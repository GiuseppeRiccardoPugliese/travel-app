<script>
import axios from "axios";

//Import del carosello
import Carousel from '../components/Carousel.vue';

export default {
  name: "Trips",
  components: {
    Carousel,
  },
  data() {
    return {
      trips: [], //Array per i viaggi
      stages: [], //Array per le tappe
    }
  },
  mounted() {
    this.fetchTrips(); // Chiamo la funzione per ottenere i dati
    this.fetchJourneyStages(); // Chiamo la funzione per ottenere i dati
  },
  methods: {
    async fetchTrips() {
      try {
        const response = await axios.get('http://localhost:8000/api/v1/trips');
        this.trips = response.data; // Dati ricevuti = array vuoto per memorizzarli
      } catch (err) {
        console.error('Errore nella chiamata API:', err); // Log dell'errore
      }
    },
    async fetchJourneyStages() {
      try {
        const response = await axios.get('http://localhost:8000/api/v1/journey-stages');
        this.stages = response.data; // Dati ricevuti = array per memorizzarli
      } catch (err) {
        console.error('Errore nella chiamata API:', err); // Log dell'errore
      }
    },
  },
}

</script>

<template>
  <div>

    <!-- Carosello -->
    <Carousel :trips="trips" />

    <!-- VIAGGI -->
    <div class="trips-container">
      <h1 class="trips-heading">Elenco dei Viaggi</h1>
      <div v-if="trips.length" class="trips-list">
        <div v-for="trip in trips" :key="trip.id" class="trips-item">
          <div class="trip-details">
            <h5 class="trip-name">{{ trip.nome }}</h5>
            <p class="trip-destination">{{ trip.destinazione }}</p>
          </div>
          <span class="trip-badge">Dettagli</span>
        </div>
      </div>
      <p v-else class="loading-message">Caricamento dei viaggi in corso...</p>
    </div>

    <!-- TAPPE -->
    <div class="stages-container">
      <h1 class="stages-heading">Elenco delle Tappe</h1>
      <div v-if="stages.length" class="stages-list">
        <div v-for="stage in stages" :key="stage.id" class="stages-item">
          <div class="stage-details">
            <h5 class="stage-name">{{ stage.nome }}</h5>
            <p class="stage-description">{{ stage.descrizione }}</p>
          </div>
          <span class="stage-badge">Dettagli</span>
        </div>
      </div>
      <p v-else class="loading-message">Caricamento delle tappe in corso...</p>
    </div>
  </div>

</template>

<style scoped lang="scss">
@use '../style/style.scss' as *;

.trips-container,
.stages-container {
  padding: 2rem;
  max-width: 800px;
  margin: auto;
}

// Titoli principali per Viaggi e Tappe
.trips-heading,
.stages-heading {
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
  color: #333;
}

// Lista per Viaggi e Tappe
.trips-list,
.stages-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

// Elemento della lista Viaggi e Tappe
.trips-item,
.stages-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  border-radius: 0.5rem;
  background-color: #f8f9fa;
  box-shadow: 0 0 0.125rem rgba(0, 0, 0, 0.1);
}

// Dettagli dei Viaggi e delle Tappe
.trip-details,
.stage-details {
  display: flex;
  flex-direction: column;
}

// Nome per Viaggi e Tappe
.trip-name,
.stage-name {
  font-size: 1.25rem;
  font-weight: 600;
  color: #333;
}

// Descrizione per Viaggi e Tappe
.trip-destination,
.stage-description {
  font-size: 1rem;
  color: #6c757d;
}

// Badge per Viaggi e Tappe
.trip-badge,
.stage-badge {
  font-size: 0.875rem;
  background-color: #007bff;
  color: #fff;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
}

// Messaggio di caricamento
.loading-message {
  text-align: center;
  font-size: 1rem;
  color: #6c757d;
}
</style>
