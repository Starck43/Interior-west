
jQuery(document).ready(function($) {

	toggleSliderAttr();

	$('#upload-button').on('click', function (e) {
		e.preventDefault();
		var button = $(this);
		var custom_uploader = wp.media({
			title: 'Галерея',
			button: {
				text: 'Добавить фото'
			},
		multiple: true  // multiload
		}).on('select', function() {
			var attachment = custom_uploader.state().get('selection').toJSON();
			var html = '';

			for (var i = 0; i < attachment.length; i++) {

				html = '<div class="postbox-gallery-image"><img src="' + attachment[i]['sizes']['thumbnail']['url'] + '" />'+
				'<a class="gallery-del-image" href="#">x</a><input type="hidden" name="gallery-image[]" value="' + 
				attachment[i]['id'] + '"></div>';
				$('.postbox-gallery-block').append(html);
			}

			toggleSliderAttr();	

		}).open();
	});

	$('.postbox-gallery-block').on('click', 'a', function (e) {
		e.preventDefault();
		$(this).parent().remove();
		toggleSliderAttr();	
	});

	function toggleSliderAttr() {
		$('.postbox-gallery-options').css('display',  $('.postbox-gallery-image').length > 0 ? 'block' : 'none');
	}

});