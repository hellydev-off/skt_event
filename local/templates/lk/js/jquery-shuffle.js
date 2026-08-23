(function($){
$.fn.shuffle=function() {
  return this.each(function(){
    var t=$(this);
    var items=$(this).contents('div');
    items=items.sort(function(){return Math.random()-0.5});
    t.empty();
    items.each(function(){$(this).appendTo(t)});
    return $(this);
  });
}
})(jQuery);