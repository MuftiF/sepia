<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'reports';

    protected $fillable = [
        'user_id',
        'judul',
        'ringkasan',
        'tanggal',
        'lokasi',
        'kategori_kasus',
        'kronologi',
        'aktor',
        'kerugian',
        'pasal',
        'status_kasus',
        'raw_input',
        'pdf_path'
    ];

    protected $casts = [
        'kronologi' => 'array',
        'aktor' => 'array',
        'tanggal' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}



