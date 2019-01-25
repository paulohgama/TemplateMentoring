console.log('Anybody there');

var MainObj = {
    events: {
        pullDown: function(){
            $('#go-down').bind('click', function(){
                //$('#consultants').
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#consultants").offset().top
                }, 1000);
            })
        },
        ratingstar: function() {
            $('.rating').barrating({
                // theme: 'fontawesome-stars',
                theme: 'fontawesome-stars',
                readonly: true,
            });
            //$('.rating').barrating('set', $('.rating').data('rating'));
            $('.rating').each(function(index){
                $(this).barrating('set', $(this.data('rating')))
            });
        },
        ratingstarchoose: function() {
            $('.rating').barrating({
                // theme: 'fontawesome-stars',
                theme: 'fontawesome-stars',
                readonly: false
              
            });
            $('.rating').barrating('set', $('.rating').data('rating'));
        },
        closedRegisterTab: function() {
            $('[data-close-upfront]').bind('click', function(){
                $('.upfront-content').addClass('closed');
            });
        },
        masks: function () {
            $('[data-date-mask]').mask("99/99/9999");
            $('[data-cel-mask]').mask('(99) 99999-9999');
            $('[data-tel-mask]').mask('(99) 9999-9999');
            $('[data-cpf-mask]').mask('999.999.999-99');
        },
        loggedMenu: function() {
            $('[data-btn-logged]').bind('click', function(e){
                $(this).toggleClass('active');
                e.preventDefault();
                $('.tiny-menu').fadeToggle();
            })
        },
        disableReadOnly: function () {
            $('.wrap-readonly .fa').bind('click', function(){          
                $(this).parent().children('input').prop('readonly') ? 
                $(this).parent().children('input').prop('readonly', false) :
                $(this).parent().children('input').prop('readonly', true)
            });
        },      
    },
    init: function() {
        this.events.pullDown();
        this.events.masks();
        this.events.loggedMenu();       
    }
}


$(MainObj.init());

