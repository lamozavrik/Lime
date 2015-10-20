(function($){

    $.fn.tabs = function(tabs){
        var selector = this.selector;

        this.each(function(i, e){

            $(e).on('click', function(){
                $(selector).removeClass('active');
                $(this).toggleClass('active');
                $(tabs).hide();
                $($(this).data('tab')).show();
            })
        })

        $(this[0]).click();
    }

})(jQuery)