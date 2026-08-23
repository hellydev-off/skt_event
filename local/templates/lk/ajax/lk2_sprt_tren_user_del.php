<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if(!CSite::InGroup(array(1,11,12)))die('Нет доступа...');
$ret='';
try{
  if(empty($SPRT_ID=intval($_REQUEST['SPRT_ID'])))throw new Exception('Нет id SPRT :(');
  $user=new CUser;
  $user->Update($SPRT_ID, ["UF_TRENER_DATE_ADD"=>'', 'UF_TRENER_ID'=>'']);
}catch(Exception $e){
  $ret=$e->getMessage();
}
die($ret);
?>