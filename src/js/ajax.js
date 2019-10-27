jQuery(function($){
	var actions = {
		updateProjects: function (response) {
			$('#projects-portfolio').html(response);
		},
		loadMoreProjects: function (response) {
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
				parent_term : elem.data('parent-id'), //назваие родительского терма
				paged : elem.data('page'), // номер страницы для загрузки
			},
			beforeSend:function(xhr) {
				elem.parents().find('li').removeClass('active');
				elem.parent().addClass('active');
				elem.css('opacity',0.5); // changing the button hover
			},
			complete: function() {
				elem.css('opacity',1); // changing the button hover back
			},
		});
	}

	$('#projects').on('click','li:not(.has-children) a', function(e){
		e.preventDefault();
		$.when( ajaxRequest($(this)) ).then(
			actions['updateProjects']
		);
	});

	$('#projects-load-more').on('click', function(e){
		e.preventDefault();
		$.when( ajaxRequest($(this)) ).then(
			actions['loadMoreProjects']
		);
	});

});