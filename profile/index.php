<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Профиль");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("Профиль");
?>
<?
$user=new CUser;
$arParams["SELECT"] = array('UF_REGION_SPR', 'UF_REGION', 'UF_REGION_STRANA', 'UF_GOROD', 'UF_RAZR', 'UF_TRENER_ID', 'UF_SUD_KAT', 'UF_DOCS', 'UF_PHOTO_MAIN', 'UF_PHOTO_SPRT', 'UF_PHOTO_ORG', 'UF_PHOTO_SUD', 'UF_PHOTO_TREN');
$oUser=$user->GetList(($by="id"), ($order="desc"), array('ID'=>$GLOBALS['USER']->GetID()), $arParams);
$arResult=$oUser->fetch();
//var_dump('<pre>',$arResult);die();
/*?>
<div class="item-list">
  <h1 class="block-title">Профиль</h1>
</div>
*/?>
<div class="bx-auth-profile">
        <div class="__table-container">

<?//if(Aiplk::getStartPage()!='lk_region' and Aiplk::getStartPage()!='lk_ross'){?>        
<div class="btn_tab_cont reg_btn_cont flt_reg_block btn_block1">
	<input data-tab="tab1" type="button" class="lnk2 active" value="Общие">
	<?if(CSite::InGroup(array(11)) or CSite::InGroup(array(12))){?><input data-tab="tab2" type="button" class="lnk2" value="Организатор"><?}?>
	<?if(CSite::InGroup(array(7))){?><input data-tab="tab3" type="button" class="lnk2" value="Судья"><?}?>
	<?if(CSite::InGroup(array(8))){?><input data-tab="tab4" type="button" class="lnk2" value="Спортсмен"><?}?>
</div>
<?//}?>
            <form id="l_profile_edit" method="post" name="form1" enctype="multipart/form-data">
                <input type="hidden" name="ID" value="<?=$arResult['ID']?>"/>

<div id="tab4" class="tab_cont aip_line_3">
  <div class="wrap-input100 form-outline mb-2 aip_line">
      <span class="label-input">Спортивный разряд/звание</span>                                 
      <select class="form-control form-control-lg form-control form-control-lg-lg" id="UF_RAZR" name="user[UF_RAZR]">
          <option value="">Не выбрано</option>
					<?foreach(Aiplk::getRazryad() as $row){?>
						<option <?=(($arResult["UF_RAZR"]==$row['ID'])?'selected':'')?> value="<?=$row['ID']?>"><?=$row['NAME']?></option>
          <?}?>
			</select>             
	</div>
  <div class="wrap-input100 form-outline mb-2">
    <span class="label-input">Тренер</span>
    <select class="inp_tags_trener form-control form-control-lg" data-f="UF_TRENER_ID" name="user[UF_TRENER_ID]">
      <option value="<?=$arResult["UF_TRENER_ID"]?>"><?=Aiplk::getFIO($arResult["UF_TRENER_ID"])?></option>
    </select> 
  </div>   
  
<!-- photo sprt -->
	<div class="wrap-input100 form-outline mb-2 aip_line input-file-row">
		<label class="label-input input-file">
		   	<span>Фото:</span> 
		   	<input onchange="showFiles3(this,'_sprt_photo')" type="file" name="photo_sprt[]">		
 		</label>
    <div>
      <span class="add_file" onclick="$(this).parents('.aip_line').find('input').trigger('click');return false;">
        <div>
          <img src="/local/templates/lk/img/skrepka.png" alt="">
          <span>Прикрепить фото</span>
        </div>
      </span>
    </div>  
		<div id="imagePreviews_sprt_photo" class="input-file-list">
      <?
        $arFile=CFile::GetFileArray($arResult['UF_PHOTO_SPRT']);
        $typeFile=explode('/', $arFile['CONTENT_TYPE']);
      ?>
      <?if(!empty($arFile['SRC'])){?>
      <a href="<?=$arFile['SRC']?>" class="col-md-4 mb-3" target="_blank">
        <img src="<?=$arFile['SRC']?>" alt="Preview" class="img-fluid rounded"> 
        <div class="text-center mt-2"> 
          <span class="badge bg-secondary"><?=$arFile['FILE_NAME']?></span> 
        </div>
      </a>
      <?}?>
    </div>  
	</div>  
