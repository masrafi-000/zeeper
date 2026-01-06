<?php

/**
 * Theme Assets (CSS + JS)
 */
function my_theme_enqueue_assets()
{

    $theme_dir     = get_stylesheet_directory();
    $theme_dir_uri = get_stylesheet_directory_uri();

    /**
     * Tailwind CSS (Compiled)
     * 
     */
    $tailwind_file = $theme_dir . '/src/output.css';
    if (file_exists($tailwind_file)) {
        wp_enqueue_style(
            'tailwind-css',
            $theme_dir_uri . '/src/output.css',
            [],
            filemtime($tailwind_file)
        );
    }

    /**
     * Main style.css
     */
    $style_file = $theme_dir . '/style.css';
    wp_enqueue_style(
        'theme-style',
        get_stylesheet_uri(),
        ['tailwind-css'],
        file_exists($style_file) ? filemtime($style_file) : null
    );

    /**
     * jQuery (WordPress Core)
     */
    wp_enqueue_script('jquery');

    // Toastify CSS
    wp_enqueue_style('toastify-css', 'https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css');
    // Toastify JS
    wp_enqueue_script('toastify-js', 'https://cdn.jsdelivr.net/npm/toastify-js', array(), null, true);

    /**
     * User CRUD JS
     */
    wp_enqueue_script(
        'user-crud-js',
        $theme_dir_uri . '/assets/js/user-crud.js',
        ['jquery'],
        filemtime($theme_dir . '/assets/js/user-crud.js'),
        true
    );


    /**
     * AJAX Data
     */
    wp_localize_script('user-crud-js', 'ajax_data', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('user_crud_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_assets');


/**
 * Create Custom User Table (Only once on theme activation)
 */
function my_theme_create_custom_user_table()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'custom_users';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
add_action('after_switch_theme', 'my_theme_create_custom_user_table');



require_once get_template_directory() . '/inc/db-setup.php';
require_once get_template_directory() . '/inc/ajax-handlers.php';
