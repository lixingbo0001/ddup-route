<?php namespace Ddup\Route;


use Ddup\Part\Libs\Arr;
use Ddup\Part\Libs\Str;
use Ddup\Route\Contracts\RouteInterface;

Class Route
{

    static function target($route, $controller)
    {
        if (!is_string($controller)) return $controller;

        $route_info = explode('.', $route);

        $controller = is_null($controller) ? Str::first($route_info[0], '/') : $controller;

        $limiters = explode('.', $controller);

        $controller = implode('\\', Arr::format($limiters, 'ucfirst'));

        return str_replace("@", "Controller@", $controller);
    }

    static function named($name, $parameters = [])
    {
        return route($name, $parameters);
    }

    static function group($prefix, $callBack, $middleware)
    {
        $route      = \Route::prefix($prefix);
        $middleware = (array)$middleware;

        $middleware && $route->middleware($middleware);

        $route->group($callBack);
    }

    /**
     * @param $methods
     * @param $route
     * @param null $controller
     * @return RouteInterface
     */
    static function match($methods, $route, $controller = null)
    {
        $methods = (array)$methods;

        $target = self::target($route, $controller);

        return \Route::match($methods, $route, $target);
    }

    static function get($route, $hanlder)
    {
        return self::match(__FUNCTION__, $route, $hanlder);
    }

    static function post($route, $hanlder)
    {
        return self::match(__FUNCTION__, $route, $hanlder);
    }

    static function put($route, $hanlder)
    {
        return self::match(__FUNCTION__, $route, $hanlder);
    }

    static function delete($route, $hanlder)
    {
        return self::match(__FUNCTION__, $route, $hanlder);
    }

    static function rest($route, $controllerName, $middleware = null)
    {
        self::get($route, $controllerName . '@limit')->middleware($middleware);
        self::post($route, $controllerName . '@create')->middleware($middleware);
        self::put($route . '/{id}', $controllerName . '@update')->where('id', '\d+')->middleware($middleware);
        self::get($route . '/{id}', $controllerName . '@show')->where('id', '\d+')->middleware($middleware);
        self::delete($route . '/{id}', $controllerName . '@delete')->where('id', '\d+')->middleware($middleware);
    }

}

