<?php

/**
 * Plugin Name: DG2 Woocommerce Company Fields
 * Plugin URI: 
 * Description: A Dg2 checkout company for WooCommerce
 * Verison: 1.0.0
 * Author: DG2
 * Author URI: 
 * Text Domain: dg2-woo-company
 */

if (!defined('ABSPATH')) exit();

require plugin_dir_path(__FILE__) . 'vendor/autoload.php';

use DG2\Core\MainLoader;

MainLoader::getInstance();
