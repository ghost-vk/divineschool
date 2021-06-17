<?php
require_once __DIR__  . '/../../class/LidForm/LidFormData.php';
$_lf_dal = new \Ghost\LidForm\LidFormData();
if ( ! is_user_logged_in() && $_lf_dal->IsOn() ) : // Lid form is turned on and new visitor
	?>
    <div id="discountModal" class="d-none position-fixed top-0 bottom-0 start-0 end-0">
        <div class="container h-100 d-flex flex-column justify-content-center">
            <div class="discountModal__wrapper shadow rounded ms-auto me-auto position-relative"
                 style="background-image:url('<?php the_field('lid_form_bg', 'options'); ?>');">
            <span class="discountModal__close position-absolute">
                <i class="fas fa-times fs-1 text-primary"></i>
            </span>
                <button class="discountModal__button rounded bg-secondary fs-5 text-nowrap position-absolute shadow">
                    Получить скидку
                </button>
            </div>
        </div>
    </div>
    <div id="lidFormWrapper" class="d-none position-fixed top-0 bottom-0 start-0 end-0">
        <div class="container h-100 d-flex flex-column justify-content-center">
            <div>
                <form class="row g-3 position-relative" id="lidForm">
				<span id="closeLidForm" class="position-absolute">
					<i class="fas fa-times fs-1 text-secondary"></i>
				</span>
                    <div class="col-12">
                        <label class="form-label">ФИО</label>
                        <input type="text" class="form-control" id="lidName">
                    </div>
                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Номер телефона</label>
                        <input type="text" class="form-control" placeholder="+7 999 888 77 66" id="lidPhone">
                    </div>
                    <div class="col-12">
                        <label for="inputAddress2" class="form-label">Email</label>
                        <input type="text" class="form-control" placeholder="youremail@domain.com" id="lidEmail">
                    </div>
                    <div class="col-12">
                        <label for="inputCity" class="form-label">Instagram</label>
                        <input type="text" class="form-control" id="lidInstagram">
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="lidFormCheck">
                            <label class="form-check-label" for="gridCheck">
                                Даю свое согласие на <a href="<?php echo home_url('/privacy'); ?>">обработку данных</a>
                            </label>
                        </div>
                    </div>
                    <div id="lidFormError" class="d-none col-12 alert alert-danger"></div>
                    <div class="col-12">
                        <button class="d-block btn-lg btn-secondary ms-auto me-auto" id="lidFormSubmit">Получить скидку!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>