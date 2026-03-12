@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

{{-- HERO --}}
<section class="page-hero">
  <div class="hero-inner">
    <div class="hero-label fade-up">
      <span class="label-dot"></span>
      Multi-Agent AI Platform
    </div>
    <h1 class="hero-title fade-up">
      Ubah berita menjadi<br><em>wawasan</em> yang terstruktur.
    </h1>
    <p class="hero-desc fade-up">
      Platform AI berbasis Gemini, Qwen, dan Llama untuk memproses dokumen hukum
      dan berita secara otomatis — dari strukturisasi hingga rekomendasi tindakan.
    </p>
    <div class="hero-stats fade-up">
      <div class="stat-item">
        <span class="stat-num">3</span>
        <span class="stat-label">AI Models</span>
      </div>
      <div class="stat-divider"></div>
      <div class="stat-item">
        <span class="stat-num">4</span>
        <span class="stat-label">Fitur Utama</span>
      </div>
      <div class="stat-divider"></div>
      <div class="stat-item">
        <span class="stat-num">∞</span>
        <span class="stat-label">Dokumen</span>
      </div>
    </div>
  </div>
</section>

{{-- FEATURE GRID --}}
<section class="features-section">
  <div class="section-header fade-up">
    <span class="section-label">— Pilih Fitur</span>
  </div>

  <div class="home-grid">

    {{-- LAPORAN --}}
    <a href="{{ route('laporan.index') }}" class="home-card fade-up">
      <div class="card-accent"></div>
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
        <div class="hc-tags">
          <span>Gemini</span>
          <span>Ekstraksi</span>
          <span>Strukturisasi</span>
        </div>
        <span class="hc-arrow">↗</span>
      </div>
    </a>

    {{-- PERSONALISASI --}}
    <a href="{{ route('personalisasi.index') }}" class="home-card fade-up">
      <div class="card-accent"></div>
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
        <div class="hc-tags">
          <span>Gemini</span>
          <span>Profil</span>
          <span>Riwayat</span>
        </div>
        <span class="hc-arrow">↗</span>
      </div>
    </a>

    {{-- FORECASTING --}}
    <a href="{{ route('forecasting.index') }}" class="home-card fade-up">
      <div class="card-accent"></div>
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
        <div class="hc-tags">
          <span>Gemini</span>
          <span>Prediksi</span>
          <span>Rekomendasi</span>
        </div>
        <span class="hc-arrow">↗</span>
      </div>
    </a>

    {{-- ANALISIS (disabled) --}}
    <div class="home-card disabled fade-up">
      <div class="card-accent"></div>
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
        <div class="hc-tags">
          <span>Multi-Model</span>
          <span>Visualisasi</span>
        </div>
        <span class="badge-soon">Segera Hadir</span>
      </div>
    </div>

  </div>
</section>

@endsection

