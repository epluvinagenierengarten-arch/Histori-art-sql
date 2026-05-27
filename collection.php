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

<style>
.collection-section {
    padding: 2rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2rem;
}

.collection-section h2 {
    font-family: 'Dancing Script', cursive;
    font-size: 2rem;
    color: var(--text-color);
}

.collection-count {
    font-family: 'Dancing Script', cursive;
    font-size: 1.1rem;
    color: rgba(201,168,76,.8);
}

.collection-empty {
    font-family: 'Dancing Script', cursive;
    font-size: 1.2rem;
    color: rgba(201,168,76,.6);
    text-align: center;
    padding: 3rem 1rem;
}

.collection-empty a {
    color: #c9a84c;
    text-decoration: underline;
}

/* Filtres */
.filter-bar {
    display: flex;
    gap: .75rem;
    flex-wrap: wrap;
    justify-content: center;
}

.filter-btn {
    font-family: 'Dancing Script', cursive;
    font-size: 1rem;
    background: transparent;
    border: 1px solid rgba(201,168,76,.35);
    color: rgba(201,168,76,.7);
    padding: .4rem 1.2rem;
    border-radius: 50px;
    cursor: pointer;
    transition: background .2s, color .2s, border-color .2s;
}
.filter-btn:hover,
.filter-btn.active {
    background: rgba(201,168,76,.15);
    border-color: #c9a84c;
    color: #c9a84c;
}

/* Grille */
.cards-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 1.25rem;
    justify-content: center;
    width: 100%;
    max-width: 1000px;
}

.card-item {
    width: 140px;
    border-radius: 12px;
    overflow: hidden;
    background: #faf7f1;
    border: 2px solid rgba(201,168,76,.3);
    display: flex;
    flex-direction: column;
    transition: transform .25s ease, box-shadow .25s ease;
}
.card-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(201,168,76,.25);
}

.card-item img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    display: block;
}

.card-item-placeholder {
    width: 100%;
    height: 160px;
    background: #ede8dc;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
}

.card-item-footer {
    padding: .4rem .5rem;
    background: #faf7f1;
    border-top: 1px solid rgba(201,168,76,.2);
}

.card-item-name {
    font-family: 'Dancing Script', cursive;
    font-size: .78rem;
    color: #8b6914;
    text-align: center;
    display: block;
}

.card-item-collection {
    font-family: 'Dancing Script', cursive;
    font-size: .68rem;
    color: rgba(139,105,20,.6);
    text-align: center;
    display: block;
    margin-top: .1rem;
}

@media (max-width: 600px) {
    .card-item { width: 120px; }
    .card-item img,
    .card-item-placeholder { height: 135px; }
}
</style>
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
        <button style="background:none;border:none;padding:0;cursor:pointer;position:absolute;top:20px;right:275px;width:44px;height:44px;overflow:hidden;flex-shrink:0;" aria-label="Booster" onclick="window.location.href='booster.php'">
            <img src="booster.png" alt="booster" style="width:50px;height:50px;object-fit:contain;display:block;">
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
                <p class="collection-count"><?= count($cartes) ?> carte<?= count($cartes) > 1 ? 's' : '' ?> récoltée<?= count($cartes) > 1 ? 's' : '' ?></p>

                <!-- Filtres par collection -->
                <div class="filter-bar">
                    <button class="filter-btn active" data-filter="all">Toutes</button>
                    <?php foreach (array_unique(array_column($cartes, 'collection')) as $col): ?>
                        <button class="filter-btn" data-filter="<?= htmlspecialchars($col) ?>">
                            <?= htmlspecialchars($collectionLabels[$col] ?? ucfirst($col)) ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <!-- Grille de cartes -->
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
                            <div class="card-item-footer">
                                <span class="card-item-name"><?= htmlspecialchars($carte['nom_carte']) ?></span>
                                <span class="card-item-collection"><?= htmlspecialchars($collectionLabels[$carte['collection']] ?? ucfirst($carte['collection'])) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <section class="newslettersection">
            <p>Interessé par les nouveautés?<br></p>
            <a href="formulaire.html"><p class="newsletterlink">Inscris toi à notre Newsletter!<br></p></a>
        </section>
        <section class="gap"><p> </p></section>
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
        document.querySelectorAll('.card-item').forEach(card => {
            card.style.display = (filter === 'all' || card.dataset.collection === filter) ? '' : 'none';
        });
    });
});
</script>

</body>
</html>