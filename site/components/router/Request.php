<?php 

include_once "Ifc_Request.php";

class Request implements Ifc_Request {

    function __construct() {
        $this->prepareProps();
    }

    // Set all keys in $_SERVER as properties of this class
    // this is so that they're easier to use in here and look better
    private function prepareProps() {
        foreach($_SERVER as $key => $value) {
            $this->{ $this->toCamelCase($key) } = $value;
        }
    }


    // Convert string from snake case to camel case
    private function toCamelCase($string) {
        $result = strtolower($string);
        preg_match_all("/_[a-z]/", $result, $matches);

        foreach($matches[0] as $match) {
            $char = str_replace("_", "", strtoupper($match));
            $result = str_replace($match, $char, $result);
        }

        return $result;
    }


    public function getBody() {
        if($this->requestMethod === "GET") {
            return;
        }

        if($this->requestMethod === "POST") {
            $body = array();
            foreach($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }

            return $body;
        }
    }


    public function json_respond($message, $status) {
        http_response_code($code);

        $response = array(
            "message" => $message,
            "status" => $status,
            "method" => $this->requestMethod // just for me
        );

        return json_encode($response);
    }

    // Path will be handled from the root of the server
    public function render($path) {
        $root = $_SERVER["DOCUMENT_ROOT"];
        $file = $root . $path;

        if(!file_exists($file)) {
            return file_get_contents("$root/views/404.php");
        }

        ob_start();
        include $file;
        return ob_get_clean();
    }
}

?>