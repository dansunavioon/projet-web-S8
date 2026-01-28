<?php
// ----------------------------
// Connexion à la base de données
// ----------------------------
$host = "localhost";
$dbname = "buildux";
$user = "postgres";
$password = "isen44N";

$pdo = new PDO(
    "pgsql:host=$host;dbname=$dbname",
    $user,
    $password,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);

// ----------------------------
// Requête
// ----------------------------
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

<?php include "../php/header.php"; ?>

<main>
  <h1>Voici les informations de contact</h1>

  <!-- TABLEAU -->
  <table border="1">
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
