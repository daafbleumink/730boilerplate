<?php
/**
 * Customize Login
 */
function my_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/src/css/login-style.css' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );

/**
 * Enqueue scripts and styles.
 */
function template_scripts() {
    // Enque font style file
    wp_enqueue_style( 'template-style', get_template_directory_uri() . '/style.css');
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script( 'main', get_template_directory_uri() . '/dist/js/scripts.min.js', false, '1', true);
        wp_enqueue_script('main');
    }
}
add_action( 'wp_enqueue_scripts', 'template_scripts' );

/**
 * Add menu
 */
function template_setup() {
    add_theme_support('menus');
    register_nav_menu('primary', 'Primary Header Navigation');
    register_nav_menu('secondary', 'Footer Navigation');
}
add_action( 'init', 'template_setup' );

/**
 * Disable features
 */

// Disable rss features
function wpb_disable_feed() {
    wp_die( __('No feed available, please visit our <a href="'. get_bloginfo('url') .'">website</a>!') );
    }
     
    add_action('do_feed', 'wpb_disable_feed', 1);
    add_action('do_feed_rdf', 'wpb_disable_feed', 1);
    add_action('do_feed_rss', 'wpb_disable_feed', 1);
    add_action('do_feed_rss2', 'wpb_disable_feed', 1);
    add_action('do_feed_atom', 'wpb_disable_feed', 1);
    add_action('do_feed_rss2_comments', 'wpb_disable_feed', 1);
    add_action('do_feed_atom_comments', 'wpb_disable_feed', 1);
 
// Remove feed link from header
remove_action( 'wp_head', 'feed_links_extra', 3 ); //Extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // General feeds: Post and Comment Feed

// Disable json api
add_filter('rest_jsonp_enabled', '_return_false');
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

// Remove the Link header for the WP REST API
// [link] => <http://www.example.com/wp-json/>; rel="https://api.w.org/"
remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );

// Remove script and style versions
function pu_remove_script_version( $src ){
    return remove_query_arg( 'ver', $src );
}
add_filter( 'script_loader_src', 'pu_remove_script_version' );
add_filter( 'style_loader_src', 'pu_remove_script_version' );

// Clean up header
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');

// Disable emojis
function disable_wp_emojicons() {

    // all actions related to emojis
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
  
  }
  add_action( 'init', 'disable_wp_emojicons' );

// Remove admin bar
add_filter('show_admin_bar', '__return_false');

// Remove generator tag
remove_action('wp_head', 'wp_generator');

add_filter( 'query_vars', function( $vars ){
    $vars[] = 'post_parent';
    return $vars;
});

/**
 * Remove Comments
 */
 
// Removes from admin menu
add_action( 'admin_menu', 'my_remove_admin_menus' );
function my_remove_admin_menus() {
	remove_menu_page( 'edit-comments.php' );
}
// Removes from post and pages
add_action( 'init', 'remove_comment_support', 100 );
function remove_comment_support() {
	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'page', 'comments' );
}
// Removes from admin bar
function mytheme_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'comments' );
}
add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );

// Removes items from admin menu
add_action( 'admin_init', 'my_remove_menu_pages' );
function my_remove_menu_pages() {

  global $user_ID;

  if ( $user_ID != 1 ) { //your user id

   //remove_menu_page('edit.php'); // Posts
   // remove_menu_page('upload.php'); // Media
   //remove_menu_page('link-manager.php'); // Links
   // remove_menu_page('edit-comments.php'); // Comments
   // remove_menu_page('edit.php?post_type=page'); // Pages
   // remove_menu_page('plugins.php'); // Plugins
   // remove_menu_page('themes.php'); // Appearance
   // remove_menu_page('users.php'); // Users
   // remove_menu_page('tools.php'); // Tools
   // remove_menu_page('options-general.php'); // Settings
   // remove_menu_page('upload.php'); // Media
  }
}

// CUSTOM IMAGE SIZES
add_action( 'after_setup_theme', 'image_size_setup' );
function image_size_setup() {
    add_image_size( 'small', 500 );
    add_image_size( 'medium', 800 );
    add_image_size( 'large', 1400 );
}

// Allow svg in upload
function add_file_types_to_uploads($file_types){

    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $new_filetypes['woff'] = 'application/x-font-woff';
    $new_filetypes['woff2'] = 'application/x-font-woff2';
    $new_filetypes['ttf'] = 'application/x-font-ttf';
    $file_types = array_merge($file_types, $new_filetypes );

    return $file_types;
}
add_action('upload_mimes', 'add_file_types_to_uploads');
  
// Add support for featured images
add_theme_support( 'post-thumbnails' );
