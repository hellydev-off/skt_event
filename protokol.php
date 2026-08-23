<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Протоколы");
$APPLICATION->SetPageProperty("title", "Протоколы");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");


$aProgramma=Aiplk::getProgramma(intval($_GET['id_programma']));
$aSorevn=Aiplk::getSorevn($aProgramma['PROPERTIES']['ID_SOREVN']['VALUE']);
if(
  Aiplk::getStartPage()=='sud' or
  Aiplk::getStartPage()=='lk_ross' //or
  //Aiplk::getStartPage()=='lk_region'
)$ed=true;else $ed=false;
//if(!Aiplk::isEditable($aProgramma['PROPERTIES']['ID_SOREVN']['VALUE']))$ed=false;
if($aSorevn['PROPERTIES']['STATUS']['VALUE']=='closed')$ed=false;

if(empty($aProgramma) or empty($aSorevn))die('Ошибка :(');

$aDisc=Aiplk::getDisciplina();
$aRazryad=Aiplk::getRazryad();
$aRazryadId=array();
foreach($aRazryad as $row)$aRazryadId[$row['ID']]=$row;
//var_dump('<pre>', Aiplk::getRegions($aSorevn['PROPERTIES']['MESTO']['VALUE']));

?>
<div id="tbl_protocol_cont" class="" style="flex-direction:column;">
<div class="item-list">
  <h1 class="block-title">Судейский протокол (Этап - <?=Aiplk::getEtap($aProgramma['PROPERTIES']['ETAP']['VALUE'])['NAME']?>)</h1>
</div>
<div class="bx-auth-profile">
  <h3><?=$aSorevn['NAME']?></h3>
</div>
<div class="prot_title_cont">
  <div><span>Вид спорта:</span> <span>спортивное метание ножа</span></div>
  <div><span>Место проведения:</span> <span><?=Aiplk::getRegionTitle($aSorevn)['txt']?></span></div>
  <div><span>Даты проведения:</span> <span><?=$aSorevn['ACTIVE_FROM']?> - <?=$aSorevn['ACTIVE_TO']?></span></div>
  <div><span>Возрастная группа:</span> <span><?=Aiplk::getVozrastGuppa($aProgramma['PROPERTIES']['VOZRAST_GRUPPA']['VALUE'])['NAME']?></span></div>
  <div><span>Спортивная дисциплина:</span> <span><?=Aiplk::getDisciplina($aProgramma['PROPERTIES']['DISCIPLINA']['VALUE'])['NAME']?></span></div>
</div>
<div class="table_cont">
<?
$seriy=intval($aProgramma['PROPERTIES']['KOLVO_SERIY']['VALUE']);
$broskov=intval($aProgramma['PROPERTIES']['KOLVO_BROSKOV']['VALUE']);
//var_dump('<pre>',$aProgramma['PROPERTIES']['KOLVO_UCH']['VALUE'],'</pre>');
//var_dump('<pre>',Aiplk::getMestoFromProgramma($aProgramma),'</pre>');

$aVarEtap=Aiplk::getVariantEtap();
try{
	if(empty($aVarEtap[$aProgramma['PROPERTIES']['VARETAP']['VALUE']]))throw new Exception();
	$aVarEtap=$aVarEtap[$aProgramma['PROPERTIES']['VARETAP']['VALUE']];
	$kolvo_v_etape=0;
	$kolvo_stendov=0;
  $flDef=true;
	foreach($aVarEtap['PROPERTIES']['ETAP']['VALUE'] as $k=>$v){
		if($v==$aProgramma['PROPERTIES']['ETAP']['VALUE']){
			$kolvo_v_etape=$aVarEtap['PROPERTIES']['KOLVO']['VALUE'][$k];
			$kolvo_stendov=array_shift(Aiplk::getVariantStend($aProgramma['PROPERTIES']['VARSTEND']['VALUE']));
			$kolvo_stendov=$kolvo_stendov['PROPERTIES']['STENDY']['VALUE'];
			if($kolvo_v_etape==0)throw new Exception();
			else{
        $flDef=false;
        require './include/protokol/po_stendam.phtml';
      }
			break;
		}
	}
  if($flDef)throw new Exception();
}catch(Exception $e){
  require './include/protokol/all.phtml';
}
?>
</div>
  <br>
  <br>
