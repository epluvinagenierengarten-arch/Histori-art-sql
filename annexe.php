<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$favoris = [];
if (isset($_SESSION['utilisateur_id'])) {
    $pdo = new PDO('mysql:host=localhost;dbname=historiart', 'root', '');
    $stmt = $pdo->prepare("SELECT carte_id FROM favoris WHERE utilisateur_id = ?");
    $stmt->execute([$_SESSION['utilisateur_id']]);
    $favoris = $stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>

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
      position: relative;
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

    .fav-btn {
      background: none;
      border: none;
      cursor: pointer;
      padding: 4px;
      position: absolute;
      bottom: 12px;
      right: 12px;
      z-index: 10;
    }

    .fav-btn svg path {
      transition: fill 0.2s;
    }

    .fav-btn.active svg path {
      fill: var(--text-color); /* cœur plein quand actif */
    }

  </style>
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
        <button class="booster-btn" id="booster.btn" aria-label="Profil" onclick="window.location.href='booster.php'">
            <img src="booster.png" alt="booster" id="busteImg">
        </button>
        <button class="button" id="themeToggle">Mode clair</button>
    </header>
</main>



<body>
    <main>
      <!-- Section Louvre -->
      <div class="museum-section">
        <h2>Musée du Louvre</h2>
      </div>
      <div class="swiper mySwiper">
        <div class="swiper-wrapper">
          <!-- cartes : Louvre -->
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="louvre/joconde.png" alt="joconde">
            </div>
            <button class="fav-btn" data-carte="louvre/joconde" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="louvre/dianedeversailles.png" alt="diane de versailles">
            </div>
            <button class="fav-btn" data-carte="louvre/dianedeversailles" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="louvre/ferronniere.png" alt="ferronniere">
            </div>
            <button class="fav-btn" data-carte="louvre/ferronniere" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="louvre/Horaces.png" alt="les Horaces">
            </div>
            <button class="fav-btn" data-carte="louvre/Horaces" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="louvre/libertéguidantlepeuple.png" alt="la liberté guidant le peuple">
            </div>
            <button class="fav-btn" data-carte="louvre/libertéguidantlepeuple" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="louvre/louisXIV.png" alt="le portrait de Louis XIV">
            </div>
            <button class="fav-btn" data-carte="louvre/louisXIV" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="louvre/meduse.png" alt="le radeau de la meduse">
            </div>
            <button class="fav-btn" data-carte="louvre/meduse"aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="louvre/napoleon.png" alt="portrait de napoléon 1er">
            </div>
            <button class="fav-btn" data-carte="louvre/napoleon" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="louvre/nocedecana.png" alt="les noces de cana">
            </div>
            <button class="fav-btn" data-carte="louvre/nocedecana" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="louvre/odalisque.png" alt="la grande odalisque">
            </div>
            <button class="fav-btn" data-carte="louvre/odalisque" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="louvre/psychée.png" alt="psychée">
            </div>
            <button class="fav-btn" data-carte="louvre/psychée" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="louvre/scribe.png" alt="le scribe">
            </div>
            <button class="fav-btn" data-carte="louvre/scribe" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="louvre/Vitruve.png" alt="vitruve">
            </div>
            <button class="fav-btn" data-carte="louvre/vitruve" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="louvre/Victory.png" alt="victoire">
            </div>
            <button class="fav-btn" data-carte="louvre/victory" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="louvre/venusDeMilo.png">
            </div>
            <button class="fav-btn" data-carte="louvre/venusdemilo" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="louvre/Zodiaque.png" alt="zodiaque">
            </div>
            <button class="fav-btn" data-carte="louvre/zodiaque" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>

      <!-- Section MoMA -->
      <div class="museum-section">
        <h2>Museum of Modern Art (MoMA)</h2>
      </div>
      <div class="swiper mySwiper">
        <div class="swiper-wrapper">
          <!-- cartes : MoMA -->
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="moma/avignon.png" alt="demoiselles d'avignon">
            </div>
            <button class="fav-btn" data-carte="moma/avignon" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="moma/boat.png" alt="bateau matisse">
            </div>
            <button class="fav-btn" data-carte="moma/boat" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="moma/bohemienne.png" alt="la bohemienne endormie">
            </div>
            <button class="fav-btn" data-carte="moma/bohemienne" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="moma/catalan.png" alt="catalan">
            </div>
            <button class="fav-btn" data-carte="moma/catalan" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="moma/chatetoiseau.png" alt="le chat et l'oiseau">
            </div>
            <button class="fav-btn" data-carte="moma/chatetoiseau" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="moma/familykhalo.png" alt="family khalo">
            </div>
            <button class="fav-btn" data-carte="moma/familykhalo" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="moma/fingerman.png" alt="finger man">
            </div>
            <button class="fav-btn" data-carte="moma/fingerman" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="moma/frida.png" alt="autoportrait frida khalo">
            </div>
            <button class="fav-btn" data-carte="moma/frida" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="moma/hope2.png" alt="l'espoir 2">
            </div>
            <button class="fav-btn" data-carte="moma/hope2" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="moma/lavilleseleve.png" alt="la ville se leve">
            </div>
            <button class="fav-btn" data-carte="moma/lavilleseleve" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="moma/lesamants.png" alt="les amants">
            </div>
            <button class="fav-btn" data-carte="moma/lesamants" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="moma/memoiredali.png" alt="memoire dali">
            </div>
            <button class="fav-btn" data-carte="moma/memoiredali" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="moma/mirroirmagritte.png" alt="mirroir magritte">
            </div>
            <button class="fav-btn" data-carte="moma/mirroirmagritte" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="moma/nuitetoilee.png" alt="la nuit étoilée">
            </div>
            <button class="fav-btn" data-carte="moma/nuitetoilee" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="moma/pontmonet.png" alt="pont monet">
            </div>
            <button class="fav-btn" data-carte="moma/pontmonet" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="moma/woman.png" alt="woman"> 
            </div>
            <button class="fav-btn" data-carte="moma/woman" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
            </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>

      <!-- Section Van Gogh Museum -->
      <div class="museum-section">
        <h2>Van Gogh Museum</h2>
      </div>

      <div class="swiper mySwiper">
        <div class="swiper-wrapper">
          <!-- cartes : Van Gogh Museum -->
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="vgmus/amandier.png">
            </div>
            <button class="fav-btn" data-carte="vgmus/amandier" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="vgmus/autoportraitChevalet.png">
            </div>
            <button class="fav-btn" data-carte="vgmus/autoportraitchevalet" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="vgmus/chambreVG.png">
            </div>
            <button class="fav-btn" data-carte="vgmus/chambreVG" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="vgmus/chaussures.png">
            </div>
            <button class="fav-btn" data-carte="vgmus/chaussures" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="vgmus/corbeaux.png">
            </div>
            <button class="fav-btn" data-carte="vgmus/corbeaux" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="vgmus/feutre.png">
            </div>
            <button class="fav-btn" data-carte="vgmus/feutre" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="vgmus/gauguin.png">
            </div>
            <button class="fav-btn" data-carte="vgmus/gauguin" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="vgmus/maisonjaune.png">
            </div>
            <button class="fav-btn" data-carte="vgmus/maisonjaune" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="vgmus/moisson.png">
            </div>
            <button class="fav-btn" data-carte="vgmus/moisson" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="vgmus/paysagepluie.png">
            </div>
            <button class="fav-btn" data-carte="vgmus/paysagepluie" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="vgmus/pecher.png">
            </div>
            <button class="fav-btn" data-carte="vgmus/pecher" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="vgmus/racinesarbre.png">
            </div>
            <button class="fav-btn" data-carte="vgmus/racinesarbre" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="vgmus/saintemariemarin.png">
            </div>
            <button class="fav-btn" data-carte="vgmus/saintemariemarin" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="vgmus/squelette.png">
            </div>
            <button class="fav-btn" data-carte="vgmus/squelette" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="vgmus/Iris.png">
            </div>
            <button class="fav-btn" data-carte="vgmus/Iris" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="swiper-slide">
            <div class="carte-placeholder">
              <img src="vgmus/tournesols.png">
            </div>
            <button class="fav-btn" data-carte="vgmus/tournesol" aria-label="Ajouter aux favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="var(--text-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
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
      const favoris = <?= json_encode($favoris) ?>;

      document.querySelectorAll('.fav-btn').forEach(btn => {
        // Coche les cœurs déjà en favoris
        if (favoris.includes(btn.dataset.carte)) {
          btn.classList.add('active');
          btn.setAttribute('aria-label', 'Retirer des favoris');
        }

        btn.addEventListener('click', () => {
          const isActive = btn.classList.toggle('active');
          const carteId = btn.dataset.carte;
          btn.setAttribute('aria-label', isActive ? 'Retirer des favoris' : 'Ajouter aux favoris');

          fetch('favorit_action.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ carte_id: carteId, action: isActive ? 'add' : 'remove' })
          });
        });
      });
    </script>
</body>

</html>