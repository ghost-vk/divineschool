(function ($) {
    const state = store.getState("homepage");
    let timeTo = state.countdownTime;

    if (timeTo) {
        const flipdown = new FlipDown(Number(timeTo));
        flipdown.start();
    }

    function showResponse(notification, text) {
        notification.destroy();
        notification.setOption({ type: "text-content", text: text });
        notification.init(3500);
    }

    /**
     * Add to cart
     */
    const notificationContainer = document.querySelector("#notification");
    const addToCart = (e) => {
        let notification = new Notification(notificationContainer, { type: "loader" } );
        let productID = e.target.dataset.id;
        let state, data, notificationText;
        let packageID = e.target.getAttribute('data-package');
        state = store.getState("general");
        data = {
            nonce: state.nonce,
            action: "add_course_to_cart",
            id: productID
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
                        if (typeof ym === 'function' && packageID) {
                            analytics.send('add_to_cart_full_' + packageID);
                        }
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

    // Discount after header row
    let saleIcon = document.querySelector(".saleHeaderRow #sale-icon"),
        saleBubble = saleIcon.parentNode.querySelector(".saleHeaderRow__bubble");
    if ( saleIcon && saleBubble ) {
        saleIcon.addEventListener("click", function (e) {
            e.stopPropagation();
            saleBubble.style.display = "block";
        });
        window.addEventListener('click', function (e) {
            let target = e.target;
            if (!saleBubble.contains(target) && !saleIcon.contains(target)) {
                saleBubble.style.display = "none";
            }
        });
    }

    // Discount popup
    let discountModal = document.querySelector('#discountModal'),
        lidFormWrapper = document.querySelector('#lidFormWrapper');
    if (discountModal && Cookies.get('DISCOUNT_FOR_LID') !== 'true') {
        // set timeout блок прокрутки + показываем скидку если не установлена кука
        function showDiscountModal() {
            discountModal.classList.remove('d-none');
            discountModal.classList.add('d-block');
        }
        setTimeout(showDiscountModal, 5000);

        let discountBody = discountModal.querySelector('.discountModal__wrapper'),
            discountCloseBtn = discountBody.querySelector('.discountModal__close'),
            discountSubmit = discountBody.querySelector('.discountModal__button');
        // Close promo on outer click
        window.addEventListener('click', function (e) {
            if (discountModal.classList.contains('d-block')) {
                if (!discountBody.contains(e.target) || discountCloseBtn.contains(e.target)) {
                    discountModal.classList.remove('d-block');
                    discountModal.classList.add('d-none');
                }
            }
        });
        // Close promo and show lid form
        discountSubmit.addEventListener('click', function () {
            discountModal.classList.remove('d-block');
            discountModal.classList.add('d-none');
            lidFormWrapper.classList.remove('d-none');
            lidFormWrapper.classList.add('d-block');
        });

        let lidForm = lidFormWrapper.querySelector('#lidForm'),
            lidFormCloseBtn = lidForm.querySelector('#closeLidForm'),
            lidFormSubmit = lidForm.querySelector('#lidFormSubmit'),
            lidFormErrorContainer = lidForm.querySelector('#lidFormError'),
            lidFormNameInput = lidForm.querySelector('#lidName'),
            lidFormPhoneInput = lidForm.querySelector('#lidPhone'),
            lidFormEmailInput = lidForm.querySelector('#lidEmail'),
            lidFormInstagramInput = lidForm.querySelector('#lidInstagram'),
            lidFormCheck = lidForm.querySelector('#lidFormCheck');
        // Close lid form
        lidFormCloseBtn.addEventListener('click', function () {
            lidFormWrapper.classList.remove('d-block');
            lidFormWrapper.classList.add('d-none');
        });
        // Function validates form
        function validateForm() {
            let response = {status: true, message: null},
                isSpaceInName = lidFormNameInput.value.indexOf(' ') >= 0,
                isNameLongEnough = lidFormNameInput.value.length > 6;
            if (!isSpaceInName || !isNameLongEnough) {
                response.status = false;
                response.message = 'Введите вашу Фамилию, Имя и Отчество(при наличии)';
                return response;
            }

            let isPhoneRight = !(/[\p{Alpha}\p{M}\p{Pc}]/gu).test(lidFormPhoneInput.value),
                isPhoneLengthEnough = lidFormPhoneInput.value.length > 8;
            if (!isPhoneLengthEnough || !isPhoneRight) {
                response.status = false;
                response.message = 'Введите ваш номер телефона';
                return response;
            }

            let emailRegexp = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (lidFormEmailInput.value.length < 8 || !emailRegexp.test(lidFormEmailInput.value)) {
                response.status = false;
                response.message = 'Введите ваш email адрес';
                return response;
            }

            if (lidFormInstagramInput.value.length < 6) {
                response.status = false;
                response.message = 'Введите ссылку или ваш ник в Instagram';
                return response;
            }

            if (!lidFormCheck.checked) {
                response.status = false;
                response.message = 'Обязательно согласие с Политикой конфиденциальности';
                return response;
            }

            return response;
        }
        function collectFormData() {
            return {
                name: lidFormNameInput.value,
                phone: lidFormPhoneInput.value,
                instagram: lidFormInstagramInput.value,
                email: lidFormEmailInput.value
            }
        }
        // Handle form
        lidFormSubmit.addEventListener('click', function (e) {
            e.preventDefault();
            let validateResponse = validateForm();
            if (validateResponse.status === true) {
                lidFormErrorContainer.innerHTML = '';
                lidFormErrorContainer.classList.remove('d-block');
                lidFormErrorContainer.classList.add('d-none');
                let notification = new Notification(notificationContainer, { type: "loader" } );
                notification.init(15000);
                lidFormWrapper.classList.remove('d-block');
                lidFormWrapper.classList.add('d-none');
                let state = store.getState("general"),
                    data = collectFormData();
                data.action = 'save_lid';
                data.nonce = state.nonce;
                let notificationText;
                $.post(state.ajaxUrl, data)
                    .done(function (response) {
                        let status = response.status;
                        switch (status) {
                            case "success" : {
                                notificationText = "Скидка добавлена!";
                                showResponse(notification, notificationText);
                                if (typeof Cookies === 'undefined') {
                                    return;
                                }
                                Cookies.set('DISCOUNT_FOR_LID', 'true', { expires: 7 });
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
            } else {
                lidFormErrorContainer.classList.remove('d-none');
                lidFormErrorContainer.classList.add('d-block');
                lidFormErrorContainer.innerHTML = validateResponse.message;
            }
        });
    }
})(jQuery);