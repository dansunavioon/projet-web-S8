document.addEventListener("DOMContentLoaded", () => {
  const jobInput = document.getElementById("q_job");
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

  async function fetchJSON(url) {
    const res = await fetch(url);
    if (!res.ok) throw new Error("HTTP " + res.status);
    return res.json();
  }

  function tableEntreprises(rows) {
    if (!rows || rows.length === 0) return `<div class="results-empty">Aucune entreprise</div>`;
    let html = `
      <table class="results-table">
        <thead><tr><th>Entreprise</th><th>Secteur</th><th>Pays</th></tr></thead><tbody>
    `;
    for (const r of rows) {
      html += `<tr>
        <td>${escapeHtml(r.nom_entreprise)}</td>
        <td>${escapeHtml(r.secteur_activite_entreprise)}</td>
        <td>${escapeHtml(r.nom_pays)}</td>
      </tr>`;
    }
    html += `</tbody></table>`;
    return html;
  }

  function tablePays(rows) {
    if (!rows || rows.length === 0) return `<div class="results-empty">Aucun pays</div>`;
    let html = `
      <table class="results-table">
        <thead><tr><th>Pays</th><th>Capitale</th><th>Monnaie</th></tr></thead><tbody>
    `;
    for (const r of rows) {
      html += `<tr>
        <td>${escapeHtml(r.nom_pays)}</td>
        <td>${escapeHtml(r.capitale_pays)}</td>
        <td>${escapeHtml(r.monnaie_pays)}</td>
      </tr>`;
    }
    html += `</tbody></table>`;
    return html;
  }

  function tableStages(rows) {
    if (!rows || rows.length === 0) return `<div class="results-empty">Aucun stage</div>`;
    let html = `
      <table class="results-table">
        <thead>
          <tr>
            <th>Entreprise</th>
            <th>Pays</th>
            <th>Début</th>
            <th>Durée</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
    `;
    for (const r of rows) {
      html += `<tr>
        <td>${escapeHtml(r.nom_entreprise)}</td>
        <td>${escapeHtml(r.nom_pays)}</td>
        <td>${escapeHtml(r.date_debut_stage)}</td>
        <td>${escapeHtml(r.duree_jours_stage)} j</td>
        <td>${escapeHtml(r.description_stage)}</td>
      </tr>`;
    }
    html += `</tbody></table>`;
    return html;
  }

  async function updateResults() {
    const job = jobInput.value.trim();
    const company = companyInput.value.trim();
    const country = locationInput.value.trim();

    resultsEl.innerHTML = `
  <div class="results-grid-3">

    <div class="results-col">
      <div class="results-col-title">Stages</div>
      <div id="staBody" class="results-col-body">
        <div class="results-empty">Recherche...</div>
      </div>
    </div>

    <div class="results-col">
      <div class="results-col-title">Entreprises</div>
      <div id="entBody" class="results-col-body">
        <div class="results-empty">Recherche...</div>
      </div>
    </div>

    <div class="results-col">
      <div class="results-col-title">Pays</div>
      <div id="payBody" class="results-col-body">
        <div class="results-empty">Recherche...</div>
      </div>
    </div>

  </div>
`;

    const staBody = document.getElementById("staBody");
    const entBody = document.getElementById("entBody");
    const payBody = document.getElementById("payBody");

    try {
      // 1) Entreprises filtrées par company + country (comme avant)
    const entUrl = `../php/search_entreprise.php?job=${encodeURIComponent(job)}&company=${encodeURIComponent(company)}&country=${encodeURIComponent(country)}`;
      // 2) Stages filtrés par job + company + country
      const staUrl = `../php/search_stage.php?job=${encodeURIComponent(job)}&company=${encodeURIComponent(company)}&country=${encodeURIComponent(country)}`;

      const [entData, staData] = await Promise.all([
        fetchJSON(entUrl),
        fetchJSON(staUrl),
      ]);

      entBody.innerHTML = tableEntreprises(entData.results);
      staBody.innerHTML = tableStages(staData.results);

      // 3) Pays = pays uniques issus des entreprises trouvées (ou des stages si entreprises vides)
      const countriesFromEnt = (entData.results || []).map(r => (r.nom_pays || "").trim()).filter(Boolean);
      const countriesFromSta = (staData.results || []).map(r => (r.nom_pays || "").trim()).filter(Boolean);

      const uniq = Array.from(new Set([...countriesFromEnt, ...countriesFromSta]));

      if (uniq.length > 0) {
        const names = uniq.join(",");
        const paysData = await fetchJSON(`../php/get_pays_details.php?names=${encodeURIComponent(names)}`);
        payBody.innerHTML = tablePays(paysData.results);
      } else if (country) {
        // fallback si aucun résultat mais l'user tape un pays
        const paysData = await fetchJSON(`../php/search_pays.php?q=${encodeURIComponent(country)}`);
        payBody.innerHTML = tablePays(paysData.results);
      } else {
        payBody.innerHTML = `<div class="results-empty">Aucun pays</div>`;
      }
    } catch (e) {
      console.error(e);
      entBody.innerHTML = `<div class="results-empty">Erreur</div>`;
      payBody.innerHTML = `<div class="results-empty">Erreur</div>`;
      staBody.innerHTML = `<div class="results-empty">Erreur</div>`;
    }
  }

  function debounce() {
    clearTimeout(timer);
    timer = setTimeout(updateResults, 250);
  }

  jobInput.addEventListener("input", debounce);
  companyInput.addEventListener("input", debounce);
  locationInput.addEventListener("input", debounce);

  updateResults();
});
