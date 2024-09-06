<div class="wrap">
    <!-- This is the page that shows up when you click on the plugin menu item directly
        It includes some documentation and some settings -->
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

    <h2>Documentation</h2>

    <p>This plugin is a simple real estate plugin that allows you to add properties to your website.</p>

    <p>The shortcodes you can use are as follows:</p>

    <ul>
        <li>[property_price] - Displays the price of the property</li>
        <li>[property_rooms] - Displays the number of rooms in the property</li>
        <li>[property_address] - Displays the address of the property</li>
        <li>[property_area] - Displays the area of the property</li>
        <li>[property_floor] - Displays the floor of the property</li>
        <li>[property_building_age] - Displays the building age of the property</li>
        <li>[property_type] - Displays the type of the property</li>
        <li>[property_city] - Displays the city of the property</li>
        <li>[property_features] - Displays the features of the property</li>
        <li>[ay_srer_search_form] - Displays a search form for the properties</li>
    </ul>

    <h2>Settings</h2>

    <p>Create cities for the plugin:</p>
    
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <?php wp_nonce_field('populate_cities_action_nonce', 'populate_cities_nonce'); ?>
        <input type="hidden" name="action" value="populate_cities_action">
        <button type="submit" class="button">Populate Cities</button>
    </form>

</div>