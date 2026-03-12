@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

{{-- HERO --}}
<section class="page-hero" style="border-bottom:none; padding-bottom:2rem">
  <p class="page-label fade-up">Multi-Agent AI Platform</p>
  <h1 class="fade-up">Ubah berita menjadi <em>wawasan</em> yang terstruktur.</h1>
  <p class="fade-up" style="margin-top:1rem">
    Platform AI berbasis Gemini, Qwen, dan Llama untuk memproses dokumen hukum
    dan berita secara otomatis — dari strukturisasi hingga rekomendasi tindakan.
  </p>
</section>

{{-- FEATURE GRID --}}
<section class="page-body" style="padding-top:2.5rem">
  <p style="font-family:'DM Mono',monospace;font-size:0.65rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--muted);margin-bottom:2rem">
    — Pilih Fitur
  </p>

  <div class="home-grid">

    {{-- LAPORAN --}}
    <a href="{{ route('laporan.index') }}" class="home-card fade-up">
      <div class="hc-top">
        <span class="hc-num">01</span>
        <div class="hc-icon">
          <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        </div>
      </div>
      <div class="hc-body">
        <h2 class="hc-title">Laporan</h2>
        <p class="hc-desc">Input link berita atau dokumen, AI mengekstrak kronologi, aktor, dan fakta penting secara otomatis.</p>
      </div>
      <div class="hc-bottom">
        <div class="hc-tags"><span>Gemini</span><span>Ekstraksi</span><span>Strukturisasi</span></div>
        <span class="hc-arrow">↗</span>
      </div>
    </a>

    {{-- PERSONALISASI --}}
    <a href="{{ route('personalisasi.index') }}" class="home-card fade-up">
      <div class="hc-top">
        <span class="hc-num">02</span>
        <div class="hc-icon">
          <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </div>
      </div>
      <div class="hc-body">
        <h2 class="hc-title">Personalisasi</h2>
        <p class="hc-desc">Masukkan nama seseorang atau entitas — sistem kompilasi semua keterlibatan dari seluruh laporan.</p>
      </div>
      <div class="hc-bottom">
        <div class="hc-tags"><span>Gemini</span><span>Profil</span><span>Riwayat</span></div>
        <span class="hc-arrow">↗</span>
      </div>
    </a>

    {{-- FORECASTING --}}
    <a href="{{ route('forecasting.index') }}" class="home-card fade-up">
      <div class="hc-top">
        <span class="hc-num">03</span>
        <div class="hc-icon">
          <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        </div>
      </div>
      <div class="hc-body">
        <h2 class="hc-title">Forecasting</h2>
        <p class="hc-desc">Dari laporan terstruktur, AI memberikan rekomendasi tindakan untuk polisi, jaksa, hakim, dan pihak terkait.</p>
      </div>
      <div class="hc-bottom">
        <div class="hc-tags"><span>Gemini</span><span>Prediksi</span><span>Rekomendasi</span></div>
        <span class="hc-arrow">↗</span>
      </div>
    </a>

    {{-- ANALISIS (disabled) --}}
    <div class="home-card disabled fade-up">
      <div class="hc-top">
        <span class="hc-num">04</span>
        <div class="hc-icon">
          <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
        </div>
      </div>
      <div class="hc-body">
        <h2 class="hc-title">Analisis</h2>
        <p class="hc-desc">Visualisasi mendalam: pola kasus, jaringan aktor, dan tren lintas laporan.</p>
      </div>
      <div class="hc-bottom">
        <div class="hc-tags"><span>Multi-Model</span><span>Visualisasi</span></div>
        <span class="badge-soon">Segera Hadir</span>
      </div>
    </div>

  </div>
</section>

@endsection

@push('styles')
<style>
  .home-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5px;
    background: rgba(139,105,20,0.15);
    border: 1px solid rgba(139,105,20,0.15);
  }

  .home-card {
    background: var(--paper);
    padding: 2.8rem;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.3s ease;
    position: relative;
    overflow: hidden;
    min-height: 300px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .home-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--ink);
    transform: translateY(100%);
    transition: transform 0.5s cubic-bezier(0.77,0,0.175,1);
    z-index: 0;
  }

  .home-card:not(.disabled):hover::before { transform: translateY(0); }

  .home-card:not(.disabled):hover .hc-num,
  .home-card:not(.disabled):hover .hc-title,
  .home-card:not(.disabled):hover .hc-desc,
  .home-card:not(.disabled):hover .hc-tags span,
  .home-card:not(.disabled):hover .hc-arrow { color: var(--paper); }

  .home-card:not(.disabled):hover .hc-tags span { border-color: rgba(245,240,232,0.25); }
  .home-card:not(.disabled):hover .hc-icon svg { stroke: var(--sepia-light); }
  .home-card:not(.disabled):hover .hc-arrow { transform: translate(4px,-4px); }

  .home-card > * { position: relative; z-index: 1; }
  .home-card.disabled { opacity: 0.45; cursor: not-allowed; }

  .hc-top { display: flex; justify-content: space-between; align-items: flex-start; }

  .hc-num {
    font-family: 'DM Mono', monospace;
    font-size: 0.65rem;
    color: var(--muted);
    letter-spacing: 0.15em;
    transition: color 0.3s;
  }

  .hc-icon svg {
    width: 26px; height: 26px;
    stroke: var(--sepia); fill: none;
    stroke-width: 1.5;
    stroke-linecap: round;
    stroke-linejoin: round;
    transition: stroke 0.3s;
  }

  .hc-body { margin-top: 2rem; }

  .hc-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.85rem;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 0.7rem;
    line-height: 1.15;
    transition: color 0.3s;
  }

  .hc-desc {
    font-size: 0.87rem;
    color: var(--muted);
    line-height: 1.65;
    font-weight: 300;
    transition: color 0.3s;
  }

  .hc-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 2rem;
  }

  .hc-tags { display: flex; gap: 0.4rem; flex-wrap: wrap; }
  .hc-tags span {
    font-family: 'DM Mono', monospace;
    font-size: 0.58rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    border: 1px solid rgba(139,105,20,0.22);
    padding: 0.2rem 0.55rem;
    color: var(--muted);
    transition: all 0.3s;
  }

  .hc-arrow { font-size: 1.1rem; color: var(--sepia); transition: all 0.3s; }

  @media (max-width: 700px) {
    .home-grid { grid-template-columns: 1fr; }
  }
</style>
@endpush
