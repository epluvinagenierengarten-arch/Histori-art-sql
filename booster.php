<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');

    if (!isset($_SESSION["utilisateur_id"])) {
        echo json_encode(["error" => "Connecte-toi pour récupérer ton booster."]);
        exit;
    }

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=historiart;charset=utf8", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Erreur de connexion BDD : " . $e->getMessage()]);
        exit;
    }

    $utilisateurId = $_SESSION["utilisateur_id"];

    try {
        $verification = $pdo->prepare("SELECT last_booster FROM utilisateurs WHERE id = ?");
        $verification->execute([$utilisateurId]);
        $data = $verification->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Erreur lecture utilisateur : " . $e->getMessage()]);
        exit;
    }

    if ($data && $data["last_booster"]) {
        $elapsed = time() - strtotime($data["last_booster"]);
        if ($elapsed < 86400) {
            $remaining = 86400 - $elapsed;
            $h = floor($remaining / 3600);
            $m = floor(($remaining % 3600) / 60);
            echo json_encode(["error" => "Reviens dans {$h}h {$m}min pour ton prochain booster !"]);
            exit;
        }
    }

    $booster = $_POST['booster'] ?? 'louvre';

    $collections = [
        'louvre' => [
            ['nom' => 'La Joconde',                  'image' => 'louvre/joconde.png'],
            ['nom' => 'La Vénus de Milo',             'image' => 'louvre/venusDeMilo.png'],
            ['nom' => 'La Victoire de Samothrace',    'image' => 'louvre/victory.png'],
            ['nom' => 'Le Radeau de la Méduse',       'image' => 'louvre/meduse.png'],
            ['nom' => 'La Liberté guidant le peuple', 'image' => 'louvre/liberteguidantlepeuple.png'],
            ['nom' => 'Le Sacre de Napoléon',         'image' => 'louvre/napoleon.png'],
            ['nom' => 'Les Noces de Cana',            'image' => 'louvre/nocedecana.png'],
            ['nom' => 'La Grande Odalisque',          'image' => 'louvre/odalisque.png'],
            ['nom' => 'Psyché ranimée',               'image' => 'louvre/psychée.png'],
            ['nom' => 'Le Serment des Horaces',       'image' => 'louvre/Horaces.png'],
            ['nom' => "Le zodiaque de Dendérah",      'image' => 'louvre/zodiaque.png'],
            ['nom' => 'Portrait de Louis XIV',        'image' => 'louvre/louisXIV.png'],
            ['nom' => 'La diane de Versailles',       'image' => 'louvre/dianedeversailles.png'],
            ['nom' => "L'Homme de Vitruve",           'image' => 'louvre/Vitruve.png'],
            ['nom' => "La belle ferronniere",         'image' => 'louvre/ferronniere.png'],
            ['nom' => 'Scribe accroupi',              'image' => 'louvre/scribe.png'],
        ],
        'moma' => [
            ['nom' => "Les Demoiselles d'Avignon",    'image' => 'moma/demoiselles.jpg'],
            ['nom' => 'La Nuit étoilée',              'image' => 'moma/nuit_etoilee.jpg'],
            ['nom' => "Campbell's Soup Cans",         'image' => 'moma/campbell.jpg'],
            ['nom' => 'Broadway Boogie-Woogie',       'image' => 'moma/broadway.jpg'],
            ['nom' => 'La Ville se lève',             'image' => 'moma/lavilleseleve.png'],
            ['nom' => 'The Persistence of Memory',    'image' => 'moma/persistence.jpg'],
            ['nom' => 'One: Number 31',               'image' => 'moma/pollock.jpg'],
            ['nom' => "Christina's World",            'image' => 'moma/christina.jpg'],
            ['nom' => 'Water Lilies',                 'image' => 'moma/waterlilies.jpg'],
            ['nom' => 'Les Trois Musiciens',          'image' => 'moma/musiciens.jpg'],
            ['nom' => "L'Espoir II",                  'image' => 'moma/hope2.png'],
            ['nom' => 'Les Amants',                   'image' => 'moma/lesamants.png'],
            ['nom' => 'Number 1 (Lavender Mist)',     'image' => 'moma/lavender.jpg'],
            ['nom' => 'Portrait de Gertrude Stein',   'image' => 'moma/stein.jpg'],
            ['nom' => 'Unique Forms',                 'image' => 'moma/unique.jpg'],
            ['nom' => "L'Atelier Rouge",              'image' => 'moma/atelier.jpg'],
        ],
        'vangogh' => [
            ['nom' => 'Les Tournesols',                    'image' => 'vgmus/tournesols.jpg'],
            ['nom' => 'La Chambre à Arles',               'image' => 'vgmus/chambreVG.png'],
            ['nom' => 'Autoportrait',                      'image' => 'vgmus/autoportrait.jpg'],
            ['nom' => 'Les Mangeurs de pommes de terre',   'image' => 'vgmus/pommes.jpg'],
            ['nom' => 'La Terrasse du café',               'image' => 'vgmus/terrasse.jpg'],
            ['nom' => 'Iris',                              'image' => 'vgmus/iris.jpg'],
            ['nom' => 'Champ de blé aux corbeaux',         'image' => 'vgmus/corbeaux.jpg'],
            ['nom' => 'Le Semeur',                         'image' => 'vgmus/semeur.jpg'],
            ['nom' => 'Amandier en fleurs',                'image' => 'vgmus/amandier.png'],
            ['nom' => 'La Berceuse',                       'image' => 'vgmus/berceuse.jpg'],
            ['nom' => 'Le Pêcher',                         'image' => 'vgmus/pecher.png'],
            ['nom' => 'Deux Crustacés',                    'image' => 'vgmus/crustaces.jpg'],
            ['nom' => "La Plaine d'Auvers",                'image' => 'vgmus/plaine.jpg'],
            ['nom' => 'Verger en fleurs',                  'image' => 'vgmus/verger.jpg'],
            ['nom' => 'Chaussures',                        'image' => 'vgmus/chaussures.png'],
            ['nom' => 'Tête de squelette',                 'image' => 'vgmus/squelette.jpg'],
        ],
    ];

    if (!isset($collections[$booster])) {
        echo json_encode(["error" => "Collection inconnue."]);
        exit;
    }

    $cartes = $collections[$booster];
    shuffle($cartes);
    $tirage = array_slice($cartes, 0, 3);

    try {
        $insert = $pdo->prepare("
            INSERT INTO cartes_utilisateurs (utilisateur_id, collection, nom_carte, image_url, date_obtention)
            VALUES (?, ?, ?, ?, NOW())
        ");
        foreach ($tirage as $carte) {
            $insert->execute([$utilisateurId, $booster, $carte['nom'], $carte['image']]);
        }
    } catch (PDOException $e) {
        echo json_encode(["error" => "Erreur insertion cartes : " . $e->getMessage()]);
        exit;
    }

    try {
        $pdo->prepare("UPDATE utilisateurs SET last_booster = NOW() WHERE id = ?")
            ->execute([$utilisateurId]);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Erreur mise à jour last_booster : " . $e->getMessage()]);
        exit;
    }

    echo json_encode(["success" => true, "cartes" => $tirage, "booster" => $booster]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script defer src="main.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    <title>Histori'art ~ Boosters</title>

<style>
.boosters-section {
    padding: 40px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2rem;
}

.boosters-grid {
    display: flex;
    justify-content: center;
    gap: 3rem;
    flex-wrap: wrap;
}

.pack-btn {
    background: none;
    padding: 2px;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    transition: transform 0.35s ease;
}
.pack-btn:hover { 
    transform: translateY(-8px); 
}

.booster-pack {
    width: 200px;
    height: 300px;
    border-radius: 2ppx;
    overflow: hidden;
    transition: box-shadow 0.35s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.booster-louvre .booster-pack {
    box-shadow: 0 10px 40px rgba(201,168,76,.35);
}
.booster-louvre:hover .booster-pack { box-shadow: 0 20px 60px rgba(201,168,76,.6); 
}

.booster-moma .booster-pack {
    box-shadow: 0 10px 40px rgba(160,0,30,.35);
    border: 2px solid rgba(232,0,58,0.35);
}
.booster-moma:hover .booster-pack { box-shadow: 0 20px 60px rgba(232,0,58,0.6); }

.booster-vangogh .booster-pack {
    box-shadow: 0 10px 40px rgba(26,92,122,.35);
    border: 2px solid rgba(26,159,204,.35);
}
.booster-vangogh:hover .booster-pack { box-shadow: 0 20px 60px rgba(26,159,204,.6); }

/* Fallback gradient affiché derrière l'image */
.booster-pack-fallback {
    position: absolute;
    inset: 0;
    border-radius: 14px;
    z-index: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: .5rem;
}
.booster-louvre  .booster-pack-fallback { background: linear-gradient(160deg, #1a1200, #8b6914, #c9a84c); }
.booster-moma    .booster-pack-fallback { background: linear-gradient(160deg, #140002, #aa0022, #e8003a); }
.booster-vangogh .booster-pack-fallback { background: linear-gradient(160deg, #000d14, #0a6a96, #1a9fcc); }
.booster-pack-fallback img  { width: 70px; height: 70px; object-fit: contain; filter: brightness(1.1); }
.booster-pack-fallback span { font-family: 'Dancing Script', cursive; font-size: .95rem; color: rgba(255,255,255,.85); text-align: center; }

/* L'image du booster passe au-dessus du fallback */
.booster-pack-img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 1;
    border-radius: 14px;
}

.booster-label {
    font-family: 'Dancing Script';
    font-size: 42 px;
    color: var(--text-color);
}

.msg-bar {
    display: none;
    max-width: 500px;
    padding: 1rem 1.5rem;
    border-radius: 10px;
    font-family: 'Dancing Script';
    font-size: 1.1rem;
    text-align: center;
    margin: 0 auto;
}
.msg-bar--cooldown { 
background: rgba(201,168,76,.1); 
border: 1px solid rgba(201,168,76,.35); color: #c9a84c; 
}

.msg-bar--error    { 
background: rgba(160,0,30,.1);   
border: 1px solid rgba(160,0,30,.4);   
color: #e87070; 
}

#overlay {
    position: fixed;
    inset: 0;
    background: rgba(5,4,2,.93);
    z-index: 200;
    display: none;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 2rem;
    padding: 2rem;
}

#overlay.active { 
display: flex; 
}

#loading { display: none; flex-direction: column; align-items: center; gap: 1rem; }

.spinner-ring {
    width: 48px; height: 48px;
    border: 2px solid rgba(201,168,76,.3);
    border-top-color: #c9a84c;
    border-radius: 50%;
    animation: spin .9s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

.loading-text {
    font-family: 'Dancing Script', cursive;
    font-size: 1.1rem;
    color: #c9a84c;
}

#result { display: none; flex-direction: column; align-items: center; gap: 1.5rem; }

.overlay-title {
    font-family: 'Dancing Script', cursive;
    font-size: 2rem;
    color: #c9a84c;
    text-align: center;
}

.cards-reveal { display: flex; gap: 1.5rem; flex-wrap: wrap; justify-content: center; }
.card-slot { perspective: 900px; }

.card-flip {
    width: 150px; height: 225px;
    position: relative;
    transform-style: preserve-3d;
    transition: transform .8s ease;
    cursor: pointer;
}
.card-slot:nth-child(2) .card-flip { transition-delay: .25s; }
.card-slot:nth-child(3) .card-flip { transition-delay: .5s;  }
.card-flip.flipped { transform: rotateY(180deg); }

.card-face {
    position: absolute;
    inset: 0;
    border-radius: 12px;
    backface-visibility: hidden;
    overflow: hidden;
}
.card-back {
    background: #faf7f1;
    border: 2px solid rgba(201,168,76,.4);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Dancing Script', cursive;
    font-size: 2.5rem;
    color: rgba(201,168,76,.35);
}
.card-front {
    transform: rotateY(180deg);
    background: #faf7f1;
    border: 2px solid #c9a84c;
    display: flex;
    flex-direction: column;
}
.card-front-img { width: 100%; flex: 1; object-fit: cover; display: block; }
.card-front-footer { padding: .4rem .6rem; background: #faf7f1; border-top: 1px solid rgba(201,168,76,.2); }
.card-front-name { font-family: 'Dancing Script', cursive; font-size: .75rem; color: #8b6914; text-align: center; }

.flip-hint { font-family: 'Dancing Script', cursive; font-size: 1rem; color: rgba(201,168,76,.6); }

#close-overlay {
    font-family: 'Dancing Script', cursive;
    font-size: 1.1rem;
    color: #c9a84c;
    background: transparent;
    border: 1px solid rgba(201,168,76,.4);
    padding: .6rem 2rem;
    border-radius: 50px;
    cursor: pointer;
}
#close-overlay:hover { background: rgba(201,168,76,.1); }

@media (max-width: 600px) {
    .boosters-grid { gap: 1.5rem; }
    .booster-pack  { width: 150px; height: 230px; }
    .card-flip     { width: 120px; height: 180px; }
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
        <button style="background:none;border:none;padding:0;cursor:pointer;position:absolute;top:20px;right:275px;width:44px;height:44px;overflow:hidden;flex-shrink:0;" aria-label="Booster" onclick="window.location.href='booster.php'">
            <img src="booster.png" alt="booster" style="width:50px;height:50px;object-fit:contain;display:block;">
        </button>
        <button class="button" id="themeToggle">Mode clair</button>
    </header>

<main>
    <div id="not-logged"   class="msg-bar msg-bar--error"></div>
    <div id="cooldown-msg" class="msg-bar msg-bar--cooldown"></div>

    <section class="boosters-section">
        <h2>Choisissez votre collection</h2>

        <div class="boosters-grid">

            <button class="pack-btn booster-louvre" data-booster="louvre">
                <div class="booster-pack">
                    <div class="booster-pack-fallback">
                        <img src="logoLouvre.png" alt="">
                        <span>Musée du Louvre</span>
                    </div>
                    <img class="booster-pack-img" src="booster_louvre.png" alt="Booster Louvre" onerror="this.style.display='none'">
                </div>
                <span class="booster-label">Louvre</span>
            </button>

            <button class="pack-btn booster-moma" data-booster="moma">
                <div class="booster-pack">
                    <div class="booster-pack-fallback">
                        <img src="LogoMoMA.jpg" alt="">
                        <span>MoMA</span>
                    </div>
                    <img class="booster-pack-img" src="booster_moma.png" alt="Booster MoMA" onerror="this.style.display='none'">
                </div>
                <span class="booster-label">MoMA</span>
            </button>

            <button class="pack-btn booster-vangogh" data-booster="vangogh">
                <div class="booster-pack">
                    <div class="booster-pack-fallback">
                        <img src="logoVanGogh.jpg" alt="">
                        <span>Van Gogh Museum</span>
                    </div>
                    <img class="booster-pack-img" src="booster_vg.png" alt="Booster Van Gogh" onerror="this.style.display='none'">
                </div>
                <span class="booster-label">Van Gogh</span>
            </button>

        </div>
    </section>
</main>

<div id="overlay">
    <div id="loading">
        <div class="spinner-ring"></div>
        <span class="loading-text">Tirage en cours…</span>
    </div>
    <div id="result">
        <h3 class="overlay-title" id="result-title"></h3>
        <p class="flip-hint">Clique sur chaque carte pour la retourner</p>
        <div class="cards-reveal" id="cards-reveal"></div>
        <button id="close-overlay">Fermer</button>
    </div>
</div>

<footer class="footer">
    <div class="imagefooter"><img src="carte.png" alt="carte"></div>
    <div class="textfooter">Tous droits de reproduction et de diffusion réservés © 2025 Histori'art</div>
</footer>

<script>
(function () {
    const overlay     = document.getElementById('overlay');
    const loadingEl   = document.getElementById('loading');
    const resultEl    = document.getElementById('result');
    const cardsReveal = document.getElementById('cards-reveal');
    const resultTitle = document.getElementById('result-title');
    const cooldownMsg = document.getElementById('cooldown-msg');
    const notLoggedEl = document.getElementById('not-logged');

    const museumNames = { louvre: 'Louvre', moma: 'MoMA', vangogh: 'Van Gogh Museum' };

    document.querySelectorAll('.pack-btn[data-booster]').forEach(btn =>
        btn.addEventListener('click', () => openBooster(btn.dataset.booster))
    );

    document.getElementById('close-overlay').addEventListener('click', closeOverlay);
    overlay.addEventListener('click', e => { if (e.target === overlay) closeOverlay(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeOverlay(); });

    function openBooster(booster) {
        cooldownMsg.style.display = notLoggedEl.style.display = 'none';
        overlay.classList.add('active');
        loadingEl.style.display = 'flex';
        resultEl.style.display  = 'none';

        const fd = new FormData();
        fd.append('action', 'open');
        fd.append('booster', booster);

        fetch('booster.php', { method: 'POST', body: fd })
            .then(r => {
                const ct = r.headers.get('content-type') || '';
                if (!ct.includes('application/json')) {
                    return r.text().then(t => { throw new Error(t.substring(0, 300)); });
                }
                return r.json();
            })
            .then(data => {
                loadingEl.style.display = 'none';

                if (data.error) {
                    closeOverlay();
                    const el = data.error.toLowerCase().includes('connecte') ? notLoggedEl : cooldownMsg;
                    el.textContent = data.error;
                    el.style.display = 'block';
                    return;
                }

                resultTitle.textContent = museumNames[data.booster] || 'Booster';
                cardsReveal.innerHTML = '';

                data.cartes.forEach(carte => {
                    const slot = document.createElement('div');
                    slot.className = 'card-slot';

                    const flip = document.createElement('div');
                    flip.className = 'card-flip';
                    flip.tabIndex = 0;

                    const back = document.createElement('div');
                    back.className = 'card-face card-back';
                    back.textContent = '✦';

                    const front = document.createElement('div');
                    front.className = 'card-face card-front';

                    const img = document.createElement('img');
                    img.className = 'card-front-img';
                    img.src = carte.image;
                    img.alt = carte.nom;
                    img.onerror = function () {
                        this.replaceWith(Object.assign(document.createElement('div'), {
                            className: 'card-front-img',
                            style: 'background:#ede8dc;display:flex;align-items:center;justify-content:center;font-size:2rem;',
                            textContent: '🖼'
                        }));
                    };

                    const footer = document.createElement('div');
                    footer.className = 'card-front-footer';
                    footer.innerHTML = `<div class="card-front-name">${carte.nom}</div>`;

                    front.appendChild(img);
                    front.appendChild(footer);
                    flip.appendChild(back);
                    flip.appendChild(front);
                    slot.appendChild(flip);
                    cardsReveal.appendChild(slot);

                    flip.addEventListener('click', () => flip.classList.toggle('flipped'));
                    flip.addEventListener('keydown', e => {
                        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); flip.classList.toggle('flipped'); }
                    });
                });

                resultEl.style.display = 'flex';
            })
            .catch(err => {
                loadingEl.style.display = 'none';
                closeOverlay();
                cooldownMsg.textContent  = 'Erreur : ' + err.message;
                cooldownMsg.style.display = 'block';
            });
    }

    function closeOverlay() {
        overlay.classList.remove('active');
        document.querySelectorAll('.card-flip').forEach(c => c.classList.remove('flipped'));
    }
})();
</script>

</body>
</html>