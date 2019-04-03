<?php 

include_once "/components/User.php";

// Just to be sure
if(empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["email"])) {
    echo "Fields required"; // Needs better message
    exit(0);
}

$user = new User(
    $_POST["email"],
    $_POST["password"]
);
$user->login();
// TODO: Simple template engine to render easier?

exit(0);
?>