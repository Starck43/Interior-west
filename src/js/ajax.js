jQuery(function($){
	var actions = {
		updateProjects: function (response) {
			$('#projects-portfolio').html(response);
			title = $('#projects-categories li.active').text();
			$('#projects-entry h1').html(title);
		},
		loadMoreProjects: function (response) {
			$('#projects-load-more').remove();
			$('#projects-portfolio').append(response);
		},
	};

	$.ajaxSetup({
		url:  window.wp_data.ajax_url,
		type: 'POST', // POST
		error: function(jqXHR, textStatus, errorThrown) {
			console.log('Ошибка: ' + textStatus + ' | ' + errorThrown);
		}
	});

	function ajaxRequest(elem, responseHandler) {
		return $.ajax({
			data: {
				action : 'projects_filter', //название нашего обработчика в inc/projects_layout.php
				term : elem.data('id'), //назваие терма
				paged : elem.data('page'), // номер страницы для загрузки
			},
			beforeSend:function(xhr) {
				if (responseHandler == 'cat-item') {
					elem.parents().find('li').removeClass('active');
					elem.parent().addClass('active');
					elem.css('opacity',0.5); // changing the button hover
				} else elem.html('Загрузка...');
			},
			complete: function() {
				if (responseHandler == 'cat-item') elem.css('opacity',1); // changing the button hover back
			},
		});
	}

	$('#projects').on('click','li:not(.has-children) a', function(e){
		e.preventDefault();
		$.when( ajaxRequest( $(this), 'cat-item' ) ).then(
			actions['updateProjects']
		);
	});

	$('#projects').on('click','#projects-load-more', function(e){
		e.preventDefault();
		$.when( ajaxRequest( $(this) ) ).then(
			actions['loadMoreProjects']
		);
	});

});