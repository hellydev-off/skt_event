<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$arGroups=CUser::GetUserGroup($GLOBALS['USER']->GetID());
if(!in_array(11, $arGroups))die();
$APPLICATION->SetTitle('Соревнования');
?>
<div class="h1_cont">
  <span>
    <h1>Соревнования</h1>
    <span class="block-title"><a href="#" id="object_add" class="btn btn-light"><i class="bx bx-plus"></i>Добавить</a></span>
  </span>  
</div>
<div class="merop_list_cont">

  <?
    $aSorevn=Aiplk::getSorevn(false, 'process', true);
    $aDol=Aiplk::getDolzhnostSudi();
    $aOcenka=Aiplk::getOcenkaSudi();
    $aDisc=Aiplk::getDisciplina();
    $aVozrgruppa=Aiplk::getVozrastGuppa();
    $aEtap=Aiplk::getEtap();
    $aRazryad=Aiplk::getRazryad();
    $aRazryadId=array();
    foreach($aRazryad as $row)$aRazryadId[$row['ID']]=$row;

    foreach($aSorevn as $aItem){
      $file=CFile::ResizeImageGet($aItem['PROPERTIES']['AFISHA']['VALUE'], array('width'=>300, 'height'=>300), BX_RESIZE_IMAGE_EXACT, true); 
    ?>

  	<div class="merop_item_cont">
      <?if(isset($file['src'])){?>
      <div class="merop_photo">
        <img class="mph_img" src="<?=$file['src']?>" alt="">
        <div class="mph_btn_cont">          
          <span class="block-title"><a href="#" class="btn btn-light mph_photo_add">
            <input data-id="<?=$aItem['ID']?>" class="mph_photo_inp" accept=".png,.jpg" type="file">
            Редактировать
          </a></span>
          <span class="block-title"><a href="#" data-id="<?=$aItem['ID']?>" class="btn btn-light mph_photo_del">Удалить</a></span>
        </div>
      </div>
      <?}else{?>
      <div class="merop_photo mph_photo_inp_open">
        <input data-id="<?=$aItem['ID']?>" class="mph_photo_inp" accept=".png,.jpg" type="file">
        <a href="#"><img src="<?=SITE_TEMPLATE_PATH?>/img/lk2/load_photo.png" alt=""></a>
        <center class="mph_txt">Загрузить изображение</center>
        <center class="mph_gray">JPG, PNG - 1080 x 1080</center>
      </div>
      <?}?>
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
            <a data-id="<?=$aItem['ID']?>" class="btn btn-primary btn-sm lk_sorevn_reg" href="#">Регистрация</a> 
            <a data-id="<?=$aItem['ID']?>" class="btn btn-primary btn-sm lk_sorevn_protokoly" href="#">Протоколы</a> 
            <div class="escho_cont">
              <a data-id="1433" onclick="return false" class="btn btn-primary btn-sm lk_sorevn_escho" href="#">Еще</a> 
              <div class="escho_div">
                <a data-id="<?=$aItem['ID']?>" class="lk_sorevn_sud_add" href="#">Судейская коллегия</a> 
                <a data-id="<?=$aItem['ID']?>" class="lk_sorevn_prog_add" href="#">Программа</a>
                <a data-id="<?=$aItem['ID']?>" class="lk_otchety" href="#">Отчеты</a>             
                <a data-id="<?=$aItem['ID']?>" class="lk_sorevn_edit" href="#">Редактировать</a> 
                <a data-id="<?=$aItem['ID']?>" style="color:red" class="lk_sorevn_del" href="#">Удалить</a>
              </div>  
            </div>
          </div>      
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
      <button onclick="window.location.reload()" type="button" class="btn btn-primary btn-lg popup__close_button">Закрыть</button>
		</div>
	</div>
</div>

<script>
$('body').on('click','.mph_photo_del',function(e){
  var t=$(this);
  $.post('/local/templates/lk/ajax/save_img_meropr.php',{'mid':t.attr('data-id'),'del':1},function(data){
    window.location.reload();
  });
  e.preventDefault();
  return false;
});
$('body').on('change','.mph_photo_inp',function(e){
  $('.overlay_loading').addClass('active');
  var formData=new FormData(); 
  var t=$(this);
  var f=t[0].files[0];
  formData.append('mfile',f);
  formData.append('mid',t.attr('data-id'));
  $.ajax({
    type:"POST",
    url:'/local/templates/lk/ajax/save_img_meropr.php',
    contentType:false,
    processData:false,
    data:formData,
    dataType:'JSON'
  }).done(function(data){
    window.location.reload();
  });  
});
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>