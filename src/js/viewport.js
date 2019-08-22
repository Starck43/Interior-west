var isElemVisible = function(el) {
	const { top, bottom, height } = el.getBoundingClientRect(); 
	var el = el.parentNode;
	do {
		viewport = el.getBoundingClientRect();
		if (top <= viewport.bottom === false) return false;
		// Check if the element is out of view due to a container scrolling
		if ((top + height) <= viewport.top) return false
		el = el.parentNode;
	} while (el != document.body);
	// Check its within the document viewport
	return top <= document.documentElement.clientHeight;
};

var visibleClassToggle = function(selector) {
	var elem = document.querySelector(selector);
	if (!elem.classList.contains('visible') && isElemVisible(elem)) { elem.classList.toggle('visible');}
}