<?php

if (! class_exists('AY_SRER_Shortcode')) {
    class AY_SRER_Shortcode
    {
        public function __construct()
        {

            // Register Shortcodes

            add_shortcode('property_price', array($this, 'ay_srer_shortcode_price'));

            add_shortcode('property_rooms', array($this, 'ay_srer_shortcode_rooms'));

            add_shortcode('property_address', array($this, 'ay_srer_shortcode_address'));

            add_shortcode('property_area', array($this, 'ay_srer_shortcode_area'));

            add_shortcode('property_floor', array($this, 'ay_srer_shortcode_floor'));

            add_shortcode('property_building_age', array($this, 'ay_srer_shortcode_building_age'));

            add_shortcode('property_type', array($this, 'ay_srer_shortcode_property_type'));

            add_shortcode('property_city', array($this, 'ay_srer_shortcode_city'));

            add_shortcode('property_features', array($this, 'ay_srer_shortcode_features'));

            add_shortcode('ay_srer_search_form', array($this, 'ay_srer_search_form'));
        }

        // Price shortcode
        public function ay_srer_shortcode_price()
        {
            global $post;
            $price = get_post_meta($post->ID, '_ay_srer_price', true);
            return $price ? esc_html($price) : '';
        }

        // Currency shortcode
        public function ay_srer_shortcode_currency()
        {
            global $post;
            $currency = get_post_meta($post->ID, '_ay_srer_currency', true);
            return $currency ? esc_html($currency) : '';
        }

        // Rooms shortcode
        public function ay_srer_shortcode_rooms()
        {
            global $post;
            $rooms = get_post_meta($post->ID, '_ay_srer_rooms', true);
            return $rooms ? esc_html($rooms) : '';
        }

        // Address shortcode
        public function ay_srer_shortcode_address()
        {
            global $post;
            $address = get_post_meta($post->ID, '_ay_srer_address', true);
            return $address ? esc_html($address) : '';
        }

        // Area shortcode
        public function ay_srer_shortcode_area()
        {
            global $post;
            $area = get_post_meta($post->ID, '_ay_srer_area', true);
            return $area ? esc_html($area) : '';
        }

        // Floor shortcode
        public function ay_srer_shortcode_floor()
        {
            global $post;
            $floor = get_post_meta($post->ID, '_ay_srer_floor', true);
            return $floor ? esc_html($floor) : '';
        }

        // Building age shortcode
        public function ay_srer_shortcode_building_age()
        {
            global $post;
            $building_age = get_post_meta($post->ID, '_ay_srer_building_age', true);
            return $building_age ? esc_html($building_age) : '';
        }

        // Property type shortcode
        public function ay_srer_shortcode_property_type()
        {
            global $post;
            $types = get_post_meta($post->ID, '_ay_srer_property_type', true);
            return is_array($types) ? implode(', ', array_map('esc_html', $types)) : '';
        }

        // City shortcode
        public function ay_srer_shortcode_city()
        {
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
        public function ay_srer_shortcode_features()
        {
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
        public function ay_srer_search_form()
        {
            //$cities = get_terms(['taxonomy' => 'city', 'hide_empty' => false]);

            $cities = get_terms(array(
                'taxonomy' => 'city',
                'hide_empty' => false,
                'parent' => 0
            ));

            // Get all cities, including both parent and sub-cities
            $all_cities = get_terms(array(
                'taxonomy'   => 'city',
                'hide_empty' => false,
            ));

            // Prepare the sub-cities in an associative array for easier access in JavaScript
            $sub_cities_by_parent = array();
            foreach ($all_cities as $city) {
                if ($city->parent != 0) {
                    $sub_cities_by_parent[$city->parent][] = $city;
                }
            }
?>
            <form id="ay-srer-search-form" method="GET" action="<?php echo esc_url(home_url('/')); ?>">
                <div class="form-col">
                    <div class="form-group">
                        <label for="property-type-list"><?php echo esc_html__('Property Type', 'ay-simple-real-estate'); ?></label>
                        <select name="property-type-list">
                            <option value=""><?php echo esc_html__('All', 'ay-simple-real-estate'); ?></option>
                            <option value="Apartment"><?php echo esc_html__('Apartment', 'ay-simple-real-estate'); ?></option>
                            <option value="Villa"><?php echo esc_html__('Villa', 'ay-simple-real-estate'); ?></option>
                            <option value="Penthouse"><?php echo esc_html__('Penthouse', 'ay-simple-real-estate'); ?></option>
                            <option value="Residence"><?php echo esc_html__('Residence', 'ay-simple-real-estate'); ?></option>
                            <option value="Bungalow"><?php echo esc_html__('Bungalow', 'ay-simple-real-estate'); ?></option>
                            <option value="Detached House"><?php echo esc_html__('Detached House', 'ay-simple-real-estate'); ?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="city"><?php echo esc_html__('City', 'ay-simple-real-estate'); ?></label>
                        <select id="search_city" name="city">
                            <option value=""><?php echo esc_html__('Select a city', 'ay-simple-real-estate'); ?></option>
                            <?php foreach ($cities as $city) : ?>
                                <option cityId="<?php echo esc_attr($city->term_id); ?>" value="<?php echo esc_attr($city->slug); ?>">
                                    <?php echo esc_html($city->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php /*
                    <div class="form-group">
                        <label for="district"><?php echo esc_html__('District', 'ay-simple-real-estate'); ?></label>
                        <select id="search_district" name="district">
                            <option value=""><?php echo esc_html__('Select a district', 'ay-simple-real-estate'); ?></option>
                            <!-- Districts will be dynamically populated based on the selected city -->
                        </select>
                    </div>
                    */ ?>
                    <div class="form-group">
                        <label for="rooms"><?php echo esc_html__('Rooms', 'ay-simple-real-estate'); ?></label>
                        <input type="number" name="rooms" min="0">
                    </div>
                    <div class="form-group">
                        <label for="price-min"><?php echo esc_html__('Min Price', 'ay-simple-real-estate'); ?></label>
                        <input type="number" name="price-min" min="0">
                    </div>
                    <div class="form-group">
                        <label for="price-max"><?php echo esc_html__('Max Price', 'ay-simple-real-estate'); ?></label>
                        <input type="number" name="price-max" min="0">
                    </div>
                    <div class="form-group">
                        <label for="s"><?php echo esc_html__('Keywords', 'ay-simple-real-estate'); ?></label>
                        <input type="text" name="s">
                    </div>

                    <div class="form-group">
                        <label for="property-type"><?php echo esc_html__('Rent or Buy', 'ay-simple-real-estate'); ?></label>
                        <select name="property-type">
                            <option value=""><?php echo esc_html__('Both', 'ay-simple-real-estate'); ?></option>
                            <option value="rent"><?php echo esc_html__('Rent', 'ay-simple-real-estate'); ?></option>
                            <option value="buy"><?php echo esc_html__('Buy', 'ay-simple-real-estate'); ?></option>
                        </select>
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit"><?php echo esc_html__('Search', 'ay-simple-real-estate'); ?></button>
                    </div>
                </div>
            </form>
            <?php /*
            <script type="text/javascript">
                document.addEventListener('DOMContentLoaded', function() {
                    // Sub-cities data from PHP
                    var subCitiesByParent = <?php echo json_encode($sub_cities_by_parent); ?>;

                    // Get the dropdown elements
                    var citySelect = document.getElementById('search_city');
                    var districtSelect = document.getElementById('search_district');

                    // Function to update district dropdown
                    function updateDistricts(parentCityId) {
                        // Clear previous options
                        districtSelect.innerHTML = '<option value=""><?php echo esc_html__('Select a district', 'ay-simple-real-estate'); ?></option>';

                        // Check if sub-cities exist for the selected parent city
                        if (subCitiesByParent[parentCityId]) {
                            subCitiesByParent[parentCityId].forEach(function(subCity) {
                                var option = document.createElement('option');
                                option.value = subCity.slug;
                                option.textContent = subCity.name;
                                districtSelect.appendChild(option);
                            });
                        }
                    }

                    // Listen for changes in the city dropdown
                    citySelect.addEventListener('change', function() {
                        var selectedCityId = citySelect.cityId;
                        
                        updateDistricts(selectedCityId);
                    });
                });
            </script>
            */ ?>
<?php
        }
    }
}
