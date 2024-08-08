document.getElementById("search_city").addEventListener("input", function () {
    const query = document.getElementById("search_city").value;

    if (query.length < 3) {
        document.getElementById("results").innerHTML = "";
        return;
    }

    const url = `https://api.tomtom.com/search/2/search/${query}.json?key=JaJJHJ6GGLUhADXt9Iuu4C5oaRT5Ah96&typeahead=true&limit=5&entityTypeSet=Municipality`;

    fetch(url)
        .then((response) => response.json())
        .then((data) => {
            document.getElementById("results").innerHTML = "";
            if (data.results) {
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
    let marker;
    document.getElementById("search_city").value = city.address.freeformAddress;
    document.getElementById("results").innerHTML = "";

    if (!map) {
        map = tt.map({
            key: "JaJJHJ6GGLUhADXt9Iuu4C5oaRT5Ah96",
            container: "map",
            center: [city.position.lon, city.position.lat],
            zoom: 10,
        });
    } else {
        map.setCenter([city.position.lon, city.position.lat]);
    }

    if (marker) {
        marker.remove();
    }

    marker = new tt.Marker()
        .setLngLat([city.position.lon, city.position.lat])
        .addTo(map);
}
