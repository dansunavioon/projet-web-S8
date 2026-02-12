<?php
session_start();
require __DIR__ . "/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  header("Location: ../pages/login.php");
  exit;
}

$email = trim($_POST["email"] ?? "");
$pass = trim($_POST["password"] ?? "");

if ($email === "" || $pass === "") {
  header("Location: ../pages/login.php?err=missing");
  exit;
}

$stmt = $pdo->prepare("SELECT id_user, nom_user, mail_user, mdp_user FROM utilisateur WHERE mail_user = :email");
$stmt->execute([":email" => $email]);
$user = $stmt->fetch();

if (!$user) {
  header("Location: ../pages/login.php?err=bad");
  exit;
}

// Vérification hash
if (!password_verify($pass, $user["mdp_user"])) {
  header("Location: ../pages/login.php?err=bad");
  exit;
}

$_SESSION["user"] = [
  "id" => $user["id_user"],
  "name" => $user["nom_user"],
  "email" => $user["mail_user"],
];

header("Location: ../pages/acceuil.php");
exit;
