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
            add_menu_page(
                'Simple Real Estate',
                'Simple Real Estate',
                'manage_options',
                'ay_srer_admimn',
                array($this, 'ay_srer_admin_page'),
                'dashicons-admin-home',
            );

            add_submenu_page(
                'ay_srer_admimn',
                'Rent',
                'Rent',
                'manage_options',
                'edit.php?post_type=rent',
                null,
                null
            );

            add_submenu_page(
                'ay_srer_admimn',
                'Buy',
                'Buy',
                'manage_options',
                'edit.php?post_type=buy',
                null,
                null
            );
        }

        // Admin page callback
        public function ay_srer_admin_page() {
            echo '<h1>Simple Real Estate</h1>';
        }
    }
};

if (class_exists('AY_SRER')) {
    register_activation_hook(__FILE__, array('AY_SRER', 'activate'));
    register_deactivation_hook(__FILE__, array('AY_SRER', 'deactivate'));
    register_uninstall_hook(__FILE__, array('AY_SRER', 'uninstall'));

    $ay_srer = new AY_SRER();
}

// Shortcodes
function ay_srer_shortcode_price() {
    global $post;
    $price = get_post_meta($post->ID, '_ay_srer_price', true);
    return $price ? esc_html($price) : '';
}
add_shortcode('property_price', 'ay_srer_shortcode_price');

function ay_srer_shortcode_rooms() {
    global $post;
    $rooms = get_post_meta($post->ID, '_ay_srer_rooms', true);
    return $rooms ? esc_html($rooms) : '';
}
add_shortcode('property_rooms', 'ay_srer_shortcode_rooms');

function ay_srer_shortcode_address() {
    global $post;
    $address = get_post_meta($post->ID, '_ay_srer_address', true);
    return $address ? esc_html($address) : '';
}
add_shortcode('property_address', 'ay_srer_shortcode_address');

function ay_srer_shortcode_area() {
    global $post;
    $area = get_post_meta($post->ID, '_ay_srer_area', true);
    return $area ? esc_html($area) : '';
}
add_shortcode('property_area', 'ay_srer_shortcode_area');

function ay_srer_shortcode_floor() {
    global $post;
    $floor = get_post_meta($post->ID, '_ay_srer_floor', true);
    return $floor ? esc_html($floor) : '';
}
add_shortcode('property_floor', 'ay_srer_shortcode_floor');

function ay_srer_shortcode_building_age() {
    global $post;
    $building_age = get_post_meta($post->ID, '_ay_srer_building_age', true);
    return $building_age ? esc_html($building_age) : '';
}
add_shortcode('property_building_age', 'ay_srer_shortcode_building_age');

function ay_srer_shortcode_property_type() {
    global $post;
    $types = get_post_meta($post->ID, '_ay_srer_property_type', true);
    return is_array($types) ? implode(', ', array_map('esc_html', $types)) : '';
}
add_shortcode('property_type', 'ay_srer_shortcode_property_type');

function ay_srer_shortcode_city() {
    global $post;
    $terms = get_the_terms($post->ID, 'city');
    if ($terms && !is_wp_error($terms)) {
        $city_names = array();
        foreach ($terms as $term) {
            $city_names[] = $term->name;
        }
        return implode(', ', $city_names);
    }
    return '';
}
add_shortcode('property_city', 'ay_srer_shortcode_city');

function ay_srer_shortcode_features() {
    global $post;
    $terms = get_the_terms($post->ID, 'feature');
    if ($terms && !is_wp_error($terms)) {
        $feature_names = array();
        foreach ($terms as $term) {
            $feature_names[] = $term->name;
        }
        return implode('<br>', $feature_names);
    }
    return '';
}
add_shortcode('property_features', 'ay_srer_shortcode_features');

