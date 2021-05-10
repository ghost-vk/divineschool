        <!--   NOTIFICATION   -->
        <div class="notification" id="notification"></div>

        <!--    FOOTER    -->
        <footer class="footer">
            <div class="container-1">
                <div class="footer__row">
                    <div class="footer__column footer__column-identica">
                        <p class="footer__sitename">
                            <?php echo get_bloginfo( 'name' ); ?>
                        </p>
                        <p class="footer__copyright">
                            &copy; 2021, Все права защищены
                        </p>
                    </div>
                    <div class="footer__column">
                        <p class="footer__title">Карта сайта</p>
                        <a href="<?php echo home_url(); ?>" class="footer__link">Главная страница</a>
                        <a href="<?php echo home_url('/user'); ?>" class="footer__link">Личный кабинет</a>
                        <a href="<?php echo home_url('/cart'); ?>" class="footer__link">Корзина</a>
                        <a href="<?php echo home_url('/privacy'); ?>" class="footer__link">
                            Политика конфиденциальности
                        </a>
                        <a href="<?php echo home_url('/user-agreement'); ?>" class="footer__link">
                            Пользовательское соглашение
                        </a>
                    </div>
                    <div class="footer__column">
                        <p class="footer__title">Контакты</p>
                        <?php $whats_app = get_field('contacts_wa', 'option'); ?>
                        <?php if ( $whats_app ) : ?>
                            <a href="https://api.whatsapp.com/send?phone=<?php echo $whats_app; ?>"
                               class="footer__link" target="_blank">
                                <i class="fab fa-whatsapp"></i>&nbsp;&nbsp;Написать в What's App
                            </a>
                        <?php endif; ?>
            
                        <?php $email = get_field('contacts_email', 'option'); ?>
                        <?php if ( $email ) : ?>
                            <a class="footer__link" href="mailto:<?php echo $email; ?>" target="_blank">
                                <i class="far fa-envelope"></i>&nbsp;&nbsp;<?php echo $email; ?>
                            </a>
                        <?php endif; ?>
            
                        <?php $phone = get_field('contacts_phone', 'option'); ?>
                        <?php if ( $phone ) : ?>
                            <a class="footer__link" href="<?php echo $phone['url']; ?>" target="_blank">
                                <i class="fas fa-phone-alt"></i>&nbsp;&nbsp;<?php echo $phone['title']; ?>
                            </a>
                        <?php endif; ?>
            
                        <?php $instagram_link = get_field('contacts_instagram', 'option'); ?>
                        <?php if ( $instagram_link ) : ?>
                            <a class="footer__link" href="<?php echo $instagram_link; ?>" target="_blank">
                                <i class="fab fa-instagram"></i>&nbsp;&nbsp;Посмотреть в Instagram
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="footer__column">
                        <p class="footer__title">О нас</p>
                        <p class="footer__link">ИП "Давудова Анна Николаевна"</p>
                        <p class="footer__link">ИНН: 233613336553</p>
                        <p class="footer__link">ОГРН: 317237500305432</p>
                    </div>
                </div>
            </div>
        </footer>
        
        <?php require_once __DIR__ . '/blocks/cookie-notification.php'; ?>
        <?php require_once __DIR__ . '/blocks/user-popups.php'; ?>

		<?php wp_footer(); ?>

	</div>
</body>
</html>