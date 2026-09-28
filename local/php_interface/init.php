<?php
use Bitrix\Main\EventManager;

require_once 'Aiplk.php';
require_once 'dadata.php';


// Проверка при регистрации и добавлении пользователя
EventManager::getInstance()->addEventHandler(
    "main",
    "OnBeforeUserRegister",
    "CheckUniqueEmail"
);
EventManager::getInstance()->addEventHandler(
    "main",
    "OnBeforeUserAdd",
    "CheckUniqueEmail"
);

// Проверка при обновлении профиля
EventManager::getInstance()->addEventHandler(
    "main",
    "OnBeforeUserUpdate",
    "CheckUniqueEmail"
);

function CheckUniqueEmail(&$arFields)
{
    // Если email не заполнен, Битрикс сам выдаст стандартную ошибку (если поле обязательное)
    if (empty($arFields["EMAIL"])) {
        return true;
    }

    // Формируем фильтр для поиска пользователей с таким же email
    $filter = array("=EMAIL" => $arFields["EMAIL"]);

    // Если это обновление профиля, исключаем текущего пользователя из поиска
    if (isset($arFields["ID"]) && intval($arFields["ID"]) > 0) {
        $filter["!=ID"] = $arFields["ID"];
    }

    // Ищем пользователей
    $resUsers = \Bitrix\Main\UserTable::getList(array(
        'select' => array('ID'),
        'filter' => $filter,
        'limit' => 1
    ));

    if ($resUsers->fetch()) {
        global $APPLICATION;
        $APPLICATION->ThrowException("Пользователь с таким Email уже зарегистрирован. <b>ДЛЯ ДАЛЬНЕЙШЕЙ РАБОТЫ, НЕОБХОДИМО УКАЗАТЬ ДРУГОЙ ПОЧТОВЫЙ АДРЕС, РАНЕЕ НЕИСПОЛЬЗУЕМЫЙ НА САЙТЕ</b>");
        return false; // Отменяем регистрацию/сохранение
    }

    return true;
}
?>