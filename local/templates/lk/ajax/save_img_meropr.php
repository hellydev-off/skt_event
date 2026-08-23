<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$ret=array('html'=>'', 'err'=>'');
$el=new CIBlockElement;
try{
  $input_name='mfile';
  $del=0;
  if(empty($_REQUEST['mid']))throw new Exception(':( mid');
  if(isset($_REQUEST['del']))$del=1;
  $id=intval($_REQUEST['mid']);
  $a=array();
  
  if($del){
    $el->SetPropertyValuesEx($id, 3, array("AFISHA" =>  array(array("VALUE" => array("del" => "Y")))));
  }else{
    $fileName=$_FILES[$input_name]["name"];
    $fileTmpName=$_FILES[$input_name]["tmp_name"];
    $fileType=$_FILES[$input_name]["type"]; 
    $file=CFile::MakeFileArray($fileTmpName);
    $file['name']=$fileName;
    if($file)$a['AFISHA']=$file;
    if(!empty($a)){
      $el->SetPropertyValuesEx($id, 3, $a);
    }
  }
  die(json_encode($ret, JSON_UNESCAPED_UNICODE));
}catch(Exception $e){
  $ret['html']='';
  $ret['err']=$e->getMessage();
  die(json_encode($ret, JSON_UNESCAPED_UNICODE));
}
?>