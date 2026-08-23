<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
<div class="doc-detail">
    <div class="block_detail_info">
        <div class="block_detail_info-chars docs">

            <div class="block_detail_info-chars-item">
                <span class="info-title">Поставщик</span>
                <span class="info-value">ООО «Вкусно и Точка»</span>
            </div>

            <div class="block_detail_info-chars-item">
                <span class="info-title">Дата окончания</span>
                <span class="info-value">31.12.2024</span>
            </div>

            <div class="block_detail_info-document">
                <a href="<?= SITE_TEMPLATE_PATH ?>/docs/dec.pdf" title="">
                    <div class="avatar">
                        <svg width="23" height="30" viewBox="0 0 32 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>google-docs</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-143.000000, -703.000000)" fill-rule="nonzero">
                                    <g transform="translate(29.000000, 595.000000)">
                                        <g transform="translate(0.922481, 42.000000)">
                                            <g transform="translate(113.077519, 66.000000)">
                                                <path d="M29,41.7882353 L3,41.7882353 C1.343,41.7882353 0,40.4520067 0,38.8033613 L0,2.98487395 C0,1.33622857 1.343,0 3,0 L22,0 L32,9.94957983 L32,38.8033613 C32,40.4520067 30.657,41.7882353 29,41.7882353 Z" fill="#2196F3"></path>
                                                <polygon fill="#BBDEFB" points="32 9.78823529 22.2117647 9.78823529 22.2117647 0"></polygon>
                                                <polygon fill="#1565C0" points="22.2117647 10.1647059 32 19.9529412 32 10.1647059"></polygon>
                                                <path d="M6.77647059,19.9529412 L24.8470588,19.9529412 L24.8470588,21.9428571 L6.77647059,21.9428571 L6.77647059,19.9529412 Z M6.77647059,23.9327731 L24.8470588,23.9327731 L24.8470588,25.9226891 L6.77647059,25.9226891 L6.77647059,23.9327731 Z M6.77647059,27.912605 L24.8470588,27.912605 L24.8470588,29.902521 L6.77647059,29.902521 L6.77647059,27.912605 Z M6.77647059,31.892437 L16.8156863,31.892437 L16.8156863,33.8823529 L6.77647059,33.8823529 L6.77647059,31.892437 Z" fill="#E3F2FD"></path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <div class="document-title">
                        <h4>Скачать документ</h4>
                        <h5>17 kb</h5>
                    </div>
                </a>
            </div>

            <div class="block_detail_info-status">
                <span class="badge text-bg-warning">Не согласован</span>
                <img src="<?= SITE_TEMPLATE_PATH ?>/svg/stamp.svg" alt="Не подписано">
                <img src="<?= SITE_TEMPLATE_PATH ?>/svg/stamp_app.svg" alt="Подписано">
            </div>

        </div>
    </div>

    <div class="wrapper">
        <div class="sidebar-left">

            <div class="sig-wrapper">
                <canvas id="signature-pad" class="signature-pad" width="100%" height="200px"></canvas>
            </div>

            <div class="clear-btn d-grid gap-2 mt-2">
                <button class="btn btn-outline-secondary btn-lg" id="clear">Очистить</button>
            </div>

            <div class="agree-btn d-grid gap-2 mt-4">
                <a href="#" title="" class="btn btn-success btn-lg"><i class='bx bx-check-double'></i> Согласовать</a>
                <a href="#" title="" class="btn btn-info btn-lg"><i class='bx bx-comment-dots'></i> Открыть чат</a>
            </div>

            <div class="action-btn d-flex justify-content-between mt-4">
                <a href="#" title="" class="btn btn-outline-dark"><i class='bx bx-upload'></i> Загрузить документ</a>
                <a href="#" title="" class="btn btn-outline-danger">Удалить</a>
            </div>

        </div>

        <div class="content">
            <div class="document-block">
                <embed src="<?= SITE_TEMPLATE_PATH ?>/docs/dec.pdf#toolbar=0" width="100%" height="600" type="application/pdf">
            </div>
        </div>
    </div>
</div>