<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form method="post" action="options.php">
        <?php
            settings_fields( 'ay_srer_group' );
            do_settings_sections( 'ay_srer_settings_page' );
            submit_button( 'Save Settings' );
        ?>
    </form>

</div>