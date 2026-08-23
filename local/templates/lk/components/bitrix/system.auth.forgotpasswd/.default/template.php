<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?><?php

ShowMessage($arParams["~AUTH_RESULT"]);

?>

<div class="formbg">
    <form name="bform" method="post" target="_top" action="<?= $arResult["AUTH_URL"] ?>">
        <?php
        if (strlen($arResult["BACKURL"]) > 0) {
            ?>
            <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
            <?php
        }
        ?>
        <input type="hidden" name="AUTH_FORM" value="Y">
        <input type="hidden" name="TYPE" value="SEND_PWD">

        <div class="popup__title">
            <h2>Восстановление пароля</h2>
        </div>

        <small>
            <?= GetMessage("AUTH_FORGOT_PASSWORD_1") ?>
        </small>

        <!--    --><?php //= GetMessage("AUTH_GET_CHECK_STRING") ?>

        <div class="button-group-block d-grid align-items-center gap-1 mt-4 mb-2">
            <div class="form-outline wrap-input100 d-none">
                <input class="form-control form-control-lg" type="text" name="USER_LOGIN" maxlength="50" placeholder="Логин" value="<?= $arResult["LAST_LOGIN"] ?>"/>
            </div>

            <span class="d-none"><?= GetMessage("AUTH_OR") ?></span>

            <div class="form-outline wrap-input100">
                <input class="form-control form-control-lg" type="text" name="USER_EMAIL" placeholder="Email" maxlength="255"/>
            </div>
        </div>

        <div class="text-center pt-1 pb-1 wrap-input100">
            <input class="btn btn-primary btn-block btn-lg mb-3" type="submit" name="send_account_info" value="<?= GetMessage("AUTH_SEND") ?>"/>
        </div>

        <div class="d-flex align-items-center justify-content-center mt-5 pb-4">
            <a class="auth_btn btn btn-outline-danger" href="<?= $arResult["AUTH_AUTH_URL"] ?>"><i class='bx bx-chevron-left'></i> Я вспомнил(ла) пароль</a>
        </div>

    </form>
</div>

<script type="text/javascript">
    document.bform.onsubmit = function () {
        document.bform.USER_LOGIN.value = document.bform.USER_EMAIL.value ;
    };
    document.bform.USER_EMAIL.focus();
</script>
