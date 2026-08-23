<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if(!CSite::InGroup(array(1,9,7,11,12)))die('Нет доступа.');
CModule::IncludeModule('iblock');
//var_dump('<pre>',$_REQUEST,'</pre>');die();
use Bitrix\Main\Mail\Event;
if(!empty($id=intval($_REQUEST['get']))){
  include \Bitrix\Main\Loader::getDocumentRoot().'/include/sorevn/sud_tpl.php';
  die();
}
$el=new CIBlockElement;
$ret=array('err'=>'', 'html'=>'');
try{
  if(empty($SOREVN_ID=intval($_REQUEST['ID_SOREVN'])))throw new Exception('Нет id мероприятия :(');
  //if(empty($_POST['SUD_NEW']))throw new Exception('Нет данных :(');
  if(Aiplk::getStartPage()=='sud' and !Aiplk::isGlavSud($SOREVN_ID))die('Нет доступа.');

  $sprDolzh=Aiplk::getDolzhnostSudi();
  $sprUsersSud=Aiplk::getUserSudi();

  $aOldID=array();
  foreach(Aiplk::getKollegiya($SOREVN_ID) as $row)$aOldID[]=$row['ID'];

  //OLD
  $aNewOldSud=array();
  foreach($_REQUEST['SUD'] as $id=>$row){
    $aNewOldSud[]=$id;
		if(!empty($row['REGION'])){
			$row['REGION']=addslashes($row['REGION']);
			$aRegion=Aiplk::parseRegion($row['REGION']);
			$row['REGION_STRANA']=$aRegion['strana'];
			$row['REGION']=$aRegion['region'];
			$row['REGION_GOROD']=$aRegion['gorod'];			
		}		
    $el->SetPropertyValuesEx($id, 4, $row);
    if($el->LAST_ERROR)throw new Exception($el->LAST_ERROR);
    $name=$sprSportsmeny[$row['SPORTSMEN']]['LAST_NAME'].' '.
    $sprSportsmeny[$row['SPORTSMEN']]['NAME'].' '.
    $sprSportsmeny[$row['SPORTSMEN']]['SECOND_NAME'].' ('.
    $row['REGION_GOROD'].' '.Aiplk::getVozrast($sprSportsmeny[$row['SPORTSMEN']]).' '.Aiplk::vozrastTitle(Aiplk::getVozrast($sprSportsmeny[$row['SPORTSMEN']])).')';  
    $el->Update($id, array('NAME'=>$name));
		if($el->LAST_ERROR)throw new Exception($el->LAST_ERROR);
    else $ret['html']='Сохранено';
  }
  //NEW
//  var_dump('<pre>',$_POST);die();
  if(is_array($_POST['SUD_NEW']) and count($_POST['SUD_NEW'])>0){
    $aProps=array();
    foreach($_POST['SUD_NEW'] as $f=>$vals){
      foreach($vals as $k=>$val){
        if(!is_array($aProps[$k]))$aProps[$k]=array();
        if(empty($val)){
          unset($aProps[$k]);
          break(1);
        }
				if($f=='REGION' and !empty($val)){
					$aRegion=Aiplk::parseRegion($val);
					$aProps[$k]['REGION_STRANA']=$aRegion['strana'];
					$aProps[$k]['REGION']=$aRegion['region'];
					$aProps[$k]['REGION_GOROD']=$aRegion['gorod'];
					continue;
				}				
        $aProps[$k][$f]=$val;
      }
    }
    if(empty($aProps))throw new Exception('Заполните все поля');
    $aOrderId=array();
    $err=array();
    foreach($aProps as $i=>$item){
      $item['NAME']=$sprDolzh[$item['DOLZHNOST']]['UF_NAME'].' - '.$sprUsersSud[$item['SUDYA']]['LAST_NAME'].' '.$sprUsersSud[$item['SUDYA']]['NAME'].' '.$sprUsersSud[$item['SUDYA']]['SECOND_NAME'];
      $item['ID_SOREVN']=$SOREVN_ID;     
      $data=[
        'CREATED_BY'=>$GLOBALS['USER']->GetID(),
        'IBLOCK_SECTION_ID'=>false,
        'IBLOCK_ID'=>4,
        'NAME'=>$item['NAME'],
        'ACTIVE' => 'Y',
        'PROPERTY_VALUES'=>$item
      ];
      if($aOrderId[]=$el->Add($data)){
        $ret['html']='Сохранено';
      }else $err[]=$el->LAST_ERROR;
    }
  }
  if(empty($err)){
    foreach(array_diff($aOldID,$aNewOldSud) as $oldId){
      $r=CIBlockElement::Delete($oldId);
    }
  }else throw new Exception(implode('<br>', $err));
}catch(Exception $e){
  $ret['err']=$e->getMessage();
}
die(json_encode($ret, JSON_UNESCAPED_UNICODE));