<?php
if (session_status() === PHP_SESSION_NONE) session_start(); // Start session if not already started
?>

<header class="site-header">
  <div class="header-inner">

    <div class="brand-group">
      <a href="../php/acceuil.php" class="brand">
        <img src="../images/logo_buildux.png" alt="Logo Buildux">
      </a>
      <span class="brand-text">Buildux the true project</span>
    </div>

    <nav class="nav">
      <a href="../php/infos.php" class="nav-link">Contact us</a>

      <?php if (!empty($_SESSION["user"])): ?> <!-- If user is logged in, show their name and a logout link -->
        <span class="nav-link nav-link--secondary"> <!-- Display the logged-in user's name safely using htmlspecialchars to prevent XSS -->
          <?= htmlspecialchars($_SESSION["user"]["name"]) ?> <!-- Output the user's name, ensuring it's properly escaped to prevent XSS attacks -->
        </span>
        <a href="../php/auth_logout.php" class="nav-link nav-link--secondary">Logout</a>
      <?php else: ?>
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
