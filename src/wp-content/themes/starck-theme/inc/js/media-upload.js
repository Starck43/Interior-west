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

				html = '<div class="gallery-image"><img src="' + attachment[i]['url'] + '" />'+
				'<a class="gallery-del-image" href="#">удалить</a><input type="hidden" name="gallery-image[]" value="' + 
				attachment[i]['url'] + '"></div>';
				$('.gallery-block').append(html);
			}

/*			if (attachment.length > 0) {
				var url_list = (attachment.map(({ url }) => url).join('|'));
				$('#gallery-images-url').val(url_list); //Record value to hidden input field
			}
			console.log(url_list);

*/		}).open();

	});

	$('.gallery-del-image').on('click', function (e) {
		e.preventDefault();
		//$(this).closest('.gallery-image').remove();
		$(this).parents('.gallery-image').remove();
	});
});