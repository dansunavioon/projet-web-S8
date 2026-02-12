<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

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
  echo json_encode(["error" => "Connexion BDD impossible", "details" => $e->getMessage()]);
  exit;
}

// ⚠️ on sépare les filtres
$company = trim($_GET["company"] ?? "");
$country = trim($_GET["country"] ?? "");

$sql = "
  SELECT nom_entreprise, secteur_activite_entreprise, nom_pays
  FROM entreprise
  WHERE 1=1
";
$params = [];

// filtre entreprise (nom ou secteur)
if ($company !== "") {
  $sql .= " AND (
    nom_entreprise ILIKE :company
    OR secteur_activite_entreprise ILIKE :company
  )";
  $params[":company"] = "%$company%";
}

// filtre pays
if ($country !== "") {
  $sql .= " AND nom_pays ILIKE :country";
  $params[":country"] = "%$country%";
}

$sql .= " ORDER BY nom_entreprise LIMIT 50";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

echo json_encode(["results" => $stmt->fetchAll()], JSON_UNESCAPED_UNICODE);
