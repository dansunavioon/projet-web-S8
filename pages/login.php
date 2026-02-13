<?php
session_start();
if (!empty($_SESSION["user"])) {
  header("Location: acceuil.php"); // redirect to home page if already logged in
  exit;
}

$err = $_GET["err"] ?? ""; // get error code from query parameter, default to empty string if not set
function errText($err){
  return match($err){
    "missing" => "Remplis tous les champs.",
    "email" => "Email invalide.",
    "exists" => "Cet email est déjà utilisé.",
    "bad" => "Email ou mot de passe incorrect.",
    default => ""
  };
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Log in / Sign up</title>
  <link rel="stylesheet" href="../css/header.css">
  <style>
    body{ margin:0; font-family: system-ui; }
    .wrap{ max-width: 1000px; margin: 40px auto; padding: 20px; }
    .grid{ display:grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .card{ background: #cfe0ff; border-radius: 22px; padding: 18px; box-shadow: 0 10px 24px rgba(0,0,0,0.08); }
    label{ font-weight: 900; color:#0a1a33; display:block; margin:10px 0 6px; }
    input{ width:100%; border:none; outline:none; padding: 12px 14px; border-radius: 14px; background: rgba(255,255,255,0.75); box-shadow: inset 0 0 0 2px rgba(255,255,255,0.65); box-sizing:border-box; }
    .btn{ margin-top: 14px; width:100%; border:none; cursor:pointer; padding: 12px 16px; border-radius: 999px; font-weight: 900; background:#a9c4ff; color:#0a1a33; }
    .err{ margin: 0 0 12px; padding: 10px 12px; border-radius: 14px; background: rgba(255,255,255,0.65); color:#0a1a33; font-weight: 800; }
    @media(max-width: 900px){ .grid{ grid-template-columns: 1fr; } }
  </style>
</head>
<body>

<?php include "../php/header.php"; ?>

<div class="wrap">
  <?php if (errText($err) !== ""): ?>
    <div class="err"><?= htmlspecialchars(errText($err)) ?></div>
  <?php endif; ?>

  <div class="grid">

    <div class="card">
      <h2>Log in</h2>
      <form method="post" action="../php/auth_login.php">
        <label>Email</label>
        <input type="email" name="email" placeholder="ton@email.com" required>
        <label>Mot de passe</label>
        <input type="password" name="password" placeholder="mot de passe" required>
        <button class="btn" type="submit">Se connecter</button>
      </form>
    </div>

    <div class="card">
      <h2>Sign up</h2>
      <form method="post" action="../php/auth_signup.php">
        <label>Nom (Prénom Nom)</label>
        <input type="text" name="name" placeholder="Prénom Nom" required>
        <label>Email</label>
        <input type="email" name="email" placeholder="ton@email.com" required>
        <label>Mot de passe</label>
        <input type="password" name="password" placeholder="simple si tu veux" required>
        <label>Date de naissance</label>
        <input type="date" name="birth" required>
        <button class="btn" type="submit">Créer un compte</button>
      </form>
    </div>

  </div>
</div>

<script src="../js/header.js"></script>
</body>
</html>
