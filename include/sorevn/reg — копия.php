<?
$popupClass='popup-object-reg';
$formId='form_object_reg';
$btnClass='lk_sorevn_reg';
$ajaxFile='sorevn_reg.php';
$title='Регистрация';
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
				<h2><?=$title?> <span class="popup_title_add"></span></h2>        
			</div>
			<form id="<?=$formId?>" method="post" enctype="multipart/form-data"></form>
		</div>
	</div>
</div>

<script>
$('body').on('click','#end_cont_sh',function(e){
	var t=$(this);
	$.post('/local/templates/lk/ajax/registraciya_off.php',{'ID_SOREVN':$('input[name=ID_SOREVN]').val()},function(data){
    if(data.err==''){
      $('#<?=$formId?>').html(data.html);
      cms_setselect2_<?=$formId?>();
    }else t.val(data.err);
  },'json');	
	e.preventDefault();
	return false;
});
$('body').on('click','#activate_sprtsn',function(e){
	var t=$(this);
	$.post('/local/templates/lk/ajax/activate_sportsmen.php',{'sportsmen_id':t.attr('data-id'), 'ID_SOREVN':$('input[name=ID_SOREVN]').val()},function(data){
    if(data.err==''){
      $('#<?=$formId?>').html(data.html);
      cms_setselect2_<?=$formId?>();
    }else t.html(data.err);
  },'json');	
	e.preventDefault();
	return false;
});
$('body').on('click','#sf_cont_sh',function(e){
  if(!confirm('Вы уверены?'))return false;
  $('#<?=$formId?> select').select2('destroy');
  $('#<?=$formId?> #sf_cont').shuffle();
  cms_setselect2_<?=$formId?>();
  e.preventDefault();
  return false;
});
$('body').on('click','#<?=$formId?> #reguser_add',function(e){
  $('#<?=$formId?> .aip_col2 select').select2('destroy');
  var p=$('#<?=$formId?> .aip_col2').eq($('#<?=$formId?> .aip_col2').length-1);
  var n=p.clone(true).insertAfter(p);
  n.find('.reguser_del').removeAttr('data-id');
  n.find('.line_num').html('№ '+$('#sf_cont>.aip_col2').length);
  n.find('select').each(function(){
    $(this).attr('name','SUD_NEW['+$(this).attr('data-f')+'][]');
    $(this).addClass('line_cloned');
  });
  cms_setselect2_<?=$formId?>();
  e.preventDefault();
  return false;
});
$('body').on('click','#<?=$formId?> .reguser_del',function(e){
  if($('#<?=$formId?> #sf_cont>div').length==1&&$('#<?=$formId?> .sud_fields_cont.line_cloned').length==1)return false;
  var t=$(this);
  if(id=$(this).attr('data-id')){
    if(!confirm('Вы уверены?'))return false;
    $.post('/local/templates/lk/ajax/delete_sportsmen.php',{'sportsmen_id':id, 'ID_SOREVN':$('input[name=ID_SOREVN]').val()},function(data){
      if(data.err==''){
        $('#<?=$formId?>').html(data.html);
        cms_setselect2_<?=$formId?>();
        let p=$(this).parent().parent().remove();
      }else t.html(data.err);
    },'json');
  }else{
    let p=$(this).parent().parent().remove();
  }
  e.preventDefault();
  return false;
});

$('.popup.<?=$popupClass?> .popup__bgd, .popup.<?=$popupClass?> .popup__close').on('click', function () {
  $('.popup.<?=$popupClass?>').removeClass('popup_open');
});  
$('.<?=$btnClass?>').click(function (e) {
  var id=$(this).attr('data-id');
  $.post('/local/templates/lk/ajax/<?=$ajaxFile?>',{'get':id},function(data){
    $('#<?=$formId?>').html(data);
    $('.<?=$popupClass?> .popup_title_add').html($('input[name=TITLE_SOREVN]').val());
    cms_setselect2_<?=$formId?>();
  });
  $(".<?=$popupClass?>").addClass("popup_open");
  e.preventDefault();
  return false;
});
$('body').on('click','#<?=$formId?> .reg_zayavka_btn',function(){
  var f=$('#<?=$formId?>');
  var formData=new FormData(f[0]);
  formData.delete('SUD_NEW[DISCIPLINY][]');
  $('#<?=$formId?> select.reg_discipl_gruppa.line_cloned').each(function(){
    let v=$(this).val().join(',');
    formData.append('SUD_NEW[DISCIPLINY][]',v); 
  });
  $.ajax({
      type:"POST",
      url:'/local/templates/lk/ajax/reg_zayavka.php',
      contentType:false,
      processData:false,
      data:formData,
      dataType:'JSON'
  }).done(function(data){
    if(data.err!='')$('.popup-sent h2').html(data.err);
    $('.popup.<?=$popupClass?>').removeClass('popup_open');
    $('.popup.popup-sent').addClass('popup_open');
  });
  e.preventDefault();
  return false;
});
$("#<?=$formId?>").submit(function(e){
  var formData=new FormData(this);
  formData.delete('SUD_NEW[DISCIPLINY][]');
  $('#<?=$formId?> select.reg_discipl_gruppa.line_cloned').each(function(){
    let v=$(this).val().join(',');
    formData.append('SUD_NEW[DISCIPLINY][]',v); 
  });
  $('#<?=$formId?> #sf_cont>div').each(function(){
    var n='SUD['+$(this).attr('data-id')+'][SORT]';
    if($(this).find('.line_cloned').length>0)n='SUD_NEW[SORT][]';
    formData.append(n,$(this).index()); 
  });
  $.ajax({
      type:"POST",
      url:'/local/templates/lk/ajax/<?=$ajaxFile?>',
      contentType:false,
      processData:false,
      data:formData,
      dataType:'JSON'
  }).done(function(data){
    if(data.err!='')$('.popup-sent h2').html(data.err);
    $('.popup.<?=$popupClass?>').removeClass('popup_open');
    $('.popup.popup-sent').addClass('popup_open');
  });
  e.preventDefault();
  return false;
});  
function cms_setselect2_<?=$formId?>(){
  $('#<?=$formId?>').find('.inp_tags_region').select2({
    'placeholder':'Не выбрано',
    'tags':false,
    'selectOnClose':false,
    'closeOnSelect':true,
    'ajax':{
      url: '/local/templates/lk/ajax/get_gorod.php',
      dataType: 'json',
      delay: 250
    }
  });
  $('#<?=$formId?>').find('.inp_tags_sportsmen').select2({
    'placeholder':'Не выбрано',
    'tags':false,
    'selectOnClose':false,
    'closeOnSelect':true,
    'ajax':{
      url: '/local/templates/lk/ajax/get_sportsmen.php',
      dataType: 'json',
      delay: 250
    }
  }).on('select2:select',function(e){
    var data=e.params.data;
    if(data.region_val){
      var p=$(this).parents('.sud_fields_cont').find('.inp_tags_region');
      var newOption=new Option(data.region_txt, data.region_val, true, true);
      p.append(newOption).trigger('change');
    }
    if(data.vozrast_gruppa_val){
      var p=$(this).parents('.sud_fields_cont').find('.inp_vozrast_gruppa');
      var newOption=new Option(data.vozrast_gruppa_txt, data.vozrast_gruppa_val, true, true);
      p.append(newOption).trigger('change');
    }
  });
  $('#<?=$formId?>').find('.inp_tags_trener').select2({
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
  $('#<?=$formId?>').find('.inp_tags').select2({
    'placeholder':'Не выбрано',
    'tags':false,
    'selectOnClose':false,
    'closeOnSelect':true,
  });
}
</script>