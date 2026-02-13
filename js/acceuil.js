const advState = {
  duration: null, // short|standard|long|xl
  sector: null,   // ex: Informatique
  start: null,    // soon|mid|later
  size: null      // small|pme|big
};

function applyChipUI() {
  document.querySelectorAll(".chip[data-key]").forEach(btn => {
    const k = btn.dataset.key;
    const v = btn.dataset.val;
    btn.classList.toggle("is-active", advState[k] === v);
  });
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
    const txt = await res.text();
    if (!res.ok) throw new Error("HTTP " + res.status + " " + txt.slice(0, 200));
    return JSON.parse(txt);
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

  function cardsEntreprisesFromStages(stageRows) {
    const uniq = new Map(); // id_entreprise -> data
    (stageRows || []).forEach(r => {
      if (!uniq.has(r.id_national_entreprise)) {
        uniq.set(r.id_national_entreprise, {
          nom_entreprise: r.nom_entreprise,
          secteur_activite_entreprise: r.secteur_activite_entreprise,
          nom_pays: r.nom_pays
        });
      }
    });

    const rows = Array.from(uniq.values());
    if (rows.length === 0) return `<div class="results-empty">Aucune entreprise</div>`;

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
          <div id="staBody" class="results-col-body"><div class="results-empty">Recherche...</div></div>
        </div>

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

    const staBody = document.getElementById("staBody");
    const entBody = document.getElementById("entBody");
    const payBody = document.getElementById("payBody");

    try {
      const staData = await fetchJSON(`../php/search_stage.php?${params.toString()}`);
      const stageRows = staData.results || [];

      staBody.innerHTML = cardsStages(stageRows);
      entBody.innerHTML = cardsEntreprisesFromStages(stageRows);

      const countries = Array.from(new Set(
        stageRows.map(r => (r.nom_pays || "").trim()).filter(Boolean)
      ));

      if (countries.length > 0) {
        const payData = await fetchJSON(
          `../php/get_pays_details.php?names=${encodeURIComponent(countries.join(","))}`
        );
        payBody.innerHTML = cardsPays(payData.results);
      } else {
        payBody.innerHTML = `<div class="results-empty">Aucun pays</div>`;
      }

    } catch (e) {
      console.error(e);
      staBody.innerHTML = entBody.innerHTML = payBody.innerHTML = `<div class="results-empty">Erreur</div>`;
    }
  }

  document.addEventListener("click", (e) => {
    const btn = e.target.closest(".chip[data-key]");
    if (!btn) return;

    e.preventDefault();
    const k = btn.dataset.key;
    const v = btn.dataset.val;

    advState[k] = (advState[k] === v) ? null : v;
    applyChipUI();
    updateResults();
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

  function debounce() {
    clearTimeout(timer);
    timer = setTimeout(updateResults, 250);
  }

  jobInput.addEventListener("input", debounce);
  companyInput.addEventListener("input", debounce);
  locationInput.addEventListener("input", debounce);

  applyChipUI();
  updateResults();
});
