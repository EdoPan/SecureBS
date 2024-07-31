<?php

require __DIR__ . '/../../vendor/autoload.php';

class DBManager {
    private static $instance = null;
    private $pdo = null;
    private $hostname;
    private $username;
    private $password;
    private $dbname;
    private $charset;
    private $options;

    private function __construct(){
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $this->hostname = $_ENV['DB_HOSTNAME'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->dbname = $_ENV['DB_NAME'];
        $this->charset = $_ENV['DB_CHARSET'];
        $this->options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $this->connect();
    }

    private function connect(): void {
        $dsn = "mysql:host=$this->hostname;dbname=$this->dbname;charset=$this->charset";
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $this->options);
        } catch (\PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
    public static function getInstance(){
        if (self::$instance === null) {
            self::$instance = new DBManager();
        }
        return self::$instance->pdo;
    }
}