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
            return redirect()->route('pasien.dashboard_pasien');
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'pasien',
        ]);

        return redirect()->route('login_pasien')->with('success', 'Registration successful. Please log in.');
    }

    // public function checkpasien()
    // {
    //     // Pastikan pengguna sudah login dan memiliki role 'pasien'
    //     if (User::check() && User::user()->role === 'pasien') {
    //         // Jika iya, arahkan ke dashboard pasien
    //         return view('dashboard.patient');
    //     } else {
    //         // Jika tidak, arahkan ke halaman yang sesuai (misalnya, halaman login atau halaman error)
    //         return redirect()->route('loginpasien')->with('error', 'Anda tidak memiliki akses.');
    //     }
    // }

    // Menampilkan halaman memilih poli
    // public function pilihPoli()
    // {
    //     $poliklinik = Poli::all();
    //     $pasien = auth()->user(); // Mendapatkan data pasien yang login
    //     return view('pilih-poli', compact('pilihPoli', 'pasien'));
    // }

    // // Proses memilih poli
    // public function prosesPilihPoli(Request $request)
    // {
    //     $pasien = auth()->user();

    //     if ($pasien->status === 'baru') {
    //         // Pasien baru harus mendaftarkan diri
    //         return redirect()->route('pendaftaran_pasien_baru')->with('poli_id', $request->poliklinik_id);
    //     } else {
    //         // Pasien lama langsung ke halaman pilih dokter
    //         return redirect()->route('pilih.dokter', $request->poliklinik_id);
    //     }
    // }

    // // Menampilkan halaman memilih dokter
    // public function pilihDokter($poliId)
    // {
    //     $dokter = Dokter::where('poliklinik_id', $poliId)->get();
    //     $poliklinik = Poliklinik::findOrFail($poliId);
    //     return view('pilih_dokter', compact('dokter', 'poliklinik'));
    // }

    // // Proses memilih dokter
    // public function prosesPilihDokter(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'dokter_id' => 'required|integer',
    //         'keluhan' => 'nullable|string',
    //     ]);

    //     $pendaftaran = Pendaftaran::create([
    //         'pasien_id' => auth()->id(),
    //         'dokter_id' => $validatedData['dokter_id'],
    //         'keluhan' => $validatedData['keluhan'] ?? null,
    //     ]);

    //     return redirect()->route('nomor.antrian', $pendaftaran->id);
    // }

    // // Menampilkan nomor antrian
    // public function nomorAntrian($id)
    // {
    //     $pendaftaran = Pendaftaran::with(['dokter', 'poliklinik'])->findOrFail($id);
    //     return view('nomor_antrian', compact('pendaftaran'));
    // }
}