<?php
/**
 * The template for displaying search forms.
 *
 * @package Embed-Gallery
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_html_x('Search for:', 'label', 'embed-gallery'); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'embed-gallery'); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x('Search for:', 'label', 'embed-gallery'); ?>" />
	</label>
	<button type="submit" class="search-submit"><span class="screen-reader-text"><?php echo esc_html_x('Search', 'submit button', 'embed-gallery'); ?></span></button>
</form>
