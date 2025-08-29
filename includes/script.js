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


// let count = 0;
// let wishlist = document.querySelectorAll(".wishlist");
// let wishlistCount = document.querySelector(".wishlistCount");
//     wishlist.forEach(function(btn) {
//         btn.addEventListener('click', ()=>{
//             count++;
//             wishlistCount.textContent = count;
//             alert("wishlist was clicked")
//         })
//     })