//top10_flt
//top10_flt_gruppy
//top10_flt_discipl
//top10_flt_period
top10_flt_apply();
function top10_flt_apply(){
  var a={};
  $('#top10_flt li.active').each(function(){
    let v=$(this).attr('data-id');
    let f=$(this).parent().attr('id');
    a[f]=v;
  });
  a.ajax='Y';
  aip_loader($('#top10_cont'));
  $.post('/local/components/aip/top10/ajax.php',a,function(data){
    if(data){
      $('#top10_cont').html(data[0]);
      $('#flt_discipl').html(data[1]);
    }
  },'json');
}
$('body').on('click','#top10_flt li',function(e){
  $(this).parent().find('li').removeClass('active');
  $(this).addClass('active');
  top10_flt_apply();
  e.preventDefault();
  return false;
});