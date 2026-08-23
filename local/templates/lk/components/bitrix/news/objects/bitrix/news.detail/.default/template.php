<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<?php //echo '<pre>'; var_dump($arResult['PROPERTIES']['USER_PROEKT']['ID']); echo '</pre>'; ?>

<div class="item-detail">
    <?php if (CSite::InGroup(array(7))) { ?>
        <a href="#" id="object_add" class="btn btn-light">Внести изменения</a>
    <?php } ?>

    <div class="block_detail_info">
        <div class="block_detail_info-chars">

            <div class="block_detail_info-chars-item">
                <span class="info-title">Статус объекта:</span>
                <span class="info-value"><?= $arResult['PROPERTIES']['OBJECT_STATUS']['VALUE'] ?></span>
            </div>

            <div class="block_detail_info-chars-item">
                <span class="info-title">Проектная организация:</span>
                <span class="info-value"><?= $arResult['PROPERTIES']['PROJECT_COMPANY']['VALUE'] ?></span>
            </div>

            <div class="block_detail_info-chars-item">
                <span class="info-title">Адрес объекта:</span>
                <span class="info-value"><?= $arResult['PROPERTIES']['OBJECT_ADDRESS']['VALUE'] ?></span>
            </div>

            <div class="block_detail_info-chars-item">
                <span class="info-title">Кадастровый номер:</span>
                <span class="info-value"><?= $arResult['PROPERTIES']['OBJECT_NUMB']['VALUE'] ?></span>
            </div>

            <div class="block_detail_info-chars-item">
                <span class="info-title">Заказчик</span>
                <span class="info-value"><?= $arResult['PROPERTIES']['OBJECT_CUSTOMER']['VALUE'] ?></span>
            </div>

            <div class="block_detail_info-chars-item">
                <span class="info-title">Авторский надзор</span>
                <span class="info-value"><?= (($arResult['PROPERTIES']['OBJECT_SUPERVISION']['VALUE']) == 'Y' ? 'Да' : 'Нет') ?></span>
            </div>

            <div class="block_detail_info-chars-item">
                <span class="info-title">Подписать агентский договор</span>
                <span class="info-value"><?= (($arResult['PROPERTIES']['DOC_SIGN']['VALUE']) == 'Y' ? 'Да' : 'Нет') ?></span>
            </div>


            <div class="block_detail_info-chars-item">
                <span class="info-title">Срок выдачи проектной документации</span>
                <span class="info-value"><?= $arResult['PROPERTIES']['DOC_DEADLINE']['VALUE'] ?></span>
            </div>
            <div class="block_detail_info-chars-item">
                <span class="info-title">Количество баллов</span>
                <span class="info-value"><?= lk_get_bonus_tbl($arResult['PROPERTIES']['USER_PROEKT']['VALUE'], $arResult['ID'])['sum'] ?></span>
            </div>
            <div class="block_detail_info-chars-item">
                <span class="info-title">Спецификация</span>
                <span class="info-value">
                    <?php
                    CModule::IncludeModule('iblock');
                    $rsFile = CFile::GetByID($arResult['PROPERTIES']['OBJECT_SPECIFICATION']['VALUE']['0']);
                    $arFile = $rsFile->GetNext();
                    $typeFile = explode('/', $arFile['CONTENT_TYPE']);
                    $fileName = explode('.', $arFile['FILE_NAME']);
                    $sizeFile = $arFile['FILE_SIZE'] / 1000000;
                        ?>

<!--                    --><?php //echo '<pre>'; print_r($arFile); echo '</pre>'; ?>


<!--                  --><?php //foreach ($arResult['PROPERTIES']['OBJECT_SPECIFICATION']['VALUE'] as $i => $picId) { ?>
<!--                      --><?php //$_ext = end(explode(".", $arResult['PROPERTIES']['OBJECT_SPECIFICATION']['DESCRIPTION'][$i])) ?>

                      <a style="display:block;margin-bottom:5px" href="<?= $arFile['SRC'] ?>" target="_blank">

                      <span class="ext_ico ei_<?= $typeFile['1'] ?>">.<?= $typeFile['1'] ?></span>

                      <span><?= $arFile['FILE_NAME'] ?></span>
                    </a>
