<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if(!CSite::InGroup(array(1,11,12)))die('Нет доступа...');
$ret=array('err'=>'', 'html'=>'');
try{
  if(empty($SPRT_ID=intval($_REQUEST['SPRT_ID'])))throw new Exception('Нет id SPRT :(');
  if(empty($SPRT_FIELD=addslashes($_REQUEST['SPRT_FIELD'])))throw new Exception('Нет id SPRT_FIELD :(');
  if(empty($SPRT_VAL=addslashes($_REQUEST['SPRT_VAL'])))$SPRT_VAL=false;
  $el=new CIBlockElement;
  $aProps=array();
  if($SPRT_FIELD=='disc'){
    if(empty($XMLID=addslashes($_REQUEST['XMLID'])))throw new Exception('Нет id XMLID :(');
    $aSprt=Aiplk::getSportsmen($SPRT_ID);
    $a=$aSprt['PROPERTIES']['DISCIPLINY']['VALUE'];
    if(empty($a))$a=array();
    $k=array_search($XMLID, $a);
    if($SPRT_VAL){
      if($k===false)$a[]=$XMLID;
    }else{
      if($k!==false){
        foreach($a as $k=>$v)if($v==$XMLID)unset($a[$k]);
      }
    }
    $aProps['DISCIPLINY']=$a;
  }else{
    $aProps[$SPRT_FIELD]=$SPRT_VAL;
  }
  //var_dump($SPRT_ID, 6, $aProps);
  $el->SetPropertyValuesEx($SPRT_ID, 6, $aProps);
}catch(Exception $e){
  $ret['err']=$e->getMessage();
}
die(json_encode($ret, JSON_UNESCAPED_UNICODE));