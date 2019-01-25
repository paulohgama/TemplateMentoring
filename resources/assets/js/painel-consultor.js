var MainObj = {
    events: {
        sideNav: function(){
            $("#aside-nav").on( "swiperight", function(event) {
                $('#main-panel-wrap').addClass('active');
                $('#aside-nav').addClass('active');
            });
            $("#aside-nav").on( "swipeleft", function(event) {
                $('#main-panel-wrap').removeClass('active');
                $('#aside-nav').removeClass('active');
            });
            //Outside click
            $(window).click(function() {
                $('#main-panel-wrap').removeClass('active');
                $('#aside-nav').removeClass('active');
            });
            $('#aside-nav').bind('click', function(e){ e.stopPropagation(); })
            $('#aside-nav .icon-list li').bind('click', function(e){
                e.stopPropagation();
               $('#main-panel-wrap').toggleClass('active');
               $('#aside-nav').toggleClass('active');
            });
        },
        passwordLevel: function() {
            var that = window.MainObj;            
            $("#password_check").keyup(function(e) {
                var value = $(this).val();
                              
                that.functions.passwordStrenth(value);
            });
        },
        stateCitySelect: function() {
            if($('#estado').length > 0 && $('#cidade').length > 0) {                
                $.getJSON('/js/estados_cidades.json', function (data) {                    
                    var items = [];
                    var options = '<option value="">Selecione o estado</option>';
                    $.each(data, function (key, val) {
                        options += '<option value="' + val.nome + '">' + val.nome + '</option>';
                    });
                    $("#estado").html(options);                    
                    $("#estado").change(function () {					
                        var options_cidades = '';
                        var str = "";                        
                        $("#estado option:selected").each(function () {
                            str += $(this).text();
                        });
                        $.each(data, function (key, val) {
                            if(val.nome == str) {							
                                $.each(val.cidades, function (key_city, val_city) {
                                    options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
                                });							
                            }
                        });
                        $("#cidade").html(options_cidades);
                        
                    }).change();	
                });
            }
        },
        imgChange: function() {
            $("#img-input").change(function() {           
                window.MainObj.functions.readURL(this);
            });
        },
        datepickers: function() {
		    $.datepicker.regional['pt-BR'] = {
		    closeText: 'Fechar',
		    prevText: '&#x3c;Anterior',
		    nextText: 'Pr&oacute;ximo&#x3e;',
		    currentText: 'Hoje',
		    monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
		    'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
		    'Jul','Ago','Set','Out','Nov','Dez'],
		    dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
		    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
		    dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
		    weekHeader: 'Sm',
		    dateFormat: 'dd/mm/yy',
		    firstDay: 0,
		    isRTL: false,
		    showMonthAfterYear: false,
		    yearSuffix: ''};
		    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);

			$("#data-inicio").datepicker({		  		    
			    onSelect: function (formattedDate) {
			        var date1 = $('#data-inicio').datepicker('getDate'); 
			        var date = new Date( Date.parse(date1));
			        date.setDate( date.getDate() + 1);        
			        var newDate = date.toDateString(); 
			        newDate = new Date( Date.parse(newDate));   
			        $('#data-fim').datepicker("option", "minDate", newDate);        
			    }
			});
			$("#data-fim").datepicker();
		}
    },    
    functions: {
        passwordStrenth: function(senha){  
            console.log('senha', senha)       
            var format = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
            var forca = 0;
            if(senha == '') {
                $('.forca-senha').fadeOut();
            }else {
                $('.forca-senha').fadeIn();
            }
            var mostra = $('.forca-senha span');
            if((senha.length >= 4) && (senha.length <= 7)){
                forca += 10;
            }else if(senha.length>7){
                forca += 25;
            }
            if(senha.match(/[a-z]+/)){
                forca += 10;
            }
            if(senha.match(/[A-Z]+/)){
                forca += 20;
            }
            if(senha.match(/d+/)){
                forca += 20;
            }
            if(format.test(senha)){
                forca += 25;
            }
            //show
            if(forca < 30){
                mostra.css('color', 'red');
                mostra.html('Fraca');
            }else if((forca >= 30) && (forca < 60)){
                mostra.css('color', '#e8e866');
                mostra.html('Justa');
            }else if((forca >= 60) && (forca < 85)){
                mostra.css('color', 'blue');
                mostra.html('Forte');
            }else{
                mostra.css('color', 'green');
                mostra.html('Excelente');
            }
        },
        masks: function () {
            $('[data-date-mask]').mask("99/99/9999");
            $('[data-cel-mask]').mask('(99) 99999-9999');
            $('[data-tel-mask]').mask('(99) 9999-9999');
            $('[data-cpf-mask]').mask('999.999.999-99');
        },
        readURL: function(input) {
            if(input.files && input.files[0]) {
              $('.wrap-file .btn-file').html('Escolher arquivo: ' + input.files[0].name) 
              var reader = new FileReader();
              reader.onload = function(e) {
                $('#frame-view').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
            }
          }
    },
    init: function() {
        this.events.sideNav();
        this.events.passwordLevel();
        this.events.stateCitySelect();
        this.events.imgChange();
        this.events.datepickers();
        this.functions.masks();
    }
}

$(MainObj.init())