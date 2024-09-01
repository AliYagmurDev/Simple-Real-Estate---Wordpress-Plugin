<?php
// Security nonce field for validation
wp_nonce_field('ay_srer_save_meta_box_data', 'ay_srer_meta_box_nonce');

// Retrieving meta values
$price = get_post_meta($post->ID, '_ay_srer_price', true);
$rooms = get_post_meta($post->ID, '_ay_srer_rooms', true);
$address = get_post_meta($post->ID, '_ay_srer_address', true);
$area = get_post_meta($post->ID, '_ay_srer_area', true);
$floor = get_post_meta($post->ID, '_ay_srer_floor', true);
$building_age = get_post_meta($post->ID, '_ay_srer_building_age', true);
$property_type = get_post_meta($post->ID, '_ay_srer_property_type', true);
$currency = get_post_meta($post->ID, '_ay_srer_currency', true);

$property_types = array(__('Apartment', 'ay-simple-real-estate'), __('Villa', 'ay-simple-real-estate'), __('Penthouse', 'ay-simple-real-estate'), __('Residence', 'ay-simple-real-estate'), __('Bungalow', 'ay-simple-real-estate'), __('Detached House', 'ay-simple-real-estate'));

// create a variable that retrieves all taxonomy values from city taxonomy that doesnt have any parent
$cities = get_terms(array(
    'taxonomy' => 'city',
    'hide_empty' => false,
    'parent' => 0
));

// Get all cities, including both parents and sub-cities
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
};

// Retrieve the selected terms for the current post
$selected_cities = get_the_terms($post->ID, 'city');

// Initialize variables for selected parent and sub city IDs
$selected_parent_city_id = '';
$selected_sub_city_id = '';

if ($selected_cities && !is_wp_error($selected_cities)) {
    foreach ($selected_cities as $selected_city) {
        if ($selected_city->parent == 0) {
            // This is a parent city
            $selected_parent_city_id = $selected_city->term_id;
        } else {
            // This is a sub city
            $selected_sub_city_id = $selected_city->term_id;
            // Additionally, set the parent city ID if the sub city is selected
            $selected_parent_city_id = $selected_city->parent;
        }
    }
}

?>

<!-- Styling should not be here, I know. But I find it easy to well, find stuff related to eachother, next to eachother -->
<style>
    .ay-srer-meta-box { 
        padding: 15px; 
        border: 1px solid #ddd; 
        border-radius: 5px; 
        background-color: #f9f9f9; 
    }
    .ay-srer-meta-box label { 
        display: block; 
        margin-bottom: 5px; 
        font-weight: bold; 
    }
    .ay-srer-meta-box input[type="text"], 
    .ay-srer-meta-box input[type="number"], 
    .ay-srer-meta-box select { 
        width: calc(100% - 22px); 
        padding: 8px; 
        margin-bottom: 10px; 
        border: 1px solid #ccc; 
        border-radius: 4px; 
    }
</style>

