<?php
session_start();

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


    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: 'Dancing Script', Georgia, serif;
        background-color: var(--bg);
        color: var(--text-color);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        transition: background-color var(--transition), color var(--transition);
    }

    a {
        color: inherit;
        text-decoration: none;
        transition: color var(--transition);
    }

    a:hover { color: var(--gold); }

    .button {
        background: transparent;
        border: 1px solid var(--gold-border);
        color: var(--gold-dim);
        border-radius: 6px;
        padding: 7px 14px;
        font-size: 13px;
        font-family: inherit;
        cursor: pointer;
        transition: all var(--transition);
        flex-shrink: 0;
    }

    .button:hover {
        background: var(--gold-faint);
        color: var(--gold);
        border-color: var(--gold-dim);
    }

    main {
        flex: 1;
        padding: 48px 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    main h1 {
        font-size: 28px;
        color: var(--text-muted);
        font-weight: 400;
        letter-spacing: 0.04em;
        text-align: center;
    }
    .account-container {
        background: var(--bg-section-light);
        border: 1px solid var(--gold-border);
        border-radius: 12px;
        max-width: 520px;
        width: 100%;
        padding: 50px 40px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
        animation: fadeSlideIn 0.6s ease forwards;
    }

    .account-header {
        text-align: center;
        margin-bottom: 32px;
        border-bottom: 1px solid var(--gold-border);
        padding-bottom: 24px;
    }

    .account-header h2 {
        font-size: 38px;
        color: var(--text-color);
        margin-bottom: 6px;
        font-weight: 700;
    }

    .account-header p {
        font-size: 14px;
        color: var(--gold-dim);
        letter-spacing: 0.04em;
    }

    /* Welcome card */
    .welcome-card {
        background: var(--bg-card);
        border: 1px solid var(--gold-border);
        border-radius: var(--radius);
        padding: 22px 20px;
        text-align: center;
        margin-bottom: 28px;
    }

    .welcome-card p {
        font-size: 22px;
        color: var(--text-color);
    }

    .welcome-card span {
        color: #b78917;
        font-weight: 700;
    }

    /* Info rows */
    .info-row {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 28px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border: 1px solid var(--gold-border);
        border-radius: 8px;
    }

    .info-item .info-label {
        font-size: 13px;
        color: var(--gold-dim);
        min-width: 60px;
    }

    .info-item .info-value {
        font-size: 16px;
        color: var(--text-color);
        font-weight: 700;
    }
    .btn-logout {
        width: 100%;
        padding: 14px 32px;
        background: transparent;
        color: var(--red);
        border: 1px solid var(--red-dim);
        border-radius: 8px;
        font-size: 17px;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        transition: all var(--transition);
    }

    .btn-logout:hover {
        background: rgba(212, 42, 0, 0.08);
        border-color: var(--red);
        transform: translateY(-1px);
    }

    .btn-collection {
        width: 100%;
        margin: 10px 0;
        padding: 14px 32px;
        background: transparent;
        color: var(--gold-dim);
        border: 1px solid var(--gold-dim);
        border-radius: 8px;
        font-size: 17px;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        letter-spacing: 0.05em;
        transition: all var(--transition);
    }

    .btn-collection:hover {
        background: var(--gold-faint);
        color: var(--gold);
        border-color: var(--gold);
        transform: translateY(-1px);
    }

    @keyframes fadeSlideIn {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 640px) {
        .banner { padding: 14px 18px; gap: 12px; }
        .guide { display: none; }
        .account-container { padding: 32px 22px; }
        .footer { flex-direction: column; text-align: center; }
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
        <h1> Votre collection est vide :(</h1>
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