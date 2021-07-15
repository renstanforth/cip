<?php
class Product {
  private $wpdb;
  private $name;
  private $price;
  private $resto_id;
  public $table_name;

  public function __construct() {
      global $wpdb;
      $this->wpdb = $wpdb;
      $this->table_name = 'cip_products';
  }

  public function setProduct( $name, $price, $resto_id ) {
    $this->name = $name;
    $this->price = $price;
    $this->resto_id = $resto_id;
  }

  public function getProducts() {
    $table_content = $this->wpdb->get_results( "SELECT * FROM $this->table_name" );
    return $table_content;
  }

  public function getProductsByResto($id) {
    $table_content = $this->wpdb->get_results( "SELECT * FROM $this->table_name WHERE resto_id=$id" );
    return $table_content;
  }

  public function getProduct( $id ) {
    $product = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT * FROM $this->table_name WHERE id=$id" ) );
    return $product;
  }

  public function save() {
    $data = array( 'name' => $this->name, 'price' => $this->price, 'resto_id' => $this->resto_id );

    if ( $this->name === '' || $this->price === '' || $this->resto_id === '' ) {
      echo 'Name, price, or restaurant in form-data should not be empty.';
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