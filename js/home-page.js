(function () {
    const flipdown = new FlipDown(1621314000);
    flipdown.start();


    /**
     * Add to cart
     */
    const notificationContainer = document.querySelector("#notification");
    const addToCart = (e) => {
        let loader = new Notification(notificationContainer, { type: "loader" } );
        loader.init(15000);
    }

    let addToCartButtons = document.getElementsByClassName("addToCartBtn");
    for (let i = 0, max = addToCartButtons.length; i < max; i += 1) {
        addToCartButtons[i].addEventListener("click", addToCart);
    }
})();