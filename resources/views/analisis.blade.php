@extends('layouts.app')

@section('title', 'Analisis')

@section('content')

<section class="page-hero">
  <p class="page-label">04 — Visualisasi & Pola</p>
  <h1>Analisis <em>Mendalam</em></h1>
  <p>Visualisasi pola kasus, jaringan aktor, dan tren lintas laporan dalam satu dashboard interaktif.</p>
</section>

<div class="page-body">
  <div style="text-align:center;padding:6rem 2rem;border:1px dashed rgba(139,105,20,0.25)">
    <div style="font-size:3rem;margin-bottom:1.5rem">📊</div>
    <p style="font-family:'DM Mono',monospace;font-size:0.68rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--muted);margin-bottom:1rem">
      Fitur Dalam Pengembangan
    </p>
    <h2 style="font-family:'Playfair Display',serif;font-size:2rem;color:var(--ink);margin-bottom:1rem">Segera Hadir</h2>
    <p style="font-size:0.9rem;color:var(--muted);max-width:400px;margin:0 auto;line-height:1.7">
      Fitur Analisis sedang dalam pengembangan dan akan segera tersedia di versi berikutnya.
    </p>
    <div style="margin-top:2.5rem">
      <a href="{{ route('home') }}" class="btn btn-outline" style="display:inline-flex">← Kembali ke Beranda</a>
    </div>
  </div>
</div>

@endsection
