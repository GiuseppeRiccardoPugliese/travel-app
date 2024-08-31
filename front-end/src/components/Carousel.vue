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
    props: {
        trips: {
            type: Array,
            required: true,
        },
    },
    methods: {
        getImageUrl(imagePath) {
            // Verifica se l'immagine è un path relativo e costruisci l'URL completo
            return `http://localhost:8000/storage/${imagePath}`;
        },
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
        <swiper :spaceBetween="15" :centeredSlides="false" :autoplay="{
            delay: 2500,
            disableOnInteraction: false,
        }" :slidesPerView="4" :loop="true" :navigation="true" :modules="modules" :breakpoints="{
            '1800': {
                slidesPerView: 5,
                spaceBetween: 70,
            },
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
                spaceBetween: 5,
            },
            '576': {
                slidesPerView: 1,
                spaceBetween: 10,
            },
            '0': {
                slidesPerView: 1,
                spaceBetween: 0,
            }
        }" class="mySwiper my-4">
            <swiper-slide v-for="trip in trips" :key="trip.id" class="swiper-slide">
                <div class="image-wrapper">
                    <img :src="getImageUrl(trip.immagine)" :alt="trip.nome" />
                    <div class="overlay">
                        <span>{{ trip.nome }}</span>
                    </div>
                </div>
            </swiper-slide>
        </swiper>
    </div>
</template>

<style lang="scss" scoped>
.carousel-container {
    height: 100%;
    padding: 24px 0;
}

.swiper-slide {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.image-wrapper {
    position: relative;
    width: 300px;
    height: 200px;

    img {
        width: 100%;
        height: 100%;
        border-radius: 20px;
        transition: filter 0.3s ease;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        background: rgba(0, 0, 0, 0.6);
        color: #fff;
        opacity: 0;
        transition: opacity 0.3s ease;
        text-align: center;
        padding: 1rem;
        box-sizing: border-box;
        border-radius: 20px;

        span {
            font-size: 1.5rem;
            font-weight: bold;
        }
    }

    &:hover {
        .overlay {
            opacity: 1;
        }
    }
}

@media screen and (min-width: 1400px) {
    .swiper-slide {
        .image-wrapper {
            width: 300px;
            height: 200px;
        }
    }
}
</style>
