<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\Dokter;
use App\Models\Pendaftaran;
use App\Models\JadwalPeriksa;

class PatientController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');
    }

    public function showDashboardPasien()
    {
        return view(
            'pasien.dashboard_pasien',
        );
    }

    public function showLoginPasienForm()
    {
        return view('login_pasien');
    }

    // proses login pasien
    public function doLoginPasien(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        // Check if the user exists and the password matches directly
        if (
            !$user || $user->password !== $request->password
        ) {
            return back()->with('error', 'Email atau password salah.');
        }

        // Log the user in
        Auth::login($user);

        // Redirect based on the user's role
        if ($user->role === 'pasien') {
            return redirect()->route('pasien.pilih-poli');
        } else if ($user->role === 'dokter') {
            return redirect()->route('dokter.dashboard');
        } else {
            return redirect()->route('admin.dashboard');
        }

        // Redirect to login page if no valid role
        return redirect()->route('showLoginPage');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'password' => 'required|string',
            'no_ktp' => 'required|integer',
            'no_hp' => 'required|integer',
        ]);

        // Periksa apakah no_ktp sudah terdaftar
        $existingUser = Pasien::where('no_ktp', $request->no_ktp)->first();
        if ($existingUser) {
            return redirect()->back()->withErrors(['no_ktp' => 'Nomor KTP sudah terdaftar.']);
        } else {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = $request->input('password');
            $user->role = "pasien";
            $user->created_at = now();
            $user->updated_at = now();
            $user->save();


            // Simpan data pasien baru ke tabel Pasien
            $pasien = new Pasien;
            $pasien->nama = $request->input('name');
            $pasien->no_ktp = $request->input('no_ktp');
            $pasien->no_hp = $request->input('no_hp');
            $pasien->save();

            // Simpan data pasien baru ke tabel Pasien
            $pasien = new Pasien;
            $pasien->nama = $request->input('name');
            $pasien->no_ktp = $request->input('no_ktp');
            $pasien->no_hp = $request->input('no_hp');
            $pasien->save();

        }

        return redirect()->route('login_pasien')->with('success', 'Registration successful. Please log in.');
    }

    // Function to generate a unique no_rm
    function generateNoRm() {
        $currentYearMonth = now()->format('Ym'); // Example: 202411
        $patientsCount = Pasien::count();
        return 'RM-' . $currentYearMonth . '-' . str_pad($patientsCount + 1, 3, '0', STR_PAD_LEFT);
    }

    // Halaman memilih poli
    public function pilihPoli()
    {
        $polis = Poli::all(); // Ambil semua poli
        return view('pasien.pilih-poli', compact('polis'));
    }

    // Halaman memilih dokter setelah memilih poli
    public function pilihDokter(Request $request, Poli $poli)
    {
        $pasien = Pasien::find($request->pasien_id);
        $dokters = $poli->dokters()->with('jadwalPeriksas')->get();

        return view('pasien.pilih-dokter', compact('poli', 'dokters', 'pasien'));
    }

    public function pilihDokterSubmit(Request $request, Poli $poli)
    {
        $request->validate([
            'dokter_id' => 'required|exists:dokter,id',
        ]);

        // Cek pasien
        $pasien = Pasien::findOrFail($request->pasien_id);

        // Cek dokter
        $dokter = Dokter::findOrFail($request->dokter_id);

        // Cek jadwal dokter yang tersedia
        $jadwal = JadwalPeriksa::where('id_dokter', $dokter->id)->first(); // Sesuaikan logika jadwal

        if (!$jadwal) {
            return redirect()->back()->withErrors(['error' => 'Jadwal untuk dokter ini tidak tersedia.']);
        }

        // Hitung nomor antrean
        $antreanTerakhir = DaftarPoli::where('id_jadwal', $jadwal->id)->max('no_antrian');
        $nomorAntrian = $antreanTerakhir ? $antreanTerakhir + 1 : 1;

        // Daftarkan pasien ke daftar poli
        $daftarPoli = DaftarPoli::create([
            'id_pasien' => $pasien->id,
            'id_jadwal' => $jadwal->id,
            'keluhan' => $request->input('keluhan', ''),
            'no_antrian' => $nomorAntrian,
        ]);

        // Arahkan ke halaman jadwal pasien
        return redirect()->route('pasien.jadwal')->with('success', 'Anda berhasil mendaftar ke poli. Nomor antrean Anda: ' . $nomorAntrian);
    }

    public function lihatJadwal(Request $request)
    {
        // Mendapatkan pasien berdasarkan ID yang sedang login (diasumsikan pasien login)
        $pasien = auth()->user()->pasien;

        if (!$pasien) {
            return redirect()->route('pasien.pilih-poli')->with('error', 'Silakan login sebagai pasien.');
        }

        // Ambil semua daftar poli yang terkait dengan pasien
        $daftarPolis = DaftarPoli::where('pasien_id', $pasien->id)
            ->with(['jadwalPeriksa.dokter', 'jadwalPeriksa.poli'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pasien.jadwal', compact('daftarPolis'));
    }

}


