<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index()
    {
        $reports = Laporan::where('user_id', Auth::id())
                        ->latest()
                        ->get();

        return view('laporan', compact('reports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'source_url' => 'required'
        ]);

        Laporan::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'source_url' => $request->source_url,
            'content' => $request->input('content')
        ]);

        return redirect()->route('laporan.index')->with('success','Laporan berhasil ditambahkan');
    }
}