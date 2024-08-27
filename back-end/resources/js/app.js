import './bootstrap';
import '~resources/scss/app.scss';
import '~icons/bootstrap-icons.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
])


// RESET BARRA DI RICERCA DESTINAZIONE
document.getElementById("search_city").value="";
document.getElementById("data_inizio").value="";
document.getElementById("data_fine").value="";
// RESET NOME MODALE (CITTA)
document.getElementById("ModalSearchedCity").innerHTML = "";
// RESET FOTO CITTA-DESTINAZIONE SEARCH-BAR
document.getElementById("photo-container").parentElement.classList.add('d-none');

// RESET MAPPA TOMTOM CITTA-DESTINAZIONE SEARCH-BAR
document.getElementById("map").parentElement.parentElement.classList.add('d-none');

// RESET NAVBAR QUANDO IL MODAL NON È ATTIVO
$("#exampleModal").on("hidden.bs.modal", function () {
    document.getElementById('nav_bar').style.display='block';
});