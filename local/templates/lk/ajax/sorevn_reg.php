<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if(!CSite::InGroup(array(1,11,12)))die('Нет доступа...');

CModule::IncludeModule('iblock');
use Bitrix\Main\Mail\Event;
$el=new CIBlockElement;
if(!empty($id=intval($_REQUEST['get']))){
  if(Aiplk::getStartPage()=='sport'){
    include \Bitrix\Main\Loader::getDocumentRoot().'/include/sorevn/reg_sport_tpl.php';
    die();
  }
  if(isset($_REQUEST['reg_edit'])){
    if(isset($_REQUEST['id_sportsmen']))$id_sportsmen=intval($_REQUEST['id_sportsmen']);else $id_sportsmen='';
    include \Bitrix\Main\Loader::getDocumentRoot().'/include/sorevn/reg_edit_tpl.php';
  }else{
		//die('lk_ross');
    include \Bitrix\Main\Loader::getDocumentRoot().'/include/sorevn/reg_tpl.php';
  } 
  die();
}

//var_dump('<pre>',$_POST,'</pre>');die();

//-id_user_sportsmen
//-id_sorevn
//-region
//-gruppa
//-discipl
//-razryad
//id_trener

$ret=array('err'=>'', 'html'=>'');
try{
  $aProps=array();
  if(empty($SOREVN_ID=intval($_REQUEST['ID_SOREVN'])))throw new Exception('Нет id мероприятия :(');
  //if(Aiplk::getStartPage()=='sud' and !Aiplk::isGlavSud($SOREVN_ID))die('Нет доступа.');
  
  if(!empty($_REQUEST['id_sportsmen']))$id_sportsmen=intval($_REQUEST['id_sportsmen']);
  else $id_sportsmen=false;

  $aProps['ID_SOREVN']=$SOREVN_ID;
  $_regionRaw=addslashes($_REQUEST['reg']['REGION']);
  if(strpos($_regionRaw, '_')===false){
    //поле не трогали — значение по умолчанию, это уже голый код региона
    $_reg=Aiplk::getRegionSprNew($_regionRaw);
    $aRegion=$_reg?array('strana'=>'Россия', 'region'=>$_reg['UF_NAME'], 'region_xml'=>$_reg['UF_XML_ID'], 'region_id'=>$_reg['ID'], 'gorod'=>''):false;
  }else{
    //составное значение: либо из автокомплита городов (Страна_ISOкод_Город),
    //либо дефолт из reg_edit_tpl.php (Страна_ИмяРегиона_Город) — пробуем оба варианта разбора
    $aRegion=Aiplk::parseRegion($_regionRaw);
    if(!$aRegion)$aRegion=Aiplk::parseRegion($_regionRaw, 'findName');
  }
  if(!$aRegion)throw new Exception('Регион не распознан, выберите город из списка подсказок');
  $aProps['REGION_STRANA']=$aRegion['strana'];
  $aProps['REGION']=$aRegion['region'];
  $aProps['REGION_SPR']=$aRegion['region_xml'];
  $aProps['REGION_GOROD']=$aRegion['gorod'];
  $aProps['VOZRAST_GRUPPA']=addslashes($_REQUEST['VGRUPPA']);
  $aProps['SPORTSMEN']=intval($_REQUEST['reg']['USER_SPORTSMEN']);
  if(is_array($_REQUEST['reg']['DISCIPLINY']))$aProps['DISCIPLINY']=$_REQUEST['reg']['DISCIPLINY'];
  $aUser=Aiplk::getUser($aProps['SPORTSMEN']);
  $aProps['RAZRYAD']=$aUser['UF_RAZR'];
  $aProps['TRENER']=$aUser['UF_TRENER_ID'];
  $aProps['NAME']=$aUser['LAST_NAME'].' '.
    $aUser['NAME'].' '.
    $aUser['SECOND_NAME'].' ('.
    $aProps['REGION_GOROD'].' '.Aiplk::getVozrast($aUser).' '.Aiplk::vozrastTitle(Aiplk::getVozrast($aUser)).')';    

  if(!$id_sportsmen){
    $_check=Aiplk::getSportsmenFromUserId($SOREVN_ID, $aProps['SPORTSMEN']);
    if(!empty($_check))throw new Exception('Такой спортсмен уже зарегистрирован.');
  }

 // var_dump('<pre>',$aProps);die();

  if($id_sportsmen){//edit
    $el->SetPropertyValuesEx($id_sportsmen, 6, $aProps);
    $ret['html']='Сохранено';
  }else{//new
    //$aSportsmeny=Aiplk::getSportsmeny($ID_SOREVN);
    //SORT
    $aProps['SORT']=Aiplk::getLastUserSort($aProps, $SOREVN_ID); 
    $data=[
      'CREATED_BY'=>$GLOBALS['USER']->GetID(),
      'IBLOCK_SECTION_ID'=>false,
      'IBLOCK_ID'=>6,
      'NAME'=>$aProps['NAME'],
      'ACTIVE' => 'Y',
      'PROPERTY_VALUES'=>$aProps
    ];
    if($el->Add($data))$ret['html']='Сохранено';
    //Обновляем кол-во в программе
    //var_dump($aProps, $SOREVN_ID);die();
    Aiplk::updateProgramKolvo($aProps, $SOREVN_ID);
    //
  }
  if($el->LAST_ERROR)throw new Exception($el->LAST_ERROR);
}catch(Exception $e){
  $ret['err']=$e->getMessage();
}
die(json_encode($ret, JSON_UNESCAPED_UNICODE));
?>