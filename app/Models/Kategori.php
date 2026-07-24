<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $primaryKey = 'kategori_id';

    protected $fillable = [
        'nama',
        'deskripsi',
        'icon',
    ];

    public function warisanBudayas()
    {
        return $this->hasMany(WarisanBudaya::class, 'kategori_id', 'kategori_id');
    }
}
