<?php
if (!defined('WP_UNINSTALL_PLUGIN')) exit;

global $wpdb;

// Remove cip tables
$wpdb->query("DROP TABLE IF EXISTS `cip_orders`, `cip_products`, `cip_restaurants`");

// Delete Post Type Invoices
$cip_args = array('post_type' => 'invoices', 'posts_per_page' => -1);
$cip_posts = get_posts($cip_args);
foreach ($cip_posts as $post) {
	wp_delete_post($post->ID, false);
}

// Delete Post Meta related to cip
$wpdb->query("DELETE FROM `wp_postmeta` WHERE `meta_key` LIKE 'cip_%'");
