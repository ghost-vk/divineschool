<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
    <meta name="description" content="Онлайн школа Анны Давудовой <?php echo get_bloginfo( 'name' ); ?>"/>
    <meta property="og:title" content="<?php the_title(); ?>">
    <meta property="og:site_name" content="Онлайн школа Анны Давудовой <?php echo get_bloginfo( 'name' ); ?>">
    <meta property="og:type" content="website">
    <meta property="og:image" content="<?php echo get_stylesheet_directory_uri(); ?>/img/pictures/anna-author.jpg">
    <meta property="og:locale" content="ru_RU">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="x-rim-auto-match" content="none">
</head>
<body>
<div id="main" class="divine-school-bg">
    <!--    HEADER    -->
    <header class="header">
        <div class="container-1">
            <div class="header__row">
                <div class="header__column">
                    <div class="header__desktop">
                        <a href="<?php echo home_url(); ?>" class="header__link header__link-sitename">
							<?php echo get_bloginfo( 'name' ); ?>
                        </a>
                        
                        <?php if ( is_front_page() && ! is_mobile() ) : // Show course blocks anchors only on front page ?>
                            <a href="#features" class="header__link header__link-element">Для кого?</a>
                            <a href="#packages" class="header__link header__link-element">Пакеты</a>
                            <a href="#course-program" class="header__link header__link-element">Программа курса</a>
                            <a href="#author" class="header__link header__link-element">Об авторе</a>
                        <?php endif; ?>
                    </div>
                    <?php if ( is_mobile() ) : ?>
                        <div class="header__mobile">
                            <div class="header__box">
                                <div class="header__button" id="mobileMenuBtn">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="header__column">
                    <?php global $woocommerce; ?>
                    <a href="<?php echo home_url('/cart'); ?>" id="headerCart" class="header__link header__link-cart
                    <?php if ( ! $woocommerce->cart->is_empty() ) { echo 'header__link-cart-active'; } ?>">
                        <i class="fas fa-shopping-cart"></i>
                        <div>1</div>
                    </a>
                    <?php if ( current_user_can('administrator') ) : ?>
                        <a href="<?php echo home_url('/wp-admin'); ?>" class="header__link header__link-login">
                            <i class="fas fa-users-cog"></i>
                        </a>
                    <?php endif; ?>
	                <?php if ( is_user_logged_in() && current_user_can('administrator') ) : ?>
                        <a href="<?php echo home_url('/user'); ?>" class="header__link header__link-login">
                            <i class="fas fa-sign-in-alt"></i>&nbsp;&nbsp;ЛК
                        </a>
	                <?php endif; ?>
                    <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo wp_logout_url(home_url()); ?>" class="header__link header__link-login">
                            <i class="fas fa-sign-out-alt"></i>&nbsp;&nbsp;Выход
                        </a>
                    <?php else : ?>
                        <a href="#" class="header__link header__link-login popup-opener" data-popup="popup-login">
                            <i class="fas fa-user"></i>&nbsp;&nbsp;Войти
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <!--   MOBILE MENU   -->
    <?php if ( is_mobile() ) : ?>
        <div class="mobileMenu" id="mobileMenu">
            <div class="container">
                <div class="mobileMenu__body">
                    <?php if ( is_front_page() ) : // Show course blocks anchors only on front page ?>
                        <div class="mobileMenu__title">
                            О курсе
                        </div>
                        <div class="mobileMenu__items">
                            <a href="#features">Для кого?</a>
                            <a href="#packages">Пакеты</a>
                            <a href="#course-program">Программа курса</a>
                            <a href="#author">Об авторе</a>
                        </div>
                    <?php endif; ?>
                    <div class="mobileMenu__title">
                        Навигация
                    </div>
                    <?php if ( is_user_logged_in() ) : ?>
                        <div class="mobileMenu__items">
                            <a href="<?php echo home_url('/user'); ?>">Личный кабинет</a>
                        </div>
                    <?php else : ?>
                        <div class="mobileMenu__items">
                            <a href="<?php echo home_url(); ?>">Главная страница</a>
                            <a href="<?php echo home_url('/cart'); ?>">Корзина</a>
                        </div>
                    <?php endif; ?>
                    <div class="mobileMenu__title">
                        Контакты
                    </div>
                    <div class="mobileMenu__items">
                        <a href="https://api.whatsapp.com/send?phone=<?php the_field('contacts_wa', 'option'); ?>"
                        target="_blank">
                            <i class="fab fa-whatsapp"></i>&nbsp;What's App
                        </a>
                        <a href="<?php the_field('contacts_instagram', 'option'); ?>" target="_blank">
                            <i class="fab fa-instagram"></i>&nbsp;Instagram
                        </a>
                    </div>
                    <div class="mobileMenu__close" id="closeMenuBtn">
                        <div class="mobileMenu__x"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    