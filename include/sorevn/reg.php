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
				<h2></h2>        
			</div>
			<div id="<?=$formId?>" method="post"></div>
		</div>
	</div>
</div>

<script>

$(document).ready(function(){
  $('body').on('click','#<?=$formId?> .col_sort',function(e){
    if(!$(this).hasClass('col_sort_active')){
      $('#<?=$formId?> .col_sort').removeClass('col_sort_active');
      $(this).addClass('col_sort_active');
    }else{
      $(this).toggleClass('desc');
    }
    reg_update_data();
    e.preventDefault();
    return false;
  });
  $('body').on('click','#<?=$formId?> .flt_reg_block a',function(e){
    $('#<?=$formId?> .flt_reg_block a').removeClass('lnk_active');
    $(this).addClass('lnk_active ');
    reg_update_data();
    e.preventDefault();
    return false;
  });  
  $('body').on('click','#<?=$formId?> .flt_reg_block2 a',function(e){
    $('#<?=$formId?> .flt_reg_block2 a').removeClass('lnk_active');
    $(this).addClass('lnk_active ');
    reg_update_data();
    e.preventDefault();
    return false;
  });
  $('body').on('click','#<?=$formId?> #reg_add',function(e){
    var _flt_gr=$('.flt_reg_block .lnk_active').attr('data-xmlid');
    $('.overlay_loading').addClass('active');
    $.post('/local/templates/lk/ajax/<?=$ajaxFile?>',{'get':$(this).attr('data-sorevnid'),'flt_gr':_flt_gr,'reg_edit':'Y'},function(data){
      $('#<?=$formId?>').html(data);
      $('.popup.<?=$popupClass?> .popup__title h2').html('Добавить участника');
      cms_setselect2_<?=$formId?>();
      $('.overlay_loading').removeClass('active');
    });
    e.preventDefault();
    return false;    
  }); 
  $('body').on('click','#<?=$formId?> .reg_edit',function(e){
    var id=$('#<?=$formId?> input[name=ID_SOREVN]').val();
    var id_sportsmen=$(this).attr('data-id_sportsmen');
    var _flt_gr=$('.flt_reg_block .lnk_active').attr('data-xmlid');
    $('.overlay_loading').addClass('active');
    $.post('/local/templates/lk/ajax/<?=$ajaxFile?>',{'get':id,'flt_gr':_flt_gr,'reg_edit':'Y','id_sportsmen':id_sportsmen},function(data){
      $('#<?=$formId?>').html(data);
      $('.popup.<?=$popupClass?> .popup__title h2').html('Редактировать участника');
      cms_setselect2_<?=$formId?>();
      $('.overlay_loading').removeClass('active');
    });
    e.preventDefault();
    return false;    
  });
  $('body').on('submit','#reg_edit_form',function(e){
    $('.overlay_loading').addClass('active');
    $.post('/local/templates/lk/ajax/<?=$ajaxFile?>',$(this).serialize(),function(data){
      if(data.err){
        alert(data.err);
        $('.overlay_loading').removeClass('active');
        return false;
      }
      reg_update_data();
      $('.overlay_loading').removeClass('active');
    },'json');
    e.preventDefault();
    return false;
  });
  $('body').on('click','#<?=$formId?> .reg_del',function(e){
    var t=$(this);
    var id=$(this).attr('data-id_sportsmen');
    if(!confirm('Вы уверены?'))return false;
    $('.overlay_loading').addClass('active');
    $.post('/local/templates/lk/ajax/delete_sportsmen.php',{'sportsmen_id':id, 'ID_SOREVN':$('#<?=$formId?> input[name=ID_SOREVN]').val()},function(data){
      if(data.err)console.log(data);
      reg_update_data();
      $('.overlay_loading').removeClass('active');
    },'json');
    e.preventDefault();
    return false;
  });  
  $('body').on('click','#sf_cont_sh',function(e){
    if($('.flt_reg_block2 .lnk_active').attr('data-xmlid')=='all'||$('.flt_reg_block .lnk_active').attr('data-xmlid')=='all'){
      alert('Выберите группу и дисциплину.');
      return false;
    }
    if(!confirm('Вы уверены?'))return false;
    $('.overlay_loading').addClass('active');
    $.post('/local/templates/lk/ajax/shuffle_sportsmen.php',{'ID_SOREVN':$('#<?=$formId?> input[name=ID_SOREVN]').val()},function(data){
      reg_update_data();
      $('.overlay_loading').removeClass('active');
    });
    e.preventDefault();
    return false;
  });
  $('body').on('click','#activate_sprtsn',function(e){
    var t=$(this);
    $('.overlay_loading').addClass('active');
    $.post('/local/templates/lk/ajax/activate_sportsmen.php',{'sportsmen_id':t.attr('data-id'), 'ID_SOREVN':$('#<?=$formId?> input[name=ID_SOREVN]').val()},function(data){
      reg_update_data();
      $('.overlay_loading').removeClass('active');
    },'json');	
    e.preventDefault();
    return false;
  });  
  $('body').on('click','#end_cont_sh',function(e){
    var t=$(this);
    $('.overlay_loading').addClass('active');
    $.post('/local/templates/lk/ajax/registraciya_off.php',{'ID_SOREVN':$('#<?=$formId?> input[name=ID_SOREVN]').val()},function(data){
      if(data.err==''){
        reg_update_data();
      }else t.html(data.err);
      $('.overlay_loading').removeClass('active');
    },'json');	
    e.preventDefault();
    return false;
  });    
  $('body').on('click','#start_cont_sh',function(e){
    var t=$(this);
    $('.overlay_loading').addClass('active');
    $.post('/local/templates/lk/ajax/registraciya_on.php',{'ID_SOREVN':$('#<?=$formId?> input[name=ID_SOREVN]').val()},function(data){
      if(data.err==''){
        reg_update_data();
      }else t.html(data.err);
      $('.overlay_loading').removeClass('active');
    },'json');	
    e.preventDefault();
    return false;
  });  
  $('body').on('click','.reg_zayavka .reg_zayavka_btn',function(e){
    var f=$('.reg_zayavka');
    var formData=new FormData(f[0]);
    $('.overlay_loading').addClass('active');
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
      $('.overlay_loading').removeClass('active');
    });
    e.preventDefault();
    return false;
  });  
});

