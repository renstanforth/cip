<?php
class Restaurant {
  private $wpdb;
  private $name;
  private $image;
  public $table_name;

  public function __construct() {
      global $wpdb;
      $this->wpdb = $wpdb;
      $this->table_name = 'cip_restaurants';
  }

  public function setRestaurant( $name, $logo ) {
    $this->name = $name;
    $this->image = $logo;
  }

  public function getRestaurants() {
    $table_content = $this->wpdb->get_results( "SELECT * FROM $this->table_name" );
    return $table_content;
  }

  public function getRestaurant( $id ) {
    $restaurant = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT * FROM $this->table_name WHERE id=$id" ) );
    return $restaurant;
  }

  public function save() {
    $data = array( 'name' => $this->name, 'image' => $this->image );

    if ( $this->name === '' || $this->image === '' ) {
      echo 'Name or image in form-data should not be empty.';
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