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

  function renderEntreprises(rows, q) {
    if (!q) return `<div class="results-hint">Tape dans “Entreprise” pour rechercher des entreprises.</div>`;
    if (!rows || rows.length === 0) return `<div class="results-hint">Aucune entreprise trouvée.</div>`;

    let html = `
      <h3 class="results-title">Entreprises</h3>
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

  function renderPays(rows, q) {
    if (!q) return `<div class="results-hint">Tape dans “Localisation” pour rechercher des pays.</div>`;
    if (!rows || rows.length === 0) return `<div class="results-hint">Aucun pays trouvé.</div>`;

    let html = `
      <h3 class="results-title">Pays</h3>
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
    const qEntreprise = companyInput.value.trim();
    const qPays = locationInput.value.trim();

    // petit loader seulement si au moins un champ est rempli
    if (qEntreprise || qPays) {
      resultsEl.innerHTML = `<div class="results-label">Recherche...</div>`;
    } else {
      resultsEl.innerHTML = `
        ${renderEntreprises([], "")}
        <div style="height:14px"></div>
        ${renderPays([], "")}
      `;
      return;
    }

    try {
      // On appelle les deux endpoints, mais seulement si le champ correspondant est rempli
      const [entrepriseData, paysData] = await Promise.all([
        qEntreprise
          ? fetchJSON(`../php/search_entreprise.php?q=${encodeURIComponent(qEntreprise)}`)
          : Promise.resolve({ results: [] }),

        qPays
          ? fetchJSON(`../php/search_pays.php?q=${encodeURIComponent(qPays)}`)
          : Promise.resolve({ results: [] }),
      ]);

      resultsEl.innerHTML = `
        ${renderEntreprises(entrepriseData.results, qEntreprise)}
        <div style="height:14px"></div>
        ${renderPays(paysData.results, qPays)}
      `;
    } catch (e) {
      console.error(e);
      resultsEl.innerHTML = `<div class="results-label">Erreur</div>`;
    }
  }

  function debounceUpdate() {
    clearTimeout(timer);
    timer = setTimeout(updateResults, 250);
  }

  companyInput.addEventListener("input", debounceUpdate);
  locationInput.addEventListener("input", debounceUpdate);

  // affichage au chargement
  updateResults();
});
