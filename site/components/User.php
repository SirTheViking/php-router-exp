<?php 

include_once "db.php";

class User {
    private $email, $password, $username;
    private $database. $connection;
    private $error;

    function __construct($email, $password, $username = NULL) {
        $this->database = new Database();
        $this->connection = $this->database->getConnection();
        $this->setEmail($email);
        $this->password = $password; // Hash later if register
        $this->setUsername($username);
    }

    // Clean it up and make sure it looks good
    private function setUsername($newUsername) {
        // Cleanup could be done better but this is supposed to be simple
        $this->username = htmlentities($newUsername, ENT_QUOTES, "UTF-8");
    }

    // Hash and salt the password
    private function hashPassword($newPassword) {
        $hash = password_hash($newPassword, PASSWORD_BCRYPT);
        $this->password = $hash;
    }

    private function setEmail($newEmail) {
        $this->email = htmlentities($newEmail, ENT_QUOTES, "UTF-8");
    }

    // WIP
    public function login() : bool {
        $statement = $this->connection->prepare(
            "SELECT * FROM users WHERE username = :username AND email = :email;"
        );
        // All data in database is strings so this works fine
        $statement->execute(array(
            ":username" => $this->username,
            ":email"    => $this->email
        ));

        $data = $statement->fetch();
        if(empty($data)) {
            $this->error = "No user with that username or email exists";    
            return false;
        }

        if(!password_verify($this->password, $data["password"])) {
            $this->error = "Incorrect password for the username/email combination";
            return false;
        }

        return true;
    }

    // WIP
    public function register() : bool {
        $statement = $this->connection->prepare(
            "INSERT INTO users (username, password, email) VALUES (:username, :password, :email);"
        );
        // All data in database is strings so this works fine
        $statement->execute(array(
            ":username" => $this->username,
            ":password" => $this->password,
            ":email"    => $this->email
        ));

        return true;
    }

    public function getErrorMessage() {
        return $this->error;
    }
}

?>