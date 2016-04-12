<?php

namespace Roots\Sage\Setup;

use Roots\Sage\Assets;

/**
 * Theme setup
 */
function setup() {
  // Enable features from Soil when plugin is activated
  // https://roots.io/plugins/soil/
  add_theme_support('soil-clean-up');
  add_theme_support('soil-nav-walker');
  add_theme_support('soil-nice-search');
  add_theme_support('soil-jquery-cdn');
  add_theme_support('soil-relative-urls');

  // Make theme available for translation
  // Community translations can be found at https://github.com/roots/sage-translations
  load_theme_textdomain('sage', get_template_directory() . '/lang');

  // Enable plugins to manage the document title
  // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
  add_theme_support('title-tag');

  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus([
    'primary_navigation' => __('Primary Navigation', 'sage'),
    'footer_menu' => __('Footer Menu', 'sage'),
    'footer_submenu' => __('Footer Submenu', 'sage'),
    'overlay_menu' => __('Overlay Menu', 'sage'),
  ]);

  // Enable post thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
  // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
  // http://codex.wordpress.org/Function_Reference/add_image_size
  add_theme_support('post-thumbnails');

  // Enable post formats
  // http://codex.wordpress.org/Post_Formats
  add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);

  // Enable HTML5 markup support
  // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

  // Use main stylesheet for visual editor
  // To add custom styles edit /assets/styles/layouts/_tinymce.scss
  add_editor_style(Assets\asset_path('styles/main.css'));


  // add custom post types


}
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

/**
 * Register sidebars
 */
function widgets_init() {
  register_sidebar([
    'name'          => __('Primary', 'sage'),
    'id'            => 'sidebar-primary',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);

  register_sidebar([
    'name'          => __('Footer', 'sage'),
    'id'            => 'sidebar-footer',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);
}
add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');

/**
 * Determine which pages should NOT display the sidebar
 */
function display_sidebar() {
  static $display;

  isset($display) || $display = !in_array(true, [
    // The sidebar will NOT be displayed if ANY of the following return true.
    // @link https://codex.wordpress.org/Conditional_Tags
    is_404(),
    is_front_page(),
    is_page_template('template-custom.php'),
  ]);

  return apply_filters('sage/display_sidebar', $display);
}

/**
 * Theme assets
 */
function assets() {
  wp_enqueue_style('sage/css', Assets\asset_path('styles/main.css'), false, null);

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_enqueue_script('sage/js', Assets\asset_path('scripts/main.js'), ['jquery'], null, true);
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);




// CUSTOM POST TYPES



function portfolio_register()
{
  global $avia_config;

  $labels = array(
    'name' => _x('Portfolio Items', 'post type general name','sage'),
    'singular_name' => _x('Portfolio Entry', 'post type singular name','sage'),
    'add_new' => _x('Add New', 'portfolio','sage'),
    'add_new_item' => __('Add New Portfolio Entry','sage'),
    'edit_item' => __('Edit Portfolio Entry','sage'),
    'new_item' => __('New Portfolio Entry','sage'),
    'view_item' => __('View Portfolio Entry','sage'),
    'search_items' => __('Search Portfolio Entries','sage'),
    'not_found' =>  __('No Portfolio Entries found','sage'),
    'not_found_in_trash' => __('No Portfolio Entries found in Trash','sage'),
    'parent_item_colon' => ''
  );

    $permalinks = get_option('avia_permalink_settings');
    if(!$permalinks) $permalinks = array();

    $permalinks['portfolio_permalink_base'] = empty($permalinks['portfolio_permalink_base']) ? __('portfolio-item', 'sage') : $permalinks['portfolio_permalink_base'];
    $permalinks['portfolio_entries_taxonomy_base'] = empty($permalinks['portfolio_entries_taxonomy_base']) ? __('portfolio_entries', 'sage') : $permalinks['portfolio_entries_taxonomy_base'];

  $args = array(
    'labels' => $labels,
    'public' => true,
    'show_ui' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'rewrite' => array('slug'=>_x($permalinks['portfolio_permalink_base'],'URL slug','sage'), 'with_front'=>false),
    'query_var' => true,
    'show_in_nav_menus'=> true,
    'taxonomies' => array('post_tag'),
    'supports' => array('title','thumbnail','excerpt','editor','comments')
  );


  $args = apply_filters('avf_portfolio_cpt_args', $args);
  $avia_config['custom_post']['portfolio']['args'] = $args;

  register_post_type( 'portfolio' , $args );


  $tax_args = array(
    "hierarchical" => true,
    "label" => "Portfolio Categories",
    "singular_label" => "Portfolio Category",
    "rewrite" => array('slug'=>_x($permalinks['portfolio_entries_taxonomy_base'],'URL slug','sage'), 'with_front'=>true),
    "query_var" => true
  );

  $avia_config['custom_taxonomy']['portfolio']['portfolio_entries']['args'] = $tax_args;

  register_taxonomy("portfolio_entries", array("portfolio"), $tax_args);

  //deactivate the avia_flush_rewrites() function - not required because we rely on the default wordpress permalink settings
  // remove_action('wp_loaded', 'avia_flush_rewrites');
}
add_action('init', __NAMESPACE__ . '\\portfolio_register');