document.addEventListener("DOMContentLoaded", () => {
  const companyInput = document.getElementById("q_company");
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

  function tableEntreprises(rows) {
    if (!rows || rows.length === 0) return `<div class="results-empty">Aucune entreprise</div>`;

    let html = `
      <table class="results-table">
        <thead>
          <tr>
            <th>Entreprise</th>
            <th>Secteur</th>
            <th>Pays</th>
          </tr>
        </thead>
        <tbody>
    `;

    for (const r of rows) {
      html += `
        <tr>
          <td>${escapeHtml(r.nom_entreprise)}</td>
          <td>${escapeHtml(r.secteur_activite_entreprise)}</td>
          <td>${escapeHtml(r.nom_pays)}</td>
        </tr>
      `;
    }

    html += `</tbody></table>`;
    return html;
  }

  function tablePays(rows) {
    if (!rows || rows.length === 0) return `<div class="results-empty">Aucun pays</div>`;

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
    return html;
  }

  async function fetchJSON(url) {
    const res = await fetch(url);
    if (!res.ok) throw new Error("HTTP " + res.status);
    return res.json();
  }

  async function updateResults() {
    const company = companyInput.value.trim();   // ex: "lu"
    const country = locationInput.value.trim();  // ex: "france"

    // 2 colonnes affichées tout le temps
    resultsEl.innerHTML = `
      <div class="results-grid">
        <div class="results-col">
          <div class="results-col-title">Entreprises</div>
          <div class="results-col-body"><div class="results-empty">Recherche...</div></div>
        </div>
        <div class="results-col">
          <div class="results-col-title">Pays</div>
          <div class="results-col-body"><div class="results-empty">Recherche...</div></div>
        </div>
      </div>
    `;

    const entrepriseBody = resultsEl.querySelectorAll(".results-col-body")[0];
    const paysBody = resultsEl.querySelectorAll(".results-col-body")[1];

    try {
      // Entreprises filtrées par company + country
      const entUrl = `../php/search_entreprise.php?company=${encodeURIComponent(company)}&country=${encodeURIComponent(country)}`;

      // Pays filtrés par country uniquement (si vide => on peut afficher vide)
      const paysUrl = `../php/search_pays.php?q=${encodeURIComponent(country)}`;

      const [entData, paysData] = await Promise.all([
        fetchJSON(entUrl),
        country ? fetchJSON(paysUrl) : Promise.resolve({ results: [] }),
      ]);

      entrepriseBody.innerHTML = tableEntreprises(entData.results);
      paysBody.innerHTML = country ? tablePays(paysData.results) : `<div class="results-empty">Tape un pays</div>`;
    } catch (e) {
      console.error(e);
      entrepriseBody.innerHTML = `<div class="results-empty">Erreur</div>`;
      paysBody.innerHTML = `<div class="results-empty">Erreur</div>`;
    }
  }

  function debounceUpdate() {
    clearTimeout(timer);
    timer = setTimeout(updateResults, 250);
  }

  companyInput.addEventListener("input", debounceUpdate);
  locationInput.addEventListener("input", debounceUpdate);

  updateResults();
});
