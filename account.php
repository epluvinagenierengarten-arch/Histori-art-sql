<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['utilisateur_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script defer src="main.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    <title>Histori'art – Mon compte</title>
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

    <main class="form-page">
        <div class="account-container">

            <div class="account-header">
                <h2>Mon compte</h2>
                <p>Votre espace personnel Histori'art</p>
            </div>

            <div class="welcome-card">
                <p>Bienvenue, <span><?= htmlspecialchars($_SESSION['nom_utilisateur']) ?></span> !</p>
            </div>

            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">Pseudo</span>
                    <span class="info-value"><?= htmlspecialchars($_SESSION['nom_utilisateur']) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value"><?= htmlspecialchars($_SESSION['email']) ?></span>
                </div>
            </div>

            <form action="macollection.php" method="POST">
                <button type="submit" class="btn-collection">Ma collection</button>
            </form>
            <form action="favorit.php" method="POST">
                <button type="submit" class="btn-collection">Mes cartes favorites</button>
            </form>

            <button type="button" class="btn-collection" onclick="window.location.href='change.php'">
                Changer de mot de passe
            </button>

            <form action="logout.php" method="POST">
                <button type="submit" class="btn-logout">Se déconnecter</button>
            </form>

            <form action="delete.php" method="POST">
                <button type="submit" class="btn-logout">Supprimer le compte</button>
            </form>

        </div>
    </main>

    <footer id="pagefooter" class="footer">
        <div class="imagefooter">
            <img src="carte.png" alt="carte">
        </div>
        <div class="textfooter">
            Tous droits de reproduction et de diffusion réservés © 2025 Histori'art
        </div>
    </footer>

</body>
</html>