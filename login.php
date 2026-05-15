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

    <style>
        .login-container {
            background: var(--bg-section-light);
            border-radius: 12px;
            max-width: 520px;
            width: 100%;
            padding: 50px 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            animation: fadeSlideIn 0.6s ease forwards;
        }

        [data-theme="light"] .login-container {
            background: #060404;
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
            border-bottom: 2px solid rgba(201, 169, 89, 0.3);
            padding-bottom: 24px;
        }

        .login-header h2 {
            font-size: 42px;
            color: var(--text-color);
            margin-bottom: 8px;
            font-weight: 700;
        }

        .login-header p {
            font-size: 15px;
            color: rgba(201, 169, 89, 0.6);
            letter-spacing: 0.04em;
            margin: 0;
        }

        .message-error {
            background-color: rgba(212, 42, 0, 0.15);
            border-left: 4px solid rgb(212, 42, 0);
            color: rgb(212, 42, 0);
            padding: 14px 18px;
            border-radius: 0 8px 8px 0;
            margin-bottom: 20px;
            font-size: 14px;
            line-height: 1.6;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            display: block;
            color: var(--text-color);
            font-weight: 700;
            font-size: 17px;
            letter-spacing: 0.02em;
            font-family: 'Dancing Script', sans-serif;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 13px 16px;
            border: 2px solid rgba(201, 169, 89, 0.3);
            border-radius: 8px;
            font-size: 15px;
            font-family: 'Dancing Script', serif;
            background: var(--bg-section-light);
            color: var(--text-color);
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        [data-theme="light"] input[type="email"],
        [data-theme="light"] input[type="password"] {
            background: #e9e9e9;
            color: #060404;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: var(--text-color);
            box-shadow: 0 0 0 4px rgba(201, 169, 89, 0.15);
        }

        .btn-primary {
            padding: 15px 32px;
            background: linear-gradient(135deg, #b78917 0%, #8b6914 100%);
            color: #060404;
            border: 2px solid var(--text-color);
            border-radius: 8px;
            font-size: 18px;
            font-weight: 700;
            font-family: 'Dancing Script', serif;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 6px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-secondary {
            padding: 13px 32px;
            background: transparent;
            color: var(--text-color);
            border: 1px solid rgba(201, 169, 89, 0.35);
            border-radius: 8px;
            font-size: 17px;
            font-weight: 700;
            font-family: 'Dancing Script', serif;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-secondary:hover {
            border-color: var(--text-color);
            background: rgba(201, 169, 89, 0.08);
        }

        .register-section {
            text-align: center;
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid rgba(201, 169, 89, 0.15);
        }

        .register-section p {
            font-size: 15px;
            color: rgba(201, 169, 89, 0.6);
            margin: 0 0 12px;
            font-family: 'Dancing Script', sans-serif;
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

</body>
</html>