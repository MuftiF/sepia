@extends('layouts.app')

@section('title', 'Personalisasi')

@section('content')

{{-- PAGE HERO --}}
<section class="page-hero">
  <p class="page-label">02 — Profil & Riwayat Entitas</p>
  <h1>Personalisasi <em>Entitas</em></h1>
  <p>Ketik nama seseorang, perusahaan, atau institusi — sistem mengompilasi semua keterlibatan, relasi, dan riwayat kasus yang tercatat.</p>
</section>

{{-- PAGE BODY --}}
<div class="page-body">
  <div class="two-col">

    {{-- KIRI: FORM INPUT --}}
    <div>
      <div class="panel">
        <div class="panel-title">Cari Entitas</div>

        <div class="input-group">
          <label class="input-label" for="persona-nama">Nama Orang atau Entitas</label>
          <input
            class="input-field"
            id="persona-nama"
            type="text"
            placeholder="Contoh: Surya Dharma, PT Maju Jaya, Polres Jakarta Utara..." />
        </div>

        <div class="input-group">
          <label class="input-label" for="persona-konteks">Konteks / Dokumen Terkait <span style="color:var(--muted)">(opsional)</span></label>
          <textarea
            class="input-field"
            id="persona-konteks"
            rows="7"
            placeholder="Tempel berita, laporan, atau dokumen yang menyebut nama tersebut untuk hasil yang lebih akurat..."></textarea>
        </div>

        <button class="btn btn-primary" id="personalisasi-btn" onclick="prosesPersonalisasi()">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          Kompilasi Profil
        </button>

        <div class="alert-danger" id="personalisasi-error"></div>
      </div>

      {{-- TIPS --}}
      <div style="margin-top:1.2rem;padding:1.2rem;border:1px dashed rgba(139,105,20,0.25)">
        <p style="font-family:'DM Mono',monospace;font-size:0.62rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--muted);margin-bottom:0.5rem">Yang akan dikompilasi</p>
        <ul style="list-style:none;font-size:0.83rem;color:var(--slate);line-height:2">
          <li>→ Profil ringkas entitas</li>
          <li>→ Keterlibatan dalam kasus</li>
          <li>→ Relasi dengan pihak lain</li>
          <li>→ Catatan penting</li>
          <li>→ Estimasi tingkat risiko</li>
        </ul>
      </div>
    </div>

    {{-- KANAN: HASIL --}}
    <div>
      <div class="spinner-wrap" id="personalisasi-spinner">
        <div class="spinner"></div>
        <p class="spinner-text">Mengompilasi profil entitas...</p>
      </div>

      <div class="result-panel" id="personalisasi-result">
        <div class="result-panel-header">
          <span>Profil Entitas</span>
          <div class="result-status">
            <div class="status-dot"></div>
            <span>Gemini 1.5 Flash</span>
          </div>
        </div>
        <div class="result-panel-body" id="personalisasi-result-body"></div>
      </div>

      <div id="personalisasi-placeholder" style="padding:4rem 2rem;text-align:center;border:1px dashed rgba(139,105,20,0.2)">
        <p style="font-family:'DM Mono',monospace;font-size:0.68rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--muted)">
          Profil akan muncul di sini
        </p>
      </div>
    </div>

  </div>
</div>

@endsection

@push('scripts')
<script>
// ============================================================
// PROMPT KHUSUS PERSONALISASI
// ============================================================
const PROMPT_PERSONALISASI = `
Kamu adalah SEPIA AI, sistem profiling entitas untuk keperluan analisis hukum dan jurnalisme Indonesia.

TUGASMU: Berdasarkan nama dan konteks yang diberikan, buat profil komprehensif entitas tersebut.

ATURAN WAJIB:
1. Kembalikan output HANYA dalam format JSON valid, tanpa teks tambahan
2. Fokus pada keterlibatan dalam kasus, peristiwa, atau kejadian penting
3. Gunakan bahasa Indonesia formal
4. Jika informasi tidak tersedia dari konteks, isi null — jangan mengarang
5. Bedakan antara fakta yang tersebut dalam konteks dan inferensi logis

FORMAT JSON:
{
  "nama": "string - nama lengkap entitas",
  "jenis_entitas": "perorangan|perusahaan|institusi|organisasi",
  "ringkasan_profil": "string - deskripsi singkat 2-3 kalimat tentang entitas",
  "peran_dalam_kasus": [
    {
      "kasus": "string - nama atau deskripsi kasus",
      "peran": "string - peran entitas dalam kasus ini",
      "waktu": "string atau null",
      "status": "string atau null - status dalam kasus"
    }
  ],
  "relasi": [
    {
      "nama": "string - nama pihak yang berelasi",
      "hubungan": "string - jenis hubungan (rekan bisnis, atasan, dll)"
    }
  ],
  "catatan_penting": "string atau null - hal penting yang perlu diperhatikan",
  "risiko_keterlibatan": "rendah|sedang|tinggi|tidak diketahui"
}`.trim();

