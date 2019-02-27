<?php

namespace Ddup\Route\Contracts;

/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2019/2/4
 * Time: 下午4:57
 */

interface RouteInterface
{
    public function where($name, $reg):self;

    public function name($name):self;

    public function middleware($key):self;
}