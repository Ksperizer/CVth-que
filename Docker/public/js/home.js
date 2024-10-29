document.addEventListener("DOMContentLoaded", function () {
    // Modal Connexion
    var modal = document.getElementById("myModal");
    var btn = document.getElementById("connexionBtn");
    var span = document.querySelector(".close"); 

    // Redirect to register page
    document.getElementById("registerBtn").onclick = function() {
        window.location.href = "register.php";
    };

    // Open modal when button is clicked
    btn.onclick = function() {
        modal.style.display = "block";
    };

    // Close modal when "X" is clicked
    span.onclick = function() {
        modal.style.display = "none";
    };

    // Close modal if user clicks outside the modal
    window.onclick = function(event) {
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
let currentIndex = 0;
const itemsToShow = 3; // Number of items to show at a time
const totalItems = items.length;

function updateCarousel() {
    const itemWidth = items[0].getBoundingClientRect().width;
    const newPosition = -currentIndex * itemWidth;
    track.style.transform = `translateX(${newPosition}px)`;
}

// next button
nextButton.addEventListener('click', () => {
    if (currentIndex < totalItems - itemsToShow) {
        currentIndex++;
        updateCarousel();
    }
});

// previous button
prevButton.addEventListener('click', () => {
    if (currentIndex > 0) {
        currentIndex--;
        updateCarousel();
    }
});
