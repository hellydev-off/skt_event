//lobaschuk@gmail.com
(function($){
    $.fn.lea_menuactive=function(options){
        var defaults={
			'class':'active',//выставляемый класс
			'innerSelect':true//подсвечивать все, содержащие текущий путь
		};
		var options=$.extend(defaults,options);
		$(this).find('a').each(function(){
			var pn=window.location.pathname;
			var pa=$(this).attr('href');
			var apa=pa.split(window.location.hostname);//абсолютные ссылки
			if(apa.length==2)pa=apa[1];
			var apa=pa.split('#');//ссылки с хэшем
			if(apa.length==2)pa=apa[0];
			var apa=pa.split('?');//ссылки с гетом
			if(apa.length==2)pa=apa[0];
			pa=$.trim(pa);pn=$.trim(pn);
			//if(pn.charAt(pn.length-1)!='/')pn+='/';
			if(pa.charAt(pa.length-1)!='/')pa+='/';

			//if($(this).attr('data-checkget')){
				var search=window.location.search;
				pn=pn+search;
				pa=$(this).attr('href');
			//}
//console.log(pa,pn);
			if(pn=='/'&&pa=='/')$(this).addClass(options.class);
			else if(options.innerSelect){
				if(pa!='/'&&pn.indexOf(pa)==0)$(this).addClass(options.class);
			}else{
				if(pa!='/'&&pn==pa)$(this).addClass(options.class);
			}
			
			$(this).click(function(){
				var scroll=(window.scrollY) ? window.scrollY
				  : document.documentElement.scrollTop ? document.documentElement.scrollTop
				  : document.body.scrollTop;				 				
				$.cookie('scroll',scroll,{expires:10000});
			});			
		});
    };
})($);
$(document).ready(function(){$('.lea_menuactive').lea_menuactive();});