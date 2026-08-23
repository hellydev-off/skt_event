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

/**
 * Функция для добавления полей в highload‑блок, если их ещё нет
 */
function createHLBlockFieldsIfNotExists(int $hlblockId): bool
{
    $entityId = 'HLBLOCK_' . $hlblockId;
    $obUserTypeEntity = new CUserTypeEntity();

    // Список необходимых полей
    $requiredFields = [
        [
            'FIELD_NAME' => 'UF_XML_ID',
            'USER_TYPE_ID' => 'string',
            'EDIT_FORM_LABEL' => ['ru' => 'ISO‑код региона'],
            'LIST_COLUMN_LABEL' => ['ru' => 'ISO‑код'],
            'LIST_FILTER_LABEL' => ['ru' => 'ISO‑код'],
        ],
        [
            'FIELD_NAME' => 'UF_NAME',
            'USER_TYPE_ID' => 'string',
            'EDIT_FORM_LABEL' => ['ru' => 'Название региона'],
            'LIST_COLUMN_LABEL' => ['ru' => 'Название'],
            'LIST_FILTER_LABEL' => ['ru' => 'Название'],
        ],
        [
            'FIELD_NAME' => 'UF_SORT',
            'USER_TYPE_ID' => 'integer',
            'EDIT_FORM_LABEL' => ['ru' => 'Сортировка (кратная 10)'],
            'LIST_COLUMN_LABEL' => ['ru' => 'Сортировка'],
            'LIST_FILTER_LABEL' => ['ru' => 'Сортировка'],
        ],
    ];

    $success = true;

    foreach ($requiredFields as $field) {
        // Проверяем, существует ли поле
        $dbRes = $obUserTypeEntity->GetList([], [
            'ENTITY_ID' => $entityId,
            'FIELD_NAME' => $field['FIELD_NAME'],
        ]);

        if ($dbRes->Fetch()) {
            echo "Поле {$field['FIELD_NAME']} уже существует\n";
            continue;
        }

        // Создаём новое поле
        $userField = [
            'ENTITY_ID' => $entityId,
            'FIELD_NAME' => $field['FIELD_NAME'],
            'USER_TYPE_ID' => $field['USER_TYPE_ID'],
            'XML_ID' => '',
            'SORT' => 500,
            'MULTIPLE' => 'N',
            'MANDATORY' => 'N',
            'SHOW_FILTER' => 'I',
            'SHOW_IN_LIST' => 'Y',
            'EDIT_IN_LIST' => 'Y',
            'IS_SEARCHABLE' => 'N',
            'SETTINGS' => [
                'DEFAULT_VALUE' => '',
            ],
        ];

        // Добавляем языковой заголовок
        $langFields = [
            'EN' => [
                'EDIT_FORM_LABEL' => $field['EDIT_FORM_LABEL']['ru'],
                'LIST_COLUMN_LABEL' => $field['LIST_COLUMN_LABEL']['ru'],
                'LIST_FILTER_LABEL' => $field['LIST_FILTER_LABEL']['ru'],
            ],
            'RU' => [
                'EDIT_FORM_LABEL' => $field['EDIT_FORM_LABEL']['ru'],
                'LIST_COLUMN_LABEL' => $field['LIST_COLUMN_LABEL']['ru'],
                'LIST_FILTER_LABEL' => $field['LIST_FILTER_LABEL']['ru'],
            ],
        ];

        $fieldId = $obUserTypeEntity->Add($userField);
        if (!$fieldId) {
            echo "Ошибка при создании поля {$field['FIELD_NAME']}\n";
            $success = false;
        } else {
            // Сохраняем языковые настройки
            foreach ($langFields as $lang => $labels) {
                $obUserTypeEntity->Update($fieldId, [
                    'LANG' => $lang,
            ] + $labels);
            }
            echo "Поле {$field['FIELD_NAME']} успешно создано\n";
        }
    }

    return $success;
}

/**
 * Функция для добавления двух регионов в существующий highload‑блок
 */
