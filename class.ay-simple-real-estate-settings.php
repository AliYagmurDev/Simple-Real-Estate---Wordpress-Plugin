<?php

if ( ! class_exists('AY_SRER_Settings')) {
    class AY_SRER_Settings{
        public static $options;

        public function __construct() {
            self::$options = get_option('ay_srer_settings');
            add_action('admin_init', array($this, 'admin_init'));
        }

        public function admin_init() {
            
            register_setting( 'ay_srer_group', 'ay_srer_settings' );

            // Add First Section
            add_settings_section(
                'ay_srer_main_section',
                'How to use',
                null,
                'ay_srer_settings_page'
            );
            add_settings_field(
                'ay_srer_settings_shortcode',
                'Shortcode',
                array($this, 'ay_srer_shortcode_callback'),
                'ay_srer_settings_page',
                'ay_srer_main_section'
            );

            // Add Second Section
            add_settings_section(
                'ay_srer_options_section',
                'Plugin Options',
                null,
                'ay_srer_settings_page_2'
            );

            add_settings_field(
                'ay_srer_settings_options',
                'Options',
                array($this, 'ay_srer_options_callback'),
                'ay_srer_settings_page_2',
                'ay_srer_options_section'
            );
        }

        // Callback for first section
        public function ay_srer_shortcode_callback() {
            echo '<span> The shortcodes you can use are as follows:  (under construction)</span>';
        }

        // Callback for second section
        public function ay_srer_options_callback() {
            echo '<span> Options for the plugin are as follows:  (under construction)</span>';
            ?>
                <input 
                type="text" 
                name="ay_srer_settings[ay_srer_settings_options]" 
                id="ay_srer_settings_options"
                value="<?php echo isset( self::$options['ay_srer_settings_options'] ) ? esc_attr(self::$options['ay_srer_settings_options']) : ''; ?>"
                >
            <?php
        }
    }
}
