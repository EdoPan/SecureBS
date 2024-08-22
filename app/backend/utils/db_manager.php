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
        return self::$instance;
    }

    public function execute_query(string $query, array $parameters = [], string $param_types = "") {
        $stmt = $this->pdo->prepare($query);

        if (!$stmt) {
            throw new Exception('Prepare failed: ' . implode(', ', $this->pdo->errorInfo()));
        }

        if (!empty($parameters)) {
            if (count($parameters) !== strlen($param_types)) {
                throw new Exception('Mismatched Bind params amount and types amount');
            }

            foreach ($parameters as $index => $value) {
                $type = $param_types[$index];
                $stmt->bindValue($index + 1, $value, $this->getPDOParamType($type));
            }
        }

        if (!$stmt->execute()) {
            throw new Exception('Execute failed: ' . implode(', ', $stmt->errorInfo()));
        }

        if (preg_match('/^SELECT/', $query)) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif (preg_match('/^(INSERT|UPDATE|DELETE)/', $query)) {
            return $stmt->rowCount();
        } else {
            return null;
        }
    }

    private function getPDOParamType(string $type): int {
        switch ($type) {
            case 'i': return PDO::PARAM_INT;
            case 'd': return PDO::PARAM_STR; // Use PDO::PARAM_STR for floating point numbers
            case 's': return PDO::PARAM_STR;
            case 'b': return PDO::PARAM_LOB;
            default: throw new Exception('Unknown parameter type: ' . $type);
        }
    }
}