function addRegionsToExistingHLBlock(int $hlblockId): void
{
    // Получаем информацию о существующем highload‑блоке по ID
    $hlblock = HL\HighloadBlockTable::getById($hlblockId)->fetch();
    if (!$hlblock) {
        die('Highload‑блок с ID ' . $hlblockId . ' не найден');
    }

    echo "Работа с highload‑блоком ID: $hlblockId, название: {$hlblock['NAME']}\n";

    // Создаём поля, если их ещё нет
    if (!createHLBlockFieldsIfNotExists($hlblockId)) {
        die('Не удалось создать необходимые поля в highload‑блоке');
    }

    // Компилируем сущность highload‑блока для работы с данными
    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    $entityClass = $entity->getDataClass();

    // Два первых региона с сортировкой, кратной 10
    $regionsToAdd = [
        ['UF_XML_ID' => 'RU-AD', 'UF_NAME' => 'Республика Адыгея', 'UF_SORT' => 1],
        ['UF_XML_ID' => 'RU-BA', 'UF_NAME' => 'Республика Башкортостан', 'UF_SORT' => 2],
        ['UF_XML_ID' => 'RU-BU', 'UF_NAME' => 'Республика Бурятия', 'UF_SORT' => 3],
        ['UF_XML_ID' => 'RU-AL', 'UF_NAME' => 'Республика Алтай', 'UF_SORT' => 4],
        ['UF_XML_ID' => 'RU-DA', 'UF_NAME' => 'Республика Дагестан', 'UF_SORT' => 5],
        ['UF_XML_ID' => 'RU-IN', 'UF_NAME' => 'Республика Ингушетия', 'UF_SORT' => 6],
        ['UF_XML_ID' => 'RU-KB', 'UF_NAME' => 'Кабардино‑Балкарская Республика', 'UF_SORT' => 7],
        ['UF_XML_ID' => 'RU-KL', 'UF_NAME' => 'Республика Калмыкия', 'UF_SORT' => 8],
        ['UF_XML_ID' => 'RU-KC', 'UF_NAME' => 'Карачаево‑Черкесская Республика', 'UF_SORT' => 9],
        ['UF_XML_ID' => 'RU-KR', 'UF_NAME' => 'Республика Карелия', 'UF_SORT' => 10],
        ['UF_XML_ID' => 'RU-KO', 'UF_NAME' => 'Республика Коми', 'UF_SORT' => 11],
        ['UF_XML_ID' => 'RU-ME', 'UF_NAME' => 'Республика Марий Эл', 'UF_SORT' => 12],
        ['UF_XML_ID' => 'RU-MO', 'UF_NAME' => 'Республика Мордовия', 'UF_SORT' => 13],
        ['UF_XML_ID' => 'RU-SA', 'UF_NAME' => 'Республика Саха (Якутия)', 'UF_SORT' => 14],
        ['UF_XML_ID' => 'RU-SE', 'UF_NAME' => 'Республика Северная Осетия — Алания', 'UF_SORT' => 15],
        ['UF_XML_ID' => 'RU-TA', 'UF_NAME' => 'Республика Татарстан', 'UF_SORT' => 16],
        ['UF_XML_ID' => 'RU-TY', 'UF_NAME' => 'Республика Тыва', 'UF_SORT' => 17],
        ['UF_XML_ID' => 'RU-UD', 'UF_NAME' => 'Удмуртская Республика', 'UF_SORT' => 18],
        ['UF_XML_ID' => 'RU-KK', 'UF_NAME' => 'Республика Хакасия', 'UF_SORT' => 19],
        ['UF_XML_ID' => 'RU-CE', 'UF_NAME' => 'Чеченская Республика', 'UF_SORT' => 20],
['UF_XML_ID' => 'RU-CU', 'UF_NAME' => 'Чувашская Республика', 'UF_SORT' => 21],
        ['UF_XML_ID' => 'RU-ALT', 'UF_NAME' => 'Алтайский край', 'UF_SORT' => 22],
        ['UF_XML_ID' => 'RU-KDA', 'UF_NAME' => 'Краснодарский край', 'UF_SORT' => 23],
        ['UF_XML_ID' => 'RU-KYA', 'UF_NAME' => 'Красноярский край', 'UF_SORT' => 24],
        ['UF_XML_ID' => 'RU-PRI', 'UF_NAME' => 'Приморский край', 'UF_SORT' => 25],
        ['UF_XML_ID' => 'RU-STA', 'UF_NAME' => 'Ставропольский край', 'UF_SORT' => 26],
        ['UF_XML_ID' => 'RU-KHA', 'UF_NAME' => 'Хабаровский край', 'UF_SORT' => 27],
        ['UF_XML_ID' => 'RU-AMU', 'UF_NAME' => 'Амурская область', 'UF_SORT' => 28],
        ['UF_XML_ID' => 'RU-ARK', 'UF_NAME' => 'Архангельская область', 'UF_SORT' => 29],
        ['UF_XML_ID' => 'RU-AST', 'UF_NAME' => 'Астраханская область', 'UF_SORT' => 30],
        ['UF_XML_ID' => 'RU-BEL', 'UF_NAME' => 'Белгородская область', 'UF_SORT' => 31],
        ['UF_XML_ID' => 'RU-BRY', 'UF_NAME' => 'Брянская область', 'UF_SORT' => 32],
        ['UF_XML_ID' => 'RU-VLA', 'UF_NAME' => 'Владимирская область', 'UF_SORT' => 33],
        ['UF_XML_ID' => 'RU-VGG', 'UF_NAME' => 'Волгоградская область', 'UF_SORT' => 34],
        ['UF_XML_ID' => 'RU-VLG', 'UF_NAME' => 'Вологодская область', 'UF_SORT' => 35],
        ['UF_XML_ID' => 'RU-VOR', 'UF_NAME' => 'Воронежская область', 'UF_SORT' => 36],
        ['UF_XML_ID' => 'RU-IVA', 'UF_NAME' => 'Ивановская область', 'UF_SORT' => 37],
        ['UF_XML_ID' => 'RU-IRK', 'UF_NAME' => 'Иркутская область', 'UF_SORT' => 38],
        ['UF_XML_ID' => 'RU-KGD', 'UF_NAME' => 'Калининградская область', 'UF_SORT' => 39],
        ['UF_XML_ID' => 'RU-KGN', 'UF_NAME' => 'Калужская область', 'UF_SORT' => 40],
        ['UF_XML_ID' => 'RU-KAM', 'UF_NAME' => 'Камчатский край', 'UF_SORT' => 41],
        ['UF_XML_ID' => 'RU-KEM', 'UF_NAME' => 'Кемеровская область', 'UF_SORT' => 42],
        ['UF_XML_ID' => 'RU-KIR', 'UF_NAME' => 'Кировская область', 'UF_SORT' => 43],
        ['UF_XML_ID' => 'RU-KS', 'UF_NAME' => 'Костромская область', 'UF_SORT' => 44],
        ['UF_XML_ID' => 'RU-KCH', 'UF_NAME' => 'Курганская область', 'UF_SORT' => 45],
        ['UF_XML_ID' => 'RU-KUR', 'UF_NAME' => 'Курская область', 'UF_SORT' => 46],
        ['UF_XML_ID' => 'RU-LEN', 'UF_NAME' => 'Ленинградская область', 'UF_SORT' => 47],
        ['UF_XML_ID' => 'RU-LIP', 'UF_NAME' => 'Липецкая область', 'UF_SORT' => 48],
        ['UF_XML_ID' => 'RU-MAG', 'UF_NAME' => 'Магаданская область', 'UF_SORT' => 49],
        ['UF_XML_ID' => 'RU-MOS', 'UF_NAME' => 'Московская область', 'UF_SORT' => 50],
        ['UF_XML_ID' => 'RU-MUR', 'UF_NAME' => 'Мурманская область', 'UF_SORT' => 51],
        ['UF_XML_ID' => 'RU-NEN', 'UF_NAME' => 'Ненецкий автономный округ', 'UF_SORT' => 52],

        ['UF_XML_ID' => 'RU-NIZ', 'UF_NAME' => 'Нижегородская область', 'UF_SORT' => 53],
        ['UF_XML_ID' => 'RU-NRM', 'UF_NAME' => 'Новгородская область', 'UF_SORT' => 54],
        ['UF_XML_ID' => 'RU-NVS', 'UF_NAME' => 'Новосибирская область', 'UF_SORT' => 55],
        ['UF_XML_ID' => 'RU-OMS', 'UF_NAME' => 'Омская область', 'UF_SORT' => 56],
        ['UF_XML_ID' => 'RU-ORE', 'UF_NAME' => 'Оренбургская область', 'UF_SORT' => 57],
        ['UF_XML_ID' => 'RU-ORL', 'UF_NAME' => 'Орловская область', 'UF_SORT' => 58],
        ['UF_XML_ID' => 'RU-PNZ', 'UF_NAME' => 'Пензенская область', 'UF_SORT' => 59],
        ['UF_XML_ID' => 'RU-PER', 'UF_NAME' => 'Пермский край', 'UF_SORT' => 60],
        ['UF_XML_ID' => 'RU-PSK', 'UF_NAME' => 'Псковская область', 'UF_SORT' => 61],
        ['UF_XML_ID' => 'RU-ROS', 'UF_NAME' => 'Ростовская область', 'UF_SORT' => 62],
        ['UF_XML_ID' => 'RU-RYA', 'UF_NAME' => 'Рязанская область', 'UF_SORT' => 63],
        ['UF_XML_ID' => 'RU-SAK', 'UF_NAME' => 'Сахалинская область', 'UF_SORT' => 64],
        ['UF_XML_ID' => 'RU-SAM', 'UF_NAME' => 'Самарская область', 'UF_SORT' => 65],
        ['UF_XML_ID' => 'RU-SAR', 'UF_NAME' => 'Саратовская область', 'UF_SORT' => 66],
        ['UF_XML_ID' => 'RU-SMO', 'UF_NAME' => 'Смоленская область', 'UF_SORT' => 67],
        ['UF_XML_ID' => 'RU-SVE', 'UF_NAME' => 'Свердловская область', 'UF_SORT' => 68],
        ['UF_XML_ID' => 'RU-TAM', 'UF_NAME' => 'Тамбовская область', 'UF_SORT' => 69],
        ['UF_XML_ID' => 'RU-TVE', 'UF_NAME' => 'Тверская область', 'UF_SORT' => 70],
        ['UF_XML_ID' => 'RU-TOM', 'UF_NAME' => 'Томская область', 'UF_SORT' => 71],
        ['UF_XML_ID' => 'RU-TUL', 'UF_NAME' => 'Тульская область', 'UF_SORT' => 72],
        ['UF_XML_ID' => 'RU-TYU', 'UF_NAME' => 'Тюменская область', 'UF_SORT' => 73],
        ['UF_XML_ID' => 'RU-ULY', 'UF_NAME' => 'Ульяновская область', 'UF_SORT' => 74],
        ['UF_XML_ID' => 'RU-CHE', 'UF_NAME' => 'Челябинская область', 'UF_SORT' => 75],
        ['UF_XML_ID' => 'RU-YAR', 'UF_NAME' => 'Ярославская область', 'UF_SORT' => 76],
        ['UF_XML_ID' => 'RU-YEV', 'UF_NAME' => 'Еврейская автономная область', 'UF_SORT' => 77],
        ['UF_XML_ID' => 'RU-KHM', 'UF_NAME' => 'Ханты‑Мансийский автономный округ — Югра', 'UF_SORT' => 78],
        ['UF_XML_ID' => 'RU-YAN', 'UF_NAME' => 'Ямало‑Ненецкий автономный округ', 'UF_SORT' => 79],
        ['UF_XML_ID' => 'RU-NEN', 'UF_NAME' => 'Ненецкий автономный округ', 'UF_SORT' => 80],
        ['UF_XML_ID' => 'RU-KGD', 'UF_NAME' => 'Калининградская область', 'UF_SORT' => 81],
        ['UF_XML_ID' => 'RU-SPE', 'UF_NAME' => 'Санкт‑Петербург', 'UF_SORT' => 82],
        ['UF_XML_ID' => 'RU-MOW', 'UF_NAME' => 'Москва', 'UF_SORT' => 83],
        ['UF_XML_ID' => 'RU-SEV', 'UF_NAME' => 'Севастополь', 'UF_SORT' => 84],
        ['UF_XML_ID' => 'RU-KRO', 'UF_NAME' => 'Республика Крым', 'UF_SORT' => 85],
        ['UF_XML_ID' => 'RU-ZAB', 'UF_NAME' => 'Забайкальский край', 'UF_SORT' => 86],
        ['UF_XML_ID' => 'RU-IVA', 'UF_NAME' => 'Ивановская область', 'UF_SORT' => 87],
        ['UF_XML_ID' => 'RU-KIR', 'UF_NAME' => 'Кировская область', 'UF_SORT' => 88],
        ['UF_XML_ID' => 'RU-MAG', 'UF_NAME' => 'Магаданская область', 'UF_SORT' => 89]
    ];

    // Заполняем highload‑блок данными
    foreach ($regionsToAdd as $region) {
        $addResult = $entityClass::add($region);
        if ($addResult->isSuccess()) {
            $newId = $addResult->getId();
            echo "Регион '{$region['UF_NAME']}' успешно добавлен с ID: $newId\n";
        } else {
            $errors = $addResult->getErrorMessages();
            echo "Ошибка добавления региона '{$region['UF_NAME']}': " . implode(', ', $errors) . "\n";
        }
    }
}

// ID существующего highload‑блока (в вашем случае — 17)
//RegionsRussia
//regions_russia
//Регионы России
$existingHLBlockId = 20;

// Запускаем добавление регионов в существующий highload‑блок
addRegionsToExistingHLBlock($existingHLBlockId);
?>
