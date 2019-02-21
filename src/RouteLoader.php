<?php namespace Ddup\Route;

use Exception;


Class RouteLoader
{
    static function load($config, $dir)
    {
        foreach ($config as $group => $middlewares) {

            $file = self::groupToFile($dir, $group);

            if (!self::isExists($file)) {
                throw new Exception('路由模块不存在' . $group);
            }

            self::registe($group, $file, $middlewares);
        }
    }

    private static function groupToFile($dir, $group)
    {
        return $dir . '/' . $group . ".php";
    }

    private static function registe($group, $file, $middlewares)
    {
        Route::group($group, function () use ($file) {
            self::open($file);
        }, $middlewares);
    }

    private static function open($file)
    {
        require $file;
    }

    private static function isExists($file)
    {
        return is_file($file);
    }
}