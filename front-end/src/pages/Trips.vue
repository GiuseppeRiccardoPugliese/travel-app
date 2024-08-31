<script>
import axios from "axios";
import Carousel from '../components/Carousel.vue';

export default {
  name: "Trips",
  components: {
    Carousel,
  },
  data() {
    return {
      trips: [], // Array per i viaggi
      stages: [], // Array per le tappe
      selectedTrip: null, // Viaggio selezionato
    };
  },
  mounted() {
    this.fetchTrips(); // Chiamo la funzione per ottenere i dati
  },
  methods: {
    async fetchTrips() {
      try {
        const response = await axios.get('http://localhost:8000/api/v1/trips');
        this.trips = response.data; // Dati ricevuti = array per memorizzarli
      } catch (err) {
        console.error('Errore nella chiamata API:', err); // Log dell'errore
      }
    },
    async fetchJourneyStages(tripId) {
      try {
        const response = await axios.get(`http://localhost:8000/api/v1/journey-stages-by-trip?trip_id=${tripId}`);
        this.stages = response.data; // Dati ricevuti = array per memorizzarli
      } catch (err) {
        console.error('Errore nella chiamata API:', err); // Log dell'errore
      }
    },
    async showDetails(trip) {
      this.selectedTrip = trip; // Selected Trip
      await this.fetchJourneyStages(trip.id); // Tappe per il viaggio selezionato
    },
    hideDetails() {
      this.selectedTrip = null; // Hide dettagli delle tappe
      this.stages = []; // Pulisco le tappe ogni volta
    },
    getImageUrl(imagePath) {
      // Verifica se l'immagine è un path relativo e costruisci l'URL completo
      return `http://localhost:8000/storage/${imagePath}`;
    },
  }
};
</script>

<template>
  <div>
    <!-- Carosello -->
    <Carousel :trips="trips" />

    <!-- VIAGGI -->
    <div v-if="!selectedTrip" class="container">
      <h1 class="trips-heading">Elenco dei Viaggi</h1>
      <div v-if="trips.length" class="row">
        <div v-for="trip in trips" :key="trip.id" class="col-md-6 col-lg-3 mb-3 col-12 col-sm-6">
          <div class="trip-card">
            <img v-if="trip.immagine" :src="getImageUrl(trip.immagine)" class="trip-card-img"
              alt="Immagine del viaggio" />
            <div class="trip-card-content">
              <!-- Nome -->
              <h5 class="trip-name">{{ trip.nome }}</h5>
              <!-- Destinazione -->
              <p class="trip-destination">{{ trip.destinazione }}</p>
              <!-- Descrizione -->
              <p class="trip-description">{{ trip.descrizione || 'Nessuna descrizione disponibile' }}</p>
              <button @click="showDetails(trip)" class="trip-details-button">Dettagli</button>
              <!-- Show dei dettagli dei JourneyStages -->
            </div>
          </div>
        </div>
      </div>
      <p v-else class="loading-message">Caricamento dei viaggi in corso...</p>
    </div>

    <!-- TAPPE -->
    <div v-if="selectedTrip" class="container">
      <div class="d-flex align-items-center mb-5 responsive">
        <button @click="hideDetails" class="hide-details-button">Indietro</button>
        <h1 class="stages-heading m-0 mx-auto">Dettagli per {{ selectedTrip.nome }}</h1>
      </div>
      <div v-if="stages.length" class="row">
        <div v-for="stage in stages" :key="stage.id" class="col-md-6 col-lg-4 col-sm-6 col-12 mb-3">
          <div class="stage-card h-100">
            <div>
              <!-- Nome -->
              <h5 class="fw-bold overflow-hidden">{{ stage.nome }}</h5>
              <!-- Descrizione -->
              <p class="stage-description overflow-hidden">{{ stage.descrizione || 'Nessuna descrizione disponibile' }}
              </p>
              <!-- Posizione -->
              <p class="mt-2 fw-normal overflow-hidden"><strong>Posizione:</strong> {{ stage.posizione }}</p>
              <div class="stage-rating d-flex align-items-center mt-2 mt-auto">
                <span class="me-1 fw-semibold">Voto: </span>
                <!-- Stelle piene -->
                <i v-for="n in Math.floor(stage.votazione)" :key="'full-' + n" class="fa-solid fa-star"></i>
                <!-- Stelle vuote -->
                <i v-for="n in (5 - Math.floor(stage.votazione))" :key="'empty-' + n" class="fa-regular fa-star"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <p v-else class="loading-message">Caricamento delle tappe in corso...</p>
    </div>
  </div>
</template>



<style scoped lang="scss">
@use '../style/style.scss' as *;
//CSS CARD
@use '../style/trip_cards.scss' as *;
</style>
