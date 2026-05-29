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

    $verification = $pdo->prepare("SELECT TIMESTAMPDIFF(SECOND, last_booster, NOW()) AS elapsed FROM utilisateurs WHERE id = ?");
    $verification->execute([$utilisateurId]);
    $data = $verification->fetch(PDO::FETCH_ASSOC);

    if ($data && $data["elapsed"] !== null && $data["elapsed"] < 86400) {
        $remaining = 86400 - $data["elapsed"];
        $h = floor($remaining / 3600);
        $m = floor(($remaining % 3600) / 60);
        echo json_encode(["error" => "Reviens dans {$h}h {$m}min pour ton prochain booster !"]);
        exit;
    }

    $booster = $_POST['booster'] ?? 'louvre';

    $collections = [
        'louvre' => [
            ['image' => 'louvre/joconde.png'],
            ['image' => 'louvre/venusDeMilo.png'],
            ['image' => 'louvre/victory.png'],
            ['image' => 'louvre/meduse.png'],
            ['image' => 'louvre/libertéguidantlepeuple.png'],
            ['image' => 'louvre/napoleon.png'],
            ['image' => 'louvre/nocedecana.png'],
            ['image' => 'louvre/odalisque.png'],
            ['image' => 'louvre/psychée.png'],
            ['image' => 'louvre/Horaces.png'],
            ['image' => 'louvre/zodiaque.png'],
            ['image' => 'louvre/louisXIV.png'],
            ['image' => 'louvre/dianedeversailles.png'],
            ['image' => 'louvre/Vitruve.png'],
            ['image' => 'louvre/ferronniere.png'],
            ['image' => 'louvre/scribe.png'],
        ],
        'moma' => [
            ['image' => 'moma/avignon.png'],
            ['image' => 'moma/boat.png'],
            ['image' => 'moma/bohemienne.png'],
            ['image' => 'moma/catalan.png'],
            ['image' => 'moma/lavilleseleve.png'],
            ['image' => 'moma/chatetoiseau.png'],
            ['image' => 'moma/familykhalo.png'],
            ['image' => 'moma/fingerman.png'],
            ['image' => 'moma/frida.png'],
            ['image' => 'moma/memoiredali.png'],
            ['image' => 'moma/hope2.png'],
            ['image' => 'moma/lesamants.png'],
            ['image' => 'moma/mirroirmagritte.png'],
            ['image' => 'moma/nuiteloilee.png'],
            ['image' => 'moma/pontmonet.png'],
            ['image' => 'moma/woman.png'],
        ],
        'vangogh' => [
            ['image' => 'vgmus/amandier.png'],
            ['image' => 'vgmus/chambreVG.png'],
            ['image' => 'vgmus/autoportraitChevalet.png'],
            ['image' => 'vgmus/chaussures.png'],
            ['image' => 'vgmus/corbeaux.png'],
            ['image' => 'vgmus/feutre.png'],
            ['image' => 'vgmus/gauguin.png'],
            ['image' => 'vgmus/iris.png'],
            ['image' => 'vgmus/maisonjaune.png'],
            ['image' => 'vgmus/moisson.png'],
            ['image' => 'vgmus/pecher.png'],
            ['image' => 'vgmus/paysagepluie.png'],
            ['image' => 'vgmus/racinesarbre.png'],
            ['image' => 'vgmus/saintemariemarin.png'],
            ['image' => 'vgmus/squelette.png'],
            ['image' => 'vgmus/tournesols.png'],
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
            $insert->execute([$utilisateurId, $booster, '', $carte['image']]);
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    <title>Histori'art – Booster</title>

<style>
.boosters-section {
    padding: 70px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 32px;
}

.boosters-grid {
    display: flex;
    justify-content: center;
    gap: 48px;
    flex-wrap: wrap;
}

.pack-btn {
    padding: 0;
    background: none;
    border: none;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .75rem;
    transition: transform .35s ease;
}
.pack-btn:hover { transform: translateY(-20px); }

.booster-pack {
    width: 200px;
    height: 300px;
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.booster-pack-img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 1;
    border-radius: 14px;
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
.msg-bar_cooldown {
    background: rgba(201,168,76,.1);
    border: 1px solid rgba(201,168,76,.35);
    color: #c9a84c;
}
.msg-bar_error {
    background: rgba(160,0,30,.1);
    border: 1px solid rgba(160,0,30,.4);
    color: #e87070;
}

#result {
    display: none;
    flex-direction: column;
    align-items: center;
    gap: 1.5rem;
}

.overlay-title {
    font-family: 'Dancing Script', cursive;
    font-size: 2rem;
    color: #c9a84c;
    text-align: center;
}

.cards-reveal {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
    justify-content: center;
}

.card-front {
    width: 150px;
    height: 225px;
    background: #faf7f1;
    border: 2px solid #c9a84c;
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.card-front-img {
    width: 100%;
    flex: 1;
    object-fit: cover;
    display: block;
}

@media (max-width: 600px) {
    .boosters-grid { gap: 1.5rem; }
    .booster-pack  { width: 150px; height: 230px; }
    .card-front    { width: 120px; height: 180px; }
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
            <img src="booster.png" alt="booster">
        </button>
        <button class="button" id="themeToggle">Mode clair</button>
    </header>

<main>
    <div id="not-logged"   class="msg-bar msg-bar_error"></div>
    <div id="cooldown-msg" class="msg-bar msg-bar_cooldown"></div>

    <section class="boosters-section">
        <h2>Choisissez votre collection</h2>

        <div class="boosters-grid">
            <button class="pack-btn booster-louvre" data-booster="louvre">
                <div class="booster-pack">
                    <img class="booster-pack-img" src="booster_louvre.png" alt="Booster Louvre">
                </div>
            </button>

            <button class="pack-btn booster-moma" data-booster="moma">
                <div class="booster-pack">
                    <img class="booster-pack-img" src="booster_moma.png" alt="Booster MoMA">
                </div>
            </button>

            <button class="pack-btn booster-vangogh" data-booster="vangogh">
                <div class="booster-pack">
                    <img class="booster-pack-img" src="booster_vg.png" alt="Booster Van Gogh">
                </div>
            </button>
        </div>

        <div id="result">
            <h3 class="overlay-title" id="result-title"></h3>
            <div class="cards-reveal" id="cards-reveal"></div>
        </div>
    </section>
</main>

<footer class="footer">
    <div class="imagefooter"><img src="carte.png" alt="carte"></div>
    <div class="textfooter">Tous droits de reproduction et de diffusion réservés © 2025 Histori'art</div>
</footer>

<script>
(function () {
    const resultEl    = document.getElementById('result');
    const cardsReveal = document.getElementById('cards-reveal');
    const resultTitle = document.getElementById('result-title');
    const cooldownMsg = document.getElementById('cooldown-msg');
    const notLoggedEl = document.getElementById('not-logged');

    const museumNames = { louvre: 'Louvre', moma: 'MoMA', vangogh: 'Van Gogh Museum' }; //dictionnaire

    document.querySelectorAll('.pack-btn[data-booster]').forEach(btn =>
        btn.addEventListener('click', () => openBooster(btn.dataset.booster))
    );

    function openBooster(booster) {
        cooldownMsg.style.display = notLoggedEl.style.display = 'none';
        cardsReveal.innerHTML = '';
        resultTitle.textContent = '';
        resultEl.style.display = 'none';
        //clic qui appelle openBooster

        const fd = new FormData();
        fd.append('action', 'open');
        fd.append('booster', booster);

        fetch('booster.php', { method: 'POST', body: fd }) //envoie POST
            .then(r => {
                const ct = r.headers.get('content-type') || '';
                if (!ct.includes('application/json'))
                    return r.text().then(t => { throw new Error(t.substring(0, 300)); });
                return r.json();
            })
            //retourne une erreur si erreur
            .then(data => {
                if (data.error) {
                    const el = data.error.toLowerCase().includes('connecte') ? notLoggedEl : cooldownMsg;
                    el.textContent = data.error;
                    el.style.display = 'block';
                    return;
                }

                resultTitle.textContent = museumNames[data.booster] || 'Booster';
                resultEl.style.display = 'flex';

                data.cartes.forEach((carte, i) => {
                    const card = document.createElement('div');
                    card.className = 'card-front';
                    card.style.cssText = `opacity:0; transform:translateY(20px); transition: opacity .4s ease ${i * .15}s, transform .4s ease ${i * .15}s;`;

                    const img = document.createElement('img');
                    img.className = 'card-front-img';
                    img.src = carte.image;
                    img.alt = '';
                    img.onerror = () => img.replaceWith(
                        Object.assign(document.createElement('div'), {
                            className: 'card-front-img',
                            style: 'background:#ede8dc;display:flex;align-items:center;justify-content:center;font-size:2rem;',
                            textContent: '🖼'
                        })
                    );

                    //retourne l'image

                    card.appendChild(img);
                    cardsReveal.appendChild(card);

                    requestAnimationFrame(() => requestAnimationFrame(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }));
                });

                resultEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            })
            .catch(err => {
                cooldownMsg.textContent = 'Erreur : ' + err.message;
                cooldownMsg.style.display = 'block';
            });
    }
})();
</script>

</body>
</html>