<?php
/*
Plugin Name: Simple Real Estate
Plugin URI: https://bogazicimedya.com
Description: A simple real estate plugin for managing rental and buying listings.
Version: 1.0
Author: Ali Yagmur
Author URI: https://bogazicimedya.com
Text Domain: bm-simple-real-estate
Domain Path: /languages
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Main plugin class
if ( ! class_exists('BM_SRER')) {
  class BM_SRER{
    function __construct() {
      $this->define_constants();

      require_once BM_SRER_PATH . 'post-types/class.bm-simple-real-estate-cpt.php';

      $BM_SRER_Post_Types = new BM_SRER_Post_Types();
    }
    public function define_constants() {
      define( 'BM_SRER_PATH', plugin_dir_path(__FILE__));
      define( 'BM_SRER_URL', plugin_dir_url(__FILE__));
      define( 'BM_SRER_VERSION', '1.0.0');
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
  }
};

if (class_exists('BM_SRER')) {
  register_activation_hook(__FILE__, array('BM_SRER', 'activate'));
  register_deactivation_hook(__FILE__, array('BM_SRER', 'deactivate'));
  register_uninstall_hook(__FILE__, array('BM_SRER', 'uninstall'));

  $bm_srer = new BM_SRER();
}

// Shortcodes
function bm_srer_shortcode_price() {
    global $post;
    $price = get_post_meta($post->ID, '_bm_srer_price', true);
    return $price ? esc_html($price) : '';
}
add_shortcode('property_price', 'bm_srer_shortcode_price');

function bm_srer_shortcode_rooms() {
    global $post;
    $rooms = get_post_meta($post->ID, '_bm_srer_rooms', true);
    return $rooms ? esc_html($rooms) : '';
}
add_shortcode('property_rooms', 'bm_srer_shortcode_rooms');

function bm_srer_shortcode_address() {
    global $post;
    $address = get_post_meta($post->ID, '_bm_srer_address', true);
    return $address ? esc_html($address) : '';
}
add_shortcode('property_address', 'bm_srer_shortcode_address');

function bm_srer_shortcode_area() {
    global $post;
    $area = get_post_meta($post->ID, '_bm_srer_area', true);
    return $area ? esc_html($area) : '';
}
add_shortcode('property_area', 'bm_srer_shortcode_area');

function bm_srer_shortcode_floor() {
    global $post;
    $floor = get_post_meta($post->ID, '_bm_srer_floor', true);
    return $floor ? esc_html($floor) : '';
}
add_shortcode('property_floor', 'bm_srer_shortcode_floor');

function bm_srer_shortcode_building_age() {
    global $post;
    $building_age = get_post_meta($post->ID, '_bm_srer_building_age', true);
    return $building_age ? esc_html($building_age) : '';
}
add_shortcode('property_building_age', 'bm_srer_shortcode_building_age');

function bm_srer_shortcode_property_type() {
    global $post;
    $types = get_post_meta($post->ID, '_bm_srer_property_type', true);
    return is_array($types) ? implode(', ', array_map('esc_html', $types)) : '';
}
add_shortcode('property_type', 'bm_srer_shortcode_property_type');

function bm_srer_shortcode_city() {
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
add_shortcode('property_city', 'bm_srer_shortcode_city');

function bm_srer_shortcode_features() {
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
add_shortcode('property_features', 'bm_srer_shortcode_features');

// Search form shortcode
function bm_srer_search_form() {
    $cities = get_terms(['taxonomy' => 'city', 'hide_empty' => false]);
    ?>
    <form id="bm-srer-search-form" method="GET" action="<?php echo esc_url(home_url('/')); ?>">
        <div class="form-col">
            <div class="form-group">
                <label for="city"><?php _e('City', 'bm-simple-real-estate'); ?></label>
                <select name="city[]" multiple>
                    <?php foreach ($cities as $city): ?>
                        <option value="<?php echo esc_attr($city->slug); ?>"><?php echo esc_html($city->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="rooms"><?php _e('Rooms', 'bm-simple-real-estate'); ?></label>
                <input type="number" name="rooms" min="0">
            </div>
            <div class="form-group">
                <label for="price-min"><?php _e('Min Price', 'bm-simple-real-estate'); ?></label>
                <input type="number" name="price-min" min="0">
            </div>
            <div class="form-group">
                <label for="price-max"><?php _e('Max Price', 'bm-simple-real-estate'); ?></label>
                <input type="number" name="price-max" min="0">
            </div>
            <div class="form-group">
                <label for="s"><?php _e('Keywords', 'bm-simple-real-estate'); ?></label>
                <input type="text" name="s">
            </div>

            <div class="form-group">
                <label for="property-type"><?php _e('Rent or Buy', 'bm-simple-real-estate'); ?></label>
                <select name="property-type">
                    <option value=""><?php _e('Both', 'bm-simple-real-estate'); ?></option>
                    <option value="rent"><?php _e('Rent', 'bm-simple-real-estate'); ?></option>
                    <option value="buy"><?php _e('Buy', 'bm-simple-real-estate'); ?></option>
                </select>
            </div>
            <br>
            <div class="form-group">
                <button type="submit"><?php _e('Search', 'bm-simple-real-estate'); ?></button>
            </div>
        </div>
    </form>

    <?php
}
add_shortcode('bm_srer_search_form', 'bm_srer_search_form');

// Search function
function bm_srer_filter_search_query($query) {
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
                'key' => '_bm_srer_rooms',
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
                'key' => '_bm_srer_price',
                'value' => $price_min,
                'compare' => '>=',
                'type' => 'NUMERIC',
            ];
        }

        if ($price_max) {
            $price_meta_query[] = [
                'key' => '_bm_srer_price',
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
add_action('pre_get_posts', 'bm_srer_filter_search_query');


// Load plugin textdomain
function bm_srer_load_textdomain() {
    load_plugin_textdomain('bm-simple-real-estate', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'bm_srer_load_textdomain');