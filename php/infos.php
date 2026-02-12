<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Contact us</title>

  <link rel="stylesheet" href="../css/header.css">
  <link rel="stylesheet" href="../css/acceuil.css"> <!-- tu peux réutiliser ton style -->
  <style>
    /* petit style local uniquement pour la page contact */
    .contact-wrap{
      max-width: 900px;
      margin: 0 auto;
      padding: 18px;
    }

    .contact-card{
      background: rgba(255,255,255,0.55);
      border-radius: 22px;
      padding: 18px;
      box-shadow: inset 0 0 0 2px rgba(255,255,255,0.65);
    }

    .contact-grid{
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
      margin-top: 14px;
    }

    .contact-field label{
      display:block;
      font-weight: 900;
      color:#0a1a33;
      margin-bottom: 6px;
    }

    .contact-field input,
    .contact-field textarea{
      width:100%;
      border:none;
      outline:none;
      background: rgba(255,255,255,0.75);
      border-radius: 14px;
      padding: 12px 14px;
      font-weight: 700;
      color:#0a1a33;
      box-shadow: inset 0 0 0 2px rgba(255,255,255,0.65);
      box-sizing: border-box;
    }

    .contact-field textarea{
      min-height: 140px;
      resize: vertical;
    }

    .contact-actions{
      margin-top: 14px;
      display:flex;
      gap: 12px;
      justify-content: flex-end;
    }

    .btn{
      border:none;
      cursor:pointer;
      padding: 12px 16px;
      border-radius: 999px;
      font-weight: 900;
      color:#0a1a33;
      background: #a9c4ff;
      box-shadow: 0 10px 18px rgba(0,0,0,0.10);
    }

    .btn-secondary{
      background: rgba(255,255,255,0.65);
    }

    .contact-info{
      margin-top: 14px;
      display:grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 10px;
    }
    .info-box{
      background: rgba(255,255,255,0.55);
      border-radius: 18px;
      padding: 12px 14px;
      box-shadow: inset 0 0 0 2px rgba(255,255,255,0.65);
      color:#0a1a33;
      font-weight: 800;
    }
    .info-box small{ display:block; opacity:0.75; font-weight:800; }

    @media(max-width: 900px){
      .contact-grid{ grid-template-columns: 1fr; }
      .contact-info{ grid-template-columns: 1fr; }
      .contact-actions{ justify-content: stretch; }
      .btn{ width:100%; }
    }
  </style>
</head>

<body>
  <?php include "../php/header.php"; ?>
  <?php include "../php/log_in.php"; ?>

  <main class="home">
    <div class="home-layout">
      <aside class="panel panel-left">
        <div class="panel-title">Help</div>
        <p style="margin-top:12px; font-weight:800; color:#0a1a33;">
          Une question ? Un bug ? Une suggestion ? Écris-nous.
        </p>
      </aside>

      <section class="panel panel-right">
        <h1 class="search-title">Contact us</h1>

        <div class="contact-wrap">
          <div class="contact-card">

            <!-- Formulaire (statique : ne fait rien pour l'instant) -->
            <form method="post" action="#">
              <div class="contact-grid">
                <div class="contact-field">
                  <label>Nom</label>
                  <input type="text" name="name" placeholder="Ton nom">
                </div>

                <div class="contact-field">
                  <label>Email</label>
                  <input type="email" name="email" placeholder="ton@email.com">
                </div>

                <div class="contact-field" style="grid-column: 1 / -1;">
                  <label>Sujet</label>
                  <input type="text" name="subject" placeholder="Sujet du message">
                </div>

                <div class="contact-field" style="grid-column: 1 / -1;">
                  <label>Message</label>
                  <textarea name="message" placeholder="Écris ton message..."></textarea>
                </div>
              </div>

              <div class="contact-actions">
                <button class="btn btn-secondary" type="reset">Effacer</button>
                <button class="btn" type="submit">Envoyer</button>
              </div>
            </form>

            <!-- Infos de contact -->
            <div class="contact-info">
              <div class="info-box">
                <small>Email</small>
                support@buildux.com
              </div>
              <div class="info-box">
                <small>Téléphone</small>
                +33 6 00 00 00 00
              </div>
              <div class="info-box">
                <small>Adresse</small>
                Nantes, France
              </div>
            </div>

          </div>
        </div>

      </section>
    </div>
  </main>

  <script src="../js/header.js"></script>
</body>
</html>
