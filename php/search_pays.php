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

$q = trim($_GET["q"] ?? "");

// Si vide -> renvoyer rien (ou renvoyer 50 pays si tu préfères)
if ($q === "") {
    echo json_encode(["results" => []], JSON_UNESCAPED_UNICODE);
    exit;
}

/*
  1) Recherche stricte : nom_pays commence par q
     ex: q="f" -> France, Finlande...
*/
$sqlStarts = "
    SELECT nom_pays, capitale_pays, monnaie_pays
    FROM pays
    WHERE nom_pays ILIKE :starts
    ORDER BY nom_pays
    LIMIT 50
";

$stmt = $pdo->prepare($sqlStarts);
$stmt->execute([":starts" => $q . "%"]);
$pays = $stmt->fetchAll();

// 2) Si aucun résultat, fallback sur recherche large (ton ancienne logique)
if (count($pays) === 0) {
    $sqlWide = "
        SELECT nom_pays, capitale_pays, monnaie_pays
        FROM pays
        WHERE nom_pays ILIKE :q
           OR capitale_pays ILIKE :q
           OR monnaie_pays ILIKE :q
        ORDER BY nom_pays
        LIMIT 50
    ";

    $stmt = $pdo->prepare($sqlWide);
    $stmt->execute([":q" => "%$q%"]);
    $pays = $stmt->fetchAll();
}

echo json_encode(["results" => $pays], JSON_UNESCAPED_UNICODE);
