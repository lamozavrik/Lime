$(function(){

    $('#nav li').has('ul').addClass('parent');

    var windiwVidth = $(window).outerWidth();

    $(window).resize(function(){
        if($(window).outerWidth() > 800){
            $('#nav').show();
        } else {
            $('#nav').hide();
        }
    })

    if(windiwVidth <= 1024){
        $('#nav').hide();
        $('#toggleMenu').on('click', function(){
            $('#nav li').removeClass('hover');
            $('#nav').toggle();
            return false;
        })

        $('#nav a').on('click', function(){
            var el = $(this).parent('li');
            $('#nav li').not(el).not(el.parents()).removeClass('hover');
            el.toggleClass('hover');

            if(el.hasClass('parent'))
                return false;
        });

    } else {

        $('#nav a').on('click', function(){
            if($(this).parent('li').hasClass('parent'))
                return false;
        });

        $('#nav li').hover(function(){
            $(this).addClass('hover');
        }, function(){
            $(this).removeClass('hover');
        });
    }
});