import { fetchCityPhotos } from "./search_city_image.js";
document.getElementById("search_city").addEventListener("input", function () {
    const query = document.getElementById("search_city").value;

    if (query.length < 3) {
        document.getElementById("results").classList.remove("border");
        document.getElementById("results").classList.remove("mt-2");
        document.getElementById("results").innerHTML = "";
        return;
    }

    const url = `https://api.tomtom.com/search/2/search/${query}.json?key=JaJJHJ6GGLUhADXt9Iuu4C5oaRT5Ah96&typeahead=true&limit=5&entityTypeSet=Municipality`;

    fetch(url)
        .then((response) => response.json())
        .then((data) => {
            document
                .getElementById("results")
                .classList.remove("border", "mt-2");
            document.getElementById("results").innerHTML = "";
            if (data.results) {
                document
                    .getElementById("results")
                    .classList.add("border", "mt-2");
                data.results.forEach((result) => {
                    const item = document.createElement("div");
                    item.classList.add("result-item");
                    item.innerHTML += `${result.address.freeformAddress} ,${result.address.country}`;
                    item.addEventListener("click", () => selectCity(result));
                    document.getElementById("results").appendChild(item);
                });
            }
        })
        .catch((error) => {
            console.error("Errore nella richiesta:", error);
        });
});

function selectCity(city) {
    let map;
    let map_modal;
    let marker;
    let marker_modal;
    fetchCityPhotos(city.address.freeformAddress);
    document.getElementById("search_city").value = city.address.freeformAddress;
    // PER IL MODALE(NOME)
    document.getElementById("ModalSearchedCity").innerHTML =
        city.address.freeformAddress;
    document.getElementById("results").innerHTML = "";
    document.getElementById("results").classList.remove("mt-2");
    document
        .getElementById("map")
        .parentElement.parentElement.classList.remove("d-none");
    if (!map) {
        map = tt.map({
            key: "JaJJHJ6GGLUhADXt9Iuu4C5oaRT5Ah96",
            container: "map",
            center: [city.position.lon, city.position.lat],
            zoom: 13,
        });
        map_modal = tt.map({
            key: "JaJJHJ6GGLUhADXt9Iuu4C5oaRT5Ah96",
            container: "map_modal",
            center: [city.position.lon, city.position.lat],
            zoom: 10,
        });
        document.getElementById("map").classList.add("drop-in-image");
    } else {
        map.setCenter([city.position.lon, city.position.lat]);
        map_modal.setCenter([city.position.lon, city.position.lat]);
    }
    $("#exampleModal").on("shown.bs.modal", function () {
        document.getElementById("nav_bar").style.display = "none";
        if (map_modal) {
            // Ricalcola la dimensione della mappa nel modale
            map_modal.resize();
        }
    });
    if (marker) {
        marker.remove();
    }

    marker = new tt.Marker()
        .setLngLat([city.position.lon, city.position.lat])
        .addTo(map, map_modal);
    marker_modal = new tt.Marker()
        .setLngLat([city.position.lon, city.position.lat])
        .addTo(map_modal);
    marker.getElement().addEventListener("click", () => {
        const latitude = city.position.lon;
        const longitude = city.position.lat;
        console.log(latitude);
        const googleMapsUrl = `https://www.google.com/maps?q=${longitude},${latitude}`;
        window.open(googleMapsUrl, "_blank");
    });
}
