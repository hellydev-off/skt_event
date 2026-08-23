<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('iblock');
use Bitrix\Main\Mail\Event;
if(!CSite::InGroup(array(1,9)))die('Нет доступа.');
$params = Array(
	"max_len" => "100", // обрезает символьный код до 100 символов
	"change_case" => "L", // буквы преобразуются к нижнему регистру
	"replace_space" => "-", // меняем пробелы на нижнее подчеркивание
	"replace_other" => "-", // меняем левые символы на нижнее подчеркивание
	"delete_repeat_replace" => "true", // удаляем повторяющиеся нижние подчеркивания
	"use_google" => "false", // отключаем использование google
); 

//header('Content-Type: application/html');
global $USER;
//lea
$aProps=$_POST['PROJECT'];
$aProps['STATUS']=array('VALUE'=>'process');
if(isset($_POST['PROJECT']['MESTO'])){
	$aRegion=Aiplk::parseRegion($_POST['PROJECT']['MESTO']);

  $aProps['REGION_SPR']=$aRegion['region_xml'];
	$aProps['REGION_STRANA']=$aRegion['strana'];
	$aProps['REGION']=$aRegion['region'];
	$aProps['REGION_GOROD']=$aRegion['gorod'];
  unset($aProps['MESTO']);
}
if(isset($_POST['PROJECT']['KOMANDA'])){
	$aRegion=Aiplk::parseRegion($_POST['PROJECT']['MESTO']);
	$_POST['PROJECT']['KOMANDA']=$aRegion['region_id'];
}

//WORK_COMPANY
if(!empty($aProps['SPORT_ORG'])){
  $aProps['SPORT_ORG']=array_diff($aProps['SPORT_ORG'], array(''));
  $aProps['SPORT_ORG']=implode(',', $aProps['SPORT_ORG']);
}

//files
$input_name='docs_meropr';
$files=array();
if(isset($_FILES[$input_name])){
  $diff=count($_FILES[$input_name])-count($_FILES[$input_name], COUNT_RECURSIVE);
  if($diff==0){
    $files=array($_FILES[$input_name]);
  }else{
    foreach($_FILES[$input_name] as $k=>$l){
      foreach($l as $i=>$v){
        $files[$i][$k]=$v;
      }
    }
  }
}
$aProps['DOCS']=$files;

//afisha
$input_name='afisha_meropr';
$files=array();
if(isset($_FILES[$input_name])){
  $diff=count($_FILES[$input_name])-count($_FILES[$input_name], COUNT_RECURSIVE);
  if($diff==0){
    $files=array($_FILES[$input_name]);
  }else{
    foreach($_FILES[$input_name] as $k=>$l){
      foreach($l as $i=>$v){
        $files[$i][$k]=$v;
      }
    }
  }
}
$aProps['AFISHA']=$files;

$rsUser=CUser::GetByID($USER->GetID());
$arUser=$rsUser->Fetch();
$aProps['REGISTRACIYA_ON']='Y';

//v($aProps);die();

///
$el = new CIBlockElement;
$data = [
    'CREATED_BY' => $USER->GetID(),
    'DATE_ACTIVE_FROM'=>new \Bitrix\Main\Type\DateTime(date('d.m.Y H:i:s', strtotime($aProps['DATE_ACTIVE_FROM']))),
    'DATE_ACTIVE_TO'=>new \Bitrix\Main\Type\DateTime(date('d.m.Y H:i:s', strtotime($aProps['DATE_ACTIVE_TO']))),
	  //"MODIFIED_BY"    => 1,
    'IBLOCK_SECTION_ID' => false,
    'IBLOCK_ID'=>3,
    'NAME'=>$aProps['NAME'],
    'ACTIVE' => 'Y',
    "CODE"=>CUtil::translit(trim($aProps['NAME']), "ru", $params),
    'PROPERTY_VALUES'=>$aProps
];

//var_dump('<pre>',$data);die();

if ($ORDER_ID = $el->Add($data)) {
  echo "ok ".$ORDER_ID;
} else {

echo "Error: ".$el->LAST_ERROR;

}