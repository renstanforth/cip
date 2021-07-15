<?php
class Order {
  private $wpdb;
  private $prod_id;
  private $quantity;
  private $resto_id;
  private $fees;
  private $transfer;
  private $client_name;
  public $table_name;

  public function __construct() {
      global $wpdb;
      $this->wpdb = $wpdb;
      $this->table_name = 'cip_orders';
  }

  public function setOrder( $data ) {
    $this->prod_id = $data['prod_id'];
    $this->quantity = $data['quantity'];
    $this->resto_id = $data['resto_id'];
    $this->fees = $data['fees'];
    $this->transfer = $data['transfer'];
    $this->client_name = $data['client_name'];
  }

  public function getOrders() {
    $table_content = $this->wpdb->get_results( "SELECT * FROM $this->table_name" );
    return $table_content;
  }

  public function getOrdersByDateRange($resto_id, $date_start, $date_end, $format_date = true) {
    // if ($format_date) {
      $min_date = DateTime::createFromFormat('m/d/Y', $date_start);
      $max_date = DateTime::createFromFormat('m/d/Y', $date_end);
      $min_date = $min_date->format('Y-m-d');
      $max_date = $max_date->format('Y-m-d');

    $query = "SELECT * FROM cip_orders WHERE resto_id=$resto_id";
    $query .= " AND date_created >= '$min_date 00:00:00'";
    $query .= " AND date_created <= '$max_date 23:59:59'";

    $table_content = $this->wpdb->get_results( $query );

    return $table_content;
  }

  public function getOrder( $resto_id, $date_start, $date_end ) {
    $total_sum = array(
      'total' => 0,
      'fees' => 0,
      'transfer' => 0,
      'orders' => 0
    );

    $orders_date_range = $this->getOrdersByDateRange($resto_id, $date_start, $date_end, false);

    for ($i=0; $i < count($orders_date_range); $i++) {
      $total_sum['total'] = $total_sum['total'] + (float)$orders_date_range[$i]->total;
      $total_sum['fees'] = $total_sum['fees'] + (float)$orders_date_range[$i]->fees;
      $total_sum['transfer'] = $total_sum['transfer'] + (float)$orders_date_range[$i]->transfer;
      $total_sum['orders']++;
    }

    return $total_sum;
  }

  public function getTotal( $id ) {
    $order = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT * FROM $this->table_name WHERE id=$id" ) );
    return $order;
  }

  public function save() {
    $product = new Product();
    $prod_info = $product->getProduct($this->prod_id);
    $prod_price = $prod_info->price;

    $data = array(
      'prod_id' => $this->prod_id,
      'quantity' => $this->quantity,
      'total' => $prod_price * $this->quantity,
      'resto_id' => $this->resto_id,
      'fees' => $this->fees,
      'transfer' => $this->transfer,
      'client_name' => $this->client_name,
    );

    if ( $this->prod_id === '' ||
        $this->quantity === '' ||
        $this->resto_id === '' ||
        $this->fees === '' ||
        $this->transfer === '' ||
        $this->client_name === ''
      ) {
      echo 'Please provide complete details';
      return false;
    }

    $result = $this->wpdb->insert( $this->table_name, $data );

    if ( $result ) {
      return true;
    }

    return false;
  }

  public function delete( $id ) {
    $this->wpdb->delete( $this->table_name, array( 'id' => $id ) );
    return true;
  }
}