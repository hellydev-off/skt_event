<?php
// Подключаем пролог Bitrix
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL;

// Проверяем подключение модулей
if (!Loader::includeModule('highloadblock')) {
    die('Модуль highloadblock не подключён');
}
if (!Loader::includeModule('main')) {
    die('Модуль main не подключён');
}

// Константы
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
        'select' => ['UF_NAME', 'UF_XML_ID', 'ID'],
        'order' => ['UF_SORT' => 'ASC']
    ]);

    $regionMap = [];
    while ($region = $regions->fetch()) {
        $regionMap[] = [
            'name' => mb_strtolower($region['UF_NAME']),
            'xml_id' => $region['UF_XML_ID'],
            'id' => $region['ID']
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
             // v($region);die();
            return $region['id'];
        }
    }

    return null;
}

/**
 * Основная функция: обновляет пользователей, заполняя поле UF_REGION_SPR
 */
function updateUsersWithRegionData(): void
{
    echo "Начало обработки пользователей\n";

    // Получаем ID highload‑блока
    $hlBlockId = getHLBlockIdByName(HLBLOCK_NAME);
    if (!$hlBlockId) {
        die('Highload‑блок с именем "' . HLBLOCK_NAME . '" не найден');
    }
    echo "Найден highload‑блок ID: $hlBlockId\n";

    // Строим карту регионов
    $regionMap = buildRegionMap($hlBlockId);
    echo "Загружено " . count($regionMap) . " регионов из highload‑блока\n";

    // Получаем пользователей с заполненным полем UF_REGION
    $userList = CUser::GetList(
        $by = 'id',
        $order = 'asc',
        ['!UF_REGION' => false],
        ['SELECT' => ['ID', 'UF_REGION']]
    );

    $processedCount = 0;
    $updatedCount = 0;
    $notFoundCount = 0;

    // Создаём экземпляр класса CUser для работы с обновлением
    $userObject = new CUser();

    while ($user = $userList->Fetch()) {
        $userId = $user['ID'];
        $regionName = trim($user['UF_REGION']);
$regionName = str_replace('-', ' ', $regionName);


        // Пропускаем, если поле UF_REGION пустое
        if (empty($regionName)) {
            continue;
        }

        $processedCount++;

        // Ищем частичное соответствие в карте регионов
        $xmlId = findRegionByPartialMatch($regionName, $regionMap);

        if ($xmlId !== null) {
            // Обновляем пользователя: заполняем UF_REGION_SPR значением UF_XML_ID
            $fields = [
                'UF_REGION_SPR' => $xmlId
            ];
            $updateResult = $userObject->Update($userId, $fields);
            //var_dump($updateResult, $userId, $fields);die();

            if ($updateResult) {
                $updatedCount++;
                echo "Пользователь ID $userId: '$regionName' → UF_REGION_SPR = '$xmlId'\n";
            } else {
                echo "Ошибка обновления пользователя ID $userId <br>";
            }
        } else {
            $notFoundCount++;
            echo "Пользователь ID $userId: регион '$regionName' не найден в highload‑блоке (частичное совпадение)\n";
        }
    }

    echo "Обработка завершена.\n";
    echo "Обработано пользователей: $processedCount\n";
    echo "Успешно обновлено: $updatedCount\n";
    echo "Не найдено совпадений: $notFoundCount\n";
}

// Запускаем основную функцию
updateUsersWithRegionData();
?>