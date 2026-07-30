<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarisanBudaya extends Model
{
    use HasFactory;

    protected $primaryKey = 'warisan_budaya_id';

    protected $fillable = [
        'kategori_id',
        'judul',
        'lokasi',
        'asal',
        'kondisi',
        'latitude',
        'longitude',
        'deskripsi',
        'sejarah',
        'gambar',
        'status',
        'jumlah_dilihat',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'kategori_id');
    }

    public function medias()
    {
        return $this->hasMany(Media::class, 'warisan_budaya_id', 'warisan_budaya_id');
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class, 'warisan_budaya_id', 'warisan_budaya_id');
    }

    public function kunjungans()
    {
        return $this->hasMany(Kunjungan::class, 'warisan_budaya_id', 'warisan_budaya_id');
    }
}
