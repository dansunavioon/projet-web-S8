<?php
// --------------------------------------------------
// Affichage des erreurs PHP (DEV uniquement)
// --------------------------------------------------
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// --------------------------------------------------
// Connexion à la base de données
// --------------------------------------------------
$host = "localhost";
$dbname = "buildux";
$user = "postgres";
$password = "isen44N";

try {
    $pdo = new PDO(
        "pgsql:host=$host;dbname=$dbname",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("<p style='color:red'>❌ Erreur de connexion BDD : " . $e->getMessage() . "</p>");
}

// --------------------------------------------------
// Requête
// --------------------------------------------------
$stmt = $pdo->query("SELECT * FROM pays");
$pays = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Contact us</title>

  <link rel="stylesheet" href="../css/header.css">
  <link rel="stylesheet" href="../css/acceuil.css">
</head>
<body>

<?php
// Sécurisation de l'include
if (file_exists("../php/header.php")) {
    include "../php/header.php";
} else {
    echo "<p style='color:red'>❌ header.php introuvable</p>";
}
?>

<main>
  <h1>Voici les informations de contact</h1>

  <!-- TABLEAU -->
  <table border="1" cellpadding="5">
    <tr>
      <th>Pays</th>
      <th>Capitale</th>
      <th>Monnaie</th>
    </tr>

    <?php foreach ($pays as $p): ?>
      <tr>
        <td><?= htmlspecialchars($p['nom_pays']) ?></td>
        <td><?= htmlspecialchars($p['capitale_pays']) ?></td>
        <td><?= htmlspecialchars($p['monnaie_pays']) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

</main>

<script src="../js/header.js"></script>
<script src="../js/accueil.js"></script>

</body>
</html>
