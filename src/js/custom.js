/*
 * Custom scripts library
 *
 */

document.addEventListener("DOMContentLoaded", function() {

	
	$(window).scroll(function(){

		$('.back-to-top').topBtnToggle({
			scrollTrigger: 400,
			//debug: true,
		});

		if ( $('main').find('.header-background').length > 0 ) {
			// preset parallax for header background
			$('.header-background').bgParallax({
				speed: 0.5,
			});
  		}
	});

	$('.back-to-top').on('click', function (e) {
		
		var scrollSpeed = 700; // скорость задержки перемещения наверх (в миллисекундах)
		
		e.preventDefault();
		$('html,body').animate({
			scrollTop: 0
		}, scrollSpeed);
		
	});



			if ( $('main').find('.jcarousel .header-background').length > 0 ) {
				$('.jcarousel')
					.jcarousel({
						wrap: 'circular',
						animation:   800,
						itemLoadCallback: trigger,
						transitions: Modernizr.csstransitions ? {
							transforms:   Modernizr.csstransforms,
							transforms3d: Modernizr.csstransforms3d,
							easing:       'ease'
						} : false
					})
					.jcarouselSwipe();

				$('.jcarousel').jcarouselAutoscroll({
					autostart: false,
					interval:  5000,
					//target: '-=1',
				});

				function trigger(carousel, state) { 
					//index = carousel.index(carousel.last);
					//$('.jcarousel .li').html(carousel.last);
				}

				if ( $('.jcarousel-wrapper').find('.jcarousel-control').length > 0 ) {
					
					$('.jcarousel-control.prev')
						.on('jcarouselcontrol:active', function() {
							$(this).removeClass('inactive');
						})
						.on('jcarouselcontrol:inactive', function() {
							$(this).addClass('inactive');
						})
						.jcarouselControl({
							target: '-=1'
						});

					$('.jcarousel-control.next')
						.on('jcarouselcontrol:active', function() {
							$(this).removeClass('inactive');
						})
						.on('jcarouselcontrol:inactive', function() {
							$(this).addClass('inactive');
						})
						.jcarouselControl({
							target: '+=1'
						});

				}

				if ( $('.jcarousel-wrapper').find('.jcarousel-pagination').length > 0 ) {
					$('.jcarousel-pagination')
						.on('jcarouselpagination:active', 'a', function() {
							$(this).addClass('active');
						})
						.on('jcarouselpagination:inactive', 'a', function() {
							$(this).removeClass('active');
						})
						.jcarouselPagination();
				}
			}

});