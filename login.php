<?php
    session_start();

    if (isset($_SESSION['utilisateur_id'])) {
        header('Location: account.php');
        exit;
    }

    $erreur = null;

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=historiart', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email    = trim($_POST["email"]);
        $password = trim($_POST['password']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erreur = "Email invalide.";
        } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
            $erreur = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
        } else {
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

           if ($user && password_verify($password, $user['mot_de_passe'])) {
                $_SESSION['utilisateur_id']   = $user['id'];
                $_SESSION['email']            = $user['email'];
                $_SESSION['nom_utilisateur']  = $user['nom_utilisateur'];
                header('Location: index.php');
                exit;
            } else {
                $erreur = "Email ou mot de passe incorrect.";
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
    <title>Histori'art – Connexion</title>
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
        <button class="booster-btn" id="booster.btn" aria-label="Profil" onclick="window.location.href='booster.php'"> <!-- localisation de la page-->
            <img src="booster.png" alt="booster" id="busteImg">
        </button>
        <button class="button" id="themeToggle">Mode clair</button>
    </header>

    <main>
        <div class="login-container">

            <div class="login-header">
                <h2>Connexion</h2>
                <p>Accédez à votre espace Histori'art</p>
            </div>

            <?php if ($erreur): ?>
                <div class="message-error"><?= htmlspecialchars($erreur) ?></div>
            <?php endif; ?>

            <form action="" method="POST" class="login-form">
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="votre.email@exemple.com"
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

                <button type="submit" class="btn-primary">Se connecter</button>
            </form>

            <div class="register-section">
                <p>Pas de compte ?</p>
                <button class="btn-secondary" onclick="window.location.href='account_creation.php'">
                    Créez en un maintenant !
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

    <script>
        // Sauvegarde l'email si connexion réussie
        const emailInput = document.getElementById('email');
        const form = document.querySelector('form');

        // Pré-remplir au chargement
        const emailSauvegarde = localStorage.getItem('email_utilisateur');
        if (emailSauvegarde) {
            emailInput.value = emailSauvegarde;
        }

        //save
        form.addEventListener('submit', () => {
            localStorage.setItem('email_utilisateur', emailInput.value);
        });
    </script>

</body>
</html>