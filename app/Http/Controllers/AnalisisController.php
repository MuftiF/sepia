<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;

class AnalisisController extends Controller
{
    public function index()
    {
        $reports = Laporan::with('analysis')
                    ->where('user_id', Auth::id())
                    ->get();

        return view('analisis', compact('reports'));
    }

    public function show($id)
    {
        $report = Laporan::with('analysis')->findOrFail($id);

        return view('detail_analisis', compact('report'));
    }
}