<!--    ABOUT COURSE AUTHOR    -->
<div class="courseAuthor" id="author">
	<div class="courseAuthor__wrapper">
		<div class="courseAuthor__row">
			<div class="courseAuthor__image">
				<img src="<?php the_field('author_image'); ?>" alt="Автор курса" />
			</div>
			<div class="courseAuthor__info">
				<div class="courseAuthor__title text-white">
					<?php the_field('author_title'); ?>
				</div>
				<div class="courseAuthor__name">
					<p><?php the_field('author_name'); ?></p>
				</div>
				<div class="courseAuthor__insta">
					<p><?php the_field('author_badge'); ?></p>
				</div>
				<p class="text-white">
					<?php the_field('author_about'); ?>
				</p>
			</div>
		</div>
	</div>
</div>