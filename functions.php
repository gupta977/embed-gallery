<?php
/**
 * Embed-Gallery functions and definitions
 *
 * @package Embed-Gallery
 */

if (!function_exists('embed_setup')):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
 function embed_setup()
{

  /*
   * Make theme available for translation.
   * Translations can be filed in the /languages/ directory.
   * If you're building a theme based on Embed-Gallery, use a find and replace
   * to change 'embed-gallery' to the name of your theme in all the template files
   */
  load_theme_textdomain('embed-gallery', get_template_directory() . '/languages');

  // Add default posts and comments RSS feed links to head.
  add_theme_support('automatic-feed-links');

  /*
   * Let WordPress manage the document title.
   * By adding theme support, we declare that this theme does not use a
   * hard-coded <title> tag in the document head, and expect WordPress to
   * provide it for us.
   */
  add_theme_support('title-tag');

  /*
   * Enable support for custom logo.
   *
   * @link https://codex.wordpress.org/Theme_Logo
   */
  add_theme_support('custom-logo', array(
   'height'      => 400,
   'width'       => 580,
   'flex-height' => true,
   'flex-width'  => true,
   'header-text' => array('site-title', 'site-description'),
  ));

  /*
   * Enable support for Post Thumbnails on posts and pages.
   *
   * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
   */
  add_theme_support('post-thumbnails');

  // Theme Image Sizes
  add_image_size('embed-gallery-featured', 700, 525, true);
  add_image_size('embed-gallery-featured-single', 769, 0, true);

  // This theme uses wp_nav_menu() in four locations.
  register_nav_menus(array(
   'header-menu' => esc_html__('Header Menu', 'embed-gallery'),
   'top-menu'    => esc_html__('Top Menu', 'embed-gallery'),
  ));

  // This theme styles the visual editor to resemble the theme style.
  add_editor_style(array('css/editor-style.css', embed_fonts_url()));

  /*
   * Switch default core markup for search form, comment form, and comments
   * to output valid HTML5.
   */
  add_theme_support('html5',
   array(
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
   )
  );

  // Setup the WordPress core custom background feature.
  add_theme_support('custom-background', apply_filters('embed_custom_background_args', array(
   'default-color' => 'f9f9f9',
   'default-image' => '',
  )));

  // Add theme support for selective refresh for widgets.
  add_theme_support('customize-selective-refresh-widgets');

  /*
   * Add support for full and wide align images.
   * @see https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#wide-alignment
   */
  add_theme_support('align-wide');

 }
endif; // embed_setup
add_action('after_setup_theme', 'embed_setup');

if (!function_exists('wp_body_open')) {

 /**
  * Shim for wp_body_open, ensuring backward compatibility with versions of WordPress older than 5.2.
  */
 function wp_body_open()
 {
  do_action('wp_body_open');
 }
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function embed_content_width()
{
 // This variable is intended to be overruled from themes.
 // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
 // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
 $GLOBALS['content_width'] = apply_filters('embed_content_width', 769);
}
add_action('after_setup_theme', 'embed_content_width', 0);

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function embed_widgets_init()
{

 // Widget Areas
 register_sidebar(array(
  'name'          => esc_html__('Main Sidebar', 'embed-gallery'),
  'id'            => 'sidebar-1',
  'description'   => esc_html__('Add widgets here to appear in your sidebar.', 'embed-gallery'),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget'  => '</aside>',
  'before_title'  => '<h2 class="widget-title">',
  'after_title'   => '</h2>',
 ));

}
add_action('widgets_init', 'embed_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function embed_scripts()
{

 /**
  * Enqueue JS files
  */

 // Enquire
 wp_enqueue_script('enquire', get_template_directory_uri() . '/js/enquire.js', array('jquery'), '2.1.6', true);

 // Fitvids
 wp_enqueue_script('fitvids', get_template_directory_uri() . '/js/fitvids.js', array('jquery'), '1.1', true);

 // Superfish Menu
 wp_enqueue_script('hover-intent', get_template_directory_uri() . '/js/hover-intent.js', array('jquery'), 'r7', true);
 wp_enqueue_script('superfish', get_template_directory_uri() . '/js/superfish.js', array('jquery'), '1.7.10', true);

 // Comment Reply
 if (is_singular() && comments_open() && get_option('thread_comments')) {
  wp_enqueue_script('comment-reply');
 }

 // Keyboard image navigation support
 if (is_singular() && wp_attachment_is_image()) {
  wp_enqueue_script('embed-gallery-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array('jquery'), '20140127', true);
 }

 // Custom Script
 wp_enqueue_script('embed-gallery-custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), '1.0', true);

 /**
  * Enqueue CSS files
  */

 // Bootstrap Custom
 wp_enqueue_style('embed-gallery-bootstrap-custom', get_template_directory_uri() . '/css/bootstrap-custom.css');

 // Font Awesome 5
 // For Reviewer and Developers: Unique Handle `font-awesome-5` is required to avoid the conflict with Font Awesome 4+ library.
 // Font Awesome 5+ library is completely rewritten and is different from Font Awesome 4+ library.
 wp_enqueue_style('font-awesome-5', get_template_directory_uri() . '/css/fontawesome-all.css');

 // Fonts
 wp_enqueue_style('embed-gallery-fonts', embed_fonts_url(), array(), null);

 // Theme Stylesheet
 wp_enqueue_style('embed-gallery-style', get_stylesheet_uri());

}
add_action('wp_enqueue_scripts', 'embed_scripts');

/**
 * Enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer-core.php';
require get_template_directory() . '/inc/customizer/customizer.php';

//Update theme
require get_template_directory() . '/inc/update/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
 'https://github.com/gupta977/embed_gallery_theme',
 __FILE__,
 'embed-gallery'
);

//Optional: If you're using a private repository, specify the access token like this:
//$myUpdateChecker->setAuthentication('your-token-here');

//Optional: Set the branch that contains the stable release.
$myUpdateChecker->setBranch('master');
//$myUpdateChecker->getVcsApi()->enableReleaseAssets();
