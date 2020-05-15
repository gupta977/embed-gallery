<?php
/**
 * Theme Customizer
 *
 * @package Embed-Gallery
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function embed_customize_register($wp_customize)
{

 $wp_customize->get_setting('blogname')->transport         = 'postMessage';
 $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
 $wp_customize->get_setting('background_color')->transport = 'postMessage';
 $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

 /**
  * Theme Options Panel
  */
 $wp_customize->add_panel('embed_theme_options', array(
  'title'    => esc_html__('Theme Options', 'embed-gallery'),
  'priority' => 1,
 ));

 /**
  * General Options Section
  */
 $wp_customize->add_section('embed_general_options', array(
  'title'       => esc_html__('General Options', 'embed-gallery'),
  'panel'       => 'embed_theme_options',
  'priority'    => 10,
  'description' => esc_html__('Personalize the general settings of your theme.', 'embed-gallery'),
 ));

 // Read More Label
 $wp_customize->add_setting('embed_read_more_label', array(
  'default'           => embed_default('embed_read_more_label'),
  'transport'         => 'postMessage',
  'sanitize_callback' => 'sanitize_text_field',
 ));

 $wp_customize->add_control('embed_read_more_label', array(
  'label'    => esc_html__('Read More Label', 'embed-gallery'),
  'section'  => 'embed_general_options',
  'priority' => 1,
  'type'     => 'text',
 ));

 // Excerpt Length
 $wp_customize->add_setting('embed_excerpt_length', array(
  'default'           => embed_default('embed_excerpt_length'),
  'sanitize_callback' => 'absint',
 ));

 $wp_customize->add_control('embed_excerpt_length', array(
  'label'       => esc_html__('Excerpt Length', 'embed-gallery'),
  'description' => esc_html__('Zero (0) length will not show the excerpt.', 'embed-gallery'),
  'section'     => 'embed_general_options',
  'priority'    => 2,
  'type'        => 'number',
 ));

 // Post Thumbnail Single Control
 $wp_customize->add_setting('embed_post_thumbnail_single', array(
  'default'           => embed_default('embed_post_thumbnail_single'),
  'sanitize_callback' => 'embed_sanitize_checkbox',
 ));

 $wp_customize->add_control('embed_post_thumbnail_single', array(
  'label'    => esc_html__('Display Featured Image at Single Posts', 'embed-gallery'),
  'section'  => 'embed_general_options',
  'priority' => 3,
  'type'     => 'checkbox',
 ));

 /**
  * Layout Options Section
  */
 $wp_customize->add_section('embed_layout_options', array(
  'title'       => esc_html__('Layout Options', 'embed-gallery'),
  'panel'       => 'embed_theme_options',
  'priority'    => 20,
  'description' => esc_html__('Personalize the layout settings of your theme.', 'embed-gallery'),
 ));

 // Theme Layout
 $wp_customize->add_setting('embed_theme_layout', array(
  'default'           => embed_default('embed_theme_layout'),
  'sanitize_callback' => 'embed_sanitize_select',
 ));

 $wp_customize->add_control('embed_theme_layout', array(
  'label'       => esc_html__('Theme Layout', 'embed-gallery'),
  'description' => esc_html__('Box layout will be visible at minimum 1200px display', 'embed-gallery'),
  'section'     => 'embed_layout_options',
  'priority'    => 1,
  'type'        => 'select',
  'choices'     => array(
   'wide' => esc_html__('Wide', 'embed-gallery'),
   'box'  => esc_html__('Box', 'embed-gallery'),
  ),
 ));

 // Main Sidebar Position
 $wp_customize->add_setting('embed_sidebar_position', array(
  'default'           => embed_default('embed_sidebar_position'),
  'sanitize_callback' => 'embed_sanitize_select',
 ));

 $wp_customize->add_control('embed_sidebar_position', array(
  'label'    => esc_html__('Main Sidebar Position (if active)', 'embed-gallery'),
  'section'  => 'embed_layout_options',
  'priority' => 2,
  'type'     => 'select',
  'choices'  => array(
   'right' => esc_html__('Right', 'embed-gallery'),
   'left'  => esc_html__('Left', 'embed-gallery'),
  ),
 ));

 /**
  * Footer Section
  */
 $wp_customize->add_section('embed_footer_options', array(
  'title'       => esc_html__('Footer Options', 'embed-gallery'),
  'panel'       => 'embed_theme_options',
  'priority'    => 30,
  'description' => esc_html__('Personalize the footer settings of your theme.', 'embed-gallery'),
 ));

 // Copyright Control
 $wp_customize->add_setting('embed_copyright', array(
  'default'           => embed_default('embed_copyright'),
  'transport'         => 'postMessage',
  'sanitize_callback' => 'wp_kses_post',
 ));

 $wp_customize->add_control('embed_copyright', array(
  'label'    => esc_html__('Copyright', 'embed-gallery'),
  'section'  => 'embed_footer_options',
  'priority' => 1,
  'type'     => 'textarea',
 ));

 // Credit Control
 $wp_customize->add_setting('embed_credit', array(
  'default'           => embed_default('embed_credit'),
  'transport'         => 'postMessage',
  'sanitize_callback' => 'embed_sanitize_checkbox',
 ));

 $wp_customize->add_control('embed_credit', array(
  'label'    => esc_html__('Display Designer Credit', 'embed-gallery'),
  'section'  => 'embed_footer_options',
  'priority' => 2,
  'type'     => 'checkbox',
 ));

 /**
  * Support Section
  */
 $wp_customize->add_section('embed_support_options', array(
  'title'       => esc_html__('Support Options', 'embed-gallery'),
  'description' => esc_html__('Thanks for your interest in Embed-Gallery! To share your feedback and for any support query you can reach us at', 'embed-gallery'),
  'panel'       => 'embed_theme_options',
  'priority'    => 40,
 ));

 // Theme Support
 $wp_customize->add_setting('embed_theme_support', array(
  'default'           => '',
  'sanitize_callback' => 'sanitize_text_field',
 ));

 $wp_customize->add_control(
  new embed_Button_Control(
   $wp_customize,
   'embed_theme_support',
   array(
    'label'         => esc_html__('Embed-Gallery Support', 'embed-gallery'),
    'section'       => 'embed_support_options',
    'priority'      => 1,
    'type'          => 'embed-gallery-button',
    'button_tag'    => 'a',
    'button_class'  => 'button button-primary',
    'button_href'   => esc_url(__('https://odude.com/contact/', 'embed-gallery')),
    'button_target' => '_blank',
   )
  )
 );

 /**
  * Review Section
  */
 $wp_customize->add_section('embed_review_options', array(
  'title'       => esc_html__('Add Your Review', 'embed-gallery'),
  'description' => esc_html__('Why not leave us a review on WordPress.org? Your review on WordPress will be highly appreciated, as it encourages us to keep updating and supporting the product.', 'embed-gallery'),
  'panel'       => 'embed_theme_options',
  'priority'    => 50,
 ));

 // Theme
 $wp_customize->add_setting('embed_theme_review', array(
  'default'           => '',
  'sanitize_callback' => 'sanitize_text_field',
 ));

 $wp_customize->add_control(
  new embed_Button_Control(
   $wp_customize,
   'embed_theme_review',
   array(
    'label'         => esc_html__('Review on WordPress.org', 'embed-gallery'),
    'section'       => 'embed_review_options',
    'type'          => 'embed-gallery-button',
    'button_tag'    => 'a',
    'button_class'  => 'button button-primary',
    'button_href'   => esc_url(__('https://wordpress.org/support/theme/embed-gallery/reviews', 'embed-gallery')),
    'button_target' => '_blank',
   )
  )
 );
}
add_action('customize_register', 'embed_customize_register');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function embed_customize_preview_js()
{
 wp_enqueue_script('embed_customizer', get_template_directory_uri() . '/js/customizer.js', array('customize-preview'), '20140120', true);
}
add_action('customize_preview_init', 'embed_customize_preview_js');
