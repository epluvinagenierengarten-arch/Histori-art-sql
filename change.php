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