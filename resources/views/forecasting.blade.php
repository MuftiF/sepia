@extends('layouts.app')

@section('title', 'Forecasting')

@section('content')

{{-- PAGE HERO --}}
<section class="page-hero">
  <p class="page-label">03 — Rekomendasi Tindakan Stakeholder</p>
  <h1>Forecasting <em>Kasus</em></h1>
  <p>Masukkan ringkasan atau laporan terstruktur — AI menganalisis dan memberikan rekomendasi tindakan konkret untuk setiap pihak yang terlibat.</p>
</section>

{{-- PAGE BODY --}}
<div class="page-body">
  <div class="two-col">

    {{-- KIRI: FORM INPUT --}}
    <div>
      <div class="panel">
        <div class="panel-title">Input Kasus</div>

        <div class="input-group">
          <label class="input-label" for="forecast-input">Ringkasan Kasus atau Hasil Laporan</label>
          <textarea
            class="input-field"
            id="forecast-input"
            rows="12"
            placeholder="Tempel ringkasan kasus atau hasil dari fitur Laporan yang telah diproses sebelumnya...

Contoh:
Kasus korupsi dana desa di Kabupaten X. Tersangka: Kepala Desa Y. Kerugian negara Rp 2 miliar. Status: ditangkap KPK pada Maret 2025..."></textarea>
        </div>

        <button class="btn btn-primary" id="forecasting-btn" onclick="prosesForecasting()">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
          Generate Rekomendasi AI
        </button>

        <div class="alert-danger" id="forecasting-error"></div>
      </div>

      {{-- INFO --}}
      <div style="margin-top:1.2rem;padding:1.2rem;border:1px dashed rgba(139,105,20,0.25)">
        <p style="font-family:'DM Mono',monospace;font-size:0.62rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--muted);margin-bottom:0.5rem">Rekomendasi untuk</p>
        <ul style="list-style:none;font-size:0.83rem;color:var(--slate);line-height:2">
          <li>🚔 Kepolisian</li>
          <li>⚖️ Kejaksaan</li>
          <li>🏛️ Kehakiman</li>
          <li>🏢 Perusahaan / Institusi Terkait</li>
          <li>📈 Proyeksi Perkembangan Kasus</li>
          <li>⚠ Risiko Jika Tidak Ditindak</li>
        </ul>
      </div>
    </div>

    {{-- KANAN: HASIL --}}
    <div>
      <div class="spinner-wrap" id="forecasting-spinner">
        <div class="spinner"></div>
        <p class="spinner-text">AI sedang menganalisis & memproyeksikan...</p>
      </div>

      <div class="result-panel" id="forecasting-result">
        <div class="result-panel-header">
          <span>Rekomendasi Stakeholder</span>
          <div class="result-status">
            <div class="status-dot"></div>
            <span>Gemini 1.5 Flash</span>
          </div>
        </div>
        <div class="result-panel-body" id="forecasting-result-body"></div>
      </div>

      <div id="forecasting-placeholder" style="padding:4rem 2rem;text-align:center;border:1px dashed rgba(139,105,20,0.2)">
        <p style="font-family:'DM Mono',monospace;font-size:0.68rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--muted)">
          Rekomendasi akan muncul di sini
        </p>
      </div>
    </div>

  </div>
</div>

@endsection