// Search form shortcode
function ay_srer_search_form() {
    $cities = get_terms(['taxonomy' => 'city', 'hide_empty' => false]);
    ?>
    <form id="ay-srer-search-form" method="GET" action="<?php echo esc_url(home_url('/')); ?>">
        <div class="form-col">
            <div class="form-group">
                <label for="city"><?php _e('City', 'ay-simple-real-estate'); ?></label>
                <select name="city[]" multiple>
                    <?php foreach ($cities as $city): ?>
                        <option value="<?php echo esc_attr($city->slug); ?>"><?php echo esc_html($city->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="rooms"><?php _e('Rooms', 'ay-simple-real-estate'); ?></label>
                <input type="number" name="rooms" min="0">
            </div>
            <div class="form-group">
                <label for="price-min"><?php _e('Min Price', 'ay-simple-real-estate'); ?></label>
                <input type="number" name="price-min" min="0">
            </div>
            <div class="form-group">
                <label for="price-max"><?php _e('Max Price', 'ay-simple-real-estate'); ?></label>
                <input type="number" name="price-max" min="0">
            </div>
            <div class="form-group">
                <label for="s"><?php _e('Keywords', 'ay-simple-real-estate'); ?></label>
                <input type="text" name="s">
            </div>

            <div class="form-group">
                <label for="property-type"><?php _e('Rent or Buy', 'ay-simple-real-estate'); ?></label>
                <select name="property-type">
                    <option value=""><?php _e('Both', 'ay-simple-real-estate'); ?></option>
                    <option value="rent"><?php _e('Rent', 'ay-simple-real-estate'); ?></option>
                    <option value="buy"><?php _e('Buy', 'ay-simple-real-estate'); ?></option>
                </select>
            </div>
            <br>
            <div class="form-group">
                <button type="submit"><?php _e('Search', 'ay-simple-real-estate'); ?></button>
            </div>
        </div>
    </form>

    <?php
}
add_shortcode('ay_srer_search_form', 'ay_srer_search_form');

// Search function
function ay_srer_filter_search_query($query) {
    if ($query->is_main_query() && !is_admin() && $query->is_search()) {

        // Handle property type filter
        $property_type = filter_input(INPUT_GET, 'property-type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($property_type) {
            $query->set('post_type', $property_type);
        } else {
            $query->set('post_type', ['rent', 'buy']);
        }

        // Handle city filter
        $cities = filter_input(INPUT_GET, 'city', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if (!empty($cities)) {
            $tax_query = $query->get('tax_query') ?: [];
            $tax_query[] = [
                'taxonomy' => 'city',
                'field' => 'slug',
                'terms' => $cities,
            ];
            $query->set('tax_query', $tax_query);
        }

        // Handle rooms filter
        $rooms = filter_input(INPUT_GET, 'rooms', FILTER_SANITIZE_NUMBER_INT);
        if ($rooms) {
            $meta_query = $query->get('meta_query') ?: [];
            $meta_query[] = [
                'key' => '_ay_srer_rooms',
                'value' => $rooms,
                'compare' => '==',
                'type' => 'NUMERIC'
            ];
            $query->set('meta_query', $meta_query);
        }

        // Handle price filter
        $price_min = filter_input(INPUT_GET, 'price-min', FILTER_SANITIZE_NUMBER_INT);
        $price_max = filter_input(INPUT_GET, 'price-max', FILTER_SANITIZE_NUMBER_INT);
        $price_meta_query = [];

        if ($price_min) {
            $price_meta_query[] = [
                'key' => '_ay_srer_price',
                'value' => $price_min,
                'compare' => '>=',
                'type' => 'NUMERIC',
            ];
        }

        if ($price_max) {
            $price_meta_query[] = [
                'key' => '_ay_srer_price',
                'value' => $price_max,
                'compare' => '<=',
                'type' => 'NUMERIC',
            ];
        }

        if ($price_meta_query) {
            $meta_query = $query->get('meta_query') ?: [];
            $meta_query = array_merge($meta_query, $price_meta_query);
            $query->set('meta_query', $meta_query);
        }
    }
}
add_action('pre_get_posts', 'ay_srer_filter_search_query');


// Load plugin textdomain
function ay_srer_load_textdomain() {
    load_plugin_textdomain('ay-simple-real-estate', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'ay_srer_load_textdomain');