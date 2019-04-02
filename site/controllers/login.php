<?php 

include_once "/components/User.php";

// Just to be sure
if(empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["email"])) {
    echo "Fields required"; // Needs better message
    exit(0);
}

$user = new User();
$user->setPassword($_POST["password"]);
$user->setEmail($_POST["email"]);
$user->login();

exit(0);
?>