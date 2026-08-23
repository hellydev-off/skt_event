<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if(!CSite::InGroup(array(1,9,7,11,12)))die('Нет доступа.');
CModule::IncludeModule('iblock');

if(!empty($id=intval($_REQUEST['get']))){
  include \Bitrix\Main\Loader::getDocumentRoot().'/include/sorevn/edit_tpl.php';
  die();
}

use Bitrix\Main\Mail\Event;

if(empty($id=intval($_REQUEST['SOREVN_ID'])))die('Нет id мероприятия :(');
//if(Aiplk::getStartPage()=='sud' and !Aiplk::isGlavSud($id))die('Нет доступа.');

//header('Content-Type: application/html');
global $USER;
//lea
$aProps=$_POST['PROJECT'];
//$aProps['STATUS']=array('VALUE'=>'process');
//var_dump('<pre>',$_POST['PROJECT']);die();

//WORK_COMPANY
if(!empty($aProps['SPORT_ORG'])){
  $aProps['SPORT_ORG']=array_diff($aProps['SPORT_ORG'], array(''));
  $aProps['SPORT_ORG']=implode(',', $aProps['SPORT_ORG']);
}

if(isset($_POST['PROJECT']['MESTO'])){
	$aRegion=Aiplk::parseRegion($_POST['PROJECT']['MESTO']);

  
  $aProps['REGION_SPR']=$aRegion['region_xml'];
	$aProps['REGION_STRANA']=$aRegion['strana'];
	$aProps['REGION']=$aRegion['region'];
	$aProps['REGION_GOROD']=$aRegion['gorod'];	
  unset($aProps['MESTO']);
}

//v($aProps);die();

$res=CIBlockElement::GetList(['NAME'=>'ASC'], ['ID'=>$id], false, false, ['*']);
if($ob=$res->GetNextElement()){
  $_aProp=array();
  foreach($ob->GetProperties(Array(),['EMPTY'=>'N']) as $f=>$row){
    $_aProp[$f]=$row['VALUE'];
  }
	$aProps=array_merge($_aProp, $aProps);
}
//var_dump('<pre>',$aProps);die('dd');
//files
$input_name='docs_meropr';
$files=array();
if(isset($_FILES[$input_name])){

    //удаляем старые файлы
    Aiplk::deleteFilesFromIB(3, $id, 'DOCS');
    ///

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
//v($aProps['DOCS']);die();

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
    //"CODE"=>CUtil::translit(trim($aProps['NAME']), "ru", $params),
    'PROPERTY_VALUES'=>$aProps
];
//var_dump('<pre>',$data,'</pre>');die();

if ($ORDER_ID = $el->update($id, $data)) {
  echo "ok ".$ORDER_ID;
} else {

echo "Error: ".$el->LAST_ERROR;

}