document.addEventListener("DOMContentLoaded", function() {
    const backToTop = document.querySelector('.back-to-top');

    // Show or hide button on scroll
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            backToTop.style.display = "flex";
        } else {
            backToTop.style.display = "none";
        }
    });

    // Smooth scroll to top
    backToTop.addEventListener('click', (e) => {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});


// Ensure the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {

    // Carousel
    const carousel = document.querySelector('.carousel');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');

    function scrollByCard(direction) {
        const card = carousel.querySelector('.card');
        if (!card) return;
        const gap = parseInt(getComputedStyle(carousel).gap) || 18;
        const scrollAmount = card.getBoundingClientRect().width + gap;
        carousel.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
    }

    if(prevBtn) prevBtn.addEventListener('click', () => scrollByCard(-1));
    if(nextBtn) nextBtn.addEventListener('click', () => scrollByCard(1));

    // Login check from PHP
    const isLoggedIn = typeof phpIsLoggedIn !== 'undefined' ? phpIsLoggedIn : false;

    // Cart & Wishlist badges
    const navbarCartBadge = document.getElementById('navbar-cart-badge');
    const navbarWishlistBadge = document.getElementById('navbar-wishlist-badge');

    function updateCart(count) { if(navbarCartBadge) navbarCartBadge.textContent = count; }
    function updateWishlist(count) { if(navbarWishlistBadge) navbarWishlistBadge.textContent = count; }

    // Add to Cart
    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', () => {
            if (!isLoggedIn) return window.location.href = 'login.php';
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-cart-plus"></i> Added';
            let count = parseInt(navbarCartBadge.textContent) + 1;
            updateCart(count);

            // TODO: AJAX request to update cart in database
        });
    });

    // Add to Wishlist
    document.querySelectorAll('.add-to-wishlist').forEach(btn => {
        btn.addEventListener('click', () => {
            if (!isLoggedIn) return window.location.href = 'login.php';
            const icon = btn.querySelector('i');
            icon.classList.toggle('far');
            icon.classList.toggle('fas');
            let count = parseInt(navbarWishlistBadge.textContent) + 1;
            updateWishlist(count);

            // TODO: AJAX request to update wishlist in database
        });
    });
});
