<?php

namespace Application;

class RouteHandler
{
    private array $routeData;

    public function __construct(array $routeData)
    {
        $this->routeData = $routeData;
    }

    /**
     * @return string
     */
    public function handle(): string
    {
        $handler = $this->routeData[1];
        $vars = $this->routeData[2];
        ob_start();
        $this->runHandler($handler, $vars);
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * @param \Closure|string $handler
     * @param array           $routeParams
     *
     * @return void
     */
    private function runHandler($handler, array $routeParams)
    {
        $_GET = $routeParams;// Жуткий костыль!!!!
        if ($handler instanceof \Closure) {
            $handler();
        } elseif (is_string($handler)) {
            $segments = explode('@', $handler);
            $className = $segments[0];
            if (!\class_exists($className)) {
                throw new \RuntimeException('Route handler class [' . $className . '] not exists!');
            }
            $method = count($segments) === 2
                ? $segments[1] : 'handle';
            call_user_func([$className, $method]);
        }
    }
}