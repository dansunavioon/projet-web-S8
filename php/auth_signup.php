<?php
session_start();
require __DIR__ . "/db.php"; // $pdo is defined here

if ($_SERVER["REQUEST_METHOD"] !== "POST") { // Only allow POST requests
  header("Location: ../pages/login.php");
  exit;
}

$name = trim($_POST["name"] ?? ""); // Get the name from POST data, default to empty string if not set
$email = trim($_POST["email"] ?? "");
$pass = trim($_POST["password"] ?? "");
$birth = trim($_POST["birth"] ?? "");

if ($name === "" || $email === "" || $pass === "" || $birth === "") {
  header("Location: ../pages/login.php?err=missing");
  exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  header("Location: ../pages/login.php?err=email");
  exit;
}

$stmt = $pdo->prepare("SELECT id_user FROM utilisateur WHERE mail_user = :email");
$stmt->execute([":email" => $email]);
if ($stmt->fetch()) {
  header("Location: ../pages/login.php?err=exists");
  exit;
}

$hash = password_hash($pass, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("
  INSERT INTO utilisateur (nom_user, mail_user, mdp_user, date_nais_user)
  VALUES (:name, :email, :mdp, :birth)
  RETURNING id_user, nom_user, mail_user
");
$stmt->execute([
  ":name" => $name,
  ":email" => $email,
  ":mdp" => $hash,
  ":birth" => $birth
]);

$userRow = $stmt->fetch();

$_SESSION["user"] = [
  "id" => $userRow["id_user"],
  "name" => $userRow["nom_user"],
  "email" => $userRow["mail_user"],
];

header("Location: ../php/acceuil.php");
exit;
