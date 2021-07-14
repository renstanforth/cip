<?php
   /*
   Plugin Name: Custom Invoice Plugin
   Plugin URI: https://www.renstanforth.com/
   description: This provides invoice features to the site.
   Version: 0.13
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
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $tables_path = plugin_dir_path( __FILE__ ) . '/includes/migration/tables.sql';
    $tables_sql = file_get_contents($tables_path);
    $sql = str_replace('__charset_collate__', $charset_collate, $tables_sql);
    
    // Create tables
    dbDelta( $sql );

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
    <?php
    include(plugin_dir_path( __FILE__ ) . '/includes/templates/invoice-form.php');
  }

  function my_add_custom_fields($post_id)
  {
      if ( $_POST['post_type'] == 'invoices' ) {
          add_post_meta($post_id, 'my_meta_key_name', 'my meta value', true);
      }
      return true;
  }
  add_action('wp_insert_post', 'my_add_custom_fields');

  function cip_scripts_and_styles_admin(){
    wp_enqueue_style('cip-styles',
    plugins_url('admin/css/style.css', __FILE__)
    );
    wp_enqueue_style('bootstrap4',
      'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css'
    );
    wp_enqueue_style('jquery-css',
      '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'
    );
    wp_enqueue_script('bootstrap-script',
      'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js'
    );
    wp_enqueue_script('jquery-script',
      'https://code.jquery.com/jquery-1.12.4.js',
      array('jquery','jquery-ui-droppable','jquery-ui-draggable', 'jquery-ui-sortable')
    );
    wp_enqueue_script('jquery-ui-script',
      'https://code.jquery.com/ui/1.12.1/jquery-ui.js'
    );
    wp_enqueue_script('cip-script',
    plugins_url('admin/js/script.js', __FILE__)
    );
  }
  add_action('admin_enqueue_scripts','cip_scripts_and_styles_admin');

  function cip_scripts_and_styles_public(){
    global $post;
    if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'cip_invoice_table') ) {
      wp_enqueue_style('bootstrap4',
        'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css'
      );
      wp_enqueue_style('datatables',
        'https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css'
      );
      wp_enqueue_script('jquery-script',
        'https://code.jquery.com/jquery-3.5.1.js'
      );
      wp_enqueue_script('datatables-script',
        'https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js'
      );
      wp_enqueue_script('cip-script',
      plugins_url('public/js/script.js', __FILE__)
      );
    }
  }
  add_action('wp_enqueue_scripts','cip_scripts_and_styles_public');

  /**
   * Restaurant Management
   */
  function cip_restaurant_menus() {
    add_menu_page(
        __( 'Restaurants', 'textdomain' ),
        __( 'Restaurants','textdomain' ),
        'manage_options',
        'restaurant-mngmt-page',
        'cip_restaurant_mngmt',
        'dashicons-food',
        59
    );

    add_submenu_page(
      'restaurant-mngmt-page',
      __( 'Products', 'textdomain' ),
      __( 'Products','textdomain' ),
      'manage_options',
      'cip-products-page',
      'cip_products_mngmt',
      1
    );

    add_submenu_page(
      'restaurant-mngmt-page',
      __( 'Orders', 'textdomain' ),
      __( 'Orders','textdomain' ),
      'manage_options',
      'cip-orders-page',
      'cip_orders_mngmt',
      2
    );
  }
  add_action('admin_menu', 'cip_restaurant_menus');
  
  /**
   * Display callback for pages
   */
  function cip_restaurant_mngmt() {
      include(plugin_dir_path( __FILE__ ) . '/includes/templates/restaurant-page.php');
  }

  function cip_products_mngmt() {
    include(plugin_dir_path( __FILE__ ) . '/includes/templates/products-page.php');
  }

  function cip_orders_mngmt() {
    include(plugin_dir_path( __FILE__ ) . '/includes/templates/orders-page.php');
  }

  /**
   * Shortcode for Invoice table
   */
  function cip_invoice_table_shortcode() {
    ob_start();
    include(plugin_dir_path( __FILE__ ) . '/includes/templates/invoice-dashboard.php');

    return ob_get_clean();
  }
  add_shortcode('cip_invoice_table', 'cip_invoice_table_shortcode');