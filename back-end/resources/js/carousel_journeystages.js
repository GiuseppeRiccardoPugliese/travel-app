async function getTopRatedStages(userId) {
    try {
        //Chiamata API
        const response = await fetch(
            "http://localhost:8000/api/v1/favorites-journey-stages",
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                // Invio l'ID dell'utente nella richiesta
                body: JSON.stringify({
                    user_id: userId,
                }),
            }
        );

        // console.log("Status:", response.status);
        // console.log("Status Text:", response.statusText);

        // Verifico la risposta
        if (!response.ok) {
            throw new Error(
                `Network response was not ok: ${response.statusText}`
            );
        }

        // Dati JSON dalla risposta
        const data = await response.json();

        // Log dati nella console
        // console.log(data);
        return data;
    } catch (error) {
        console.error("Error fetching top-rated stages:", error);
    }
}
async function carousel(id) {
    // RECUPERO i dati delle card
    const cardsData = await getTopRatedStages(id);
    // console.log(cardsData);

    // RECUPERO l'elemento contenitore
    const carosello = $("#carosello-journey-card");

    // Pulisco il contenitore esistente
    carosello.empty();

    // DEBUG
    // console.log(Object.keys(cardsData).length);

    for (let i = 0; i < Object.keys(cardsData).length; i++) {
        // console.log(cardsData[i]);
        if (
            cardsData[i].trip.immagine == null &&
            cardsData[i].votazione != null
        ) {
            delete cardsData[i];
            continue;
        }
        // DEBUG
        // console.log(cardsData[i].trip.immagine);

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
    // console.log(Object.keys(cardsData).length);
    const itemsToShow =
        Object.keys(cardsData).length > 1
            ? {
                  0: {
                      items: 1, // Mostro 1 elemento per schermi piccoli
                  },
                  600: {
                      items: Math.max(
                          1,
                          Math.min(Object.keys(cardsData).length, 2)
                      ), // Mostro almeno 2 elementi per schermi medi, fino a 2 se disponibili
                  },
                  1000: {
                      items: Math.max(
                          1,
                          Math.min(Object.keys(cardsData).length, 4)
                      ), // Mostro tra 2 e 4 elementi per schermi grandi, a seconda della disponibilità
                  },
              }
            : {
                  0: {
                      items: 1, // Mostro 1 elemento per tutti i casi se ne hai solo 1
                  },
                  600: {
                      items: 1, // Mostro 1 elemento per tutti i casi se ne hai solo 1
                  },
                  1000: {
                      items: 1, // Mostro 1 elemento per tutti i casi se ne hai solo 1
                  },
              };
    //Owl Carousel
    carosello.owlCarousel({
        loop: true, // Scorrimento infinito
        margin: 20, // Spazio tra le slide
        nav: false, // Disattivo le frecce di navigazione
        autoplay: true, // Attivo la riproduzione automatica
        autoplayTimeout: 4000, // Durata di ogni slide in millisecondi
        mouseDrag: false, // Disattivo il drag con il mouse
        touchDrag: false, // Disattivo il drag con il tocco
        responsive: itemsToShow,
    });
}
