<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if(!CSite::InGroup(array(1,9,7,11,12)))die('Нет доступа...');
$ret=array('err'=>'', 'html'=>'');
try{
  if(empty($SOREVN_ID=intval($_REQUEST['ID_SOREVN'])))throw new Exception('Нет id мероприятия :(');
  if(empty($_REQUEST['data']))throw new Exception('Нет данных :(');
  //if(Aiplk::getStartPage()!='org' and !Aiplk::isGlavSud($SOREVN_ID))throw new Exception('Нет доступа :(');
  if(!$aData=json_decode($_REQUEST['data'], true))throw new Exception(':(');
  //var_dump($aData, $SOREVN_ID);die();
  $el=new CIBlockElement;
  foreach($aData as $progId=>$a){
    $SO_STENDA=intval($a['SO_STENDA']);
    $S_SERII=intval($a['S_SERII']);
    if(empty($SO_STENDA))$SO_STENDA=1;
    if(empty($S_SERII))$S_SERII=1;
    $el->SetPropertyValuesEx($progId, 5, array('SO_STENDA'=>$SO_STENDA, 'S_SERII'=>$S_SERII));
  }
}catch(Exception $e){
  $ret['err']=$e->getMessage();
}
die(json_encode($ret, JSON_UNESCAPED_UNICODE));