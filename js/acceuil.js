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
    const company = companyInput.value.trim();
    const countryFilter = locationInput.value.trim();

    // 2 colonnes TOUJOURS
    resultsEl.innerHTML = `
      <div class="results-grid">
        <div class="results-col">
          <div class="results-col-title">Entreprises</div>
          <div id="entBody" class="results-col-body"><div class="results-empty">Recherche...</div></div>
        </div>
        <div class="results-col">
          <div class="results-col-title">Pays</div>
          <div id="payBody" class="results-col-body"><div class="results-empty">Recherche...</div></div>
        </div>
      </div>
    `;

    const entBody = document.getElementById("entBody");
    const payBody = document.getElementById("payBody");

    try {
      // 1) Entreprises (filtrées par entreprise + pays saisi)
      const entUrl = `../php/search_entreprise.php?company=${encodeURIComponent(company)}&country=${encodeURIComponent(countryFilter)}`;
      const entData = await fetchJSON(entUrl);
      entBody.innerHTML = tableEntreprises(entData.results);

      // 2) Pays = UNIQUEMENT ceux présents dans les entreprises trouvées
      const uniq = Array.from(
        new Set((entData.results || []).map(r => (r.nom_pays || "").trim()).filter(Boolean))
      );

      if (uniq.length > 0) {
        const names = uniq.join(",");
        const paysDetailsUrl = `../php/get_pays_details.php?names=${encodeURIComponent(names)}`;
        const paysData = await fetchJSON(paysDetailsUrl);
        payBody.innerHTML = tablePays(paysData.results);
      } else {
        // Aucune entreprise trouvée :
        // -> si l'utilisateur a tapé un pays, on affiche les pays correspondants (fallback)
        if (countryFilter) {
          const paysData = await fetchJSON(`../php/search_pays.php?q=${encodeURIComponent(countryFilter)}`);
          payBody.innerHTML = tablePays(paysData.results);
        } else {
          // sinon rien
          payBody.innerHTML = `<div class="results-empty">Aucun pays</div>`;
        }
      }
    } catch (e) {
      console.error(e);
      entBody.innerHTML = `<div class="results-empty">Erreur</div>`;
      payBody.innerHTML = `<div class="results-empty">Erreur</div>`;
    }
  }

  function debounce() {
    clearTimeout(timer);
    timer = setTimeout(updateResults, 250);
  }

  companyInput.addEventListener("input", debounce);
  locationInput.addEventListener("input", debounce);

  updateResults();
});
