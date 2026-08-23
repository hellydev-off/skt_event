$('body').on('submit','#feedbackModal form',function(e){
  if(!$(this)[0].checkValidity()){
    $('#successMessage').html('Заполните обязательные поля !');
  }else{
    $.post($(this).attr('action'),$(this).serialize(),function(data){
      $('#feedbackModal').html($(data).find('#feedbackModal').html());
    });
  }
  e.preventDefault();
	return false;
})