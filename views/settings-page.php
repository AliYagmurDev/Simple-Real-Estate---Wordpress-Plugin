<div class="wrap">
    <!-- This is the page that shows up when you click on the plugin menu item directly
        It includes some documentation and some settings -->
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form method="post" action="options.php">
        <?php
            settings_fields( 'ay_srer_group' );
            do_settings_sections( 'ay_srer_settings_page' );
            do_settings_sections( 'ay_srer_settings_page_2' );
            submit_button( 'Save Settings' );
        ?>
    </form>

</div>