<?
$popupClass='popup-object-protokoly';
$formId='form_object_protokoly';
$btnClass='lk_sorevn_protokoly';
$ajaxFile='sorevn_protokoly.php';
$title='Протоколы соревнования';
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
$('.popup.<?=$popupClass?> .popup__bgd, .popup.<?=$popupClass?> .popup__close').on('click', function () {
  $('.popup.<?=$popupClass?>').removeClass('popup_open');
});  
$('.<?=$btnClass?>').click(function (e) {
  var id=$(this).attr('data-id');
  $.post('/local/templates/lk/ajax/<?=$ajaxFile?>',{'get':id},function(data){
    $('#<?=$formId?>').html(data);
  });
  $(".<?=$popupClass?>").addClass("popup_open");
  e.preventDefault();
  return false;
});
$("#<?=$formId?>").submit(function(e){
  var formData=new FormData(this); 
  $('select.aip_prog_vgruppa').each(function(){
    var v=$(this).val();
    formData.append('SUD[VOZRAST_GRUPPA][]',v);
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
    $('.popup.popup-sent').addClass('popup_open');
  });
  e.preventDefault();
  return false;
});  
$('body').on('keypress','.inp_prog_so_stenda,.inp_prog_s_serii',function(e){
  $('#btn_prot_save').removeClass('disabled'); 
})
$('body').on('click','#btn_prot_save',function(e){
  var tbtn=$(this);
  var ret={};
  $('.inp_prog_so_stenda:visible').each(function(){
    let t=$(this);
    let t2=t.parents('tr').find('input.inp_prog_s_serii');
    ret[t.attr('data-id_prog')]={'SO_STENDA':t.val(), 'S_SERII':t2.val()};
  });  
  let id_sorevn=$('#ID_SOREVN').val();
  $('.overlay_loading').addClass('active');
  $.post('/local/templates/lk/ajax/prog_set_first_stend.php',{'ID_SOREVN':id_sorevn, 'data':JSON.stringify(ret)},function(data){
    if(data.err)tbtn.val(data.err);
    $('.overlay_loading').removeClass('active');
  },'json');
})
</script>