function getImage() {
    const urlChiamata =
        'https://api.unsplash.com/search/photos?query=New+York,Paris,Tokyo,Rome,Italy&per_page=30&page=1&client_id=QngG7sfBVMWvG3kVsWuLqkCRWftkIHIqNHRRsI6fp0I';
    fetch(urlChiamata)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            // Recupera l'elemento contenitore
            const carosello = document.getElementById('carosello');

            // Crea un frammento di documento
            const fragment = document.createDocumentFragment();

            let citySearch;
            // Popola l'array delle immagini e crea gli elementi
            data.results.forEach(element => {
                const url = element.urls.full;

                citySearch = element.tags[0].title;
                if (element.tags[0].title == citySearch || element.tags[0].title == 'city') {
                    // DEBUG
                    // console.log(element.tags[1].title)
                }
                // Nuovo elemento div con classe 'item'
                const newItem = document.createElement('div');
                newItem.className = 'item';
                newItem.classList.add('position-relative')

                // Nuovo elemento img
                const newImg = document.createElement('img');
                newImg.src = url;
                newImg.alt = 'Image';

                const titleDestination = document.createElement('span');
                titleDestination.innerHTML = capitalizeFirstLetter(citySearch);
                titleDestination.classList.add('position-absolute', 'bottom-0', 'start-0',
                'text-white');
                titleDestination.style='font-size : 20px;'
                newItem.appendChild(titleDestination);
                // appendo l'immagine all'elemento div
                newItem.appendChild(newImg);

                // nuovo div al frammento di documento
                fragment.appendChild(newItem);
            });

            function capitalizeFirstLetter(str) {
                if (str.length === 0) return str; // Gestione caso di una stringa vuota
                return str.charAt(0).toUpperCase() + str.slice(1);
            }




            // Aggiungo il frammento di documento al contenitore
            carosello.appendChild(fragment);

            // Owl Carousel dopo aver aggiunto tutte le immagini
            $(carosello).owlCarousel({
                loop: true, // Attivo lo scorrimento infinito
                margin: 20, // Spazio tra le slide
                nav: false, // Attivo le frecce di navigazione
                autoplay: true, // Attivo la riproduzione automatica
                autoplayTimeout: 3000, // Durata di ogni slide in millisecondi
                mouseDrag: false, // Abilito il drag con il mouse
                touchDrag: false, // Abilito il drag con il tocco
                responsive: {
                    0: {
                        items: 1 // 1 elemento per schermi piccoli
                    },
                    600: {
                        items: 1 // 1 elemento per schermi medi
                    },
                    1000: {
                        items: 1 // 1 elemento per schermi grandi
                    }
                }
            });
        })
        .catch(error => {
            console.error('There has been a problem with your fetch operation:', error);
        });
}