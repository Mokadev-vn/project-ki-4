<?php

namespace Core;

class Router
{
    protected $routes;
    protected $uri;
    protected $pathInfo;
    protected $queryString;
    protected $middleware;

    const HTTP_GET = "GET";
    const HTTP_POST = "POST";
    const HTTP_PUT = "PUT";
    const HTTP_DELETE = "DELETE";

    protected $httpMethods = [
        self::HTTP_GET,
        self::HTTP_POST,
        self::HTTP_PUT,
        self::HTTP_DELETE
    ];

    public function __construct()
    {
        $this->intUri();
    }

    public function middleware($name)
    {
        $this->middleware = $name;
        return $this;
    }

    public function group($uri, $data)
    {
        foreach ($data as $route) {
            switch ($route[0]) {
                case 'GET':
                    $this->get($uri.$route[1], $route[2]);
                    break;
                case 'POST':
                    $this->post($uri.$route[1], $route[2]);
                    break;
                case 'PUT':
                    $this->put($uri.$route[1], $route[2]);
                    break;
                case 'DELETE':
                    $this->delete($uri.$route[1], $route[2]);
                    break;
                default: 
                break;
            }
        }
        return $this;
    }


    public static function getHttpMethod()
    {
        return StrToUpper(AddSlashes(StripSlashes(strip_tags($_SERVER["REQUEST_METHOD"]))));
    }

    public function get($uri, $callback)
    {
        $this->addHttpRouter($uri, self::HTTP_GET, $callback);
    }

    public function post($uri, $callback)
    {
        $this->addHttpRouter($uri, self::HTTP_POST, $callback);
    }


    public function put($uri, $callback)
    {
        $this->addHttpRouter($uri, self::HTTP_PUT, $callback);
    }

    public function delete($uri, $callback)
    {
        $this->addHttpRouter($uri, self::HTTP_DELETE, $callback);
    }

    protected function addHttpRouter($uri, $method, $callback)
    {

        if (preg_match_all('/({([a-zA-Z]+)})/', $uri, $params)) {
            $uri = preg_replace('/({([a-zA-Z]+)})/', '(.+)', $uri);
        }

        $uri = str_replace('/', '\/', $uri);

        $route = [
            'uri' => $uri,
            'method' => $method,
            'action' => $callback,
            'params' => $params[2],
            'middleware' => $this->middleware
        ];

        $this->routes[] = $route;
        $this->middleware = null;
    }

    public function execute()
    {
        foreach ($this->routes as $route) {
            if ($route['method'] == $this->getHttpMethod()) {

                $reg = '/^' . $route['uri'] . '$/';
                if (preg_match($reg, $this->pathInfo, $params)) {

                    if ($route['middleware'] != '') {
                        $handler = new Middleware($route['middleware']);
                        if (!$handler->get()) {
                            return;
                        }
                    }
                    array_shift($params);
                    $this->callbackAction($route['action'], $params);
                    return;
                }
            }
        }
        return view('errors.404');
    }


    protected function callbackAction($action, $params)
    {
        if (is_callable($action)) {
            call_user_func_array($action, $params);
            return;
        }

        if (is_string($action)) {
            $action = explode('@', $action);
            $controller_name = $action[0];
            $controller = new $controller_name();
            call_user_func_array([$controller, $action[1]], $params);
            return;
        }
    }

    protected function handleMiddleware()
    {
    }


    public function getPathInfo()
    {
        if (!isset($this->pathInfo) && isset($_SERVER["PATH_INFO"])) {
            $this->pathInfo = rtrim(AddSlashes(StripSlashes(strip_tags($_SERVER["PATH_INFO"]))), "/");
        } else {
            $this->pathInfo = '/';
        }

        return $this->pathInfo;
    }

    public function getQueryString()
    {
        if (!isset($this->queryString)) {
            $this->queryString = AddSlashes(StripSlashes(strip_tags($_SERVER["QUERY_STRING"])));
        }

        return $this->queryString;
    }

    protected function intUri()
    {
        if (!isset($this->uri)) {
            $this->uri = $this->getPathInfo();
            //if (strlen($this->getQueryString())) {
             //   $this->uri .= "?" . $this->getQueryString();
            //}
        }

        return $this->uri;
    }
}
