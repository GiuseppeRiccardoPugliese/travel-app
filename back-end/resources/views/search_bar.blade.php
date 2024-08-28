<section class=" ps-4 text-dark ">
    <h1 class="text_title fw-bold">Pianifica il tuo viaggio!</h1>
</section>
<div class="container p-0 d-flex flex-column ">

    <div class="row w-75 mx-auto multi-colored-border justify-content-center">
        <div class="col-md-4 p-0 border border-0 ">
            <div class="input-group flex-nowrap h-100">
                <span class="input-group-text  bg-transparent " id="addon-wrapping"><i
                        class="fa-solid fa-location-arrow"></i></span>
                <input class="form-control p-2 border border-top-0 border-end-0 rounded-3 me-2" type="search"
                    placeholder="Destinazione" aria-label="Search" id="search_city" name="search_city">
            </div>
        </div>

        @include('start_date')


        <div class="col-md-12 pe-1">
            <div id="results" class="border-1 border-black border-0 bg-white pe-1 rounded-2"></div>
        </div>

    </div>
    <div class="row w-75 mx-auto ">


        <div class="col-6 d-flex">
            <a data-bs-toggle="modal" data-bs-target="#exampleModal" class="w-100">
                <div id="map" style="height: 400px; width: 100%;" class="mt-3 flex-fill"></div>
            </a>
        </div>


        <div class="col-6 d-flex">
            <div id="photo-container" class="mt-3 flex-fill bg-light d-flex justify-content-center align-items-center">
                <p>Immagine della destinazione <br> non disponibile!</p>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalSearchedCity">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <!-- Mappa che riempie la larghezza e altezza del modale -->
                    <div id="map_modal" class="w-100" style="height: 600px;"></div>
                </div>

            </div>
        </div>
    </div>

</div>
