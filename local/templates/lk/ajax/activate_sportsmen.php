<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if(!CSite::InGroup(array(1,9,7, 11, 12)))die('Нет доступа.');
$ret=array('err'=>'', 'html'=>'');
try{
  if(empty($id=intval($_REQUEST['sportsmen_id'])))throw new Exception('Нет id спортсмена :(');
  if(empty($SOREVN_ID=intval($_REQUEST['ID_SOREVN'])))throw new Exception('Нет id мероприятия :(');
  if(Aiplk::getStartPage()=='sud' and !Aiplk::isGlavSud($SOREVN_ID))die('Нет доступа.');
	$el=new CIBlockElement;
	//var_dump($id);die();
	$el->update($id, array('ACTIVE'=>'Y'));
	ob_start();
  $id=$SOREVN_ID;
	require $_SERVER['DOCUMENT_ROOT'].'/include/sorevn/reg_tpl.php';
	$ret['html']=ob_get_clean();
}catch(Exception $e){
  $ret['err']=$e->getMessage();
}
die(json_encode($ret, JSON_UNESCAPED_UNICODE));