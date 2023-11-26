<?php
/**
 * GeneratePress child theme functions and definitions.
 *
 * Add your custom PHP in this file.
 * Only edit this file if you have direct access to it on your server (to fix errors if they happen).
 */

 /**
 * This allows us to limit overall site width to 1920 for those with 65" tvs
 * There is corresponding css to do so. 
 */

 /* Opens site wrapper div */
 add_action('generate_before_header', 'tct_open_wrapper');
 function tct_open_wrapper(){
     echo '<div class="site-wrapper">';
 }
 
 /* Closes site wrapper div */
 add_action('generate_after_footer', 'tct_close_wrapper');
 function tct_close_wrapper(){
     echo '</div>';
 }


/*
this section allows you to see your css in the customizer?
*/

 /* Enqueue Child Theme style.css to editor */
add_filter('block_editor_settings_all', function($editor_settings) {
    // Get the URL of the child theme's style.css
    $child_theme_style_url = get_stylesheet_directory_uri() . '/style.css';

    $editor_settings['styles'][] = array('css' => wp_remote_get($child_theme_style_url)['body']);
    return $editor_settings;
});


/* Eunqueue Customizer CSS to editor */ 
add_filter( 'block_editor_settings_all', function( $editor_settings ) {
    $css = wp_get_custom_css_post()->post_content;
    $editor_settings['styles'][] = array( 'css' => $css );
    return $editor_settings;
} );

/*
this removes the default wordpress blocks
*/

/* Remove WordPress Core default block patterns */
add_action( 'after_setup_theme', 'my_remove_patterns' );
function my_remove_patterns() {
   remove_theme_support( 'core-block-patterns' );
}

/* Patterns accessible in backend */
function be_reusable_blocks_admin_menu() {
    add_menu_page( 'Patterns', 'Patterns', 'edit_posts', 'edit.php?post_type=wp_block', '', 'dashicons-editor-table', 22 );
}
add_action( 'admin_menu', 'be_reusable_blocks_admin_menu' );