async function fetchCityPhotos(city) {
    console.log(city);
    const accessKey = "QngG7sfBVMWvG3kVsWuLqkCRWftkIHIqNHRRsI6fp0I"; // Sostituisci con la tua chiave API
    const url = `https://api.unsplash.com/search/photos?query=${city}`;
    try {
        const response = await fetch(`${url}&client_id=${accessKey}`);
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        const data = await response.json();
        displayPhotos(data.results, city);
    } catch (error) {
        console.error("Error fetching photos:", error);
    }
}

function displayPhotos(photos, city) {
    const container = document.getElementById("photo-container");
    container.innerHTML = ""; // PULISCE IL CONTENITORE
    container.parentElement.classList.remove('d-none'); //RIMUOVE IL DISPLAY NONE
    console.log("search_city.js" + photos);

    let numberCasual = Math.round(getRandomDecimal(0, photos.length - 1));
    console.log(numberCasual);
    if (
        (photos[numberCasual].description &&
            photos[numberCasual].description.toLowerCase().includes("city")) ||
        (photos[numberCasual].tags[0] &&
            photos[numberCasual].tags[0].title
                .toLowerCase()
                .includes(city.toLowerCase()))
    ) {
        const img = document.createElement("img");
        img.src = photos[numberCasual].urls.regular;
        img.alt = photos[numberCasual].description || "Photo";
        img.style.height="400px";
        img.classList.add("drop-in-image","w-100","object-fit-cover");
        container.appendChild(img);
    }
}

function getRandomDecimal(min, max) {
    return Math.random() * (max - min) + min;
}
export { fetchCityPhotos, displayPhotos };
