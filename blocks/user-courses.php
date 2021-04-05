<?php require_once __DIR__ . './../class/class-wc-course-product.php'; ?>
<div class="row">
	<div class="col-md-9">
		<?php if ( ! isset($_COOKIE['visitor']) ) : // Show hello first visit ?>
			<div class="userAccount__hello mb-3">
				<div class="rounded bg-warning py-5 px-3 text-center">
					<h3 class="mb-3">Добро пожаловать!</h3>
					<p>Спасибо, что выбрали нас!<br>
						Здесь вы можете посмотреть выбранные курсы</p>
				</div>
			</div>
		<?php endif; ?>
		<div class="coursesItems mb-md-0">
			<div class="rounded bg-warning py-5 px-3 text-center">
				<h3 class="mb-5">Мои курсы</h3>
                <?php $courses = get_user_paid_orders(); ?>
                <?php if ( ! empty($courses) ) : // If have access to course ?>
                    <?php foreach ( $courses as $course ) : ?>
                        <?php
                        $course_product = new \LASH\WC_Course_Product($course['product_id']);
                        $course_product->set_variation($course['variation_id']);
                        $package_name = $course_product->get_package_name();
                        $package_start = $course_product->get_nice_start_date();
                        ?>
                        <div class="row mb-5 justify-content-between">
                            <div class="col-md-3">
                                <img src="<?php echo get_field('user_account_image', $course['product_id']); ?>">
                            </div>
                            <div class="col-md-8 text-start">
                                <h5 class="mb-3"><?php echo get_the_title($course['product_id']); ?></h5>
                                <div class="mb-2"><?php $course_product->print_features(); ?></div>
                                <p class="text-muted mb-2"><?php echo 'Пакет "' . $package_name . '"'; ?></p>
                                <p class="text-muted mb-2">Дата начала курса: <?php echo $package_start; ?></p>
                                <a href="<?php echo esc_url(get_the_permalink($course['product_id'])); ?>">Посмотреть содержание курса и расписание</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : // If no available courses ?>
                    <h5 class="text-center">Пока что у вас нет доступных курсов</h5>
                <?php endif; ?>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="userAccount__contacts bg-warning p-3 mb-3 rounded">
			<h3 class="mb-3 text-center"><i class="fas fa-question-circle"></i>&nbsp;&nbsp;Поддержка</h3>
			<p><?php the_field('support_text'); ?><br><br>
                <?php if ( have_rows('support_repeater') ) : ?>
                    <?php while ( have_rows('support_repeater') ) : the_row(); ?>
                        <?php $link = get_sub_field('link'); ?>
                        <a href="<?php echo esc_url($link['url']); ?>" target="_blank"><?php echo $link['title']; ?></a><br>
                    <?php endwhile; ?>
                <?php endif; ?>
			</p>
		</div>
        <?php if ( have_rows('notifications_repeater') ) : ?>
            <?php while ( have_rows('notifications_repeater') ) : the_row(); ?>
                <div class="userAccount__contacts bg-warning p-3 mb-3 rounded">
                    <h3 class="mb-3 text-center"><i class="fas fa-exclamation-circle"></i></h3>
                    <p><?php the_sub_field('text'); ?></p>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
	</div>
</div>