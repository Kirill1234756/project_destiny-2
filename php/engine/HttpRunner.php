<?php

namespace Application;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

use function FastRoute\simpleDispatcher;

class HttpRunner
{


    public function run()
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $router) {
            include_once __DIR__ . '/routes.php';
        });

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);
        $baseUri = $this->prepareBaseUrl($uri, $_SERVER);
        $uri = str_replace($baseUri, '', $uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);


        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                header('location: ' . $baseUri . '/404');
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                header('location: ' . $baseUri . '/403');
				//echo 'Method not Allowed! Allowed: [' . implode($allowedMethods) . ']';
                break;
            case Dispatcher::FOUND:

                $routeHandler = new \Application\RouteHandler($routeInfo);
                echo $routeHandler->handle();
                break;
        }
    }

    protected function prepareBaseUrl(string $uri, array $server): string
    {
        $baseUrl = '/';


        if (!isset($server['SCRIPT_FILENAME'])) {
            throw new \RuntimeException('SCRIPT_FILENAME is not defined in server params!');
        }
        $requestPath = $uri;
        foreach (['PHP_SELF', 'SCRIPT_NAME', 'ORIG_SCRIPT_NAME'] as $v) {
            $value = (string)($server[$v] ?? '');

            if (basename($value) === basename($server['SCRIPT_FILENAME'])) {
                //  $this->file = basename($value);
                $this->publicPath = str_replace($value, '', (string)$server['SCRIPT_FILENAME']);
                $value = '/' . ltrim($value, '/');
                if ($requestPath === preg_replace('~^' . preg_quote($value, '~') . '~i', '', $requestPath)) {
                    $value = dirname($value);
                }
                $baseUrl = $value;
                break;
            }
        }


        return rtrim($baseUrl, '/\\');
    }
}



