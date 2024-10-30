document.addEventListener("DOMContentLoaded", function () {
    // Modal Connexion
    var modal = document.getElementById("myModal");
    var btn = document.getElementById("connexionBtn");
    var span = document.querySelector(".close");

    var registerBtn = document.getElementById("registerBtn");
    if (registerBtn) {
        registerBtn.onclick = function () {
            window.location.href = "register.php";
        };
    }

    if (btn) {
        btn.onclick = function () {
            if (modal) modal.style.display = "block";
        };
    }

    if (span) {
        span.onclick = function () {
            if (modal) modal.style.display = "none";
        };
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
});

// Carousel JS
const track = document.querySelector('.carousel-track');
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');
const items = document.querySelectorAll('.carousel-item');

if (track && prevButton && nextButton && items.length > 0) {
    let currentIndex = 0;
    const itemsToShow = 3; // Number of items to show at a time
    const totalItems = items.length;

    function updateCarousel() {
        const itemWidth = items[0].getBoundingClientRect().width;
        const newPosition = -currentIndex * itemWidth;
        track.style.transform = `translateX(${newPosition}px)`;
    }

    // Bouton suivant
    nextButton.addEventListener('click', () => {
        if (currentIndex < totalItems - itemsToShow) {
            currentIndex++;
            updateCarousel();
        }
    });

    // Bouton précédent
    prevButton.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel();
        }
    });
}
