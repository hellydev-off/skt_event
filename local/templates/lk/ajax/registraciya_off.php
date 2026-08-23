<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if(!CSite::InGroup(array(1,9,7)))die('Нет доступа...');
$ret=array('err'=>'', 'html'=>'');
try{
  if(empty($SOREVN_ID=intval($_REQUEST['ID_SOREVN'])))throw new Exception('Нет id мероприятия :(');
  if(Aiplk::getStartPage()=='sud' and !Aiplk::isGlavSud($SOREVN_ID))throw new Exception('Нет доступа :(');
	$aItems=Aiplk::getSportsmeny($SOREVN_ID);
	if(count($aItems)<2)throw new Exception('Маловато участников :(');
	$el=new CIBlockElement;
	//var_dump($id);die();
	$el->SetPropertyValuesEx($SOREVN_ID, 3, array('REGISTRACIYA_OFF'=>['VALUE_ENUM_ID'=>'1']));
	ob_start();
  $id=$SOREVN_ID;
	require $_SERVER['DOCUMENT_ROOT'].'/include/sorevn/reg_tpl.php';
	$ret['html']=ob_get_clean();
}catch(Exception $e){
  $ret['err']=$e->getMessage();
}
die(json_encode($ret, JSON_UNESCAPED_UNICODE));