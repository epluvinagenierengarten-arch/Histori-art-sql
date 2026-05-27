<?php
//inserer l'API
$API_KEY = "8ba62b36e17b48d0ae98cd220471ebd7";

$cacheFile = __DIR__ . '/cache_carte_mois.json';
$cacheValid = file_exists($cacheFile) && (time() - filemtime($cacheFile) < 2629800);

if ($cacheValid) {
    $artOfmounth = json_decode(file_get_contents($cacheFile), true);
} else {
    $ctx = stream_context_create(['http' => ['timeout' => 5]]);
    $raw = @file_get_contents(
        "https://api.artsearch.io/artworks/random?api-key={$API_KEY}",
        false, $ctx
    );
    $artOfmounth = $raw ? json_decode($raw, true) : null;
    if ($artOfmounth) {
        file_put_contents($cacheFile, json_encode($artOfmounth));
    }
}

// Rareté aléatoire pour la carte du mois
$raretés = [
    ['label' => '✨ Légendaire', 'color' => '#f4d03f', 'glow' => 'rgba(244,208,63,0.5)'],
    ['label' => '🟣 Maître',     'color' => '#9b59b6', 'glow' => 'rgba(186, 118, 210, 0.4)'],
    ['label' => '🔵 Rare',       'color' => '#2ca1c5', 'glow' => 'rgba(46, 87, 112, 0.77)'],
    ['label' => '🟢 Commune',     'color' => '#0ee22a', 'glow' => 'rgba(115, 149, 123, 0.4)'],
];
$rareté = $raretés[array_rand($raretés)];
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    <title>Histori'art</title>

    <style>
        /*API*/

        /*visu carte*/
        .carte-api-card {
            width: 260px;
            flex-shrink: 0;
            background: #faf7f1;
            border-radius: 18px;
            overflow: hidden;
            border: 2px solid <?= $rareté['color'] ?>;
            box-shadow:
                0 0 30px <?= $rareté['glow'] ?>,
                0 20px 50px rgba(0,0,0,0.4);
            animation: floatCard 3.5s ease-in-out infinite;
            position: relative;
        }

        /*badge commun rare epique ou legendaire en fonction de la rareté*/
        .carte-api-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: <?= $rareté['color'] ?>;
            color: #111;
            font-family: sans-serif;
            font-size: 10px;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 20px;
            letter-spacing: .05em;
            z-index: 2;
        }

        /*info rareté avec couleur qui change*/
        .carte-api-info-rarety {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Dancing Script', cursive;
            font-size: 18px;
            color: <?= $rareté['color'] ?>;
        }

        /*Bandeau 1*/

        .bandeau1 {
            background: var(--bg-section-dark);
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: stretch;
            width: 100%;
            gap: 0;
            flex-wrap: wrap;
                border-top:2px solid #a78014a1;
            border-bottom:2px solid #a78014a1;
        }

        .image11, .image21, .image31 {
            flex: 1;
            display: flex;
            flex-direction: column;
            border-left: 1px solid rgba(201, 169, 89, 0.15);
            transition: background 0.3s ease;
        }

        .image11 { border-left: none; }

        .image11:hover, .image21:hover, .image31:hover {
            background: rgba(201, 169, 89, 0.04);
        }

        .image11 img, .image21 img, .image31 img {
            width: 100%;
            height: 400px;
            object-fit: contain;
            display: block;
        }

        .image11::before { content: '01'; }
        .image21::before { content: '02'; }
        .image31::before { content: '03'; }

        .image11::before, .image21::before, .image31::before {
            font-family: 'Dancing Script', sans-serif;
            font-size: 64px;
            color: rgba(201, 169, 89, 0.35);
            padding: 20px 22px 0;
            line-height: 1;
            display: block;
        }

        .image11 p, .image21 p, .image31 p {
            padding: 14px 22px 28px;
            font-size: 15px;
            line-height: 1.65;
            text-align: left;
            flex: 1;
        }

        .bandeau1-texte {
            width: 100%;
            padding: 30px 60px 40px;
            border-top: 1px solid rgba(201, 169, 89, 0.15);
        }

        .bandeau1-texte p {
            font-family: 'Dancing Script', serif;
            font-size: 17px;
            color: var(--text-color);
            line-height: 1.9;
            text-align: center;
        }

        .bandeau1 p {
            text-align: center;
            font-size: 24px;
        }

        /*Bandeau 2*/

    .bandeau2 {
        background: white;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        min-height: 520px;
        width: 100%;
        padding: 70px 80px;
        gap: 60px;
        overflow: hidden;
        position: relative;
        border-top:2px solid #a78014a1;
        border-bottom:2px solid #a78014a1;
    }

    .bandeau2::before {
        content: '';
        position: absolute;
        left: 180px;
        top: 50%;
        transform: translateY(-50%);
        width: 420px;
        height: 420px;
        background: radial-gradient(ellipse, rgba(185,146,59,0.07) 0%, transparent 70%);
        pointer-events: none;
    }

    .cards-stage {
        position: relative;
        width: 380px;
        height: 440px;
        flex-shrink: 0;
        z-index: 1;
    }

    .card {
        position: absolute;
        width: 220px;
        border-radius: 16px;
        overflow: hidden;
        cursor: pointer;
        transition:
            transform 0.55s cubic-bezier(0.34, 1.3, 0.64, 1),
            opacity   0.45s ease,
            box-shadow 0.45s ease,
            filter 0.45s ease;
        will-change: transform, opacity;
        transform-origin: bottom center;
    }

    .card--far {
        top: 40px; left: 0px;
        z-index: 1;
        transform: perspective(800px) rotateY(-18deg) scale(0.78);
        opacity: 0.45;
        filter: brightness(0.75);
        border: 1px solid rgba(185, 146, 59, 0.2);
        box-shadow: none;
    }

    .card--mid {
        top: 20px; left: 60px;
        z-index: 2;
        transform: perspective(800px) rotateY(-10deg) scale(0.88);
        opacity: 0.7;
        filter: brightness(0.9);
        border: 1px solid rgba(185, 146, 59, 0.3);
        box-shadow: 4px 8px 30px rgba(185,146,59,0.12);
    }

    .card--front {
        top: 0px; left: 140px;
        z-index: 3;
        transform: perspective(800px) rotateY(0deg) scale(1);
        opacity: 1;
        filter: brightness(1);
        border: 1px solid rgba(185, 146, 59, 0.45);
        box-shadow:
            0 20px 50px rgba(185,146,59,0.18),
            0 4px 16px rgba(0,0,0,0.1),
            inset 0 1px 0 rgba(255,255,255,0.8);
    }

    .card--far:hover  { 
        opacity: 0.6;  
        filter: brightness(0.85); 
    }

    .card--mid:hover  { 
        opacity: 0.85; 
        filter: brightness(0.95); 
    }

    .card--front:hover {
        transform: perspective(800px) rotateY(0deg) scale(1.02) translateY(-4px);
        box-shadow: 0 28px 60px rgba(185,146,59,0.25), 0 4px 20px rgba(0,0,0,0.12);
    }

    .card-inner {
    display: flex;
    flex-direction: column;
    background: #faf7f1;
    height: 100%;
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 10px;
        background: rgba(185, 146, 59, 0.06);
        border-bottom: 1px solid rgba(185, 146, 59, 0.12);
    }

    .card-badge {
        font-size: 9px;
        font-family: sans-serif;
        font-weight: 700;
        color: #999;
        background: #eee;
        padding: 2px 5px;
        border-radius: 3px;
        letter-spacing: .05em;
    }

    .card-title-text {
        font-family: 'Dancing Script', serif;
        font-size: 13px;
        color: #8b6914;
        flex: 1;
    }

    .card-icon { font-size: 14px; }

    .card-image {
        width: 100%;
        height: 100%;
        overflow: hidden;
        background: #ede8dc;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .card-desc {
        padding: 10px 12px;
        flex: 1;
        border-bottom: 1px solid rgba(185, 146, 59, 0.1);
    }

    .card-desc p {
        font-family: 'Dancing Script', serif;
        font-size: 11px;
        color: #9a7d40;
        line-height: 1.55;
        text-align: left;
    }

    .card-footer {
        display: flex;
        gap: 6px;
        padding: 8px 10px;
    }

    .card-btn {
        flex: 1;
        padding: 5px 0;
        font-family: sans-serif;
        font-size: 10px;
        color: #999;
        background: white;
        border: 1px solid #ddd;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.2s, color 0.2s;
    }

    .card-btn:hover {
        background: #f5f0e8;
        color: #8b6914;
    }

    .bandeau2-text {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 22px;
        z-index: 1;
    }

    .bandeau2-eyebrow {
        font-family: 'Dancing Script', serif;
        font-size: 14px;
        color: rgba(185, 146, 59, 0.5);
        letter-spacing: .14em;
        text-align: left;
    }

    .bandeau2-title {
        font-family: 'Dancing Script', serif;
        font-size: 52px;
        color: #b9923b;
        text-align: left;
        line-height: 1.1;
        font-weight: 700;
    }

    .bandeau2-body {
        font-family: 'Dancing Script', serif;
        font-size: 18px;
        color: rgba(139, 105, 20, 0.8);
        line-height: 1.85;
        text-align: left;
    }

    .bandeau2-dots {
        display: flex;
        gap: 10px;
        margin-top: 8px;
    }

    .dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        border: none;
        background: rgba(185, 146, 59, 0.2);
        cursor: pointer;
        transition: background 0.3s, transform 0.3s;
        padding: 0;
    }

    .dot--active {
        background: rgba(185, 146, 59, 0.75);
        transform: scale(1.35);
    }

    .image12 { display: none; }
    .texte12 { display: none; }





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
        <button class="booster-btn" id="booster.btn" aria-label="Profil" onclick="window.location.href='booster.php'">
            <img src="booster.png" alt="booster" id="busteImg">
        </button>
        <button class="button" id="themeToggle">Mode clair</button>
    </header>

    <main>

        <!--Carousel-->
        <div class="bandeau2">
            <div class="cards-stage">
                <div class="card card--far" data-index="2">
                    <div class="card-inner">
                        <div class="card-image">
                            <img src="louvre/joconde.png" alt="joconde">
                        </div>
                    </div>
                </div>
                <div class="card card--mid" data-index="1">
                    <div class="card-inner">
                        <div class="card-image">
                            <img src="vgmus/pecher.png" alt="pecher VG">
                        </div>
                    </div>
                </div>
                <div class="card card--front card--active" data-index="0">
                    <div class="card-inner">
                        <div class="card-image">
                            <img src="moma/lavilleseleve.png" alt="La Ville se lève">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bandeau2-text">
                <h3 class="bandeau2-title">✦ Collection exclusive à chaque musée ✦</h3>
                <p class="bandeau2-body">
                    Les joueurs constituent leur galerie virtuelle en acquérant des cartes illustrées
                    avec une fidélité exceptionnelle, détaillant l'œuvre, l'artiste et son contexte historique.<br>
                    Au-delà de la collection, le jeu propose des duels où les cartes s'affrontent selon leur influence,
                    leur technique ou leur rareté.<br>L'objectif est de compléter les séries spécifiques à chaque institution
                    pour devenir le conservateur le plus prestigieux.<br>Alliant culture et stratégie,
                    Histori'art offre une exploration ludique et éducative de l'histoire de l'art,
                    idéale pour les passionnés comme pour les curieux souhaitant voyager à travers les plus beaux musées du monde.
                </p>
                <div class="bandeau2-dots">
                    <button class="dot dot--active" data-target="0"></button>
                    <button class="dot" data-target="1"></button>
                    <button class="dot" data-target="2"></button>
                </div>
            </div>
        </div>

        <!--Bandeau 1 -->
        <div class="bandeau1">
            <div class="image11">
                <img src="louvre/Vitruve.png" alt="vitruve leonard de vinci">
                <p>Apprenez en collectionnant : <br> chaque carte raconte une histoire, avec des anecdotes,
                    des dates clés et des explications accessibles à tous</p>
            </div>
            <div class="image21">
                <img src="vgmus/chambreVG.png" alt="chambreVG">
                <p>Collectionnez et échangez : <br> bâtissez votre galerie personnelle, complétez vos séries
                    et partagez votre passion avec d'autres amateurs d'art.</p>
            </div>
            <div class="image31">
                <img src="moma/lesamants.png" alt="les amants">
                <p>Voyagez dans le temps et l'espace : <br> laissez-vous guider par les grands maîtres
                    et explorez la richesse culturelle qui a façonné notre monde.</p>
            </div>
        </div>

        <!-- API: carte mystère -->
        <div class="carte-du-mois-section">
            <h2 class="carte-du-mois-title">✦ Carte mystère du mois✦</h2>
            <p class="carte-du-mois-subtitle">Une nouvelle œuvre vous est révélée chaque mois, et vous est offerte pour tout achat de cartes Histori'art </p>

            <?php if ($artOfmounth && isset($artOfmounth['title'])): ?>
                <div class="carte-api-wrapper">

                    <!-- La carte -->
                    <div class="carte-api-card">
                        <div class="carte-api-badge"><?= $rareté['label'] ?></div>
                        <?php if (!empty($artOfmounth['image'])): ?>
                            <!-- Récupère image et titre de l'oeuvre -->
                            <img
                                class="carte-api-img"
                                src="<?= htmlspecialchars($artOfmounth['image']) ?>"    
                                alt="<?= htmlspecialchars($artOfmounth['title']) ?>"
                                loading="lazy"
                            >
                        <!-- message d'erreur -->
                        <?php else: ?>
                            <div class="carte-api-img-placeholder">Image non disponible</div>
                        <?php endif; ?>
                        <!--infos de la carte (nom, date, ...)-->
                        <div class="carte-api-body">
                            <div class="carte-api-nom"><?= htmlspecialchars($artOfmounth['title']) ?></div>
                            <?php if (!empty($artOfmounth['start_date'])): ?>
                                <div class="carte-api-dates">
                                    <?= $artOfmounth['start_date'] ?>
                                    <?= !empty($artOfmounth['end_date']) && $artOfmounth['end_date'] !== $artOfmounth['start_date']
                                        ? ' – ' . $artOfmounth['end_date'] : '' ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Panneau descriptif -->
                    <div class="carte-api-info">
                        <div class="carte-api-info-label">✦ Œuvre du mois ✦</div>
                        <div class="carte-api-info-titre"><?= htmlspecialchars($artOfmounth['title']) ?></div>
                        
                        <!--check si date ok-->
                        <?php if (!empty($artOfmounth['start_date'])): ?>
                            <div style="font-family:'Dancing Script';font-size:16px;color:rgba(243, 227, 185, 0.7);">
                                <?= $artOfmounth['start_date'] ?>
                                <?= (!empty($artOfmounth['end_date']) && $artOfmounth['end_date'] !== $artOfmounth['start_date'])
                                    ? ' – ' . $artOfmounth['end_date'] : '' ?>
                            </div>
                        <?php endif; ?>

                        <!--check si description ok-->
                        <?php if (!empty($artOfmounth['description'])): ?>
                            <div class="carte-api-info-desc">
                                <?= htmlspecialchars(
                                    mb_substr($artOfmounth['description'], 0, 350) .
                                    (mb_strlen($artOfmounth['description']) > 350 ? '…' : '')
                                ) ?>
                            </div>
                        <?php endif; ?>

                        <!--Indique la rareté-->
                        <div class="carte-api-info-rarety"><?= $rareté['label'] ?></div>

                        <!--le bouton-->

                        <a href="annexe.php" style="
                            font-family:'Dancing Script';
                            font-size:22px;
                            color:var(--text-color);
                            border:1px solid rgba(243, 227, 185, 0.7);
                            padding:10px 24px;
                            border-radius:10px;
                            display:inline-block;
                            text-decoration:none;
                            transition:background 0.2s;
                            margin-top:8px;"
                        >Voir toutes les cartes existantes →</a>
                    </div>

                </div>
            
            <!--Si ça focntione pas-->
            <?php else: ?>
                <div class="carte-api-error">
                    Impossible de charger la carte.<br>
                    <small style="font-size:14px;">erreur</small>
                </div>
            <?php endif; ?>

            <div class="divider-ornement">✦ ✦ ✦</div>
        </div>

        <!--musées-->
        <div class="intermédiaire1">
            <h4>Les musées</h4>
        </div>

        <section class="carte-box">
            <div class="carte-container">
                <div class="galerie">
                    <div class="carte tab-card">
                        <a href="moma_resized.jpg" class="glightbox" type="image"
                           data-description="Le Museum of Modern Art (MoMA), inauguré en 1929, est situé dans le quartier de Midtown à Manhattan, New York.">
                            <img src="moma_resized.jpg" alt="MoMA">
                        </a>
                    </div>
                    <div class="carte tab-card">
                        <a href="louvre_resized.jpg" class="glightbox" type="image"
                           data-description="Le musée du Louvre est le plus grand musée d'art du monde avec 72 735 m² de salles et galeries, situé dans le 1er arrondissement de Paris.">
                            <img src="louvre_resized.jpg" alt="Louvre">
                        </a>
                    </div>
                    <div class="carte tab-card">
                        <a href="vangogh_resized.jpg" class="glightbox" type="image"
                           data-description="Le musée Van Gogh, fondé en 1973, est situé à Amsterdam et principalement consacré au peintre néerlandais Vincent van Gogh.">
                            <img src="vangogh_resized.jpg" alt="VGmuseum">
                        </a>
                    </div>
                </div>
            </div>

            <!--Les raretés-->
            <div class="intermédiaire">
                <h4>Les raretés</h4>
            </div>

            <div class="bandeau3">
                <div class="image13">
                    <img src="vgmus/amandier.png" alt="amandier en fleur">
                    <p>Communes 🟢 <br>
                        Cartes communes qui présentent des œuvres majeures.
                        Faciles à obtenir, elles constituent la base de votre collection.
                    </p>
                </div>
                <div class="image23">
                    <img src="louvre/napoleon.png" alt="Le sacre de napoleon">
                    <p>Rares 🔵 <br>
                        Cartes un peu plus difficiles à trouver,
                        mettant en avant des œuvres emblématiques ou des artistes incontournables.
                    </p>
                </div>
                <div class="image33">
                    <img src="moma/hope2.png" alt="L'espoir II">
                    <p>Maître 🟣<br>
                        Cartes rares, souvent en édition limitée,
                        qui révèlent des chefs-d'œuvre universels ou des pièces essentielles.
                    </p>
                </div>
                <div class="image43">
                    <img src="vgmus/chaussures.png" alt="Chaussures de Van gogh">
                    <p>Légendaires ✨ <br>
                        Cartes ultra-rares, véritables trésors de collection.
                        Elles célèbrent des œuvres qui ont marqué durablement l'imaginaire collectif.
                    </p>
                </div>
            </div>

            <div class="lien">
                <a href="annexe.php">Lien vers les autres cartes</a>
            </div>
        </section>

    </main>

    <footer id="pagefooter" class="footer">
        <div class="imagefooter">
            <img src="carte.png" alt="carte">
        </div>
        <div class="textfooter">
            Tous droits de reproduction et de diffusion réservés © 2025 Histori'art
        </div>
        <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
        <script>
            const lightbox = GLightbox({
                selector: '.glightbox',
                loop: true,
                openEffect: 'zoom',
                descPosition: 'bottom'
            });
        </script>
    </footer>
</body>
</html>