$('.popup.<?=$popupClass?> .popup__bgd, .popup.<?=$popupClass?> .popup__close').on('click', function () {
  $('.popup.<?=$popupClass?>').removeClass('popup_open');
});  
$('.<?=$btnClass?>').click(function (e) {
  var id=$(this).attr('data-id');
  $('.overlay_loading').addClass('active');
  $.post('/local/templates/lk/ajax/<?=$ajaxFile?>',{'get':id},function(data){
    $('#<?=$formId?>').html(data);
    $('.popup.<?=$popupClass?> .popup__title h2').html('<?=$title?>');
    $('.overlay_loading').removeClass('active');
  });
  $(".<?=$popupClass?>").addClass("popup_open");
  e.preventDefault();
  return false;
});
function reg_update_data(){
  var _sort=$('.col_sort_active').attr('data-field');
  var _sortn='ASC';
  if($('.col_sort_active').hasClass('desc'))_sortn='DESC';
  
  var _flt_gr=$('.flt_reg_block .lnk_active').attr('data-xmlid');
  var _flt_disc=$('.flt_reg_block2 .lnk_active').attr('data-xmlid');

  var id=$('#<?=$formId?> input[name=ID_SOREVN]').val();
  $('.overlay_loading').addClass('active');
  $.post('/local/templates/lk/ajax/<?=$ajaxFile?>',{'ID_SOREVN':id,'get':id,'sort':_sort,'sortn':_sortn,'flt_gr':_flt_gr, 'flt_disc':_flt_disc},function(data){
    $('.popup.<?=$popupClass?> .popup__title h2').html('<?=$title?>');
    if(data)$('#<?=$formId?>').html(data);
    $('.overlay_loading').removeClass('active');
  });
}
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
      url: '/local/templates/lk/ajax/get_sportsmen.php?VGRUPPA='+$('input[name=VGRUPPA]').val(),
      dataType: 'json',
      delay: 250
    }
  }).on('select2:select',function(e){
    var data=e.params.data;
    if(data.region_val){
      var p=$(this).parents('#<?=$formId?>').find('.inp_tags_region');
      var newOption=new Option(data.region_txt, data.region_val, true, true);
      p.append(newOption).trigger('change');
    }
    if(data.data_rozhd){
      $(this).parents('#<?=$formId?>').find('.reg_data_rozhd').val(data.data_rozhd);
    }
    if(data.vozrast_gruppa_val){
      $('#reg_vgr').html(data.vozrast_gruppa_txt);
      $('input[name=VGRUPPA]').val(data.vozrast_gruppa_val);
      // var p=$(this).parents('#<?=$formId?>').find('.inp_vozrast_gruppa');
      // var newOption=new Option(data.vozrast_gruppa_txt, data.vozrast_gruppa_val, true, true);
      // p.append(newOption).trigger('change');
    }
  });
}
</script>