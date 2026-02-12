const locationInput = document.getElementById("q_location");
const resultsEl = document.getElementById("results");

function escapeHtml(str) {
  return String(str ?? "")
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#039;");
}

function renderTable(rows) {
  console.log("ROWS:", rows); // 🔍 debug

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
  const q = locationInput.value.trim();
  resultsEl.innerHTML = `<div class="results-label">Recherche...</div>`;

  try {
    const res = await fetch(`../php/search_internships.php?q=${encodeURIComponent(q)}`);
    const data = await res.json();

    console.log("DATA:", data); // 🔍 debug
    renderTable(data.results);
  } catch (e) {
    console.error(e);
    resultsEl.innerHTML = `<div class="results-label">Erreur</div>`;
  }
}

locationInput.addEventListener("input", searchPays);

// affichage au chargement
searchPays();
