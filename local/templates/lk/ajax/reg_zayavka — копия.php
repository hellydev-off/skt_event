<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if(!CSite::InGroup(array(1,9,7,8)))die('Нет доступа...');
CModule::IncludeModule('iblock');
$el=new CIBlockElement;
use Bitrix\Main\Mail\Event;
$ret=array('err'=>'', 'html'=>'');
//var_dump('<pre>',$_POST['SUD_NEW'],'</pre>');die();
try{
  if(empty($SOREVN_ID=intval($_REQUEST['ID_SOREVN'])))throw new Exception('Нет id мероприятия :(');
  if(Aiplk::getStartPage()=='sud' and !Aiplk::isGlavSud($SOREVN_ID))die('Нет доступа.');
  //NEW	
  if(is_array($_POST['SUD_NEW']) and count($_POST['SUD_NEW'])>0){
    $aUser=Aiplk::getUser($GLOBALS['USER']->GetId());
    $aSorevn=Aiplk::getSorevn($ID_SOREVN);
    $aOrg=Aiplk::getUser($aSorevn['CREATED_BY']);    
    $aProps=array();
    foreach($_POST['SUD_NEW'] as $f=>$vals){
      foreach($vals as $k=>$val){
        if(!is_array($aProps[$k]))$aProps[$k]=array();
        // if(empty($val) and $f!='SORT'){
        //   unset($aProps[$k]);
        //   break(1);
        // }
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

      $item['DISCIPLINY']=explode(',', $item['DISCIPLINY']);
      $item['DISCIPLINY']=array_diff($item['DISCIPLINY'], array(''));
      $item['NAME']=$aUser['LAST_NAME'].' '.
        $aUser['NAME'].' '.
        $aUser['SECOND_NAME'].' ('.
        $item['REGION_GOROD'].' '.Aiplk::getVozrast($aUser).' '.Aiplk::vozrastTitle(Aiplk::getVozrast($aUser)).')';
      $item['ID_SOREVN']=$SOREVN_ID;      
      $data=[
        'CREATED_BY'=>$GLOBALS['USER']->GetID(),
        'IBLOCK_SECTION_ID'=>false,
        'IBLOCK_ID'=>6,
        'NAME'=>$item['NAME'],
        'ACTIVE' => 'N',
        'PROPERTY_VALUES'=>$item
      ];
      //var_dump('<pre>',$data,'</pre>');die();
      if($aOrderId[]=$el->Add($data)){
        $aFields=array(
          'SPORTSMEN'=>Aiplk::getFIO($aUser),
          'SOREVN'=>$aSorevn['NAME'],
          'EMAIL'=>'leaxxxjob@yandex.ru'//$aOrg['EMAIL']
        );
        Event::send(array(
          'EVENT_NAME'=>'NEW_SPORTSMEN',
          'LID'=>SITE_ID,
          'C_FIELDS'=>$aFields
        ));        
        $ret['html']='Заявка отправлена организатору';
      }else $err[]=$el->LAST_ERROR;
    }
  }
}catch(Exception $e){
  $ret['err']=$e->getMessage();
}
die(json_encode($ret, JSON_UNESCAPED_UNICODE));  