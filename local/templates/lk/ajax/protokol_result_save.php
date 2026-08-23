<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
//var_dump('<pre>',$_REQUEST,'</pre>');

if(!CSite::InGroup(array(1,7)))die('Нет доступа.');
$ID_SOREVN=intval($_REQUEST['prot_id_sorevn']);

CModule::IncludeModule('iblock');
$ret=array('err'=>'', 'html'=>'');
try{
  if(empty($sportsmenId=intval($_REQUEST['prot_sportsmen_id'])))throw new Exception('Нет id спортсмена :(');
  if(empty($programmaId=intval($_REQUEST['prot_programma_id'])))throw new Exception('Нет id программы :(');
  if(empty($seriya=intval($_REQUEST['prot_seriya'])))throw new Exception('Нет серии :(');
  if(empty($_REQUEST['prot_results']) or !is_array($_REQUEST['prot_results']))throw new Exception('Нет данных :(');  
  $el=new CIBlockElement;
  $_a=Aiplk::getSportsmen($sportsmenId);
  if(empty($_a['PROPERTIES']['REZULTATY_JSON']['VALUE'])){
    $resJson=array();
  }else{
    $resJson=json_decode($_a['PROPERTIES']['REZULTATY_JSON']['~VALUE'], true);
  }
  //var_dump('<pre>',$_a['PROPERTIES']['REZULTATY_JSON']['VALUE'],'</pre>');
  if(!is_array($resJson[$programmaId]))$resJson[$programmaId]=array();
  $resJson[$programmaId][$seriya]=$_REQUEST['prot_results'];
  if($_a=json_encode($resJson, JSON_UNESCAPED_UNICODE)){
    //var_dump('<pre>',$_a);
    $el->SetPropertyValuesEx($sportsmenId, 6, array('REZULTATY_JSON'=>$_a));
  }else throw new Exception('Ошбка данных :(');
}catch(Exception $e){
  $ret['err']=$e->getMessage();
}
die(json_encode($ret, JSON_UNESCAPED_UNICODE));  
?>