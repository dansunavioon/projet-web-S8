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
