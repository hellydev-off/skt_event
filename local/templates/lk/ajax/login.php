<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

global $USER;
if (!is_object($USER)) $USER = new CUser;
$arAuthResult = $USER->Login($_REQUEST['LOGIN'], $_REQUEST['PASSW'], "Y");


$info = [];
if ($arAuthResult['TYPE'] == 'ERROR') {
    $info = ['status' => 0, 'msg' => 'Неверный логин или пароль'];
} else {
    $info = ['status' => 1];
    $rsUser = $USER::GetByID($USER->GetID());
    $arUser = $rsUser->Fetch();
}

//var_dump('<pre>', $info);die();

echo json_encode($info);
die();
