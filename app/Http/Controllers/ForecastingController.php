<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forecast;
use Illuminate\Support\Facades\Auth;

class ForecastingController extends Controller
{
    public function index()
    {
        $forecasts = Forecast::where('user_id', Auth::id())
                    ->latest()
                    ->get();

        return view('forecasting', compact('forecasts'));
    }
}