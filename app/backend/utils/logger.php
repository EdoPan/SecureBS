<?php

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Log {

    private static $instance = null;
 
    public static function getInstance(){
        if (self::$instance === null) {
            self::$instance = new Logger('store');
            switch (basename(__DIR__)) {
                case 'utils':
                    self::$instance->pushHandler(new StreamHandler('../../../logs/store.log', Level::Info));
                    break;
                case 'backend':
                    self::$instance->pushHandler(new StreamHandler('../logs/store.log', Level::Info));
                    break;
            }
        }
        return self::$instance;
    }
}