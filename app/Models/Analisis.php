<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Analisis extends Model
{
    use HasFactory;

    protected $table = 'analyses';

    protected $fillable = [
        'report_id',
        'summary',
        'sentiment',
        'keywords'
    ];

    public function report()
    {
        return $this->belongsTo(Laporan::class);
    }
}