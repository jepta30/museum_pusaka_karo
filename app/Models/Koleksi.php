<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koleksi extends Model
{
    use HasFactory;

    protected $primaryKey = 'nomor_koleksi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nomor_koleksi',
        'nama_koleksi',
        'jenis_koleksi',
        'nama_pemilik',
        'cara_perolehan',
        'tempat_perolehan',
        'tanggal_masuk',
        'keterangan',
    ];
}
