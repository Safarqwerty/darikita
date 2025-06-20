document.addEventListener("DOMContentLoaded", function () {
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById("mobile-menu-button");
    const mobileMenu = document.getElementById("mobile-menu");

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener("click", function () {
            mobileMenu.classList.toggle("hidden");

            // Update button icon
            const svg = mobileMenuButton.querySelector("svg");
            if (mobileMenu.classList.contains("hidden")) {
                svg.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
            } else {
                svg.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
            }
        });
    }

    // Profile dropdown toggle (desktop)
    const userMenuButton = document.getElementById("user-menu-button");
    const userDropdown = document.getElementById("user-dropdown");

    if (userMenuButton && userDropdown) {
        userMenuButton.addEventListener("click", function (e) {
            e.stopPropagation();
            userDropdown.classList.toggle("hidden");
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", function (e) {
            if (
                !userMenuButton.contains(e.target) &&
                !userDropdown.contains(e.target)
            ) {
                userDropdown.classList.add("hidden");
            }
        });
    }

    // Close mobile menu when clicking on links
    const mobileLinks = mobileMenu?.querySelectorAll("a");
    if (mobileLinks) {
        mobileLinks.forEach((link) => {
            link.addEventListener("click", function () {
                mobileMenu.classList.add("hidden");
                const svg = mobileMenuButton.querySelector("svg");
                svg.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
            });
        });
    }
});
// Initialize AOS
AOS.init({
    duration: 800,
    easing: "ease-in-out",
    once: true,
});

// Back to top button
const backToTopButton = document.getElementById("back-to-top");
window.addEventListener("scroll", () => {
    if (window.pageYOffset > 300) {
        backToTopButton.classList.remove("opacity-0", "invisible");
        backToTopButton.classList.add("opacity-100", "visible");
    } else {
        backToTopButton.classList.remove("opacity-100", "visible");
        backToTopButton.classList.add("opacity-0", "invisible");
    }
});
backToTopButton.addEventListener("click", () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
});

// Mobile menu toggle (pakai struktur baru)
const mobileMenuButton = document.getElementById("mobileMenuButton");
const mobileMenu = document.querySelector(".mobile-menu");

mobileMenuButton.addEventListener("click", () => {
    mobileMenu.classList.toggle("hidden");
});

// Sembunyikan menu mobile jika layar diperbesar
window.addEventListener("resize", () => {
    if (window.innerWidth >= 768) {
        mobileMenu.classList.add("hidden");
    }
});
