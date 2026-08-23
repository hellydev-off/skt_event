<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$ret=array('err'=>'', 'html'=>'Сохранено');
$el = new CIBlockElement;
try{
  if(empty($ID_SOREVN=intval($_REQUEST['id_sorevn'])))throw new Exception('Нет ID мероприятия :(');
  if(empty($otchet=$_REQUEST['otchet']))throw new Exception('Ошибка :(');
  if(empty($sud=$_REQUEST['sud']))throw new Exception('Ошибка :(');
  $otchet['STATUS']='closed';
  $el->SetPropertyValuesEx($ID_SOREVN, 3, $otchet);
  if($el->LAST_ERROR)throw new Exception($el->LAST_ERROR);
  foreach($sud as $id=>$ocenka){
    $id=intval($id);
    $ocenka=intval($ocenka);
    $el->SetPropertyValuesEx($id, 4, ['OCENKA_GLAVNOGO'=>$ocenka]);
    if($el->LAST_ERROR)throw new Exception($el->LAST_ERROR);
  }
}catch(Exception $e){
  $ret['err']=$e->getMessage();
}
die(json_encode($ret, JSON_UNESCAPED_UNICODE));
?>