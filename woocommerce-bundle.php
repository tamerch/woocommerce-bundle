<?php
/*
Plugin Name: WooCommerce Bundle product
Plugin URI: 
Description: WooCommerce custom plugin for creating bundle product
Author: Samuel Boutron
Author URI: samuel.boutron@gmail.com
Version: 1.1.382020

	Copyright: 2012 samuel boutron (email : samuel.boutron@gmail.com)
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html

	changelog  (tested on WP 3.8 and woocommerce 2.0.20):
	- added : get each product images, and add it automaticaly in product gallery when bundle is updated
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// global variable to get plugin dir in other php files
global $wc_bundle_plugin_url;
$wc_bundle_plugin_url = plugin_dir_url(__FILE__);

// Admin
require_once dirname( __FILE__ ) . '/post-types/writepanels/writepanel-bundle_data.php';

// Frontend template
require_once dirname( __FILE__ ) . '/templates/bundle-product.php';

// Frontend template
require_once dirname( __FILE__ ) . '/templates/bundle-product-gallery.php';