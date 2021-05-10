<?php global $course_product_id; ?>
<div class="courseCard">
	<div class="courseCard__wrapper">
		<p class="courseCard__badge">
                    <span class="text-white">
                        гарантированный<br />результат
                    </span>
		</p>
        <?php
        if ( isset($bg_image) ) {
            $background = "background-image: url('" . esc_url($bg_image) . "')";
		} else {
			$background = 'background-color: #c4c4c4';
        }
		?>
		<div class="courseCard__body" style="<?php echo $background; ?>">
			<div class="courseCard__title">
				<?php
				$name = ( isset($package_name) ) ? $package_name : '';
				echo $name;
                ?>
			</div>
			<ul class="courseCard__features">
				<?php
                $index = ( isset($package_index) ) ? $package_index : 1;
                display_package_description($index, $course_product_id);
                ?>
			</ul>
			<div class="courseCard__price">
                <?php if ( isset($sale_price) && $sale_price !== false ) : ?>
                    <div class="courseCard__before">
						<?php
						$regular = ( isset($regular_price) ) ? $regular_price : '';
						echo $regular;
						?>
                        &#8381;
                    </div>
                    <div class="courseCard__current">
						<?php echo $sale_price; ?> &#8381;
                    </div>
                <?php else : ?>
                    <div class="courseCard__current">
						<?php
						$regular = ( isset($regular_price) ) ? $regular_price : '';
						echo $regular;
						?>
                        &#8381;
                    </div>
                <?php endif; ?>
			</div>
            <?php if ( isset($is_started) && $is_started === false ) : ?>
                <!--    ACTIVE SELL    -->
                <div class="courseCard__button">
                    <?php if ( isset($package_id) ) : ?>
                        <button class="mediumButton mediumButton-green addToCartBtn" data-id="<?php echo $package_id; ?>">
                            <?php
                            $btn = ( isset($btn_text) ) ? $btn_text : 'Купить';
                            echo $btn;
                            ?>
                        </button>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <!--    SELL CLOSED    -->
                <div class="courseCard__closed">
                    Продажи закрыты
                </div>
            <?php endif; ?>
		</div>
	</div>
</div>