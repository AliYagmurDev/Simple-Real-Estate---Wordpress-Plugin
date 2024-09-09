<div class="wrap">
    <!-- This is the page that shows up when you click on the plugin menu item directly
        It includes some documentation and some settings -->
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

    <h2><?php echo __('Documentation', 'ay-simple-real-estate'); ?></h2>

    <p><?php echo __('This plugin is a simple real estate plugin that allows you to add properties to your website.', 'ay-simple-real-estate'); ?></p>

    <p><?php echo __('The shortcodes you can use are as follows:', 'ay-simple-real-estate'); ?></p>

    <ul>
        <li>[property_price] - <?php echo __('Displays the price of the property', 'ay-simple-real-estate'); ?></li>
        <li>[property_rooms] - <?php echo __('Displays the number of rooms in the property', 'ay-simple-real-estate'); ?></li>
        <li>[property_address] - <?php echo __('Displays the address of the property', 'ay-simple-real-estate'); ?></li>
        <li>[property_area] - <?php echo __('Displays the area of the property', 'ay-simple-real-estate'); ?></li>
        <li>[property_floor] - <?php echo __('Displays the floor of the property', 'ay-simple-real-estate'); ?></li>
        <li>[property_building_age] - <?php echo __('Displays the building age of the property', 'ay-simple-real-estate'); ?></li>
        <li>[property_type] - <?php echo __('Displays the type of the property', 'ay-simple-real-estate'); ?></li>
        <li>[property_city] - <?php echo __('Displays the city of the property', 'ay-simple-real-estate'); ?></li>
        <li>[property_features] - <?php echo __('Displays the features of the property', 'ay-simple-real-estate'); ?></li>
        <li>[ay_srer_search_form] - <?php echo __('Displays a search form for the properties', 'ay-simple-real-estate'); ?></li>
    </ul>

    <h2><?php echo __('Settings', 'ay-simple-real-estate'); ?></h2>

    <p><?php echo __('Create cities for the plugin:', 'ay-simple-real-estate'); ?></p>
    
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <?php wp_nonce_field('populate_cities_action_nonce', 'populate_cities_nonce'); ?>
        <input type="hidden" name="action" value="populate_cities_action">
        <button type="submit" class="button"><?php echo __('Populate Cities', 'ay-simple-real-estate'); ?></button>
    </form>

</div>