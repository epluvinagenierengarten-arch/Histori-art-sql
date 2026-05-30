<?php
session_start();

// 1) Accès réservé aux utilisateurs connectés
if (!isset($_SESSION["utilisateur_id"])) {
    header("Location: login.php");
    exit;
}

// 2) Connexion BDD et récupération des cartes de l'utilisateur
try {
    $pdo = new PDO("mysql:host=localhost;dbname=historiart;charset=utf8", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données.");
}

$utilisateurId = $_SESSION["utilisateur_id"];

$stmt = $pdo->prepare("
    SELECT nom_carte, image_url, collection, date_obtention
    FROM cartes_utilisateurs
    WHERE utilisateur_id = ?
    ORDER BY date_obtention DESC
");
$stmt->execute([$utilisateurId]);
$cartes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$collectionLabels = [
    'louvre'  => 'Musée du Louvre',
    'moma'    => 'MoMA',
    'vangogh' => 'Van Gogh Museum',
];
?>
<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script defer src="main.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    <title>Histori'art ~ Ma collection</title>
</head>

<body class="body">
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
        <section class="collection-section">
            <h2>Ma collection</h2>

            <?php if (empty($cartes)): ?>
                <p class="collection-empty">
                    Tu n'as encore aucune carte.<br>
                    <a href="booster.php">Ouvre ton premier booster !</a>
                </p>
            <?php else: ?>

                <div class="filter-bar">
                    <button class="filter-btn active" data-filter="all">Toutes</button>
                    <button class="filter-btn" data-filter="louvre">Musée du Louvre</button>
                    <button class="filter-btn" data-filter="moma">MoMA</button>
                    <button class="filter-btn" data-filter="vangogh">Van Gogh Museum</button>
                </div>

                <div class="cards-grid" id="cards-grid">
                    <?php foreach ($cartes as $carte): ?>
                        <div class="card-item" data-collection="<?= htmlspecialchars($carte['collection']) ?>">
                            <?php
                                $imgPath = htmlspecialchars($carte['image_url']);
                            ?>
                            <img
                                src="<?= $imgPath ?>"
                                alt="<?= htmlspecialchars($carte['nom_carte']) ?>"
                                onerror="this.outerHTML='<div class=\'card-item-placeholder\'>🖼</div>'"
                            >
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
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
// Filtre par collection
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const filter = btn.dataset.filter;
        let visible = 0;

        document.querySelectorAll('.card-item').forEach(card => {
            const show = filter === 'all' || card.dataset.collection === filter;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        // Affiche le message
        let empty = document.getElementById('empty-msg');
        if (visible === 0) {
            if (!empty) {
                empty = document.createElement('p');
                empty.id = 'empty-msg';
                empty.className = 'collection-empty';
                empty.textContent = 'Il n\'y a rien ici.';
                document.getElementById('cards-grid').after(empty);
            }
            empty.style.display = 'block';
        // APU message
        } else {
            if (empty) empty.style.display = 'none';
        }
    });
});
</script>

</body>
</html>
