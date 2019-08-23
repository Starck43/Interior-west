var isElemVisible = function(el) {
	const { top, height, bottom } = el.getBoundingClientRect(); 
	const screenHeight = document.documentElement.clientHeight;
	var el = el.parentNode;
	do {
		// Check if the element is out of viewport due to a container scrolling
		viewport = el.getBoundingClientRect();
		if (top <= viewport.bottom === false) return false; //below viewport
		if (bottom <= viewport.top) return false; //above viewport
		el = el.parentNode;
	} while (el != document.body);
	// Check its within the document viewport and return moving factor
	return ((screenHeight - top) / height).toFixed(2);
};

var visibleClassToggle = function(selector, modeIn, modeOut, offset) {
	const elem = document.querySelector(selector);
	var factor = isElemVisible(elem);
	factor -= (offset > 0 && offset <= 1 ) ? offset : 0;
	//console.log(toggle_offset);
	if ( factor >= 0 ) { 
		if (!elem.classList.contains('visible')) elem.classList.add('visible');
		if (elem.classList.contains('visible') && modeIn === 'fade' && (factor+offset) <= 1 ) {
			var offset_factor = (factor*(1+offset)+offset*offset).toFixed(2);
			elem.style.opacity = (offset_factor <= 1) ? offset_factor : 1;
		}
	}
	if ( modeOut === 'toggle' && ( factor < 0 ) && elem.classList.contains('visible') ) { 
		elem.classList.remove('visible');
		elem.style.opacity = 0;
	}
}