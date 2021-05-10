<?php
global $course_product_id;
global $is_course_started;

$start_datetime_str = get_field('start_datetime', $course_product_id);
$start_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $start_datetime_str);
$now = new DateTime('NOW');
if ( $start_datetime ) {
    if ( $now > $start_datetime ) {
		$is_course_started = true;
    } else {
		$is_course_started = false;
    }
} else {
	$is_course_started = true;
}
?>

<!--  COUNTDOWN TIMER  -->
<div class="courseCountdown">
	<div class="container">
        <?php if ( $is_course_started === false ) : ?>
            <div class="courseCountdown__title">
                <h3>До старта осталось</h3>
            </div>
            <div class="courseCountdown__wrapper">
                <div id="flipdown" class="flipdown"></div>
            </div>
        <?php else : ?>
            <div class="courseCountdown__title">
                <h3>Продажи закрыты</h3>
            </div>
        <?php endif; ?>
	</div>
</div>