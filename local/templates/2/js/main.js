/*$(window).scroll(function() {
    let headerBotPos = $('header').outerHeight(true) + 150;
    if ($(window).scrollTop() >= headerBotPos)
    {
        $('header').addClass('fixed');
        setTimeout(function() {
            $('header').addClass('on');
        }, 100);
    }
    else
    {
        $('header').removeClass('fixed');
        setTimeout(function() {
            $('header').removeClass('on');
        }, 50);
    }
})*/
function aip_loader(cont){
  cont.css('position','relative');
  let t='<div style="display:flex;align-items:flex-end;position:absolute;width:100%;height:100%;top:0;left:0;z-index:3" class="overlay_loading"><svg class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg"><circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle></svg></div>';
  $(t).appendTo(cont);
}
$(window).resize(function() {
    $('[data-type="main-filter-wrap"]').each(function() {
        if(window.innerWidth > 900) {
            $(this).find('[data-type="main-filter"]').removeClass('active');
            $(this).find('[data-type="main-filter-cont"]').show();
        } else {
            if(!$(this).find('[data-type="main-filter"]').hasClass('active')) {
                $(this).find('[data-type="main-filter-cont"]').hide();
            }
        }
    })
})

$(document).ready(function() {
    if($('.title-cont-txt.over').length > 0) {
        if (!checkClipPathSupport()) {
            $('.title-cont-txt.over').each(function(){
                $(this).hide();
            })
        }
    }

    $('[data-type="main-filter"]').on('click',function() {

        if(window.innerWidth <= 900) {
            const wrap = $(this).closest('[data-type="main-filter-wrap"]');
            $(this).toggleClass('active');
            wrap.find('[data-type="main-filter-cont"]').slideToggle();
        }
    })

    $('[data-type="main-popup-close"]').on('click', function() {
        $(this).closest('[data-type="main-popup"]').fadeOut();
        $('[data-type="overlay"]').fadeOut();
        $('body').removeClass('disabled');
    })

    $(document).mouseup(function (e) {

        const container = $('[data-type="main-popup"]');
        const target = e.target;
        if (container.css('display')!='none' && container.has(e.target).length === 0 && !$(target).is('[data-type="main-popup"]')){
            $('[data-type="main-popup"]').fadeOut();
            $('[data-type="overlay"]').fadeOut();
            $('body').removeClass('disabled');
        }
    });

    $('.main-event-txt').on('click', function(e) {

        const el = $(this).closest('.main-event');
        const clampedHeight = el.find('.main-event-txt').outerHeight();

        let tempElement = el.clone();
        tempElement.find('.main-event-txt').addClass('no-limit');
        tempElement = tempElement[0];

        const cont = document.createElement('div');
        cont.className = 'container';
        cont.appendChild(tempElement);

        document.body.appendChild(cont);
        const fullHeight = cont.querySelector('.main-event-txt').offsetHeight;
        document.body.removeChild(cont);

        if (clampedHeight < fullHeight) {
            //console.log('Текст ограничен.');
            let txt = $(this).html();
            txt = txt.replace('<i class="icon-comment"></i>','');
            txt = '<div>' + txt + '</div>';
            $('[data-type="main-popup-cont"]').html(txt);
            $('[data-type="main-popup"]').fadeIn();
            $('[data-type="overlay"]').fadeIn();
            $('body').addClass('disabled');
            if(typeof searchScroll === 'undefined') {
                var searchScroll = $('[data-type="main-popup-cont"]').jScrollPane({
                    showArrows: false,
                    maintainPosition: false
                }).data('jsp');
            } else {
                searchScroll.reinitialise();
            }
        } else {
            //console.log('Текст не ограничен.');
        }

        return false;

    })




})

var mainVideo = document.getElementById("mainVideo");

mainVideo.addEventListener('playing', function() {
    $('[data-type="main-video-play"]').html('<i class="icon-pause"></i>');
});

mainVideo.addEventListener('pause', function() {
    $('[data-type="main-video-play"]').html('<i class="icon-play"></i>');
});

$('[data-type="main-video-play"]').on('click', function() {
    const video = document.getElementById("mainVideo");
    if (video.paused) {
        video.play();
        $(this).html('<i class="icon-pause"></i>');
    } else {
        video.pause();
        $(this).html('<i class="icon-play"></i>');
    }
})

function checkClipPathSupport() {
    const element = document.createElement('div');
    element.style.clipPath = 'polygon(50% 0%, 0% 100%, 100% 100%)';
    const hasClipPath = element.style.clipPath === 'polygon(50% 0%, 0% 100%, 100% 100%)' ||
        element.style.clipPath !== '';
    return hasClipPath;
}


