<!--  COURSE CONTENT BRIEF -->
<?php if ( have_rows('brief_repeater') ) : ?>
	<div class="courseBrief">
		<div class="container-1">
			<h2><?php the_field('brief_title'); ?></h2>
			<div class="courseBrief__row">
                <?php while ( have_rows('brief_repeater') ) : the_row(); ?>
                    <div class="courseBrief__element">
                        <div class="courseBrief__num">
                            <?php the_sub_field('num'); ?>
                        </div>
                        <div class="courseBrief__text">
                            <p class="text-bigger-2">
								<?php the_sub_field('text'); ?>
                            </p>
                        </div>
                    </div>
                <?php endwhile; ?>
			</div>
		</div>
	</div>
<?php endif; ?>
