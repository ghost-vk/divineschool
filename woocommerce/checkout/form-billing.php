<?php defined( 'ABSPATH' ) || exit; ?>
<div class="woocommerce-billing-fields">
	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>
	
	<div class="woocommerce-billing-fields__field-wrapper">
		<?php
		$fields = $checkout->get_checkout_fields( 'billing' );
		
		foreach ( $fields as $key => $field ) {
			woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
		}
		?>
        <div class="form-row">
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="" id="checkPolicy">
                <label class="form-check-label" for="checkPolicy">
                    Я ознакомлен и согласен с <a href="<?php echo home_url('privacy'); ?>">Политикой конфиденциальности</a>
                    <abbr class="required" title="обязательно">*</abbr>
                </label>
            </div>
        </div>
	</div>
 
	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
 
</div>