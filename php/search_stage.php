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

$job     = trim($_GET["job"] ?? "");       // métier / mots-clés
$company = trim($_GET["company"] ?? "");   // entreprise / secteur
$country = trim($_GET["country"] ?? "");   // pays

$sql = "
  SELECT
    s.id_stage,
    s.date_publication_stage,
    s.date_debut_stage,
    s.duree_jours_stage,
    s.description_stage,
    e.nom_entreprise,
    e.secteur_activite_entreprise,
    e.nom_pays
  FROM stage s
  JOIN entreprise e ON e.id_national_entreprise = s.id_national_entreprise
  WHERE 1=1
";

$params = [];

if ($job !== "") {
  $sql .= " AND s.description_stage ILIKE :job";
  $params[":job"] = "%$job%";
}

if ($company !== "") {
  $sql .= " AND (e.nom_entreprise ILIKE :company OR e.secteur_activite_entreprise ILIKE :company)";
  $params[":company"] = "%$company%";
}

if ($country !== "") {
  $sql .= " AND e.nom_pays ILIKE :country";
  $params[":country"] = "%$country%";
}

$sql .= " ORDER BY s.date_publication_stage DESC, s.id_stage DESC LIMIT 50";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

echo json_encode(["results" => $stmt->fetchAll()], JSON_UNESCAPED_UNICODE);
