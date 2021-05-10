<!--  HERO SECTION  -->
<?php global $project_name; ?>
<div class="homeHero">
	<div class="homeHero__row">
		<div class="homeHero__image">
			<div class="homeHero__image-container">
				<img src="<?php the_field('hero_bg'); ?>" alt="" />
			</div>
		</div>
		<div class="homeHero__info">
			<h1><?php echo $project_name; ?></h1>
			<div class="homeHero__subtitle text-white-desktop">
				<?php the_field('hero_subtitle'); ?>
			</div>
			<div class="homeHero__call">
				<?php the_field('hero_call_text'); ?>
			</div>
			<a class="homeHero__btn bigButton" href="#packages">
				<?php the_field('hero_btn_text'); ?>
			</a>
			<?php if ( have_rows('hero_features_repeater') ) : ?>
				<?php while ( have_rows('hero_features_repeater') ) : the_row(); ?>
					<div class="homeHero__check">
						<img src="<?php echo get_stylesheet_directory_uri() . '/img/icons/hero-check.svg'; ?>" alt="" />
						<span><?php the_sub_field('text'); ?></span>
					</div>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
</div>