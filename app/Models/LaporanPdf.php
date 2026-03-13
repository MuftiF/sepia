<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanPdf extends Model
{
    use HasFactory;

    protected $table = 'pdf_reports';

    protected $fillable = [
        'report_id',
        'file_path',
        'downloaded'
    ];

    public function report()
    {
        return $this->belongsTo(Laporan::class);
    }
}