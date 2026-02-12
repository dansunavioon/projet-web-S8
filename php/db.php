<?php
// auth.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

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
  die("Erreur BDD : " . $e->getMessage());
}

function is_logged_in(): bool {
  return !empty($_SESSION["user"]);
}

function current_user(): ?array {
  return $_SESSION["user"] ?? null;
}
