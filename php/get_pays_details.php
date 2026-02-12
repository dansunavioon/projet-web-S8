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

$namesRaw = trim($_GET["names"] ?? "");
if ($namesRaw === "") {
  echo json_encode(["results" => []], JSON_UNESCAPED_UNICODE);
  exit;
}

$names = array_values(array_unique(array_filter(array_map('trim', explode(',', $namesRaw)))));
$names = array_slice($names, 0, 50);

$placeholders = [];
$params = [];
foreach ($names as $i => $n) {
  $ph = ":p$i";
  $placeholders[] = $ph;
  $params[$ph] = $n;
}

$sql = "
  SELECT nom_pays, capitale_pays, monnaie_pays
  FROM pays
  WHERE nom_pays IN (" . implode(',', $placeholders) . ")
  ORDER BY nom_pays
";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

echo json_encode(["results" => $stmt->fetchAll()], JSON_UNESCAPED_UNICODE);
