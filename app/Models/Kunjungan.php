<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    protected $primaryKey = 'kunjungan_id';

    protected $fillable = [
        'halaman',
        'warisan_budaya_id',
        'tanggal',
        'waktu',
        'perangkat',
        'kota',
        'ip',
    ];

    public function warisanBudaya()
    {
        return $this->belongsTo(WarisanBudaya::class, 'warisan_budaya_id', 'warisan_budaya_id');
    }
}
