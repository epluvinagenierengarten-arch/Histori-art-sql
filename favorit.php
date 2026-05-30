<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['utilisateur_id'])) {
    header('Location: login.php');
    exit();
}

$pdo = new PDO('mysql:host=localhost;dbname=historiart', 'root', '');
$stmt = $pdo->prepare("SELECT carte_id FROM favoris WHERE utilisateur_id = ?");
$stmt->execute([$_SESSION['utilisateur_id']]);
$favoris = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
  <title>Histori'art – Mes favoris</title>
</head>
<body>

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

  <main>
    <div class="museum-section">
      <h2>Mes cartes favorites</h2>
    </div>

    <?php if (empty($favoris)): ?>
      <div class="empty-msg">
        <p>Tu n'as pas encore de cartes favorites.</p>
        <p><a href="annexe.php">→ Parcourir les cartes</a></p>
      </div>
    <?php else: ?>
      <div class="favoris-grid">
        <?php foreach ($favoris as $carte_id): ?>
          <div class="carte-item">
            <img src="<?= htmlspecialchars($carte_id) ?>.png" alt="<?= htmlspecialchars($carte_id) ?>">
            <button class="fav-btn active" data-carte="<?= htmlspecialchars($carte_id) ?>" aria-label="Retirer des favoris">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 14 21 13 21"
                  stroke="#e05570" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </main>

  <footer id="pagefooter" class="footer">
    <div class="imagefooter"><img src="carte.png" alt="carte"></div>
    <div class="textfooter">Tous droits réservés © 2025 Histori'art</div>
  </footer>

  <script>
    document.querySelectorAll('.fav-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const carteId = btn.dataset.carte;
        fetch('favorit_action.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ carte_id: carteId, action: 'remove' })
        });
        btn.closest('.carte-item').remove();
        if (document.querySelectorAll('.carte-item').length === 0) {
          document.querySelector('.favoris-grid').outerHTML =
            '<div class="empty-msg"><p>Tu n\'as plus de cartes favorites.</p><p><a href="annexe.php">→ Parcourir les cartes</a></p></div>';
        }
      });
    });
  </script>
</body>
</html>