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

//print_r($arResult['PROPERTIES']);

//echo "s2=".$arResult['PROPERTIES']['STATUS2']['VALUE'];

// Собираем данные пользователя
$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();

$doc_user = 1;
if ( $arUser['UF_INN'] == $arResult['PROPERTIES']['INN']['VALUE']) {$doc_user = 2;} 
//echo "Сторона ".$doc_user ;
?>

<?
$APPLICATION->AddChainItem('Объекты', '/suppliers/');
$APPLICATION->AddChainItem($arResult['DISPLAY_PROPERTIES']['OBJECT']['LINK_ELEMENT_VALUE'][$arResult['PROPERTIES']['OBJECT']['VALUE']]['NAME'], '/suppliers/' . $arResult['DISPLAY_PROPERTIES']['OBJECT']['LINK_ELEMENT_VALUE'][$arResult['PROPERTIES']['OBJECT']['VALUE']]['DETAIL_PAGE_URL']);
?>


    <div class="doc-detail">
        <div class="block_detail_info">
            <div class="block_detail_info-chars docs">

                <div class="block_detail_info-chars-item">
                    <span class="info-title">Поставщик</span>
                    <span class="info-value"><?= $arResult['DISPLAY_PROPERTIES']['OBJECT']['LINK_ELEMENT_VALUE'][$arResult['PROPERTIES']['OBJECT']['VALUE']]['NAME'] ?></span>
                </div>

                <?php if(!empty( $arResult['PROPERTIES']['EXP_DATE']['VALUE'] )){ ?>
                <div class="block_detail_info-chars-item">
                    <span class="info-title">Дата окончания</span>
                    <span class="info-value"><?= $arResult['PROPERTIES']['EXP_DATE']['VALUE'] ?></span>
                </div>
                <?php } ?>

                <div class="block_detail_info-document">
                    <a href="<?= $arResult['DISPLAY_PROPERTIES']['FILE']['FILE_VALUE']['SRC'] ?>" title="">
                        <div class="avatar">
                            <svg width="23" height="30" viewBox="0 0 32 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>google-docs</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-143.000000, -703.000000)" fill-rule="nonzero">
                                        <g transform="translate(29.000000, 595.000000)">
                                            <g transform="translate(0.922481, 42.000000)">
                                                <g transform="translate(113.077519, 66.000000)">
                                                    <path d="M29,41.7882353 L3,41.7882353 C1.343,41.7882353 0,40.4520067 0,38.8033613 L0,2.98487395 C0,1.33622857 1.343,0 3,0 L22,0 L32,9.94957983 L32,38.8033613 C32,40.4520067 30.657,41.7882353 29,41.7882353 Z"
                                                          fill="#2196F3"></path>
                                                    <polygon fill="#BBDEFB" points="32 9.78823529 22.2117647 9.78823529 22.2117647 0"></polygon>
                                                    <polygon fill="#1565C0" points="22.2117647 10.1647059 32 19.9529412 32 10.1647059"></polygon>
                                                    <path d="M6.77647059,19.9529412 L24.8470588,19.9529412 L24.8470588,21.9428571 L6.77647059,21.9428571 L6.77647059,19.9529412 Z M6.77647059,23.9327731 L24.8470588,23.9327731 L24.8470588,25.9226891 L6.77647059,25.9226891 L6.77647059,23.9327731 Z M6.77647059,27.912605 L24.8470588,27.912605 L24.8470588,29.902521 L6.77647059,29.902521 L6.77647059,27.912605 Z M6.77647059,31.892437 L16.8156863,31.892437 L16.8156863,33.8823529 L6.77647059,33.8823529 L6.77647059,31.892437 Z"
                                                          fill="#E3F2FD"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <div class="document-title">
                            <h4>Скачать документ</h4>
                            <h5><?= $arResult['DISPLAY_PROPERTIES']['FILE']['FILE_VALUE']['FILE_SIZE'] / 1000 ?> kb</h5>
                        </div>
                    </a>
                </div>

                <div class="block_detail_info-status">
                    <span class="badge text-bg-<?= ($arResult['PROPERTIES']["STATUS"]["VALUE_ENUM"] =="Согласован")?'success':'warning' ?>"><?=$arResult['PROPERTIES']['STATUS']['VALUE']?></span>

                    <!--img src="<?= SITE_TEMPLATE_PATH ?>/svg/stamp.svg" alt="Не подписано"-->
					<img src="<?= SITE_TEMPLATE_PATH ?><?=($arResult['PROPERTIES']['STATUS']['VALUE'] == 'Согласован')? '/svg/stamp_app.svg': '/svg/stamp.svg' ?>" alt="Подписано">
					<img src="<?= SITE_TEMPLATE_PATH ?><?=($arResult['PROPERTIES']['STATUS2']['VALUE'] == 'Согласован')? '/svg/stamp_app.svg': '/svg/stamp.svg' ?>" alt="Подписано">
                </div>

            </div>
        </div>

        <div class="wrapper">
            <div class="sidebar-left">

