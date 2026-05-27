/*   DAY / NIGHT MODE */
console.log("mode jour/nuit")

const themeToggle = document.getElementById("themeToggle");

themeToggle.addEventListener("click", () => {
    const html = document.documentElement;
    const isDark = html.dataset.theme === "dark";

    html.dataset.theme = isDark ? "light" : "dark";
    themeToggle.textContent = isDark ? "Mode sombre" : "Mode clair";


    themeToggle.classList.add("clicked");
    setTimeout(() => themeToggle.classList.remove("clicked"), 200);
});


/*TABS*/
console.log("tabs")

const tabs = document.querySelectorAll(".tab");
// On récupère tous les éléments avec la classe "tab"
const contents = document.querySelectorAll(".tab-content");
// same avec tab-content

tabs.forEach(tab => {
    tab.addEventListener("click", () => {
        // evenement au click

        tabs.forEach(t => t.classList.remove("active"));
        // remove l'ancien onglet pour le remplacer par un nouveau
        tab.classList.add("active");
        // ajoute un nouveau bouton

        contents.forEach(c => c.classList.remove("visible"));
        // retire visible, donc c'est caché
        document.getElementById(tab.dataset.target).classList.add("visible");
        // et maintenant l'onglet cliqué est visible
    });
});


/*BANDEAU 2 — Carrousel perspective*/
console.log("carrousel bandeau2");

(function () {

    const stage = document.querySelector('.cards-stage');
    if (!stage) return; // sécurité si la section n'existe pas

    const cards = Array.from(stage.querySelectorAll('.card'));
    const dots  = Array.from(document.querySelectorAll('.bandeau2-dots .dot'));
    let animating = false;
    let autoTimer = null;

    // order[0] = carte devant, order[1] = milieu, order[2] = loin
    let order = [0, 1, 2];

    const POSITIONS = [
        {
            // Devant (active)
            className: 'card--front',
            style: {
                top: '0px', left: '140px', zIndex: '3',
                transform: 'perspective(800px) rotateY(0deg) scale(1)',
                opacity: '1', filter: 'brightness(1)',
                border: '1px solid rgba(185,146,59,0.45)',
                boxShadow: '0 20px 50px rgba(185,146,59,0.18), 0 4px 16px rgba(0,0,0,0.1)'
            }
        },
        {
            // Milieu
            className: 'card--mid',
            style: {
                top: '20px', left: '60px', zIndex: '2',
                transform: 'perspective(800px) rotateY(-10deg) scale(0.88)',
                opacity: '0.7', filter: 'brightness(0.9)',
                border: '1px solid rgba(185,146,59,0.3)',
                boxShadow: '4px 8px 30px rgba(185,146,59,0.12)'
            }
        },
        {
            // Loin (derrière)
            className: 'card--far',
            style: {
                top: '40px', left: '0px', zIndex: '1',
                transform: 'perspective(800px) rotateY(-18deg) scale(0.78)',
                opacity: '0.45', filter: 'brightness(0.75)',
                border: '1px solid rgba(185,146,59,0.2)',
                boxShadow: 'none'
            }
        }
    ];

    function applyPosition(card, posIndex, animate) {
        const pos = POSITIONS[posIndex];

        card.classList.remove('card--front', 'card--mid', 'card--far', 'card--active');
        card.classList.add(pos.className);
        if (posIndex === 0) card.classList.add('card--active');

        if (!animate) {
            card.style.transition = 'none';
        } else {
            card.style.transition =
                'transform 0.55s cubic-bezier(0.34, 1.3, 0.64, 1), opacity 0.45s ease, box-shadow 0.45s ease, filter 0.45s ease';
        }

        Object.assign(card.style, pos.style);
    }

    function updateDots() {
        dots.forEach((dot, i) => {
            dot.classList.toggle('dot--active', order[0] === i);
        });
    }

    function rotateTo(targetIdx) {
        if (animating) return;
        if (order[0] === targetIdx) return;

        animating = true;

        const frontCard = cards[order[0]];

        // 1. Faire sortir la carte du devant vers la gauche
        frontCard.style.transition =
            'transform 0.4s cubic-bezier(0.4, 0, 0.8, 1), opacity 0.32s ease, filter 0.32s ease';
        frontCard.style.transform =
            'perspective(800px) translateX(-220%) rotateY(30deg) scale(0.75)';
        frontCard.style.opacity = '0';
        frontCard.style.filter  = 'brightness(0.4)';

        setTimeout(() => {

            // 2. Recalculer l'ordre : targetIdx passe devant
            const newOrder = [targetIdx];
            for (let i = 0; i < 3; i++) {
                if (order[i] !== targetIdx) newOrder.push(order[i]);
            }
            order = newOrder;
            // S'assurer que l'ancienne carte front est en dernière position
            const frontIdx = cards.indexOf(frontCard);
            order = order.filter(i => i !== frontIdx);
            order.push(frontIdx);

            // 3. Positionner la carte "far" hors champ droite sans transition
            const farCard = cards[order[2]];
            farCard.style.transition = 'none';
            farCard.style.transform  =
                'perspective(800px) translateX(120%) rotateY(-30deg) scale(0.65)';
            farCard.style.opacity = '0';
            farCard.style.filter  = 'brightness(0.3)';

            // 4. Appliquer les nouvelles positions
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {

                    applyPosition(cards[order[1]], 1, true);
                    applyPosition(cards[order[0]], 0, true);

                    // La carte "far" entre depuis la droite avec un léger délai
                    setTimeout(() => {
                        applyPosition(cards[order[2]], 2, true);
                    }, 80);

                    updateDots();

                    setTimeout(() => { animating = false; }, 580);
                });
            });

        }, 360);
    }

    function rotateNext() {
        rotateTo(order[1]);
    }

    // Clic sur les cartes
    cards.forEach((card, idx) => {
        card.addEventListener('click', () => {
            if (order[0] === idx) {
                rotateNext(); // clic sur la carte active → suivante
            } else {
                rotateTo(idx);
            }
        });
    });

    // Clic sur les dots
    dots.forEach((dot, i) => {
        dot.addEventListener('click', () => rotateTo(i));
    });

    // Auto-rotation toutes les 3.5 secondes
    function startAuto() {
        autoTimer = setInterval(rotateNext, 3500);
    }
    function stopAuto() {
        clearInterval(autoTimer);
    }

    stage.addEventListener('mouseenter', stopAuto);
    stage.addEventListener('mouseleave', startAuto);

    // Initialisation
    order.forEach((cardIdx, posIdx) => {
        applyPosition(cards[cardIdx], posIdx, false);
    });
    updateDots();
    startAuto();

})();



//focntionnement du booster
document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("BoutonBooster");//recuperation de l'id boosterbtn
    const result = document.getElementById("booster-resultat");

    btn.addEventListener("click", async () => {

        const res = await fetch("booster.php");
        const data = await res.json();

        if (data.error) {
            result.innerHTML =  data.error;//affichage des message d'erreur 
            return;
        }

        result.innerHTML = "";
//recuperation et affichage des cartes recuperer 
        data.forEach(card => {
            const div = document.createElement("div");
            div.innerHTML = `
                <img src="${card.image}" width="120">
                <p>${card.title}</p>
            `;
            result.appendChild(div);
        });

    });
});