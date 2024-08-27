let scrollAmount = 100; // Altezza dello scroll in pixel per ogni scatto
let scrollDuration = 300; // Durata dello scroll in millisecondi

function smoothScrollBy(amount) {
    let start = window.scrollY;
    let startTime = null;

    function animation(currentTime) {
        if (startTime === null) startTime = currentTime;
        let timeElapsed = currentTime - startTime;
        let progress = Math.min(timeElapsed / scrollDuration, 1);
        window.scrollTo(0, start + amount * easeInOutQuad(progress));
        if (timeElapsed < scrollDuration) {
            requestAnimationFrame(animation);
        }
    }

    function easeInOutQuad(t) {
        return t < 0.5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2;
    }

    requestAnimationFrame(animation);
}

// Funzione che gestisce lo scroll a scatti e fluido
function scrollHandler(event) {
    event.preventDefault(); // Previene lo scroll standard
    let delta = Math.sign(event.deltaY); // Determina la direzione dello scroll
    smoothScrollBy(delta * scrollAmount); // Esegue lo scroll a scatti con animazione
}

// Aggiungi l'evento di scroll del mouse alla pagina
window.addEventListener('wheel', scrollHandler);


document.addEventListener('DOMContentLoaded', function () {
    const dropdown = document.querySelector('.nav-item.dropdown');
    const dropdownMenu = dropdown.querySelector('.dropdown-menu');
    let hideTimeout;

    function showMenu() {
        clearTimeout(hideTimeout); // Annulla qualsiasi timeout di nascondimento in corso
        dropdownMenu.classList.add('show');
    }

    function hideMenu() {
        dropdownMenu.classList.remove('show');
        hideTimeout = setTimeout(() => {
            dropdownMenu.style.visibility = 'hidden';
        }, 500); // Il timeout deve corrispondere alla durata della transizione
    }

    // Mostra il menu a discesa al passaggio del mouse
    dropdown.addEventListener('mouseenter', function () {
        dropdownMenu.style.visibility = 'visible';
        showMenu();
    });

    // Nasconde il menu a discesa quando il mouse esce
    dropdown.addEventListener('mouseleave', function () {
        hideMenu();
    });

    // Gestisci la fine della transizione per rimuovere la visibilità dopo l'animazione
    dropdownMenu.addEventListener('transitionend', function (event) {
        if (!dropdownMenu.classList.contains('show')) {
            dropdownMenu.style.visibility = 'hidden';
        }
    });
});