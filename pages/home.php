<?php
do_action('redirect_to_user_account');
get_header(); ?>

<?php
global $course_product_id;
global $project_name;

$course_product_id = get_field('course_product_id')[0];
$project_name = get_field('project_name');
?>

<?php require_once __DIR__ . '/../blocks/homepage/hero.php'; ?>
<?php require_once __DIR__ . '/../blocks/homepage/features.php'; ?>
<?php require_once __DIR__ . '/../blocks/homepage/course-brief.php'; ?>
<?php require_once __DIR__ . '/../blocks/homepage/banner-info.php'; ?>
<?php require_once __DIR__ . '/../blocks/homepage/countdown-timer.php'; ?>

<div class="courseCard-home_first" id="packages">
	<?php require_once __DIR__ . '/../blocks/homepage/packages.php'; ?>
</div>

<?php require_once __DIR__ . '/../blocks/homepage/course-program.php'; ?>
<?php require_once __DIR__ . '/../blocks/homepage/author.php'; ?>
<?php require_once __DIR__ . '/../blocks/homepage/author-quote.php'; ?>
<?php require_once __DIR__ . '/../blocks/homepage/comparing.php'; ?>

<!--    REPEAT COURSE CARD    -->
<div class="courseCard-home_second">
	<?php require __DIR__ . '/../blocks/homepage/packages.php'; ?>
</div>

<?php get_footer(); ?>
