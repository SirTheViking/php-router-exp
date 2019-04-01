<?php 

class Database {
    private $host = "localhost";
    private $name = "raya";
    private $username = "root";
    private $password = "root";
    private $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
    private $options = [
        PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES      => false
    ];
    private $port = "3306";
    private $charset = "utf8mb4";

    public $connection;

    public function getConnection() {
        $this->connection = null;

        try {
            $this->connection = new PDO(
                $this->dsn,
                $this->username,
                $this->password,
                $this->options
            );
        } catch (PDOException $e) {
            echo "Database connection error: " . $e->getMessage();
        }

        return $this->connection;
    }
    
}

?>