<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="style.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css">
    <script defer src="annexe.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />
    <title>Histori'art — Les Cartes</title>
</head>

<main>
  <header class="banner">
        <h1>Histori'art</h1>
        <div class="main">
            <h2>Le jeu de cartes sur l'histoire de l'art</h2>
        </div>
        <div class="guide">
            <div class="entree"><a href="index.php">✦ Menu</a></div>
            <div class="entree"><a href="annexe.php">✦ Les cartes</a></div>
            <div class="entree"><a href="collection.php">✦ Les collections</a></div>
        </div>
        <button class="buste-btn" id="busteBtn" aria-label="Profil" onclick="window.location.href='login.php'">
            <img src="buste_clair.png" alt="Buste" id="busteImg">
        </button>
        <button class="button" id="themeToggle">Mode clair</button>
    </header>
</main>

<style>
    html,
    body {
      position: relative;
      height: 100%;
    }

    body {
      background: #000;
      font-size: 14px;
      color: #fff;
      margin: 0;
      padding: 0;
    }

    .swiper {
      width: 100%;
      height: 700px;
    }

    .swiper-slide {
      text-align: center;
      font-size: 18px;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 600px;
    }

    .swiper-slide img {
      display: block;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .museum-section {
      padding: 40px 20px;
      background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
      border-bottom: 3px solid #c9a961;
      border-top: 3px solid #c9a961;
      margin: 30px 0 20px 0;
      position: relative;
      overflow: hidden;
      animation: fadeSlideIn 0.8s ease forwards;
    }

    .museum-section h2 {
      margin: 0;
      font-size: 32px;
      font-weight: bold;
      color: #c9a961;
      font-family: 'Dancing Script', cursive;
      text-align: center;
      letter-spacing: 2px;
      position: relative;
      z-index: 1;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .carte-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    }

    .carte-placeholder img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

  </style>
</head>

<body>
    <main>
      <!-- Section Louvre -->
      <div class="museum-section">
        <h2>Musée du Louvre</h2>
      </div>
      <div class="swiper mySwiper">
        <div class="swiper-wrapper">
          <!-- Images : Louvre -->
          <div class="swiper-slide"><div class="carte-placeholder"><img src="louvre/joconde.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="louvre/dianedeversailles.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="louvre/ferronniere.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="louvre/Horaces.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="louvre/libertéguidantlepeuple.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="louvre/louisXIV.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="louvre/meduse.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="louvre/napoleon.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="louvre/nocedecana.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="louvre/odalisque.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="louvre/psychée.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="louvre/scribe.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="louvre/Vitruve.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="louvre/Victory.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="louvre/venusDeMilo.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="louvre/Zodiaque.png"></div></div>
        </div>
        <div class="swiper-pagination"></div>
      </div>

      <!-- Section MoMA -->
      <div class="museum-section">
        <h2>Museum of Modern Art (MoMA)</h2>
      </div>
      <div class="swiper mySwiper">
        <div class="swiper-wrapper">
          <!-- Images : MoMA -->
          <div class="swiper-slide"><div class="carte-placeholder"><img src="moma/avignon.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="moma/boat.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="moma/bohemienne.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="moma/catalan.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="moma/chatetoiseau.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="moma/familykhalo.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="moma/fingerman.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="moma/frida.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="moma/hope2.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="moma/lavilleseleve.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="moma/lesamants.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="moma/memoiredali.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="moma/mirroirmagritte.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="moma/nuitetoilee.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="moma/pontmonet.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="moma/woman.png"></div></div>
        </div>
        <div class="swiper-pagination"></div>
      </div>

      <!-- Section Van Gogh Museum -->
      <div class="museum-section">
        <h2>Musée Van Gogh</h2>
      </div>

      <div class="swiper mySwiper">
        <div class="swiper-wrapper">
          <!-- Images : Van Gogh Museum -->
          <div class="swiper-slide"><div class="carte-placeholder"><img src="vgmus/amandier.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="vgmus/autoportraitChevalet.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="vgmus/chambreVG.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="vgmus/chaussures.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="vgmus/corbeaux.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="vgmus/feutre.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="vgmus/gauguin.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="vgmus/maisonjaune.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="vgmus/moisson.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="vgmus/paysagepluie.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="vgmus/pecher.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="vgmus/racinesarbre.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="vgmus/saintemariemarin.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="vgmus/squelette.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="vgmus/Iris.png"></div></div>
          <div class="swiper-slide"><div class="carte-placeholder"><img src="vgmus/tournesols.png"></div></div>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </main>

    <footer id="pagefooter" class="footer">
        <div class="imagefooter">
            <img src="carte.png" alt="carte">
        </div>
        <div class="textfooter">
            Tous droits réservés © 2025 Histori'art
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>

    <script>
      var swiper = new Swiper(".mySwiper", {
        slidesPerView: 4,
        spaceBetween: 20,
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
      });
    </script>
</body>

</html>