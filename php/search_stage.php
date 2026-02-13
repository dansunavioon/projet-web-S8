<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . "/db.php"; // <-- ton PDO $pdo

$job      = trim($_GET['job'] ?? '');
$company  = trim($_GET['company'] ?? '');
$country  = trim($_GET['country'] ?? '');

$duration = trim($_GET['duration'] ?? ''); // short|standard|long|xl
$sector   = trim($_GET['sector'] ?? '');
$start    = trim($_GET['start'] ?? '');    // soon|mid|later
$size     = trim($_GET['size'] ?? '');     // small|pme|big

$sql = "
SELECT
  s.id_stage,
  s.date_debut_stage,
  s.duree_jours_stage,
  s.description_stage,
  e.id_national_entreprise,
  e.nom_entreprise,
  e.secteur_activite_entreprise,
  e.nb_employes_entreprise,
  e.nom_pays
FROM stage s
JOIN entreprise e ON e.id_national_entreprise = s.id_national_entreprise
WHERE 1=1
";
$params = [];

/* mots-clés => description */
if ($job !== '') {
  $sql .= " AND s.description_stage ILIKE :job";
  $params[':job'] = "%$job%";
}

/* entreprise */
if ($company !== '') {
  $sql .= " AND e.nom_entreprise ILIKE :company";
  $params[':company'] = "%$company%";
}

/* pays */
if ($country !== '') {
  $sql .= " AND e.nom_pays ILIKE :country";
  $params[':country'] = "%$country%";
}

/* secteur */
if ($sector !== '') {
  $sql .= " AND e.secteur_activite_entreprise ILIKE :sector";
  $params[':sector'] = "%$sector%";
}

/* taille entreprise */
if ($size === "small") $sql .= " AND e.nb_employes_entreprise < 300";
if ($size === "pme")   $sql .= " AND e.nb_employes_entreprise BETWEEN 300 AND 1000";
if ($size === "big")   $sql .= " AND e.nb_employes_entreprise > 1000";

/* durée (adaptée à tes données) */
if ($duration === "short")    $sql .= " AND s.duree_jours_stage <= 60";
if ($duration === "standard") $sql .= " AND s.duree_jours_stage BETWEEN 61 AND 90";
if ($duration === "long")     $sql .= " AND s.duree_jours_stage BETWEEN 91 AND 120";
if ($duration === "xl")       $sql .= " AND s.duree_jours_stage > 120";

/* date de début */
if ($start === "soon") {
  $sql .= " AND s.date_debut_stage <= (CURRENT_DATE + INTERVAL '30 days')";
}
if ($start === "mid") {
  $sql .= " AND s.date_debut_stage > (CURRENT_DATE + INTERVAL '30 days')
            AND s.date_debut_stage <= (CURRENT_DATE + INTERVAL '90 days')";
}
if ($start === "later") {
  $sql .= " AND s.date_debut_stage > (CURRENT_DATE + INTERVAL '90 days')";
}

$sql .= " ORDER BY s.date_debut_stage ASC LIMIT 200";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

echo json_encode(["results" => $stmt->fetchAll()], JSON_UNESCAPED_UNICODE);
