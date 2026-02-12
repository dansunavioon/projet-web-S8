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

if ($q === "") {
    echo json_encode(["results" => []]);
    exit;
}


$sql = "
SELECT 
    s.id_stage,
    s.date_publication_stage,
    s.date_debut_stage,
    s.duree_jours_stage,
    s.description_stage,
    
    e.nom_entreprise,
    e.secteur_activite_entreprise,
    e.nb_employes_entreprise,
    
    p.nom_pays,
    p.capitale_pays,
    p.monnaie_pays

FROM stage s
JOIN entreprise e 
    ON s.id_national_entreprise = e.id_national_entreprise
JOIN pays p 
    ON e.nom_pays = p.nom_pays

WHERE 
    s.description_stage ILIKE :q
    OR e.nom_entreprise ILIKE :q
    OR e.secteur_activite_entreprise ILIKE :q
    OR p.nom_pays ILIKE :q

ORDER BY s.date_publication_stage DESC
LIMIT 50
";

$stmt = $pdo->prepare($sql);
$stmt->execute([":q" => "%$q%"]);
$stages = $stmt->fetchAll();

echo json_encode(["results" => $stages], JSON_UNESCAPED_UNICODE);