<!-- /photo -->

	<div class="wrap-input100 form-outline mb-2 aip_line input-file-row">
		<label class="label-input input-file">
		   	<span>Добавить документы</span> 
		   	<input onchange="showFiles(this)" type="file" name="docs_sport[]" multiple="">		
 		</label>
    <div>
      <span class="add_file" onclick="$(this).parent().find('input').trigger('click');return false;">
        <div>
          <img src="/local/templates/lk/img/skrepka.png" alt="">
          <span>Прикрепить файл</span>
        </div>  
      </span>
    </div>  
		<div id="imagePreviews" class="input-file-list">
    <?foreach ($arResult['UF_DOCS'] as $fid){
        $arFile=CFile::GetFileArray($fid);
        $typeFile=explode('/', $arFile['CONTENT_TYPE']);
     ?>
      <a href="<?=$arFile['SRC']?>" class="col-md-4 mb-3" target="_blank">
        <img src="<?=$arFile['SRC']?>" alt="Preview" class="img-fluid rounded"> 
        <div class="text-center mt-2"> 
          <span class="badge bg-secondary"><?=$arFile['FILE_NAME']?></span> 
        </div>
      </a>
    <?}?>
    </div>  
	</div>  
</div>



<div id="tab3" class="tab_cont aip_line_3">
	<div class="wrap-input100 form-outline mb-2 aip_line">
      <span class="label-input">Судейская категория</span>                                 
      <select class="form-control form-control-lg form-control form-control-lg-lg" id="UF_SUD_KAT" name="user[UF_SUD_KAT]">
          <option value="">Не выбрано</option>
					<?foreach(Aiplk::getKategoriiSudi() as $row){?>
						<option <?=(($arResult["UF_SUD_KAT"]==$row['ID'])?'selected':'')?> value="<?=$row['ID']?>"><?=$row['NAME']?></option>
          <?}?>
			</select>             
	</div>

 <!-- photo sud -->
	<div class="wrap-input100 form-outline mb-2 aip_line input-file-row">
		<label class="label-input input-file">
		   	<span>Фото:</span> 
		   	<input onchange="showFiles3(this,'_sud_photo')" type="file" name="photo_sud[]">		
 		</label>
    <div>
      <span class="add_file" onclick="$(this).parents('.aip_line').find('input').trigger('click');return false;">
        <div>
          <img src="/local/templates/lk/img/skrepka.png" alt="">
          <span>Прикрепить фото</span>
        </div>
      </span>
    </div>  
		<div id="imagePreviews_sud_photo" class="input-file-list">
      <?
        $arFile=CFile::GetFileArray($arResult['UF_PHOTO_SUD']);
        $typeFile=explode('/', $arFile['CONTENT_TYPE']);
      ?>
      <?if(!empty($arFile['SRC'])){?>
      <a href="<?=$arFile['SRC']?>" class="col-md-4 mb-3" target="_blank">
        <img src="<?=$arFile['SRC']?>" alt="Preview" class="img-fluid rounded"> 
        <div class="text-center mt-2"> 
          <span class="badge bg-secondary"><?=$arFile['FILE_NAME']?></span> 
        </div>
      </a>
      <?}?>
    </div>  
	</div>  
<!-- /photo -->  

	<div class="wrap-input100 form-outline mb-2 aip_line input-file-row">
		<label class="label-input input-file">
		   	<span>Добавить документы</span> 
		   	<input onchange="showFiles2(this)" type="file" name="docs_sud[]" multiple="">		
 		</label>
    <div>
      <span class="add_file" onclick="$(this).parent().find('input').trigger('click');return false;">
        <div>
          <img src="/local/templates/lk/img/skrepka.png" alt="">
          <span>Прикрепить файл</span>
        </div>
      </span>
    </div>  
		<div id="imagePreviews2" class="input-file-list">
    <?foreach ($arResult['UF_DOCS'] as $fid){
        $arFile=CFile::GetFileArray($fid);
        $typeFile=explode('/', $arFile['CONTENT_TYPE']);
     ?>
      <a href="<?=$arFile['SRC']?>" class="col-md-4 mb-3" target="_blank">
        <img src="<?=$arFile['SRC']?>" alt="Preview" class="img-fluid rounded"> 
        <div class="text-center mt-2"> 
          <span class="badge bg-secondary"><?=$arFile['FILE_NAME']?></span> 
        </div>
      </a>
    <?}?>      
    </div>  
	</div>  
