var MOROZ = MOROZ || {};

MOROZ.Popup = {}; // Popup class

MOROZ.Popup.checker = {}; // Validation object

/**
 * Response content
 */
MOROZ.Popup.response = {
    "popup-lid": {
        textMain: 'Спасибо! В скором времени мы с вами свяжемся.',
        eTextMain: 'Упс... Что-то пошло не так.<br />' +
            'Попробуйте ещё раз, если не получится - напишите в техподдержку'
    },
    "popup-login": {
        textMain: 'Вход успешно выполнен',
        eTextMain: 'Логин или пароль не верны'
    },
    "popup-registration": {
        textMain: 'Спасибо! В скором времени мы с вами свяжемся.',
        eTextMain: 'Упс... Что-то пошло не так.<br />' +
            'Попробуйте ещё раз, если не получится - напишите в техподдержку'
    },
    "popup-recovery": {
        textMain: 'Ссылка для восстановления пароля успешно отправлена.<br />' +
            'Проверьте почту!',
        eTextMain: 'Упс... Что-то пошло не так.<br />' +
            'Попробуйте ещё раз, если не получится - напишите в техподдержку'
    },
    "popup-new-password": {
        textMain: 'Новый пароль готов!',
        eTextMain: 'Упс... Что-то пошло не так.<br />' +
            'Попробуйте ещё раз, если не получится - напишите в техподдержку'
    }
};

