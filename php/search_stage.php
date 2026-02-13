<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

require __DIR__ . "/db.php"; // ou database.php si chez toi c'est database.php

$job     = trim($_GET["job"] ?? "");
$company = trim($_GET["company"] ?? "");
$country = trim($_GET["country"] ?? "");

$duration = trim($_GET["duration"] ?? ""); // short|standard|long|xl
$sector   = trim($_GET["sector"] ?? "");   // ex "Informatique"
$start    = trim($_GET["start"] ?? "");    // soon|mid|later
$size     = trim($_GET["size"] ?? "");     // small|pme|big

$sql = "
  SELECT
    e.nom_entreprise,
    e.nom_pays,
    s.date_debut_stage,
    s.duree_jours_stage,
    s.description_stage
  FROM stage s
  JOIN entreprise e ON e.id_national_entreprise = s.id_national_entreprise
  WHERE 1=1
";
$params = [];

/* job => description */
if ($job !== "") {
  $sql .= " AND s.description_stage ILIKE :job";
  $params[":job"] = "%$job%";
}

/* entreprise => nom entreprise OU secteur */
if ($company !== "") {
  $sql .= " AND (e.nom_entreprise ILIKE :company OR e.secteur_activite_entreprise ILIKE :company)";
  $params[":company"] = "%$company%";
}

/* pays */
if ($country !== "") {
  $sql .= " AND e.nom_pays ILIKE :country";
  $params[":country"] = "%$country%";
}

/* durée */
if ($duration !== "") {
  if ($duration === "short")     $sql .= " AND s.duree_jours_stage < 60";
  if ($duration === "standard")  $sql .= " AND s.duree_jours_stage BETWEEN 60 AND 89";
  if ($duration === "long")      $sql .= " AND s.duree_jours_stage BETWEEN 90 AND 179";
  if ($duration === "xl")        $sql .= " AND s.duree_jours_stage >= 180";
}

/* secteur */
if ($sector !== "") {
  $sql .= " AND e.secteur_activite_entreprise ILIKE :sector";
  $params[":sector"] = "%$sector%";
}

/* taille entreprise */
if ($size !== "") {
  if ($size === "small") $sql .= " AND e.nb_employes_entreprise < 300";
  if ($size === "pme")   $sql .= " AND e.nb_employes_entreprise BETWEEN 300 AND 1000";
  if ($size === "big")   $sql .= " AND e.nb_employes_entreprise > 1000";
}

/* début (par rapport à aujourd’hui) */
if ($start !== "") {
  if ($start === "soon")  $sql .= " AND s.date_debut_stage <= (CURRENT_DATE + INTERVAL '30 days')";
  if ($start === "mid")   $sql .= " AND s.date_debut_stage > (CURRENT_DATE + INTERVAL '30 days') AND s.date_debut_stage <= (CURRENT_DATE + INTERVAL '90 days')";
  if ($start === "later") $sql .= " AND s.date_debut_stage > (CURRENT_DATE + INTERVAL '90 days')";
}

$sql .= " ORDER BY s.date_debut_stage ASC LIMIT 100";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

echo json_encode(["results" => $stmt->fetchAll()], JSON_UNESCAPED_UNICODE);
