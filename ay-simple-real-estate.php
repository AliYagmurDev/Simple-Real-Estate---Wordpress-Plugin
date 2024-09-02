<?php
/*
Plugin Name: Simple Real Estate
Plugin URI: https://aliyagmur.me/plugins/ay-simple-real-estate
Description: A simple real estate plugin for managing rental and buying listings.
Version: 1.0
Author: Ali Yagmur
Author URI: https://aliyagmur.me
Text Domain: ay-simple-real-estate
Domain Path: /languages
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Main plugin class
if ( ! class_exists('AY_SRER')) {
    class AY_SRER{
        function __construct() {
            $this->define_constants();

            add_action( 'admin_menu', array($this, 'add_admnin_menu') );

            require_once AY_SRER_PATH . 'post-types/class.ay-simple-real-estate-cpt.php';
            $AY_SRER_Post_Types = new AY_SRER_Post_Types();

            require_once AY_SRER_PATH . 'taxonomies/class.ay-simple-real-estate-taxonomy.php';
            $AY_SRER_Taxonomies = new AY_SRER_Taxonomies();

            require_once AY_SRER_PATH . 'class.ay-simple-real-estate-settings.php';
            $AY_SRER_Settings = new AY_SRER_Settings();

            require_once AY_SRER_PATH . 'shortcodes/class.ay-simple-real-estate-shortcode.php';
            $AY_SRER_Shortcode = new AY_SRER_Shortcode();

            require_once AY_SRER_PATH . 'functions/class.ay-simple-real-estate-search.php';
            $AY_SRER_Search = new AY_SRER_Search();

            require_once AY_SRER_PATH . 'functions/class.ay-simple-real-estate-load-cities.php';

        }
        public function define_constants() {
            define( 'AY_SRER_PATH', plugin_dir_path(__FILE__));
            define( 'AY_SRER_URL', plugin_dir_url(__FILE__));
            define( 'AY_SRER_VERSION', '1.0.0');
        }

        public static function activate() {
            // Clear the rewrite rules for custom post types to work
            update_option( 'rewrite_rules', '' );
        }

        public static function deactivate() {
            // flush rewrite rules on plugin deactivation
            flush_rewrite_rules();
            
            // Unregister the post types
            unregister_post_type('rent');
            unregister_post_type('buy');
        }

        public static function uninstall() {

        }

        // Adds menu item to the admin dashboard
        public function add_admnin_menu() {
            //adds main menu item
            add_menu_page(
                'Simple Real Estate',
                'Simple Real Estate',
                'manage_options',
                'ay_srer_admimn',
                array($this, 'ay_srer_admin_page'),
                'dashicons-admin-home',
                25,
            );
        }

        // Admin page callback
        public function ay_srer_admin_page() {
            require( AY_SRER_PATH . 'views/settings-page.php' );
        }
    }
};

if (class_exists('AY_SRER')) {
    register_activation_hook(__FILE__, array('AY_SRER', 'activate'));
    register_deactivation_hook(__FILE__, array('AY_SRER', 'deactivate'));
    register_uninstall_hook(__FILE__, array('AY_SRER', 'uninstall'));

    $ay_srer = new AY_SRER();
}


// Load plugin textdomain
function ay_srer_load_textdomain() {
    load_plugin_textdomain('ay-simple-real-estate', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'ay_srer_load_textdomain');