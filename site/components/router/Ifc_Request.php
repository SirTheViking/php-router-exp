<?php 

interface Ifc_Request {
    public function getBody();
    public function json_respond($message, $status);
    public function render($path);
}

?>