</div>



<!-- ORG -->
 <style>
  .inp_workcomp_cont{display:flex;flex-direction:column;margin-top:20px}
  .inp_workcomp_cont input{margin-top:-10px}
  .aip_line_3>div .inp_workcomp_add{
    margin-top:10px;
    border-radius:var(--bs-border-radius-lg);
    font-size:30px;padding:12px;border:1px solid;display:inline;width:auto!important
  }
 </style>
<div id="tab2" class="tab_cont aip_line_3">
  <div class="wrap-input100 form-outline mb-2">
      <span class="label-input">Организация:</span>
      <div class="inp_workcomp_cont">
        <?foreach(Aiplk::getWorkcompArr($arResult["WORK_COMPANY"]) as $row){?>
          <input class="form-control form-control-lg inp_workcomp" type="text" name="user[WORK_COMPANY][]" maxlength="50" value="<?=htmlspecialchars($row, ENT_QUOTES)?>"/>  
        <?}?>
        <input class="form-control form-control-lg inp_workcomp" type="text" name="user[WORK_COMPANY][]" maxlength="50" value=""/>
      </div>
      <div><a href="#" class="inp_workcomp_add">+</a></div>
  </div>   
  <script>
    $('body').on('click','.inp_workcomp_add',function(e){
      var p=$(this).parent().prev('.inp_workcomp_cont');
      var _inp=p.find('input.inp_workcomp').eq(0);
      _inp.clone(false).appendTo(p).val('');
      e.preventDefault();
      return false;
    });
  </script>
<!-- photo org -->
	<div class="wrap-input100 form-outline mb-2 aip_line input-file-row">
		<label class="label-input input-file">
		   	<span>Фото:</span> 
		   	<input onchange="showFiles3(this,'_org_photo')" type="file" name="photo_org[]">		
 		</label>
    <div>
      <span class="add_file" onclick="$(this).parents('.aip_line').find('input').trigger('click');return false;">
        <div>
          <img src="/local/templates/lk/img/skrepka.png" alt="">
          <span>Прикрепить фото</span>
        </div>
      </span>
    </div>  
		<div id="imagePreviews_org_photo" class="input-file-list">
      <?
        $arFile=CFile::GetFileArray($arResult['UF_PHOTO_ORG']);
        $typeFile=explode('/', $arFile['CONTENT_TYPE']);
      ?>
      <?if(!empty($arFile['SRC'])){?>
      <a href="<?=$arFile['SRC']?>" class="col-md-4 mb-3" target="_blank">
        <img src="<?=$arFile['SRC']?>" alt="Preview" class="img-fluid rounded"> 
        <div class="text-center mt-2"> 
          <span class="badge bg-secondary"><?=$arFile['FILE_NAME']?></span> 
        </div>
      </a>
      <?}?>
    </div>  
	</div>  
<!-- /photo -->  
</div>


