<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
//if(!CSite::InGroup(array(6,7)))die('Нет доступа');
use Bitrix\Main\Mail\Event;
global $USER; 

$session = \Bitrix\Main\Application::getInstance()->getSession();
$info = [];
$sms_code_success = false;
$error_txt = '';

//if(isset($_REQUEST['user_status']) and count($_REQUEST['user_status'])>0)$aUserStatus=$_REQUEST['user_status'];
//else die(json_encode(['status'=>0, 'error'=>'Не выбран статус :('], JSON_UNESCAPED_UNICODE));

if ($session->has('registration_sms_code')){
    if ($session['registration_sms_code'] == $_POST['SMS_CODE']){
		
		//создание пользователя
		$user = new CUser;
		
		// $new_password = randString(8, array(
		// 	  "abcdefghijklnmopqrstuvwxyz",
		// 	  "ABCDEFGHIJKLNMOPQRSTUVWXYZ",
		// 	  "0123456789",
		// 	));
		
		$FIO = trim($_POST["USER"]["NAME"]);
		$login = trim($_POST["USER"]["EMAIL"]);

		$arFields = $_POST["USER"];

		$user_phone=trim(addslashes($arFields['PHONE_NUMBER']));
		if($user_phone[0] == '8'){
			$user_phone[0] = '+7';
		}
		//$user_phone = "+".preg_replace("/[^0-9]/", '', $_POST["USER"]["PHONE_NUMBER"]);
    $user_phone=str_replace('-', '', $user_phone);
    $user_phone=str_replace(' ', '', $user_phone);
    //die($user_phone);
		$arFields["PHONE_NUMBER"] = $user_phone;
		$arFields["PERSONAL_PHONE"] = $user_phone;
		
 

		$arFields["PASSWORD"] = addslashes($_POST["NEW_PASSWORD"]);
		$arFields["CONFIRM_PASSWORD"] = addslashes($_POST["NEW_PASSWORD_CONFIRM"]);
		$arFields["LOGIN"] = $login;

		$arFields["GROUP_ID"]=$aUserStatus;
    if(!empty($_POST['drone']))$arFields[$_POST['drone']]='Y';
    $arFields['ACTIVE']='Y';

		$_REQUEST['USER']['UF_REGION']=addslashes($_REQUEST['USER']['UF_REGION']);
    if(isset($_REQUEST['USER']['UF_REGION'])){	
			$aRegion=Aiplk::parseRegion($_REQUEST['USER']['UF_REGION']);
      $arFields['UF_REGION_STRANA']=$aRegion['strana'];
      $arFields['UF_REGION_SPR']=$aRegion['region_id'];
      $arFields['UF_REGION']=$aRegion['region'];
      $arFields['UF_GOROD']=$aRegion['gorod'];
    }
    
		Aiplk::setFIO($arFields);

		$newBirthday=date("d.m.Y", strtotime($_POST["USER"]["PERSONAL_BIRTHDAY"]));
		$arFields["PERSONAL_BIRTHDAY"]=$newBirthday;

$user = new CUser;


$arFields['UF_LINK_MANAGER']=$arUser['ID'];

if($userID = $user->Add($arFields)){
			$sms_code_success = true;
			//$USER->Authorize($userID);
		}else{
			$error_txt = $user->LAST_ERROR;
		}
	}else{
		$error_txt = "неверный код подтверждения";
	};            
}else{
	$error_txt = "неверный код подтверждения";
}; 

if ($sms_code_success){
  $info = ['status' => 1];
  // $arFields['USER_ID']=$userID;
  // $arFields['LNK_ACTIVATE']='http://'.SITE_SERVER_NAME.'/activate.php?user='.$userID;
  // $arFields['SEND_EMAIL']=$arUser['EMAIL'];
  // //$arFields['SEND_EMAIL']='leaxxxjob@gmail.com';  
	// Event::send(array(
	// 		'EVENT_NAME' => 'LK_USER_REGISTER',
	// 		'LID' => SITE_ID,
	// 		'C_FIELDS' => $arFields,
	// 	));
}else{
	$info = ['status' => 0, 'error'=>$error_txt];
}


echo json_encode($info, JSON_UNESCAPED_UNICODE);

//file_put_contents("post.log", print_r($_POST, true));

die();