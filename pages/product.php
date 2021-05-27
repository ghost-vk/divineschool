<?php
require_once __DIR__ . './../class/class-wc-course-product.php';
$product_id = get_the_ID();
$user_id = get_current_user_id();
$course_product = new LASH\WC_Course_Product($product_id);
if ( ! $course_product || ! $user_id ) { // If can't get course product or not login
	header('Location: ' . home_url());
}
$access = $course_product->is_available($user_id);
if ( ! $access ) { // If user haven't access to this course
	header('Location: ' . home_url());
}
?>
<?php get_header(); ?>
<div class="coursePage">
	<div class="container">
		<div class="coursePage__title w-75 mx-auto">
			<h3 class="lh-sm"><?php the_title(); ?></h3>
		</div>
        <?php
        $subtitle = get_field('product_subtitle');
        
        if ( $subtitle ) :
        ?>
            <div class="coursePage__subtitle">
                <h5 class="text-muted"><?php echo $subtitle; ?></h5>
            </div>
        <?php endif; ?>
		<div class="shedule">
			<h3 class="lh-sm"><?php the_field('product_shedule_title'); ?></h3>
            <?php if ( have_rows('product_repeater') ) : ?>
                <div class="shedule__row">
                <?php while ( have_rows('product_repeater') ) : the_row(); ?>
                    <div class="shedule__item">
						<?php if ( ! is_mobile() ) : ?>
                            <div class="shedule__index">
                                <span><?php the_sub_field('index'); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="shedule__content">
                            <?php if ( is_mobile() ) : ?>
                            <div class="shedule__index mobile">
                                <span><?php the_sub_field('index'); ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="shedule__title">
                                <p><?php the_sub_field('title'); ?></p>
                            </div>
                            <div class="shedule__description">
                                <p><?php the_sub_field('description'); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                </div>
            <?php endif; ?>
		</div>
        <div class="editorContent">
            <?php the_content(); ?>
        </div>
	</div>
</div>

<?php get_footer(); ?>

