<?php 

if(!class_exists('BM_SRER_Post_Types')) {
  class BM_SRER_Post_Types{
    function __construct() {
      add_action( 'init', array($this, 'create_post_types' ) );
      add_action( 'add_meta_boxes', array($this, 'bm_srer_add_meta_boxes'));
      add_action( 'save_post', array($this, 'bm_srer_save_meta_box_data'), 10);

      // Custom columns for rent post type
      add_filter( 'manage_rent_posts_columns', array($this, 'bm_srer_cpt_columns'));
      add_action( 'manage_rent_posts_custom_column', array($this, 'bm_srer_custom_columns'), 10, 2 );
      add_filter( 'manage_edit-rent_sortable_columns', array($this, 'bm_srer_sortable_columns'));

      // Custom columns for buy post type
      add_filter( 'manage_buy_posts_columns', array($this, 'bm_srer_cpt_columns'));
      add_action( 'manage_buy_posts_custom_column', array($this, 'bm_srer_custom_columns'), 10, 2 );
      add_filter( 'manage_edit-buy_sortable_columns', array($this, 'bm_srer_sortable_columns'));
    }

    // Create the post types
    public function create_post_types() {
      register_post_type('rent',
        array(
          'label' => __('Rent Listings', 'bm-simple-real-estate'),
          'description' => __('Rent Listings', 'bm-simple-real-estate'),
          'labels' => array(
            'name' => __('Rent Listings', 'bm-simple-real-estate'),
            'singular_name' => __('Rent Listing', 'bm-simple-real-estate'),
            'add_new' => __('Add New Rent Listing', 'bm-simple-real-estate'),
            'add_new_item' => __('Add New Rent Listing', 'bm-simple-real-estate'),
            'edit_item' => __('Edit Rent Listing', 'bm-simple-real-estate'),
            'new_item' => __('New Rent Listing', 'bm-simple-real-estate'),
            'view_item' => __('View Rent Listing', 'bm-simple-real-estate'),
            'search_items' => __('Search Rent Listings', 'bm-simple-real-estate'),
            'not_found' => __('No Rent Listings found', 'bm-simple-real-estate'),
            'not_found_in_trash' => __('No Rent Listings found in Trash', 'bm-simple-real-estate')
          ),
          'public' => true,
          'has_archive' => true,
          'rewrite' => array('slug' => 'rent'),
          'supports' => array('title', 'editor', 'thumbnail'),
          'menu_icon' => 'dashicons-admin-home',
          'show_in_rest' => true,
          'show_ui' => true,
          'show_in_menu' => false,
          'show_in_admin_bar' => true,
          'can_export' => true,
          'publicly_queryable' => true,
        )
      );

      register_post_type('buy',
        array(
          'label' => __('Buy Listings', 'bm-simple-real-estate'),
          'description' => __('Buy Listings', 'bm-simple-real-estate'),
          'labels' => array(
            'name' => __('Buy Listings', 'bm-simple-real-estate'),
            'singular_name' => __('Buy Listing', 'bm-simple-real-estate'),
            'add_new' => __('Add New Buy Listing', 'bm-simple-real-estate'),
            'add_new_item' => __('Add New Buy Listing', 'bm-simple-real-estate'),
            'edit_item' => __('Edit Buy Listing', 'bm-simple-real-estate'),
            'new_item' => __('New Buy Listing', 'bm-simple-real-estate'),
            'view_item' => __('View Buy Listing', 'bm-simple-real-estate'),
            'search_items' => __('Search Buy Listings', 'bm-simple-real-estate'),
            'not_found' => __('No Buy Listings found', 'bm-simple-real-estate'),
            'not_found_in_trash' => __('No Buy Listings found in Trash', 'bm-simple-real-estate')
          ),
          'public' => true,
          'has_archive' => true,
          'rewrite' => array('slug' => 'buy'),
          'supports' => array('title', 'editor', 'thumbnail'),
          'menu_icon' => 'dashicons-admin-multisite',
          'show_in_rest' => true,
          'show_ui' => true,
          'show_in_menu' => false,
          'show_in_admin_bar' => true,
          'can_export' => true,
          'publicly_queryable' => true,
        )
      );
    }

    // Add meta boxes to the rent and buy post types
    function bm_srer_add_meta_boxes() {
      add_meta_box(
          'bm_srer_meta_box',
          __('Property Details', 'bm-simple-real-estate'),
          array($this, 'bm_srer_meta_box_callback'),
          ['rent', 'buy'],
          'normal',
          'high'
      );
    }

    // Showing the meta box and populate it with the current values
    function bm_srer_meta_box_callback($post) {
      require_once(BM_SRER_PATH . 'views/bm-simple-real-estate_metabox.php');

      
    }

    // Save meta box data
    public function bm_srer_save_meta_box_data($post_id) {
      if (!isset($_POST['bm_srer_meta_box_nonce']) || !wp_verify_nonce($_POST['bm_srer_meta_box_nonce'], 'bm_srer_save_meta_box_data')) {
          return;
      }

      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
          return;
      }

      if (!current_user_can('edit_post', $post_id)) {
          return;
      }

      if (isset($_POST['bm_srer_price'])) {
          update_post_meta($post_id, '_bm_srer_price', sanitize_text_field($_POST['bm_srer_price']));
      }

      if (isset($_POST['bm_srer_rooms'])) {
          update_post_meta($post_id, '_bm_srer_rooms', sanitize_text_field($_POST['bm_srer_rooms']));
      }

      if (isset($_POST['bm_srer_address'])) {
          update_post_meta($post_id, '_bm_srer_address', sanitize_text_field($_POST['bm_srer_address']));
      }

      if (isset($_POST['bm_srer_area'])) {
          update_post_meta($post_id, '_bm_srer_area', sanitize_text_field($_POST['bm_srer_area']));
      }

      if (isset($_POST['bm_srer_floor'])) {
          update_post_meta($post_id, '_bm_srer_floor', sanitize_text_field($_POST['bm_srer_floor']));
      }

      if (isset($_POST['bm_srer_building_age'])) {
          update_post_meta($post_id, '_bm_srer_building_age', sanitize_text_field($_POST['bm_srer_building_age']));
      }

      if (isset($_POST['bm_srer_property_type'])) {
          update_post_meta($post_id, '_bm_srer_property_type', array_map('sanitize_text_field', $_POST['bm_srer_property_type']));
      }
    }
    
    // Add custom columns to the custom post types
    public function bm_srer_cpt_columns( $columns ) {
      $columns['bm_srer_property_type'] = esc_html__('Property Type', 'bm-simple-real-estate');
      return $columns;
    }
    
    // Populate custom columns of the custom post type relevant values
    public function bm_srer_custom_columns( $column, $post_id ) {
      switch ( $column ) {
        case 'bm_srer_property_type':
          $property_types = get_post_meta($post_id, '_bm_srer_property_type', true);
          if ( !empty($property_types) ) {
            echo esc_html(implode(', ', $property_types));
          }
          break;
      }
    }

    // Make the custom columns sortable
    public function bm_srer_sortable_columns( $columns ) {
      $columns['bm_srer_property_type'] = 'bm_srer_property_type';
      return $columns;
    }
  }
}

