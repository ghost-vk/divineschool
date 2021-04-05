<?php get_header(); ?>

<?php
global $woocommerce;
$cart_items = $woocommerce->cart->get_cart();
do_action( 'remove_repeated_products', $cart_items );
?>

<?php echo do_shortcode("[woocommerce_cart]"); ?>

<?php get_footer(); ?>