<div class="podpisi_cont">
<div>Главный судья  ____________/ <?=Aiplk::getFIO(Aiplk::getGlavnSud($aProgramma['PROPERTIES']['ID_SOREVN']['VALUE'])['USER_SUDYA'])?></div>
  <br>
  <br>
  <div>Главный секретарь  ____________/ <?=Aiplk::getFIO(Aiplk::getGlavnSudSekretar($aProgramma['PROPERTIES']['ID_SOREVN']['VALUE'])['USER_SUDYA'])?></div>
</div>
</div>
<br>
<?if(/*Aiplk::getStartPage()!='sud' and */Aiplk::getStartPage()!='sport'){?>
  <a class="btn_all" onclick="printDiv();return false" href="#">Распечатать</a>
  <a class="btn_all" onclick="if(window.sort_mesta=='Y')window.sort_mesta='N';else window.sort_mesta='Y';$(this).toggleClass('btn_active');return false" href="#">Сортировать по месту</a>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
<?}?>
<?
$title='Установить результат';
$btnClass='prot_add_item';
$popupClass='prot_popup';
$formId='prot_form';
$ajaxFile='protokol_result_save.php';
?>
<div class="popup <?=$popupClass?>">
	<div class="popup__bgd">
	</div>
	<div class="popup__content">
		<div class="popup__close">
      <i class="bx bx-menu"></i>
		</div>
		<div>
			<div class="popup__title">
				<h2><?=$title?></h2>        
			</div>
			<form id="<?=$formId?>" method="post" enctype="multipart/form-data">
        <div class="container">
					
          <div class="row align-items-start">
            <div class="col aip_col_reverse">
              <div class="prot_inp_cont">
              <?for($br=1;$br<=$broskov;$br++){?>
                <label class="form-label">
                  <div>Результат № <?=$br?></div>
                  <input readonly name="prot_results[<?=($br-1)?>]" class="form-control" value="0" type="text">
                </label>
              <?}?>
                <label class="form-label">
                  <div>ИТОГО</div>
                  <input id="protocol_result" class="form-control" value="0" disabled type="text">
                </label>
              </div>
            </div>
            <div class="col prot_btn_bally_add_cont">
              <a href="#">0</a>
              <a href="#">5</a>
              <a href="#">10</a>
              <a href="#">15</a>
              <a href="#">20</a>
              <a href="#">25</a>
              <a href="#">30</a>
              <a href="#">35</a>
              <a href="#">40</a>
              <a href="#">45</a>
              <a href="#">50</a>
              <a href="#">55</a>
              <a href="#">60</a>
              <a id="protocol_clear" href="#">Очистить</a>
            </div>
          </div>
					<div class="prot_data">
              <div>Зчетная серия <b id="data_seriya"></b></div>
              <div>Смена/Стенд <b id="data_smena_stend"></b></div>
              <div><b id="data_name"></b></div>
              <div><g id="data_region">Регион</g></div>					
					</div>
					
        </div>
        <input type="hidden" name="is_changed" id="is_changed" value="N">
        <input type="hidden" name="prot_sportsmen_id" id="prot_sportsmen_id">
        <input type="hidden" name="prot_programma_id" id="prot_programma_id">
        <input type="hidden" name="prot_seriya" id="prot_seriya">
        <input type="hidden" name="prot_id_sorevn" value="<?=$aSorevn['ID']?>" id="prot_id_sorevn">

        <div class="wrap-input100 mt-4 btn_cont_1">
          <input onclick="$(this).parents('.popup__content').find('.popup__close').trigger('click')" type="button" name="go" value="Закрыть" class="questionnaire_btn btn btn-primary">
        </div>

      </form>
		</div>
	</div>
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
<script>
$('.popup.<?=$popupClass?> .popup__bgd, .popup.<?=$popupClass?> .popup__close').on('click', function () {
  $('.popup.<?=$popupClass?>').removeClass('popup_open');
});  
$('body').on('click','.<?=$btnClass?>',function (e) {
  var $aLnk=$(this);
  $aLnk.attr('data-set','N');
  $(".<?=$popupClass?>").addClass("popup_open");
  $('#data_seriya').html($(this).attr('data-seriya'));
  $('#data_region').html($(this).attr('data-region'));
  $('#data_name').html($(this).attr('data-username'));
  $('#prot_sportsmen_id').val($(this).attr('data-userid'));
  $('#prot_programma_id').val($(this).attr('data-id_prog'));
  $('#prot_seriya').val($(this).attr('data-seriya'));
  $('#data_smena_stend').html($(this).attr('data-smena')+'/'+$(this).attr('data-stend'));
  $('.prot_inp_cont input').eq(0).addClass('prot_inp_active');
  $('#is_changed').val('N');
  
  var results=JSON.parse($(this).attr('data-results'));
  var i=0;
  $('.prot_inp_cont input.form-control').each(function(){
    if(results==null||results[i]==null||results[i]=='')$(this).val(0);
    else $(this).val(results[i]);
    i++;
  });
  protokol_calc();
  //$('.prot_inp_cont input')[0].focus();
  e.preventDefault();
  return false;
});
$('body').on('click','.prot_btn_bally_add_cont>a:not(#protocol_clear)',function(e){
  var i=0;
  var v=$(this).html();
  $('.prot_inp_cont input').each(function(e){
    if($(this).hasClass('prot_inp_active')){
      $(this).removeClass('prot_inp_active');
      $("#<?=$formId?> #is_changed").val('Y');
      $(this).val(v).trigger('change');
      $("#<?=$formId?> #is_changed").val('N');
      i++;
      if(i>=$('.prot_inp_cont input').length)i=0;
      return false;
    }
    i++;
  });
  $('.prot_inp_cont input').eq(i).addClass('prot_inp_active');
  //$('.prot_inp_cont input')[i].focus(); 
  e.preventDefault();
  return false;
});
$('body').on('click','#protocol_clear',function(e){
  $('.prot_inp_cont input').each(function(){
    $(this).val(0);
    $('.prot_inp_cont input').eq(0).trigger('click');
  });
  console.log('-nochange?');
  $("#<?=$formId?> #is_changed").val('Y');
  protokol_calc();
  $("#<?=$formId?> #is_changed").val('N');
  e.preventDefault();
  return false;
});
function protokol_calc(){
  var r=$('#protocol_result');
  var s=0;
  $('.prot_inp_cont input:not(#protocol_result)').each(function(){
    s+=parseInt($(this).val());
  });
  r.val(s);
  $("#<?=$formId?>").trigger('submit');
}
$('.prot_inp_cont input').change(function(e){
  protokol_calc();
});

