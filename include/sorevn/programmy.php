<?
$popupClass='popup-object-prog_add';
$formId='form_object_prog_add';
$btnClass='lk_sorevn_prog_add';
$ajaxFile='sorevn_prog_add.php';
$title='Программа соревнования';
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
			<form id="<?=$formId?>" method="post" enctype="multipart/form-data"></form>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	$('body').on('change','select.inp_varetap',function(e){
		var cont=$(this).parents('div.prog_item');
		var a=JSON.parse($(this).find('option:selected').attr('data-etapy'));
		if(a){
			cont.find('.table_cont table tr').css('display','none');
			cont.find('input.prog_etap').attr('disabled',true);
			cont.find('input.prog_etap').prop('checked',false);
			a.forEach(function(item) {
    		cont.find('.prog_etap_'+item).css('display','table-row');
    		cont.find('input.prog_etap[value='+item+']').prop('checked',true);
    		cont.find('input.prog_etap[value='+item+']').attr('disabled',false);
			});
		}
		cms_prg_get_kolvo($(this).parents('div.prog_item'));
    e.preventDefault();
    return false;
	});
  $('body').on('change','.prog_etap_activate',function(e){
    var p=$(this).parents('tr');
    if($(this).is(':checked')){
      p.find('input').prop('disabled',false);
    }else{
      p.find('input').not(this).prop('disabled',true);
    }
  });
  $('body').on('click','#<?=$formId?> #prog_add',function(e){
    $('#<?=$formId?> select').select2('destroy');
    var p=$('#<?=$formId?> .prog_cont');
    var n=p.find('.prog_item').eq(0).clone(true).appendTo(p);
    n.find('input.prog_etap').attr('data-id','');
    n.find('input[type=text],input[type=number],input[type=date],input[type=time]').not('.prog_seriy').val('');
    n.find('option:selected').prop('selected',false);
    n.find('input[type=checkbox]').prop('checked',false).trigger('change');
    n.find('input').prop('disabled',false);
    n.find('tr').css('display','none');
    n.find('.prog_del').attr('data-id','');
    cms_setselect2_<?=$formId?>();
    e.preventDefault();
    return false;
  });
  $('body').on('click','#<?=$formId?> .prog_del',function(e){
    if($(this).parents('.prog_cont').find('.prog_item').length<2)return false;
    if(!confirm('Вы уверены?'))return false;
    if($(this).attr('data-id')!=''){
      var deleteItem=[];
      $(this).parent().parent().find('tr').each(function(){
        var chbEtap=$(this).find('input.prog_etap');
        if(parseInt(chbEtap.attr('data-id'))>0)deleteItem.push(chbEtap.attr('data-id'));
      });
      prog_delete(deleteItem,$('#<?=$formId?>'));
    }else{
      $(this).parents('div.prog_item').remove();
    }
    e.preventDefault();
    return false;
  });
  $('body').on('submit','#<?=$formId?>',function(e){
    var formData=new FormData();
    var deleteItem=[];
    var i=0;
    $(this).find('.prog_item').each(function(){
      var prgGr=$(this).find('select.prog_vozrgr').val();
      var prgDisc=$(this).find('select.prog_discipl').val();
      // var prgVarStend=$(this).find('select.inp_varstend').val();
      // var prgVarStendTxt=$(this).find('select.inp_varstend option:selected').attr('data-kolvo');
      var prgVarEtap=$(this).find('select.inp_varetap').val();
      $(this).find('tr').each(function(){
        var chbEtap=$(this).find('input.prog_etap');
        //inp_varstend
        var prgVarStend=$(this).find('select.inp_varstend').val();
        var prgVarStendTxt=$(this).find('select.inp_varstend option:selected').attr('data-kolvo');        
        if(!chbEtap.is(':checked')){
          //console.log(chbEtap[0]);
          if(parseInt(chbEtap.attr('data-id'))>0)deleteItem.push(chbEtap.attr('data-id'));
          return true;
        }
        formData.append('prog['+i+'][ID]',$(this).find('input.prog_etap').attr('data-id'));
        formData.append('prog['+i+'][VOZRAST_GRUPPA]',prgGr);
        formData.append('prog['+i+'][DISCIPLINA]',prgDisc);
        formData.append('prog['+i+'][ETAP]',$(this).find('input.prog_etap').val());
        formData.append('prog['+i+'][KOLVO_STENDOV]',prgVarStendTxt);
        formData.append('prog['+i+'][KOLVO_SERIY]',$(this).find('input.prog_seriy').val());
        formData.append('prog['+i+'][SO_STENDA]',$(this).find('input.prog_so_stenda').val());
        formData.append('prog['+i+'][S_SERII]',$(this).find('input.prog_s_serii').val());
        formData.append('prog['+i+'][VREMYA_NACH1]',$(this).find('input.prog_data').val());
        formData.append('prog['+i+'][VREMYA_NACH2]',$(this).find('input.prog_vremya').val());
        formData.append('prog['+i+'][KOLVO_UCH]',$(this).find('input.prog_kolvo').val());
        formData.append('prog['+i+'][KOLVO_BROSKOV]',$(this).find('input.prog_broskov').val());
        formData.append('prog['+i+'][VARETAP]',prgVarEtap);
        formData.append('prog['+i+'][VARSTEND]',prgVarStend);
        i++;
      });
    });
    // console.log(formData);
    // return false;
    formData.append('ID_SOREVN',$('#<?=$formId?> input[name=ID_SOREVN]').val());    
    if(deleteItem.length>0)prog_delete(deleteItem,false);
    $('.overlay_loading').addClass('active');
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
      $('.overlay_loading').removeClass('active');
    });
    e.preventDefault();
    return false;    
  });
  $('.popup.<?=$popupClass?> .popup__bgd, .popup.<?=$popupClass?> .popup__close').on('click', function () {
    $('.popup.<?=$popupClass?>').removeClass('popup_open');
  });  
  $('.<?=$btnClass?>').click(function (e) {
    var id=$(this).attr('data-id');
    $('.overlay_loading').addClass('active');
    $.post('/local/templates/lk/ajax/<?=$ajaxFile?>',{'get':id},function(data){    
      $('#<?=$formId?>').html(data);
      cms_setselect2_<?=$formId?>();
      $('.overlay_loading').removeClass('active');
    });
    $(".<?=$popupClass?>").addClass("popup_open");
    e.preventDefault();
    return false;
  });
});
function cms_prg_get_kolvo($cont){
  var sorevn_id=$('#<?=$formId?> input[name=ID_SOREVN]').val();
  var disc=$cont.find('select.prog_discipl').val();
  var gruppa=$cont.find('select.prog_vozrgr').val();
        var prgVarStend=$cont.find('select.inp_varstend').val();
      var prgVarStendTxt=$cont.find('select.inp_varstend option:selected').attr('data-kolvo');
      var prgVarEtap=$cont.find('select.inp_varetap').val();
  var etap=[];
  $cont.find('input.prog_etap:checked').each(function(){
    etap.push($(this).val());
  });
  $('.overlay_loading').addClass('active');
  $.post('/local/templates/lk/ajax/prog_get_kolvo.php',{'ID_SOREVN':sorevn_id,'disc':disc,'gruppa':gruppa,'etap':etap, 'prgVarEtap':prgVarEtap},function(data){
    if(data.err)console.log(data.err);
    for(et in data.etap){
      let inp=$cont.find('.prog_etap_'+et+' input.prog_kolvo');
      if(data.etap[et]!=0&&data.etap[et]!=''){
        inp.val(data.etap[et]);
        inp.trigger('change');        
      }
    }
    $('.overlay_loading').removeClass('active');
  },'json');
}
function cms_setselect2_<?=$formId?>(){
  $('#<?=$formId?>').find('.inp_tags').select2({
    'placeholder':'Не выбрано',
    'tags':false,
    'selectOnClose':false,
    'closeOnSelect':true,
    'minimumResultsForSearch':'Infinity'
  });
}
function prog_delete(a,$cont){
  $('.overlay_loading').addClass('active');
  $.post('/local/templates/lk/ajax/delete_prog.php',{'prog_id':a,'ID_SOREVN':$('#<?=$formId?> input[name=ID_SOREVN]').val()},function(data){
    if($cont){
      $cont.html(data.html);
      cms_setselect2_<?=$formId?>();
    }
    $('.overlay_loading').removeClass('active');
  },'json');
}
</script>