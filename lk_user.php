<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$APPLICATION->SetPageProperty("title", "Общероссийская ФСОО \"Спортивное метание ножа\"");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("Главная страница");
$APPLICATION->AddChainItem('Личный кабинет');
?><div class="item-list">
	<h1 class="block-title">Мероприятия
    <?//echo Aiplk::getStartPage(), ' ', ((CSite::InGroup(array(1)))?'admin':'')?>
    <span> 
    <?if(Aiplk::getStartPage()=='org'){?>
      <a href="#" id="object_add" class="btn btn-light"><i class="bx bx-plus"></i>Добавить</a>
    <?}?>  
    </span>
  </h1>
  <?$aSorevn=Aiplk::getSorevn();if(empty($aSorevn)){?>
    <div>
      <br>
      <big>Не найдено :(</big>
    </div>
  <?}?>
	<div class="merop_list_cont">
  <?
    $aDol=Aiplk::getDolzhnostSudi();
    $aOcenka=Aiplk::getOcenkaSudi();
    $aDisc=Aiplk::getDisciplina();
    $aVozrgruppa=Aiplk::getVozrastGuppa();
    $aEtap=Aiplk::getEtap();
    $aRazryad=Aiplk::getRazryad();
    $aRazryadId=array();
    foreach($aRazryad as $row)$aRazryadId[$row['ID']]=$row;

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
          </div>	
        
          <?// or (Aiplk::getStartPage()=='sud' and Aiplk::isGlavSud($aItem['ID']))?>
          <?if(Aiplk::getStartPage()=='org' /*or CSite::InGroup(array(1))*/){?>
          <div>
            <a data-id="<?=$aItem['ID']?>" class="lk_sorevn_edit btn btn-primary btn-sm" href="#">Редактировать</a> 
            <a data-id="<?=$aItem['ID']?>" class="lk_sorevn_del btn btn-primary btn-sm" href="#">Удалить</a>
          </div>
          <?}?>
        <?}?>
			</div>
      <div class="sent_error"><div></div></div>
		</div>
  <?}?>
	</div>
  
  
<?$aSorevn=Aiplk::getSorevn(false, 'closed', false)?>
<?if(!empty($aSorevn) and Aiplk::getStartPage()=='sport'){?>
  <h1>Мои результаты</h1>
  <div id="finished_sprt_cont"><?require_once 'finished_sportsmen.php'?></div>
<?}?>
<?if(!empty($aSorevn) and Aiplk::getStartPage()=='sud'){?>
  <h1>Завершенные мероприятия</h1>
  <div id="finished_sprt_cont"><?require_once 'finished_sud.php'?></div>
<?}?>
<?if(!empty($aSorevn) and Aiplk::getStartPage()=='org'){?>
  <h1>Завершенные мероприятия</h1>
  <div id="finished_sprt_cont"><?require_once 'finished_org.php'?></div>
<?}?>

  <?$APPLICATION->IncludeFile(SITE_DIR.'/include/sorevn/add.php')?>
  <?$APPLICATION->IncludeFile(SITE_DIR.'/include/sorevn/edit.php')?>
  <?$APPLICATION->IncludeFile(SITE_DIR.'/include/sorevn/del.php')?>
  <?$APPLICATION->IncludeFile(SITE_DIR.'/include/sorevn/sud.php')?>
  <?$APPLICATION->IncludeFile(SITE_DIR.'/include/sorevn/programmy.php')?>
  <?$APPLICATION->IncludeFile(SITE_DIR.'/include/sorevn/reg.php')?>
  <?$APPLICATION->IncludeFile(SITE_DIR.'/include/sorevn/protokoly.php')?>
  <?$APPLICATION->IncludeFile(SITE_DIR.'/include/sorevn/otchety.php')?>

</div>

<div class="popup popup-sent">
	<div class="popup__bgd">
	</div>
	<div class="popup__content">
		<div class="popup__close">
 <i class="bx bx-menu"></i>
		</div>
		<h2>Сохранено</h2>
		<p>
		</p>
		<div class="popup__body">
 <button type="button" class="btn btn-primary btn-lg popup__close_button">Закрыть</button>
		</div>
	</div>
</div>