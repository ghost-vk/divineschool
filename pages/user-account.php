<?php if ( ! is_user_logged_in() ) {
	header('Location: ' . home_url() . '?login=true');
} ?>
<?php
if ( ! isset($_COOKIE['visitor']) ) { // First visit user account
	setcookie('visitor', '1', time() + 3600 * 24 * 60, '/', '', 0);
}
?>
<?php get_header(); ?>
    <div class="container">
        <div class="userAccount py-5">
            <div class="userAccount__title text-center mb-5">
                <h3 class="text-primary fw-bold">Кабинет пользователя</h3>
            </div>
            <!--      PURCHASES LIST      -->
			<?php require_once __DIR__  . './../blocks/user-courses.php'; ?>
        </div>
    </div>
<?php get_footer(); ?>
