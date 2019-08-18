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
	  
	});

	$('.back-to-top').on('click', function (e) {
		
		var scrollSpeed = 700; // скорость задержки перемещения наверх (в миллисекундах)
		
		e.preventDefault();
		$('html,body').animate({
			scrollTop: 0
		}, scrollSpeed);
		
	});



});