<?php 

include_once "db.php";

class User {
    private $email, $password, $username;
    private $database;
    private $isLoggedIn;

    function __construct($email, $password, $username = NULL) {
        $this->database = new Database();
        $this->email    = $email;
        $this->password = $password;
        $this->username = is_null($username) ? $username : setUsername($username) ;
    }

    // Clean it up and make sure it looks good
    private function setUsername($newUsername) {
        // Cleanup could be done better but this is supposed to be simple
        $this->username = htmlspecialchars($newUsername);
    }

    // Hash and salt the password
    private function setPassword($newPassword) {
        $hash = password_hash($newPassword, PASSWORD_BCRYPT);
        $this->password = $hash;
    }

    private function setEmail($newEmail) {
        $this->email = htmlspecialchars($newEmail);
    }

    // WIP
    public function login() : bool {
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
    public function register() : bool {
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