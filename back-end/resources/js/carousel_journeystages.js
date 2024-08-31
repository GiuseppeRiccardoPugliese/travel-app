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
    // console.log(Object.keys(cardsData).length);
    Object.keys(cardsData).forEach((key) => {

        // Accedo all'oggetto corrente
        const card = cardsData[key];

        // DEBUG: verifica dell'oggetto corrente
        // console.log(card);

        // Condizione per eliminare l'elemento
        if (card.trip.immagine == null && card.votazione != null) {
            delete cardsData[key];
            return; // Continua al prossimo elemento
        }

        //  Card html
        const cardHTML = `
            <div class="item d-flex flex-column align-items-center px-3 py-3" style="height: 480px;">
                <div class="card travel-card">
                    <img src="/storage/${card.trip.immagine}" class="card-img-top travel-card-img" alt="${card.nome}">
                    <div class="card-body travel-card-body">
                        <h5 class="card-title">${card.nome}</h5>
                        <p class="card-text">${card.descrizione}</p>
                    </div>
                </div>
            </div>
        `;

        // Creo del div contenitore
        const div = document.createElement("div");
        div.classList.add("d-flex", "flex-column", "align-items-center");
        div.innerHTML = cardHTML;

        // Aggiunta del div al carosello
        carosello.append(div);
    });

    console.log(Object.keys(cardsData).length);
    const itemsToShow =
        Object.keys(cardsData).length > 1
            ? {
                  0: {
                      items: 1, // Mostra 1 elemento per schermi piccoli
                  },
                  600: {
                      items: Math.max(
                          1,
                          Math.min(Object.keys(cardsData).length, 2)
                      ), // Mostra almeno 2 elementi per schermi medi, fino a 2 se disponibili
                  },
                  1000: {
                      items: Math.max(
                          1,
                          Math.min(Object.keys(cardsData).length, 4)
                      ), // Mostra tra 2 e 4 elementi per schermi grandi, a seconda della disponibilità
                  },
              }
            : {
                  0: {
                      items: 1, // Mostra 1 elemento per tutti i casi se ne hai solo 1
                  },
                  600: {
                      items: 1, // Mostra 1 elemento per tutti i casi se ne hai solo 1
                  },
                  1000: {
                      items: 1, // Mostra 1 elemento per tutti i casi se ne hai solo 1
                  },
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
        responsive: itemsToShow,
    });
}
