<div class="popup popup-object-add">
	<div class="popup__bgd">
	</div>
	<div class="popup__content">
		<div class="popup__close">
 <i class="bx bx-menu"></i>
		</div>
		<div>
			<div class="popup__title">
				<h2>Добавление мероприятия</h2>
			</div>
			<form id="form_object_add" method="post" enctype="multipart/form-data">
				<div class="wrap-input100 form-outline mb-2">
          <span class="label-input">Название<span class="req">*</span></span> 
          <input class="form-control form-control-lg" type="text" id="OBJECT_NAME" name="PROJECT[NAME]" required="">
				</div>

        <div class="wrap-input100 form-outline mb-2">
          <span class="label-input">Номер соревнования</span> 
          <input value="" class="form-control form-control-lg" type="text" id="NOM_SOREVN" name="PROJECT[NOM_SOREVN]">
				</div>

        <div class="wrap-input100 form-outline mb-2 aip_line">
            <span class="label-input">Статус</span>
            <select style="width:auto;max-width: 100%;" class="form-control form-control-lg form-control form-control-lg-lg" id="OBJECT_UROVEN" name="PROJECT[UROVEN]">
                              <option value="">Не выбрано</option>
                              <?foreach(Aiplk::getUroven() as $row){?>
                                <option value="<?=$row['UF_XML_ID']?>"><?=$row['NAME']?></option>
                              <?}?>                              
            </select>
        </div>        
				<div class="wrap-input100 form-outline mb-2 tag_select_cont">
          <span class="label-input">Спортивная организация<span class="req">*</span></span> 
          


          <style>
            .tag_select_cont .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover, .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:focus,
            .tag_select_cont .select2-selection__choice__display,
            .tag_select_cont .select2-selection__choice,
            .tag_select_cont .select2-selection__choice__remove{
              background:#03a9ff!important;color:white!important;border:none!important;
            }
            .tag_select_cont .select2-container .select2-selection--multiple .select2-selection__rendered{
              display:flex
            }
            .tag_select_cont .select2-selection.select2-selection--multiple{
              display: flex;
              align-items: center;
              justify-content: flex-start;
              caret-color: transparent;
            }
            .tag_select_cont .select2-selection__rendered{font-size:24px;margin-top:0;margin-bottom:0}
            .tag_select_cont .select2-results{background:#eff5fa}
            .tag_select_cont .select2-container--default .select2-selection--multiple,
            .tag_select_cont .select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple,
            .tag_select_cont .select2-container--default.select2-container--focus .select2-selection--multiple{
              background-color: #eff5fa;
              border: none;
              border-radius: var(--bs-border-radius-lg);
              min-height: calc(1.5em + 1rem + calc(var(--bs-border-width) * 2));
            }
          </style>
          <select multiple="multiple" class="form-control form-control-lg" id="SPORT_ORG" name="PROJECT[SPORT_ORG][]">
            <?
            $aUser=Aiplk::getUser($GLOBALS['USER']->GetID());
            foreach(Aiplk::getWorkcompArr($aUser['WORK_COMPANY']) as $row){?>
              <option value="<?=$row?>"><?=$row?></option>
            <?}?>
          </select>
          <script>
            	$('#SPORT_ORG').select2();
          </script>

          <?/*<input class="form-control form-control-lg" type="text" id="SPORT_ORG" name="PROJECT[SPORT_ORG]" required="">*/?>
				</div>
				<div class="wrap-input100 form-outline mb-2 ">
          <span class="label-input">Место проведения<span class="req">*</span></span>
          <select class="form-control form-control-lg inp_tags" name="PROJECT[MESTO]" id="MESTO1" required></select>
				</div>

				<div class="wrap-input100 form-outline mb-2 ">
          <span class="label-input">Название команды<span class="req">*</span></span>
          <input class="form-control form-control-lg" type="text" name="PROJECT[KOMANDA]" id="KOMANDA" required>
				</div>

				<div class="wrap-input100 form-outline mb-2 aip_line">
          <span class="label-input no_margin">Даты проведения</span>
          <div>
            <span class="aip_line">с&nbsp;&nbsp;<input class="form-control form-control-lg no_margin" type="date" id="DATE_ACTIVE_FROM" name="PROJECT[DATE_ACTIVE_FROM]" required min="<?=date("Y-m-d")?>" value="<?=date("Y-m-d")?>"></span>
            <span class="aip_line">&nbsp;&nbsp;по&nbsp;&nbsp;<input class="form-control form-control-lg no_margin" type="date" id="DATE_ACTIVE_TO" name="PROJECT[DATE_ACTIVE_TO]" required="" min="<?=date("Y-m-d")?>" value="<?=date("Y-m-d")?>"></span>
          </div>
				</div>
				<div class="wrap-input100 form-outline mb-2">
          <span class="label-input">Добавить описание</span> 
          <textarea class="form-control form-control-lg" type="text" id="OBJECT_NAME" name="PROJECT[DESCR]"></textarea>
				</div>

        <div class="wrap-input100 form-outline mb-2 aip_line">
          <label class="label-input input-file">
              <span>Добавить документы</span> 
              <input onchange="showFiles(this)" type="file" name="docs_meropr[]" multiple="">		
          </label>
          <span class="add_file" onclick="$(this).parent().find('input').trigger('click');return false;">
            <div><img src="/local/templates/lk/img/skrepka.png" alt=""><span>Прикрепить файл</span></div>
            <?/*<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path></svg>*/?>
          </span>
        </div> 
        <div id="imagePreviews" class="input-file-list"></div>  

        <div class="wrap-input100 form-outline mb-2 aip_line">
          <label class="label-input input-file">
              <span>Афиша</span> 
              <input onchange="showFiles2(this)" type="file" name="afisha_meropr[]">		
          </label>
          <span class="add_file" onclick="$(this).parent().find('input').trigger('click');return false;">
            <div><img src="/local/templates/lk/img/skrepka.png" alt=""><span>Прикрепить файл</span></div>
            <?/*<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path></svg>*/?>
          </span>
        </div> 
        <div id="imagePreviews2" class="input-file-list"></div>  

				<div class="wrap-input100 mt-4 btn_cont_1">
          <input type="submit" name="go" value="Добавить" class="questionnaire_btn btn btn-primary">
				</div>        
			</form>
		</div>
	</div>
</div>
<script>
$('.popup.popup-object-add .popup__bgd, .popup.popup-object-add .popup__close').on('click', function () {
  $('.popup.popup-object-add').removeClass('popup_open');
});
$('#object_add').click(function (e) {
    e.preventDefault();
    $(".popup-object-add").addClass("popup_open");
});
$("#form_object_add").submit(function (e) {
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: '/local/templates/lk/ajax/sorevn_add.php',
                contentType: false,
                processData: false,
                data: formData,
            }).done(function (data) {
                //console.log(data);
                $('.popup.popup-sent').addClass('popup_open');
                //location.reload();
                //window.location = '/suppliers/';
            }).fail(function () {
                $('.sent_error > div').html('Ошибка.');
                $('.sent_error').fadeIn(300, function () {
                    setTimeout(function () {
                        $('.sent_error').fadeOut(300);
                    }, 3000);
                });
                return false;
            });

            return false;

            e.preventDefault();
  });  
$(document).ready(function(){
  //select2
  $('#form_object_add .inp_tags').select2({
    'tags':false,
    'selectOnClose':false,
    'closeOnSelect':true,
    'ajax':{
      url: '/local/templates/lk/ajax/get_gorod.php',
      dataType: 'json',
      delay: 250
    }
  });
});
</script>