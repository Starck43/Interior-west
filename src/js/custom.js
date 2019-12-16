/*
 * Custom scripts library
 *
 * @version 1.8.3
 */

var $ = jQuery.noConflict();
var width;

function checkMobileNavgation(nav) {
	width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
	//height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
	if (!nav.hasClass('burger'))
		if ( width < 992 ) nav.addClass('mobile')
		else nav.removeClass('mobile')
}

document.addEventListener('readystatechange', function(el) {
	if ( document.readyState === 'interactive' ) {}
});

document.addEventListener("DOMContentLoaded", function() {

	$('#dom-preloader').fadeOut(500, function() {
		//$('#dom-preloader').remove();
	});
	$('body').fadeIn(500);
	var overlay = $('#overlay');
	var navigation = $('#header-nav');
	checkMobileNavgation(navigation);
	navigation.css('opacity', 1);
	var burger = $('#nav-burger');
	var mobileMenu = $('ul.primary-menu');
	var mainheader = $('#main-header');
	if (mainheader) mainheader.addClass('visible');
	var scrollup = $('#scroll-up');
	var search = $('#site-search-modal');
	var back2top = $('#link-to-top');
	var gotoBack = $('#link-to-back:not(.show-in-top)');

	var stopScroll;
	var scrollPos_Y;

	function disableScroll() {
		scrollPos_Y = $(window).scrollTop();
		stopScroll = true;
		$('body').addClass('scroll-disabled').css('margin-top', -scrollPos_Y + 'px');

		//$('#overlay .image-box').on("touchmove", function(e) { e.stopPropagation(); });
	}

	function enableScroll() {
		stopScroll = false;
		$('body').removeClass('scroll-disabled').css('margin-top', 0);
		$(window).scrollTop(scrollPos_Y);

		//$('#overlay .image-box').unbind("touchmove");
	}

	function disableTouchMove() {
		document.ontouchmove = function(e) { e.preventDefault(); }
		return true;
	}

	function enableTouchMove() {
		document.ontouchmove = function() { return true; }
		return false;
	}

	// in vewport check script
	inView.offset(0);
	inView('h1')
		.on('enter', el => {
			//el.style.opacity = 1;
			el.classList.add('in-view');
		})
		.on('exit', el => {
			//el.style.opacity = 0.5;
		});
	inView('h2')
		.on('enter', el => {
			el.classList.add('in-view');
		});
	inView('.entry-content >div')
		.on('enter', el => {
			el.classList.add('in-view');
		});


	$( window ).on( 'resize', function( e ) {
		checkMobileNavgation(navigation);

		if (mobileMenu.hasClass('active')) burger.click(); // if burger menu open then close it
	});

	$(window).scroll(function() {
		//addVisibleClass(document.body.querySelectorAll('article')); //viewport.js

		back2top && back2top.topBtnToggle({
			scrollTrigger: 1000,
			//debug: true,
		});

		gotoBack && gotoBack.topBtnToggle({
			scrollTrigger: 1000,
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


/*
// Click event on link starting from # for landing page
	$('a[href^="#"]').on('click', function (e) {
		e.preventDefault();
		var target = $(this).attr('href');
		if ( target.length > 1 && window.location.pathname == '/' && window.location.search == '') { //if home page and no search query and no only #
			//if ($(target).hasClass('animate')) $(target).removeClass('animate');
			if (burger.is(':visible')) burger.click(); //close burger menu on link clicking

			var top = $(target).offset().top;
			$('html, body').animate({scrollTop: top}, 500+top/4); //800 - длительность скроллинга в мс
		} else {
			//target = target.replace(/[^A-Za-z]/g, "");
			location.replace('/'+target);
		}
	});

*/
/*
	burger.on('click', function (e) {
		if (burger.is(':visible')) {
			burger.toggleClass('active');
			$('#menu-top').toggleClass('active');
			$(document.body).toggleClass('modal');
		}
	});
*/

	//New version with own close button in menu
	burger.on('click', function (e) {
		if (!mobileMenu.hasClass('active')) {
			mobileMenu.prepend('<div class="close-icon"></div>');
			//burger.toggleClass('active');
			mobileMenu.addClass('active');
			//$(document.body).toggleClass('modal');
		}
	});

	mobileMenu.on('click','.close-icon', function (e) {
		mobileMenu.removeClass('active').children().remove('.close-icon');
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
		if( e.keyCode == 27 && !overlay.hasClass('hidden') )
			overlay.click() //close overlay form
		else //close burger menu on esc key
		if( e.keyCode == 27 && mobileMenu.hasClass('active') ) mobileMenu.children('.close-icon').click(); // if( e.keyCode == 27 && burger.hasClass('active') ) burger.click();
	});


	scrollup.on('click', function (e) {
		var mc = document.body.querySelector('#main-container');
		scrollup
		.fadeOut('slow')
		.delay(500)
		.remove()
		.delay(500)
		.queue( function() {
			mc.scrollIntoView({block: "start", behavior: "smooth"});
		});
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

	$('#search-close').on('click', function (e) {
		var field_s = search.find('#s');
		if ( field_s.val() ) field_s.val('')
		else search.fadeToggle(300);
	});

	overlay.on('click', function (e) {
		$(this).addClass('hidden');
		enableScroll();
	});

	if ( $('.jcarousel').has('li.slide').length ) {

		$('[data-jcarousel]').each(function() {
			var el = $(this);
			el.jcarousel(el.data());
		});

		var xStart, yStart;
		var stopTouch;
		var slidesPerPage = 1;

		var carousel = $('.jcarousel');
		carousel
			.on('jcarousel:create jcarousel:reload', function() {
				var carousel_w = carousel.parent().innerWidth(),
					carousel_h = carousel.parent().innerHeight();

				slidesPerPage = (carousel_w > carousel_h) ? Math.trunc(  carousel_w / carousel_h ) : 1;

				var slide_width = Math.ceil( carousel_w / slidesPerPage );
				carousel.jcarousel('items').css("width", slide_width + 'px');
			})
			.on('touchstart', function(e) {
				xStart = e.touches[0].screenX;
				yStart = e.touches[0].screenY;
				stopTouch = null;
			})
			.on('touchmove', function(e) {
				var xMovement = Math.abs(e.touches[0].screenX - xStart);
				var yMovement = Math.abs(e.touches[0].screenY - yStart);
				if (stopTouch == null && (xMovement > 10 || yMovement > 10))
					stopTouch = (yMovement < xMovement) ? disableTouchMove() : enableTouchMove();
			})
			.on('touchend touchcancel', function() {
				stopTouch && enableTouchMove();
			})
			.on('jcarousel:createend jcarousel:animateend', function() {
				$(this).jcarousel('target').addClass('active');
			})
			.on('jcarousel:visibleout', 'li', function() {
				$(this).removeClass('active');
			})
			.on('click', 'li', function (e) {
				var src = $(this).attr('src-url');
				if (src) {
					src = 'url('+src+')';
					//var bg = $(e.target).css('background-image');
					//bg = bg.replace('url(','').replace(')','').replace(/\"/gi, "");
					!overlay.children('.imagebox').length && overlay.append('<div class="imagebox"></div><div class="close close-icon" title="Close"></div>');
					overlay.children('.imagebox').css('background-image', src).parent().removeClass('hidden');
					disableScroll();
				}
			})
			.jcarousel({
				//scroll: slidesPerPage,
				//center: true,
				wrap: 'circular',
				animation: 500,
				//transitions: true,
				transitions: Modernizr.csstransitions ? {
					transforms:   Modernizr.csstransforms,
					transforms3d: Modernizr.csstransforms3d,
					easing:       'ease'
				} : false
			})
			//.jcarousel('scroll', '+='+String(slidesPerPage))
			.jcarouselSwipe({
				//perSwipe: slidesPerPage
				//method: 'scrollIntoView' // by default 'scroll'
			});

			if ( 'true' === carousel.attr('data-jcarouselautoscroll') ) {
				carousel.jcarouselAutoscroll({
					interval:  5000,
					//autostart: false,
					//target: '-=1'+String(slidesPerPage)
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
						//target: '-='+String(slidesPerPage)
					});

				$('.jcarousel-control.next')
					.on('jcarouselcontrol:active', function() {
						$(this).removeClass('inactive');
					})
					.on('jcarouselcontrol:inactive', function() {
						$(this).addClass('inactive');
					})
					.jcarouselControl({
						//target: '+='+String(slidesPerPage)
					});
	/*
				if ( !$("html").has("mobile") ) {
					$(".jcarousel-wrapper").hover( function() {
						$('.jcarousel-control').fadeIn(300);
					}, function() {
						$('.jcarousel-control').fadeOut(300);
					});
				}
	*/

			}

		if ( $('.jcarousel-wrapper').has('.jcarousel-pagination').length && 'true' === $('.jcarousel-pagination').attr('data-jcarouselpagination') ) {
			$('.jcarousel-pagination')
				.on('jcarouselpagination:active', 'a', function() {
					$(this).addClass('active');
				})
				.on('jcarouselpagination:inactive', 'a', function() {
					$(this).removeClass('active');
				})
				.jcarouselPagination({
					//'perPage': slidesPerPage
				});
		} else $('.jcarousel-pagination').remove();

	}

	//Adding an agent to HTML selector
	var deviceAgent = navigator.userAgent.toLowerCase();
	if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
		$("html").addClass("mobile");
		$("html").addClass("ios");
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
