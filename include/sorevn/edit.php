<div class="popup popup-object-edit">
	<div class="popup__bgd">
	</div>
	<div class="popup__content">
		<div class="popup__close">
      <i class="bx bx-menu"></i>
		</div>
		<div>
			<div class="popup__title">
				<h2>Редактирование мероприятия</h2>        
			</div>
			<form id="form_object_edit" method="post" enctype="multipart/form-data">

			</form>
		</div>
	</div>
</div>
<script>
$('.popup.popup-object-edit .popup__bgd, .popup.popup-object-edit .popup__close').on('click', function () {
  $('.popup.popup-object-edit').removeClass('popup_open');
});  
$('.lk_sorevn_edit').click(function (e) {
  var id=$(this).attr('data-id');
  $.post('/local/templates/lk/ajax/sorevn_edit.php',{'get':id},function(data){
    $('#form_object_edit').html(data);
    //select2 1
    $('#form_object_edit').find('.inp_tags').select2({
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
  $(".popup-object-edit").addClass("popup_open");
  e.preventDefault();
  return false;
});
$("#form_object_edit").submit(function (e) {
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: '/local/templates/lk/ajax/sorevn_edit.php',
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
 
</script>