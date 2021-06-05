<?php if ( ! is_user_logged_in() ) : ?>
    <div id="cookieNotification" class="cookieNotification">
        <div class="cookieNotification__body">
            <div class="container-1 cookieNotification__ref">
                <p>
                    Для повышения удобства работы с сайтом на нем используются
                    <a href="<?php echo home_url('/privacy'); ?>">файлы cookie</a>. В cookie содержатся данные
                    о Ваших прошлых посещениях сайта. Если Вы не хотите, чтобы эти данные обрабатывались,
                    отключите cookie в настройках браузера.
                </p>
                <div class="cookieNotification__close" id="agreeWithCookieBtn">x</div>
            </div>
        </div>
    </div>
<?php endif; ?>