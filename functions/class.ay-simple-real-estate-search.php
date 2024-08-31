<?php

if (! class_exists('AY_SRER_Search')) {
    class AY_SRER_Search {

        public function __construct() {
            add_action('pre_get_posts', array($this, 'ay_srer_filter_search_query'));
        }

        // Search function
        public function ay_srer_filter_search_query($query) {
            if ($query->is_main_query() && !is_admin() && $query->is_search()) {

                // Handle property type filter
                $property_type = filter_input(INPUT_GET, 'property-type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                if ($property_type) {
                    $query->set('post_type', $property_type);
                } else {
                    $query->set('post_type', ['rent', 'buy']);
                }

                // Handle city filter
                $cities = filter_input(INPUT_GET, 'city', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
                if (!empty($cities)) {
                    $tax_query = $query->get('tax_query') ?: [];
                    $tax_query[] = [
                        'taxonomy' => 'city',
                        'field' => 'slug',
                        'terms' => $cities,
                    ];
                    $query->set('tax_query', $tax_query);
                }

                // Handle rooms filter
                $rooms = filter_input(INPUT_GET, 'rooms', FILTER_SANITIZE_NUMBER_INT);
                if ($rooms) {
                    $meta_query = $query->get('meta_query') ?: [];
                    $meta_query[] = [
                        'key' => '_ay_srer_rooms',
                        'value' => $rooms,
                        'compare' => '==',
                        'type' => 'NUMERIC'
                    ];
                    $query->set('meta_query', $meta_query);
                }

                // Handle price filter
                $price_min = filter_input(INPUT_GET, 'price-min', FILTER_SANITIZE_NUMBER_INT);
                $price_max = filter_input(INPUT_GET, 'price-max', FILTER_SANITIZE_NUMBER_INT);
                $price_meta_query = [];

                if ($price_min) {
                    $price_meta_query[] = [
                        'key' => '_ay_srer_price',
                        'value' => $price_min,
                        'compare' => '>=',
                        'type' => 'NUMERIC',
                    ];
                }

                if ($price_max) {
                    $price_meta_query[] = [
                        'key' => '_ay_srer_price',
                        'value' => $price_max,
                        'compare' => '<=',
                        'type' => 'NUMERIC',
                    ];
                }

                if ($price_meta_query) {
                    $meta_query = $query->get('meta_query') ?: [];
                    $meta_query = array_merge($meta_query, $price_meta_query);
                    $query->set('meta_query', $meta_query);
                }
            }
        }
    }
};