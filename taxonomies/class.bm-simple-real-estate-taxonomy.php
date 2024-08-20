<?php 

if(!class_exists('BM_SRER_Taxonomies')) {
  class BM_SRER_Taxonomies{
    function __construct() {
      add_action( 'init', array($this, 'create_taxonomies' ) );
    }

    public function create_taxonomies() {
      $feature_labels = array(
        'name'              => __('Features', 'bm-simple-real-estate'),
        'singular_name'     => __('Feature', 'bm-simple-real-estate'),
        'search_items'      => __('Search Features', 'bm-simple-real-estate'),
        'all_items'         => __('All Features', 'bm-simple-real-estate'),
        'parent_item'       => __('Parent Feature', 'bm-simple-real-estate'),
        'parent_item_colon' => __('Parent Feature:', 'bm-simple-real-estate'),
        'edit_item'         => __('Edit Feature', 'bm-simple-real-estate'),
        'update_item'       => __('Update Feature', 'bm-simple-real-estate'),
        'add_new_item'      => __('Add New Feature', 'bm-simple-real-estate'),
        'new_item_name'     => __('New Feature Name', 'bm-simple-real-estate'),
        'menu_name'         => __('Features', 'bm-simple-real-estate'),
      );

      $feature_args = array(
        'hierarchical'      => false,
        'labels'            => $feature_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'feature'),
        'show_in_rest'      => true,
      );

      register_taxonomy('feature', array('rent', 'buy'), $feature_args);


      $city_labels = array(
      'name'              => __('Cities', 'bm-simple-real-estate'),
      'singular_name'     => __('City', 'bm-simple-real-estate'),
      'search_items'      => __('Search Cities', 'bm-simple-real-estate'),
      'all_items'         => __('All Cities', 'bm-simple-real-estate'),
      'parent_item'       => __('Parent City', 'bm-simple-real-estate'),
      'parent_item_colon' => __('Parent City:', 'bm-simple-real-estate'),
      'edit_item'         => __('Edit City', 'bm-simple-real-estate'),
      'update_item'       => __('Update City', 'bm-simple-real-estate'),
      'add_new_item'      => __('Add New City', 'bm-simple-real-estate'),
      'new_item_name'     => __('New City Name', 'bm-simple-real-estate'),
      'menu_name'         => __('Cities', 'bm-simple-real-estate'),
      );

      $city_args = array(
        'hierarchical'      => true,
        'labels'            => $city_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'city'),
        'show_in_rest'      => true,
      );

      register_taxonomy('city', array('rent', 'buy'), $city_args);
    }
  }
}

