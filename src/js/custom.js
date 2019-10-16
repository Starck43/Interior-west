/*
 * Custom scripts library
 *
 * @version 1.0.5
 */


document.addEventListener('readystatechange', function(el) {
	if ( document.readyState === 'interactive' ) {
		var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
		if ( width < 768 ) $('#nav-burger').addClass('burger');
		// Adding class after full DOM loading for applying CSS animation
		//$('#main-header').addClass('visible');
		$.when( $('#dom-preloader').find('i').removeClass('fa-spin').end().delay(500).fadeOut('slow') )
		.done( function() { 
			$('body').fadeIn();
			$('#dom-preloader').remove(); 
		});		
	}
});

document.addEventListener("DOMContentLoaded", function() {

	var navigation = $('#header-nav').css('opacity', 1);
	var burger = $('#nav-burger');
	var mainheader = $('#main-header');
	var scrollup = $('#scroll-up');
	var search = $('#site-search-modal');
	var back2top = $('#back-to-top');
/*
// inView.js
	inView('.someSelector')
		.on('enter', el => {
			el.style.opacity =1;
			el.classList.add('visible');
		})
		.on('exit', el => {
			el.style.opacity = 0.5;
		});	
*/

	$( window ).on( 'resize', function( e ) {
		if ( $(this).width() < 768 ) {
			//navigation.addClass('burger');
			burger.removeClass('hidden');
		} else {
			//navigation.removeClass('burger');
			burger.addClass('hidden');
		}

	});

	$(window).scroll(function() {
		addVisibleClass(document.body.querySelectorAll('article')); //viewport.js
		addVisibleClass(document.body.querySelectorAll('#copyright'));

		$('#back-to-top').topBtnToggle({
			scrollTrigger: 1200,
			//debug: true,
		});

		if ( $('body').has('.parallax').length ) {
			// init parallax for background
			$('.parallax').bgParallax({
				bgpositionY: 50, //it must be the same background-position value in css 
				speed: 0.5,
			});
		}
	});

// Click event on link starting from #
	$('a[href^="#"]').on('click', function (e) {
		e.preventDefault();
		var target = $(this).attr('href');
		if ( window.location.pathname == '/' && window.location.search == '' ) { //if home page
			//if ($(target).hasClass('animate')) $(target).removeClass('animate');
			if (burger.hasClass('burger')) burger.click(); //close burger menu on link clicking

			var top = $(target).offset().top;
			$('html, body').animate({scrollTop: top}, 500+top/4); //800 - длительность скроллинга в мс			
		} else {
			//target = target.replace(/[^A-Za-z]/g, "");
			location.replace('/'+target);
		}
	});

	burger.on('click', function (e) {
		if (burger.hasClass('visible')) {
			burger.toggleClass('active');
			$('#menu-top').toggleClass('active');
			$(document.body).toggleClass('modal');
		}
	});

	var submenu_item = $('.menu-item-has-children a').on('click', function (e) {
		e.preventDefault();
		$(this).parent().toggleClass('collapsed');
	});
		
	$( document ).on( 'keyup', function (e) {
		e.preventDefault();
		if( e.keyCode == 27 && search.is(':visible') )
			search.fadeToggle(300) //close search form
		else
		if( e.keyCode == 27 && burger.hasClass('active') ) burger.click(); // close burger menu on esc key
	});
	
	scrollup.on('click', function (e) {
		var mc = document.body.querySelector('#main-container');
		scrollup
		.fadeOut('slow')
		.delay(1000)
		.queue( function() {
			mc.scrollIntoView({block: "start", behavior: "smooth"});
		})
		.remove();
	});

	back2top.on('click', function (e) {		
		// 800 - скорость задержки перемещения наверх (в миллисекундах)
		e.preventDefault();
		$('html,body').animate({scrollTop: 0}, 800);		
	});

	$('#nav-search').on('click', function (e) {
		if ( !search.attr('display','none') && search.find('#s').val() ) {
			$('#searchform').submit(); 
		} else search.fadeToggle(300);
	});

	$('#searchform').on('submit', function (e) {
		//идет поиск...
		//можно вывести preloader с надписью
	});

	$('#searchform-close').on('click', function (e) {
		var field_s = search.find('#s');
		if ( field_s.val() ) field_s.val('')
		else search.fadeToggle(300);
	});

	if ( $('.jcarousel').length > 0 ) {
		var j = $(".jcarousel-wrapper li");
		if (j.length > 0) j.css("width", j.parents(".jcarousel-wrapper").css("width"));
	}
	
	if ( $('.jcarousel').has('.header-background').length ) {

		$('[data-jcarousel]').each(function() {
			var el = $(this);
			el.jcarousel(el.data());
		});

		$('.jcarousel')		
			.on('jcarousel:reloadend', function(event, carousel) {
				$(this).jcarousel('target').addClass('active');

			})
			.on('jcarousel:visibleout', 'li', function() {
				$(this).removeClass('active');
			})
			.on('jcarousel:visiblein', 'li', function() {
				$(this).addClass('active');
			})
			.jcarousel({
				wrap: 'circular',
				animation: 1000,
				transitions: Modernizr.csstransitions ? {
					transforms:   Modernizr.csstransforms,
					transforms3d: Modernizr.csstransforms3d,
					easing:       'ease'
				} : false
			})
			.jcarouselSwipe();

			if ( 'true' === $('.jcarousel').attr('data-jcarouselautoscroll') ) {
				$('.jcarousel').jcarouselAutoscroll({
					interval:  5000,
					//autostart: false,
					//target: '-=1',
				});
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

			$(".jcarousel-wrapper").hover( function() {
				$('.jcarousel-control').fadeIn(700);
			}, function() {
				$('.jcarousel-control').fadeOut(700);
			});

		}

		if ( $('.jcarousel-wrapper').has('.jcarousel-pagination').length && 'true' === $('.jcarousel-pagination').attr('data-jcarouselpagination') ) {
			$('.jcarousel-pagination')
				.on('jcarouselpagination:active', 'a', function() {
					$(this).addClass('active');
				})
				.on('jcarouselpagination:inactive', 'a', function() {
					$(this).removeClass('active');
				})
				.jcarouselPagination();
		} else $('.jcarousel-pagination').remove();
	}

	//Adding an agent to HTML selector
	var deviceAgent = navigator.userAgent.toLowerCase();
	if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
		$("html").addClass("ios");
		$("html").addClass("mobile");
	}
	if (navigator.userAgent.search("MSIE") >= 0) {
		$("html").addClass("ie");
	}
	else if (navigator.userAgent.search("Chrome") >= 0) {
		$("html").addClass("chrome");
	}
	else if (navigator.userAgent.search("Firefox") >= 0) {
		$("html").addClass("firefox");
	}
	else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
		$("html").addClass("safari");
	}
	else if (navigator.userAgent.search("Opera") >= 0) {
		$("html").addClass("opera");
	}

});
