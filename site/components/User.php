<?php 

include_once "db.php";

class User {
    private $username;
    private $password;
    private $email;
    private $database;

    function __construct() {
        $this->database = new Database();
    }

    // Clean it up and make sure it looks good
    public function setUsername($newUsername) {
        if(empty($newUsername)) {
            // Do something
        }

        $this->username = htmlspecialchars($newUsername);
    }

    // Hash and salt the password
    public function setPassword($newPassword) {
        if(empty($newPassword)) {
            // Do something
        }

        $hash = password_hash($newPassword, PASSWORD_BCRYPT);
        $this->password = $hash;
    }

    public function setEmail($newEmail) {
        if(empty($newEmail)) {
            // Do something
        }

        $this->email = htmlspecialchars($newEmail);
    }

    // WIP
    public function login() {
        $connection = $this->database->getConnection();

        $statement = $connection->prepare(
            "SELECT * FROM users WHERE username = :username AND email = :email;"
        );
        // All data in database is strings so this works fine
        $statement->execute(array(
            ":username" => $this->username,
            ":email"    => $this->email
        ));
    }

    // WIP
    public function register() {
        $connection = $this->database->getConnection();

        $statement = $connection->prepare(
            "INSERT INTO users (username, password, email) VALUES (:username, :password, :email);"
        );
        // All data in database is strings so this works fine
        $statement->execute(array(
            ":username" => $this->username,
            ":password" => $this->password,
            ":email"    => $this->email
        ));
    }
}

?>