jQuery(function($){
	$('#projects-categories li a').on('click', function(e){
		e.preventDefault();
		var elem = $(this);
		$.ajax({
			url:  window.wp_data.ajax_url,
			type: 'POST', // POST
			data : {
				action : 'projects_filter', //название нашего обработчика в inc/projects_layout.php
				term : elem.data('category-id'), //id услуги из списка услуг
			},
			beforeSend:function(xhr){
				elem.css('opacity',0.5); // changing the button label
			},
			success:function(data){
				//alert(data);
				elem.css('opacity',1); // changing the button label back
				$('#projects-portfolio').html(data); // insert data
			}
		});
	});

	$('#projects-load-more').on('click', function(e){
		e.preventDefault();
		var elem = $(this);
		$.ajax({
			url:  window.wp_data.ajax_url,
			type: "POST",
			data : {
				action : 'projects_filter',
				term : elem.data('category-id'), //id таксономии
				paged : elem.data('page'), // номер страницы для загрузки
			},
			success: function (data) {
				elem.remove(); //удаляем кнопку
				jQuery('#projects-portfolio').append(data); // добавляем в контейнер ответ с сервера
			}
		});
    });

});