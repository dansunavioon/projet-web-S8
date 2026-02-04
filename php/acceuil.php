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
          <div class="search-pill">Métier / Mots clés</div>
          <div class="search-pill">Entreprise</div>
          <div class="search-pill">Localisation</div>
        </div>

        <div class="results-box">
          <div class="results-label">results</div>
        </div>
      </section>
    </div>
  </main>

  <script src="../js/header.js"></script>
  <script src="../js/accueil.js"></script>

</body>
</html>
