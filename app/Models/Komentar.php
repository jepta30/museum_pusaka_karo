<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;

    protected $primaryKey = 'komentar_id';

    protected $fillable = [
        'warisan_budaya_id',
        'nama',
        'email',
        'isi_komentar',
        'status',
    ];

    public function warisanBudaya()
    {
        return $this->belongsTo(WarisanBudaya::class, 'warisan_budaya_id', 'warisan_budaya_id');
    }
}
