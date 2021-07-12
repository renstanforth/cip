<?php
   /*
   Plugin Name: Custom Invoice Plugin
   Plugin URI: https://www.renstanforth.com/
   description: This provides invoice features to the site.
   Version: 0.11
   Author: Ren Stanforth
   Author URI: https://www.renstanforth.com/
   License: GNU GPL3
   */

   /**
   * Register "invoices" custom post type
   */
  function cip_setup_post_type() {
    $args = [
      'public' => true,
      'menu_icon' => 'dashicons-media-spreadsheet',
      'labels' => array(
        'name' => __( 'Invoices' ),
        'singular_name' => __( 'Invoices' ),
        'add_new_item' => __( 'Add Invoice' ),
        'add_new' => __( 'Add Invoice' ),
        'edit_item' => __( 'Edit Invoice' ),
        'featured_image' => __( 'Invoice Image' ),
        'set_featured_image' => __( 'Upload Invoice Image' ),
        'remove_featured_image' => __( 'Remove Invoice Images' ),
        'menu_name' => __( 'Invoices' ),
      ),
      'supports' => array(
        'revisions',
      ),
    ];
    register_post_type( 'invoices', $args ); 
  } 
  add_action( 'init', 'cip_setup_post_type' );

  /**
  * Activate the plugin
  */
  function cip_activate() { 
    // Trigger function to register custom post type
    cip_setup_post_type(); 
    // Clear the permalinks
    flush_rewrite_rules(); 

    // ToDo:
    // - Create DB: restaurants, orders
  }
  register_activation_hook( __FILE__, 'cip_activate' );

  /**
   * Deactivation hook
   */
  function cip_deactivate() {
    // Unregister custom post type
    unregister_post_type( 'invoices' );
    flush_rewrite_rules();
  }
  register_deactivation_hook( __FILE__, 'cip_deactivate' );

  /**
   * Uninstall hook
   */
  function cip_uninstall() {
    // ToDo: Uninstallation, remove db table restaurants/orders
  }
  register_uninstall_hook( __FILE__, 'cip_uninstall' );

  // Autogenerate Invoice Title
  function auto_generate_post_title($title) {
    global $post;
    if (isset($post->ID)) {
        if (empty($_POST['post_title']) && 'invoices' == get_post_type($post->ID)){
          // get the current post ID number
          $id = get_the_ID();
          // add ID number with order strong
          $title = 'Invoice #'.$id;} }
    return $title; 
  }
  add_filter('title_save_pre','auto_generate_post_title');

  function global_notice_meta_box() {
      add_meta_box(
          'invoice-details',
          'Invoice Details',
          'cip_invoice_details',
          'invoices'
      );
  }
  add_action( 'add_meta_boxes', 'global_notice_meta_box' );

  function cip_invoice_details() {
    // ToDo:
    // - Add restaurant dropdown
    // - Add status
    // - Add start date and end date
    // - Show total based from start date and end date
    // - Add fees, transfer
    // - Show total orders
    ?>
    <h1>Invoice #<?= the_ID();?></h1>
    <h2>Company: Restaurant 1</h2>
    <?php
  }
?>