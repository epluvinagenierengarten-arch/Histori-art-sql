<?php
session_start();

if (isset($_SESSION['utilisateur_id'])) {
    header('Location: account.php');
    exit;
}

$erreur = null;
$succes = null;

try {
    $pdo = new PDO('mysql:host=localhost;dbname=historiart', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom               = trim($_POST['nom']);
    $email             = trim($_POST['email']);
    $password          = trim($_POST['password']);
    $password_confirm  = trim($_POST['password_confirm']);
    $date_naissance    = trim($_POST['date_naissance']);
    $newsletter        = isset($_POST['newsletter']) ? 1 : 0;

    // Validations
    if (empty($nom)) {
        $erreur = "Le nom est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Adresse email invalide.";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
        $erreur = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
    } elseif ($password !== $password_confirm) {
        $erreur = "Les mots de passe ne correspondent pas.";
    } elseif (empty($date_naissance)) {
        $erreur = "La date de naissance est requise.";
    } else {
        // Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = :email");
        $stmt->execute([':email' => $email]);
        if ($stmt->fetch()) {
            $erreur = "Un compte avec cette adresse email existe déjà.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("
                INSERT INTO utilisateurs (nom_utilisateur, email, mot_de_passe, date_naissance, newsletter)
                VALUES (:nom, :email, :mot_de_passe, :date_naissance, :newsletter)
            ");
            $stmt->execute([
                ':nom'            => $nom,
                ':email'          => $email,
                ':mot_de_passe'   => $hash,
                ':date_naissance' => $date_naissance,
                ':newsletter'     => $newsletter,
            ]);

            // Connexion automatique après inscription
            $newId = $pdo->lastInsertId();
            $_SESSION['utilisateur_id'] = $newId;
            $_SESSION['email']          = $email;
            $_SESSION['nom_utilisateur'] = $nom;
            header('Location: index.php');
            exit;
        }
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
    <title>Histori'art – Créer un compte</title>
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
        <div class="login-container">

            <div class="login-header">
                <h2>Créer un compte</h2>
                <p>Rejoignez l'univers Histori'art</p>
            </div>

            <?php if ($erreur): ?>
                <div class="message-error"><?= htmlspecialchars($erreur) ?></div>
            <?php endif; ?>

            <form action="" method="POST" class="login-form">

                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input
                        type="text"
                        id="nom"
                        name="nom"
                        placeholder="Votre nom"
                        value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '' ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email :</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="votre.email@exemple.com"
                        value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe :</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Ex: JmLelouvre*67"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password_confirm">Confirmer le mot de passe :</label>
                    <input
                        type="password"
                        id="password_confirm"
                        name="password_confirm"
                        placeholder="Répétez votre mot de passe"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="date_naissance">Date de naissance :</label>
                    <input
                        type="date"
                        id="date_naissance"
                        name="date_naissance"
                        value="<?= isset($_POST['date_naissance']) ? htmlspecialchars($_POST['date_naissance']) : '' ?>"
                        required
                    >
                </div>

                <label class="form-group-check">
                    <input
                        type="checkbox"
                        name="newsletter"
                        id="newsletter"
                        <?= isset($_POST['newsletter']) ? 'checked' : '' ?>
                    >
                    <span>Je souhaite m'inscrire à la newsletter Histori'art</span>
                </label>

                <button type="submit" class="btn-primary">Créer mon compte</button>
            </form>

            <div class="login-section">
                <p>Déjà un compte ?</p>
                <button class="btn-secondary" onclick="window.location.href='login.php'">
                    Se connecter
                </button>
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