document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("q_location");
  const resultsEl = document.getElementById("results");

  function renderTable(rows) {
    if (!rows || rows.length === 0) {
      resultsEl.innerHTML = `<div class="results-label">Aucun résultat</div>`;
      return;
    }

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
          <td>${r.nom_entreprise}</td>
          <td>${r.secteur_activite_entreprise}</td>
          <td>${r.nom_pays}</td>
        </tr>
      `;
    }

    html += `</tbody></table>`;
    resultsEl.innerHTML = html;
  }

  async function searchEntreprise() {
    const q = input.value.trim();
    resultsEl.innerHTML = `<div class="results-label">Recherche...</div>`;

    try {
      const res = await fetch(
        `../php/search_entreprise.php?q=${encodeURIComponent(q)}`
      );
      const data = await res.json();
      renderTable(data.results);
    } catch (e) {
      console.error(e);
      resultsEl.innerHTML = `<div class="results-label">Erreur</div>`;
    }
  }

  input.addEventListener("input", searchEntreprise);
  searchEntreprise(); // affichage au chargement
});
