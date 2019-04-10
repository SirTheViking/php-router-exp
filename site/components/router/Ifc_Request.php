<?php 

interface Ifc_Request {
    public function getBody();
    public function jsonRespond($message, $status);
    public function render($path);
}

?>