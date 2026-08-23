<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
IncludeTemplateLangFile(__FILE__);
use Bitrix\Main\Page\Asset;
//CJSCore::Init(array('jquery3'));
global $USER;

/** @var array $arResult */
/** @var array $arParams */

if (!CModule::IncludeModule("iblock"))
    return;

// Собираем данные пользователя
$rsUser=CUser::GetByID($USER->GetID());
$arUser=$rsUser->Fetch();
?>
<?php
$arGroupAvalaible=array_merge(Aiplk::$groupIds, array(1));
$arGroups=CUser::GetUserGroup($USER->GetID());
//var_dump('<pre>', $arGroups);die();
$result_intersect = array_intersect($arGroupAvalaible, $arGroups);
if ((empty($result_intersect) && $APPLICATION->GetCurPage(false) != '/login.php')) {
  if($APPLICATION->GetCurPage(false)!='/auth/' or ($APPLICATION->GetCurPage(false)=='/login.php' and empty($_GET['forgot_password'])))LocalRedirect("/login.php" );
}

$curPage = $APPLICATION->GetCurPage(true);
$assets = \Bitrix\Main\Page\Asset::getInstance();

$GLOBALS['cur_page']='';
if($APPLICATION->GetCurPage(false)=='/login.php')$GLOBALS['cur_page']="page-login";

$arGroups=CUser::GetUserGroup($GLOBALS['USER']->GetID());
if(in_array(11, $arGroups))Aiplk::setGroup(11);
if(in_array(12, $arGroups))Aiplk::setGroup(12);

