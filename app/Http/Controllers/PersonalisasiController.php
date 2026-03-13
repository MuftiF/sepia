<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\LaporanPdf;
use Illuminate\Support\Facades\Auth;

class PersonalisasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $reports = Laporan::where('user_id', $user->id)->latest()->get();

        $pdfs = LaporanPdf::whereHas('report', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('downloaded', false)->get();

        return view('personalisasi', compact('user','reports','pdfs'));
    }
}