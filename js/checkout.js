(function ($) {
    $(document).ready(function () {
        let fields,
            submit,
            check,
            errorBlock;

        fields = {
            name: $("#billing_first_name"),
            secondName: $("#billing_last_name"),
            city: $("#billing_city"),
            phone: $("#billing_phone"),
            email: $("#billing_email")
        }

        errorBlock = $(`
            <div class="form-row">
                <div class="bg-danger p-2 rounded">
                    <p class="text-white mb-0"><i class="fas fa-exclamation-circle"></i>&nbsp;&nbsp;Пожалуйста, проверьте правильность ввода данных</p>
                </div>
            </div>
        `);

        /**
         * Normal check email
         * @param email
         * @return {boolean}
         */
        function validateEmail(email) {
            const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }

        /**
         * Check no empty string
         * @param str
         * @return {boolean}
         */
        function validateSimpleString(str) {
            if (!str || str.length < 3) {
                return false;
            }
            return true;
        }

        /**
         * Simple validates phone
         * @param str
         * @return {boolean}
         */
        function lazyValidatePhone(str) {
            if (!str || str.length < 8) {
                return false;
            }
            return true;
        }

        /**
         * Validates all fields in field Object
         * @return {boolean}
         */
        function validateFields() {
            let validation;

            for (var prop in fields) {
                switch (prop) {
                    case 'phone' :
                        validation = lazyValidatePhone(fields[prop].val());
                        break;
                    case 'email' :
                        validation = validateEmail(fields[prop].val());
                        break;
                    default :
                        validation = validateSimpleString(fields[prop].val());
                        break;
                }
                if (validation === false) {
                    fields[prop].addClass('border border-danger');
                    return false;
                } else {
                    fields[prop].removeClass('border border-danger');
                }
            }
            return true;
        }

        submit = $("#checkoutSubmit");

        check = false;
        submit.click(function (e) {
            if (check === true) { // Bubble away after validation
                return;
            }

            e.preventDefault();
            check = validateFields();
            if (check !== true) { // Validation failed
                fields.email.parents("#billing_email_field").after(errorBlock);
            } else {
                errorBlock.remove();
                $(this).trigger('click');
            }
        });

    });
})(jQuery);