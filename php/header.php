<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>

<header class="site-header">
  <div class="header-inner">

    <!-- LOGO + TEXTE -->
    <div class="brand-group">
      <a href="../php/acceuil.php" class="brand">
        <img src="../images/logo_buildux.png" alt="Logo Buildux">
      </a>
      <span class="brand-text">Buildux the true project</span>
    </div>

    <nav class="nav">
      <a href="../php/infos.php" class="nav-link">Contact us</a>

      <?php if (!empty($_SESSION["user"])): ?>
        <!-- ✅ CONNECTÉ : afficher nom + logout -->
        <span class="nav-link nav-link--secondary">
          <?= htmlspecialchars($_SESSION["user"]["name"]) ?>
        </span>
        <a href="../php/auth_logout.php" class="nav-link nav-link--secondary">Logout</a>
      <?php else: ?>
        <!-- ❌ PAS CONNECTÉ : afficher login -->
        <a href="../pages/login.php" class="nav-link nav-link--secondary">
          Log in / Sign in
        </a>
      <?php endif; ?>
    </nav>

    <button class="burger" aria-label="Menu">
      <span></span>
      <span></span>
      <span></span>
    </button>

  </div>

  <nav class="nav-mobile">
    <a href="../php/infos.php" class="nav-link">Contact us</a>

    <?php if (!empty($_SESSION["user"])): ?>
      <span class="nav-link nav-link--secondary">
        <?= htmlspecialchars($_SESSION["user"]["name"]) ?>
      </span>
      <a href="../php/auth_logout.php" class="nav-link nav-link--secondary">Logout</a>
    <?php else: ?>
      <a href="../pages/login.php" class="nav-link nav-link--secondary">
        Log in / Sign in
      </a>
    <?php endif; ?>
  </nav>
</header>
