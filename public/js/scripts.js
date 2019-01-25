// require('jquery-mask-plugin');

//START
var start = {

	plugins: {
		slick: function(){
			$('.slick-slider').slick({
				infinite: true,
				autoplay: true,
  				autoplaySpeed: 8000,
				// infinite: false,
				speed: 500,
				slidesToShow: 2,
                slidesToScroll: 2,
                // prevArrow: '<button class="btn btn-prev"></button>',
    			// nextArrow: '<button class="btn btn-next"></button>'
    			prevArrow: '.slider .btn.btn-prev',
    			nextArrow: '.slider .btn.btn-next',
    			responsive: [{
			        breakpoint: 700,
			        settings: {
			            slidesToShow: 1,
			            slidesToScroll: 1
			        }
			    }]
			})
			$('img[data-lazy]').one('load', function(e) {
                if (this.complete) {
                    $(this).siblings('.ajax-loader').remove();
                }
            });
		},

		mask: function(){
			// CPF or CNPJ
			var CpfCnpjMask = function (val) {
				return val.replace(/\D/g, '').length < 12 ? '000.000.000-009' : '00.000.000/0000-00';
			},
			cpfOptions = {
				onKeyPress: function(val, e, field, options) {
				    field.mask(CpfCnpjMask.apply({}, arguments), options);
				},clearIfNotMatch: true
			};

            $('.cpf_cnpj').mask(CpfCnpjMask, cpfOptions);
            $('.date').mask('99/99/9999');
            $('.cep').mask('99999-999')
            $('input.price').mask('000.000.000.000.000,00', {reverse: true});
            
            var SPMaskBehavior = function (val) {
              return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009'
            }
            
            var spOptions = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options)
                }
            }
            
            $('input.telephone').mask(SPMaskBehavior, spOptions);
            
        },

        simplegallery: function(){
			$(document).ready(function(){
				$('.simple-gallery .galeria-item a').simpleLightbox({
					showCaptions: false,
					closeText: '<span></span>',
					navText: ['<span></span>','<span></span>']
				});
			});
		}
	},

	// EVENTS
	events: {
		init: function(){
			$(function(){
				$('.carousel').carousel();
			});
		},

		facebook_share: function(){
			$(function(){
				$('#facebook_share').on('click', function(){
					var url = "https://www.facebook.com/sharer/sharer.php?u=" + "http://www.osan.com.br/";
					var url = "https://www.facebook.com/sharer/sharer.php?u=" + window.location.href;
					window.open(
						url,
						"Compartilhar no Facebook",
						"width=500,height=300,top=100,left=100"
					);
				});
			});
		},

		twitter_share: function(){
			$(function(){
				$('#twitter_share').on('click', function(){
					// var url = "https://twitter.com/share?url=" + "http://www.osan.com.br/";
					var url = "https://twitter.com/share?url=" + window.location.href;
					window.open(
						url,
						"Compartilhar no Twitter",
						"width=500,height=300,top=100,left=100"
					);
				});
			});
		},
	},

	//INIT OBJECT
	init: function(){
		start.events.init();
		start.plugins.slick();
		start.events.facebook_share();
		start.events.twitter_share();
		// start.plugins.mask();
	}
};
// /START

//INIT OBJECTS
start.init();