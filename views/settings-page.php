<div class="wrap">
    <!-- This is the page that shows up when you click on the plugin menu item directly
        It includes some documentation and some settings -->
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <?php wp_nonce_field('populate_cities_action_nonce', 'populate_cities_nonce'); ?>
        <input type="hidden" name="action" value="populate_cities_action">
        <button type="submit" class="button">Populate Cities</button>
    </form>

</div>