(function () {
    let mobileMenuBtn = document.querySelector("#mobileMenuBtn"),
        mobileMenu = document.querySelector("#mobileMenu"),
        closeMenuBtn = document.querySelector("#closeMenuBtn");

    /**
     * Function opens and close mobile menu
     */
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener("click", () => {
            mobileMenu.classList.toggle("active");
        });
    }

    /**
     * Close menu
     */
    if (closeMenuBtn) {
        closeMenuBtn.addEventListener("click", () => {
            mobileMenu.classList.remove("active");
        });
    }

    /**
     * Smooth scroll
     */
    const smoothScroll = new SmoothScroll('a[href*="#"]', {
            offset: () => {
                let offset = 100;
                if (window.innerWidth < 1200) {
                    offset = 450;
                }
                return offset;
            }
        }
    );
})();