<? if ( $doc_user == 1 && $arResult['PROPERTIES']["STATUS"]["VALUE_ENUM"] !="Согласован" ):?>
                <div id="signature-pad" class="signature-pad">
                    <div class="signature-pad--body">
                        <canvas></canvas>
                    </div>
                    <div class="signature-pad--footer">
                        <div class="signature-pad--actions">
                            <div class="clear-btn d-grid gap-2 mt-2">
                                <button type="button" class="button btn btn-outline-secondary clear" data-action="clear">Очистить</button>
                            </div>
                        </div>
                    </div>
                </div>

               <!-- <div class="sig-wrapper">
                    <canvas id="signature-pad" class="signature-pad" width="100%" height="200px"></canvas>
                </div>-->

            <!--    <div class="clear-btn d-grid gap-2 mt-2">
                    <button class="btn btn-outline-secondary" id="clear">Очистить</button>
                </div>-->


			<div class="gap-2 mt-4 mb-4">
                    <label for="formFile" class="form-label">Загрузить файл печати</label>
                    <input class="form-control" name="files" type="file" id="formFile">
			</div>

                <div class="agree-btn d-grid gap-2 mt-2 mb-4">
                    <a href="javascript:void(0);" title="" class="btn btn-success btn-lg" id="saveConvas" data-id="<?= $arResult['ID'] ?>">Согласовать</a>
                </div>
<? endif; ?>

<? if ( $doc_user == 2 && $arResult['PROPERTIES']["STATUS2"]["VALUE_ENUM"] !="Согласован" ):?>
                <div id="signature-pad" class="signature-pad">
                    <div class="signature-pad--body">
                        <canvas></canvas>
                    </div>
                    <div class="signature-pad--footer">
                        <div class="signature-pad--actions">
                            <div class="clear-btn d-grid gap-2 mt-2">
                                <button type="button" class="button btn btn-outline-secondary clear" data-action="clear">Очистить</button>
                            </div>
                        </div>
                    </div>
                </div>

               <!-- <div class="sig-wrapper">
                    <canvas id="signature-pad" class="signature-pad" width="100%" height="200px"></canvas>
                </div>-->

            <!--    <div class="clear-btn d-grid gap-2 mt-2">
                    <button class="btn btn-outline-secondary" id="clear">Очистить</button>
                </div>-->

			<div class="gap-2 mt-4 mb-4">
                    <label for="formFile" class="form-label">Загрузить файл печати</label>
                    <input class="form-control" name="files" type="file" id="formFile">
			</div>

                <div class="agree-btn d-grid gap-2 mt-2 mb-4">
                    <a href="javascript:void(0);" title="" class="btn btn-success btn-lg" id="saveConvas2" data-id="<?= $arResult['ID'] ?>">Согласовать</a>
                </div>
