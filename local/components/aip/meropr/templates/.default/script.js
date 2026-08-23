meropr_flt_apply();
function meropr_flt_apply(p){
  var a={};
  $('#meropr_flt li.active').each(function(){
    let v=$(this).attr('data-id');
    let f=$(this).parent().attr('id');
    a[f]=v;
  });
  a.ajax='Y';
  if(p)a.PAGEN_1=p;else a.PAGEN_1='1';
  aip_loader($('#meropr_cont'));
  $.post('/local/components/aip/meropr/ajax.php',a,function(data){
    if(data)$('#meropr_cont').html(data);
    if(p)window.location.href="#meropr_flt";
  });
}
$('body').on('click','#meropr_flt li',function(e){
  $(this).parent().find('li').removeClass('active');
  $(this).addClass('active');
  meropr_flt_apply();
  e.preventDefault();
  return false;
});
$('body').on('click','.main-events-pagination a',function(e){
  meropr_flt_apply($(this).attr('data-page'));
  e.preventDefault();
  return false;
})