let scrollAmount = 100;
let scrollDuration = 300;

function smoothScrollBy(element, amount) {
    const start = element.scrollTop;
    const startTime = performance.now();

    function animation(currentTime) {
        const elapsedTime = currentTime - startTime;
        const progress = Math.min(elapsedTime / scrollDuration, 1);
        const ease = easeInOutQuad(progress);

        element.scrollTo(0, start + amount * ease);

        if (elapsedTime < scrollDuration) {
            requestAnimationFrame(animation);
        }
    }

    function easeInOutQuad(t) {
        return t < 0.5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2;
    }

    requestAnimationFrame(animation);
}

function scrollHandler(event) {
    event.preventDefault();
    const delta = Math.sign(event.deltaY);
    const main = document.querySelector('main');
    smoothScrollBy(main, delta * scrollAmount);
}

document.querySelector('main').addEventListener('wheel', scrollHandler);

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

    // Menu a discesa al passaggio del mouse
    dropdown.addEventListener('mouseenter', function () {
        dropdownMenu.style.visibility = 'visible';
        showMenu();
    });

    // Menu a discesa quando il mouse esce
    dropdown.addEventListener('mouseleave', function () {
        hideMenu();
    });

    // Gestione fine della transizione per rimuovere la visibilità dopo l'animazione
    dropdownMenu.addEventListener('transitionend', function (event) {
        if (!dropdownMenu.classList.contains('show')) {
            dropdownMenu.style.visibility = 'hidden';
        }
    });
});