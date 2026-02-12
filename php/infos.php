<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Contact us</title>

  <link rel="stylesheet" href="../css/header.css">
  <link rel="stylesheet" href="../css/acceuil.css">

  <style>
    /* Layout spécial contact : une seule colonne */
    .contact-layout{
      max-width: 1000px;
      margin: 0 auto;
      padding: 20px;
    }

    .contact-card{
      background: rgba(255,255,255,0.55);
      border-radius: 26px;
      padding: 24px;
      box-shadow: inset 0 0 0 2px rgba(255,255,255,0.65);
    }

    .contact-grid{
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
      margin-top: 18px;
    }

    .contact-field label{
      display: block;
      font-weight: 900;
      color: #0a1a33;
      margin-bottom: 6px;
    }

    .contact-field input,
    .contact-field textarea{
      width: 100%;
      border: none;
      outline: none;
      background: rgba(255,255,255,0.75);
      border-radius: 16px;
      padding: 14px 16px;
      font-weight: 700;
      color: #0a1a33;
      box-shadow: inset 0 0 0 2px rgba(255,255,255,0.65);
      box-sizing: border-box;
    }

    .contact-field textarea{
      min-height: 160px;
      resize: vertical;
    }

    .contact-actions{
      margin-top: 18px;
      display: flex;
      gap: 14px;
      justify-content: flex-end;
    }

    .btn{
      border: none;
      cursor: pointer;
      padding: 14px 20px;
      border-radius: 999px;
      font-weight: 900;
      color: #0a1a33;
      background: #a9c4ff;
      box-shadow: 0 10px 18px rgba(0,0,0,0.12);
    }

    .btn-secondary{
      background: rgba(255,255,255,0.65);
    }

    .contact-info{
      margin-top: 20px;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 12px;
    }

    .info-box{
      background: rgba(255,255,255,0.55);
      border-radius: 18px;
      padding: 14px;
      box-shadow: inset 0 0 0 2px rgba(255,255,255,0.65);
      font-weight: 800;
      color: #0a1a33;
    }

    .info-box small{
      display: block;
      opacity: 0.7;
      margin-bottom: 4px;
    }

    @media(max-width: 900px){
      .contact-grid{ grid-template-columns: 1fr; }
      .contact-info{ grid-template-columns: 1fr; }
      .contact-actions{ justify-content: stretch; }
      .btn{ width: 100%; }
    }

      html, body{
        height: 100%;
        margin: 0;
      }

      main.home{
        min-height: calc(100vh - 110px);
        display: flex;
        justify-content: center;
        align-items: stretch;
        padding-top: 20px; 
      }

      .contact-layout{
        width: 100%;
        max-width: 1100px;
        display: flex;
        flex-direction: column;
      }

      .contact-card{
        flex: 1;
        display: flex;
        flex-direction: column;
      }

      .contact-card form{
        flex: 1;
        display: flex;
        flex-direction: column;
      }

      .contact-field textarea{
        flex: 1;
      }

  </style>
</head>

<body>

<?php include "../php/header.php"; ?>
<?php include "../php/log_in.php"; ?>

<main class="home">
  <section class="panel panel-right contact-layout">

    <h1 class="search-title">Contact us</h1>

    <div class="contact-card">

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
          <button type="reset" class="btn btn-secondary">Effacer</button>
          <button type="submit" class="btn">Envoyer</button>
        </div>
      </form>

      <div class="contact-info">
        <div class="info-box">
          <small>Email</small>
          support@buildux.com
        </div>
        <div class="info-box">
          <small>Téléphone</small>
          +33 6 07 08 09 10
        </div>
        <div class="info-box">
          <small>Localisation</small>
          Nantes, France
        </div>
      </div>

    </div>
  </section>
</main>

<script src="../js/header.js"></script>
</body>
</html>
