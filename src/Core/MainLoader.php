<?php

namespace DG2\Core;

use DG2\Core\LoadAssets;
use DG2\Addons\WooCompany;

class MainLoader
{
    private static $instance = null;

    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        $this->initTheme();
    }

    public function initTheme()
    {
        // init classes for theme
        LoadAssets::getInstance();
        WooCompany::getInstance();
    }

    public static function getInstance()
    {
        return (self::$instance == null)
            ? self::$instance = new self()
            : self::$instance;
    }
}
