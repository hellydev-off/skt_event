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

$filter = Array("ID"=> $USER->GetID());
$rsUser = CUser::GetList(($by="ID"), ($order="ID"), $filter);
$currUser = $rsUser->Fetch();
?>
<div class="item-list">

<!--        --><?php //echo '<pre>'; print_r($currUser); echo '</pre>'; ?>

    <h2 class="block-title">Объекты, поставщики <span><a href="#" id="object_add" class="btn btn-light"> <i class='bx bx-plus'></i></span></a></h2>

    <div class="table-container">
        <table id="objects" class="table responsive hover nowrap" style="width: 100%;">
            <thead>
            <tr>
                <th>Наименование подрядчика</th>
                <th>ИНН</th>
                <th>Телефон</th>
                <th>Email</th>
                <th>ФИО представителя</th>
                <th>Тип</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($arResult["ITEMS"] as $arItem): ?>
                <?php
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));


                $arSelect = array("ID", "IBLOCK_ID", "PROPERTY_*");//IBLOCK_ID и ID обязательно должны быть указаны
                $arFilter = array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ID" => $arItem, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
                $res = CIBlockElement::GetList(array(), $arFilter, false, array(), $arSelect);
                while ($ob = $res->GetNextElement()) {
                    $arProps = $ob->GetProperties(); // получаем все свойства
                }

                $arResult = $arProps;

                ?>

                <tr id="<?= $this->GetEditAreaId($arItem['ID']); ?>">

                    <?php if ($arParams["DISPLAY_NAME"] != "N" && $arItem["NAME"]): ?>
                        <td>
                            <a href="<?php echo $arItem["DETAIL_PAGE_URL"] ?>"><?php echo $arItem["NAME"] ?></a>
                        </td>
                    <?php endif; ?>

                    <?php if (!empty($arResult["INN"]["VALUE"])): ?>
                        <td>
                            <?= $arResult["INN"]["VALUE"] ?>
                        </td>
                    <?php endif; ?>

                    <?php if (!empty($arResult["PHONE"]["VALUE"])): ?>
                        <td>
                            <?= $arResult["PHONE"]["VALUE"] ?>
                        </td>
                    <?php endif; ?>

                    <?php if (!empty($arResult["EMAIL"]["VALUE"])): ?>
                        <td>
                            <?= $arResult["EMAIL"]["VALUE"] ?>
                        </td>
                    <?php endif; ?>

                    <?php if (!empty($arResult["FIO"]["VALUE"])): ?>
                        <td>
                            <?= $arResult["FIO"]["VALUE"] ?>
                        </td>
                    <?php endif; ?>

                    <?php if (!empty($arResult["SPHERE"]["VALUE_ENUM"])): ?>
                        <td>
                            <?= $arResult["SPHERE"]["VALUE_ENUM"] ?>
                        </td>
                    <?php endif; ?>

                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
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
                <h2>Добавление объекта</h2>
            </div>

            <form id="form_object_add" method="post" enctype="multipart/form-data">

                <div class="wrap-input100 certificate_div form-outline mb-2">
                    <span class="label-input">ИНН организации <span class="req">*</span></span>
                    <input class="form-control form-control-lg" type="text" id="COMPANY_INN" name="INN" required>
                </div>

                <div class="wrap-input100 form-outline mb-2">
                    <span class="label-input">Название организации <span class="req">*</span></span>
                    <input class="form-control form-control-lg" type="text" id="COMPANY_NAME" name="NAME" required>
                </div>

                <div class="wrap-input100 form-outline mb-2">
                    <span class="label-input">ФИО представителя <span class="req">*</span></span>
                    <input class="form-control form-control-lg" type="text" id="COMPANY_FIO" name="FIO" required>
                </div>

                <div class="wrap-input100 form-outline mb-2">
                    <span class="label-input">Телефон <span class="req">*</span></span>
                    <input class="form-control form-control-lg" type="text" id="COMPANY_PHONE" name="PHONE" required>
                </div>

                <div class="wrap-input100 form-outline mb-2">
                    <span class="label-input">Email <span class="req">*</span></span>
                    <input class="form-control form-control-lg" type="text" id="COMPANY_EMAIL" name="EMAIL" required>
                </div>

                <div class="wrap-input100 form-outline mb-2">
                    <span class="label-input">Дата договора</span>
                    <input class="form-control form-control-lg" type="text" id="COMPANY_DOC_DATE" name="DOC_DATE" >
                </div>

                <div class="wrap-input100 form-outline mb-2 select-input"">
                    <span class="label-input">Тип <span class="req">*</span></span>
                    <select id="COMPANY_SPHERE" name="SPHERE" class="js-select2 form-control">
                        <?php
                        $res = CIBlockProperty::GetPropertyEnum("SPHERE", array(), array("IBLOCK_ID" => 1));
                        while ($ar_res = $res->GetNext()) {
                            ?>
                            <option value="<?= $ar_res["ID"] ?>"<?= $ar_res["VALUE"] == $arResult['PROPERTIES']['SPHERE']['VALUE'] ? "selected" : "" ?>><?= $ar_res["VALUE"] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="wrap-input100 mt-4">
                    <input type="submit" name="go" value="Добавить объект" class="questionnaire_btn btn btn-primary btn-lg">
                </div>
            </form>
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
</script>

<script>
    $(document).ready(function() {
        $('.js-select2').select2({
            maximumSelectionLength: 2,
            language: "ru",
            dropdownParent: $('.popup-object-add')
        });
    });

    $("#COMPANY_PHONE").mask("+7 999 999-99-99");
</script>

<script>
    let table = new DataTable('#objects', {
        responsive: true,
        autoWidth: false,
        paging: true,
        language: {
            url: '<?= SITE_TEMPLATE_PATH ?>/js/ru.json',
        },
        layout: {
            topEnd: {
            },
            topStart: {
                search: {
                    placeholder: 'Поиск ...'
                }
            },
            bottomStart: 'paging',
            bottomEnd: 'pageLength'
        },
    });
</script>

<script>

        $("#form_object_add").submit(function (e) {
			// alert('ok***');

            e.preventDefault();

            var formData = new FormData();

            formData.append('inn', $('#COMPANY_INN').val());
            formData.append('name', $('#COMPANY_NAME').val());
            formData.append('fio', $('#COMPANY_FIO').val());
            formData.append('phone', $('#COMPANY_PHONE').val());
            formData.append('email', $('#COMPANY_EMAIL').val());
            formData.append('doc_date', $('#COMPANY_DOC_DATE').val());
            formData.append('sphere', $('#COMPANY_SPHERE').val());

            $.ajax({
                type: "POST",
                url: '<?=SITE_TEMPLATE_PATH ?>/ajax/object_add.php',
                contentType: false,
                processData: false,
                data: formData,
            }).done(function (data) {
                console.log(data);
                $('.popup.popup-sent').addClass('popup_open');

				//alert('ok');
                window.location = '/suppliers/';
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
                window.location = '/';
            });

            return false;


        });

</script>