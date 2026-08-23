<?
$popupClass='popup-object-sud_add';
$formId='form_object_sud_add';
$btnClass='lk_sorevn_sud_add';
$ajaxFile='sorevn_sud_add.php';
$title='Судейская коллегия';
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
$('body').on('click','#<?=$formId?> #sudya_add',function(e){
	$('#<?=$formId?> .aip_col2 select').select2('destroy');
  var p=$('#<?=$formId?> .aip_col2').eq($('#<?=$formId?> .aip_col2').length-1);
  var n=p.clone(true).insertAfter(p);
  n.find('option:selected').removeAttr('selected');
  n.find('.inp_tags_sportsmen,.inp_tags_region').empty();
	n.find('.sudya_del').removeAttr('data-id');
  n.find('select').each(function(){
    $(this).attr('name','SUD_NEW['+$(this).attr('data-f')+'][]');
    $(this).addClass('line_cloned');
  });
  cms_setselect2_<?=$formId?>();
  e.preventDefault();
  return false;
})
$('body').on('click','#<?=$formId?> .sudya_del',function(e){
  if($('#<?=$formId?> #sf_cont>div').length==1&&$('#<?=$formId?> .sud_fields_cont').attr('data-id')=='')return false;
  var t=$(this);
  if(id=$(this).attr('data-id')){
    if(!confirm('Вы уверены?'))return false;
    $.post('/local/templates/lk/ajax/delete_sudman.php',{'sportsmen_id':id, 'ID_SOREVN':$('#<?=$formId?> input[name=ID_SOREVN]').val()},function(data){
      if(data.err==''){
        $('#<?=$formId?>').html(data.html);
        cms_setselect2_<?=$formId?>();
        let p=$(this).parent().remove();
      }else t.html(data.err);
    },'json');
  }else{
    let p=$(this).parent().remove();
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
$("#<?=$formId?>").submit(function(e){
  var formData=new FormData(this);
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
      url: '/local/templates/lk/ajax/get_sudman.php',
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
    if(data.kat_val){
      console.log(data);
      var p=$(this).parents('.sud_fields_cont').find('.inp_kateg_sud');
      var newOption=new Option(data.kat_txt, data.kat_val, true, true);
      p.append(newOption).trigger('change');
    }
  }); 
  $('#<?=$formId?>').find('.inp_tags_dolzhnost').select2({
    'placeholder':'Не выбрано',
    'tags':false,
    'selectOnClose':false,
    'closeOnSelect':true,
    'minimumResultsForSearch':'Infinity',
  }).on('select2:selecting',function(e){
		$(this).attr('data-old',e.currentTarget.value);
	}).on('select2:select',function(e){		
    if($('#<?=$formId?> option[value=main_sud]:selected').length==2&&e.currentTarget.value=='main_sud'){
      console.log(e.currentTarget.value, $(this).attr('data-old'));
      $(e.currentTarget).val($(e.currentTarget).attr('data-old')).trigger('change');
			alert('Главный судья уже выбран.');
      e.preventDefault();
			return false;
		}
	});  
	$('#<?=$formId?>').find('.inp_tags').select2({
    'placeholder':'Не выбрано',
    'tags':false,
    'selectOnClose':false,
    'closeOnSelect':true,
    'minimumResultsForSearch':'Infinity'
  });
} 
</script>