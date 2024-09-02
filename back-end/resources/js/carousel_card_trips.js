async function fetchTrips() {
    try {
        // Effettuo la richiesta GET all'API
        const response = await fetch('http://localhost:8000/api/v1/trips');

        // Verifico se la risposta è ok
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }

        // Dati JSON dalla risposta
        const data = await response.json();

        return data;
    } catch (error) {
        console.error('There has been a problem with your fetch operation:', error);
        return []; // Array vuoto in caso di errore
    }
}

async function carousel() {
    // RECUPERO i dati delle card
    const cardsData = await fetchTrips();

    // RECUPERO l'elemento contenitore
    const carosello = $('#carosello-card');

    // Pulisco il contenitore esistente
    carosello.empty();

    // DEBUG
    // console.log(cardsData);
    
    // NUMERO RANDOM DEI VIAGGI DA PRENDERE - MIN 5 - MASSIMO 8
    let randomTrips = Math.floor(Math.random() * ((cardsData.length - 2) - 5 + 1)) + 5;

    for (let i = 0; i < randomTrips; i++) {
        if (cardsData[i].immagine == null && cardsData[i].votazione != null) {
            continue;
        }
        // DEBUG
        // console.log(cardsData[i].users[0].name)

        const cardHTML = `
        
                <div class="item d-flex flex-column align-items-center px-3" style="height: 480px;width:430px;">
                     <div class="profile-container mb-2">
            <img src="/storage/${cardsData[i].users[0].immagine_url}" alt="Profile Picture" class=" rounded-circle w-auto">
            <span class="profile-name">${cardsData[i].users[0].name}</span>
        </div>
                    <div class="card travel-card w-75">
                        <img src="/storage/${cardsData[i].immagine}" class="card-img-top travel-card-img" alt="${cardsData[i].nome} ">
                        <div class="card-body travel-card-body">
                            <h5 class="card-title">${cardsData[i].nome}</h5>
                            <p class="card-text">${cardsData[i].descrizione}</p>
                        </div>
                    </div>
                   
                </div>
               `;
        let starsHTML = '';
        for (let j = 1; j <= 5; j++) {
            starsHTML += `
                    <i class="fas fs-5 fa-star ${j <= cardsData[i].votazione ? 'text-warning' : ''}" data-value="${j}"></i>
                `;
        }

        const div = document.createElement('div');
        div.classList.add('d-flex','flex-column','align-items-center')
        div.innerHTML = cardHTML;
        const div2 = document.createElement('div');
        div2.style.marginTop="40px";
        div2.innerHTML= starsHTML;
        div.append(div2);
        carosello.append(div);

    }



    // Owl Carousel
    carosello.owlCarousel({
        loop: true, // Attivo lo scorrimento infinito
        margin: 20, // Spazio tra le slide
        nav: false, // Disattivo le frecce di navigazione
        autoplay: true, // Attivo la riproduzione automatica
        autoplayTimeout: 4000, // Durato di ogni slide in millisecondi
        mouseDrag: false, // Disattivo il drag con il mouse
        touchDrag: false, // Disattivo il drag con il tocco
        responsive: {
            0: {
                items: 1 // 1 elemento per schermi piccoli
            },
            600: {
                items: 2 // 2 elementi per schermi medi
            },
            1000: {
                items: 3 // 4 elementi per schermi grandi
            },
            1190: {
                items: 4 // 4 elementi per schermi grandi
            }
        }
    });
}