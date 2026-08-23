<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$arGroups=CUser::GetUserGroup($GLOBALS['USER']->GetID());
if(!in_array(12, $arGroups))die();
$curUser=Aiplk::getUser($GLOBALS['USER']->getID());
//$waitUsers=array();
$waitUsers=Aiplk::getUserSportsmeny(null, '', $curUser['UF_REGION_SPR'], false);
if(empty($gr=intval($_REQUEST['group'])))die();

$title='Спортсмены';
if($gr==7)$title='Судьи';
elseif($gr==8)$title='Спортсмены';
elseif($gr==10)$title='Тренеры';
else die();
$APPLICATION->SetTitle($title);

//$aUsers=Aiplk::getUserSportsmeny(null, $gr, $curUser['UF_REGION_SPR']);
$aUsers=Aiplk::getUserFromGroup($gr, $curUser['UF_REGION_SPR']);
//v($aUsers);
//$regXmlId=Aiplk::getRegionSprNew($curUser['UF_REGION_SPR'])['UF_XML_ID'];
//$aUsers=Aiplk::getSportsmeny(false, 'Y', ['ACTIVE'=>'Y', 'IBLOCK_ID'=>6, 'PROPERTY_REGION_SPR'=>$regXmlId]);

$_waitUsers=$waitUsers;
$user=new CUser;
foreach($waitUsers as $k=>$v){
  $user->Update($v['ID'], ["UF_DOPUSK" => 7]);
}
?>

<?if(count($waitUsers)>0){?>
<div class="newuser_conf_cont">
  <div class="newuser_title">Новые пользователи ожидают подтверждения:</div>
  <div>
    <?$i=2;foreach($_waitUsers as $k=>$row){
      $dateRegister = $row['DATE_REGISTER'];
      $now = new DateTime();  
      $diff = $now->getTimestamp() - $dateRegister->getTimestamp();
      $hours = round($diff / 3600);      
    ?>
      <div class="newuser_line">
        <div>
          <?if(empty($row['UF_DOPUSK'])){?>
            <div><img src="<?=SITE_TEMPLATE_PATH?>/img/lk2/ico_tochka.png" alt=""></div>
            <div class="nu_gray"><?=$hours?> ч назад</div>
            <div><b><?=Aiplk::getFIO($row)?></b></div>
          <?}else{?>
            <div></div>
            <div class="nu_gray"><?=$hours?> ч назад</div>
            <div><?=Aiplk::getFIO($row)?></div>
          <?}?>
          <div><?=$row['UF_GOROD']?></div>
          <div><?=ConvertDateTime($row['DATE_REGISTER'], "DD.MM.YYYY", "ru") ?></div>
        </div>
        <div>
          <a href="#" data-id="<?=$row['ID']?>" class="newuser_btn_conf">Подтвердить</a>
          <a href="#" data-id="<?=$row['ID']?>" class="newuser_btn_deni">Отказать</a>
        </div>
      </div>  
    <?
      unset($_waitUsers[$k]);      
      $i--;
      if($i==0)break;
    }
    ?>
  </div>
  <div class="newuser_conf_cont_add">
    <?foreach($_waitUsers as $k=>$row){
      $dateRegister = $row['DATE_REGISTER'];
      $now = new DateTime();  
      $diff = $now->getTimestamp() - $dateRegister->getTimestamp();
      $hours = round($diff / 3600);
    ?>
      <div class="newuser_line">
        <div>
          <?if(empty($row['UF_DOPUSK'])){?>
            <div><img src="<?=SITE_TEMPLATE_PATH?>/img/lk2/ico_tochka.png" alt=""></div>
            <div class="nu_gray"><?=$hours?> ч назад</div>
            <div><b><?=Aiplk::getFIO($row)?></b></div>
          <?}else{?>
            <div></div>
            <div class="nu_gray"><?=$hours?> ч назад</div>
            <div><?=Aiplk::getFIO($row)?></div>
          <?}?>
          <div><?=$row['UF_GOROD']?></div>
          <div><?=ConvertDateTime($row['DATE_REGISTER'], "DD.MM.YYYY", "ru") ?></div>
        </div>
        <div>
          <a href="#" data-id="<?=$row['ID']?>" class="newuser_btn_conf">Подтвердить</a>
          <a href="#" data-id="<?=$row['ID']?>" class="newuser_btn_deni">Отказать</a>
        </div>
      </div>  
    <?}?>
  </div>  
   <?if(!empty($_waitUsers)){?>
  <a href="#" class="newuser_conf_btn_add"><img src="/local/templates/lk/img/lk2/ico_3tocki.png" alt="">&nbsp;&nbsp;<span class="newuser_conf_btn_add_text">Еще</span>&nbsp;<?=count($_waitUsers)?> заявок</a>
  <?}?>
</div>
<br>
<?}?>

