const locationInput = document.getElementById("q_location");
const resultsEl = document.getElementById("results");

let timer = null;

function escapeHtml(str) {
  return String(str ?? "")
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#039;");
}

function renderTable(rows) {
  if (!rows || rows.length === 0) {
    resultsEl.innerHTML = `<div class="results-label">Aucun résultat</div>`;
    return;
  }

  let html = `
    <table class="results-table">
      <thead>
        <tr>
          <th>Pays</th>
          <th>Capitale</th>
          <th>Monnaie</th>
        </tr>
      </thead>
      <tbody>
  `;

  for (const r of rows) {
    html += `
      <tr>
        <td>${escapeHtml(r.nom_pays)}</td>
        <td>${escapeHtml(r.capitale_pays)}</td>
        <td>${escapeHtml(r.monnaie_pays)}</td>
      </tr>
    `;
  }

  html += `</tbody></table>`;
  resultsEl.innerHTML = html;
}

async function searchPays() {
  const q = locationInput?.value.trim() ?? "";
  resultsEl.innerHTML = `<div class="results-label">Recherche...</div>`;

  try {
    const res = await fetch(`../php/search_internships.php?q=${encodeURIComponent(q)}`);
    if (!res.ok) throw new Error("HTTP " + res.status);

    const data = await res.json();
    renderTable(data.results);
  } catch (e) {
    console.error(e);
    resultsEl.innerHTML = `<div class="results-label">Erreur de recherche</div>`;
  }
}

function debounceSearch() {
  clearTimeout(timer);
  timer = setTimeout(searchPays, 250);
}

locationInput?.addEventListener("input", debounceSearch);
searchPays();
