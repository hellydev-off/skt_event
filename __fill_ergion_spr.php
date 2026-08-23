<?php
// Подключаем пролог Bitrix
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL;

// Проверяем подключение модулей
if (!Loader::includeModule('highloadblock')) {
    die('Модуль highloadblock не подключён');
}
if (!Loader::includeModule('iblock')) {
    die('Модуль iblock не подключён');
}

// Константы
//define('IBLOCK_ID', 3);
//define('IBLOCK_ID', 6);
define('IBLOCK_ID', 4);
define('HLBLOCK_NAME', 'RegionsRussia');

/**
 * Функция для получения ID highload‑блока по имени
 */
function getHLBlockIdByName(string $hlBlockName): ?int
{
    $hlblockList = HL\HighloadBlockTable::getList([
        'select' => ['ID'],
        'filter' => ['=NAME' => $hlBlockName]
    ]);

    if ($hlBlock = $hlblockList->fetch()) {
        return (int)$hlBlock['ID'];
    }

    return null;
}

/**
 * Функция для создания массива регионов из highload‑блока
 */
function buildRegionMap(int $hlBlockId): array
{
    // Получаем сущность highload‑блока
    $entity = HL\HighloadBlockTable::compileEntity($hlBlockId);
    $entityClass = $entity->getDataClass();

    // Запрашиваем все регионы из highload‑блока
    $regions = $entityClass::getList([
        'select' => ['UF_NAME', 'UF_XML_ID'],
        'order' => ['UF_SORT' => 'ASC']
    ]);

    $regionMap = [];
    while ($region = $regions->fetch()) {
        $regionMap[] = [
            'name' => mb_strtolower($region['UF_NAME']),
            'xml_id' => $region['UF_XML_ID']
        ];
    }

    return $regionMap;
}

/**
 * Функция для поиска частичного совпадения названий
 * Возвращает UF_XML_ID при первом совпадении или null
 */
function findRegionByPartialMatch(string $searchName, array $regionMap): ?string
{
    $searchNameLower = mb_strtolower(trim($searchName));

    foreach ($regionMap as $region) {
        // Проверяем, содержится ли искомое название в названии региона ИЛИ
        // содержится ли название региона в искомом названии
        if (strpos($region['name'], $searchNameLower) !== false ||
            strpos($searchNameLower, $region['name']) !== false) {
            return $region['xml_id'];
        }
    }

    return null;
}

/**
 * Основная функция: обновляет элементы инфоблока, заполняя поле UF_REGION_SPR
 */
function updateIBlockElementsWithRegionData(): void
{
    echo "Начало обработки элементов инфоблока ID " . IBLOCK_ID . "\n";

    // Получаем ID highload‑блока
    $hlBlockId = getHLBlockIdByName(HLBLOCK_NAME);
    if (!$hlBlockId) {
        die('Highload‑блок с именем "' . HLBLOCK_NAME . '" не найден');
    }
    echo "Найден highload‑блок ID: $hlBlockId\n";

    // Строим карту регионов
    $regionMap = buildRegionMap($hlBlockId);
    echo "Загружено " . count($regionMap) . " регионов из highload‑блока\n";

    // Получаем элементы инфоблока
    $iblockElements = CIBlockElement::GetList(
        [],
        ['IBLOCK_ID' => IBLOCK_ID],
        false,
        false,
        ['ID', 'NAME', 'PROPERTY_REGION']
    );

    $processedCount = 0;
    $updatedCount = 0;
    $notFoundCount = 0;

    while ($element = $iblockElements->GetNext()) {
        $elementId = $element['ID'];
        $regionName = trim($element['PROPERTY_REGION_VALUE']);
        $regionName = str_replace('-', ' ', $regionName);
        // Пропускаем, если поле REGION пустое
        if (empty($regionName)) {
            continue;
        }

        $processedCount++;

        // Ищем частичное соответствие в карте регионов
        $xmlId = findRegionByPartialMatch($regionName, $regionMap);

        if ($xmlId !== null) {
            // Обновляем элемент инфоблока: заполняем UF_REGION_SPR значением UF_XML_ID
            $updateResult = CIBlockElement::SetPropertyValuesEx(
                $elementId,
                IBLOCK_ID,
                ['REGION_SPR' => $xmlId]
            );

            if ($updateResult === true) {
                $updatedCount++;
                echo "Элемент ID $elementId: '$regionName' → REGION_SPR = '$xmlId'\n";
            } else {
                echo "Ошибка обновления элемента ID $elementId\n";
            }
        } else {
            $notFoundCount++;
            echo "Элемент ID $elementId: регион '$regionName' не найден в highload‑блоке (частичное совпадение)\n";
        }
    }

    echo "Обработка завершена.\n";
    echo "Обработано элементов: $processedCount\n";
    echo "Успешно обновлено: $updatedCount\n";
    echo "Не найдено совпадений: $notFoundCount\n";
}

// Запускаем основную функцию
updateIBlockElementsWithRegionData();
?>