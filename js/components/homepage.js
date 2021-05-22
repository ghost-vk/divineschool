(function ($) {
    const state = store.getState("homepage");
    let timeTo = state.countdownTime;

    if (timeTo) {
        const flipdown = new FlipDown(Number(timeTo));
        flipdown.start();
    }

    /**
     * Add to cart
     */
    const notificationContainer = document.querySelector("#notification");
    const addToCart = (e) => {
        let notification = new Notification(notificationContainer, { type: "loader" } );
        let productID = e.target.dataset.id;
        let state, data, notificationText;
        state = store.getState("general");
        data = {
            nonce: state.nonce,
            action: "add_course_to_cart",
            id: productID
        }

        const showResponse = (notification, text) => {
            notification.destroy();
            notification.setOption({ type: "text-content", text: text });
            notification.init(3500);
        }

        const showCart = () => {
            document.querySelector("#headerCart").classList.add("header__link-cart-active");
        }

        notification.init(15000);
        $.post(state.ajaxUrl, data)
            .done(function (response) {
                let status = response.status;
                switch (status) {
                    case "success" : {
                        notificationText = "Добавлено в корзину";
                        showResponse(notification, notificationText);
                        showCart();
                        break;
                    }
                    case "fail" : {
                        notificationText = "Ошибка, попробуйте перезагрузить страницу";
                        showResponse(notification, notificationText);
                        break;
                    }
                }
            })
            .fail(function () {
                notificationText = "Ошибка, перезагрузите страницу";
                showResponse(notification, notificationText);
            });
    }

    let addToCartButtons = document.getElementsByClassName("addToCartBtn");
    for (let i = 0, max = addToCartButtons.length; i < max; i += 1) {
        addToCartButtons[i].addEventListener("click", addToCart);
    }

    $(document).ready(function () {
        let questionIcons = $('.courseProgram__icon');
        questionIcons.viewportChecker({classToAdd: 'animate__heartBeat'});
    });
})(jQuery);