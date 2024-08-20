<?php
// Security nonce field for validation
wp_nonce_field('bm_srer_save_meta_box_data', 'bm_srer_meta_box_nonce');

// Retrieving meta values
$price = get_post_meta($post->ID, '_bm_srer_price', true);
$rooms = get_post_meta($post->ID, '_bm_srer_rooms', true);
$address = get_post_meta($post->ID, '_bm_srer_address', true);
$area = get_post_meta($post->ID, '_bm_srer_area', true);
$floor = get_post_meta($post->ID, '_bm_srer_floor', true);
$building_age = get_post_meta($post->ID, '_bm_srer_building_age', true);
$property_type = get_post_meta($post->ID, '_bm_srer_property_type', true);

$property_types = array('Villa', 'Apartment', 'Penthouse', 'Residence', 'Bungalow', 'Detached House');
?>

<style>
    .bm-srer-meta-box { 
        padding: 15px; 
        border: 1px solid #ddd; 
        border-radius: 5px; 
        background-color: #f9f9f9; 
    }
    .bm-srer-meta-box label { 
        display: block; 
        margin-bottom: 5px; 
        font-weight: bold; 
    }
    .bm-srer-meta-box input[type="text"], 
    .bm-srer-meta-box input[type="number"], 
    .bm-srer-meta-box select { 
        width: calc(100% - 22px); 
        padding: 8px; 
        margin-bottom: 10px; 
        border: 1px solid #ccc; 
        border-radius: 4px; 
    }
    .bm-srer-meta-box .multiple-select {
        height: 100px; 
    }
</style>

<div class="bm-srer-meta-box">
    <label for="bm_srer_property_type"><?php echo esc_html__('Property Type:', 'bm-simple-real-estate'); ?></label>
    <select multiple id="bm_srer_property_type" name="bm_srer_property_type[]" class="multiple-select">
        <?php foreach ($property_types as $type) : ?>
            <option value="<?php echo esc_attr($type); ?>" <?php echo in_array($type, (array) $property_type) ? 'selected' : ''; ?>>
                <?php echo esc_html($type); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="bm_srer_address"><?php echo esc_html__('Address:', 'bm-simple-real-estate'); ?></label>
    <input type="text" id="bm_srer_address" name="bm_srer_address" value="<?php echo esc_attr($address); ?>" />

    <label for="bm_srer_price"><?php echo esc_html__('Price:', 'bm-simple-real-estate'); ?></label>
    <input type="number" id="bm_srer_price" name="bm_srer_price" value="<?php echo esc_attr($price); ?>" />

    <label for="bm_srer_rooms"><?php echo esc_html__('Rooms:', 'bm-simple-real-estate'); ?></label>
    <input type="number" id="bm_srer_rooms" name="bm_srer_rooms" value="<?php echo esc_attr($rooms); ?>" />

    <label for="bm_srer_area"><?php echo esc_html__('Area (sq ft):', 'bm-simple-real-estate'); ?></label>
    <input type="number" id="bm_srer_area" name="bm_srer_area" value="<?php echo esc_attr($area); ?>" />

    <label for="bm_srer_floor"><?php echo esc_html__('Floor:', 'bm-simple-real-estate'); ?></label>
    <input type="number" id="bm_srer_floor" name="bm_srer_floor" value="<?php echo esc_attr($floor); ?>" />

    <label for="bm_srer_building_age"><?php echo esc_html__('Building Age (years):', 'bm-simple-real-estate'); ?></label>
    <input type="number" id="bm_srer_building_age" name="bm_srer_building_age" value="<?php echo esc_attr($building_age); ?>" />
</div>

