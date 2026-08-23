<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if(!CSite::InGroup(array(1,9,7,8)))die('Нет доступа...');
CModule::IncludeModule('iblock');
$el=new CIBlockElement;
use Bitrix\Main\Mail\Event;
$ret=array('err'=>'', 'html'=>'');
//var_dump('<pre>',$_POST,'</pre>');die();
try{
  if(empty($SOREVN_ID=intval($_REQUEST['ID_SOREVN'])))throw new Exception('Нет id мероприятия :(');
  if(Aiplk::getStartPage()=='sud' and !Aiplk::isGlavSud($SOREVN_ID))die('Нет доступа.');
  if(!is_array($_POST['reg']['DISCIPLINY']) or count($_POST['reg']['DISCIPLINY'])==0)throw new Exception('Нет id дисциплин :(');
  $aSprt=Aiplk::getSprtCurrent($SOREVN_ID);
  $aRazryad=Aiplk::getRazryad();
  $aRazryadId=array();
  foreach($aRazryad as $row)$aRazryadId[$row['ID']]=$row;
  $aUser=Aiplk::getUser($GLOBALS['USER']->GetId());
  $aSorevn=Aiplk::getSorevn($SOREVN_ID);
  $aOrg=Aiplk::getUser($aSorevn['CREATED_BY']);    
  $aProps=array(
    'DISCIPLINY'=>$_POST['reg']['DISCIPLINY'],
    'ID_SOREVN'=>$SOREVN_ID,
    'REGION_STRANA'=>$aUser['UF_REGION_STRANA'],
    'REGION'=>$aUser['UF_REGION'],
    'REGION_GOROD'=>$aUser['UF_GOROD'],
    'VOZRAST_GRUPPA'=>Aiplk::getVozrastGruppa($aUser['ID'])[2]['UF_XML_ID'],
    'RAZRYAD'=>$aRazryadId[$aUser['UF_RAZR']]['UF_XML_ID'],
    'SPORTSMEN'=>$aUser['ID'],
    'TRENER'=>$aUser['UF_TRENER_ID']
  );
  $name=$aUser['LAST_NAME'].' '.
  $aUser['NAME'].' '.
  $aUser['SECOND_NAME'].' ('.
  $aProps['REGION_GOROD'].' '.Aiplk::getVozrast($aUser).' '.Aiplk::vozrastTitle(Aiplk::getVozrast($aUser)).')';

  //SORT
  $aProps['SORT']=Aiplk::getLastUserSort($aProps, $ID_SOREVN);

  //NEW
  if(empty($aSprt)){
    $data=[
      'CREATED_BY'=>$GLOBALS['USER']->GetID(),
      'IBLOCK_SECTION_ID'=>false,
      'IBLOCK_ID'=>6,
      'NAME'=>$name,
      'ACTIVE' => 'Y',//для предварительной заявки ставим N, тогда организатор будет утверждать такого юзера отдельно
      'PROPERTY_VALUES'=>$aProps
    ];
  }
  if($aOrderId[]=$el->Add($data)){
    $aFields=array(
      'SPORTSMEN'=>Aiplk::getFIO($aUser),
      'SOREVN'=>$aSorevn['NAME'],
      'EMAIL'=>$aOrg['EMAIL']
    );

    //Обновляем кол-во в программе
    Aiplk::updateProgramKolvo($aProps, $ID_SOREVN);
    //

    Event::send(array(
      'EVENT_NAME'=>'NEW_SPORTSMEN',
      'LID'=>SITE_ID,
      'C_FIELDS'=>$aFields
    ));        
    $ret['html']='Заявка отправлена организатору';
  }else $err[]=$el->LAST_ERROR;
}catch(Exception $e){
  $ret['err']=$e->getMessage();
}
die(json_encode($ret, JSON_UNESCAPED_UNICODE));  