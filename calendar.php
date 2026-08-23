<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

// $url=Aiplk::getStartPage();
// if($url!='/index.php')LocalRedirect($url);

//var_dump(Aiplk::getStartPage());

// $arGroupAvalaible=array(1,9,7,8,10);
// $arGroups=CUser::GetUserGroup($USER->GetID());
// $result_intersect = array_intersect($arGroupAvalaible, $arGroups);
// if (empty($result_intersect) && $APPLICATION->GetCurPage(false) != '/login.php') {
//   if($APPLICATION->GetCurPage(false)!='/auth/')LocalRedirect("/login.php");
// }

$APPLICATION->SetPageProperty("title", "Общероссийская ФСОО \"Спортивное метание ножа\"");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("Главная страница");
$APPLICATION->AddChainItem('Личный кабинет');
?><div class="item-list">
	<h1 class="block-title">Календарь мероприятий
    <span> 
    <?/*if(Aiplk::getStartPage()=='org'){?>
      <a href="#" id="object_add" class="btn btn-light"> <i class="bx bx-plus"></i></a>
    <?}*/?>  
    </span>
  </h1>
  <?$aSorevn=Aiplk::getSorevn(false, 'process', true);if(empty($aSorevn)){?>
    <div>
      <br>
      <big>Не найдено :(</big>
    </div>
  <?}?>
	<div class="merop_list_cont">
  <?
    $aRegSorId=Aiplk::getIDsSorevnFrom();
    foreach($aSorevn as $aItem){
  ?>
		<div class="merop_item">
			<div class="h4"><?=$aItem['NAME']?></div>
			<div class="merop_daty">
				<img src="/local/templates/lk/img/data_proved.png"> Даты проведения: <span><?=ConvertDateTime($aItem['DATE_ACTIVE_FROM'], "DD.MM.YYYY", "ru") ?> - <?= ConvertDateTime($aItem['DATE_ACTIVE_TO'], "DD.MM.YYYY", "ru")?></span>
			</div>
			<div class="merop_daty">
        <?//var_dump('<pre>',$aItem)?>
				<img src="/local/templates/lk/img/mesto_proved.png"> Место проведения: <span><?=Aiplk::getRegionTitle($aItem)['txt']?></span>
			</div>
      <?if(in_array($aItem['ID'], $aRegSorId)){
        echo '<small>Зарегистрирован</small>';
      }?>      
			<div class="merop_btn_cont">
        <div>
        <?/*if(Aiplk::getStartPage()=='sport'){?>
          <a data-id="<?=$aItem['ID']?>" class="btn btn-primary btn-sm lk_sorevn_reg" href="#">Регистрация</a>
        <?}*/?>
          <a data-id="<?=$aItem['ID']?>" class="btn btn-primary btn-sm lk_sorevn_protokoly" href="#">Протоколы</a> 
        <?/*<a data-id="<?=$aItem['ID']?>" class="lk_sorevn_sud_add btn btn-primary btn-sm" href="#">Судейская коллегия</a> 
        <a data-id="<?=$aItem['ID']?>" class="lk_sorevn_prog_add btn btn-primary btn-sm" href="#">Программа</a> 
        <a data-id="<?=$aItem['ID']?>" class="lk_otchety btn btn-primary btn-sm" href="#">Отчеты</a> 
        <?// or (Aiplk::getStartPage()=='sud' and Aiplk::isGlavSud($aItem['ID']))?>
        <?if(Aiplk::getStartPage()=='org' or CSite::InGroup(array(1))){?>
          <a data-id="<?=$aItem['ID']?>" class="lk_sorevn_edit btn btn-primary btn-sm" href="#">Редактировать</a> 
          <a data-id="<?=$aItem['ID']?>" class="lk_sorevn_del btn btn-primary btn-sm" href="#">Удалить</a>
        <?}?>*/?>
        </div>
			</div>
      <div class="sent_error"><div></div></div>
		</div>
  <?}?>
	</div>

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

<script>
    $("#COMPANY_PHONE").mask("+7 999 999-99-99");
    $('.popup.popup-sent .popup__bgd, .popup.popup-sent .popup__close, .popup.popup-sent .popup__close_button').on('click', function () {
                $('.popup.popup-sent').removeClass('popup_open');
                //window.location = '/';
                location.reload();
    });
</script>

</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>