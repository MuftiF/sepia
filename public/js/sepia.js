/**
 * SEPIA — Global JavaScript
 * File: public/js/sepia.js
 *
 * Berisi:
 * - Konfigurasi Groq API (via Laravel proxy)
 * - Fungsi callGroq() — menggantikan callGemini()
 * - Helper render hasil
 * - Utilitas UI
 */

// ============================================================
// KONFIGURASI GROQ (via Laravel backend proxy)
// API key disimpan aman di server, JS hanya panggil route Laravel
// ============================================================
const SEPIA = {
  groqProxyUrl: window.GROQ_PROXY_URL || '/api/groq/chat',
  csrfToken:    window.CSRF_TOKEN     || document.querySelector('meta[name="csrf-token"]')?.content || '',
};

// ============================================================
// CORE: PANGGIL GROQ API (melalui Laravel proxy)
// Drop-in replacement untuk callGemini()
// ============================================================
async function callGroq(systemPrompt, userPrompt, options = {}) {
  const response = await fetch(SEPIA.groqProxyUrl, {
    method: 'POST',
    headers: {
      'Content-Type':  'application/json',
      'X-CSRF-TOKEN':  SEPIA.csrfToken,
      'Accept':        'application/json',
    },
    body: JSON.stringify({
      system_prompt: systemPrompt,
      user_prompt:   userPrompt,
      temperature:   options.temperature  ?? 0.3,
      max_tokens:    options.max_tokens   ?? 2048,
    })
  });

  const data = await response.json();

  if (!response.ok || data.error) {
    throw new Error(data.error || 'Gagal menghubungi Groq API');
  }

  return data.text || '';
}

// ============================================================
// ALIAS: callGemini → callGroq
// Agar halaman lain yang masih pakai callGemini() tidak perlu diubah dulu
// ============================================================
const callGemini = callGroq;

// ============================================================
// HELPER: PARSE JSON DARI RESPONSE GROQ
// (sama seperti sebelumnya, Groq juga bisa balikkan markdown json)
// ============================================================
function parseGeminiJSON(text) {
  // Bersihkan markdown code block jika ada
  const cleaned = text.replace(/```json\s*/gi, '').replace(/```\s*/g, '').trim();
  try {
    return JSON.parse(cleaned);
  } catch (e) {
    // Coba cari JSON object di dalam teks
    const match = cleaned.match(/\{[\s\S]*\}/);
    if (match) return JSON.parse(match[0]);
    throw new Error('Response AI tidak valid sebagai JSON. Coba lagi.');
  }
}

// Alias untuk konsistensi
const parseGroqJSON = parseGeminiJSON;

// ============================================================
// HELPER: UI UTILITIES
// ============================================================
function setLoading(id, state) {
  const spinner = document.getElementById(id + '-spinner');
  const btn     = document.getElementById(id + '-btn');
  if (spinner) spinner.classList.toggle('visible', state);
  if (btn)     btn.disabled = state;
}

function showError(id, msg) {
  const el = document.getElementById(id + '-error');
  if (!el) return;
  el.textContent = '⚠ ' + msg;
  el.classList.add('visible');
}

function hideError(id) {
  const el = document.getElementById(id + '-error');
  if (el) el.classList.remove('visible');
}

function showResult(id) {
  const el = document.getElementById(id + '-result');
  if (el) el.classList.add('visible');
}

function hideResult(id) {
  const el = document.getElementById(id + '-result');
  if (el) el.classList.remove('visible');
}

// ============================================================
// HELPER: RENDER KOMPONEN UI
// ============================================================

/** Render satu section hasil */
function renderSection(title, bodyHtml, titleColor = '') {
  return `
    <div class="rs">
      <div class="rs-title" style="${titleColor ? 'color:' + titleColor : ''}">${title}</div>
      <div class="rs-body">${bodyHtml}</div>
    </div>`;
}

/** Render timeline items */
function renderTimeline(items) {
  if (!items?.length) return '<em style="color:var(--muted)">Tidak tersedia</em>';
  return items.map(k => `
    <div class="timeline-item">
      <div class="timeline-dot"></div>
      <div class="timeline-time">${k.waktu || '—'}</div>
      <div class="timeline-event">${k.kejadian}</div>
    </div>`).join('');
}

/** Render actor chips */
function renderActorChips(actors) {
  if (!actors?.length) return '';
  return actors.map(a => `
    <div class="actor-chip">
      <span>${a.nama}</span>
      <span class="role">${a.peran}</span>
    </div>`).join('');
}

/** Render actor detail list */
function renderActorList(actors) {
  if (!actors?.length) return '';
  return actors.map(a => `
    <div style="margin-bottom:0.55rem">
      <strong>${a.nama}</strong>
      <span class="role" style="margin-left:0.4rem">${a.peran}</span><br>
      <span style="font-size:0.83rem;color:var(--muted)">${a.deskripsi}</span>
    </div>`).join('');
}

/** Render rekomendasi card */
function renderRecCard(icon, title, actions, catatan = null) {
  if (!actions?.length) return '';
  return `
    <div class="rec-card">
      <div class="rec-card-title">${icon} ${title}</div>
      ${actions.map(a => `<div class="rec-item">${a}</div>`).join('')}
      ${catatan ? `<div style="margin-top:0.6rem;font-size:0.8rem;font-style:italic;color:var(--muted)">📝 ${catatan}</div>` : ''}
    </div>`;
}

/** Render urgency badge */
function renderUrgency(level) {
  const map = { rendah: 'rendah', sedang: 'sedang', tinggi: 'tinggi', kritis: 'kritis' };
  const cls = map[level] || 'sedang';
  return `<span class="urgency urgency-${cls}">● ${level?.toUpperCase()}</span>`;
}