<?php
require_once __DIR__ . '/../../ghost-plugins/prepayment-save-discount/Prepayment.php';
$prepayment_plugin = new \Ghost\Prepayment\Prepayment();

if ( $prepayment_plugin->IsPluginOn() ) :
	$prepayment_main_text = get_field('prepayment_row_text', 'options');
	$pm = preg_match('/{(.*)}/', $prepayment_main_text, $output_array);
	if ( $pm ) {
		$id = get_field('prepayment_product_id', 'options')[0];
//		$link_url = home_url('/cart/?add-to-cart=' . $id);
		$link = '<a href="#packages" class="text-primary text-decoration-underline">' . $output_array[1] . '</a>';
		
		$prepayment_main_text = str_replace( $output_array[0], $link, $prepayment_main_text );
	}
	?>
    <div class="saleHeaderRow position-sticky bg-warning">
        <div class="container-1 p-2 text-center">
			<span>
	            <?php echo $prepayment_main_text; ?>
            </span>
            <span class="position-relative">
                <i class="saleHeaderRow__icon fas fa-info-circle text-primary" id="sale-icon"></i>
                <div class="saleHeaderRow__bubble rounded-2 overflow-hidden position-absolute shadow p-2">
                    <div>
                        <span>
                            <?php the_field('prepayment_instruction_text', 'options'); ?>
                        </span>
                    </div>
                </div>
            </span>
        </div>
    </div>
<?php endif; ?>