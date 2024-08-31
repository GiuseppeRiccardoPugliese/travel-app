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

    }
  },
  methods: {

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

  </div>

</template>

<style lang="scss">
@use './style/style.scss' as *;
</style>
