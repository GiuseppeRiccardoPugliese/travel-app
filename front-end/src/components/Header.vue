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
                        <i class="fa-solid fa-bars fs-4"></i>
                    </button>
                </div>

            </section>
        </nav>

        <!-- Off-canvas -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header border-bottom border-1">

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
.header {
    // position: fixed;
    // top: 0;
    width: 100%;
    z-index: 1000;
}

//NAV SETUP 
.navbar {
    background-color: #deebfa;
    width: 100%;
    padding: 0;
}

.nav-section {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
    margin: 0 auto;

    .btn-primary {
        background-color: #1E90FF;
        border-color: grey;
    }

}

//OFFCANVAS
.offcanvas-body {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    background-color: #f7f7ff;
}

.offcanvas-link {
    display: block;
    width: 100%;
    text-align: center;
    padding: 12px 0;
    margin-bottom: 15px;
    font-size: 18px;
    font-weight: bold;
    color: #ffffff;
    background-color: #13dbe6;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.2s ease;
    text-decoration: none;
}

.offcanvas-link:last-child {
    margin-bottom: 0;
}

.offcanvas-link:hover {
    background-color: #11c4cc;
    transform: translateY(-3px);
}

.offcanvas-link:active {
    background-color: #0fb0b8;
    transform: translateY(0);
}

//TYPING INSIDE OFFCANVAS 
.typing-container {
    display: inline-block;
    font-size: 24px;
    color: #333;
    border-right: 2px solid #333;
    white-space: nowrap;
    overflow: hidden;
    animation: typing 3s steps(40, end) infinite, blink-caret 0.75s step-end infinite;
}

@keyframes typing {
    0% {
        width: 0;
    }

    50% {
        width: 14%;
    }

    75% {
        width: 50%;
        border-right: none;
    }

    /* Pause with border removed */
    100% {
        width: 100%;
        border-right: none;
    }

    /* Maintain the final state */
}

@keyframes blink-caret {

    from,
    to {
        border-color: transparent;
    }

    50% {
        border-color: #333;
    }
}


//LOGO
.site-header {
    padding: 20px 10px;
}

.site-header .travel-app {
    display: inline-block;
    font-weight: bold;
}

.site-header .travel-app span {
    display: inline-block;
    opacity: 0;
    background-clip: text;
    -webkit-background-clip: text;
    color: transparent;
}

.site-header .part1 {
    background: linear-gradient(90deg, #FFA500, #FF4500);
    animation: slideUp 0.8s ease-out forwards;
}

.site-header .part2 {
    background: linear-gradient(90deg, #32CD32, #228B22);
    animation: slideUp 0.8s ease-out forwards 0.5s;
}

.site-header .part3 {
    background: linear-gradient(90deg, #1E90FF, #0000FF);
    animation: slideRight 0.8s ease-out forwards 1s;
}

.site-header .dash {
    background: linear-gradient(90deg, #FF69B4, #FF1493);
    animation: fadeIn 0.8s ease-out forwards 1.5s;
}

@keyframes slideUp {
    from {
        transform: translateY(100%);
        opacity: 0;
    }

    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes slideRight {
    from {
        transform: translateX(-100%);
        opacity: 0;
    }

    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}
</style>