<div class="h1_cont">
  <h1><?=$title?></h1>
  <div>Всего: <span><?=count($aUsers)?></span></div>  
</div>
<div class="table_cont">
  


<!-- СПОРТСМЕНЫ -->
<?if($gr==8){?>
  <table class="table_reg tbl_lk_ross">
  <tbody>
    <tr>
      <th style="max-width:20px">№</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(0)?>" data-field="0">ФИО</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(1)?>" data-field="1">Дата рождения</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(2)?>" data-field="2">Возрастная группа</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(3)?>" data-field="3">Телефон</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(4)?>" data-field="4">Почта</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(5)?>" data-field="5">Тренер</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(6)?>" data-field="6">Населенный пункт</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(7)?>" data-field="7">Разряд/звание</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(8)?>" data-field="8">Комментарий</th>
      <th></th>
    </tr>
    <?
    $_aSprts=array();
    foreach($aUsers as $aItem){
      $_aReg=Aiplk::getRegionTitle($aItem);
      $_aSprts[]=array(
        Aiplk::getFIO($aItem),
        ConvertDateTime($aItem['PERSONAL_BIRTHDAY'], "DD.MM.YYYY", "ru"),
        Aiplk::getVozrastGruppa($aItem['ID'])[2]['NAME'],
        $aItem['PERSONAL_PHONE'],
        $aItem['EMAIL'],
        Aiplk::getFIO($aItem['UF_TRENER_ID']),
        $_aReg['g'],
        Aiplk::getRazryad($aItem['UF_RAZR'])['NAME'],
        $aItem['UF_COMM'],
        $aItem['ID']
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
      <td><?=$aItem[4]?></td>
      <td><?=$aItem[5]?></td>
      <td><?=$aItem[6]?></td>
      <td><?=$aItem[7]?></td>
      <td><?=$aItem[8]?></td>
      <td><a href="#" class="lk_ross_user_edit" data-userid="<?=$aItem[9]?>"><img src="<?=SITE_TEMPLATE_PATH?>/img/edit.svg" alt=""></a></td>
    </tr>
    <?}?>
  </tbody>
  </table>


<!-- ТРЕНЕРЫ -->
<?}elseif($gr==10){?>
  <table class="table_reg tbl_lk_ross">
  <tbody>
    <tr>
      <th style="max-width:20px">№</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(0)?>" data-field="0">ФИО</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(1)?>" data-field="1">Дата рождения</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(2)?>" data-field="2">Телефон</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(3)?>" data-field="3">Почта</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(4)?>" data-field="4">Населенный пункт</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(5)?>" data-field="5">Тренерская категория</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(6)?>" data-field="6">Лицензия</th>
      <th></th>
    </tr>
    <?
    $_aSprts=array();
    foreach($aUsers as $aItem){
      $_aReg=Aiplk::getRegionTitle($aItem);
      $_aSprts[]=array(
        Aiplk::getFIO($aItem),
        ConvertDateTime($aItem['PERSONAL_BIRTHDAY'], "DD.MM.YYYY", "ru"),
        $aItem['PERSONAL_PHONE'],
        $aItem['EMAIL'],
        $_aReg['g'],
        Aiplk::getKategoriiSudi(false, $aItem['UF_TRENER_KAT'])['NAME'],
        Aiplk::getEnumList('UF_LIC_TRENER_TIP')[$aItem['UF_LIC_TRENER_TIP']].' №'.$aItem['UF_LIC_TRENER_NOMER'].' до '.$aItem['UF_LIC_TRENER_SROK'],
        $aItem['ID']
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
      <td><?=$aItem[4]?></td>
      <td><?=$aItem[5]?></td>
      <td><?=$aItem[6]?></td>
      <td><a href="#" class="lk_ross_user_edit" data-userid="<?=$aItem[7]?>"><img src="<?=SITE_TEMPLATE_PATH?>/img/edit.svg" alt=""></a></td>
    </tr>
    <?}?>
  </tbody>
  </table>

<!-- СУДЬИ -->
<?}elseif($gr==7){?>
  <table class="table_reg tbl_lk_ross">
  <tbody>
    <tr>
      <th style="max-width:20px">№</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(0)?>" data-field="0">ФИО</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(1)?>" data-field="1">Дата рождения</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(2)?>" data-field="2">Телефон</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(3)?>" data-field="3">Почта</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(4)?>" data-field="4">Населенный пункт</th>
      <th class="col_sort <?=Aiplk::sortArrTblClass(5)?>" data-field="5">Судейская категория</th>
      <th></th>
    </tr>
    <?
    $_aSprts=array();
    foreach($aUsers as $aItem){
      $_aReg=Aiplk::getRegionTitle($aItem);
      $_aSprts[]=array(
        Aiplk::getFIO($aItem),
        ConvertDateTime($aItem['PERSONAL_BIRTHDAY'], "DD.MM.YYYY", "ru"),
        $aItem['PERSONAL_PHONE'],
        $aItem['EMAIL'],
        $_aReg['g'],
        Aiplk::getKategoriiSudi(false, $aItem['UF_SUD_KAT'])['NAME'],
        $aItem['ID']
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
      <td><?=$aItem[4]?></td>
      <td><?=$aItem[5]?></td>
      <td><a href="#" class="lk_ross_user_edit" data-userid="<?=$aItem[6]?>"><img src="<?=SITE_TEMPLATE_PATH?>/img/edit.svg" alt=""></a></td>
    </tr>
    <?}?>
  </tbody>
  </table>
<?}?>

</div>

<?if(!isset($_REQUEST['ajax'])){//sort?>
<script>
  function reg_update_data(){
    var sf=$('.col_sort_active').attr('data-field');
    var desc='';
    $('.overlay_loading').addClass('active');
    if($('.col_sort_active').hasClass('desc'))desc='1';
    $.post('/lk2_sprt.php',{'ajax':'Y','desc':desc,'sort_field':sf,'group':'<?=$gr?>'},function(data){
    console.log(data);
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

<script>
  $('body').on('click','.newuser_btn_conf',function(e){
    var t=$(this);
    if(confirm('Уверенность ?')){
      $.post('/local/templates/lk/ajax/lk2_user_active.php',{'id':t.attr('data-id'),'act':'confirm'},function(data){
        if(data=='ok')t.parents('div.newuser_line').hide('fast',function(){$(this).remove()});
        else console.log(data);
      });
    }
    e.preventDefault();
    return false;
  });  
  $('body').on('click','.newuser_btn_deni',function(e){
    var t=$(this);
    if(confirm('Уверенность ?')){
      $.post('/local/templates/lk/ajax/lk2_user_active.php',{'id':t.attr('data-id'),'act':'denied'},function(data){
        if(data=='ok')t.parents('div.newuser_line').hide('fast',function(){$(this).remove()});
        else console.log(data);
      });
    }
    e.preventDefault();
    return false;    
  });
  $('body').on('click','.newuser_conf_btn_add',function(e){
    if($(this).find('.newuser_conf_btn_add_text').text()=='Свернуть')$(this).find('.newuser_conf_btn_add_text').html('Ещё');
    else $(this).find('.newuser_conf_btn_add_text').html('Свернуть');
    $('.newuser_conf_cont_add').slideToggle('fast');
    e.preventDefault();
    return false;
  });
  $('body').on('click','.lk_ross_user_edit',function(e){
    var userid=$(this).attr('data-userid');
    $('.overlay_loading').addClass('active');
    $.post('/local/templates/lk/ajax/lk_ross_user_edit.php',{'userid':userid},function(data){
      $('.popup.popup-object-reg .popup__title h2').html('Редактировать пользователя');
      $('#form_object_reg').html(data);
      $('.popup.popup-object-reg').addClass('popup_open');
      $('.overlay_loading').removeClass('active');
    });
    e.preventDefault();
    return false;    
  }); 
  $('.popup.popup-object-reg .popup__bgd, .popup.popup-object-reg .popup__close').on('click', function () {
    $('.popup.popup-object-reg').removeClass('popup_open');
  });    
</script>

<div class="popup popup-object-reg">
	<div class="popup__bgd">
	</div>
	<div class="popup__content">
		<div class="popup__close">
      <i class="bx bx-menu"></i>
		</div>
		<div>
			<div class="popup__title">
				<h2></h2>        
			</div>
			<div id="form_object_reg" method="post"></div>
		</div>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>