<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Протоколы");
$APPLICATION->SetPageProperty("title", "Протоколы");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$ID_SOREVN=intval($_REQUEST['id_sorevn']);
if(empty($ID_SOREVN))LocalRedirect("/404.php", "404 Not Found");
$userGlSud=Aiplk::getGlavnSud($ID_SOREVN);
$aSorevn=Aiplk::getSorevn($ID_SOREVN);
if($aSorevn['PROPERTIES']['STATUS']['VALUE']!='process')$closed=true;else $closed=false;
if(($GLOBALS['USER']->GetID()==$userGlSud['PROPERTIES']['SUDYA']['VALUE'] or Aiplk::getStartPage()=='org'/* or CSite::InGroup(array(1))*/) and !$closed)$me=true;else $me=false;
if(!Aiplk::isEditable($id))$me=false;
?>
<?//var_dump('<pre>',$aSorevn,'</pre>')?>
<?/*<input title="Стендов" value="<?=$aItem['PROPERTIES']['KOLVO_STENDOV']['VALUE']?>" name="SUD[KOLVO_STENDOV][]" required placeholder="Стендов" class="form-control form-control-lg" type="number">*/?>
<?if(empty($aSorevn)){?>
  <big>Нет данных</big>
<?}else{?>
<div class="item-list">
  <h1 class="block-title">СПРАВКА о количестве регионов на Чемпионате "<?=$aSorevn['NAME']?>"</h1>
</div>  
<?//v(Aiplk::getRegionTitle($aSorevn))?>
<?/*<div class="bx-auth-profile"><h3><?=$aSorevn['NAME']?></h3></div>*/?>
<div class="prot_title_cont dubl">
  <div style="min-width:49%;"><span>Вид спорта:</span> <span>спортивное метание ножа</span></div>
  <div style="min-width:49%;"><span>Место проведения:</span> <span><?=Aiplk::getRegionTitle($aSorevn)['txt']?></span></div>
  <div style="min-width:49%;"><span>№ мероприятия:</span> <span>2009100017017407</span></div>
  <div style="min-width:49%;"><span>Даты проведения:</span> <span><?=$aSorevn['ACTIVE_FROM']?> - <?=$aSorevn['ACTIVE_TO']?></span></div>
</div>
<ol>
 <?$areg=array();
  foreach(Aiplk::getSportsmeny($ID_SOREVN) as $row)$areg[$row['PROPERTIES']['REGION']['VALUE']]=$row['PROPERTIES']['REGION']['VALUE'];
  foreach($areg as $row){?>
  <li><?=$row?></li>
<?}?>
</ol>
<div class="prot_title_cont">
  <div><span>Главный спортивный судья:</span> <span><?=Aiplk::getFIO($userGlSud['USER_SUDYA'])?></span></div>
</div> 
 <?}?> 
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>