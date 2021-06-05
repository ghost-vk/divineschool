<?php defined( 'ABSPATH' ) || exit; ?>

<div class="cartBody pb-3">
	<?php
	global $woocommerce;
	$cart_items = $woocommerce->cart->get_cart();
	
	$subtotal = $woocommerce->cart->get_cart_subtotal();
	$total = $woocommerce->cart->get_cart_total();
	do_action( 'woocommerce_before_cart' );
	?>
    <div class="card">
        <div class="row">
            <div class="col-md-8 cart">
                <div class="title">
                    <div class="row">
                        <div class="col">
                            <h4 class="text-bigger-2"><strong>Корзина</strong></h4>
                        </div>
                    </div>
                </div>
				<?php $i = 0; ?>
				<?php foreach ( $cart_items as $cart_item_key => $cart_item ) : ?>
					
					<?php
					// Get data for row
					$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
					
					$product_name = $_product->get_title();
					
					$thumbnail_src = get_field('square_image', $product_id);
					if ( empty($thumbnail_src) ) {
						$thumbnail_src = wp_get_attachment_image_url( 5, 'medium' );
					}
					
					$package_index = $cart_item['variation']["attribute_pa_package"];
					$parent_id = $cart_item['product_id'];
					$package_name = get_field( $package_index . '_name', $parent_id );
					
					$price = $woocommerce->cart->get_product_price( $_product );
					
					$remove_url = wc_get_cart_remove_url( $cart_item_key );
					
					$border_top_class = ( $i > 0 ) ? '' : 'border-top';
					?>

                    <div class="row border-bottom <?= $border_top_class; ?>">
                        <div class="row main align-items-center">
	                        <?php if ( $thumbnail_src ) : ?>
                                <div class="col-3 col-md-2 px-0">
                                    <img class="img-fluid" src="<?php the_field('cart_image', $parent_id); ?>">
                                </div>
	                        <?php endif; ?>
                            <div class="col-9 col-md-6">
                                <div class="row mb-2 mb-md-0 text-bigger-1"><?= $product_name; ?></div>
                                <?php if ( $package_name ) : ?>
                                    <div class="row small text-muted">Пакет "<?= $package_name; ?>"</div>
                                <?php endif; ?>
                            </div>
                            <div class="col-8 col-md-3 mt-3 mt-md-0 text-bigger-1"><?= $price;?></div>
                            <div class="col-4 col-md-1 text-end text-md-start mt-3 mt-md-0">
                                <a href="<?= $remove_url; ?>" class="text-muted text-bigger-1"><i class="far fa-trash-alt"></i></a>
                            </div>
                        </div>
                    </div>
					
					<?php $i += 1; ?>
				<?php endforeach; ?>
                <div class="back-to-shop"><a href="<?= home_url(); ?>">&leftarrow; <span class="text-muted">Вернуться на главную</span></a></div>
            </div>
			<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>
            <div class="col-md-4 summary">
                <div>
                    <h5 class="text-bigger-1">
                        <strong>
	                        <?php
                            $total_title = ( $subtotal !== $total ) ? 'Итого<br />(С УЧЕТОМ СКИДКИ)' : 'Итого';
                            echo $total_title;
                            ?>
                        </strong>
                    </h5>
                </div>
                <hr>
                <div class="pb-2">
                    <p class="small text-muted">Курс будет доступен вам в личном кабинете после оплаты</p>
                </div>
                <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                    <div class="col px-0 text-bigger-2">Сумма</div>
                    <div class="col text-right text-bigger-2"><?php echo $total; ?></div>
                </div>
                <a href="<?php echo wc_get_checkout_url(); ?>" class="btn">Оформить заказ</a>
            </div>
        </div>
    </div>
</div>