<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . "/db.php"; // doit créer $pdo (PDO PostgreSQL)

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
  s.date_publication_stage,
  s.date_debut_stage,
  s.duree_jours_stage,
  s.description_stage,
  e.id_national_entreprise,
  e.nom_entreprise,
  e.nb_employes_entreprise,
  e.secteur_activite_entreprise,
  e.nom_pays
FROM stage s
JOIN entreprise e ON e.id_national_entreprise = s.id_national_entreprise
WHERE 1=1
";

$params = [];

/* 🔎 Métier/Mots-clés : on cherche dans description */
if ($job !== '') {
  $sql .= " AND s.description_stage ILIKE :job";
  $params[':job'] = "%$job%";
}

/* 🏢 Entreprise */
if ($company !== '') {
  $sql .= " AND e.nom_entreprise ILIKE :company";
  $params[':company'] = "%$company%";
}

/* 🌍 Pays */
if ($country !== '') {
  $sql .= " AND e.nom_pays ILIKE :country";
  $params[':country'] = "%$country%";
}

/* 🧩 Secteur */
if ($sector !== '') {
  $sql .= " AND e.secteur_activite_entreprise ILIKE :sector";
  $params[':sector'] = "%$sector%";
}

/* 👥 Taille entreprise */
if ($size === "small") $sql .= " AND e.nb_employes_entreprise < 300";
if ($size === "pme")   $sql .= " AND e.nb_employes_entreprise BETWEEN 300 AND 1000";
if ($size === "big")   $sql .= " AND e.nb_employes_entreprise > 1000";

/* ⏱️ Durée (adaptée à tes données : 60/75/90/120/180) */
if ($duration === "short") {
  $sql .= " AND s.duree_jours_stage <= 60";
} elseif ($duration === "standard") {
  $sql .= " AND s.duree_jours_stage BETWEEN 61 AND 90";
} elseif ($duration === "long") {
  $sql .= " AND s.duree_jours_stage BETWEEN 91 AND 180";
} elseif ($duration === "xl") {
  $sql .= " AND s.duree_jours_stage > 180";
}

/* 📅 Début */
if ($start === "soon") {
  $sql .= " AND s.date_debut_stage <= (CURRENT_DATE + INTERVAL '30 days')";
} elseif ($start === "mid") {
  $sql .= " AND s.date_debut_stage > (CURRENT_DATE + INTERVAL '30 days')
            AND s.date_debut_stage <= (CURRENT_DATE + INTERVAL '90 days')";
} elseif ($start === "later") {
  $sql .= " AND s.date_debut_stage > (CURRENT_DATE + INTERVAL '90 days')";
}

$sql .= " ORDER BY s.date_debut_stage ASC LIMIT 200";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

echo json_encode(["results" => $stmt->fetchAll()], JSON_UNESCAPED_UNICODE);
