<?php
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
if(!in_array(10, $arGroups))die();
$APPLICATION->SetTitle('Календарь');
$aSorevn=Aiplk::getSorevn(false, 'process', true);
?>
<div class="h1_cont">
  <span>
    <h1>Календарь соревнований</h1>
  </span>  
</div>
<div class="merop_list_cont">
<?foreach($aSorevn as $aItem){
  $file=CFile::ResizeImageGet($aItem['PROPERTIES']['AFISHA']['VALUE'], array('width'=>300, 'height'=>300), BX_RESIZE_IMAGE_EXACT, true); 
?>  
  <div class="merop_item_cont">
     <div class="merop_photo">
      <img class="mph_img" src="<?=$file['src']?>" alt="">
      <?/*<div class="mph_btn_cont">
        <span class="block-title"><a href="#" class="btn btn-light mph_photo_add">Редактировать</a></span>
        <span class="block-title"><a href="#" class="btn btn-light mph_photo_del">Удалить</a></span>
      </div>*/?>
    </div>    
  	<div class="merop_item">
			<div class="h4"><?=$aItem['NAME']?></div>
			<div class="merop_daty">
				<img src="/local/templates/lk/img/data_proved.png"> Даты проведения: <span><?=ConvertDateTime($aItem['DATE_ACTIVE_FROM'], "DD.MM.YYYY", "ru") ?> - <?= ConvertDateTime($aItem['DATE_ACTIVE_TO'], "DD.MM.YYYY", "ru")?></span>
			</div>
			<div class="merop_daty">
        <img src="/local/templates/lk/img/mesto_proved.png"> Место проведения: <span><?=Aiplk::getRegionTitle($aItem)['txt']?></span>
			</div>
      <div class="merop_btn_cont">
        <div>
          <a data-id="<?=$aItem['ID']?>" class="btn btn-primary btn-sm lk_sorevn_protokoly" href="#">Протоколы</a>
          <?if(Aiplk::isGlavSud($aItem['ID'])){?>
            <a data-id="<?=$aItem['ID']?>" class="lk_otchety btn btn-primary btn-sm" href="#">Отчеты</a>
          <?}?>
        </div>
   		</div>
      <div class="sent_error"><div></div></div>
		</div>
  </div>
  <?}?>
</div>
<?$APPLICATION->IncludeFile(SITE_DIR.'/include/sorevn/protokoly.php')?>
<?$APPLICATION->IncludeFile(SITE_DIR.'/include/sorevn/otchety.php')?>