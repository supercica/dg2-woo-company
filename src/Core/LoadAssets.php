<?php

namespace DG2\Core;

class LoadAssets
{
    // Plugin version
    const DG2_VERSION = '1.0.0';


    // class instance
    private static $instance = null;

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_script']);
        add_action('plugins_loaded', [$this, 'language_plugins_loaded'], 0);
    }

    function language_plugins_loaded()
    {
        load_plugin_textdomain('dg2-woo-addons', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    function enqueue_script()
    {
        if (is_checkout()) {
            wp_register_style('pib_checkout_style', plugins_url('../assets/style.css', __DIR__), [], self::DG2_VERSION, 'all');
            wp_register_script('pib_checkout_script', plugins_url('../assets/script.js', __DIR__), ['jquery'], self::DG2_VERSION, true);
            // wp_register_script('pib_checkout_script', plugins_url('/assets/script.js', __FILE__), array('jquery'));
            wp_enqueue_style('pib_checkout_style');
            wp_enqueue_script('pib_checkout_script');
        }
    }


    /**
     * Instance
     * Retrive instance of the class Dg1_Includes.
     * @access public
     * @return object $instance of the class
     */
    static public function getInstance()
    {
        if (self::$instance == NULL) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
