<?php

if (! class_exists('AY_SRER_Shortcode')) {
    class AY_SRER_Shortcode {
        public function __construct() {

            // Register Shortcodes
            
            add_shortcode('property_price', array( $this, 'ay_srer_shortcode_price'));

            add_shortcode('property_rooms', array( $this, 'ay_srer_shortcode_rooms'));

            add_shortcode('property_address', array( $this, 'ay_srer_shortcode_address'));

            add_shortcode('property_area', array( $this, 'ay_srer_shortcode_area'));

            add_shortcode('property_floor', array( $this, 'ay_srer_shortcode_floor'));

            add_shortcode('property_building_age', array( $this, 'ay_srer_shortcode_building_age'));

            add_shortcode('property_type', array( $this, 'ay_srer_shortcode_property_type'));

            add_shortcode('property_city', array( $this, 'ay_srer_shortcode_city'));

            add_shortcode('property_features', array( $this, 'ay_srer_shortcode_features'));

            add_shortcode('ay_srer_search_form', array( $this, 'ay_srer_search_form'));
        }

        // Price shortcode
        public function ay_srer_shortcode_price() {
            global $post;
            $price = get_post_meta($post->ID, '_ay_srer_price', true);
            return $price ? esc_html($price) : '';
        }

        // Currency shortcode
        public function ay_srer_shortcode_currency() {
            global $post;
            $currency = get_post_meta($post->ID, '_ay_srer_currency', true);
            return $currency ? esc_html($currency) : '';
        }

        // Rooms shortcode
        public function ay_srer_shortcode_rooms() {
            global $post;
            $rooms = get_post_meta($post->ID, '_ay_srer_rooms', true);
            return $rooms ? esc_html($rooms) : '';
        }

        // Address shortcode
        public function ay_srer_shortcode_address() {
            global $post;
            $address = get_post_meta($post->ID, '_ay_srer_address', true);
            return $address ? esc_html($address) : '';
        }

        // Area shortcode
        public function ay_srer_shortcode_area() {
            global $post;
            $area = get_post_meta($post->ID, '_ay_srer_area', true);
            return $area ? esc_html($area) : '';
        }

        // Floor shortcode
        public function ay_srer_shortcode_floor() {
            global $post;
            $floor = get_post_meta($post->ID, '_ay_srer_floor', true);
            return $floor ? esc_html($floor) : '';
        }

        // Building age shortcode
        public function ay_srer_shortcode_building_age() {
            global $post;
            $building_age = get_post_meta($post->ID, '_ay_srer_building_age', true);
            return $building_age ? esc_html($building_age) : '';
        }

        // Property type shortcode
        public function ay_srer_shortcode_property_type() {
            global $post;
            $types = get_post_meta($post->ID, '_ay_srer_property_type', true);
            return is_array($types) ? implode(', ', array_map('esc_html', $types)) : '';
        }

        // City shortcode
        public function ay_srer_shortcode_city() {
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

        // Features shortcode
        public function ay_srer_shortcode_features() {
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

        // Search form shortcode
        public function ay_srer_search_form() {
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
    }
}