<?php

/**
* images are added to the product during the update process in admin panel
*  update_post_meta( $post_id, '_product_image_gallery', $gallery );
*/

global $post, $woocommerce, $product;
add_action('woocommerce_product_thumbnails','bundle_add_images');

function bundle_add_images() {
	
	/*
	global $post, $woocommerce, $product;  // the product
	
	print_r ("Toto = ".$product->product_image_gallery);
	echo "<br>-----------------<br>";
	//$product->product_image_gallery = "1083,1082,1081,1080,1079";
	
	// add table with products included in bundle
	$product_ids = maybe_unserialize( get_post_meta($post->ID, '_bundle_ids', true) );
	$reduction = maybe_unserialize( get_post_meta($post->ID, '_bundle_reduce', true) );
	$attachment_ids = $product->get_gallery_attachment_ids();
	
	print_r ("Bonjour Hook");
	echo "<br>-----------------<br>";
	print_r ($product);
	echo "<br>-----------------<br>";
	print_r ($post);
	echo "<br>-----------------<br>";

	print_r ($attachment_ids);
	echo "<br>-----------------<br>";
	*/
}
?>