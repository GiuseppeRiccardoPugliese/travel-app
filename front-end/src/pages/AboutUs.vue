<script>
export default {
    name: "AboutUs",
};
</script>

<template>
    <div class="about-us container py-5">
        <!-- Freccia per tornare nella home -->
        <div class="back-home mb-4">
            <router-link to="/" class="back-link">
                <i class="fa-solid fa-arrow-left"></i><span>Home</span>
            </router-link>
        </div>

        <!-- Titolo -->
        <h1 class="text-center mb-5 about-us-title">About Us</h1>

        <div class="row justify-content-center">
            <!-- Prima Card Autore -->
            <div class="col-lg-4 col-md-6 col-10 mb-4 d-flex">
                <div class="card author-card flex-fill">
                    <img src="../../public/IMG-20240309-WA0193.jpg" class="card-img-top"
                        alt="Giuseppe Riccardo Pugliese" />
                    <div class="card-body text-center d-flex flex-column">
                        <h5 class="card-title">Giuseppe Riccardo Pugliese</h5>
                        <p class="card-text">Full Stack Developer</p>
                        <div class="social-icons mt-auto d-flex justify-content-center">
                            <a href="https://www.linkedin.com/in/giuseppe-pugliese03/" target="_blank"
                                class="social-icon">
                                <i class="fab fa-linkedin"></i>
                            </a>
                            <a href="https://github.com/GiuseppeRiccardoPugliese" target="_blank" class="social-icon">
                                <i class="fab fa-github"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seconda Card Autore -->
            <div class="col-lg-4 col-md-6 col-10 mb-4 d-flex">
                <div class="card author-card flex-fill">
                    <img src="../../public/Kaid.jpg" class="card-img-top" alt="Kaid Gabriele Abu Madegem" />
                    <div class="card-body text-center d-flex flex-column">
                        <h5 class="card-title">Kaid Gabriele Abu Madegem</h5>
                        <p class="card-text">Full Stack Developer</p>
                        <div class="social-icons mt-auto d-flex justify-content-center">
                            <a href="https://www.linkedin.com/in/kaid-gabriele-abu-madegem-3b83ba2b8/" target="_blank"
                                class="social-icon">
                                <i class="fab fa-linkedin"></i>
                            </a>
                            <a href="https://github.com/Gabrieleabu23" target="_blank" class="social-icon">
                                <i class="fab fa-github"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
//Torna alla Home
.back-home {

    .back-link {
        color: #0077b5;
        font-size: 1.25rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: color 0.4s ease;
    }

    .back-link i {
        margin-right: 8px;
        font-size: 1.5rem;
    }

    .back-link:hover {
        color: #e90303;
    }
}

//Titolo sezione con l'animazione
.about-us-title {
    font-size: 2.5rem;
    font-weight: bold;
    color: #1E90FF;
    text-transform: uppercase;
    letter-spacing: 2px;
    animation: fadeInDown 2s ease-out, pulse 1.5s infinite alternate;
}

/* Animazione del titolo */
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }

    100% {
        transform: scale(1.05);
    }
}

/* Media Queries per il titolo */
@media (max-width: 1200px) {
    .about-us-title {
        font-size: 2.2rem;
    }
}

@media (max-width: 992px) {
    .about-us-title {
        font-size: 2rem;
    }
}

@media (max-width: 768px) {
    .about-us-title {
        font-size: 1.75rem;
    }
}

// @media (max-width: 576px) {
//     .about-us-title {
//         font-size: 1.5rem;
//     }
// }

//Section AboutUs
.about-us {
    border-radius: 10px;
    padding: 20px;
}

//Card
.author-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease;
}

.author-card:hover {
    transform: scale(1.05);
}

.card-img-top {
    border-radius: 15px 15px 0 0;
    object-fit: cover;
    height: 480px;
    width: 100%;
}

.card-title {
    font-size: 1.5rem;
    font-weight: bold;
}

.card-text {
    font-size: 1rem;
    color: #6c757d;
}

.social-icons {
    margin-top: 10px;
}

.social-icon {
    color: #0077b5;
    /* LinkedIn */
    font-size: 1.5rem;
    margin: 0 10px;
    transition: color 0.3s ease;
}

.social-icon:hover {
    color: #005582;
    /* LinkedIn Hover */
}

.social-icon:nth-child(2) {
    color: #333;
    /* GitHub */
}

.social-icon:nth-child(2):hover {
    color: #000;
    /* GitHub Hover */
}
</style>