<?php
// Path: Docker/app/src/rooter.php

// Rooter
class Rooter{
    private $routes = [];

// add method to add a route to the routes array
    public function add($path, $callback)
    {
        $this->routes[$path] = $callback;
    }

    public function run(){
        $requestUri = $_SERVER['REQUEST_URI'];
        foreach ($this->routes as $path => $callback) {
            if ($requestUri == $path) {
                call_user_func($callback);
                return;
            }
    }
    
    // If no route is found, return a 404 error
    header("HTTP/1.0 404 Not Found");
    echo "Page not found";
    }

}