<!-- The new meta boxes as shown in the editor page of property posts -->
<div class="ay-srer-meta-box">
    <label for="ay_srer_property_type"><?php echo esc_html__('Property Type:', 'ay-simple-real-estate'); ?></label>
    <select id="ay_srer_property_type" name="ay_srer_property_type[]" class="multiple-select">
        <?php foreach ($property_types as $type) : ?>
            <option value="<?php echo esc_attr($type); ?>" <?php echo in_array($type, (array) $property_type) ? 'selected' : ''; ?>>
                <?php echo esc_html($type); ?>
            </option>
        <?php endforeach; ?>
    </select>


    <!-- Here starts the dynamic address input -->

    <label for="ay_srer_city"><?php echo esc_html__('City:', 'ay-simple-real-estate'); ?></label>
    <select id="ay_srer_city" name="ay_srer_city">
        <option value=""><?php echo esc_html__('Select a city', 'ay-simple-real-estate'); ?></option>
        <?php foreach ($cities as $city) : ?>
            <option value="<?php echo esc_attr($city->term_id); ?>" <?php echo selected($city->term_id, $selected_parent_city_id); ?>>
                <?php echo esc_html($city->name); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="ay_srer_sub_city"><?php echo esc_html__('District:', 'ay-simple-real-estate'); ?></label>
    <select id="ay_srer_sub_city" name="ay_srer_sub_city">
        <option value=""><?php echo esc_html__('Select a district', 'ay-simple-real-estate'); ?></option>
        <!-- Sub cities will be populated here dynamically -->
    </select>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Sub-cities data from PHP
            var subCitiesByParent = <?php echo json_encode($sub_cities_by_parent); ?>;
            
            // Get the dropdown elements
            var citySelect = document.getElementById('ay_srer_city');
            var subCitySelect = document.getElementById('ay_srer_sub_city');

            // Function to update sub cities dropdown
            function updateSubCities(parentCityId) {
                // Clear previous options
                subCitySelect.innerHTML = '<option value=""><?php echo esc_html__('Select a district', 'ay-simple-real-estate'); ?></option>';
                
                // Check if sub cities exist for the selected parent city
                if (subCitiesByParent[parentCityId]) {
                    subCitiesByParent[parentCityId].forEach(function(subCity) {
                        var option = document.createElement('option');
                        option.value = subCity.term_id;
                        option.textContent = subCity.name;
                        if (subCity.term_id == '<?php echo esc_js($selected_sub_city_id); ?>') {
                            option.selected = true; // Mark the correct sub city as selected
                        }
                        subCitySelect.appendChild(option);
                    });
                }
            }

            // Initially update sub cities dropdown if a parent city is already selected
            var initialCityId = citySelect.value;
            if (initialCityId) {
                updateSubCities(initialCityId);
            }

            // Listen for changes in the city dropdown
            citySelect.addEventListener('change', function() {
                var selectedCityId = citySelect.value;
                updateSubCities(selectedCityId);
            });
        });
    </script>

    <!-- Here ends the dynamic address input -->

    <label for="ay_srer_address"><?php echo esc_html__('Address:', 'ay-simple-real-estate'); ?></label>
    <input type="text" id="ay_srer_address" name="ay_srer_address" value="<?php echo esc_attr($address); ?>" />

    <label for="ay_srer_currency"><?php echo esc_html__('Currency:', 'ay-simple-real-estate'); ?></label>
    <select id="ay_srer_currency" name="ay_srer_currency">
        <option value=""><?php echo esc_html__('Select a currency', 'ay-simple-real-estate'); ?></option>
        <option value="GBP" <?php echo selected('TL', $currency); ?>><?php echo esc_html__('TL', 'ay-simple-real-estate'); ?></option>
        <option value="USD" <?php echo selected('USD', $currency); ?>><?php echo esc_html__('USD', 'ay-simple-real-estate'); ?></option>
        <option value="EUR" <?php echo selected('EUR', $currency); ?>><?php echo esc_html__('EUR', 'ay-simple-real-estate'); ?></option>
        <option value="GBP" <?php echo selected('GBP', $currency); ?>><?php echo esc_html__('GBP', 'ay-simple-real-estate'); ?></option> 
    </select>

    <label for="ay_srer_price"><?php echo esc_html__('Price:', 'ay-simple-real-estate'); ?></label>
    <input type="number" id="ay_srer_price" name="ay_srer_price" value="<?php echo esc_attr($price); ?>" />

    <label for="ay_srer_rooms"><?php echo esc_html__('Rooms:', 'ay-simple-real-estate'); ?></label>
    <input type="text" id="ay_srer_rooms" name="ay_srer_rooms" value="<?php echo esc_attr($rooms); ?>" />

    <label for="ay_srer_area"><?php echo esc_html__('Area (sq ft):', 'ay-simple-real-estate'); ?></label>
    <input type="number" id="ay_srer_area" name="ay_srer_area" value="<?php echo esc_attr($area); ?>" />

    <label for="ay_srer_floor"><?php echo esc_html__('Floor:', 'ay-simple-real-estate'); ?></label>
    <input type="number" id="ay_srer_floor" name="ay_srer_floor" value="<?php echo esc_attr($floor); ?>" />

    <label for="ay_srer_building_age"><?php echo esc_html__('Building Age (years):', 'ay-simple-real-estate'); ?></label>
    <input type="number" id="ay_srer_building_age" name="ay_srer_building_age" value="<?php echo esc_attr($building_age); ?>" />
</div>

