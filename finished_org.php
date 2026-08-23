<?php
//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?>

	<div class="merop_list_cont finished_list">
  <?
    foreach($aSorevn as $aItem){?>
		<div class="merop_item">
			<div class="h4"><?=$aItem['NAME']?></div>
			<div class="merop_daty">
				<img src="/local/templates/lk/img/data_proved.png"> Даты проведения: <span><?=ConvertDateTime($aItem['DATE_ACTIVE_FROM'], "DD.MM.YYYY", "ru") ?> - <?= ConvertDateTime($aItem['DATE_ACTIVE_TO'], "DD.MM.YYYY", "ru")?></span>
			</div>
			<div class="merop_daty">
        <?//var_dump('<pre>',$aItem)?>
				<img src="/local/templates/lk/img/mesto_proved.png"> Место проведения: <span><?=Aiplk::getRegionTitle($aItem)['txt']?></span>
			</div>
      <?if(Aiplk::getStartPage()=='sud'){?>
        <?if($aDs=Aiplk::getCurrentSudDolzhnost($aItem['ID'])){?>
          <div class="main_comment"><?=implode(', ', $aDs)?></div>
        <?}?>  
      <?}?>
			<div class="merop_btn_cont">
        <?if(Aiplk::getStartPage()=='sport'){          
          //$aProgrammy=Aiplk::getProgrammy($aItem['ID'], true);  
          //$aRes=array();
          require 'index_sportsmen.php';
        }else{?>
          <div>
            <?if(Aiplk::getStartPage()!='sud'){?>
              <a data-id="<?=$aItem['ID']?>" class="lk_sorevn_sud_add btn btn-primary btn-sm" href="#">Судейская коллегия</a> 
              <a data-id="<?=$aItem['ID']?>" class="lk_sorevn_prog_add btn btn-primary btn-sm" href="#">Программа</a> 
              <a data-id="<?=$aItem['ID']?>" class="btn btn-primary btn-sm lk_sorevn_reg" href="#">Регистрация</a> 
            <?}?>
            <a data-id="<?=$aItem['ID']?>" class="btn btn-primary btn-sm lk_sorevn_protokoly" href="#">Протоколы</a> 
            <?if(Aiplk::getStartPage()!='sud'){?>
              <a data-id="<?=$aItem['ID']?>" class="lk_otchety btn btn-primary btn-sm" href="#">Отчеты</a> 
            <?}?>  
            <a data-id="<?=$aItem['ID']?>" class="lk_sorevn_edit btn btn-primary btn-sm" href="#">Инфо</a> 
          </div>	
        
          <?// or (Aiplk::getStartPage()=='sud' and Aiplk::isGlavSud($aItem['ID']))?>
          <?if(Aiplk::getStartPage()=='org' /*or CSite::InGroup(array(1))*/){?>
          <div>
            <?/*<a data-id="<?=$aItem['ID']?>" class="lk_sorevn_del btn btn-primary btn-sm" href="#">Удалить</a>*/?>
          </div>
          <?}?>
        <?}?>
			</div>
      <div class="sent_error"><div></div></div>
		</div>
  <?}?>
	</div>