$('body').on('click','.prot_inp_cont input',function(e){
  $('.prot_inp_cont input').removeClass('prot_inp_active');
  $(this).addClass('prot_inp_active');
  e.preventDefault();
  return false;
});
$("#<?=$formId?>").submit(function(e){
  if($("#<?=$formId?> #is_changed").val()!='Y'){
    console.log('nochange');
    //return false;
  }
  $('.overlay_loading').addClass('active');
  var formData=new FormData(this); 
  $.ajax({
      type:"POST",
      url:'/local/templates/lk/ajax/<?=$ajaxFile?>',
      contentType:false,
      processData:false,
      data:formData,
      dataType:'JSON'
  }).done(function(data){
    $('.overlay_loading').removeClass('active');
    // $.post(location.href, function(data2){//убрать потом
    //   $('#protocol_result_table').html($(data2).find('#protocol_result_table').html());
    // });      
    //if(data.err!='')$('.popup-sent h2').html(data.err);
    //$('.popup.popup-sent').addClass('popup_open');
  });
  e.preventDefault();
  return false;
});

//раскоментить для live
window.sort_mesta='N';
window.setInterval(function(){
  $.post(location.href,{'sort_mesta':window.sort_mesta},function(data){
    $('#protocol_result_table').html($(data).find('#protocol_result_table').html());
  });
},3000);


$('.popup.popup-sent .popup__bgd, .popup.popup-sent .popup__close, .popup.popup-sent .popup__close_button').on('click', function () {
                $('.popup.popup-sent').removeClass('popup_open');
                //window.location = '/';
                location.reload();
});
function printDiv(){
  var divToPrint=document.getElementById('tbl_protocol_cont');
  var newWin=window.open('','Протокол соревнования');
  newWin.document.open();
  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
  newWin.document.close();
  setTimeout(function(){newWin.close();},1000);
}
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>