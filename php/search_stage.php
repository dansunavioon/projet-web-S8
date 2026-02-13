<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

require_once "database.php"; // ← ton PDO

$job      = trim($_GET['job'] ?? '');
$company  = trim($_GET['company'] ?? '');
$country  = trim($_GET['country'] ?? '');

$duration = $_GET['duration'] ?? '';
$sector   = $_GET['sector'] ?? '';
$start    = $_GET['start'] ?? '';
$size     = $_GET['size'] ?? '';


$sql = "
SELECT 
  s.date_debut_stage,
  s.duree_jours_stage,
  s.description_stage,
  e.nom_entreprise,
  e.secteur_activite_entreprise,
  e.nb_employes_entreprise,
  e.nom_pays
FROM stage s
JOIN entreprise e ON s.id_national_entreprise = e.id_national_entreprise
WHERE 1=1
";

$params = [];


if ($job !== '') {
  $sql .= " AND s.description_stage ILIKE :job";
  $params[':job'] = "%$job%";
}

if ($company !== '') {
  $sql .= " AND e.nom_entreprise ILIKE :company";
  $params[':company'] = "%$company%";
}

if ($country !== '') {
  $sql .= " AND e.nom_pays ILIKE :country";
  $params[':country'] = "%$country%";
}


if ($duration === "short") {
  $sql .= " AND s.duree_jours_stage < 60";
}
if ($duration === "standard") {
  $sql .= " AND s.duree_jours_stage BETWEEN 60 AND 120";
}
if ($duration === "long") {
  $sql .= " AND s.duree_jours_stage > 120";
}

if ($sector !== '') {
  $sql .= " AND e.secteur_activite_entreprise = :sector";
  $params[':sector'] = $sector;
}

if ($start === "soon") {
  $sql .= " AND s.date_debut_stage <= CURRENT_DATE + INTERVAL '30 days'";
}
if ($start === "mid") {
  $sql .= " AND s.date_debut_stage BETWEEN CURRENT_DATE + INTERVAL '30 days'
                               AND CURRENT_DATE + INTERVAL '90 days'";
}
if ($start === "later") {
  $sql .= " AND s.date_debut_stage > CURRENT_DATE + INTERVAL '90 days'";
}

if ($size === "small") {
  $sql .= " AND e.nb_employes_entreprise < 50";
}
if ($size === "pme") {
  $sql .= " AND e.nb_employes_entreprise BETWEEN 50 AND 250";
}
if ($size === "big") {
  $sql .= " AND e.nb_employes_entreprise > 250";
}

$sql .= " ORDER BY s.date_debut_stage ASC LIMIT 50";


$stmt = $pdo->prepare($sql);
$stmt->execute($params);

echo json_encode([
  "results" => $stmt->fetchAll()
], JSON_UNESCAPED_UNICODE);