<!-- USER -->
<div id="tab1" class="tab_cont active_tab aip_line_3">
                    <div class="wrap-input100 form-outline mb-2">
                        <span class="label-input">Фамилия:<span class="starrequired">*</span></span>
                        <input required class="form-control form-control-lg" type="text" name="user[LAST_NAME]" maxlength="50" value="<?= $arResult["LAST_NAME"] ?>"/>
                    </div>                 
                    <div class="wrap-input100 form-outline mb-2">
                        <span class="label-input">Имя:<span class="starrequired">*</span></span>
                        <input required class="form-control form-control-lg" type="text" name="user[NAME]" maxlength="50" value="<?= $arResult["NAME"] ?>"/>
                    </div>
                    <div class="wrap-input100 form-outline mb-2">
                        <span class="label-input">Отчество:<span class="starrequired">*</span></span>
                        <input required class="form-control form-control-lg" type="text" name="user[SECOND_NAME]" maxlength="50" value="<?= $arResult["SECOND_NAME"] ?>"/>
                    </div>                    
                    <div class="wrap-input100 form-outline mb-2 aip_line">
                        <span class="label-input">Пол:</span>
                                                    
                          <select class="form-control form-control-lg form-control form-control-lg-lg" id="PERSONAL_GENDER" name="user[PERSONAL_GENDER]">
                              <option value="">Не выбрано</option>
                              <option <?=(($arResult["PERSONAL_GENDER"]=='M')?'selected':'')?> value="M">Мужской</option>
                              <option <?=(($arResult["PERSONAL_GENDER"]=='F')?'selected':'')?> value="F">Женский</option></select>
                          </select>
                        
                    </div>                  
                    <div class="wrap-input100 form-outline mb-2 aip_line">
                        <span class="label-input">Дата рождения:</span>
                        <input required class="form-control form-control-lg" type="date" name="user[PERSONAL_BIRTHDAY]" maxlength="50" value="<?=ConvertDateTime($arResult['PERSONAL_BIRTHDAY'], "YYYY-MM-DD", "ru")?>"/>
                    </div>
                    <div class="wrap-input100 form-outline mb-2">
                      <span class="label-input">Телефон</span>
                      <input required class="form-control form-control-lg" type="text" name="user[PERSONAL_PHONE]" maxlength="50" value="<?php echo $arResult["PERSONAL_PHONE"] ?>"/>
                    </div>
                    <div class="wrap-input100 form-outline mb-2">
                      <span class="label-input">E-Mail<?php if ($arResult["EMAIL_REQUIRED"]): ?><span class="starrequired">*</span><?php endif ?></span>
                        <input required class="form-control form-control-lg" type="text" name="user[EMAIL]" maxlength="50" value="<?php echo $arResult["EMAIL"]?>"/>
                    </div>

                    <div class="wrap-input100 form-outline mb-2">
                        <span class="label-input">Логин<span class="starrequired">*</span></span>
                        <input class="form-control form-control-lg" type="text" name="user[LOGIN]" maxlength="50" value="<?php echo $arResult["LOGIN"] ?>" disabled/>
                    </div>

                    <?//$regions=Aiplk::getRegions()?>
                    <?$aRegion=Aiplk::getRegionTitle($arResult);
                    ?>
                    <div class="wrap-input100 form-outline mb-2">
                      <span class="label-input">Регион<span class="starrequired">*</span></span>
                      <select class="form-control form-control-lg form-control form-control-lg-lg inp_tags" name="user[UF_REGION]" id="PERSONAL_STATE" required>                              
                        <option selected value="<?=$aRegion['xmlval']?>"><?=$aRegion['txt']?></option>
                              <?/*foreach($regions as $_r){?>
                                <option <?=(($arResult['UF_REGION']==$_r['UF_XML_ID'])?'selected':'')?> value="<?=$_r['UF_XML_ID']?>"><?=$_r['NAME']?></option>
                              <?}*/?>
                      </select>                   
                    </div>
<!-- photo main -->
	<div class="wrap-input100 form-outline mb-2 aip_line input-file-row">
		<label class="label-input input-file">
		   	<span>Фото:</span> 
		   	<input onchange="showFiles3(this,'_mian_photo')" type="file" name="photo_main[]">		
 		</label>
    <div>
      <span class="add_file" onclick="$(this).parents('.aip_line').find('input').trigger('click');return false;">
        <div>
          <img src="/local/templates/lk/img/skrepka.png" alt="">
          <span>Прикрепить фото</span>
        </div>
      </span>
    </div>  
		<div id="imagePreviews_mian_photo" class="input-file-list">
      <?
        $arFile=CFile::GetFileArray($arResult['UF_PHOTO_MAIN']);
        $typeFile=explode('/', $arFile['CONTENT_TYPE']);
      ?>
      <?if(!empty($arFile['SRC'])){?>
      <a href="<?=$arFile['SRC']?>" class="col-md-4 mb-3" target="_blank">
        <img src="<?=$arFile['SRC']?>" alt="Preview" class="img-fluid rounded"> 
        <div class="text-center mt-2"> 
          <span class="badge bg-secondary"><?=$arFile['FILE_NAME']?></span> 
        </div>
      </a>
      <?}?>
    </div>  
	</div>  
