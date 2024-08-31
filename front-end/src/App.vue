<script>
import Footer from './components/Footer.vue';
import Header from './components/Header.vue';

export default {

  components: {
    Footer,
    Header,
  },
  data() {
    return {
      showScrollTop: false,
    }
  },
  methods: {
    checkScroll() {
      // Se la pagina e' stata scrollata di 100px allora:
      this.showScrollTop = window.scrollY > 100;
      //Log "true" di showScrollTop
    },
    scrollToTop() {
      // Funzione per far scrollare la pagina verso l'alto
      window.scrollTo({
        top: 0,
        behavior: 'smooth', //Scrolla top lentamente 'smooth' invece di essere istantaneo
      });
    },
  },
  mounted() {
    window.addEventListener('scroll', this.checkScroll);
  },
  beforeDestroy() {
    // Memory leaks
    window.removeEventListener('scroll', this.checkScroll);
  },
}

</script>

<template>
  <!-- Rotte (Trips, NotFound) -->
  <div class="app-container d-flex flex-column min-vh-100">

    <!-- Header -->
    <Header />

    <main class="content flex-grow-1">
      <router-view></router-view>
    </main>

    <!-- Footer -->
    <Footer />

    <!-- Freccia che compare quando scrolli di 100px -->
    <div v-if="showScrollTop" @click="scrollToTop" class="scroll-top-arrow show">
      <i class="fa-solid fa-circle-up"></i>
    </div>
  </div>
</template>

<style lang="scss">
@use './style/style.scss' as *;

/* Stili per la freccia */
.scroll-top-arrow {
  position: fixed;
  bottom: 100px;
  right: 20px;
  font-size: 30px;
  cursor: pointer;
  display: none;
  transition: opacity 0.3s ease;

  .fa-circle-up {
    color: white;
  }
}

/* Stili per la freccia quando visibile */
.scroll-top-arrow.show {
  display: block;
  opacity: 1;
  padding: 0px 12px;
  background-color: #61aafd;
  border-radius: 5px;
  z-index: 1000;
}
</style>
