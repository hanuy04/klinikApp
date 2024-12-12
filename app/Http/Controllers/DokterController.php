<?php

namespace App\Http\Controllers;

use App\Models\DaftarPoli;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function showDashboard(Request $request){
        $listpasien = DaftarPoli::with('pasien','periksa','jadwalPeriksa')->get();
        // echo $listpasien;
        return view('dokter.dokterlistperiksa',compact('listpasien'));
    }
}
