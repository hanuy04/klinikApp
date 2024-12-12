<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarPoli extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'daftar_poli';

    protected $fillable = [
        'id_pasien',
        'id_jadwal',
        'keluhan',
        'no_antrian',
    ];

    /**
     * Relasi ke model Pasien
     */
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }

    /**
     * Relasi ke model JadwalPeriksa
     */
    public function jadwalPeriksa()
    {
        return $this->belongsTo(JadwalPeriksa::class, 'id_jadwal');
    }
    
    public function periksa(){
        return $this->hasOne(Periksa::class,"id_daftar_poli");
    }
}
