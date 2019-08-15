/*
 * Custom scripts library
 *
 */

document.addEventListener("DOMContentLoaded", function() {

	
	$(window).scroll(function(){
		// preset parallax for header background
		$('.header-background').bgParallax({
			speed: 0.25,
		});
		
		$('.back-to-top').topBtnToggle({
			scrollTrigger: 400,
		});
	  
	});

	$('.back-to-top').on('click', function (e) {
		
		var scrollSpeed = 500; // скорость задержки перемещения наверх (в миллисекундах)
		
		e.preventDefault();
		$('html,body').animate({
			scrollTop: 0
		}, scrollSpeed);
		
	});

});