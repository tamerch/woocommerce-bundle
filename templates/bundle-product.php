<?php

/**
* write data to product short description
*/

function product_bundle_short_desc () {
	global $post;  // the product
	
	// add table with products included in bundle
	$product_ids = maybe_unserialize( get_post_meta($post->ID, '_bundle_ids', true) );
	$reduction = maybe_unserialize( get_post_meta($post->ID, '_bundle_reduce', true) );
	
	if ( !$product_ids ) {return;}
	?>	
	
	Ce pack comprends les produits suivants :
	<style type="text/css">
		.group_table_bundle {width: 90%; margin-bottom: 1em;}
		.group_table_bundle td {vertical-align: middle; border-bottom: 1px dotted #222;}
	</style>
	
	<br><br>
	<table cellspacing="0" class="group_table_bundle">
		<tbody>
		<?php
		foreach ( $product_ids as $product_id ) { 
			$product = new WC_Product_simple( $product_id );
			echo '<tr>';
			echo '<td class="label"><label id="product-'.$product_id.'?>">';
				if ($product->is_visible()) {
					echo '<a href="'.get_permalink($product_id).'">' . $product->get_title() . '</a>';
				} else {
					echo $product->get_title();
				}
				echo '</label></td>';
				echo '<td class="price">';
				echo woocommerce_price($product->get_price(), $args = array() );
				echo '</td>';
				echo '<td class="thumbnails" style="width:32px;height:32px;">'.get_the_post_thumbnail( $product_id,array(90,90) ).'</td>';
			echo '</tr>';
		}
		?>
		</tbody>
	</table>
	
	<?php
	
	$bundle_price = get_post_meta($post->ID, '_regular_price', true);
	$sale_price = get_post_meta($post->ID, '_sale_price', true);	
	$regular_price = get_post_meta($post->ID, '_bundle_regular_price', true);
	
	$regular_price_html = woocommerce_price( $regular_price, $args = array() );
	if ($sale_price != "") { 
		$you_save_html = woocommerce_price( (floatval($sale_price) - floatval($bundle_price)), $args = array() );
	} else {
		$you_save_html = woocommerce_price( (floatval($regular_price) - floatval($bundle_price)), $args = array() );	
	}
	
	?>
	<table table cellspacing="0" class="group_table_bundle_price">
		<tbody>
			<tr>
				<td class="label"><?php _e('Prix normal','woocommerce-ru-bundle'); ?></td>
				<td class="price"><?php echo $regular_price_html; ?></td>
			</tr>
			<tr>
				<td class="label"><?php _e('Vous &eacute;conomisez','woocommerce-ru-bundle'); ?></td>
				<td class="price"><?php echo $you_save_html; ?></td>
			</tr>
		</tbody>
	</table>
	
	<style type="text/css">
		.group_table_bundle_price {width: 90%; margin-bottom: 1em;}
		.group_table_bundle_price td {vertical-align: middle; font-size: 1.25em;}
	</style>
	<?php
}
add_action('woocommerce_before_add_to_cart_form', 'product_bundle_short_desc', 25);
?>