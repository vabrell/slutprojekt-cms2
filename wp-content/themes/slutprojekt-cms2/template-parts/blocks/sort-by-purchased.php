<?php 
global $wpdb;
$query = "SELECT meta_value AS product_id, COUNT(*) AS amount FROM wp_woocommerce_order_itemmeta WHERE meta_key='_product_id' GROUP BY meta_value ORDER BY amount";
$products = $wpdb->get_results($query, OBJECT);

var_dump($products); 

foreach ($products AS $p) {
  $product = wc_get_product($p->id);

  $product-> get_image();

  $product-> get_name();

  get_permalink($product->get_id() );
}

?>