<!-- /photo -->
                    <!-- <div class="wrap-input100 form-outline mb-2">
                        Город<span class="starrequired">*</span>
                        <input required class="form-control form-control-lg" type="text" name="user[PERSONAL_CITY]" maxlength="50" value="<?php echo $arResult["PERSONAL_CITY"] ?>"/>
                    </div>                      -->
            <?if(Aiplk::getStartPage()!='lk_region' and Aiplk::getStartPage()!='lk_ross'){?>         
                    <div class="wrap-input100 form-outline mb-2 aip_chb_cont">                    
                      <span class="label-input">Статус<span class="starrequired">*</span></span>
                      <div>
                        <?/*
                        <label>
                          <input <?=((CSite::InGroup(array(9)))?'checked':'')?> type="checkbox" name="user_status[]" value="9">
											  	<span class="custom-checkbox"></span>
                          <span>Организатор</span>
                        </label>*/?>
                        <label>
                          <input <?=((CSite::InGroup(array(7)))?'checked':'')?> type="checkbox" name="user_status[]" value="7">
                          <span class="custom-checkbox"></span>
											  	<span>Судья</span>
                        </label>
                        <label>
                          <input <?=((CSite::InGroup(array(8)))?'checked':'')?> type="checkbox" name="user_status[]" value="8">
                          <span class="custom-checkbox"></span>
											  	<span>Спортсмен</span>
                        </label>
                        <label>
                          <input <?=((CSite::InGroup(array(10)))?'checked':'')?> type="checkbox" name="user_status[]" value="10">
                          <span class="custom-checkbox"></span>
											  	<span>Тренер</span>
                        </label>                          
                      </div>  
                    </div>     
            <?}?>                    
                    <?if(CSite::InGroup(array(11))){?>
                      <input type="hidden" name="user_status[]" value="11">
                    <?}?>                    
                    <?if(CSite::InGroup(array(12))){?>
                      <input type="hidden" name="user_status[]" value="12">
                    <?}?>



<?// ******************** /User properties ***************************************************?>
                     <?//var_dump('<pre>',$arResult)?>                         
                                              
                    
                    
                    
                    <?php if ($arResult['CAN_EDIT_PASSWORD']): ?>
                        <div class="wrap-input100 form-outline mb-2">
                        <?= GetMessage('NEW_PASSWORD_REQ') ?>
                        <input class="form-control form-control-lg" type="password" name="user[NEW_PASSWORD]" maxlength="50" value="" autocomplete="off" class="bx-auth-input"/>
                        <p class="text-muted input-info"><?php echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"]; ?></p>
                        <?php if ($arResult["SECURE_AUTH"]): ?>
                            <span class="bx-auth-secure" id="bx_auth_secure" title="<?php echo GetMessage("AUTH_SECURE_NOTE") ?>" style="display:none">
					            <div class="bx-auth-secure-icon"></div>
				            </span>
                            <noscript>
                            <span class="bx-auth-secure" title="<?php echo GetMessage("AUTH_NONSECURE_NOTE") ?>">
                                <div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
                            </span>
                            </noscript>
                            <script type="text/javascript">
                                document.getElementById('bx_auth_secure').style.display = 'inline-block';
                            </script>
                            
                            </div>
                        <?php endif ?>
                        <div class="wrap-input100 form-outline mb-2">
                            <?= GetMessage('NEW_PASSWORD_CONFIRM') ?>
                            <input class="form-control form-control-lg" type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off"/>
                        </div>
                        
                    <?php endif ?>

   
</div>
                <br>
                <br>

                <div class="wrap-input100 btn_cont_1" style="background:transparent;max-width:500px;position:relative;margin-bottom:40px">
                  <input id="l_profile_edit_btn" type="button" class="btn btn-primary" name="save" value="<?= (($arResult["ID"] > 0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD")) ?>">
                  
                  <a style="background: none !important;display: flex;justify-content: center;align-items: center;" href="/lk/?logout=yes&<?=bitrix_sessid_get()?>" class="nav_link"> <i class="bx bx-log-out nav_icon"></i>&nbsp;<span class="nav_name">Выход</span> </a>
                
                </div>
            </form>

        </div>
