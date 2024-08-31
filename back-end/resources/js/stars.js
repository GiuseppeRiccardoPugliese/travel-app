function colorStar(value, containerId) {
    console.log(containerId);
    // Ottieni il contenitore delle stelline
    var container = document.getElementById(`${containerId}`);

    // Ottieni tutte le stelline all'interno del contenitore
    var star = container.children[1];;

    if (star.classList.contains('selected')) {
        document.getElementById(`star${value}`).value = 0;
        star.classList.remove('selected');
    } else {
        document.getElementById(`star${value}`).value = 1;
        star.classList.add('selected')

    }

}

function votazione() {
    let valutazione = 0;
    for (let i = 1; i <= 5; i++) {

        if (document.getElementById(`star${i}`).value == 1) {
            valutazione = valutazione + 1;
        }

    }
    document.getElementById('valutazione').value = valutazione;
}
function coloredStars() {
    console.log(document.getElementById(`star1`).value);
    for (let i = 1; i <= 5; i++) {

        var container = document.getElementById(`star-container-${i}`);
        var input = document.getElementById(`star${i}`);
        console.log(input.value)
        var stars = container.children[1];
        if (input.value == '1') {
            stars.classList.add('selected');
        }
    }


}


