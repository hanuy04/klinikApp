<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Poli;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // panggil dashboard admin dan hitung jumlah poli, dokter, pasien
    public function showDashboard()
    {
        $jumlahPoli = Poli::count();
        $jumlahDokter = Dokter::count();
        $jumlahPasien = Pasien::count();

        return view(
            'admin.dashboard',
            compact('jumlahPoli', 'jumlahDokter', 'jumlahPasien')
        );
    }

    // panggil halaman poi
    public function showPoli()
    {
        $poli = Poli::all();

        // kirim data ke view
        return view('admin.viewPoli', compact('poli'));
    }

    // panggil halaman dokter
    public function showDokter()
    {
        $dokter = Dokter::all();

        return view('admin.viewDokter', compact('dokter'));
    }

    // panggil halaman pasien
    public function showPasien()
    {
        $pasien = Pasien::all();

        return view('admin.viewPasien', compact('pasien'));
    }

    // panggil halaman edit poli tertentu
    public function editPoli($id)
    {
        $poli = Poli::findOrFail($id);
        return view('admin.editPoli', compact('poli'));
    }

    // update data poli
    public function updatePoli(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $poli = Poli::findOrFail($id);
        $poli->nama_poli = $request->input('nama');
        $poli->keterangan = $request->input('keterangan');
        $poli->save();

        return redirect()->route('admin.poli')->with('success', 'Data Poli berhasil diperbarui.');
    }

    // panggil halaman edit dokter tertentu
    public function editDokter($id)
    {
        $dokter = Dokter::findOrFail($id);
        $polis = Poli::all();

        return view('admin.editDokter', compact('dokter', 'polis'));
    }

    // update data dokter
    public function updateDokter(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:150',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|integer',
            'poli_id' => 'required|integer',
        ]);

        $dokter = Dokter::findOrFail($id);
        $dokter->nama = $request->input('nama');
        $dokter->alamat = $request->input('alamat');
        $dokter->no_hp = $request->input('no_hp');
        $dokter->id_poli = $request->input('poli_id');
        $dokter->save();

        return redirect()->route('admin.dokter')->with('success', 'Data Dokter berhasil diperbarui.');
    }

    // panggil halaman edit pasien tertentu
    public function editPasien($id)
    {
        $pasien = Pasien::findOrFail($id);

        return view('admin.editPasien', compact('pasien'));
    }

    // update data pasien
    public function updatePasien(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:150',
            'no_ktp' => 'required|string|max:255',
            'no_hp' => 'required|integer|max:10',
            'no_rm' => 'required|char|max:10',
        ]);

        $dokter = Dokter::findOrFail($id);
        $dokter->nama = $request->input('nama');
        $dokter->no_ktp = $request->input('no_ktp');
        $dokter->no_hp = $request->input('no_hp');
        $dokter->no_rm = $request->input('no_rm');
        $dokter->save();

        return redirect()->route('admin.pasien')->with('success', 'Data Pasien berhasil diperbarui.');
    }
}
