<script>

import { Swiper, SwiperSlide } from "swiper/vue";

import "swiper/css";

import "swiper/css/pagination";
import "swiper/css/navigation";

import { Autoplay, Pagination, Navigation } from "swiper/modules";

export default {
    name: 'Carousel',
    components: {
        Swiper,
        SwiperSlide,
    },
    setup() {
        return {
            modules: [Autoplay, Pagination, Navigation],
        };
    },
}
</script>

<template>
    <div class="carousel-container">
        <swiper
            :spaceBetween="30"
            :centeredSlides="true"
            :autoplay="{
                delay: 2500,
                disableOnInteraction: false,
            }"
            :slidesPerView="4"
            :loop="true"
            :navigation="true"
            :modules="modules"
            :breakpoints="{
                '1300': {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
                '1024': {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                '768': {
                    slidesPerView: 2,
                    spaceBetween: 15,
                },
                '576': {
                    slidesPerView: 1,
                    spaceBetween: 10,
                }
            }"
            class="mySwiper my-4"
        >
            <swiper-slide class="d-flex flex-column justify-content-center align-items-center">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQMVL_uoAuufBNjJTcfBrqAkhexO0oMtG84qg&s" alt="Viaggio 1" />
                <span>Viaggio 1</span>
            </swiper-slide>

            <swiper-slide class="d-flex flex-column justify-content-center align-items-center">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQMVL_uoAuufBNjJTcfBrqAkhexO0oMtG84qg&s" alt="Viaggio 2" />
                <span>Viaggio 2</span>
            </swiper-slide>

            <swiper-slide class="d-flex flex-column justify-content-center align-items-center">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQMVL_uoAuufBNjJTcfBrqAkhexO0oMtG84qg&s" alt="Viaggio 3" />
                <span>Viaggio 3</span>
            </swiper-slide>

            <swiper-slide class="d-flex flex-column justify-content-center align-items-center">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQMVL_uoAuufBNjJTcfBrqAkhexO0oMtG84qg&s" alt="Viaggio 4" />
                <span>Viaggio 4</span>
            </swiper-slide>

            <swiper-slide class="d-flex flex-column justify-content-center align-items-center">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQMVL_uoAuufBNjJTcfBrqAkhexO0oMtG84qg&s" alt="Viaggio 5" />
                <span>Viaggio 5</span>
            </swiper-slide>

            <swiper-slide class="d-flex flex-column justify-content-center align-items-center">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQMVL_uoAuufBNjJTcfBrqAkhexO0oMtG84qg&s" alt="Viaggio 6" />
                <span>Viaggio 6</span>
            </swiper-slide>
        </swiper>
    </div>
</template>

<style lang="scss" scoped>
img {
    width: 300px;
    height: 200px;
    border-radius: 20px;
}

.carousel-container {
    height: 100%;
    padding: 24px 0;
}

@media screen and (max-width: 900px) {
    img {
        width: 100%;
        height: 100%;
    }
}

@media screen and (min-width: 1400px) {
    img {
        width: 300px;
        height: 200px;
        margin-left: 20px;
        margin-right: 20px;
    }
}
</style>
