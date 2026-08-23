<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($component->ajax!='Y'){
  $aSpr=$component->getAGruppyDiscipl();          
?>
			<div id="top10_flt" class="main-filter main-filter-rating" data-type="main-filter-wrap">
				<div class="main-filter-title" data-type="main-filter">
					 Рейтинг на основе лучшего результата финала: <i class="icon-filter"></i>
				</div>			
				<div class="main-filter-wrap" data-type="main-filter-cont">
					<div class="main-filter-item">
						<div class="main-filter-item-title">
							 Группы:
						</div>
						<ul id="top10_flt_gruppy" class="main-filter-item-wrap">
              <?$flFirst='muzh';$aDisc=array();foreach($aSpr as $k=>$v){?>
                <li data-id="<?=$v['UF_GRUPPA']?>" class="main-filter-item-option <?=(($flFirst==$v['UF_GRUPPA'])?'active':'')?>"><?=$v['UF_NAME']?></li>
              <?
                if($flFirst==$v['UF_GRUPPA'])$aDisc=$v['UF_DISCIPLINA'];
              }
              ?>
              <?/*
							<li data-id="muzh" class="main-filter-item-option active">Мужчины</li>
							<li data-id="zhen" class="main-filter-item-option">Женщины</li>
              */?>
						</ul>
					</div>
					<div class="main-filter-item">
						<div class="main-filter-item-title">
							 Дисципины:
						</div>
            <div id="flt_discipl">
              <?require_once 'flt_discl.phtml'?>
            </div>
					</div>
					<div class="main-filter-item">
						<div class="main-filter-item-title">
							 Период:
						</div>
						<ul id="top10_flt_period" class="main-filter-item-wrap">
              <li data-id="cur" class="main-filter-item-option active">За текущий год </li>
							<li data-id="all" class="main-filter-item-option">	За все время </li>
						</ul>
					</div>
				</div>
			</div>						
      <div id="top10_cont" class="main-table-rating">
<?}?>
<?if($component->ajax=='Y'){?>
<?if(count($arResult['USERS_INFO'])>0){?>
				<table>
				<tbody>
				<tr class="main-table-rating-head">
					<th>
						 Место
					</th>
					<th>
						 Спортсмен
					</th>
					<th>
						 Возрастная группа
					</th>
					<th>
						 Дистанция
					</th>
					<th>
						 Соревнование
					</th>
					<th>
						 Баллы
					</th>
				</tr>
<?$i=0;foreach($arResult['USERS_INFO'] as $userId=>$ochko){$i++;$arItem=$arResult['ITEMS'][$userId];?>				
				<tr>
					<td>
						 <?=$i?>
					</td>
					<td data-sprt_id="<?=$arItem['ID']?>">
            <?$file=CFile::ResizeImageGet(Aiplk::getSprtPhoto($arItem['PROPERTIES']['SPORTSMEN']['VALUE']), array('width'=>387, 'height'=>387), BX_RESIZE_IMAGE_EXACT, true);?>
            <?if(empty($file)){?>
						  <div class="rating-photo"><img src="/local/templates/2/img/avatar.png" alt="фото"></div>
            <?}else{?>
                <div class="rating-photo"><img src="<?=$file['src']?>" alt="фото"></div>
            <?}?>
						<div class="rating-info">
							<div class="rating-fio">
								 <?=Aiplk::getFIO($arItem['PROPERTIES']['SPORTSMEN']['VALUE'])?>
							</div>
							<div class="rating-geo">
                <?=Aiplk::getRegionTitle($arItem)['txt']?>								 
							</div>
						</div>
					</td>
					<td data-prg_id="<?=$arResult['USER_PRG'][$arItem['ID']]['ID']?>"><?=Aiplk::getVozrastGuppa($arItem['PROPERTIES']['VOZRAST_GRUPPA']['VALUE'])['NAME']?></td>
					<td><?=$arResult['DIST']['UF_DESCRIPTION']?></td>
					<td>
						<div class="rating-event">
							<?=$arResult['SOREVN'][$arItem['PROPERTIES']['ID_SOREVN']['VALUE']]['NAME']?>
						</div>
						<div class="rating-event-time">
              <?=ConvertDateTime($arResult['SOREVN'][$arItem['PROPERTIES']['ID_SOREVN']['VALUE']]['DATE_ACTIVE_FROM'], "DD.MM.YYYY", "ru") ?> - 
              <?=ConvertDateTime($arResult['SOREVN'][$arItem['PROPERTIES']['ID_SOREVN']['VALUE']]['DATE_ACTIVE_TO'], "DD.MM.YYYY", "ru")?>
						</div>
						<div class="rating-event-geo">
							 <?=Aiplk::getRegionTitle($arResult['SOREVN'][$arItem['PROPERTIES']['ID_SOREVN']['VALUE']])['txt']?>
						</div>
					</td>
					<td><?=$ochko?></td>
				</tr>
<?}?>				
				</tbody>
				</table>
        <?}else{?>
          <div>
            <br>  
            <br>  
<br>  
Таких пока нет</div>
<?}?>


<?}else{?>
  <div class="overlay_loading">
    <svg class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
      <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
    </svg>
  </div>
<?}?>

<?if($component->ajax!='Y'){?>
</div>
<?}?>