document.addEventListener('DOMContentLoaded', function() {

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

				html = '<div class="gallery-image"><img src="' + attachment[i]['sizes']['thumbnail']['url'] + '" />'+
				'<a class="gallery-del-image" href="#">удалить</a><input type="hidden" name="gallery-image[]" value="' + 
				attachment[i]['url'] + '"></div>';
				$('.gallery-block').append(html);
			}


			toggleSliderAttr(Boolean(attachment.length),'checkbox');


		}).open();

	});

	$('.gallery-del-image').on('click', function (e) {
		e.preventDefault();
		$(this).parents('.gallery-image').remove();
		toggleSliderAttr(Boolean($('.gallery-image').length));	
	});

	function toggleSliderAttr(isImg = false, value = 'hidden') {
		if (isImg) { $('label.gallery-scroll, label.gallery-pagination').show(); }
		else { $('label.gallery-scroll, label.gallery-pagination').hide(); }
	}
});