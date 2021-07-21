<?php
   /*
   Plugin Name: Custom Invoice Plugin
   Plugin URI: https://www.renstanforth.com/
   description: This provides invoice features to the site.
   Version: 0.28
   Author: Ren Stanforth
   Author URI: https://www.renstanforth.com/
   License: GNU GPL3
   */

  /**
   * Require Classes
   */
  require_once plugin_dir_path( __FILE__ ) . 'includes/classes/Restaurant.php';
  require_once plugin_dir_path( __FILE__ ) . 'includes/classes/Product.php';
  require_once plugin_dir_path( __FILE__ ) . 'includes/classes/Order.php';
  require_once plugin_dir_path( __FILE__ ) . 'includes/classes/Invoice.php';

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
    ?>
    <h1>Invoice #<?= the_ID();?></h1>
    <?php
    include(plugin_dir_path( __FILE__ ) . '/includes/templates/invoice-form.php');
  }

  function cip_save_postmeta($post_id, $post, $update ) {
    if ( $_POST['post_type'] == 'invoices' ) {
      if (!$update) {
        add_post_meta($post_id, 'cip_restaurant_id', $_POST['cip_restaurant_id'], true);
        add_post_meta($post_id, 'cip_invoice_status', $_POST['cip_invoice_status'], true);
        add_post_meta($post_id, 'cip_date_start', $_POST['cip_date_start'], true);
        add_post_meta($post_id, 'cip_date_end', $_POST['cip_date_end'], true);
      } else {
        update_post_meta($post_id, 'cip_restaurant_id', $_POST['cip_restaurant_id']);
        update_post_meta($post_id, 'cip_invoice_status', $_POST['cip_invoice_status']);
        update_post_meta($post_id, 'cip_date_start', $_POST['cip_date_start']);
        update_post_meta($post_id, 'cip_date_end', $_POST['cip_date_end']);
      }
    }
    return $update;
  }
  add_action('save_post', 'cip_save_postmeta', 10, 3);

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
    wp_localize_script( 'cip-script', 'ajax_urls',
      array( 
          'api' => home_url() . '/wp-json/cip/v1',
      )
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
      wp_enqueue_style('datatables-responsive',
        'https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css'
      );
      wp_enqueue_style('datatables-datetime',
        'https://cdn.datatables.net/datetime/1.1.0/css/dataTables.dateTime.min.css'
      );
      wp_enqueue_style('cip-styles',
        plugins_url('public/css/style.css', __FILE__)
      );
      wp_enqueue_style('cip-styles-responsive',
        plugins_url('public/css/style-responsive.css', __FILE__)
      );
      wp_enqueue_script('jquery-script',
        'https://code.jquery.com/jquery-3.5.1.js'
      );
      wp_enqueue_script('datatables-script',
        'https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js'
      );
      wp_enqueue_script('datatables-responsive',
        'https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js'
      );
      wp_enqueue_script('moment-script',
        'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js'
      );
      wp_enqueue_script('datetime-script',
        'https://cdn.datatables.net/datetime/1.1.0/js/dataTables.dateTime.min.js'
      );
      wp_enqueue_script('cip-script',
      plugins_url('public/js/script.js', __FILE__)
      );

      wp_localize_script( 'cip-script', 'ajax_urls',
        array( 
            'api' => home_url() . '/wp-json/cip/v1',
            'plugin_public_images' => plugin_dir_url( __FILE__ ) . "public/images",
        )
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

  /**
   * REST API: Restaurants
   */
  function cip_api_restaurant_get( $data ) {
    $restaurant = new Restaurant();
    if ( $data->get_param('id') ) {
      return $restaurant->getRestaurant( $data->get_param('id') );
    } else {
      return $restaurant->getRestaurants();
    }
  }
  add_action('rest_api_init', function () {
    register_rest_route( 'cip/v1', 'restaurants', array(
          'methods'  => 'GET',
          'callback' => 'cip_api_restaurant_get'
        ));
  });

  function cip_api_restaurant_insert( $data ) {
    $restaurant = new Restaurant();
    $name = $data->get_param('name');
    $logo = $data->get_param('logo');
    $restaurant->setRestaurant( $name, $logo );
    if ( $restaurant->save() ) {
      return true;
    }
  }
  add_action('rest_api_init', function () {
    register_rest_route( 'cip/v1', 'restaurants/insert', array(
            'methods'  => 'POST',
            'callback' => 'cip_api_restaurant_insert'
        ));
  });

  function cip_api_restaurant_remove( $data ) {
    $restaurant = new Restaurant();
    $id = $data->get_param('id');
    if ( $data->get_param('id') ) {
      return $restaurant->delete( $data->get_param('id') );
    }
  }
  add_action('rest_api_init', function () {
    register_rest_route( 'cip/v1', 'restaurants/remove', array(
                  'methods'  => 'DELETE',
                  'callback' => 'cip_api_restaurant_remove'
        ));
  });

  /**
   * REST API: Products
   */
  function cip_api_product_get( $data ) {
    $product = new Product();
    if ( $data->get_param('id') ) {
      return $product->getProduct( $data->get_param('id') );
    } else if ( $data->get_param('resto_id') ) {
      return $product->getProductsByResto($data->get_param('resto_id'));
    } else {
      return $product->getProducts();
    }
  }
  add_action('rest_api_init', function () {
    register_rest_route( 'cip/v1', 'products', array(
                  'methods'  => 'GET',
                  'callback' => 'cip_api_product_get'
        ));
  });

  function cip_api_product_insert( $data ) {
    $product = new Product();
    $name = $data->get_param('name');
    $price = $data->get_param('price');
    $resto_id = $data->get_param('resto_id');
    $product->setProduct( $name, $price, $resto_id );
    if ( $product->save() ) {
      return true;
    }
  }
  add_action('rest_api_init', function () {
    register_rest_route( 'cip/v1', 'products/insert', array(
                  'methods'  => 'POST',
                  'callback' => 'cip_api_product_insert'
        ));
  });

  function cip_api_product_remove( $data ) {
    $product = new Product();
    $id = $data->get_param('id');
    if ( $data->get_param('id') ) {
      return $product->delete( $data->get_param('id') );
    }
  }
  add_action('rest_api_init', function () {
    register_rest_route( 'cip/v1', 'products/remove', array(
                  'methods'  => 'DELETE',
                  'callback' => 'cip_api_product_remove'
        ));
  });

  /**
   * REST API: Orders
   */
  function cip_api_order_get( $data ) {
    $order = new Order();
    if ( $data->get_param('id') ) {
      return $order->getOrder( $data->get_param('id') );
    } else if ($data->get_param('resto-id') &&
      $data->get_param('start-date') &&
      $data->get_param('end-date')) {
      return $order->getOrdersByDateRange($data->get_param('resto-id'),
        $data->get_param('start-date'),
        $data->get_param('end-date')
      );
    } else {
      return $order->getOrders();
    }
  }
  add_action('rest_api_init', function () {
    register_rest_route( 'cip/v1', 'orders', array(
                  'methods'  => 'GET',
                  'callback' => 'cip_api_order_get'
        ));
  });

  function cip_api_order_insert( $data ) {
    $order = new Order();
    $customer_order = array(
      'prod_id' => $data->get_param('prod_id'),
      'quantity' => $data->get_param('quantity'),
      'resto_id' => $data->get_param('resto_id'),
      'fees' => $data->get_param('fees'),
      'transfer' => $data->get_param('transfer'),
      'client_name' => $data->get_param('client_name'),
    );
    $order->setOrder( $customer_order );
    if ( $order->save() ) {
      return true;
    }
  }
  add_action('rest_api_init', function () {
    register_rest_route( 'cip/v1', 'orders/insert', array(
                  'methods'  => 'POST',
                  'callback' => 'cip_api_order_insert'
        ));
  });

  function cip_api_order_remove( $data ) {
    $order = new Order();
    $id = $data->get_param('id');
    if ( $id ) {
      return $order->delete( $id );
    }
  }
  add_action('rest_api_init', function () {
    register_rest_route( 'cip/v1', 'orders/remove', array(
                  'methods'  => 'DELETE',
                  'callback' => 'cip_api_order_remove'
        ));
  });

  function cip_get_invoices() {
    $invoice = new Invoice();
    return $invoice->getInvoices();
  }
  add_action('rest_api_init', function () {
    register_rest_route( 'cip/v1', 'invoices', array(
                  'methods'  => 'GET',
                  'callback' => 'cip_get_invoices'
        ));
  });

  function cip_download_invoice( $data ) {
    $id = $data->get_param('id');
    $invoice = new Invoice();
    if ( $id ) {
      $result = $invoice->getInvoices($id);
    } else {
      $result = $invoice->getInvoices();
    }

    $filename = 'All Invoice';
    $date = date("Y-m-d H:i:s");
    $output = fopen('php://output', 'w');
    foreach ( $result as $key => $value ) {
      foreach ($value as $key2 => $value2) {
        $filename = $value2['restaurant'] . "_Invoice_" . $value2['start_date'] . "-" . $value2['end_date'];
        fputcsv( $output, array('Invoice ID',
          'Restaurant',
          'Start Date',
          'End Date',
          'Total',
          'Fees',
          'Transfer',
          'Orders',
          'Status')
        );
        fputcsv( $output, array($value2['id'],
          $value2['restaurant'],
          $value2['start_date'],
          $value2['end_date'],
          $value2['total'],
          $value2['fees'],
          $value2['transfer'],
          $value2['orders'],
          $value2['status'])
        );
        fputcsv( $output, array(''));
        fputcsv( $output, array('LIST OF ORDERS'));
        fputcsv( $output, array('Restaurant',
          'Client Name', 
          'Product',
          'Price',
          'Quantity',
          'Total',
          'Fees',
          'Transfer')
        );
        foreach ($value2['order_list'] as $key3 => $value3) {
          fputcsv( $output, array($value3['resto_name'],
            $value3['client_name'],
            $value3['product_name'],
            $value3['product_price'],
            $value3['product_quantity'],
            $value3['order_total'],
            $value3['order_fees'],
            $value3['order_transfer'])
          );
        }
        fputcsv( $output, array(''));
        fputcsv( $output, array(''));
      }
    }
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", false);
    header('Content-Type: text/csv; charset=utf-8');
    header("Content-Disposition: attachment; filename=\"" . $filename . ".csv\";" );
    header("Content-Transfer-Encoding: binary");exit;
  }
  add_action('rest_api_init', function () {
    register_rest_route( 'cip/v1', 'invoices/download', array(
                  'methods'  => 'GET',
                  'callback' => 'cip_download_invoice'
        ));
  });

  function cip_invoice_paid( $data ) {
    $invoice = new Invoice();
    $invoice->setPaid($data->get_param('data'));
    return true;
  }
  add_action('rest_api_init', function () {
    register_rest_route( 'cip/v1', 'invoices/paid', array(
                  'methods'  => 'POST',
                  'callback' => 'cip_invoice_paid'
        ));
  });