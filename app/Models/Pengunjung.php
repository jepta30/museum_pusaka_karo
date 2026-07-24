<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengunjung extends Model
{
    use HasFactory;

    protected $primaryKey = 'no_pengunjung';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'no_pengunjung',
        'nama',
        'alamat',
        'pekerjaan',
        'tanggal',
    ];
}
