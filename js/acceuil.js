const advState = {
  duration: null, // short | standard | long | xl
  sector: null,   // ex: "Informatique"
  start: null,    // soon | mid | later
  size: null      // small | pme | big
};

function applyChipUI() {
  document.querySelectorAll(".chip[data-key]").forEach(btn => {
    const k = btn.dataset.key;
    const v = btn.dataset.val;
    btn.classList.toggle("is-active", advState[k] === v);
  });
}

function bindAdvancedFilters(updateResults) {
  document.querySelectorAll(".chip[data-key]").forEach(btn => {
    btn.addEventListener("click", (e) => {
      e.preventDefault(); // ✅ évite tout submit/reload
      const k = btn.dataset.key;
      const v = btn.dataset.val;

      advState[k] = advState[k] === v ? null : v; // toggle
      applyChipUI();
      updateResults();
    });
  });

  const reset = document.getElementById("advReset");
  if (reset) {
    reset.addEventListener("click", (e) => {
      e.preventDefault();
      advState.duration = null;
      advState.sector = null;
      advState.start = null;
      advState.size = null;
      applyChipUI();
      updateResults();
    });
  }
}


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

  function cardsStages(rows) {
    if (!rows || rows.length === 0) return `<div class="results-empty">Aucun stage</div>`;
    return rows.map(r => `
      <div class="card">
        <div class="card-title">${escapeHtml(r.nom_entreprise)}</div>
        <div class="card-text"><strong>Pays :</strong> ${escapeHtml(r.nom_pays)}</div>
        <div class="card-text"><strong>Début :</strong> ${escapeHtml(r.date_debut_stage)}</div>
        <div class="card-text"><strong>Durée :</strong> ${escapeHtml(r.duree_jours_stage)} jours</div>
        <div class="card-text">${escapeHtml(r.description_stage)}</div>
      </div>
    `).join("");
  }

  function cardsEntreprises(rows) {
    if (!rows || rows.length === 0) return `<div class="results-empty">Aucune entreprise</div>`;
    return rows.map(r => `
      <div class="card">
        <div class="card-title">${escapeHtml(r.nom_entreprise)}</div>
        <div class="card-text"><strong>Secteur :</strong> ${escapeHtml(r.secteur_activite_entreprise)}</div>
        <div class="card-text"><strong>Pays :</strong> ${escapeHtml(r.nom_pays)}</div>
      </div>
    `).join("");
  }

  function cardsPays(rows) {
    if (!rows || rows.length === 0) return `<div class="results-empty">Aucun pays</div>`;
    return rows.map(r => `
      <div class="card">
        <div class="card-title">${escapeHtml(r.nom_pays)}</div>
        <div class="card-text"><strong>Capitale :</strong> ${escapeHtml(r.capitale_pays)}</div>
        <div class="card-text"><strong>Monnaie :</strong> ${escapeHtml(r.monnaie_pays)}</div>
      </div>
    `).join("");
  }

  async function updateResults() {
    const job = jobInput.value.trim();
    const company = companyInput.value.trim();
    const country = locationInput.value.trim();

    const params = new URLSearchParams({
      job,
      company,
      country,
      duration: advState.duration ?? "",
      sector: advState.sector ?? "",
      start: advState.start ?? "",
      size: advState.size ?? ""
    });

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
      const [staData, entData] = await Promise.all([
        fetchJSON(`../php/search_stage.php?${params.toString()}`),
        fetchJSON(`../php/search_entreprise.php?${params.toString()}`)
      ]);

      staBody.innerHTML = cardsStages(staData.results);
      entBody.innerHTML = cardsEntreprises(entData.results);

      const countries = new Set();
      (staData.results || []).forEach(r => (r.nom_pays ? countries.add(r.nom_pays.trim()) : null));
      (entData.results || []).forEach(r => (r.nom_pays ? countries.add(r.nom_pays.trim()) : null));

      if (countries.size > 0) {
        const names = Array.from(countries).join(",");
        const payData = await fetchJSON(`../php/get_pays_details.php?names=${encodeURIComponent(names)}`);
        payBody.innerHTML = cardsPays(payData.results);
      } else if (country) {
        const payData = await fetchJSON(`../php/search_pays.php?q=${encodeURIComponent(country)}`);
        payBody.innerHTML = cardsPays(payData.results);
      } else {
        payBody.innerHTML = `<div class="results-empty">Aucun pays</div>`;
      }

    } catch (e) {
      console.error(e);
      staBody.innerHTML = `<div class="results-empty">Erreur</div>`;
      entBody.innerHTML = `<div class="results-empty">Erreur</div>`;
      payBody.innerHTML = `<div class="results-empty">Erreur</div>`;
    }
  }

  function debounce() {
    clearTimeout(timer);
    timer = setTimeout(updateResults, 250);
  }

  jobInput.addEventListener("input", debounce);
  companyInput.addEventListener("input", debounce);
  locationInput.addEventListener("input", debounce);

  bindAdvancedFilters(updateResults);
  applyChipUI();
  updateResults();
});
