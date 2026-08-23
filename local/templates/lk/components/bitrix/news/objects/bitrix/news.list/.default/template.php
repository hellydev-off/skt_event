<?define("NEED_AUTH", true)?>
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

if(!CSite::InGroup(array(6, 7)))die('Нет доступа.');

$filter = Array("ID"=> $USER->GetID());
$rsUser = CUser::GetList(($by="ID"), ($order="ID"), $filter);
$currUser = $rsUser->Fetch();
?>
<div class="item-list">



    <h2 class="block-title">Проекты <span>
      <?if(CSite::InGroup(array(7))){?><a href="#" id="object_add" class="btn btn-light"> <i class='bx bx-plus'></i></span></a><?}?>
    </h2>

    <div class="table-container">

        <table id="objects" class="table responsive hover" style="width: 100%;">
            <thead>
            <tr>
                <th>Название объекта</th>
                <th>Статус объекта</th>
                <th>Адрес объекта</th>
                <th>Заказчик</th>
                <th>Начислено баллов</th>
                <th>Дата добавления</th>
                <th>Дата изменения</th>
                <th>Файлы спецификации</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($arResult["ITEMS"] as $arItem): ?>
                <?php
                //var_dump($arItem['PROPERTIES']['USER_PROEKT']['VALUE']);
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