// ============================================================
// HANDLER PROSES PERSONALISASI
// ============================================================
async function prosesPersonalisasi() {
  const nama    = document.getElementById('persona-nama').value.trim();
  const konteks = document.getElementById('persona-konteks').value.trim();

  if (!nama) {
    showError('personalisasi', 'Harap masukkan nama orang atau entitas terlebih dahulu.');
    return;
  }

  hideError('personalisasi');
  hideResult('personalisasi');
  document.getElementById('personalisasi-placeholder').style.display = 'none';
  setLoading('personalisasi', true);

  try {
    const userPrompt = `Nama entitas yang dicari: ${nama}` +
      (konteks ? `\n\nKonteks / dokumen terkait:\n${konteks}` : '');

    const raw  = await callGemini(PROMPT_PERSONALISASI, userPrompt);
    const data = parseGeminiJSON(raw);

    document.getElementById('personalisasi-result-body').innerHTML = renderHasilPersonalisasi(data);
    showResult('personalisasi');

  } catch (e) {
    showError('personalisasi', e.message);
    document.getElementById('personalisasi-placeholder').style.display = 'block';
  } finally {
    setLoading('personalisasi', false);
  }
}

// ============================================================
// RENDER HASIL PERSONALISASI
// ============================================================
function renderHasilPersonalisasi(data) {
  let html = '';

  // Header profil
  html += renderSection('Identitas',
    `<strong style="font-size:1.05rem">${data.nama}</strong><br>
     <span style="font-family:'DM Mono',monospace;font-size:0.62rem;letter-spacing:0.12em;text-transform:uppercase;color:var(--muted)">${data.jenis_entitas || ''}</span><br><br>
     ${data.ringkasan_profil || ''}`
  );

  // Keterlibatan kasus
  if (data.peran_dalam_kasus?.length) {
    const kasusHtml = data.peran_dalam_kasus.map(k => `
      <div style="margin-bottom:0.9rem;padding:0.9rem;background:var(--paper);border:1px solid var(--sepia-pale)">
        <strong style="font-size:0.9rem">${k.kasus}</strong><br>
        <span style="font-size:0.8rem;color:var(--muted)">
          Peran: ${k.peran}
          ${k.waktu   ? ' &nbsp;·&nbsp; ' + k.waktu   : ''}
          ${k.status  ? ' &nbsp;·&nbsp; Status: ' + k.status : ''}
        </span>
      </div>`).join('');
    html += renderSection('Keterlibatan Kasus', kasusHtml);
  }

  // Relasi
  if (data.relasi?.length) {
    html += renderSection('Relasi',
      data.relasi.map(r => `
        <div class="actor-chip">
          <span>${r.nama}</span>
          <span class="role">${r.hubungan}</span>
        </div>`).join('')
    );
  }

  // Catatan
  if (data.catatan_penting) {
    html += renderSection('Catatan Penting', data.catatan_penting);
  }

  // Risiko
  const risikoMap = {
    rendah: '#16a34a', sedang: '#d97706',
    tinggi: '#dc2626', 'tidak diketahui': '#6b7280'
  };
  const risikoWarna = risikoMap[data.risiko_keterlibatan] || '#6b7280';
  html += renderSection('Estimasi Risiko',
    `<span style="color:${risikoWarna};font-weight:700;text-transform:uppercase;
      letter-spacing:0.12em;font-family:'DM Mono',monospace;font-size:0.8rem">
      ● ${data.risiko_keterlibatan || 'Tidak diketahui'}
    </span>`
  );

  return html;
}
</script>
@endpush
