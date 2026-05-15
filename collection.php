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
    <title>Histori'art</title>
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
        <button class="button" id="themeToggle">Mode clair</button>
    </header>
    <main>
        <section class="museums-container">
            
            <div class="museums-buttons">
                <button class="museum-btn"><a href="louvre.html"><img src="logoLouvre.png" alt="logoLouvre"></a></button>
                <button class="museum-btn"><a href="moma.html"><img src="LogoMoMA.jpg" alt="logoMoMA"></a></button>
                <button class="museum-btn"><a href="vgmuseum.html"><img src="logoVGMuseum.jpg" alt="logoVGMuseum"></a></button>
            </div>
        </section>
        <section class="newslettersection">
            <p>Interessé par les nouveautés?<br> </p>
            <a href="formulaire.html"><p class="newsletterlink">Inscris toi à notre Newsletter!<br> </p></a>
        </section>
        <section class="gap">
            <p> </p>
        </section>
    </main>
    <footer>
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