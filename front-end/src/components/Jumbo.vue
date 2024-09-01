<script>
export default {
    name: "Jumbo",
}
</script>

<template>
    <div class="jumbotron">
        <div class="jumbotron-content">
            <h1 class="jumbotron-title">Benvenuto!</h1>
            <p class="jumbotron-subtitle">Accedi o registrati per organizzare i tuoi viaggi.</p>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.jumbotron {
    position: relative;
    background-image: url('../../public/jumbo_img.avif');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    color: #fff;
    text-align: center;
    padding: 4rem 2rem;
    box-shadow: 0 0 0.5rem rgba(0, 0, 0, 0.3);
    margin-bottom: 2.5rem;

    .jumbotron-content {
        max-width: 800px;
        margin: 100px auto;
        padding: 2rem;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 0.5rem;

        .jumbotron-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .jumbotron-subtitle {
            font-size: 1.125rem;
            margin-bottom: 1.5rem;
            font-weight: 400;
        }
    }
}
</style>
