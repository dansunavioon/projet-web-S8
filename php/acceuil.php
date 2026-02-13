<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Accueil</title>

  <link rel="stylesheet" href="../css/acceuil.css">
  <link rel="stylesheet" href="../css/header.css">
</head>
<body>

  <?php include "../php/header.php"; ?>
  <?php include "../php/log_in.php"; ?>

  <main class="home">
    <div class="home-layout">

      <aside class="panel panel-left">
        <div class="panel-title">Recherche avancée</div>

        <div class="adv">

          <div class="adv-group">
            <div class="adv-title">Durée</div>
            <div class="adv-chips"> <!-- Chips for duration -->
              <button type="button" class="chip" data-key="duration" data-val="short">Court (&lt; 2 mois)</button> <!-- Buton for short duration -->
              <button type="button" class="chip" data-key="duration" data-val="standard">Standard (2–3 mois)</button>
              <button type="button" class="chip" data-key="duration" data-val="long">Long (3–6 mois)</button>
              <button type="button" class="chip" data-key="duration" data-val="xl">Très long (6+ mois)</button>
              
            </div>
          </div>

          <div class="adv-group">
            <div class="adv-title">Secteur</div>
            <div class="adv-chips">
              <button type="button" class="chip" data-key="sector" data-val="Informatique">Informatique</button>
              <button type="button" class="chip" data-key="sector" data-val="Logiciel">Logiciel</button>
              <button type="button" class="chip" data-key="sector" data-val="Électronique">Électronique</button>
              <button type="button" class="chip" data-key="sector" data-val="Finance">Finance</button>
              <button type="button" class="chip" data-key="sector" data-val="Agroalimentaire">Agroalimentaire</button>
              <button type="button" class="chip" data-key="sector" data-val="Énergie">Énergie</button>
              <button type="button" class="chip" data-key="sector" data-val="Transport">Transport</button>
              <button type="button" class="chip" data-key="sector" data-val="Services">Services</button>
            </div>
          </div>

          <div class="adv-group">
            <div class="adv-title">Début</div>
            <div class="adv-chips">
              <button type="button" class="chip" data-key="start" data-val="soon">≤ 30 jours</button>
              <button type="button" class="chip" data-key="start" data-val="mid">1–3 mois</button>
              <button type="button" class="chip" data-key="start" data-val="later">3+ mois</button>
            </div>
          </div>

          <div class="adv-group">
            <div class="adv-title">Taille entreprise</div>
            <div class="adv-chips">
              <button type="button" class="chip" data-key="size" data-val="small">&lt; 300</button>
              <button type="button" class="chip" data-key="size" data-val="pme">300–1000</button>
              <button type="button" class="chip" data-key="size" data-val="big">1000+</button>
            </div>
          </div>

          <div class="adv-actions">
            <button type="button" class="chip chip-reset" id="advReset">Réinitialiser</button>
          </div>

        </div>
      </aside>

      <section class="panel panel-right">
        <h1 class="search-title">Search for an internship</h1>

        <div class="search-bar">
          <input id="q_job" class="search-input" type="text" placeholder="Métier / Mots clés">
          <input id="q_company" class="search-input" type="text" placeholder="Entreprise">
          <input id="q_location" class="search-input" type="text" placeholder="Localisation (pays/ville)">
        </div>

        <div class="results-box">
          <div id="results" class="results-content">
            <div class="results-label">results</div>
          </div>
        </div>
      </section>

    </div>
  </main>

  <script src="../js/header.js"></script>
  <script src="../js/acceuil.js"></script>

</body>
</html>
