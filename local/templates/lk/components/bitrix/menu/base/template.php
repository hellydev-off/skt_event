<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if (!empty($arResult)): ?>
    <?php
    foreach ($arResult as $arItem):
        if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) continue;
        ?>

        <a href="<?= $arItem["LINK"] ?>"
           class="nav_link <?php if ($arItem["SELECTED"]): ?>active<?php endif; ?> <?php if (isset($arItem["PARAMS"]["dif_class"])) echo $arItem["PARAMS"]["dif_class"]; ?>">
            <?php if (isset($arItem["PARAMS"]["icon"])): ?>
                <i class="bx <?= $arItem["PARAMS"]["icon"] ?> nav_icon"></i>
            <?php endif; ?>
            <span><?= $arItem["TEXT"] ?></span>
            <?php if (isset($arItem["PARAMS"]["mob_name"])): ?>
                <span class="span-mob"><?= $arItem["PARAMS"]["mob_name"] ?></span>
            <?php endif; ?>
        </a>

    <?php endforeach ?>
<?php endif ?>