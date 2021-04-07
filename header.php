<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
	<?php wp_head(); ?>
 
</head>
<body class="lightBg">
<div id="main">
	<header class="bg-primary">
        <div class="container-md">
            <nav class="navbar navbar-expand-md navbar-dark" aria-label="Third navbar example">
                <div class="container-fluid">
                    <a class="navbar-brand" href="<?= home_url(); ?>"><?= get_bloginfo( 'name' ); ?></a>
                    <div class="me-auto d-none d-sm-block"></div>
                    <div class="d-md-block d-flex justify-content-between">
                        <a href="<?= home_url('/cart'); ?>" class="btn btn-secondary me-2"><i class="fas fa-shopping-cart"></i><span class="d-none d-sm-inline-block">&nbsp;&nbsp;Корзина</span></a>
						<?php if ( is_user_logged_in() ) : ?>
                            <?php
							$current_user = wp_get_current_user();
							$first_name = $current_user->user_firstname;
                            ?>
                            <a href="<?= home_url('/user'); ?>" class="btn btn-info me-2"><i class="fas fa-user"></i><span class="d-none d-sm-inline-block">&nbsp;&nbsp;<?= $first_name; ?></span></a>
                            <a href="<?php echo wp_logout_url(home_url()); ?>" class="btn btn-light">
                                <i class="fas fa-sign-out-alt"></i></i><span class="d-none d-sm-inline-block">&nbsp;&nbsp;Выход</span>
                            </a>
						<?php else : ?>
                            <a href="#" class="btn btn-info popup-opener" data-popup="popup-login"><i class="fas fa-user"></i><span class="d-none d-sm-inline-block">&nbsp;&nbsp;Личный кабинет</span></a>
						<?php endif; ?>
                    </div>
                </div>
            </nav>
        </div>
	</header>