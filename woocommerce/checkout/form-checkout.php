<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $woocommerce;
$total = $woocommerce->cart->get_cart_total();
$subtotal = $woocommerce->cart->get_cart_subtotal();
?>

<div class="container">
    <section class="payment-form dark">
        <div class="container">
            <div class="block-heading">
                <h3 class="text-primary">Оформление заказа</h3>
                <p>После оплаты вам придет письмо на указанный email с данными для входа в личный кабинет</p>
            </div>

            <form name="checkout" method="post" class="checkoutForm rounded" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
                <div class="products">
                    <h3 class="title text-bigger-2">Курсы</h3>
					<?php
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						
						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
							$package_index = $cart_item['variation']["attribute_pa_package"];
							?>
                            <div class="item">
                                <span class="price">
                                    <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                </span>
                                <p class="item-name">
									<?php echo get_the_title($cart_item['product_id']); ?>
                                </p>
								<?php if ( have_rows($package_index . '_description', $cart_item['product_id']) ) : ?>
                                    <ul class="item-description">
										<?php while ( have_rows($package_index . '_description', $cart_item['product_id']) ) : the_row(); ?>
                                            <li><?php the_sub_field('text'); ?></li>
										<?php endwhile; ?>
                                    </ul>
								<?php endif; ?>
                            </div>
							<?php
						}
					}
					?>
                    <?php if ( $total !== $subtotal ) : ?>
                        <div class="total pb-2">Без скидки<span class="price"><?php echo $subtotal; ?></span></div>
                        <div class="total">Итого (со скидкой)<span class="price"><?php echo $total; ?></span></div>
                    <?php else : ?>
                        <div class="total">Итого<span class="price"><?php echo $total; ?></span></div>
                    <?php endif; ?>
                </div>
                <div class="card-details">
                    <h3 class="title">Оформление</h3>
                    <div class="row">
						<?php do_action( 'woocommerce_checkout_billing' ); ?>
                    </div>

                    <h3 class="title mt-4">Способ оплаты</h3>
                    <div class="row">
						<?php
						$WC_Payment_Gateways = new WC_Payment_Gateways();
						$available_gateways = $WC_Payment_Gateways->get_available_payment_gateways();
						$gateway_test = $available_gateways["cheque"];
						$gateway_paypal = $available_gateways["paypal"];
						$gateway_yookassa = $available_gateways["yookassa_epl"];
						?>
                        <div class="d-block my-1">
							<?php if ( get_current_user_id() === 1 ) : // Test payment for superadmin ?>
                                <div class="custom-control custom-radio payment-method">
                                    <input id="credit" name="payment_method" type="radio" class="custom-control-input" value="<?php echo esc_attr( $gateway_test->id ); ?>" checked="checked">
                                    <label class="custom-control-label mb-0 payment-label" for="credit">Тестовая оплата&nbsp;&nbsp;<i class="far fa-credit-card"></i></label>
                                </div>
                                <div class="method-description">
                                    <p class="text">
                                        Метод оплаты для тестирования платежей. Если вы это видите, не выбирайте этот метод, вам не будет предоставлена услуга.
                                    </p>
                                </div>
							<?php endif; ?>
							<?php if ( $gateway_yookassa ) : ?>
                                <div class="custom-control custom-radio payment-method">
                                    <input id="yookassa_payment_method" name="payment_method" type="radio"
                                           class="custom-control-input" checked="checked"
                                           value="<?php echo esc_attr( $gateway_yookassa->id ); ?>">
                                    <label class="custom-control-label mb-0 payment-label" for="yookassa_payment_method">ЮКасса&nbsp;&nbsp;<i class="far fa-credit-card"></i></label>
                                </div>
                                <div class="method-description">
                                    <p class="text">Больше подходит, если вы находитесь в России. Можно оплатить с помощью банковских карт и электронных кошельков</p>
                                </div>
							<?php endif; ?>
							<?php if ( $gateway_paypal ) : ?>
                                <div class="custom-control custom-radio payment-method">
                                    <input id="paypal" name="payment_method" type="radio" class="custom-control-input " value="<?php echo esc_attr( $gateway_paypal->id ); ?>">
                                    <label class="custom-control-label mb-0 payment-label" for="paypal">PayPal&nbsp;&nbsp;<i class="fab fa-paypal"></i></label>
                                </div>
							<?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group w-100 mt-3">
                            <input type="hidden" name="woocommerce_pay" value="1" />
							<?php wp_nonce_field( 'woocommerce-process_checkout' ); ?>
							
							<?php do_action( 'woocommerce_pay_order_before_submit' ); ?>

                            <button type="submit" id="checkoutSubmit" name="woocommerce_checkout_place_order" class="btn btn-success btn-block w-100 mb-2">Оплатить</button>
							
							<?php do_action( 'woocommerce_pay_order_after_submit' ); ?>
							
							<?php wp_nonce_field( 'woocommerce-pay', 'woocommerce-pay-nonce' ); ?>
                        </div>
                    </div>
                </div>
            </form>
			
			<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

            <div class="payment-form__question rounded">
                <div class="products rounded">
                    <h3 class="title">Есть вопросы?</h3>
                    <p>Напишите нам:</p>
					<?php $whats_app = get_field('contacts_wa', 'option'); ?>
					<?php if ( $whats_app ) : ?>
                        <a href="https://api.whatsapp.com/send?phone=<?php echo $whats_app; ?>"
                           class="d-block" target="_blank">
                            <i class="fab fa-whatsapp"></i>&nbsp;&nbsp;What's App
                        </a>
					<?php endif; ?>
					<?php $email = get_field('contacts_email', 'option'); ?>
					<?php if ( $email ) : ?>
                        <a class="d-block" href="mailto:<?php echo $email; ?>" target="_blank">
                            <i class="far fa-envelope"></i>&nbsp;&nbsp;<?php echo $email; ?>
                        </a>
					<?php endif; ?>
					
					<?php $phone = get_field('contacts_phone', 'option'); ?>
					<?php if ( $phone ) : ?>
                        <a class="d-block" href="<?php echo $phone['url']; ?>" target="_blank">
                            <i class="fas fa-phone-alt"></i>&nbsp;&nbsp;<?php echo $phone['title']; ?>
                        </a>
					<?php endif; ?>
					
					<?php $instagram_link = get_field('contacts_instagram', 'option'); ?>
					<?php if ( $instagram_link ) : ?>
                        <a class="d-block" href="<?php echo $instagram_link; ?>" target="_blank">
                            <i class="fab fa-instagram"></i>&nbsp;&nbsp;Instagram
                        </a>
					<?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>