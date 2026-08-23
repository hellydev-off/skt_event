<?
$popupClass='popup-object-otchety';
$formId='form_object_otchety';
$btnClass='lk_otchety';
$ajaxFile='sorevn_otchety.php';
$title='Отчеты';
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
</script>