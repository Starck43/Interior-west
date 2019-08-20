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

		if ( $('body').has('.parallax').length ) {
			// preset parallax for header background
			$('.parallax').bgParallax({
				bgpositionY: 50,
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



			if ( bg_class = $('.jcarousel').has('.header-background').length ) {

				$('.jcarousel')
				
					.on('jcarousel:reloadend', function(event, carousel) {
						var li = $(this).jcarousel('target');
						li.addClass('active');
					})
					.on('jcarousel:visibleout', 'li', function() {
						var li = $(this);
						li.removeClass('active');
					})
					.on('jcarousel:visiblein', 'li', function() {
						var li = $(this);
						li.addClass('active');
					})
					.jcarousel({
						wrap: 'circular',
						animation:   1000,
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
					console.log(':'+carousel.target);
					//var target = $('.jcarousel').jcarousel('target'); 
					//$('.jcarousel .li').html(carousel.last);
				}

				if ( $('.jcarousel-wrapper').has('.jcarousel-control').length ) {
					
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

				if ( $('.jcarousel-wrapper').has('.jcarousel-pagination').length ) {
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