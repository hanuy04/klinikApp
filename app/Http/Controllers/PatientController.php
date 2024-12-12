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

            // User::create([
            //     'name' => $request->name,
            //     'email' => $request->email,
            //     'password' => $request->password,
            //     'role' => 'pasien',
            // ]);
            // }

            // // Hitung jumlah pasien yang terdaftar bulan ini
            // $currentYearMonth = now()->format('Ym'); // Contoh: 202411
            // $patientsCount = Pasien::count();

            // // Generate nomor rekam medis dengan format 'RM-TahunBulan-Urutan'
            // $no_rm = $currentYearMonth . '-' . str_pad($patientsCount + 1, 3, '0', STR_PAD_LEFT);

            // Simpan data pasien baru ke tabel Pasien
            $pasien = new Pasien;
            $pasien->nama = $request->input('name');
            $pasien->no_ktp = $request->input('no_ktp');
            $pasien->no_hp = $request->input('no_hp');
            $pasien->save();

            // Pasien::create([
            //     'nama' => $request->name,
            //     'no_ktp' => $request->no_ktp,
            //     'no_hp' => $request->no_hp,
            //     'no_rm' => $no_rm,
            // ]);
        }

        return redirect()->route('login_pasien')->with('success', 'Registration successful. Please log in.');
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
        $dokters = $poli->dokters;

        $jadwals = [];
        if ($request->has('dokter_id')) {
            $jadwals = JadwalPeriksa::where('id_dokter', $request->dokter_id)->get();
        }

        return view('pasien.pilih-dokter', compact('poli', 'dokters', 'jadwals', 'pasien'));
    }

    // Proses pendaftaran nomor antrian
    public function daftarAntrian(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'dokter_id' => 'required|exists:dokter,id',
            'jadwal_id' => 'required|exists:jadwal_periksa,id',
        ]);

        $noAntrian = DaftarPoli::where('id_jadwal', $request->jadwal_id)->max('no_antrian') + 1;

        DaftarPoli::create([
            'id_pasien' => $request->pasien_id,
            'id_jadwal' => $request->jadwal_id,
            'keluhan' => $request->keluhan,
            'no_antrian' => $noAntrian,
        ]);

        return redirect()->route('pasien.pilih-poli')->with('success', "Pendaftaran berhasil! Nomor antrian Anda adalah $noAntrian.");
    }
}
