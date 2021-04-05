<?php
defined( 'ABSPATH' ) || exit;
?>

<?php if ( $order ) : ?>
    
    <?php if ( $order->has_status( 'failed' ) ) : ?>

        <div class="thankYou">
            <div class="container">
                <div class="jumbotron text-xs-center py-5 text-center">
                    <h1 class="display-3">Платеж не удался</h1>
                    <p class="lead">Похоже ваш платеж был отклонен, возможно на вашем счету не достаточно средств</p>
                    <hr>
                    <p>
                        Есть вопросы? <a href="mailto:<?php the_field('email_link', 8); ?>">Напишите нам</a>
                    </p>
                    <p class="lead">
                        <a class="btn btn-primary btn-sm" href="<?= home_url(); ?>" role="button">Перейти на главную страницу</a>
                    </p>
                </div>
            </div>
        </div>

    <?php else : ?>

        <div class="thankYou">
            <div class="container">
                <div class="jumbotron text-xs-center py-5 text-center">
                    <h1 class="display-3">Спасибо!</h1>
                    <p class="lead"><strong>Пожалуйста проверьте ваш email (и папку спам)</strong>, в письме вы найдете данные для входа в личный кабинет.</p>
                    <hr>
                    <p>
                        Есть вопросы? <a href="mailto:<?php the_field('email_link', 8); ?>">Напишите нам</a>
                    </p>
                    <p class="lead">
                        <a class="btn btn-primary btn-sm" href="<?= home_url(); ?>" role="button">Перейти на главную страницу</a>
                    </p>
                </div>
            </div>
        </div>
    
    <?php endif; ?>
    
<?php endif; ?>