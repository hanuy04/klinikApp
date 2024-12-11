<?php

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Poliklinik;
use App\Models\Dokter;
use App\Models\Pendaftaran;

class PendaftaranController extends Controller
{
    // Menampilkan halaman memilih poli
    public function pilihPoli()
    {
        $poliklinik = Poliklinik::all();
        $pasien = auth()->user(); // Mendapatkan data pasien yang login
        return view('pilih_poli', compact('poliklinik', 'pasien'));
    }

    // Proses memilih poli
    public function prosesPilihPoli(Request $request)
    {
        $pasien = auth()->user();

        if ($pasien->status === 'baru') {
            // Pasien baru harus mendaftarkan diri
            return redirect()->route('pendaftaran_pasien_baru')->with('poli_id', $request->poliklinik_id);
        } else {
            // Pasien lama langsung ke halaman pilih dokter
            return redirect()->route('pilih.dokter', $request->poliklinik_id);
        }
    }

    // Menampilkan halaman memilih dokter
    public function pilihDokter($poliId)
    {
        $dokter = Dokter::where('poliklinik_id', $poliId)->get();
        $poliklinik = Poliklinik::findOrFail($poliId);
        return view('pilih_dokter', compact('dokter', 'poliklinik'));
    }

    // Proses memilih dokter
    public function prosesPilihDokter(Request $request)
    {
        $validatedData = $request->validate([
            'dokter_id' => 'required|integer',
            'keluhan' => 'nullable|string',
        ]);

        $pendaftaran = Pendaftaran::create([
            'pasien_id' => auth()->id(),
            'dokter_id' => $validatedData['dokter_id'],
            'keluhan' => $validatedData['keluhan'] ?? null,
        ]);

        return redirect()->route('nomor.antrian', $pendaftaran->id);
    }

    // Menampilkan nomor antrian
    public function nomorAntrian($id)
    {
        $pendaftaran = Pendaftaran::with(['dokter', 'poliklinik'])->findOrFail($id);
        return view('nomor_antrian', compact('pendaftaran'));
    }
}