<!--                  --><?php //} ?>

                </span>
            </div>

        </div>
    </div>

</div>


<div class="popup popup-object-add">
    <div class="popup__bgd"></div>
    <div class="popup__content">
        <div class="popup__close">
            <i class='bx bx-x'></i>
        </div>

        <div>
            <div class="popup__title">
                <h2>Редактирование проекта</h2>
            </div>

            <form id="form_object_add" method="post" enctype="multipart/form-data">
                <input type="hidden" name="ID_OBJ" value="<?= $arResult['ID'] ?>">
                <fieldset class="mt-4 mb-2">
                    <legend>Статус объекта: <span class="req">*</span></legend>

                    <div class="mb-2">
                        <input type="radio" id="UF_MKD" name="PROJECT[OBJECT_STATUS]" value="МКД" <?= (($arResult['PROPERTIES']['OBJECT_STATUS']['VALUE'] == 'МКД' ? 'checked' : '')) ?> />
                        <label for="UF_MKD">МКД</label>
                    </div>

                    <div class="mb-2">
                        <input type="radio" id="UF_IZHS" name="PROJECT[OBJECT_STATUS]" value="ИЖС" <?= (($arResult['PROPERTIES']['OBJECT_STATUS']['VALUE'] == 'ИЖС' ? 'checked' : '')) ?>/>
                        <label for="UF_IZHS">ИЖС</label>
                    </div>
                </fieldset>

                <div class="wrap-input100 certificate_div form-outline mb-2">
                    <span class="label-input">Проектная организация</span>
                    <input class="form-control form-control-lg" type="text" id="PROJECT_COMPANY" name="PROJECT[PROJECT_COMPANY]" value="<?= $arResult['PROPERTIES']['PROJECT_COMPANY']['VALUE'] ?>">
                </div>

                <div class="wrap-input100 form-outline mb-2">
                    <span class="label-input">Название объекта <span class="req">*</span></span>
                    <input class="form-control form-control-lg" type="text" id="OBJECT_NAME" name="PROJECT[NAME]" required value="<?= $arResult['NAME'] ?>">
                </div>

                <div class="wrap-input100 form-outline mb-2">
                    <span class="label-input">Адрес объекта</span>
                    <input class="form-control form-control-lg" type="text" id="OBJECT_ADDRESS" name="PROJECT[OBJECT_ADDRESS]" value="<?= $arResult['PROPERTIES']['OBJECT_ADDRESS']['VALUE'] ?>">
                </div>

                <div class="wrap-input100 form-outline mb-2">
                    <span class="label-input">Кадастровый номер</span>
                    <input class="form-control form-control-lg" type="text" id="OBJECT_NUMB" name="PROJECT[OBJECT_NUMB]" value="<?= $arResult['PROPERTIES']['OBJECT_NUMB']['VALUE'] ?>">
                </div>

                <div class="wrap-input100 form-outline mb-2">
                    <span class="label-input">Заказчик</span>
                    <input class="form-control form-control-lg" type="text" id="OBJECT_CUSTOMER" name="PROJECT[OBJECT_CUSTOMER]" value="<?= $arResult['PROPERTIES']['OBJECT_CUSTOMER']['VALUE'] ?>">
                </div>

                <div class="wrap-input100 form-outline mb-2">
                    <span class="label-input">Авторский надзор <span class="req">*</span></span>
                    <input class="" type="checkbox" id="OBJECT_SUPERVISION" name="PROJECT[OBJECT_SUPERVISION]" value="Y"
                           required <?= (($arResult['PROPERTIES']['OBJECT_SUPERVISION']['VALUE'] == 'Y' ? 'checked' : '')) ?>>
                </div>

                <div class="wrap-input100 form-outline mb-2">
                    <span class="label-input">Подписать агентский договор</span>
                    <input class="" type="checkbox" id="DOC_SIGN" name="PROJECT[DOC_SIGN]" value="Y" <?= (($arResult['PROPERTIES']['DOC_SIGN']['VALUE'] == 'Y' ? 'checked' : '')) ?>>
                </div>

                <div class="file-block wrap-input100 mb-2">
                    <label for="order_file">Спецификация</label>
                    <input type="file" id="OBJECT_SPECIFICATION" name="object_spec[]" multiple>
                    <div class="img_delete_cont">


                        <?php foreach ($arResult['PROPERTIES']['OBJECT_SPECIFICATION']['VALUE'] as $i => $picId) { ?>
                            <?php //var_dump('<pre>', end(explode(".", $arResult['PROPERTIES']['OBJECT_SPECIFICATION']['DESCRIPTION'][$i])))?>
                            <?php $_ext = end(explode(".", $arResult['PROPERTIES']['OBJECT_SPECIFICATION']['DESCRIPTION'][$i])) ?>
                            <a style="display:block;margin-bottom:5px" href="<?= CFile::GetPath($picId) ?>" target="_blank">
                                <?php /*<img src="<?=CFile::ResizeImageGet($picId, array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src']?>">*/ ?>
                                <span class="ext_ico ei_<?= $_ext ?>">.<?= $_ext ?></span>
                                <span><?= $arResult['PROPERTIES']['OBJECT_SPECIFICATION']['DESCRIPTION'][$i] ?></span>
                                <input type="checkbox" value="<?= $picId ?>" name=DELETE_IMG[]>
                            </a>
                        <?php } ?>


                        <?php /*foreach($arResult['PROPERTIES']['OBJECT_SPECIFICATION']['VALUE'] as $picId){?>
                        <label>
                          <input type="checkbox" value="<?=$picId?>" name=DELETE_IMG[]>
                          <img src="<?=CFile::ResizeImageGet($picId, array('width'=>150, 'height'=>150), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src']?>">
                        </label>
                      <?}*/ ?>
                    </div>
                </div>

                <div class="wrap-input100 form-outline mb-2">
                    <span class="label-input">Срок выдачи проектной документации</span>
                    <input type="date" id="DOC_DEADLINE" name="PROJECT[DOC_DEADLINE]" required
                           max="<?= date("Y-m-d") ?>"
                           value="<?= date("Y-m-d", strtotime($arResult['PROPERTIES']['DOC_DEADLINE']['VALUE'])) ?>">
                </div>


                <div class="wrap-input100 mt-4">
                    <input type="submit" name="go" value="Сохранить изменения" class="questionnaire_btn btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>
