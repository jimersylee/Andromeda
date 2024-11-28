<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2017/5/27
 * Time: 15:49
 */

namespace Andromeda;

/**
 * 依赖注入实现核心类
 * Class Di
 * @package Andromeda
 */
class Di implements DiInterface
{
    /**
     * List of registered services
     */
    protected $_services;

    /**
     * List of shared instances
     */
    public $_sharedInstances;


    public function offsetExists($offset):bool
    {
        // TODO: Implement offsetExists() method.
        return false;
    }

    public function offsetGet($offset): mixed
    {
        // TODO: Implement offsetGet() method.
        return null;
    }

    public function offsetSet($offset, $value):void
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($offset):void
    {
        // TODO: Implement offsetUnset() method.
    }

}