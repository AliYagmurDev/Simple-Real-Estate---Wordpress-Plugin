<?php

if ( ! class_exists('AY_SRER_Settings')) {
    class AY_SRER_Settings{

        public function __construct() {
            add_action('admin_post_populate_cities_action', array($this, 'PopulateCities'));
        }


        public function PopulateCities() {
            // Populate the city taxonomy with Cyprus cities and districts
            $AY_SRER_LoadCities = new AY_SRER_LoadCities();
            $AY_SRER_LoadCities->load_cyprus_cities_tr();

            // Redirect back to the settings page
            wp_redirect(admin_url('admin.php?page=ay_srer_admin'));
        }
        
    }
}