@push('scripts')
<script>
// ============================================================
// PROMPT KHUSUS FORECASTING
// ============================================================
const PROMPT_FORECASTING = `
Kamu adalah SEPIA AI, sistem prediksi dan rekomendasi tindakan untuk penegakan hukum dan kebijakan di Indonesia.

TUGASMU: Berdasarkan ringkasan kasus yang diberikan, buat rekomendasi tindakan konkret untuk setiap stakeholder yang relevan sesuai hukum Indonesia.

ATURAN WAJIB:
1. Kembalikan output HANYA dalam format JSON valid, tanpa teks tambahan
2. Rekomendasi harus spesifik, actionable, dan sesuai hukum Indonesia
3. Gunakan bahasa Indonesia formal
4. Sertakan urgensi yang realistis
5. Jika suatu stakeholder tidak relevan dengan kasus, isi tindakan dengan array kosong []

FORMAT JSON:
{
  "ringkasan_kasus": "string - ringkasan singkat kasus dalam 1-2 kalimat",
  "tingkat_urgensi": "rendah|sedang|tinggi|kritis",
  "rekomendasi": {
    "polisi": {
      "tindakan": ["string - tindakan konkret 1", "string - tindakan konkret 2"],
      "prioritas": "rendah|sedang|tinggi",
      "catatan": "string atau null"
    },
    "jaksa": {
      "tindakan": ["string"],
      "prioritas": "rendah|sedang|tinggi",
      "catatan": "string atau null"
    },
    "hakim": {
      "tindakan": ["string"],
      "prioritas": "rendah|sedang|tinggi",
      "catatan": "string atau null"
    },
    "pihak_terkait": [
      {
        "pihak": "string - nama institusi atau perusahaan",
        "tindakan": ["string"],
        "prioritas": "rendah|sedang|tinggi"
      }
    ]
  },
  "proyeksi_kasus": "string - prediksi perkembangan kasus jika semua rekomendasi dijalankan",
  "risiko_jika_tidak_ditindak": "string - konsekuensi hukum dan sosial jika tidak ada tindakan"
}`.trim();

// ============================================================
// HANDLER PROSES FORECASTING
// ============================================================
async function prosesForecasting() {
  const input = document.getElementById('forecast-input').value.trim();

  if (!input) {
    showError('forecasting', 'Harap masukkan ringkasan kasus atau laporan terlebih dahulu.');
    return;
  }

  hideError('forecasting');
  hideResult('forecasting');
  document.getElementById('forecasting-placeholder').style.display = 'none';
  setLoading('forecasting', true);

  try {
    const raw  = await callGemini(PROMPT_FORECASTING, 'Kasus yang perlu dianalisis:\n\n' + input);
    const data = parseGeminiJSON(raw);

    document.getElementById('forecasting-result-body').innerHTML = renderHasilForecasting(data);
    showResult('forecasting');

  } catch (e) {
    showError('forecasting', e.message);
    document.getElementById('forecasting-placeholder').style.display = 'block';
  } finally {
    setLoading('forecasting', false);
  }
}

// ============================================================
// RENDER HASIL FORECASTING
// ============================================================
function renderHasilForecasting(data) {
  let html = '';

  // Ringkasan + urgensi
  html += renderSection('Ringkasan & Tingkat Urgensi',
    `${data.ringkasan_kasus || ''}<br><br>${renderUrgency(data.tingkat_urgensi)}`
  );

  const rek = data.rekomendasi;

  // Polisi
  if (rek?.polisi?.tindakan?.length) {
    html += renderSection('🚔 Rekomendasi — Kepolisian',
      renderRecCard('', '', rek.polisi.tindakan, rek.polisi.catatan)
    );
  }

  // Jaksa
  if (rek?.jaksa?.tindakan?.length) {
    html += renderSection('⚖️ Rekomendasi — Kejaksaan',
      renderRecCard('', '', rek.jaksa.tindakan, rek.jaksa.catatan)
    );
  }

  // Hakim
  if (rek?.hakim?.tindakan?.length) {
    html += renderSection('🏛️ Rekomendasi — Kehakiman',
      renderRecCard('', '', rek.hakim.tindakan, rek.hakim.catatan)
    );
  }

  // Pihak terkait
  if (rek?.pihak_terkait?.length) {
    const pihakHtml = rek.pihak_terkait
      .filter(p => p.tindakan?.length)
      .map(p => renderRecCard('🏢', p.pihak, p.tindakan))
      .join('');
    if (pihakHtml) {
      html += renderSection('🏢 Rekomendasi — Pihak Terkait Lainnya', pihakHtml);
    }
  }

  // Proyeksi
  if (data.proyeksi_kasus) {
    html += renderSection('📈 Proyeksi Perkembangan Kasus', data.proyeksi_kasus);
  }

  // Risiko
  if (data.risiko_jika_tidak_ditindak) {
    html += renderSection(
      '⚠ Risiko Jika Tidak Ditindak',
      `<span style="color:var(--rust)">${data.risiko_jika_tidak_ditindak}</span>`,
      'var(--rust)'
    );
  }

  return html;
}
</script>
@endpush