<? endif; ?>

                <div class="action-btn d-grid gap-2">
                    <a href="javascript:jivo_api.open()" title="" class="btn btn-outline-secondary btn-lg"><i class='bx bx-comment-dots'></i> Открыть чат</a>
<!--                    <a href="javascript:void(0);" id="document_add" title="" class="btn btn-outline-secondary btn-lg"><i class='bx bx-upload'></i> Загрузить новый документ</a>-->
                    <a href="javascript:void(0);" id="document_delete" title="" class="btn btn-outline-secondary btn-lg" data-id="<?= $arResult['ID'] ?>">Удалить</a>
                </div>

            </div>

            <div class="content">
                <div class="document-block">
                    <object data="<?= $arResult['DISPLAY_PROPERTIES']['FILE']['FILE_VALUE']['SRC'] ?>" width="100%" height="600px">
                        <p>Похоже ваш браузер не поддерживает просмотр встроенного файла pdf. Ничего страшного, вы можете <a href="<?= $arResult['DISPLAY_PROPERTIES']['FILE']['FILE_VALUE']['SRC'] ?>">открыть его по ссылке</a></p>
                    </object>



                    <? /*
                    <!--                    <iframe src="https://docs.google.com/viewer?url=--><?php //= $arResult['DISPLAY_PROPERTIES']['FILE']['FILE_VALUE']['SRC'] ?><!--&embedded=true" style="width:100%; height:600px;" frameborder="0"></iframe>-->
                        <!--                    <embed src="--><?php //= $arResult['DISPLAY_PROPERTIES']['FILE']['FILE_VALUE']['SRC'] ?><!--#toolbar=0" width="100%" height="600" type="application/pdf">-->
                    <!--                <iframe src='https://view.officeapps.live.com/op/embed.aspx?src=-->
                    <?php //= $arResult['DISPLAY_PROPERTIES']['FILE']['FILE_VALUE']['SRC'] ?><!--' width='100%' height='650px' frameborder='0'></iframe>-->
                    <!--                <iframe src="https://docs.google.com/gview?url=--><?php //= $arResult['DISPLAY_PROPERTIES']['FILE']['FILE_VALUE']['SRC'] ?><!--&embedded=true"></iframe>-->

                    <!--                <iframe width="100%" height="600px" src="https://docs.google.com/gview?url=-->
                    <?php //= $arResult['DISPLAY_PROPERTIES']['FILE']['FILE_VALUE']['SRC'] ?><!--%26embedded=true"></iframe>-->
						*/?>
                </div>
            </div>

        </div>
    </div>

    <div class="popup popup-document-add">
        <div class="popup__bgd"></div>
        <div class="popup__content">
            <div class="popup__close">
                <i class='bx bx-x'></i>
            </div>

            <div>
                <div class="popup__title">
                    <h2>Загрузка документа</h2>
                </div>

                <form id="form_document_replace" method="post" enctype="multipart/form-data">

                    <div class="wrap-input100 form-outline mb-2">
                        <span class="label-input">Название документа <span class="req">*</span></span>
                        <input class="form-control form-control-lg" type="text" id="DOCUMENT_NAME" name="NAME" required>
                    </div>

                    <div class="wrap-input100 form-outline mb-2">
                        <span class="label-input">Дата окончания</span>
                        <input class="form-control form-control-lg" type="date" id="DOCUMENT_EXP_DATE" name="EXP_DATE">
                    </div>

                    <div class="wrap-input100 form-outline mt-4 mb-2">
                        <span class="label-input">Документ</span>
                        <textarea id="summernote" name="editordata"></textarea>
                    </div>

                    <div class="wrap-input100 form-outline mb-2">
                        <label for="formFile" class="form-label">Загрузить файл печати</label>
                        <input class="form-control" name="files" type="file" id="formFile">
                    </div>

                    <input type="hidden" id="DOCUMENT_INN" name="INN" value="<?= $arResult['PROPERTIES']['INN']['VALUE'] ?>">
                    <input type="hidden" id="DOCUMENT_OBJECT" name="OBJECT" value="<?= $arResult['ID'] ?>">

                    <div class="wrap-input100 mt-4">
                        <input type="submit" name="go" value="Добавить документ" class="questionnaire_btn btn btn-primary">
                    </div>

                </form>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
	<script src="<?= SITE_TEMPLATE_PATH ?>/js/app.js"></script>


    <script src="//code.jivo.ru/widget/nVoILSXtYh" async></script>

		<?/* script>
        const signaturePad = new SignaturePad(canvas, {
            minWidth: 5,
            maxWidth: 10,
            penColor: "rgb(66, 133, 244)"
        });
		</script */?>

	<script>
	$(document).on('click', '#saveConvas', function () {
    console.log("save");
	var dataURL = signaturePad.toDataURL();
    let elemID = $(this).attr("data-id");
	var formData = new FormData();
    formData.append('imgBase64', dataURL);
    formData.append('elemID', elemID);
        $.each($("#formFile")[0].files, function (key, input) {
			formData.append('file[]', input);
        });

            $.ajax({
                type: "POST",
				contentType: false,
				processData: false,
                url: "<?= SITE_TEMPLATE_PATH ?>/ajax/saveCanvasToPng_Pdf.php",
				data: formData,
				//data: {imgBase64: dataURL, elemID: elemID}
	 	}).done(function(d) {
	 	console.log(d,'saved');
		location.reload(true);

	 	});

	});
	</script>

	<script>
	$(document).on('click', '#saveConvas2', function () {
    console.log("save2");
    let elemID = $(this).attr("data-id");
	var dataURL = signaturePad.toDataURL();
	var formData = new FormData();
    formData.append('imgBase64', dataURL);
    formData.append('elemID', elemID);
        $.each($("#formFile")[0].files, function (key, input) {
			formData.append('file[]', input);
        });

            $.ajax({
                type: "POST",
				contentType: false,
				processData: false,
                url: "<?= SITE_TEMPLATE_PATH ?>/ajax/saveCanvasToPng_Pdf2.php",
				data: formData,
				//data: {imgBase64: dataURL, elemID: elemID}
	 	}).done(function(d) {
	 	console.log(d,'saved2');
		location.reload(true);

	 	});

	});
	</script>

    <script>
        try {
            encode_url=URLEncoder.encode(url,"UTF-8"); //Url Convert to UTF-8 It important.
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
        }

        webView.loadUrl("https://docs.google.com/viewerng/viewer?embedded=true&url="+encode_url);
    </script>

    <script>
        $("#document_delete").click(function () {
            let elemID = $(this).attr("data-id");
            let confirmDel = confirm("Удалить документ?");
            if (confirmDel) {
                $.ajax({
                    type: 'POST',
                    url: '<?=SITE_TEMPLATE_PATH ?>/ajax/delete_elem.php',
                    data: {elemID: elemID},
                    success: function (data) {
                        console.log(data);
                        document.location = "<?='/suppliers/' . $arResult['DISPLAY_PROPERTIES']['OBJECT']['LINK_ELEMENT_VALUE'][$arResult['PROPERTIES']['OBJECT']['VALUE']]['DETAIL_PAGE_URL']?>";
                    },
                    error: function (xhr, str) {
                        alert('ошибка : ' + xhr.responseCode);
                    }
                });
            }
        });
		</script>


    <script>
        $('#document_add').click(function () {
			//e.preventDefault();
            $(".popup-document-add").addClass("popup_open");
        });


        $('.popup.popup-document-add .popup__bgd, .popup.popup-document-add .popup__close').on('click', function () {
            $('.popup.popup-document-add').removeClass('popup_open');
        });
    </script>

		<?php // echo '<pre>'; print_r($arResult); echo '</pre>'; ?>