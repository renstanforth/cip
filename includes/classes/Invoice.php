<?php
class Invoice {
  private $wpdb;

  public function __construct() {
    global $wpdb;
    $this->wpdb = $wpdb;
  }

  public function getInvoices( $id = null ) {
    $invoice_post = $this->getInvoicePost( $id );
    $data = array();
    foreach ($invoice_post as $key => $value) {
      $item = array(
        'id' => $value->ID,
        'restaurant' => null,
        'status' => null,
        'start_date' => null,
        'end_date' => null,
        'total' => null,
        'fees' => null,
        'transfer' => null,
        'orders' => null,
        'order_list' => null,
      );
      $invoice_postmeta = $this->getPostMeta($value->ID);
      $resto_id = 0;
      
      foreach ($invoice_postmeta as $key_postmeta => $value_postmeta) {
        switch ($value_postmeta->meta_key) {
          case 'cip_restaurant_id':
            $resto_id = $value_postmeta->meta_value;
            $restaurant = new Restaurant();
            $restaurant_info = $restaurant->getRestaurant($resto_id);
            $item['restaurant'] = $restaurant_info->name;
            break;
          case 'cip_invoice_status':
            $item['status'] = strtoupper($value_postmeta->meta_value);
            break;
          case 'cip_date_start':
            $item['start_date'] = $value_postmeta->meta_value;
            break;
          case 'cip_date_end':
            $item['end_date'] = $value_postmeta->meta_value;
            break;
          
          default:
            # code...
            break;
        }
      }
      $order = new Order();
      $order_total = $order->getOrder( $resto_id, $item['start_date'], $item['end_date']);
      $item['total'] = $order_total['total'];
      $item['fees'] = $order_total['fees'];
      $item['transfer'] = $order_total['transfer'];
      $item['orders'] = $order_total['orders'];
      $item['order_list'] = $order_total['order_list'];
      $data[] = $item;
    }
    return array("data" => $data);
  }

  public function getInvoicePost( $id = null ) {
    $wpdb_posts = $this->wpdb->posts;
    $query = "
      SELECT $wpdb_posts.ID,$wpdb_posts.post_title
      FROM $wpdb_posts
      WHERE $wpdb_posts.post_type = 'invoices'";

    if ($id) {
      $query .= " AND $wpdb_posts.ID = $id";
    }

    $query .= "
      AND $wpdb_posts.post_status = 'publish'
      GROUP BY $wpdb_posts.ID
      ORDER BY $wpdb_posts.post_date DESC
    ";

    $invoices = $this->wpdb->get_results($query);
    return $invoices;
  }

  public function getPostMeta( $id ) {
    $wpdb_postmeta = $this->wpdb->postmeta;
    $query = "
      SELECT *
      FROM $wpdb_postmeta
      WHERE $wpdb_postmeta.post_id = $id
      AND $wpdb_postmeta.meta_key LIKE '%cip_%'
    ";

    $invoices = $this->wpdb->get_results($query);
    return $invoices;
  }

  public function setPaid( $ids ) {
    for ($i=0; $i < count($ids); $i++) {
      update_post_meta($ids[$i], 'cip_invoice_status', 'paid');
    }
    return true;
  }
}