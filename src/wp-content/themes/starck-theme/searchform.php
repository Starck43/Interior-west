<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ) ?>" >
	<input type="text" value="<?php echo get_search_query() ?>" name="s" id="s" placeholder="поиск по сайту" />
	<input type="submit" id="searchform-submit" value="найти" />
</form>
<span id="searchform-close" alt="Очистить/Закрыть поле для поиска"></span>