document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("myModal");
    const editButton = document.getElementById("editBtn");
    const closeButton = document.querySelector(".close");

    
    editButton.addEventListener("click", function () {
        modal.style.display = "flex"; // Affiche la modale
    });

    closeButton.addEventListener("click", function () {
        modal.style.display = "none"; // Cache la modale
    });

    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none"; // Cache la modale
        }
    });
});