</div>
<div class="popup popup-sent">
            <div class="popup__bgd"></div>
            <div class="popup__content">
                <div class="popup__close">
                    <i class='bx bx-x'></i>
                </div>
                <h2>Сохранено</h2>
                <p></p>
                <div class="popup__body">
                    <button type="button" onclick="location.reload()" class="btn btn-primary btn-lg popup__close_button">Закрыть</button>
                </div>
            </div>
</div>
<script>
$('.btn_tab_cont input').click(function(e){
	$('.btn_tab_cont input').removeClass('active');
	$(this).addClass('active');
	$('.tab_cont').removeClass('active_tab');
	$('#'+$(this).attr('data-tab')).addClass('active_tab');
	e.preventDefault();
	return false;
});
$('body').on('focus','.l_err',function(){$(this).removeClass('l_err')})
$('body').on('click','#l_profile_edit_btn',function(e){
  if(!$('#l_profile_edit')[0].checkValidity()){
    fl=false;
    $('#l_profile_edit').find('*[required]').each(function(){
      var fl=true;
      if($(this).val()==''){
        $(this).addClass('l_err');
        fl=false;
      }
    });
    if(!fl)alert('Заполните обязательные поля!');
    return false;
  }
  var formData = new FormData(document.forms.l_profile_edit);
  //console.log(formData);return false;
  $.ajax({
    type: 'POST',
    url: '<?=SITE_TEMPLATE_PATH ?>/ajax/profile_edit.php',
    data: formData,
    contentType: false,
    processData: false,
    dataType : "json",
    success:function(data) {
      if(data.err)$('.popup.popup-sent h2').eq(0).html(data.err);
      else if(data.html)$('.popup.popup-sent h2').eq(0).html(data.html);
      $('.popup.popup-sent').addClass('popup_open');
    }
  });
  e.preventDefault();
  return false; 
});
$('.popup.popup-sent .popup__bgd, .popup.popup-sent .popup__close, .popup.popup-sent .popup__close_button').on('click', function () {
    $('.popup.popup-sent').removeClass('popup_open');
});
$(document).ready(function(){
  //select2
  $('#l_profile_edit').find('.inp_tags_trener').select2({
    'placeholder':'Не выбрано',
    'tags':false,
    'selectOnClose':false,
    'closeOnSelect':true,
    'ajax':{
      url: '/local/templates/lk/ajax/get_trener.php',
      dataType: 'json',
      delay: 250,
    }
  });    
  $('#l_profile_edit .inp_tags').select2({
    'tags':false,
    'selectOnClose':false,
    'closeOnSelect':true,
    'ajax':{
      url: '/local/templates/lk/ajax/get_gorod.php',
      dataType: 'json',
      delay: 250
    }
  });
	$('#main_h1').html('Настройки');
});
/*
var dt = new DataTransfer();
$('.input-file input[type=file]').on('change', function(){
	let $files_list = $(this).parents('div.input-file-row').find('.input-file-list').eq(0);
	$files_list.empty();
	for(var i = 0; i < this.files.length; i++){
		let new_file_input = '<div class="input-file-list-item">' +
			'<span class="input-file-list-name">' + this.files.item(i).name + '</span>' +
			'<a href="#" onclick="removeFilesItem(this); return false;" class="input-file-list-remove">x</a>' +
			'</div>';
		$files_list.append(new_file_input);
		dt.items.add(this.files.item(i));
	};
	this.files = dt.files;
});
function removeFilesItem(target){
	let name = $(target).prev().text();
	let input = $(target).closest('.input-file-row').find('input[type=file]');	
	$(target).closest('.input-file-list-item').remove();	
	for(let i = 0; i < dt.items.length; i++){
		if(name === dt.items[i].getAsFile().name){
			dt.items.remove(i);
		}
	}
	input[0].files = dt.files;  
}*/

</script>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>