<div class="popup popup-sent">
    <div class="popup__bgd"></div>
    <div class="popup__content">
        <div class="popup__close">
            <i class='bx bx-x'></i>
        </div>
        <h2>Сохранено</h2>
        <p></p>
        <div class="popup__body">
            <button type="button" class="btn btn-primary btn-lg popup__close_button">Закрыть</button>
        </div>
    </div>
</div>
<script>
    $('#object_add').click(function (e) {
        e.preventDefault();
        $(".popup-object-add").addClass("popup_open");
    });
    $('.popup.popup-object-add .popup__bgd, .popup.popup-object-add .popup__close').on('click', function () {
        $('.popup.popup-object-add').removeClass('popup_open');
    });
    $("#form_object_add").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: '<?=SITE_TEMPLATE_PATH ?>/ajax/object_mod.php',
            contentType: false,
            processData: false,
            data: formData,
        }).done(function (data) {
            console.log(data);
            $('.popup.popup-sent').addClass('popup_open');
        }).fail(function () {
            $('.sent_error > div').html('Ошибка.');
            $('.sent_error').fadeIn(300, function () {
                setTimeout(function () {
                    $('.sent_error').fadeOut(300);
                }, 3000);
            });
            return false;
        });
        $('.popup.popup-sent .popup__bgd, .popup.popup-sent .popup__close, .popup.popup-sent .popup__close_button').on('click', function () {
            $('.popup.popup-sent').removeClass('popup_open');
            //window.location = '/';
            location.reload();
        });
        return false;
    });
</script>