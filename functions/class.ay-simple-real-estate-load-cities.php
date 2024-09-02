<?php

if(!class_exists('AY_SRER_LoadCities')) {
    class AY_SRER_LoadCities{
        public function __construct() {

        }

        public function load_cyprus_cities_tr() {
            $cities = array(
                'Lefkoşa' => array('Akıncılar', 'Dikmen', 'Gönyeli', 'Alayköy', 'Haspolat'),
                'Gazimağusa' => array('Geçitkale', 'Serdarlı', 'Paşaköy', 'Mutluyaka'),
                'Girne' => array('Çatalköy', 'Alsancak', 'Lapta', 'Karşıyaka'),
                'Güzelyurt' => array('Yuvacık', 'Bostancı', 'Akçay', 'Zümrütköy'),
                'İskele' => array('Boğaz', 'Mehmetçik', 'Karpaz', 'Kumyalı')
            );

            foreach ($cities as $city => $districts) {
                // Add the city as a parent term
                $parent_term = wp_insert_term(
                    $city,  // The term to add
                    'city'  // The taxonomy
                );

                // If there's an error in inserting, skip this term
                if (is_wp_error($parent_term)) {
                    continue;
                }

                // Add the districts as child terms
                foreach ($districts as $district) {
                    wp_insert_term(
                        $district,  // The term to add
                        'city',  // The taxonomy
                        array(
                            'parent' => $parent_term['term_id']  // Set the parent to the city
                        )
                    );
                }
            }
        }
    }
}