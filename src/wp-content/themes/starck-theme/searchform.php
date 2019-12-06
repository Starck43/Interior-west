<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ) ?>" >
	<input type="text" value="<?php echo get_search_query() ?>" name="s" id="s" placeholder="<?php esc_html_e('Search', 'starck'); ?>" />
	<input type="submit" id="searchform-submit" value="<?php esc_html_e('Find','starck'); ?>" />
</form>
<div id="search-close" class="close-icon" style="display: none" title="<?php esc_html_e('Close','starck'); ?>"></div>