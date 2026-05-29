<?php
session_start();
try {
    $pdo = new PDO('mysql:host=localhost;dbname=historiart', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
 
if (!isset($_SESSION['utilisateur_id'])) {
    header('Location: login.php');
    exit();
}
 
$success_message = '';
$error_message   = '';


if (isset($_POST['action']) && $_POST['action'] === 'changer_mdp') {
 
    $ancien_mdp    = $_POST['ancien_mdp']      ?? '';
    $nouveau_mdp   = $_POST['nouveau_mdp']     ?? '';
    $confirmer_mdp = $_POST['confirmer_mdp']   ?? '';
 
    $stmt = $pdo->prepare("SELECT mot_de_passe FROM utilisateurs WHERE id = ?");
    $stmt->execute([$_SESSION['utilisateur_id']]);
    $hash_bdd = $stmt->fetchColumn();

    if ($hash_bdd === false) {
        $error_message = 'Utilisateur introuvable.';
    }

 
    if (!password_verify($ancien_mdp, $hash_bdd)) {
        $error_message = 'Mot de passe actuel incorrect.';
    } elseif (strlen($nouveau_mdp) < 8) {
        $error_message = 'Le nouveau mot de passe doit contenir au moins 8 caractères.';
    } elseif ($nouveau_mdp !== $confirmer_mdp) {
        $error_message = 'Les deux nouveaux mots de passe ne correspondent pas.';
    } else {
        $nouveau_hash = password_hash($nouveau_mdp, PASSWORD_BCRYPT);
 
        
        $stmt = $pdo->prepare("UPDATE utilisateurs SET mot_de_passe = ? WHERE id = ?");
        $stmt->execute([$nouveau_hash, $_SESSION['utilisateur_id']]);
 
        $_SESSION['password_hash'] = $nouveau_hash;
        $success_message = 'Mot de passe mis à jour avec succès !';
    }
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
    <title>Histori'art – Changer de mot de passe </title>
    <style>
        
    .changement-wrapper {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
        background: var(--bg-main-dark);
    }

    .changement-panel {
        width: 100%;
        max-width: 520px;
        background: var(--bg-banner);
        border-top: 3px solid var(--text-color);
        border-radius: 4px;
        padding: 2.5rem 2.8rem 2.8rem;
        position: relative;
        animation: fadeSlideIn 0.6s ease forwards;
    }


    .changement-titre {
        font-family: 'Dancing Script';
        font-size: 36px;
        color: var(--text-color);
        text-align: center;
        margin-bottom: 0.3rem;
    }

    .changement-sous-titre {
        font-family: 'Dancing Script', serif;
        font-size: 16px;
        color: var(--bg-main-dark);
        text-align: center;
        margin-bottom: 2rem;
    }

    .champ-groupe {
        margin-bottom: 1.4rem;
    }

    .champ-label {
        display: block;
        font-family: 'Dancing Script', serif;
        font-size: 18px;
        color: var(--text-color);
        margin-bottom: 0.4rem;
        opacity: 0.5;
    }

    .champ-input {
        width: 100%;
        background: var(--bg-main-dark);
        border: 1px solid var(--bg-main-dark);
        border-radius: 4px;
        color: var(--text-color);
        font-family: 'Dancing Script', serif;
        font-size: 18px;
        padding: 0.65rem 1rem;
        outline: none;
        transition: border-color .25s, box-shadow .25s;
    }

    .champ-input::placeholder {
        color: var(--text-color);
    }

    .champ-input:focus {
        border-color: var(--text-color);
    }

    .force-barre {
        height: 3px;
        background: rgba(201, 169, 89, 0.12);
        border-radius: 2px;
        margin-top: 0.5rem;
        overflow: hidden;
    }

    .force-remplissage {
        height: 100%;
        width: 0%;
        border-radius: 2px;
        transition: width 0.35s, background 0.35s;
    }

    .champ-indice {
        font-family: 'Dancing Script', serif;
        font-size: 14px;
        color: rgba(201, 169, 89, 0.4);
        margin-top: 0.3rem;
        font-style: italic;
    }

    .alerte {
        font-family: 'Dancing Script', serif;
        font-size: 18px;
        padding: 0.8rem 1.1rem;
        border-radius: 4px;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .alerte-succes {
        background: rgba(74, 140, 92, 0.1);
        border: 1px solid rgba(74, 140, 92, 0.35);
        color: #7abf8e;
    }

    .alerte-erreur {
        background: rgba(184, 64, 64, 0.1);
        border: 1px solid rgba(184, 64, 64, 0.3);
        color: #d47878;
    }

    .btn-changer {
        width: 100%;
        margin-top: 0.5rem;
        padding: 0.8rem;
        background: transparent;
        border: 2px solid var(--text-color);
        border-radius: 8px;
        color: var(--text-color);
        font-family: 'Dancing Script', serif;
        font-size: 24px;
        cursor: pointer;
        transition: background .3s, color .3s, box-shadow .3s, transform .15s;
        box-shadow: 0 0 8px rgba(201, 169, 89, 0.2);
    }

    .btn-changer:hover {
        background: var(--text-color);
        color: var(--bg-banner);
        box-shadow: 0 0 18px rgba(201, 169, 89, 0.6);
        transform: translateY(-2px);
    }

    .btn-changer:active {
        transform: scale(0.97);
    }

    .retour-lien {
        display: block;
        text-align: center;
        margin-top: 1.4rem;
        font-family: 'Dancing Script', serif;
        font-size: 20px;
        color: #4D3E19;
        text-decoration: none;
        transition: color .25s;
    }

    .retour-lien:hover {
        color: var(--text-color);
    }

    .ornement-separateur {
        text-align: center;
        font-family: 'Dancing Script', serif;
        font-size: 22px;
        color: rgba(201, 169, 89, 0.2);
        letter-spacing: 8px;
        margin: 1.5rem 0 1.2rem;
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
        <div class="changement-wrapper">
            <div class="changement-panel">
 
                <p class="changement-titre">Changer le mot de passe</p>
                <p class="changement-sous-titre">Histori'art · Mon compte</p>
 
                <?php if ($success_message): ?>
                    <div class="alerte alerte-succes"><?= htmlspecialchars($success_message) ?></div>
                <?php elseif ($error_message): ?>
                    <div class="alerte alerte-erreur"><?= htmlspecialchars($error_message) ?></div>
                <?php endif; ?>
 
                <form method="POST" action="">
                    <input type="hidden" name="action" value="changer_mdp">
 
                    <div class="champ-groupe">
                        <label class="champ-label" for="ancien_mdp">Votre ancien mot de passe :</label>
                        <input
                            class="champ-input"
                            type="password"
                            id="ancien_mdp"
                            name="ancien_mdp"
                            placeholder="••••••••"
                            required
                        >
                    </div>
 
                    <div class="ornement-separateur">· · ·</div>
 
                    <div class="champ-groupe">
                        <label class="champ-label" for="nouveau_mdp">Votre nouveau mot de passe :</label>
                        <input
                            class="champ-input"
                            type="password"
                            id="nouveau_mdp"
                            name="nouveau_mdp"
                            placeholder="Ex: JmLelouvre*67"
                            required
                            oninput="evaluerForce(this.value)"
                        >
                        <div class="force-barre">
                            <div class="force-remplissage" id="forceMdp"></div>
                        </div>
                        <p class="champ-indice">Au moins 8 caractères.</p>
                    </div>
 
                    <div class="champ-groupe">
                        <label class="champ-label" for="confirmer_mdp">Confirmer le nouveau mot de passe :</label>
                        <input
                            class="champ-input"
                            type="password"
                            id="confirmer_mdp"
                            name="confirmer_mdp"
                            placeholder="Répétez votre mot de passe"
                            required
                        >
                    </div>
 
                    <button type="submit" class="btn-changer">✦ Mettre à jour</button>
                </form>
 
                <a href="account.php" class="retour-lien">← Retour au compte</a>
 
            </div>
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