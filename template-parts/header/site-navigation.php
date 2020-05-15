<?php
/**
 * The template for displaying site navigation
 *
 * @package Embed-Gallery
 */
?>

<nav id="site-navigation" class="main-navigation" role="navigation">
	<div class="main-navigation-inside">
		<div class="toggle-menu-wrapper">
			<a href="#header-menu-responsive" title="<?php esc_attr_e('Menu', 'embed-gallery');?>" class="toggle-menu-control">
				<span class="toggle-menu-label"><?php esc_html_e('Menu', 'embed-gallery');?></span>
			</a>
		</div>

		<?php
// Header Menu
wp_nav_menu(apply_filters('embed_header_menu_args', array(
 'container'       => 'div',
 'container_class' => 'site-header-menu',
 'theme_location'  => 'header-menu',
 'menu_class'      => 'header-menu sf-menu',
 'menu_id'         => 'menu-1',
 'depth'           => 3,
)));
?>

	</div><!-- .main-navigation-inside -->
</nav><!-- .main-navigation -->