(function ($) {
    $(document).ready(function () {
        let popupSelects = $('.moroz-popup__select select'), // Select wrappers in popups
            popupSubmits = $('.popup-submit'), // Submit buttons
            popupResponse = $('#popup-response'),
            popupX = $('.moroz-popup__close-container'),
            popupOpeners = $('.popup-opener'),
            eyeToggler = $('.eye-toggler'),
            openerBind = $('.open-binded'),
            checkbox = $('.moroz-popup__checkbox'),
            checker = MOROZ.Popup.checker,
            alertWindow = $('#alert-message'),
            alertBtns = $('.alert-btn');

        /**
         * Close popup window
         * @param x {Object} - jQuery object
         */
        function closePopup(x) {
            x.parents('.moroz-popup').removeClass('active');
        }

        /**
         * Put selected text into <p> tag
         * @param select {Object} - jQuery object
         */
        function changeSelectText(select) {
            let newText = select.find('option:selected').text(),
                visibleElement = select.parent().find('p');
            visibleElement.text(newText);
        }

        /**
         * Checks contact type in select tag.
         * @param popupWindow {Object} - jQuery object. Popup body
         */
        function checkContactType(popupWindow) {
            let response, select, value, errorTag, visibleTag;

            select = popupWindow.find('select');
            if (select.length) {
                value = select.val();
                errorTag = select.next();
                visibleTag = select.parent().find('p');
                if (value !== "0") {
                    response = true;
                    errorTag.removeClass('error-active');
                    visibleTag.removeClass('red-border');
                } else {
                    response = false;
                    errorTag.addClass('error-active');
                    visibleTag.addClass('red-border');
                }
            } else {
                response = 0;
            }

            return response;
        }

        /**
         * Checks user name.
         * @param popupWindow {Object} - jQuery object. Popup body
         * @return {number|boolean} 0 - There aren't name input. true - name correct. false - name incorrect.
         */
        function checkName(popupWindow) {
            let input, value, response, next;

            input = popupWindow.find('.name-input');
            if (input.length) {
                value = input.val();
                next = input.next();
                if (value.length < 3) {
                    response = false;
                    input.addClass('red-border');
                    next.addClass('error-active');
                } else {
                    response = true;
                    next.removeClass('error-active');
                    input.removeClass('red-border');
                }
            } else {
                response = 0;
            }

            return response;
        }

        /**
         * Checks user email field
         * @param popupWindow {Object} - jQuery object. Popup body
         * @return {number|boolean} 0 - There aren't email input. true - email correct. false - email incorrect.
         */
        function checkEmail(popupWindow) {
            let input, value, response, error, re, test;

            input = popupWindow.find('.email-input');
            if (input.length) {
                value = input.val();
                re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                test = re.test(String(value).toLowerCase());
                error = input.next();
                if (value.length < 5) {
                    response = false;
                    error.text('!Введите email');
                    input.addClass('red-border');
                    error.addClass('error-active');
                } else if (test === false) {
                    response = false;
                    error.text('!Не правильно указан email');
                    input.addClass('red-border');
                    error.addClass('error-active');
                } else if (test === true) {
                    response = true;
                    error.removeClass('error-active');
                    input.removeClass('red-border');
                }
            } else {
                response = 0;
            }

            return response;
        }

        /**
         * Checks password for registration
         * @param popupWindow {Object} - jQuery object. Popup body
         * @return {number|boolean} 0 - There aren't password input. true - password correct. false - password incorrect.
         */
        function checkPassword(popupWindow) {
            let input, value, response, error, eye, fire, calm;
            input = popupWindow.find('.password-input');

            if (input.length) {
                value = input.val();
                error = input.next();
                eye = input.parent().find('svg');
                fire = function () {
                    input.addClass('red-border');
                    error.addClass('error-active');
                    eye.addClass('red-svg');
                }
                calm = function () {
                    input.removeClass('red-border');
                    error.removeClass('error-active');
                    eye.removeClass('red-svg');
                }

                if (value.length < 8 || value.length > 16) {
                    response = false;
                    error.text('!Пароль из 8 - 16 символов');
                    fire();
                } else if (!/[a-z]/.test(value)) {
                    response = false;
                    error.text('!Минимум 1 буква');
                    fire();
                } else if (!/[0-9]/.test(value)) {
                    response = false;
                    error.text('!Минимум 1 цифра');
                    fire();
                } else if (/[а-яА-ЯЁё]/.test(value)) {
                    response = false;
                    error.text('!Только латинские буквы');
                    fire();
                } else {
                    response = true;
                    calm();
                }

            } else {
                response = 0;
            }
            return response;
        }

        /**
         * Checks password for login
         * @param popupWindow {Object} - jQuery object. Popup body
         * @return {number|boolean} 0 - There aren't password input. true - password correct. false - password incorrect.
         */
        function checkPasswordForLogin(popupWindow) {
            let input, value, response, error, eye, fire, calm;
            input = popupWindow.find('.password-login-input');

            if (input.length) {
                value = input.val();
                error = input.next();
                eye = input.parent().find('svg');
                fire = function () {
                    input.addClass('red-border');
                    error.addClass('error-active');
                    eye.addClass('red-svg');
                }
                calm = function () {
                    input.removeClass('red-border');
                    error.removeClass('error-active');
                    eye.removeClass('red-svg');
                }

                if (value.length < 8 || value.length > 16) {
                    response = false;
                    fire();
                } else if (/[а-яА-ЯЁё]/.test(value)) {
                    response = false;
                    fire();
                } else {
                    response = true;
                    calm();
                }

            } else {
                response = 0;
            }
            return response;
        }

        /**
         * Checks repeated password.
         * @param popupWindow {Object} - jQuery object. Popup body
         * @return {number|boolean} 0 - There aren't password input. true - password correct. false - password incorrect.
         */
        function checkPasswordRepeat(popupWindow) {
            let inputOriginal, inputRepeater, response, error, eye, fire, calm;
            inputOriginal = popupWindow.find('.password-input');
            inputRepeater = popupWindow.find('.password-repeat-input');

            if (inputOriginal.length && inputRepeater.length) {
                error = inputRepeater.next();
                eye = inputRepeater.parent().find('svg');
                fire = function () {
                    inputRepeater.addClass('red-border');
                    error.addClass('error-active');
                    eye.addClass('red-svg');
                }
                calm = function () {
                    inputRepeater.removeClass('red-border');
                    error.removeClass('error-active');
                    eye.removeClass('red-svg');
                }

                if (inputOriginal.val() !== inputRepeater.val()) {
                    response = false;
                    fire();
                } else {
                    response = true;
                    calm();
                }

            } else {
                response = 0;
            }
            return response;
        }

        /**
         * Checks user phone.
         * @param popupWindow {Object} - jQuery object. Popup body
         * @return {number|boolean} 0 - There aren't name input. true - name correct. false - name incorrect.
         */
        function checkContact(popupWindow) {
            let input, value, response, next;

            input = popupWindow.find('.contact-input');
            if (input.length) {
                value = input.val();
                next = input.next();
                if (value.length < 3) {
                    response = false;
                    input.addClass('red-border');
                    next.addClass('error-active');
                } else {
                    response = true;
                    input.removeClass('red-border');
                    next.removeClass('error-active');
                }
            } else {
                response = 0;
            }

            return response;
        }

        /**
         * Check user agreement
         * @param popupWindow {Object} - jQuery object. Popup body
         * @return {number|boolean} 0 - There aren't name input. true - name correct. false - name incorrect.
         */
        function checkPolicy(popupWindow) {
            let checkbox, response, error;

            checkbox = popupWindow.find('.agree-input');
            if (checkbox.length) {
                error = checkbox.next();
                if (checkbox.is(':checked')) {
                    response = true;
                    error.removeClass('error-active');
                } else {
                    response = false;
                    error.addClass('error-active');
                }
            } else {
                response = 0;
            }

            return response;
        }

        /**
         * Call check functions to construct checker object
         * @param popupWindow {Object} - jQuery object
         */
        function constructChecker(popupWindow) {
            checker = {
                name: checkName(popupWindow),
                contact: checkContact(popupWindow),
                contactType: checkContactType(popupWindow),
                email: checkEmail(popupWindow),
                password: checkPassword(popupWindow),
                passwordForLogin: checkPasswordForLogin(popupWindow),
                passwordRepeated: checkPasswordRepeat(popupWindow),
                agreePolicy: checkPolicy(popupWindow)
            };
        }

        /**
         * Check trough props of checker object
         * @param checker {Object}
         * @return {boolean}
         */
        function checkForm(checker) {
            if (typeof checker === "object") {
                for (var prop in checker) {
                    if (checker[prop] === false) {
                        return false;
                    }
                }
            }
            return true;
        }

        /**
         * Looks at select value and changes placeholder in contact input
         * @param select {Object} - jQuery object
         */
        function changePlaceholder(select) {
            let value = select.val(),
                contactInput = select.parents('.moroz-popup__form').find('.contact-input'),
                newPlaceholder;

            switch (value) {
                case '0':
                    newPlaceholder = 'Ваш контакт';
                    break;
                case 'tg':
                    newPlaceholder = 'Ваш тэг в Telegram';
                    break;
                case 'vk':
                    newPlaceholder = 'Ваш ID или ссылка ВКонтакте';
                    break;
            }

            if (typeof newPlaceholder === 'string') {
                contactInput.attr('placeholder', newPlaceholder);
            }
        }

        /**
         * Remove errors class from popup elements.
         */
        function removeErrors(popup) {
            popup.find('.red-border').removeClass('red-border');
            popup.find('.error-active').removeClass('error-active');
        }

        /**
         * Clears field of popup window.
         * @param popup {Object} - jQuery
         */
        function clearPopup(popup) {
            let inputs, selects, svg;
            inputs = popup.find('input');
            selects = popup.find('select');
            svg = popup.find('svg');

            inputs.val('');
            selects.val('0');
            svg.removeClass('red-svg');
            changeSelectText(selects);
            changePlaceholder(selects);

            if (inputs.is(":checked")) {
                let checkIcon = popup.find('.check-icon');
                inputs.prop("checked", false);
                checkIcon.removeClass('visible');
                checkIcon.addClass('hidden');
            }

            removeErrors(popup);
        }

        /**
         * Opens popup window
         * @param btn {Object} - jQuery object
         */
        function openPopup(btn) {
            let id = btn.attr('data-popup'), popup;

            popup = $(`#${id}`);
            popup.addClass('active');

            let dataSelect = btn.attr('data-select');
            if (typeof dataSelect === "string") {
                let select = popup.find('select');
                select.val(dataSelect);
                changeSelectText(select);
                changePlaceholder(select);
            }
        }

        /**
         * Toggle input type and eye icon. Shows or hide password input.
         * @param btn {Object} - jQuery. Clicked icon.
         */
        function toggleEye(btn) {
            let icons = btn.parent().children('svg'),
                input = btn.parent().children('input');

            for (var i = 0, max = icons.length; i < max; i += 1) {
                if (/\bvisible\b/.test(icons[i].classList)) {
                    icons[i].classList.remove('visible');
                    icons[i].classList.add('hidden');
                } else if (/\bhidden\b/.test(icons[i].classList)) {
                    icons[i].classList.remove('hidden');
                    icons[i].classList.add('visible');
                }
            }

            if (input.attr('type') === "text") {
                input.attr('type', 'password');
            } else {
                input.attr('type', 'text');
            }
        }

        /**
         * Collects data from popup to Object data
         * @param popup {Object} - jQuery object
         * @return {Object} data
         */
        function collectData(popup) {
            let inputs = popup.find('input'),
                selects = popup.find('select'),
                data = {},
                searchParams,
                userAccountEvent;

            for (var i = 0, max = inputs.length; i < max; i += 1) {
                data[inputs[i].getAttribute('data-name')] = inputs[i].value;
            }

            for (var i = 0, max = selects.length; i < max; i += 1) {
                let sel = selects[i];
                data[sel.getAttribute('data-name')] = sel.options[sel.selectedIndex].text;
            }

            // data.title = popupForm.title;
            data.nonce = popupForm.nonce;
            data.action = popup.attr('data-action');

            if (typeof dataEvent !== "undefined") {
                data.user_id = dataEvent.user_id;
                data.event_id = dataEvent.event_id;
            }

            userAccountEvent = popup.attr('data-event');
            if (userAccountEvent !== "undefined") {
                data.event_id = userAccountEvent;
            }

            searchParams = new URLSearchParams(window.location.search);
            if (searchParams.get('action') === "rp") {
                data.key = searchParams.get('key');
                data.login = searchParams.get('login');
            }

            return data;
        }

        /**
         * Open binded popup and hide current
         * @param btn {Object} - jQuery. Clicked button.
         */
        function openBinded(btn) {
            let popupId = btn.attr('data-popup'),
                current = btn.parents('.moroz-popup__window'),
                x = current.find('.moroz-popup__close-container');

            $(`#${popupId}`).addClass('active');
            setTimeout(function () {
                x.click();
            }, 150);
        }

        /**
         * Reload page after login to set user
         * @param response {Object} - data from ajax authentication
         */
        function reloadPage(response) {
            if (response.success === "yes") {
                document.location.href = popupForm.userAccountURL;
            }
        }

        /**
         * Handles response from ajax.
         * @param response
         */
        function handleResponse(response) {
            switch (response.action) {
                case "reload":
                    reloadPage(response);
                    break;
            }
        }

        /**
         * Show alert modal window when user interact with ajax without filling form
         * @param alert {Object} - content data for alert window
         */
        function showAlertMessage(button) {
            let prop, message, messageTag, data;
            if (!alertWindow.length) {
                return;
            }

            messageTag = alertWindow.find('.response-main');
            prop = button.attr('data-alert');
            if (!prop || !messageTag.length) {
                return;
            }

            message = popupForm.alert[prop];
            messageTag.text(message);

            alertWindow.addClass('active');
            setTimeout(function () {
                alertWindow.removeClass('active');
            }, 3500);

            data = {
                action: button.attr('data-action'),
                product: button.attr('data-product'),
                nonce: popupForm.nonce
            };

            if (typeof dataEvent !== "undefined") {
                data.user_id = dataEvent.user_id;
                data.event_id = dataEvent.event_id;
            }

            if (typeof data.action === "string") {
                $.post( popupForm.url, data, function (response) {
                    console.log(response); // Test
                });
            }
        }

        // Opens popup
        popupOpeners.on('click', function (e) {
            e.preventDefault();
            openPopup($(this));
        });

        // Changes text on select click
        popupSelects.on('change', function () {
            changeSelectText($(this));
            changePlaceholder($(this));
        });

        // Main handler of submit btn
        popupSubmits.on('click', function (e) {
            let popupWindow, check, data, popupId;

            e.preventDefault();

            popupWindow = $(this).parents('.moroz-popup__window');
            checker = {};
            constructChecker(popupWindow);
            check = checkForm(checker);
            if (check === true) {
                let showResponse = function (mode = "default") {
                        if (mode === "default") {
                            popupResponse.addClass('active');
                        } else {
                            $("#popup-response-alt").addClass('active');
                        }
                        setTimeout(function () {
                            popupWindow.parent().removeClass('active');
                        }, 150);
                    },
                    hideResponse = function (mode = "default") {
                        let popupHiding = (mode === "default") ? popupResponse.removeClass('active') : $("#popup-response-alt").removeClass('active');
                    },
                    errorCodes = ["not", "", "0"],
                    button = popupWindow.find(".moroz-popup__submit"),
                    responseMode; //

                button.addClass("active"); // Show loader
                popupId = popupWindow.parent().attr('id');

                // Send data
                data = collectData(popupWindow);
                $.post( popupForm.url, data, function (response) {
                    // console.log(response); // Test

                    if (response === "ok"  && typeof response.reminder === "undefined") {
                        popupResponse.find('.response-main').html(MOROZ.Popup.response[popupId].textMain);
                    } else if (errorCodes.includes(response)) {
                        popupResponse.find('.response-main').html(MOROZ.Popup.response[popupId].eTextMain);
                    } else if (typeof response === "string") {
                        popupResponse.find('.response-main').html(response);
                    } else if (typeof response === "object") {
                        popupResponse.find('.response-main').html(response.message);
                        handleResponse(response); // Call function after response
                    }

                    responseMode = (typeof response.reminder === "undefined") ? "default" : "event-reminder";
                    showResponse(responseMode); // Show popup with response message

                    button.removeClass("active"); // Hide loader

                    setTimeout(function () {
                        hideResponse(responseMode); // Hide response popup
                        clearPopup(popupWindow); // Clear popup fields
                    }, 3000);
                });

                check = false; // Reset validation
            }
        });

        // Close popup window on click
        popupX.on('click', function () {
            closePopup($(this));
            clearPopup($(this).parents('.moroz-popup__window'));
        });

        // Toggle input type password to text and reverse
        eyeToggler.on('click', function () {
            toggleEye($(this));
        });

        // Open binded popup and hide current
        openerBind.on('click', function (e) {
            e.preventDefault();
            openBinded($(this));
        });

        // Change checkbox icon
        checkbox.on('click', function () {
            let svg = $(this).children('svg');
            if (svg.hasClass('hidden')) {
                svg.removeClass('hidden');
                svg.addClass('visible');
            } else {
                svg.removeClass('visible');
                svg.addClass('hidden');
            }
        });

        // Show alert window, call ajax action
        alertBtns.on('click', function(e) {
            e.preventDefault();
            showAlertMessage($(this));
        });
    });
})(jQuery);