<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $primaryKey = 'media_id';

    protected $fillable = [
        'warisan_budaya_id',
        'file_media',
        'jenis_media',
        'keterangan',
    ];

    public function warisanBudaya()
    {
        return $this->belongsTo(WarisanBudaya::class, 'warisan_budaya_id', 'warisan_budaya_id');
    }
}
