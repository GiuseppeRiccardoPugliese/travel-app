<script>
export default {
    name: "Header",
    data() {
        return {
            isWide: false, // Inizialmente impostato su false

        }
    }
}
</script>

<template>
    <!-- Header -->
    <header class="header">

        <!-- Nav -->
        <nav class="navbar">
            <section class="nav-section" :style="{ maxWidth: isWide ? '1320px' : '100%' }">

                <!-- Rotta per i Trips Logo a sinistra -->
                <router-link :to="{ name: 'Trips' }">
                    <div class="site-header">
                        <h1 class="travel-app mb-0">
                            <span class="part1">TRA</span><span class="part2">VEL</span><span class="dash">-</span><span
                                class="part3">APP</span>
                        </h1>
                    </div>
                </router-link>

                <div class="d-flex">
                    <!-- Pulsante Account -->
                    <button class="btn btn-primary d-flex" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                        <i class="fa-solid fa-user fs-4"></i>
                    </button>
                </div>

            </section>
        </nav>

        <!-- Off-canvas -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header border-bottom border-1" style="padding: 20px;">

                <span class="typing-container">Area riservata</span>

                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">

                <a href="http://localhost:8000/register" class="offcanvas-link d-block mb-3"
                    id="offcanvasRightLabel">Registrati!</a>
                <a href="http://localhost:8000/login" class="offcanvas-link" id="offcanvasRightLabel">Accedi!</a>

            </div>
        </div>
    </header>

</template>

<style lang="scss" scoped>
//CSS HEADER
@use '../style/header.scss' as *;
</style>