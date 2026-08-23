<?php
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
if(!in_array(12, $arGroups))die();
$APPLICATION->SetTitle('Календарь');
$curUser=Aiplk::getUser($GLOBALS['USER']->getID());
$waitUsers=Aiplk::getUserSportsmeny(null, '', $curUser['UF_REGION_SPR'], false);
$_waitUsers=$waitUsers;
$user = new CUser;
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
  <span>
    <h1>Календарь соревнований</h1>
  </span>  
</div>



<div class="merop_list_cont">
  <?$aSorevn=Aiplk::getSorevn(false, 'process', true)?>
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
					<?//v(Aiplk::getCurRegion($curUser)['UF_XML_ID'])?>
					<?//v(Aiplk::getRegionTitle($aItem)['UF_XML_ID'])?>
					<?//if(Aiplk::getCurRegion($curUser)['UF_XML_ID']==Aiplk::getRegionTitle($aItem)['UF_XML_ID']){?>
          	<a data-id="<?=$aItem['ID']?>" class="lk_sorevn_lk2_reg btn btn-primary btn-sm" href="/lk2_reg_sprt.php?id=<?=$aItem['ID']?>">Регистрация</a>     
					<?//}?>	
          <a data-id="<?=$aItem['ID']?>" class="btn btn-primary btn-sm lk_sorevn_protokoly" href="#">Протоколы</a> 
          <a data-id="<?=$aItem['ID']?>" class="lk_otchety btn btn-primary btn-sm" href="#">Отчеты</a>     
        </div>	
   		</div>
      <div class="sent_error"><div></div></div>
		</div>
  </div>
  <?}?>
  <?$APPLICATION->IncludeFile(SITE_DIR.'/include/sorevn/protokoly.php')?>
  <?$APPLICATION->IncludeFile(SITE_DIR.'/include/sorevn/otchety.php')?>  
</div>




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
</script>