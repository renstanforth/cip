<?php
   /*
   Plugin Name: Custom Invoice Plugin
   Plugin URI: https://www.renstanforth.com/
   description: This provides invoice features to the site.
   Version: 0.1
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
      'label'     => __( 'Invoices', 'textdomain' ),
      'menu_icon' => 'dashicons-media-spreadsheet',
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
    // ToDo: Uninstallation
  }
  register_uninstall_hook( __FILE__, 'cip_uninstall' );
?>