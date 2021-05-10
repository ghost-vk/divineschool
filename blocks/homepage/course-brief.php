<!--  COURSE CONTENT BRIEF -->
<?php if ( have_rows('brief_repeater') ) : ?>
	<div class="courseBrief">
		<div class="container-1">
			<h2><?php the_field('brief_title'); ?></h2>
			<div class="courseBrief__row">
				<div class="courseBrief__image">
					<img src="<?php the_field('brief_image'); ?>" alt="" />
				</div>
				<div class="courseBrief__items">
					<?php while ( have_rows('brief_repeater') ) : the_row(); ?>
						<div class="courseBrief__element">
							<p><?php the_sub_field('text'); ?></p>
						</div>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>