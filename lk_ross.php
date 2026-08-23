<?php
if(isset($_REQUEST['ajax']))require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
$arGroups=CUser::GetUserGroup($GLOBALS['USER']->GetID());
if(!in_array(11, $arGroups))die();
$APPLICATION->SetTitle('Регионы');
?>
<div class="h1_cont">
  <h1>Регионы</h1>
  <div>
    <div>Всего спортсменов: <span><?=count(Aiplk::getUserSportsmeny())?></span></div>
    <div>Всего тренеров: <span><?=count(Aiplk::getUserTrenery())?></span></div>
    <div>Всего судей: <span><?=count(Aiplk::getUserSudi())?></span></div>
  </div>  
</div>
<?
$aSprts=Aiplk::getUserSportsmeny(null, 12);
?>
<div class="table_cont">
  <table class="table_reg tbl_lk_ross">
  <tbody>
    <tr>
      <th style="max-width:20px">№</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(0)?>" data-field="0">Регион</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(1)?>" data-field="1">ФИО руководителя</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(2)?>" data-field="2">Телефон</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(3)?>" data-field="3">Почта</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(4)?>" data-field="4">Спортсмены</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(5)?>" data-field="5">Тренеры</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(6)?>" data-field="6">Судьи</th>
      <!-- <th></th> -->
    </tr>
<?
$_aSprts=array();
foreach($aSprts as $aItem){
  $_aReg=Aiplk::getRegionSprNew($aItem['UF_REGION_SPR']);
  $_aSprts[]=array(
    $_aReg['UF_NAME'],
    Aiplk::getFIO($aItem),
    $aItem['PERSONAL_PHONE'],
    $aItem['EMAIL'],
    count(Aiplk::getUserSportsmeny(null, 8, $_aReg['ID'])),
    count(Aiplk::getUserSportsmeny(null, 10, $_aReg['ID'])),
    count(Aiplk::getUserSportsmeny(null, 7, $_aReg['ID']))
  );
}
//sort
Aiplk::sortArrTbl($_aSprts);
//
$i=0;foreach($_aSprts as $aItem){$i++;?>
    <tr>
      <td><?=$i?></td>
      <td><?=$aItem[0]?></td>
      <td><?=$aItem[1]?></td>
      <td><?=$aItem[2]?></td>
      <td><?=$aItem[3]?></td>
      <td class="cblue"><?=$aItem[4]?></td>
      <td class="cblue"><?=$aItem[5]?></td>
      <td class="cblue"><?=$aItem[6]?></td>
      <!-- <td><a href="#"><img src="<?=SITE_TEMPLATE_PATH?>/img/edit.svg" alt=""></a></td> -->
    </tr>
<?}?>
  </tbody>
  </table>
</div>

<?if(!isset($_REQUEST['ajax'])){?>
<script>
  function reg_update_data(){
    var sf=$('.col_sort_active').attr('data-field');
    var desc='';
    $('.overlay_loading').addClass('active');
    if($('.col_sort_active').hasClass('desc'))desc='1';
    $.post('/lk_ross.php',{'ajax':'Y','desc':desc,'sort_field':sf},function(data){
      $('.tbl_lk_ross').html($(data).find('.tbl_lk_ross').html());
      $('.overlay_loading').removeClass('active');
    });
  }
   $('body').on('click','.col_sort',function(e){
    if(!$(this).hasClass('col_sort_active')){
      $('.col_sort').removeClass('col_sort_active');
      $('.col_sort').removeClass('desc');
      $(this).addClass('col_sort_active');
    }else{
      $(this).toggleClass('desc');
    }
    setTimeout(reg_update_data,400);
    e.preventDefault();
    return false;
  }); 
</script>
<?}?>