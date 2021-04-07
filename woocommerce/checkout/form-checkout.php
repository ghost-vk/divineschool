<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $woocommerce;
?>

<div class="container">
    <section class="payment-form dark">
        <div class="container">
            <div class="block-heading">
                <h2 class="text-primary">Оформление заказа</h2>
                <p>После оплаты вам придет письмо на указанный email с данными для входа в личный кабинет</p>
            </div>
            
            <form name="checkout" method="post" class="checkoutForm rounded" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
                <div class="products">
                    <h3 class="title">Курсы</h3>
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
                    <div class="total">Итого<span class="price"><?php echo $woocommerce->cart->get_cart_total(); ?></span></div>
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
						$gateway_test = $available_gateways["cheque"]; // TODO Сменить тип платежной системы на боевой (Касса)
//						$gateway_kassa = $available_gateways["cheque"];
						$gateway_paypal = $available_gateways["paypal"];
						?>
                        <div class="d-block my-1">
                            <div class="custom-control custom-radio payment-method">
                                <input id="credit" name="payment_method" type="radio" class="custom-control-input" value="<?php echo esc_attr( $gateway_test->id ); ?>" checked="checked">
                                <label class="custom-control-label mb-0 payment-label" for="credit">Оплата картой&nbsp;&nbsp;<i class="far fa-credit-card"></i></label>
                            </div>
                            <div class="custom-control custom-radio payment-method">
                                <input id="paypal" name="payment_method" type="radio" class="custom-control-input " value="<?php echo esc_attr( $gateway_paypal->id ); ?>">
                                <label class="custom-control-label mb-0 payment-label" for="paypal">PayPal&nbsp;&nbsp;<i class="fab fa-paypal"></i></label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group w-100 mt-3">
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
            
            <?php $page_id = 42; // Checkout page ID?>
            <div class="payment-form__question rounded">
                <div class="products rounded">
                    <h3 class="title"><?php the_field('contacts_title', $page_id); ?></h3>
                    <p><?php the_field('contacts_subtitle', $page_id); ?></p>
                    <?php $contacts = get_field('contacts_group', $page_id); ?>
                    <?php if ( ! empty($contacts) ) : ?>
                        <?php
                        $wa = $contacts['wa'];
                        $tg = $contacts['tg'];
                        $insta = $contacts['insta'];
                        $email = $contacts['email'];
                        ?>
                        <?php if ( isset($wa) ) : $target = ( $wa['target'] ) ? $wa['target'] : '_self'; ?>
                            <a class="d-block" href="<?php echo $wa['url']; ?>" target="<?php echo $wa['target']; ?>">
                                <i class="fab fa-whatsapp"></i>&nbsp;&nbsp;<?php echo $wa['title']; ?>
                            </a>
                        <?php endif; ?>
						<?php if ( isset($tg) ) : $target = ( $tg['target'] ) ? $tg['target'] : '_self'; ?>
                            <a class="d-block" href="<?php echo $tg['url']; ?>" target="<?php echo $tg['target']; ?>">
                                <i class="fab fa-telegram-plane"></i>&nbsp;&nbsp;<?php echo $tg['title']; ?>
                            </a>
						<?php endif; ?>
						<?php if ( isset($insta) ) : $target = ( $insta['target'] ) ? $insta['target'] : '_self'; ?>
                            <a class="d-block" href="<?php echo $insta['url']; ?>" target="<?php echo $insta['target']; ?>">
                                <i class="fab fa-instagram"></i>&nbsp;&nbsp;<?php echo $insta['title']; ?>
                            </a>
						<?php endif; ?>
						<?php if ( isset($email) ) : ?>
                            <a class="d-block" href="mailto:<?php echo $email; ?>">
                                <i class="far fa-envelope"></i>&nbsp;&nbsp;<?php echo $email; ?>
                            </a>
						<?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>