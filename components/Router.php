<?php

/**
 * Class Router
 * Component for working with routes
 */
class Router
{

    /**
     * property to store an array of routes
     * @var array 
     */
    private $routes;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Path to file with routes
        $routesPath = ROOT . '/config/routes.php';

        // Get the routes from the file
        $this->routes = include($routesPath);
    }

    /**
     * Return REQUEST string
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    /**
     * Method to parsing the request
     */
    public function run()
    {
        // Getting request string
        $uri = $this->getURI();

        // Cheking request in the routes array (routes.php)
        foreach ($this->routes as $uriPattern => $path) {

            // compare  $uriPattern и $uri
            if (preg_match("~$uriPattern~", $uri)) {

                // get the inner path from the outer according to the Regular Expressions.
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                // define controller, action, parameters 

                $segments = explode('/', $internalRoute);

                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action' . ucfirst(array_shift($segments));

                $parameters = $segments;

                // Attach controller class file
                $controllerFile = ROOT . '/controllers/' .
                        $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }

                //instantiate an object and call a method (action)
                $controllerObject = new $controllerName;

                /* Call the method ($ actionName) 
                 * of a class ($ controllerObject) 
                 * with the given ($ parameters) parameters
                 */
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

                // If the controller method is successfully called, break the router.
                if ($result != null) {
                    break;
                }
            }
        }
    }

}
