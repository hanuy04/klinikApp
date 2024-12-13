<?php

namespace App\Http\Controllers;

use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\JadwalPeriksa;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Periksa;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function showDashboard(Request $request){
        $listpasien = DaftarPoli::with('pasien','periksa')->get();
        $datadokter = array();
        foreach($listpasien as $item){
            $datae = JadwalPeriksa::where('id','=',$item->id_jadwal)->first();
            array_push($datadokter,$datae->id_dokter);
        }
        return view('dokter.dokterlistperiksa',compact('listpasien','datadokter'));
    }
    public function detailPemeriksaan(Request $request){
        $dataperiksa = Periksa::where("id","=",$request->id)->first();
        $datapoli = DaftarPoli::where("id","=",$dataperiksa->id_daftar_poli)->with('pasien')->get();
        $dataobat = Obat::all();
        $valoption = "";
        foreach($dataobat as $data){
            $valoption .='<option value="'.$data->id.'">'.$data->nama_obat.'</option>';
        }
        return view('dokter.detailpemeriksaan',["datapoli"=>$datapoli,"dataobat"=>$valoption]);
    }
    public function simpantanggal(Request $request){
        $databaru = new Periksa();
        $databaru->tgl_periksa = $request->tgl_periksa;
        $databaru->id_daftar_poli = $request->id_daftar_poli;
        $databaru->catatan = "";
        $databaru->save();
        return redirect()->route('dokter.dashboard');
    }
    public function simpanpemeriksaan(Request $request){
        $dataperiksa = Periksa::where("id","=",$request->idperiksa)->first();
        $dataperiksa->catatan = $request->catatan;
        $dataperiksa->biaya_periksa = $request->nominal;
        $dataperiksa->save();
        foreach($request->namaobat as $data){
            $dataobat = new DetailPeriksa();
            $dataobat->id_periksa = $request->idperiksa;
            $dataobat->id_obat = $data;
            $dataobat->save();
        }
        // echo $dataperiksa;
        return redirect()->route('dokter.dashboard');
    }
    public function historypasien(){
        $listpasien = DaftarPoli::with('pasien','periksa')->get();
        $datadokter = array();
        foreach($listpasien as $item){
            $datae = JadwalPeriksa::where('id','=',$item->id_jadwal)->first();
            array_push($datadokter,$datae->id_dokter);
        }
        return view('dokter.dokterhistory',compact('listpasien','datadokter'));
    }
    public function detailpasien(Request $request){
        $datasend = array();
        $datapasien = Pasien::where("id","=",$request->id)->first();
        $datapolis = DaftarPoli::where("id_pasien","=",$datapasien->id)->get();
        $datasend["namapasien"] = $datapasien->nama;
        $datasend["no_hp"] = $datapasien->no_hp;
        $datapushtmp = array();
        foreach($datapolis as $data){
            $datapush = array();
            $dataperiksa = Periksa::where("id_daftar_poli","=",$data->id)->first();
            $datapush["catatan"] = $dataperiksa->catatan;
            $datapush["tanggal"] = $dataperiksa->tgl_periksa;
            $datapush["biaya"] = $dataperiksa->biaya_periksa;
            $datadetail = DetailPeriksa::where("id_periksa","=",$dataperiksa->id)->get();
            $lobat = array();
            foreach($datadetail as $dataa){
                $obate = Obat::where("id","=",$dataa->id_obat)->first();
                array_push($lobat,$obate->nama_obat);
            }
            $datapush["obat"] = $lobat;
            array_push($datapushtmp,$datapush);
        }
        $datasend["riwayat"] = $datapushtmp;
        return view('dokter.detailpasien',["data"=>$datasend]);
    }
}
