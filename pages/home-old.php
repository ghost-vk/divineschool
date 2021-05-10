<div class="homeBody">
	<!--    HELLO SECTION    -->
	<div class="px-4 py-5 text-center helloSection">
		<?php if ( is_mobile() ) {
			$background_image_src = get_field('hero_bg_mobile');
			$counter_id = 'id="counterMobile"';
		} else {
			$background_image_src = get_field('hero_bg_pc');
			$counter_id = '';
		} ?>
		<style>
            .helloSection {
                background-image: url("<?php echo $background_image_src; ?>");
            }
		</style>
		<h1 class="display-5 fw-bold text-primary"><?php the_field('hello_title'); ?></h1>
		<div class="col-lg-6 mx-auto">
			<div class="lead text-secondary">
				<?php the_field('hello_text'); ?>
			</div>
			
			<div class="homeTimer mb-md-5 mb-3" <?php echo $counter_id; // Displays with attr name ?>>
				<div id="countdown"></div>
			</div>
			
			<div class="d-grid gap-2 d-sm-flex pt-2 justify-content-sm-center">
				<a href="#packages" class="btn btn-primary btn-lg px-4 me-sm-3">Выбрать пакет</a>
				<a href="#courseContentTitle" class="btn btn-outline-primary btn-lg px-4">Что будет на курсе?</a>
			</div>
		</div>
	</div>
	
	<div class="container">
		<!--   COURSE CONTENT   -->
		<h2 class="display-6 text-center my-5" id="courseContentTitle"><?php the_field('modules_title'); ?></h2>
		<div class="row justify-content-center">
			<div class="accordion col-12 col-md-8 col-sm-10" id="accordionModules">
				<?php if ( have_rows('modules_repeater') ) : $i = 0; ?>
					<?php while ( have_rows('modules_repeater') ) : the_row(); ?>
						<div class="accordion-item">
							<h2 class="accordion-header" id="heading-<?= $i; ?>">
								<button class="accordion-button collapsed bg-warning" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $i; ?>" aria-expanded="false" aria-controls="collapse-<?= $i; ?>">
									<?php the_sub_field('name'); ?>
								</button>
							</h2>
							<div id="collapse-<?= $i; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?= $i; ?>" data-bs-parent="#accordionModules">
								<div class="accordion-body">
									<?php the_sub_field('content'); ?>
								</div>
							</div>
						</div>
						<?php $i += 1; ?>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>
		</div>
		
		<!--    PRICE    -->
		<?php
		$currency_symbol = get_woocommerce_currency_symbol();
		
		// Get package names
		$course = get_field('course_product_id');
		$course_product_id = $course[0];
		$package_names = [
			1 => get_field( "package_1_name", $course_product_id ),
			2 => get_field( "package_2_name", $course_product_id ),
			3 => get_field( "package_3_name", $course_product_id ),
		];
		
		// Packages button text
		$package_btn = [
			1 => get_field( "package_1_btn_text", $course_product_id ),
			2 => get_field( "package_2_btn_text", $course_product_id ),
			3 => get_field( "package_3_btn_text", $course_product_id ),
		];
		
		/**
		 * Displays package description from product page (course)
		 * @param $package_index {Integer}
		 * @param $course_product_id {Integer}
		 */
		function echo_description( $package_index, $course_product_id ) {
			if ( have_rows( 'package_' . $package_index . '_description', $course_product_id ) ) {
				while ( have_rows( 'package_' . $package_index . '_description', $course_product_id ) ) {
					the_row();
					echo '<li>' . get_sub_field('text') . '</li>';
				}
			}
		}
		
		
		// Get variations
		$product = wc_get_product( $course_product_id );
		$variations = $product->get_available_variations( 'objects' );
		$variations_data = [];
		$add_to_cart_urls = [];
		foreach ( $variations as $variation ) {
			$package_attr = $variation->attributes['pa_package'];
			if ( !$package_attr ) {
				continue;
			}
			
			$regular_price = (int)$variation->regular_price;
			if ( $regular_price > 0 ) {
				$regular_price = number_format( $regular_price, 0, '.', ' ' ) . ' ' . $currency_symbol;
			}
			
			$sale_price = (int)$variation->sale_price;
			if ( $sale_price > 0 ) {
				$sale_price = number_format( $sale_price, 0, '.', ' ' ) . ' ' . $currency_symbol;
			} else {
				$sale_price = false;
			}
			
			$variations_data[$package_attr] = array(
				'regular_price' => $regular_price,
				'sale_price' => $sale_price,
				'id' => $variation->get_id(),
			);
		}
		?>
		<div class="pricing-header p-5 pb-md-4 mx-auto text-center">
			<h2 class="display-6 text-primary"><?php the_field('price_title'); ?></h2>
			<p class="fs-5 text-secondary"><?php the_field('price_subtitle'); ?></p>
		</div>
		<div class="pricesCard row row-cols-1 row-cols-md-3 mb-3 text-center">
			<?php for ( $i = 1; $i < 4; $i += 1 ) : ?>
				<?php
				switch ($i) {
					case 1 :
						$backgroud_class = '';
						$border_class = '';
						$button_class = 'btn-outline-primary';
						break;
					case 2 :
						$backgroud_class = '';
						$border_class = '';
						$button_class = 'btn-primary';
						break;
					case 3 :
						$backgroud_class = 'bg-primary text-white';
						$border_class = 'border-primary';
						$button_class = 'btn-primary';
						break;
					default :
						$backgroud_class = '';
						$border_class = '';
						$button_class = '';
						break;
				}
				?>
				<div class="col">
					<div class="card mb-4 rounded-3 shadow-sm <?= $border_class; ?>">
						<div class="card-header py-3 <?= $backgroud_class . ' ' . $border_class; ?>">
							<h4 class="my-0 fw-normal"><?= $package_names[$i]; ?></h4>
						</div>
						<div class="card-body">
							
							<?php if ( $variations_data["package_$i"]["sale_price"] !== false ) : ?>
								<h1 class="card-title pricing-card-title fs-3 text-muted text-decoration-line-through"><?= $variations_data["package_$i"]["regular_price"]; ?></h1>
								<h1 class="card-title pricing-card-title"><?= $variations_data["package_$i"]["sale_price"]; ?></h1>
							<?php else : ?>
								<h1 class="card-title pricing-card-title"><?= $variations_data["package_$i"]["regular_price"]; ?></h1>
							<?php endif; ?>
							
							<ul class="list-unstyled mt-3 mb-4">
								<?php echo_description( $i, $course_product_id ); ?>
							</ul>
							
							<form action="" method="post">
								<input class="d-none" type="radio" checked="checked" name="product_id" value="<?= $variations_data["package_$i"]['id']; ?>" />
								<button type="submit" class="w-100 btn btn-lg <?= $button_class; ?>"><?= $package_btn[$i]; ?></button>
							</form>
						</div>
					</div>
				</div>
			<?php endfor; ?>
		
		</div>
  
		<!--   MODULES COMPARING   -->
		<h2 class="display-6 text-center my-5 text-primary" id="packages"><?php the_field('comparing_title'); ?></h2>
		<div class="table-responsive">
			<table class="table text-center">
				<thead>
				<tr>
					<th style="width: 55%;"></th>
					<?php foreach ($package_names as $name) : ?>
						<th style="width: 15%; padding: .2rem"><span class="fw-light fs-6"><?= $name; ?></span></th>
					<?php endforeach; ?>
				</tr>
				</thead>
				<tbody>
				<?php if ( have_rows('comparing_table_repeater') ) : ?>
					<?php while ( have_rows('comparing_table_repeater') ) : the_row(); ?>
						<tr>
							<th scope="row" class="text-start px-0"><span class="fs-6 fw-light"><?php the_sub_field('measure'); ?></span></th>
							<?php for ( $i = 1; $i < 4; $i += 1) : ?>
								<?php if ( get_sub_field("is_package_$i") === true ) : ?>
									<td><i class="fas fa-check text-secondary"></i></td>
								<?php else : ?>
									<td></td>
								<?php endif; ?>
							<?php endfor; ?>
						</tr>
					<?php endwhile; ?>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
	
	</div>
</div>