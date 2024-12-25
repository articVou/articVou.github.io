function searchGallery() {
    const input = document.getElementById("search-input").value.toLowerCase();
    const galleryItems = document.querySelectorAll(".gallery-container div");

    galleryItems.forEach(item => {
        const altText = item.querySelector("img").alt.toLowerCase();

        // Tampilkan/hilangkan item berdasarkan pencarian
        if (altText.includes(input)) {
            item.style.display = "block";
        } else {
            item.style.display = "none";
        }
    });
}

