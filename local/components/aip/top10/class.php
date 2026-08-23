<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
class AIPTop10 extends CBitrixComponent{
  public $ajax=false;
	public function executeComponent(){
    if(isset($_REQUEST['ajax'])){
      $this->ajax='Y';
    }else{
      $this->IncludeComponentTemplate();
      return false;
    }
		$IBLOCK_ID_USER=6;
		$IBLOCK_ID_SOREVN=3;
		$IBLOCK_ID_PRG=5;
		$pGruppa=addslashes($_REQUEST['top10_flt_gruppy']);
		$pDisc=addslashes($_REQUEST['top10_flt_discipl']);
		$pPeriod=addslashes($_REQUEST['top10_flt_period']);

$aSpr=$this->getAGruppyDiscipl();
$flFirst=$pGruppa;
$aDisc=array();
foreach($aSpr as $k=>$v){             
  if($flFirst==$v['UF_GRUPPA']){
    $aDisc=$v['UF_DISCIPLINA'];
    break;
  }
}
if(!empty($pDisc)){
  $fl=false;
  $flFirst=false;
  foreach($aDisc as $k=>$v){
    if(!$flFirst)$flFirst=$v['XML_ID'];
    if($pDisc==$v['XML_ID']){
      $fl=true;
      break;
    }
  }
  if(!$fl){
    $pDisc=$flFirst;
  }
}

		if(1==1 or CModule::IncludeModule('iblock') && $this->StartResultCache(false, $pGruppa.$pDisc.$pPeriod)){
			$arSort=array("DATE_CREATE"=>"ASC");
			$arFilter=array(
				"IBLOCK_ID"=>$IBLOCK_ID_SOREVN,
				"ACTIVE"=>'Y',
				"<=DATE_CREATE"=>date('d.m.Y H:i:s')
			);
      if($pPeriod!='all')$arFilter['>=DATE_CREATE']='01.01.'.(date('Y')).' 00:00:00';

      $aSorevnId=array();
      $aUserIdFirst=array();
      $aUserFirstPrg=array();

      $aSorevn=Aiplk::getIB($arFilter, $arSort);
      foreach($aSorevn as $k=>$v)$aSorevnId[]=$v['ID'];

      $aFlt=array(
        'ACTIVE'=>'Y',
        'IBLOCK_ID'=>$IBLOCK_ID_PRG,
        'PROPERTY_VOZRAST_GRUPPA'=>$pGruppa,
        'PROPERTY_DISCIPLINA'=>$pDisc,
        'PROPERTY_ID_SOREVN'=>$aSorevnId,
        '>PROPERTY_KOLVO_UCH'=>0,
        'PROPERTY_ETAP'=>'final'
      );
      $prgs=Aiplk::getIB($aFlt);
      foreach($prgs as $p){
        $aRes=Aiplk::getMestoFromProgramma($p);
        if(!empty($aRes)){
          foreach($aRes as $_userId=>$_aRes){
            $res=intval($_aRes[1]);
            $userId=$_userId;
            $aUserPrg=$p;
            if(!empty($res))break;
          }
          if(!empty($res)){
            $aUserIdFirst[$userId]=$res;
            $aUserFirstPrg[$userId]=$aUserPrg;
          }
        }
      }
      arsort($aUserIdFirst);
      $aUserIdFirst=array_slice($aUserIdFirst, 0, 10, true);

      $arResult=array();
			$arFilter=array(
				"IBLOCK_ID"=>$IBLOCK_ID_USER,
				"ID"=>array_keys($aUserIdFirst),
			);
			$arResult['ITEMS']=Aiplk::getIB($arFilter, $arSort);
      $arResult['USERS_INFO']=$aUserIdFirst;
      $arResult['DIST']=Aiplk::getDisciplina($pDisc);
      $arResult['SOREVN']=$aSorevn;
      $arResult['USER_PRG']=$aUserFirstPrg;
      
			$this->arResult=$arResult;      

      ob_start();
      require_once './templates/.default/flt_discl.phtml';
      $_discs=ob_get_clean();

      ob_start();
			$this->IncludeComponentTemplate();
      $_ret=ob_get_clean();      
      die(json_encode(array($_ret, $_discs), JSON_UNESCAPED_UNICODE));
		}else{
			$this->AbortResultCache();
		}
	}	
  public function getAGruppyDiscipl(){
    $aGruppa=Aiplk::getVozrastGuppa();
    $aDiscipl=Aiplk::getDisciplina();
    $aFilter=array();
    $ret=Aiplk::getHighloadIB(16, $aFilter, array("UF_SORT"=>"ASC"));
    foreach($ret as $k=>$v){
      $ret[$k]['UF_GRUPPA']=Aiplk::getHLXML_fromID($aGruppa, $ret[$k]['UF_GRUPPA']);
      foreach($ret[$k]['UF_DISCIPLINA'] as $kDiscl=>$aDiscl){
        $ret[$k]['UF_DISCIPLINA'][$kDiscl]=array(
          'XML_ID'=>Aiplk::getHLXML_fromID($aDiscipl, $ret[$k]['UF_DISCIPLINA'][$kDiscl]),
          'NAME'=>Aiplk::getHLXML_fromID($aDiscipl, $ret[$k]['UF_DISCIPLINA'][$kDiscl], 'UF_NAME'),
        );
      }
    }
    return $ret;
  }
}
?>