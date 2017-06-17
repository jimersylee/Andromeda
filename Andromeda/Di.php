<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2017/5/27
 * Time: 15:49
 */

namespace Framework;

/**
 * 依赖注入实现核心类
 * Class Di
 * @package Framework
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





    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

}