<?php
header('Content-Type: application/json; charset=utf-8');
$ret=array();
$ret2=array();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
$aProgramma=Aiplk::getProgramma(intval($_GET['id_programma']));
$aSorevn=Aiplk::getSorevn($aProgramma['PROPERTIES']['ID_SOREVN']['VALUE']);
if(empty($aProgramma) or empty($aSorevn))die('Ошибка :(');
$aDisc=Aiplk::getDisciplina();
$aRazryad=Aiplk::getRazryad();
$aRazryadId=array();
foreach($aRazryad as $row)$aRazryadId[$row['ID']]=$row;
$seriy=intval($aProgramma['PROPERTIES']['KOLVO_SERIY']['VALUE']);
$broskov=intval($aProgramma['PROPERTIES']['KOLVO_BROSKOV']['VALUE']);
$aVarEtap=Aiplk::getVariantEtap();

$ret['header_title']=$aSorevn['NAME'];
$ret['header_vid']='спортивное метание ножа';
$ret['header_date']=$aSorevn['ACTIVE_FROM'].' - '.$aSorevn['ACTIVE_TO'];
$ret['header_mesto']=Aiplk::getRegionTitle($aSorevn)['txt'];
$ret['header_disciplina']=Aiplk::getDisciplina($aProgramma['PROPERTIES']['DISCIPLINA']['VALUE'])['NAME'];
$ret['header_gruppa']=Aiplk::getVozrastGuppa($aProgramma['PROPERTIES']['VOZRAST_GRUPPA']['VALUE'])['NAME'];

try{
	if(empty($aVarEtap[$aProgramma['PROPERTIES']['VARETAP']['VALUE']]))throw new Exception();
	$aVarEtap=$aVarEtap[$aProgramma['PROPERTIES']['VARETAP']['VALUE']];
	$kolvo_v_etape=0;
	$kolvo_stendov=0;
  $flDef=true;
	foreach($aVarEtap['PROPERTIES']['ETAP']['VALUE'] as $k=>$v){
		if($v==$aProgramma['PROPERTIES']['ETAP']['VALUE']){
			$kolvo_v_etape=$aVarEtap['PROPERTIES']['KOLVO']['VALUE'][$k];
			$kolvo_stendov=array_shift(Aiplk::getVariantStend($aProgramma['PROPERTIES']['VARSTEND']['VALUE']));
			$kolvo_stendov=$kolvo_stendov['PROPERTIES']['STENDY']['VALUE'];
			if($kolvo_v_etape==0)throw new Exception();
			else{
        $flDef=false;
        require './include/protokol/po_stendam_json.phtml';
      }
			break;
		}
	}
  if($flDef)throw new Exception();
}catch(Exception $e){
	require './include/protokol/all_json.phtml';
}
if(isset($_GET['f1'])){
  die(json_encode($ret2, JSON_UNESCAPED_UNICODE));
}elseif(isset($_GET['f2'])){
  die(json_encode($ret, JSON_UNESCAPED_UNICODE));
}
?>