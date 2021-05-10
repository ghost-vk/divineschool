<!--  FEATURES SECTION  -->
<?php if ( have_rows('home_features_repeater') ) : ?>
	<div class="homeFeatures" id="features">
		<div class="container-1">
			<h2><?php the_field('home_features_title'); ?></h2>
			<div class="homeFeatures__row">
				<?php while ( have_rows('home_features_repeater') ) : the_row(); ?>
					<div class="homeFeatures__item">
						<div class="homeFeatures__wrapper">
							<div class="homeFeatures__name">
								<div class="homeFeatures__icon">
									<img src="<?php the_sub_field('icon'); ?>" alt="" />
								</div>
								<h3><?php the_sub_field('title'); ?></h3>
							</div>
							<div class="homeFeatures__body">
								<p><?php the_sub_field('text'); ?></p>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
<?php endif; ?>