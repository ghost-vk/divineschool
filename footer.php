        <footer class="border-top mt-5 border-secondary">
            <div class="container-md">
                <div class="row pt-4 my-md-5 pt-md-5">
                    <div class="col-12 col-md order-2 order-md-0">
                        <h4 class="text-muted text-center text-md-start"><?= get_bloginfo( 'name' ); ?></h4>
                        <small class="d-block mb-3 text-muted text-center text-md-start">© 2021, Все права защищены</small>
                    </div>
                    <div class="col-12 col-md">
                        <h5 class="text-center text-md-start text-primary">Карта сайта</h5>
                        <ul class="list-unstyled text-small text-center text-md-start">
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="<?= home_url(); ?>">Главная страница</a></li>
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="<?= home_url('/user'); ?>">Личный кабинет</a></li>
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="<?= home_url('/cart'); ?>">Корзина</a></li>
                            <?php if ( is_user_logged_in() ) : ?>
                                <li class="mb-1"><a class="link-secondary text-decoration-none" href="<?php echo wp_logout_url(home_url()); ?>">Выход</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="col-12 col-md">
                        <h5 class="text-center text-md-start text-primary">Контакты</h5>
                        <ul class="list-unstyled text-small text-center text-md-start">
                            <?php $wa_link = get_field('wa_link', 8); ?>
                            <?php if ( $wa_link ) : ?>
                                <li class="mb-1"><a class="link-secondary text-decoration-none" href="<?= $wa_link['url']?>"><i class="fab fa-whatsapp"></i>&nbsp;&nbsp;<?= $wa_link['title']?></a></li>
                            <?php endif; ?>
                            
                            <?php $email_link = get_field('email_link', 8); ?>
							<?php if ( $email_link ) : ?>
                                <li class="mb-1"><a class="link-secondary text-decoration-none" href="mailto:<?= $email_link; ?>"><i class="far fa-envelope"></i>&nbsp;&nbsp;<?= $email_link; ?></a></li>
							<?php endif; ?>
	
							<?php $phone_text = get_field('phone_text', 8); ?>
							<?php if ( $phone_text ) : ?>
                                <li class="mb-1"><a class="link-secondary text-decoration-none" href="tel:<?= $phone_text; ?>"><i class="fas fa-phone-alt"></i>&nbsp;&nbsp;<?= $phone_text; ?></a></li>
							<?php endif; ?>
	
							<?php $instagram_link = get_field('instagram_link', 8); ?>
							<?php if ( $instagram_link ) : ?>
                                <li class="mb-1"><a class="link-secondary text-decoration-none" href="<?= $instagram_link['url']; ?>"><i class="fab fa-instagram"></i>&nbsp;&nbsp;<?= $instagram_link['title']; ?></a></li>
							<?php endif; ?>
                        </ul>
                    </div>
                    <div class="col-12 col-md">
                        <h5 class="text-center text-md-start text-primary">О нас</h5>
                        <ul class="list-unstyled text-small text-center text-md-start">
                            <li class="mb-1"><p class="link-secondary text-decoration-none mb-0">ИП "Давудова Анна Николаевна"</p></li>
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="<?= home_url('/privacy'); ?>">Политика конфиденциальности</a></li>
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="<?= home_url('/user-agreement'); ?>">Пользовательское соглашение</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        
        <?php require_once __DIR__ . '/blocks/user-popups.php'; ?>

		<?php wp_footer(); ?>

	</div>
</body>
</html>