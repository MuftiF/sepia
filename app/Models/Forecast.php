<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Forecast extends Model
{
    use HasFactory;

    protected $table = 'forecasts';

    protected $fillable = [
        'user_id',
        'topic',
        'prediction',
        'confidence_score'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}