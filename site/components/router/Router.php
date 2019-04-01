<?php 

 class Router {
    private $request;
    private $httpMethods = array(
        "GET",
        "POST"
    ); // For now

    
    function __construct(Ifc_Request $request) {
        $this->request = $request;
    }


    function __call($name, $args) {
        list($route, $method) = $args;

        if(!in_array(strtoupper($name), $this->httpMethods)) {
            $this->handleInvalidMethod();
        }

        $this->{ strtolower($name) }[$this->formatRoute($route)] = $method;
    }


    // Remove trailing slashes
    private function formatRoute($route) {
        $result = rtrim($route, "/");
        
        if($result === "") {
            return "/";
        }

        return $result;
    }


    // Handle non existent request methods
    private function handleInvalidMethod() {
        header("{$this->request->serverProtocol} 405 Method Not Allowed");
    }

    
    // Handle non existent files
    private function defaultRequestHandler() {
        header("{$this->request->serverProtocol} 404 Not Found");
    }


    // Run whatever the closure in the request from 'index.php' says
    private function resolve() {
        $methodDict = $this->{ strtolower($this->request->requestMethod) };
        $formattedRoute = $this->formatRoute($this->request->requestUri);
        $method = $methodDict[$formattedRoute];

        if(is_null($method)) {
            $this->defaultRequestHandler();
            return;
        }

        echo call_user_func_array($method, array($this->request));
    }


    function __destruct() {
        $this->resolve();
    }
 }

?>