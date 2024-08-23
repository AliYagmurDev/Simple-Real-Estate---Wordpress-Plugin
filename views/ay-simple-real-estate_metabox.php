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

$property_types = array('Villa', 'Apartment', 'Penthouse', 'Residence', 'Bungalow', 'Detached House');
?>

<!-- Styling should not be here -->
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
    .ay-srer-meta-box .multiple-select {
        height: 100px; 
    }
</style>

<!-- The new meta boxes as shown in the editor page of property posts -->
<div class="ay-srer-meta-box">
    <label for="ay_srer_property_type"><?php echo esc_html__('Property Type:', 'ay-simple-real-estate'); ?></label>
    <select multiple id="ay_srer_property_type" name="ay_srer_property_type[]" class="multiple-select">
        <?php foreach ($property_types as $type) : ?>
            <option value="<?php echo esc_attr($type); ?>" <?php echo in_array($type, (array) $property_type) ? 'selected' : ''; ?>>
                <?php echo esc_html($type); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="ay_srer_address"><?php echo esc_html__('Address:', 'ay-simple-real-estate'); ?></label>
    <input type="text" id="ay_srer_address" name="ay_srer_address" value="<?php echo esc_attr($address); ?>" />

    <label for="ay_srer_price"><?php echo esc_html__('Price:', 'ay-simple-real-estate'); ?></label>
    <input type="number" id="ay_srer_price" name="ay_srer_price" value="<?php echo esc_attr($price); ?>" />

    <label for="ay_srer_rooms"><?php echo esc_html__('Rooms:', 'ay-simple-real-estate'); ?></label>
    <input type="number" id="ay_srer_rooms" name="ay_srer_rooms" value="<?php echo esc_attr($rooms); ?>" />

    <label for="ay_srer_area"><?php echo esc_html__('Area (sq ft):', 'ay-simple-real-estate'); ?></label>
    <input type="number" id="ay_srer_area" name="ay_srer_area" value="<?php echo esc_attr($area); ?>" />

    <label for="ay_srer_floor"><?php echo esc_html__('Floor:', 'ay-simple-real-estate'); ?></label>
    <input type="number" id="ay_srer_floor" name="ay_srer_floor" value="<?php echo esc_attr($floor); ?>" />

    <label for="ay_srer_building_age"><?php echo esc_html__('Building Age (years):', 'ay-simple-real-estate'); ?></label>
    <input type="number" id="ay_srer_building_age" name="ay_srer_building_age" value="<?php echo esc_attr($building_age); ?>" />
</div>

