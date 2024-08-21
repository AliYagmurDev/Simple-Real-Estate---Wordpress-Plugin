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
        }

        public function ay_srer_shortcode_callback() {
            echo '<span> The shortcodes you can use are as follows:  (under construction)</span>';
        }
    }
}