@push('styles')
<style>
  /* ─── HERO ──────────────────────────────────────────── */
  .page-hero {
    padding: 5rem 0 4rem;
    border-bottom: 1px solid rgba(26, 102, 64, 0.12);
    background: linear-gradient(
      160deg,
      rgba(234, 247, 240, 0.7) 0%,
      rgba(255, 255, 255, 0.4) 60%
    );
  }

  .hero-inner {
    max-width: 860px;
    margin: 0 auto;
    padding: 0 48px;
  }

  .hero-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: 'DM Mono', monospace;
    font-size: 11px;
    font-weight: 500;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--green-600, #1a6640);
    background: rgba(234, 247, 240, 0.9);
    border: 1px solid rgba(26, 102, 64, 0.2);
    padding: 6px 14px;
    border-radius: 20px;
    margin-bottom: 2rem;
  }

  .label-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #2a9d65;
    animation: pulse-dot 2.5s ease-in-out infinite;
  }

  @keyframes pulse-dot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.35; transform: scale(0.65); }
  }

  .hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.4rem, 5vw, 3.6rem);
    font-weight: 900;
    line-height: 1.1;
    color: #0a2e1a;
    margin-bottom: 1.4rem;
    letter-spacing: -0.02em;
  }

  .hero-title em {
    font-style: italic;
    color: #1a6640;
    position: relative;
  }

  .hero-title em::after {
    content: '';
    position: absolute;
    bottom: 4px;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #2a9d65, #86d4aa);
    border-radius: 2px;
    opacity: 0.5;
  }

  .hero-desc {
    font-size: 1.05rem;
    font-weight: 300;
    line-height: 1.75;
    color: #2d6647;
    max-width: 600px;
    margin-bottom: 3rem;
  }

  /* ─── STATS ─────────────────────────────────────────── */
  .hero-stats {
    display: flex;
    align-items: center;
    gap: 32px;
  }

  .stat-item {
    display: flex;
    flex-direction: column;
    gap: 2px;
  }

  .stat-num {
    font-family: 'Playfair Display', serif;
    font-size: 1.75rem;
    font-weight: 700;
    color: #0a2e1a;
    line-height: 1;
  }

  .stat-label {
    font-family: 'DM Mono', monospace;
    font-size: 10px;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #6aaa88;
  }

  .stat-divider {
    width: 1px;
    height: 32px;
    background: rgba(26, 102, 64, 0.15);
  }

  /* ─── FEATURES SECTION ───────────────────────────────── */
  .features-section {
    padding: 3.5rem 0 5rem;
  }

  .section-header {
    max-width: 860px;
    margin: 0 auto 2rem;
    padding: 0 48px;
  }

  .section-label {
    font-family: 'DM Mono', monospace;
    font-size: 10.5px;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: #6aaa88;
  }

  /* ─── GRID ───────────────────────────────────────────── */
  .home-grid {
    max-width: 860px;
    margin: 0 auto;
    padding: 0 48px;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
  }

  /* ─── CARD ───────────────────────────────────────────── */
  .home-card {
    background: #ffffff;
    border: 1px solid rgba(26, 102, 64, 0.14);
    border-radius: 16px;
    padding: 2.4rem;
    text-decoration: none;
    cursor: pointer;
    transition:
      border-color 0.25s ease,
      box-shadow 0.25s ease,
      transform 0.25s ease;
    position: relative;
    overflow: hidden;
    min-height: 280px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  /* top green accent bar — slides in on hover */
  .card-accent {
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #1f7a4d, #4db882);
    border-radius: 16px 16px 0 0;
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .home-card:not(.disabled):hover {
    border-color: rgba(26, 102, 64, 0.28);
    box-shadow:
      0 8px 32px rgba(10, 46, 26, 0.10),
      0 2px 8px rgba(10, 46, 26, 0.06);
    transform: translateY(-3px);
  }

  .home-card:not(.disabled):hover .card-accent {
    transform: scaleX(1);
  }

  .home-card:not(.disabled):hover .hc-arrow {
    transform: translate(3px, -3px);
    color: #1a6640;
  }

  .home-card:not(.disabled):hover .hc-icon svg {
    stroke: #1f7a4d;
  }

  .home-card.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background: #f7faf8;
  }

  /* ─── CARD INTERNALS ─────────────────────────────────── */
  .hc-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
  }

  .hc-num {
    font-family: 'DM Mono', monospace;
    font-size: 10.5px;
    color: #6aaa88;
    letter-spacing: 0.15em;
  }

  .hc-icon svg {
    width: 24px;
    height: 24px;
    stroke: #2a9d65;
    fill: none;
    stroke-width: 1.5;
    stroke-linecap: round;
    stroke-linejoin: round;
    transition: stroke 0.25s ease;
  }

  .hc-body { margin-top: 1.8rem; }

  .hc-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.65rem;
    font-weight: 700;
    color: #0a2e1a;
    margin-bottom: 0.65rem;
    line-height: 1.15;
  }

  .hc-desc {
    font-size: 0.86rem;
    color: #4d8c6a;
    line-height: 1.7;
    font-weight: 300;
  }

  .hc-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 2rem;
    flex-wrap: wrap;
    gap: 8px;
  }

  .hc-tags {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
  }

  .hc-tags span {
    font-family: 'DM Mono', monospace;
    font-size: 9.5px;
    letter-spacing: 0.09em;
    text-transform: uppercase;
    border: 1px solid rgba(26, 102, 64, 0.2);
    background: rgba(234, 247, 240, 0.6);
    padding: 3px 9px;
    border-radius: 20px;
    color: #2d6647;
  }

  .hc-arrow {
    font-size: 1.1rem;
    color: #86d4aa;
    transition: transform 0.25s ease, color 0.25s ease;
    line-height: 1;
  }

  .badge-soon {
    font-family: 'DM Mono', monospace;
    font-size: 9.5px;
    font-weight: 500;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #2d6647;
    background: #c2ecd5;
    border: 1px solid #86d4aa;
    padding: 4px 10px;
    border-radius: 20px;
  }

  /* ─── FADE-UP ANIMATION ──────────────────────────────── */
  .fade-up {
    opacity: 0;
    transform: translateY(18px);
    animation: fadeUp 0.55s cubic-bezier(0.4, 0, 0.2, 1) forwards;
  }

  .fade-up:nth-child(1) { animation-delay: 0.05s; }
  .fade-up:nth-child(2) { animation-delay: 0.12s; }
  .fade-up:nth-child(3) { animation-delay: 0.19s; }
  .fade-up:nth-child(4) { animation-delay: 0.26s; }

  .home-grid .fade-up:nth-child(1) { animation-delay: 0.1s; }
  .home-grid .fade-up:nth-child(2) { animation-delay: 0.18s; }
  .home-grid .fade-up:nth-child(3) { animation-delay: 0.26s; }
  .home-grid .fade-up:nth-child(4) { animation-delay: 0.34s; }

  @keyframes fadeUp {
    to { opacity: 1; transform: translateY(0); }
  }

  /* ─── RESPONSIVE ─────────────────────────────────────── */
  @media (max-width: 768px) {
    .hero-inner,
    .section-header,
    .home-grid {
      padding: 0 24px;
    }

    .hero-title { font-size: 2.2rem; }
    .home-grid { grid-template-columns: 1fr; }
    .hero-stats { gap: 20px; }
  }

  @media (max-width: 480px) {
    .page-hero { padding: 3rem 0 2.5rem; }
    .hero-title { font-size: 1.9rem; }
    .home-card { padding: 1.8rem; min-height: auto; }
  }
</style>
@endpush