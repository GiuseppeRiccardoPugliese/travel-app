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
                    <img src="../../public/Giuseppe.jpg" class="card-img-top" alt="Giuseppe Riccardo Pugliese" />
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
//CSS AboutUs
@use '../style/about_us.scss' as *;
</style>