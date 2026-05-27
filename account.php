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

    <style>
        .account-container {
            background: var(--bg-section-light);
            border-radius: 12px;
            max-width: 520px;
            width: 100%;
            padding: 50px 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            animation: fadeSlideIn 0.6s ease forwards;
        }

        [data-theme="light"] .account-container {
            background: #060404;
        }

        .account-header {
            text-align: center;
            margin-bottom: 32px;
            border-bottom: 2px solid rgba(201, 169, 89, 0.3);
            padding-bottom: 24px;
        }

        .account-header h2 {
            font-size: 42px;
            color: var(--text-color);
            margin-bottom: 8px;
            font-weight: 700;
        }

        .account-header p {
            font-size: 15px;
            color: rgba(201, 169, 89, 0.6);
            letter-spacing: 0.04em;
            margin: 0;
        }

        .welcome-card {
            background: rgba(201, 169, 89, 0.07);
            border: 1px solid rgba(201, 169, 89, 0.25);
            border-radius: 10px;
            padding: 24px 20px;
            text-align: center;
            margin-bottom: 28px;
        }

        .welcome-card p {
            font-size: 22px;
            color: var(--text-color);
            font-family: 'Dancing Script', sans-serif;
            margin: 0;
        }

        .welcome-card span {
            color: #b78917;
            font-weight: 700;
        }

        .info-row {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 32px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 16px;
            border: 2px solid rgba(201, 169, 89, 0.2);
            border-radius: 8px;
            font-family: 'Dancing Script', sans-serif;
        }

        .info-item .info-label {
            font-size: 14px;
            color: rgba(201, 169, 89, 0.6);
            min-width: 60px;
        }

        .info-item .info-value {
            font-size: 16px;
            color: var(--text-color);
            font-weight: 700;
        }

        .btn-logout {
            padding: 15px 32px;
            background: transparent;
            color: rgb(212, 42, 0);
            border: 2px solid rgba(212, 42, 0, 0.5);
            border-radius: 8px;
            font-size: 18px;
            font-weight: 700;
            font-family: 'Dancing Script', serif;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin: 10px 0;
        }

        .btn-logout:hover {
            background: rgba(212, 42, 0, 0.1);
            border-color: rgb(212, 42, 0);
            transform: translateY(-1px);
        }

        .btn-collection {
            padding: 15px 32px;
            background: transparent;
            color: rgba(201, 169, 89, 0.6);
            border: 2px solid rgba(201, 169, 89, 0.6);
            border-radius: 8px;
            font-size: 18px;
            font-weight: 700;
            font-family: 'Dancing Script', serif;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            letter-spacing: 0.05em;
            margin: 10px 0;
        }

        .btn-collection:hover {
            background: rgba(201, 169, 89, 0.6);
            transform: translateY(-1px);
        }

        main {
            padding: 48px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @keyframes fadeSlideIn {
            from {
                opacity: 0;
                transform: translateY(24px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
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