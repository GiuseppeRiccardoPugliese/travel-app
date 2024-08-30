async function getTopRatedStages(userId) {
    try {
        // Esegui la chiamata alla tua API
        const response = await fetch(
            "http://localhost:8000/api/v1/favorites-journey-stages",
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                // Invia l'ID dell'utente nel corpo della richiesta
                body: JSON.stringify({
                    user_id: userId,
                }),
            }
        );

        // Logga il codice di stato e il testo della risposta
        console.log("Status:", response.status);
        console.log("Status Text:", response.statusText);

        // Verifica se la risposta è ok
        if (!response.ok) {
            throw new Error(
                `Network response was not ok: ${response.statusText}`
            );
        }

        // Ottieni i dati JSON dalla risposta
        const data = await response.json();

        // Logga i dati nella console o gestiscili come preferisci
        // console.log(data);
        return data;
    } catch (error) {
        console.error("Error fetching top-rated stages:", error);
    }
}
async function carousel(id) {
    // RECUPERO i dati delle card
    const cardsData = await getTopRatedStages(id);
    console.log(cardsData);

    // RECUPERO l'elemento contenitore
    const carosello = $("#carosello-journey-card");

    // Pulisco il contenitore esistente
    carosello.empty();

    // DEBUG
    // console.log(cardsData);

    for (let i = 0; i < cardsData.length ; i++) {
        if (cardsData[i].trip.immagine == null && cardsData[i].votazione != null) {
            continue;
        }
        // DEBUG
        // console.log(cardsData[i].name)

        const cardHTML = `
        
                <div class="item d-flex flex-column align-items-center px-3 py-3" style="height: 480px;">
                    <div class="card travel-card">
                        <img src="/storage/${cardsData[i].trip.immagine}" class="card-img-top travel-card-img" alt="${cardsData[i].nome}">
                        <div class="card-body travel-card-body">
                            <h5 class="card-title">${cardsData[i].nome}</h5>
                            <p class="card-text">${cardsData[i].descrizione}</p>
                        </div>
                    </div>
                   
                </div>
               `;
        
        const div = document.createElement("div");
        div.classList.add("d-flex", "flex-column", "align-items-center");
        div.innerHTML = cardHTML;
        carosello.append(div);
    }
    const itemsToShow = (cardsData.length > 1) ? {
        0: {
            items: 1, // Mostra 1 elemento per schermi piccoli
        },
        600: {
            items: Math.min(cardsData.length, 2), // Mostra 2 elementi per schermi medi, o meno se non ci sono 2 elementi
        },
        1000: {
            items: Math.min(cardsData.length, 4), // Mostra fino a 4 elementi per schermi grandi, o meno se non ci sono 4 elementi
        }
    } : {
        0: {
            items: 1, // Mostra 1 elemento per tutti i casi se ne hai solo 1
        },
        600: {
            items: 1, // Mostra 1 elemento per tutti i casi se ne hai solo 1
        },
        1000: {
            items: 1, // Mostra 1 elemento per tutti i casi se ne hai solo 1
        }
    };
    // Inizializza Owl Carousel
    carosello.owlCarousel({
        loop: true, // Attiva lo scorrimento infinito
        margin: 20, // Spazio tra le slide
        nav: false, // Disattiva le frecce di navigazione
        autoplay: true, // Attiva la riproduzione automatica
        autoplayTimeout: 4000, // Durata di ogni slide in millisecondi
        mouseDrag: false, // Disattiva il drag con il mouse
        touchDrag: false, // Disattiva il drag con il tocco
        responsive: itemsToShow
    });
}
