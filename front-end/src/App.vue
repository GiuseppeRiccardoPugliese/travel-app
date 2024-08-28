<script>
import Footer from './components/Footer.vue'

export default{

  components: {
    Footer,
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
