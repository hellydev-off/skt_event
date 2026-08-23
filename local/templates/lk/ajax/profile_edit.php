<?php
//var_dump('<pre>',$_REQUEST);die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$ret=array('err'=>'', 'html'=>'');
$user=new CUser;
try{
  if(!isset($_REQUEST['ID']) or empty($id=intval($_REQUEST['ID'])))throw new Exception('Нет ID пользователя :(');
  $aUserGroups=$user->GetUserGroup($id);
  $aUserStatus=array();
  if(!is_array($_REQUEST['user']))throw new Exception('Нет :(');
  if(isset($_REQUEST['user_status']) and count($_REQUEST['user_status'])>0)$aUserStatus=$_REQUEST['user_status'];
  foreach($aUserGroups as $k=>$row)if(in_array($row, Aiplk::$groupIds))unset($aUserGroups[$k]);
  $aUserStatus=array_merge($aUserStatus, $aUserGroups);

  if(isset($_REQUEST['user']['UF_REGION'])){
		$aRegion=Aiplk::parseRegion($_REQUEST['user']['UF_REGION']);
    if($aRegion===false)throw new Exception('Регион не распознан, выберите город из списка подсказок');
		$_REQUEST['user']['UF_REGION_STRANA']=$aRegion['strana'];
    $_REQUEST['user']['UF_REGION']=$aRegion['region'];
    $_REQUEST['user']['UF_REGION_SPR']=$aRegion['region_id'];
    $_REQUEST['user']['UF_GOROD']=$aRegion['gorod'];
  }

  if(empty($_REQUEST['no_change_groups'])){
    $aUserStatus[]=4;
    $a=array_merge($_REQUEST['user'], array('GROUP_ID'=>$aUserStatus));
  }else $a=$_REQUEST['user'];
 // var_dump('<pre>',$a);die();

  $newBirthday=date("d.m.Y", strtotime($_REQUEST["user"]["PERSONAL_BIRTHDAY"]));
  $a["PERSONAL_BIRTHDAY"]=$newBirthday; 
  if(!empty($a["UF_LIC_TRENER_SROK"])){
    $newBirthday=date("d.m.Y", strtotime($_REQUEST["user"]["UF_LIC_TRENER_SROK"]));
    $a["UF_LIC_TRENER_SROK"]=$newBirthday;
  }

  //WORK_COMPANY
  if(!empty($a['WORK_COMPANY'])){
    $a['WORK_COMPANY']=array_diff($a['WORK_COMPANY'], array(''));
    $a['WORK_COMPANY']=implode(',', $a['WORK_COMPANY']);
  }

	Aiplk::setFIO($a);

  //files
  $input_name1='docs_sport';
  $input_name2='docs_sud';
  $input_name3='photo_main';
  $input_name4='photo_org';
  $input_name5='photo_sud';
  $input_name6='photo_tren';
  $input_name7='photo_sprt';
  $files=array();
  if(!empty($_FILES[$input_name1]['name']['0'])){
    foreach ($_FILES[$input_name1]["name"] as $key => $value) {
      $fileName = $_FILES[$input_name1]["name"][$key];
      $fileTmpName = $_FILES[$input_name1]["tmp_name"][$key];
      $fileType = $_FILES[$input_name1]["type"][$key]; 
      $file = CFile::MakeFileArray($fileTmpName);
      $file['name'] = $fileName;
      $files[] = $file;
    }
  }  
  $files=array();
  if(!empty($_FILES[$input_name2]['name']['0'])){
    foreach ($_FILES[$input_name2]["name"] as $key => $value) {
      $fileName = $_FILES[$input_name2]["name"][$key];
      $fileTmpName = $_FILES[$input_name2]["tmp_name"][$key];
      $fileType = $_FILES[$input_name2]["type"][$key]; 
      $file = CFile::MakeFileArray($fileTmpName);
      $file['name'] = $fileName;
      $files[] = $file;
    }
  }
  if(count($files)>0)$a['UF_DOCS']=$files;
  //UF_PHOTO_MAIN
  $files=array();
  if(!empty($_FILES[$input_name3]['name']['0'])){
    foreach ($_FILES[$input_name3]["name"] as $key => $value) {
      $fileName = $_FILES[$input_name3]["name"][$key];
      $fileTmpName = $_FILES[$input_name3]["tmp_name"][$key];
      $fileType = $_FILES[$input_name3]["type"][$key]; 
      $file = CFile::MakeFileArray($fileTmpName);
      $file['name'] = $fileName;
      $files=$file;
    }
  }
  if(count($files)>0)$a['UF_PHOTO_MAIN']=$files;
  //
  //UF_PHOTO_ORG
  $files=array();
  if(!empty($_FILES[$input_name4]['name']['0'])){
    foreach ($_FILES[$input_name4]["name"] as $key => $value) {
      $fileName = $_FILES[$input_name4]["name"][$key];
      $fileTmpName = $_FILES[$input_name4]["tmp_name"][$key];
      $fileType = $_FILES[$input_name4]["type"][$key]; 
      $file = CFile::MakeFileArray($fileTmpName);
      $file['name'] = $fileName;
      $files=$file;
    }
  }
  if(count($files)>0)$a['UF_PHOTO_ORG']=$files;
  //
  //UF_PHOTO_SUD
  $files=array();
  if(!empty($_FILES[$input_name5]['name']['0'])){
    foreach ($_FILES[$input_name5]["name"] as $key => $value) {
      $fileName = $_FILES[$input_name5]["name"][$key];
      $fileTmpName = $_FILES[$input_name5]["tmp_name"][$key];
      $fileType = $_FILES[$input_name5]["type"][$key]; 
      $file = CFile::MakeFileArray($fileTmpName);
      $file['name'] = $fileName;
      $files=$file;
    }
  }
  if(count($files)>0)$a['UF_PHOTO_SUD']=$files;
  //   
  //UF_PHOTO_TREN
  $files=array();
  if(!empty($_FILES[$input_name6]['name']['0'])){
    foreach ($_FILES[$input_name6]["name"] as $key => $value) {
      $fileName = $_FILES[$input_name6]["name"][$key];
      $fileTmpName = $_FILES[$input_name6]["tmp_name"][$key];
      $fileType = $_FILES[$input_name6]["type"][$key]; 
      $file = CFile::MakeFileArray($fileTmpName);
      $file['name'] = $fileName;
      $files=$file;
    }
  }
  if(count($files)>0)$a['UF_PHOTO_TREN']=$files;
  //    
  //UF_PHOTO_SPRT
  $files=array();
  if(!empty($_FILES[$input_name7]['name']['0'])){
    foreach ($_FILES[$input_name7]["name"] as $key => $value) {
      $fileName = $_FILES[$input_name7]["name"][$key];
      $fileTmpName = $_FILES[$input_name7]["tmp_name"][$key];
      $fileType = $_FILES[$input_name7]["type"][$key]; 
      $file = CFile::MakeFileArray($fileTmpName);
      $file['name'] = $fileName;
      $files=$file;
    }
  }
  if(count($files)>0)$a['UF_PHOTO_SPRT']=$files;
  //  
//дата добавления тренера
$u=Aiplk::getUser($id);
if($u['UF_TRENER_ID']!=$a['UF_TRENER_ID'])$a['UF_TRENER_DATE_ADD']=new \Bitrix\Main\Type\DateTime();
///

  //var_dump('<pre>',$a,'</pre>');die();
  if($user->Update($id, $a)){
    $ret['html']='Сохранено';
  }else throw new Exception('Ошибка записи пользователя "'.$user->LAST_ERROR.'"');
}catch(Exception $e){
  $ret['err']=$e->getMessage();
}
die(json_encode($ret, JSON_UNESCAPED_UNICODE));
?>