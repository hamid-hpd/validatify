<?php
//LanguageLoader.php
namespace Hpd\Validatify\ErrorHandlers;

use Hpd\Validatify\Configuration;

class LanguageLoader {
    private $messages;
    private static $instance = null;

    private function __construct() {
        $language = Configuration::getInstance()->get('language');
        $this->messages = include_once(__DIR__ .'../../../languages/'.$language . '.php');
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new LanguageLoader();
        }
        return self::$instance;
    }

    public function getMessages() {
        return $this->messages;
    }
} 
