<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
//var_dump('<pre>',$_REQUEST);die();
$ret=array('etap'=>array(), 'err'=>'');
try{
  if(empty($ID_SOREVN=intval($_REQUEST['ID_SOREVN'])))throw new Exception('ID_SOREVN пуст');
  if(empty($disc=addslashes($_REQUEST['disc'])))throw new Exception('disc пуст');
  if(empty($gruppa=addslashes($_REQUEST['gruppa'])))throw new Exception('gruppa пуст');
  if(!is_array($etap=$_REQUEST['etap']))throw new Exception('etap пуст');
  if(empty($prgVarEtap=intval($_REQUEST['prgVarEtap'])))throw new Exception('prgVarEtap пуст');

  $aVarEtap=Aiplk::getVariantEtap();
//v($aVarEtap[$prgVarEtap]['PROPERTIES']['ETAP']['VALUE']);
//v($aVarEtap[$prgVarEtap]['PROPERTIES']['KOLVO']['VALUE'],1);
$allKol=count(Aiplk::getSportsmenyKolvo($ID_SOREVN, $disc, $gruppa));
foreach($aVarEtap[$prgVarEtap]['PROPERTIES']['ETAP']['VALUE'] as $k=>$et){
	$kolvo=$aVarEtap[$prgVarEtap]['PROPERTIES']['KOLVO']['VALUE'][$k];
	if(empty($kolvo))$kolvo=$allKol;
	$ret['etap'][$et]=$kolvo;
}


  // foreach($etap as $et){
  //   $allKol=count(Aiplk::getSportsmenyKolvo($ID_SOREVN, $disc, $gruppa));
  //   if($et=='otbor')$kolvo=$allKol;
  //   // if($et=='chetv')$kolvo=(($allKol<32)?$allKol:32);
  //   // if($et=='poluf')$kolvo=(($allKol<16)?$allKol:16);
  //   // if($et=='final')$kolvo=(($allKol<8)?$allKol:8);
  //   if($et=='chetv')$kolvo=32;
  //   if($et=='poluf')$kolvo=16;
  //   if($et=='final')$kolvo=8;
  //   $ret['etap'][$et]=$kolvo;
  // }

  //include \Bitrix\Main\Loader::getDocumentRoot().'/include/sorevn/programmy_tpl.php';
  //$ret['html_prog']

}catch(Exception $e){
  $ret['err']=$e->getMessage();
}
die(json_encode($ret, JSON_UNESCAPED_UNICODE));
?>