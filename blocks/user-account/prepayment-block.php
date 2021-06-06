<?php
require_once __DIR__ . '/../../ghost-plugins/prepayment-save-discount/Prepayment.php';
$prepayment = new \Ghost\Prepayment\Prepayment();
$partially_paid_products = $prepayment->GetDiscountProducts();
if ( ! empty($partially_paid_products) ) :
	require_once __DIR__ . '/../../class/class-wc-course-product.php';
	$products_and_prices = $partially_paid_products[0];
	$first_variation_id = $products_and_prices[0]['id'];
	$first_variation_product = wc_get_product($first_variation_id);
	$parent_id = $first_variation_product->get_parent_id();
	$course_product = new \LASH\WC_Course_Product($parent_id);
	$prepayment_product_id = get_paid_prepayment_product();
	$prepayment_product_title = ( $prepayment_product_id ) ? get_the_title($prepayment_product_id) : '';
	?>
    <div class="rounded bg-warning py-5 px-3 text-center">
        <h3 class="mb-5 lh-base fw-bold">
            ДОСТУП ПО ПРЕДОПЛАТЕ<br />
			<?php
			if ( $prepayment_product_title ) {
				echo $prepayment_product_title . '<br />';
			}
			?>
            (до 12 июля)
        </h3>
        <p class="mb-5">Вы уже частично оплатили курс и теперь для Вас сохранена скидка на следующие пакеты</p>
        <div class=" px-2">
			<?php
			foreach ( $products_and_prices as $row ) :
				$id = $row['id'];
				$price = $row['price'];
				$price = number_format((int)$price, 0, '.', ' ');
				$price .= ' &#8381;';
				$course_product->set_variation($id);
				$package_name = $course_product->get_package_name();
				$link = home_url('/cart/?add-to-cart=' . $id);
				?>
                <div class="col-lg bg-white shadow rounded  p-3 text-start mb-4">
                    <h3 class="mb-2 text-center lh-sm">"<?php echo $package_name; ?>"</h3>
                    <hr>
                    <p class="fs-5 lh-sm mb-3 text-center">Что входит в пакет?</p>
					<?php $course_product->print_features(); ?>
                    <div class="d-flex justify-content-center mt-3">
                        <a href="<?php echo $link; ?>" class="btn btn-secondary">
                            Купить со скидкой<br />
                            <strong><?php echo $price; ?></strong>
                        </a>
                    </div>
                </div>
			<?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>