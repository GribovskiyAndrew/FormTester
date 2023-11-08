<?php

require_once('vendor/autoload.php');

use Facebook\WebDriver\Remote\RemoteWebDriver;

class SeleniumTest
{
    public $webDriver;

    private static $instance = null;

    private function __construct()
    {
        $capabilities = ['platform' => 'WINDOWS', 'browserName' => 'chrome'];
        $this->webDriver = RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities);
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function tearDown()
    {
        $this->webDriver->quit();
    }
}
