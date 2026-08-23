<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($component->ajax!='Y'){?>
			<div id="meropr_flt" class="main-filter" data-type="main-filter-wrap">
				<div class="main-filter-title" data-type="main-filter">
					 Фильтр: <i class="icon-filter"></i>
				</div>
				<div class="main-filter-wrap" data-type="main-filter-cont">
					<div class="main-filter-item">
						<div class="main-filter-item-title">
							 Статус:
						</div>
						<ul id="meropr_flt_status" class="main-filter-item-wrap">
							<li data-id="all" class="main-filter-item-option active">Все соревнования </li>
							<li data-id="Y" class="main-filter-item-option">Завершено </li>
							<li data-id="N" class="main-filter-item-option">Этап регистрации </li>
						</ul>
					</div>
					<div style="display:none" class="main-filter-item">
						<div class="main-filter-item-title">
							 Место проведения:
						</div>
						<ul id="meropr_flt_mesto" class="main-filter-item-wrap">
							<li data-id="all" class="main-filter-item-option active">Все регионы</li>
              <?foreach($arResult['REGIONS'] as $region=>$v){?>
							  <li data-id="<?=$region?>" class="main-filter-item-option"><?=$region?></li>
              <?}?>
						</ul>
					</div>
					<div class="main-filter-item">
						<div class="main-filter-item-title">
							 Период:
						</div>
						<ul id="meropr_flt_period" class="main-filter-item-wrap">
							<li class="main-filter-item-option active">
							За все время </li>
							<li class="main-filter-item-option">
							За текущий год<br>
							</li>
						</ul>
					</div>
				</div>
			</div>
      <div id="meropr_cont" class="main-events-list">
<?}?>
<?if($component->ajax=='Y'){
if(empty($arResult["ITEMS"]))echo '<div class="not_found">Мероприятий не найдено</div>'  
?>
<?foreach($arResult["ITEMS"] as $arItem){?>
				<div class="main-event">
					<div class="main-event-img">
            <?$file=CFile::ResizeImageGet($arItem['PROPERTIES']['AFISHA']['VALUE'], array('width'=>387, 'height'=>387), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
            <?if(empty($file['src'])){?>
						  <img alt="<?=$arItem['NAME']?>" src="/local/templates/2/img/event-img.png">
            <?}else{?>
						  <img alt="<?=$arItem['NAME']?>" src="<?=$file['src']?>">
            <?}?>
					</div>
					<div class="main-event-desc">
						<div class="main-event-title">
							 <?=$arItem['NAME']?>
						</div>
            <?//v($arItem['PROPERTIES']['REGISTRACIYA_OFF'])?>
						<?if($arItem['PROPERTIES']['STATUS']['VALUE']=='closed'){?>
						  <div class="main-event-stat finished">Мероприятие завершено</div>
            <?}else{?>
						  <div class="main-event-stat">Этап регистрации</div>
						<?}?>
						<div class="main-event-info">
							<div class="main-event-info-item">
 <i class="icon-calendar"></i>
								<?=ConvertDateTime($arItem['DATE_ACTIVE_FROM'], "DD.MM.YYYY", "ru") ?> - <?= ConvertDateTime($arItem['DATE_ACTIVE_TO'], "DD.MM.YYYY", "ru")?>
							</div>
							<div class="main-event-info-item">
 <i class="icon-geo"></i>
								<?=Aiplk::getRegionTitle($arItem)['txt']?>
							</div>
						</div>
						<div class="main-event-txt no-limit">
              <i class="icon-comment"></i>
							<p>
								 <?=$arItem['PROPERTIES']['DESCR']['VALUE']?>
							</p>
						</div>
						<div class="main-event-btns">
							<?/*<div class="main-event-btn"><i class="icon-bell"></i>Уведомите меня</?div>*/?>
							<div class="main-event-btn">
                <a style="color:black" href="lk.php">Протоколы</a>
              </div>
						</div>
					</div>
				</div>



<?}?>
        <div class="main-events-nav">
<?/*		<div class="main-events-more">
			 Показать еще <i class="icon-right-arr"></i>
		</div>*/?>

<?=$arResult['NAV']?>

</div>

<?}else{?>
  <div class="overlay_loading">
    <svg class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
      <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
    </svg>
  </div>


</div>



 <?}?>