<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// IMPORTANT : on renvoie du JSON (pas du HTML)
header('Content-Type: application/json; charset=utf-8');

// Connexion PostgreSQL (comme ton code)
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
    // Renvoie une erreur JSON
    echo json_encode(["error" => "Connexion BDD impossible", "details" => $e->getMessage()]);
    exit;
}

// Récupère la recherche ?q=...
$q = trim($_GET["q"] ?? "");

// Requête LIKE (PostgreSQL : ILIKE = insensible à la casse)
$sql = "
    SELECT nom_pays, capitale_pays, monnaie_pays
    FROM pays
    WHERE nom_pays ILIKE :q
       OR capitale_pays ILIKE :q
       OR monnaie_pays ILIKE :q
    ORDER BY nom_pays
    LIMIT 50
";

$stmt = $pdo->prepare($sql);
$stmt->execute([":q" => "%$q%"]);

$pays = $stmt->fetchAll();

// Renvoie les résultats
echo json_encode(["results" => $pays], JSON_UNESCAPED_UNICODE);
