<?php 

if(!class_exists('AY_SRER_Taxonomies')) {
  class AY_SRER_Taxonomies{
    function __construct() {
      add_action( 'init', array($this, 'create_taxonomies' ) );
    }

    public function create_taxonomies() {
      $feature_labels = array(
        'name'              => __('Features', 'ay-simple-real-estate'),
        'singular_name'     => __('Feature', 'ay-simple-real-estate'),
        'search_items'      => __('Search Features', 'ay-simple-real-estate'),
        'all_items'         => __('All Features', 'ay-simple-real-estate'),
        'parent_item'       => __('Parent Feature', 'ay-simple-real-estate'),
        'parent_item_colon' => __('Parent Feature:', 'ay-simple-real-estate'),
        'edit_item'         => __('Edit Feature', 'ay-simple-real-estate'),
        'update_item'       => __('Update Feature', 'ay-simple-real-estate'),
        'add_new_item'      => __('Add New Feature', 'ay-simple-real-estate'),
        'new_item_name'     => __('New Feature Name', 'ay-simple-real-estate'),
        'menu_name'         => __('Features', 'ay-simple-real-estate'),
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
      'name'              => __('Cities', 'ay-simple-real-estate'),
      'singular_name'     => __('City', 'ay-simple-real-estate'),
      'search_items'      => __('Search Cities', 'ay-simple-real-estate'),
      'all_items'         => __('All Cities', 'ay-simple-real-estate'),
      'parent_item'       => __('Parent City', 'ay-simple-real-estate'),
      'parent_item_colon' => __('Parent City:', 'ay-simple-real-estate'),
      'edit_item'         => __('Edit City', 'ay-simple-real-estate'),
      'update_item'       => __('Update City', 'ay-simple-real-estate'),
      'add_new_item'      => __('Add New City', 'ay-simple-real-estate'),
      'new_item_name'     => __('New City Name', 'ay-simple-real-estate'),
      'menu_name'         => __('Cities', 'ay-simple-real-estate'),
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

