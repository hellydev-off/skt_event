<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
class AIPMeropr extends CBitrixComponent{
  
  static $nPageSize=3;
  public $ajax=false;
  public $arResult=array();

	public function executeComponent(){
    if(isset($_REQUEST['ajax'])){
      $this->ajax='Y';
    }else{
      //$this->IncludeComponentTemplate();
      //return false;
    }
		$IBLOCK_ID_SOREVN=3;
		$pPeriod=addslashes($_REQUEST['meropr_flt_period']);
		$pMesto=addslashes($_REQUEST['meropr_flt_mesto']);
		$pRegoff=addslashes($_REQUEST['meropr_flt_status']);

		if(1==1 or CModule::IncludeModule('iblock') && $this->StartResultCache(false, $pGruppa.$pDisc.$pPeriod)){
			$arSort=array("DATE_CREATE"=>"DESC");
			$arFilter=array(
				"IBLOCK_ID"=>$IBLOCK_ID_SOREVN,
				"ACTIVE"=>'Y',
				"<=DATE_CREATE"=>date('d.m.Y H:i:s'),
			);
      if($pMesto!='all')$arFilter['PROPERTY_REGION']=$pMesto;
      if($pRegoff=='Y')$arFilter['PROPERTY_STATUS']='closed';
      if($pRegoff=='N')$arFilter['!PROPERTY_REGISTRACIYA_OFF']='1';
      if($pPeriod!='all')$arFilter['>=DATE_CREATE']='01.01.'.(date('Y')).' 00:00:00';
    
//v($arFilter);
    $res2=CIBlockElement::GetList($arSort, $arFilter, false);
    
    $aRegions=array();
    while($arRow=$res2->GetNextElement()){
      $aProps=$arRow->GetProperties(Array(),Array('ACTIVE'=>'Y','EMPTY'=>'N'));
      $aRegions[$aProps['REGION']['VALUE']]='';
    }
    ksort($aRegions);

    $res=CIBlockElement::GetList($arSort, $arFilter, false, array("nPageSize"=>self::$nPageSize, "bShowAll"=>false));

    $res->NavStart(0);
    $res->nPageWindow=3;
    $nav=$res->GetPageNavStringEx($navComponentObject, '', 'modern', false, null, array("BASE_LINK"=>'?ajax=Y'));
    //v($arRegions);

    while($arRow=$res->GetNextElement()){
      $aFields=$arRow->GetFields();
      $aProps=$arRow->GetProperties(Array(),Array('ACTIVE'=>'Y','EMPTY'=>'N'));
      $aFields['PROPERTIES']=$aProps;
      $arResult[$aFields['ID']]=$aFields;
    }





      
      // $aRegions=array();
      // foreach($arResult as $k=>$v){
      //   $aRegions[$v['PROPERTIES']['REGION']['VALUE']]='';
      // }
      // ksort($aRegions);

			$this->arResult['ITEMS']=$arResult;
      $this->arResult['REGIONS']=$aRegions;
      $this->arResult['NAV']=$nav;
			$this->IncludeComponentTemplate();
		}else{
			$this->AbortResultCache();
		}
	}	
}
?>