<!--                --><?php //echo '<pre>'; print_r($arResult["DOC_DEADLINE"]); echo '</pre>'; ?>

                <tr id="<?= $this->GetEditAreaId($arItem['ID']); ?>">


                        <td>
                            <a href="<?php echo $arItem["DETAIL_PAGE_URL"] ?>"><?php echo $arItem["NAME"] ?></a>
                        </td>

                        <td>
                            <?= $arResult["OBJECT_STATUS"]["VALUE"] ?>
                        </td>



                        <td>
                            <?= $arResult["OBJECT_ADDRESS"]["VALUE"] ?>
                        </td>


  
                        <td>
                            <?= $arResult["OBJECT_CUSTOMER"]["VALUE"] ?>
                        </td>



                        <td>
                            <?= $arResult["OBJECT_BALL"]["VALUE"] ?>
                        </td>
                        
                        <td>
                            <?=FormatDateFromDB($arItem["DATE_CREATE"], 'SHORT')?>
                        </td>
                        <td>
                            <?=FormatDateFromDB($arItem["TIMESTAMP_X"], 'SHORT')?>
                        </td>
                        <td>
                        <?foreach($arResult['OBJECT_SPECIFICATION']['VALUE'] as $i=>$picId){?>
                          <?$_ext=end(explode(".", $arResult['OBJECT_SPECIFICATION']['DESCRIPTION'][$i]))?>
                          <a style="display:block;margin-bottom:5px" href="<?=CFile::GetPath($picId)?>" target="_blank">
                            <?/*<img src="<?=CFile::ResizeImageGet($picId, array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src']?>">
                            <span class="ext_ico ei_<?=$_ext?>">.<?=$_ext?></span>*/?>
                            <span><?=$arResult['OBJECT_SPECIFICATION']['DESCRIPTION'][$i]?></span>
                          </a>
                        <?}?>
                        </td>


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
                <h2>Добавление проекта</h2>
            </div>

            <form id="form_object_add" method="post" enctype="multipart/form-data">

                <fieldset class="mt-4 mb-2">
                    <legend>Статус объекта: <span class="req">*</span></legend>

                    <div class="mb-2">
                        <input type="radio" id="UF_MKD" name="PROJECT[OBJECT_STATUS]" value="МКД" checked />
                        <label for="UF_MKD">МКД</label>
                    </div>

                    <div class="mb-2">
                        <input type="radio" id="UF_IZHS" name="PROJECT[OBJECT_STATUS]" value="ИЖС" />
                        <label for="UF_IZHS">ИЖС</label>
                    </div>
                </fieldset>

                <div class="wrap-input100 certificate_div form-outline mb-2">
                    <span class="label-input">Проектная организация</span>
                    <input class="form-control form-control-lg" type="text" id="PROJECT_COMPANY" name="PROJECT[PROJECT_COMPANY]">
                </div>

                <div class="wrap-input100 form-outline mb-2">
                    <span class="label-input">Название объекта <span class="req">*</span></span>
                    <input class="form-control form-control-lg" type="text" id="OBJECT_NAME" name="PROJECT[NAME]" required>
                </div>

                <div class="wrap-input100 form-outline mb-2">
                    <span class="label-input">Адрес объекта</span>
                    <input class="form-control form-control-lg" type="text" id="OBJECT_ADDRESS" name="PROJECT[OBJECT_ADDRESS]">
                </div>

                <div class="wrap-input100 form-outline mb-2">
                    <span class="label-input">Кадастровый номер</span>
                    <input class="form-control form-control-lg" type="text" id="OBJECT_NUMB" name="PROJECT[OBJECT_NUMB]">
                </div>

                <div class="wrap-input100 form-outline mb-2">
                    <span class="label-input">Заказчик</span>
                    <input class="form-control form-control-lg" type="text" id="OBJECT_CUSTOMER" name="PROJECT[OBJECT_CUSTOMER]">
                </div>

                <div class="wrap-input100 form-outline mb-2">
                    <span class="label-input">Авторский надзор <span class="req">*</span></span>
                    <label>Да
                      <input class="" type="radio" id="OBJECT_SUPERVISION" name="PROJECT[OBJECT_SUPERVISION]" value="Y" required>
                    </label>
                    <label>Нет
                      <input class="" type="radio" id="OBJECT_SUPERVISION2" name="PROJECT[OBJECT_SUPERVISION]" value="N" required>
                    </label>
                </div>

                <div class="wrap-input100 form-outline mb-2">
                    <span class="label-input">Подписать агентский договор</span>
                    <label>Да
                      <input class="" type="radio" id="DOC_SIGN" name="PROJECT[DOC_SIGN]" value="Y" >
                    </label>
                    <label>Нет
                      <input class="" type="radio" id="DOC_SIGN2" name="PROJECT[DOC_SIGN]" value="N" >
                    </label>
                </div>

                <div class="file-block wrap-input100 mb-2">
                    <label for="order_file">Спецификация</label>
                    <input type="file" id="OBJECT_SPECIFICATION" name="object_spec[]" multiple>
                </div>

                <div class="wrap-input100 form-outline mb-2">
                    <span class="label-input">Срок выдачи проектной документации</span>
                    <input type="date" id="DOC_DEADLINE" name="PROJECT[DOC_DEADLINE]" required
                           max="<?= date("Y-m-d") ?>"
                           value="<?= date("Y-m-d") ?>">
                </div>



                <div class="wrap-input100 mt-4">
                    <input type="submit" name="go" value="Добавить объект" class="questionnaire_btn btn btn-primary">
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
        pageLength: 25,
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
        columnDefs: [
            {
                targets: '_all',
                className: 'dt-left'
            }
        ],
    });
</script>

<script>

  $("#form_object_add").submit(function (e) {
			 //alert('ok***');

            e.preventDefault();

            var formData = new FormData(this);

            // formData.append('inn', $('#COMPANY_INN').val());
            // formData.append('name', $('#COMPANY_NAME').val());
            // formData.append('fio', $('#COMPANY_FIO').val());
            // formData.append('phone', $('#COMPANY_PHONE').val());
            // formData.append('email', $('#COMPANY_EMAIL').val());
            // formData.append('doc_date', $('#COMPANY_DOC_DATE').val());
            // formData.append('sphere', $('#COMPANY_SPHERE').val());

            $.ajax({
                type: "POST",
                url: '<?=SITE_TEMPLATE_PATH ?>/ajax/object_add.php',
                contentType: false,
                processData: false,
                data: formData,
            }).done(function (data) {
                console.log(data);
                $('.popup.popup-sent').addClass('popup_open');
                //location.reload();
                //window.location = '/suppliers/';
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