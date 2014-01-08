
;(function($) {

	window.main = {
		init: function(){

			$('a[href^=#].scroll-to-btn').click(function(){
				var target = $($(this).attr('href'));
				var offsetTop = (target.length != 0) ? target.offset().top : 0;
				$('html,body').animate({scrollTop: offsetTop},'slow');
				return false;
			});

			$('.mobilenav').on('click', function() {
				console.log('click');
				var navigation = $('#header .main-navigation');
				if(navigation.is(':visible')){
					navigation.slideUp();
				} else {
					navigation.slideDown();
				}
			});

			$('.selectbox.petrol').append('<span data-icon="2" class="icon"></span>');
			$('.selectbox.gear').append('<span data-icon="1" class="icon"></span>');

			$("select").selecter();

			$('.gfield_radio li').on('click', function(event) {
				$('.gfield_radio li label').removeClass('selected');
				$('label', this).addClass('selected');
			});			
		},


		loaded: function(){
			// $('.row .container').eqHeights();
			this.setBoxSizing();
			this.ajaxPage.init();
		},

		setBoxSizing: function(){
			if( $('html').hasClass('no-boxsizing') ){
		        $('.span:visible').each(function(){
		        	console.log($(this).attr('class'));
		        	var span = $(this);
		            var fullW = span.outerWidth(),
		                actualW = span.width(),
		                wDiff = fullW - actualW,
		                newW = actualW - wDiff;
		 			
		            span.css('width',newW);
		        });
		    }
		},		

		ajaxPage: {
			init: function(){
				main.ajaxPage.container = $('#ajax-page');
				pageUrl = main.ajaxPage.pageUrl = window.location.href;

				main.ajaxPage.scrollPosition = 0;
				$('.ajax-btn').unbind('click');
				$(document).on('click', '.ajax-btn', function(e){
					if($(this).hasClass('no-scroll')) {
						main.ajaxPage.scrollPosition = 0;
					} else {
						main.ajaxPage.scrollPosition = main.ajaxPage.container.offset().top;
					}
					// console.log(main.ajaxPage.scrollPosition);
					e.preventDefault();
					main.ajaxPage.load($(this).attr('href'));
					$('html, body').delay(1000).animate({scrollTop: main.ajaxPage.scrollPosition}, 300);
				});

				$(document).on('click', '#ajax-page .close-button', function() {
					main.ajaxPage.close();
				});								
			},

			close: function(){
				$('#ajax-page').slideUp(function(){
					main.ajaxPage.container.html('');
				});
				$('html, body').animate({scrollTop: main.ajaxPage.scrollPosition}, 300);
								
			},

			load: function(url){

				var container = main.ajaxPage.container,
					ajaxUrl = main.ajaxUrl(url);

			    container.slideDown('2000');
			    $('html, body').animate({scrollTop: container.offset().top}, 800, 'easeInOutQuad');
			    if($('.content', container).length == 0){

					loader = $('<div class="loader"></div>').hide();
					container.append(loader);
					container.delay(200).animate({height: loader.actual('outerHeight')}, function(){
						loader.fadeIn();

						$.get(ajaxUrl, function(data) {
							var content = $('<div class="content"></div>').hide();

							container.html(content);
							content.html(data);
							loader.fadeOut(function(){
								if($.fn.imagesLoaded){
									content.imagesLoaded(function(){
										container.animate({'height': content.height()}, function(){
											container.css({'height': 'auto'});
											content.fadeIn();
											container.slideDown('slow');
										});
									});
								} else {
									container.animate({'height': content.actual('height')}, function(){
										container.css({'height': 'auto'});
										content.fadeIn();
									});
								}	
							});

						});
					});
				} else {
					var content = $('.content', container),
						loader = $('<div class="loader"></div>').hide();
					container.prepend(loader);
					content.fadeTo(300, 0, function(){
						loader.fadeIn();
						$.get(ajaxUrl, function(data) {
							content.html(data);
							loader.fadeOut(function(){
								container.animate({'height': content.actual('height')}, function(){
									content.fadeTo(300, 1);
									container.css({'height': 'auto'});
								});
							});
						});
					});
				}
			}
		},

		ajaxUrl: function(url){
			var regex = new RegExp('(\\?|\\&)ajax=.*?(?=(&|$))'),
		        qstring = /\?.+$/;

			if (regex.test(url)){
		        ajaxUrl = url.replace(regex, '$1ajax=true');
		    } else if (qstring.test(url)) {
		        ajaxUrl = url + '&ajax=true';
		    } else {
		        ajaxUrl =  url + '?ajax=true';
		    }

		    return ajaxUrl;		
		},		
		
		resize: function(){
		}
	}

	$(function(){
		main.init();
	});

	$(window).load(function(){
		main.loaded();


		$('.datepicker').datepicker('option', 'minDate', 3);
				
		if(window.location.hash == '#terms-and-conditions') {
		  $('.footer-text a').click();
		}			
	});

})(jQuery);
