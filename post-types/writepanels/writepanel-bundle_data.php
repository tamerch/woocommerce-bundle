<?php 


/**
 * Hook function to add checkbox or choosing bundle
 */
function custom_product_type_options( $fields ) {
	$fields['bundle'] = array(
			'id' => '_bundle',
			'wrapper_class' => 'show_if_simple',
			'label' => __('Bundle', 'woocommerce'),
			'description' => __('Bundle products have a regular price, but total price is calculated depending on items included in the bundle', 'woocommerce')
			);
	return $fields;
}
add_filter( 'product_type_options' , 'custom_product_type_options' ,25,2);	

/**
 * Hook function to add bundle form in simple product
 * Based on grouped product form with "ajax select product"
 */
function product_bundle_general_data () {
	global $post, $woocommerce, $product;
	?>
	<div class="options_group show_if_bundle">
		<p class="form-field">
			<label for="_bundle_ids"> <?php echo _e('Bundles', 'rultralight'); ?> </label>
			<select id="_bundle_ids" name="_bundle_ids[]" class="ajax_chosen_select_products" multiple="multiple" data-placeholder=" <?php echo _e('Search for a product&hellip;', 'rultralight'); ?> ">;
			<?php
			$product_ids = maybe_unserialize( get_post_meta($post->ID, '_bundle_ids', true) );
			if ($product_ids) {
				$total_price=0;
				foreach ($product_ids as $product_id) {
				
					$title 	= get_the_title($product_id);
					$sku 	= get_post_meta($product_id, '_sku', true);
					$price	= get_post_meta($product_id, '_regular_price', true);

					if (!$title) continue;
					if (isset($sku) && $sku) $str_sku = ' (SKU: ' . $sku . ')';
					if (isset($price) && $price) $str_price = ' (PRICE: ' . $price . ')';
					echo '<option value="'.$product_id.'" selected="selected">'. $title . $str_sku . $str_price . '</option>';
					$total_price += $price;
				}
			}
			?>
			</select>
		</p>
	</div> 
	<?php
 }
add_action('woocommerce_product_options_general_product_data','product_bundle_general_data');


/**
 * Saves the data put into the product boxes, as post meta data
 *
 * @param int $post_id the post (product) id
 * @param stdClass $post the post (product)
 */
function product_save_data_bundle( $post_id, $post ) {
	$bundle_product = new WC_Product( $post_id );
	
	//is bundle
	$is_bundle = (isset($_POST['_bundle'])) ? 'yes' : 'no';
	update_post_meta( $post_id, '_bundle', $is_bundle );
	
	// bundle ids
	if (isset($_POST['_bundle_ids']) && $is_bundle) {
		$bundle = array();
		$ids = $_POST['_bundle_ids'];
		$total_price = 0;
		$gallery = "";
		foreach ($ids as $id) :
			if ($id && $id>0) {
				$bundle[] = $id;
				$product = new WC_Product_simple( $id );
				$total_price = $total_price + intval($product->get_price());
				$product = get_product($id);
				$gallery = $gallery.",".$product->product_image_gallery;
			}
		endforeach;
		update_post_meta( $post_id, '_bundle_ids', $bundle );
		update_post_meta( $post_id, '_bundle_regular_price', $total_price );
		update_post_meta( $post_id, '_product_image_gallery', $gallery );
	} else {
		delete_post_meta( $post_id, '_bundle');
		delete_post_meta( $post_id, '_bundle_ids' );
		delete_post_meta( $post_id, '_bundle_regular_price', $total_price );
		delete_post_meta( $post_id, 'total_sales' );
	}
	
	// Bundle Reduction 
	if (isset($_POST['bundle_reduce'])) {
		$reduction = $_POST['bundle_reduce'];
		update_post_meta( $post_id, '_bundle_reduce', $reduction );
		update_post_meta( $post_id, '_bundle_regular_price', $total_price );
	} else {
		delete_post_meta( $post_id, '_bundle_reduce' );
		delete_post_meta( $post_id, 'total_sales' );
	}
	
}
add_action('woocommerce_process_product_meta', 'product_save_data_bundle', 25, 2);

?>