if(isset($_GET['logout'])){
  $GLOBALS['USER']->Logout();
  LocalRedirect("/");
}else{
  if(
    $GLOBALS['USER']->IsAuthorized() and
    !in_array(12, $arGroups) and
    !in_array(11, $arGroups) and
    $arUser['UF_DOPUSK']!='8'
  )die('
  <center>
    Спасибо за регистрацию, ожидайте подтверждения со стороны региональной спортивной федерации ('.$arUser['UF_REGION'].')
    <a style="background: none !important;display: flex;justify-content: center;align-items: center;" href="/lk/?logout=yes" class="nav_link"><span class="nav_name">Выход</span> </a>
  </center>
  ');
}
?><!doctype html>
<html lang="ru">
<head>
  <?$APPLICATION->ShowHead();?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <title><? $APPLICATION->ShowTitle(); ?></title>
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>
  <?php
    // $assets->addCss('https://cdn.datatables.net/responsive/3.0.0/css/responsive.bootstrap5.css');
    // $assets->addCss('https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css');
    // $assets->addCss('https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.css');
    // $assets->addCss('https://cdn.datatables.net/searchpanes/2.3.1/css/searchPanes.dataTables.css');
    // $assets->addCss('https://cdn.datatables.net/select/2.0.0/css/select.dataTables.css');
    // $assets->addCss('https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css');

    // $assets->addCss(SITE_TEMPLATE_PATH . '/vendors/bootstrap/bootstrap-icons.css');
		 $assets->addCss(SITE_TEMPLATE_PATH . '/css/bootstrap.min.css');
		 $assets->addCss('https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css');
     //$assets->addCss(SITE_TEMPLATE_PATH.'/css/boxicons.min.css');
     $assets->addCss(SITE_TEMPLATE_PATH . '/css/custom.css');
     $assets->addCss(SITE_TEMPLATE_PATH . '/js/select2/select2.css');
     $assets->addCss(SITE_TEMPLATE_PATH . '/css/redis.css');
     $assets->addJs(SITE_TEMPLATE_PATH . '/js/jquery.min.js');
     $assets->addJs(SITE_TEMPLATE_PATH . '/js/jquery.cookie.js');
     $assets->addJs(SITE_TEMPLATE_PATH . '/js/select2/select2.js');
  ?>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<!-- Yandex.RTB -->
<script>window.yaContextCb=window.yaContextCb||[]</script>
<script src="https://yandex.ru/ads/system/context.js" async></script>

</head>
<body id="body-pd" class="body-pd <?=$GLOBALS['cur_page']?>">
<?if(isset($_GET['p']))$APPLICATION->ShowPanel();?>
<?if($GLOBALS['cur_page']!="page-login"){?>



<header id="header" class="d-flex align-items-center pb-3 mb-5 header body-pd">
    <div class="header_toggle border-bottom">      
        <i class='bx bx-menu' id="header-toggle"></i>
          &nbsp;
          &nbsp;
          &nbsp;
          <div class="bonus">
                <!-- <div class="bonus-title"> -->
                    <!-- <i class='bx bx-wallet'></i> -->
                <!-- </div> -->
                <div id="main_h1" class="bonus-value">
                   <?=((Aiplk::getStartPage(1)==9)?'Организатор':'')?>
                   <?=((Aiplk::getStartPage(1)==7)?'Судья':'')?>
                   <?=((Aiplk::getStartPage(1)==8)?'Спортсмен':'')?>
                   <?=((Aiplk::getStartPage(1)==10)?'Тренер':'')?>
                   <?=((Aiplk::getStartPage(1)==11)?'Федеральная организация':'')?>
                   <?=((Aiplk::getStartPage(1)==12)?Aiplk::getRegionTitle($arUser)['r']:'')?>
                </div>
                <div class="bonus-action">
                  <div class="lea_menuactive" style="display:flex;margin-top:2px">
                    <?if(Aiplk::getStartPage(1)!=11 and Aiplk::getStartPage(1)!=12 and Aiplk::getStartPage(1)!=10){?>
                              <?if(Aiplk::getStartPage()!='sud'){?>
                                <?if($APPLICATION->GetCurPage(false)=='/calendar.php'){?>
                                  <a href="/lk.php" class="nav_link nav_list"><i class="bx-x3"></i><span>Личный кабинет</span></a>                      
                                <?}else{?>
                                  <a href="/calendar.php" class="nav_link"><i class="bx bx-wallet"></i><span>Календарь</span></a>                      
                                <?}?>
                              <?}else{?>
                                  <a href="#p" style="visibility:hidden" class="nav_link"><i class="bx bx-wallet"></i><span></span></a>
                              <?}?>
                    <?}else{?>
                        <span style="color: #03a9ff;" class="nav_link"><?=$APPLICATION->ShowTitle(false)?></span>
                    <?}?>
                  </div>
                </div>
          </div>
        </div>
        <br>
        <hr>
<?/*
    <div class="header_login">
        <a href="/profile/" title="Профиль пользователя">
            <i class="bx bx-user nav_icon"></i>
        </a>
        <div class="header_login-info">
            <a href="/profile/" title="Профиль пользователя">
                <div class="header_login-name">
                  <span class="btn"><?=$arUser['LAST_NAME']?> <?=$arUser['NAME']?> <?=$arUser['SECOND_NAME']?></span>
                </div>
                <div class="header_login-company"> </div>
            </a>
        </div>
        <div class="header_login-exit"><a href="/lk/?logout=yes&<?=bitrix_sessid_get()?>"> <i class="bx bx-log-out nav_icon"></i> </a></div>
    </div>
*/?>
</header>


<?
//
//lk_ross
//
if(Aiplk::getStartPage()=='lk_ross'){?>
<div class="l-navbar show" id="nav-bar">
 	<nav class="nav" style="height:auto">
    <div class="nav_list lea_menuactive"> 
      <a class="nav_link" href="/lk.php">
        <img src="<?=SITE_TEMPLATE_PATH?>/img/lk2/ico_regiony.png" alt="">
        <span>Регионы</span>
      </a>      
      <a class="nav_link" href="/lk2_sorevnovaniya.php">
        <img src="<?=SITE_TEMPLATE_PATH?>/img/lk2/ico_sorevn.png" alt="">
        <span>Соревнования</span>
      </a>
      <br>
      <a class="nav_link" href="/lk2_bilety.php">
        <img src="<?=SITE_TEMPLATE_PATH?>/img/lk2/ico_bilety.png" alt="">
        <span>Билеты</span>
      </a>
      <a class="nav_link" href="/profile/">
        <img src="<?=SITE_TEMPLATE_PATH?>/img/lk2/ico_nastro.png" alt="">
        <span>Настройки</span>
      </a>
    </div>
  </nav>
  <div class="rekl_block">
    <div class="is_desktop">
      <!-- Yandex.RTB R-A-15333226-1 -->
      <div id="yandex_rtb_R-A-15333226-1"></div>
      <script>
      window.yaContextCb.push(() => {
      Ya.Context.AdvManager.render({
      "blockId": "R-A-15333226-1",
      "renderTo": "yandex_rtb_R-A-15333226-1"
      })
      })
      </script>
    </div>  
  </div>



</div>
<?
//
//lk_region
//
}elseif(Aiplk::getStartPage()=='lk_region'){?>
<div class="l-navbar show" id="nav-bar">
  <nav class="nav" style="height:auto">
    <div class="nav_list lea_menuactive"> 
      <a class="nav_link" href="/lk.php">
        <img src="<?=SITE_TEMPLATE_PATH?>/img/lk2/ico_kalendar.png" alt="">
        <span>Календарь</span>
      </a>      
      <a class="nav_link" href="/lk2_sprt.php?group=7">
        <img src="<?=SITE_TEMPLATE_PATH?>/img/lk2/ico_sud.png" alt="">
        <span>Судьи</span>
      </a>
      <a class="nav_link" href="/lk2_sprt.php?group=8">
        <img src="<?=SITE_TEMPLATE_PATH?>/img/lk2/ico_sprt.png" alt="">
        <span>Спортсмены</span>
      </a>
      <a class="nav_link" href="/lk2_sprt.php?group=10">
        <img src="<?=SITE_TEMPLATE_PATH?>/img/lk2/ico_trenery.png" alt="">
        <span>Тренеры</span>
      </a>
      <br>
      <a class="nav_link" href="/lk2_bilety.php">
        <img src="<?=SITE_TEMPLATE_PATH?>/img/lk2/ico_bilety.png" alt="">
        <span>Билеты</span>
      </a>
      <a class="nav_link" href="/profile/">
        <img src="<?=SITE_TEMPLATE_PATH?>/img/lk2/ico_nastro.png" alt="">
        <span>Настройки</span>
      </a>
    </div>
  </nav>
  <div class="rekl_block">
    <div class="is_desktop">
      <!-- Yandex.RTB R-A-15333226-1 -->
      <div id="yandex_rtb_R-A-15333226-1"></div>
      <script>
      window.yaContextCb.push(() => {
      Ya.Context.AdvManager.render({
      "blockId": "R-A-15333226-1",
      "renderTo": "yandex_rtb_R-A-15333226-1"
      })
      })
      </script>
    </div>  
  </div>


</div>  
<?}elseif(Aiplk::getStartPage()=='trener'){?>
<div class="l-navbar show" id="nav-bar">
  <nav class="nav" style="height:auto">
    <div class="nav_list"> 
      <div class="lea_menuactive">
      <a class="nav_link" href="/lk.php">
        <img src="<?=SITE_TEMPLATE_PATH?>/img/lk2/ico_kalendar.png" alt="">
        <span>Календарь</span>
      </a>      
      <a class="nav_link" href="/lk2_sprt_tren.php">
        <img src="<?=SITE_TEMPLATE_PATH?>/img/lk2/ico_sprt.png" alt="">
        <span>Спортсмены</span>
      </a>
      </div>
      <br>

              <?if(CSite::InGroup(array(7))){?>
                <a data-status="7" class="nav_link lk_change_status <?=((Aiplk::getStartPage(1)=='7')?'btn-primary':'')?>" href="/lk.php"><i class="bx bx-x2 nav_icon"></i>
                  <span>Судья</span>            
                </a>
              <?}?>
              <?if(CSite::InGroup(array(8))){?>
                <a data-status="8" class="nav_link lk_change_status <?=((Aiplk::getStartPage(1)=='8')?'btn-primary':'')?>" href="/lk.php"><i class="bx bx-x3 nav_icon"></i>
                  <span>Спортсмен</span>
                </a>
              <?}?>
              <?if(CSite::InGroup(array(10))){?>
                <a data-status="10" class="<?=((Aiplk::getStartPage(1)==10)?'active':'')?> nav_link lk_change_status <?=((Aiplk::getStartPage(1)=='10')?'btn-primary':'')?>" href="/lk.php"><i class="bx bx-x4 nav_icon"></i>
                  <span>Тренер</span>
                </a>
              <?}?>

      <a class="nav_link" href="/lk2_bilety.php">
        <img src="<?=SITE_TEMPLATE_PATH?>/img/lk2/ico_bilety.png" alt="">
        <span>Билеты</span>
      </a>
      <a class="nav_link" href="/profile/">
        <img src="<?=SITE_TEMPLATE_PATH?>/img/lk2/ico_nastro.png" alt="">
        <span>Настройки</span>
      </a>
    </div>
  </nav>
  <div class="rekl_block">
    <div class="is_desktop">
      <!-- Yandex.RTB R-A-15333226-1 -->
      <div id="yandex_rtb_R-A-15333226-1"></div>
      <script>
      window.yaContextCb.push(() => {
      Ya.Context.AdvManager.render({
      "blockId": "R-A-15333226-1",
      "renderTo": "yandex_rtb_R-A-15333226-1"
      })
      })
      </script>
    </div>  
  </div>

</div>  
<?
//
//lk всех остальных
//
}else{?>
<div class="l-navbar show" id="nav-bar">
    <nav class="nav" style="height:auto">
      
        <div class="lea_menuactive111">
          <a href="/" class="nav_logo">
                <!-- <img src="/local/templates/lk/img/logoW2.png" class="img-fluid logoL" alt=""> -->
                <!-- <img src="/local/templates/lk/img/logoW2_small.png" class="img-fluid logoS" alt=""> -->
          </a>
          <div class="nav_list">                          
            <?//if(Aiplk::getStartPage(1)=='9'){//организаторы?>

              <?if(CSite::InGroup(array(9))){?>
                <a data-status="9" class="<?=((Aiplk::getStartPage(1)==9)?'active':'')?> nav_link lk_change_status <?=((Aiplk::getStartPage(1)=='9')?'btn-primary':'')?>" href="/lk.php"><i class="bx bx-x1 nav_icon"></i>
                  <span>Организатор</span>
                </a>
              <?}?>
              <?if(CSite::InGroup(array(7))){?>
                <a data-status="7" class="<?=((Aiplk::getStartPage(1)==7)?'active':'')?> nav_link lk_change_status <?=((Aiplk::getStartPage(1)=='7')?'btn-primary':'')?>" href="/lk.php"><i class="bx bx-x2 nav_icon"></i>
                  <span>Судья</span>            
                </a>
              <?}?>
              <?if(CSite::InGroup(array(8))){?>
                <a data-status="8" class="<?=((Aiplk::getStartPage(1)==8)?'active':'')?> nav_link lk_change_status <?=((Aiplk::getStartPage(1)=='8')?'btn-primary':'')?>" href="/lk.php"><i class="bx bx-x3 nav_icon"></i>
                  <span>Спортсмен</span>
                </a>
              <?}?>
              <?if(CSite::InGroup(array(10))){?>
                <a data-status="10" class="<?=((Aiplk::getStartPage(1)==10)?'active':'')?> nav_link lk_change_status <?=((Aiplk::getStartPage(1)=='10')?'btn-primary':'')?>" href="/lk.php"><i class="bx bx-x4 nav_icon"></i>
                  <span>Тренер</span>
                </a>
              <?}?>
              <?if(CSite::InGroup(array(8))){?>
                <a href="/lk2_strahovka.php" class="nav_link"><i class="bx bx-shield-alt-2 nav_icon"></i>
                  <span>Страховка</span>
                </a>
              <?}?>
              <a href="/profile/" class="nav_link  "><i class='bx bx-cog nav_icon'></i><span>Настройки</span></a>
					</div>
          <div class="rekl_block">


          <div class="is_desktop">
            
<!-- Yandex.RTB R-A-15333226-1 -->
<div id="yandex_rtb_R-A-15333226-1"></div>
<script>
window.yaContextCb.push(() => {
    Ya.Context.AdvManager.render({
        "blockId": "R-A-15333226-1",
        "renderTo": "yandex_rtb_R-A-15333226-1"
    })
})
</script>
          </div>

          </div>
        </div>

        <div class="sidebar-bottom lea_menuactive nav_list">
            <!-- <h4>Мы в социальных сетях</h4> -->
            <!-- <ul>
                <li><a href="#" target="_blank"><i class='bx bxl-vk'></i></a></li>
                <li><a href="#" target="_blank"><i class='bx bxl-telegram'></i></a></li>
            </ul> -->

            <!-- <hr> -->

            <!-- <div class="slogan">#nbsp</div> -->

            <!-- <hr> -->
            
            <?/*
            <a href="/lk/?logout=yes&<?=bitrix_sessid_get()?>" class="nav_link"> <i class="bx bx-log-out nav_icon"></i> <span class="nav_name">Выход</span> </a>
            */?>
        </div>
    </nav>
</div>
<?}?>


<div class="main-content">
  <div class="wrapper-inner">
    <div class="status_select_cont">
      <?/*
    <?if(CSite::InGroup(array(9))){?><a data-status="9" class="lk_change_status btn <?=((Aiplk::getStartPage(1)=='9')?'btn-primary':'')?>" href="#">Организатор</a><?}?>
    <?if(CSite::InGroup(array(7))){?><a data-status="7" class="lk_change_status btn <?=((Aiplk::getStartPage(1)=='7')?'btn-primary':'')?>" href="#">Судья</a><?}?>
    <?if(CSite::InGroup(array(8))){?><a data-status="8" class="lk_change_status btn <?=((Aiplk::getStartPage(1)=='8')?'btn-primary':'')?>" href="#">Спортсмен</a><?}?>
    <?if(CSite::InGroup(array(10))){?><a data-status="10" class="lk_change_status btn <?=((Aiplk::getStartPage(1)=='10')?'btn-primary':'')?>" href="#">Тренер</a><?}?>
      */?>
    </div>
    <!--region breadcrumb-->
    <!-- <h1>Мероприятия</h1> -->
    <nav class="breadcrumbs">
      <?$APPLICATION->IncludeComponent(
        "bitrix:breadcrumb",
        "universal",
        array(
          "START_FROM" => "1",
          "PATH" => "",
          "SITE_ID" => "s1"
        ),
        false,
        array('HIDE_ICONS' => 'Y')
      ); ?>
            </nav>
<?}?>



            <div class="is_mobile">

<!-- Yandex.RTB R-A-15333226-2 -->
<script>
window.yaContextCb.push(() => {
    Ya.Context.AdvManager.render({
        "blockId": "R-A-15333226-2",
        "type": "fullscreen",
        "platform": "touch"
    })
})
</script>  
</div>