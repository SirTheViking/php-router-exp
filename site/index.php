<?php 

include_once "./components/router/Request.php";
include_once "./components/router/Router.php";

$router = new Router(new Request);

$router->get("/", function($request) {
    return $request->render("/views/home.php");
});

$router->get("/data", function($request) {
    return $request->render("/views/data.php");
});

// /login    ? /user/login
// /register ? /user/register

?>