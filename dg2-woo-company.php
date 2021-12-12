<?php

/**
 * Plugin Name: DG2 Woocommerce Company Fields
 * Plugin URI: https://digital2.rs
 * Description: A Dg2 checkout company for WooCommerce
 * Verison: 1.0.0
 * Author: Digital2
 * Author uRI: https://digital2.rs
 * Text Domain: dg2-woo-company
 */

if (!defined('ABSPATH')) exit();

require plugin_dir_path(__FILE__) . 'vendor/autoload.php';

use DG2\Core\MainLoader;

MainLoader::getInstance();
