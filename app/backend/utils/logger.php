<?php
use Monolog\Level;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;


class Log {
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance === null) {     
            $logger = new Monolog\Logger('logger');
            $logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/store.log', Level::Debug));
            $logger->pushHandler(new FirePHPHandler());
            self::$instance = $logger;
        }
        return self::$instance;
    }
}