<?php

/**
 * Created by IntelliJ IDEA.
 * User: Jimersy Lee
 * Date: 2017/6/17
 * Time: 10:39
 */
class Di implements ArrayAccess
{
    private $_bindings = array();//服务列表
    private $_instances = array();//已经实例化的服务

    //        //获取服务
    public function get($name, $params = array())
    {
        //先从已经实例化的列表中查找
        if (isset($this->_instances[$name])) {
            return $this->_instances[$name];
        }
        //检测有没有注册该服务
        if (!isset($this->_bindings[$name])) {
            return null;
        }
        $concrete = $this->_bindings[$name]['class'];//对象具体注册内容
        $obj = null;
        //匿名函数方式
        if ($concrete instanceof Closure) {
            $obj = call_user_func_array($concrete, $params);
        } //字符串方式
        elseif (is_string($concrete)) {
            if (empty($params)) {
                $obj = new $concrete;
            } else {                //带参数的类实例化，使用反射
                $class = new ReflectionClass($concrete);
                $obj = $class->newInstanceArgs($params);
            }
        }        //如果是共享服务，则写入_instances列表，下次直接取回
        if ($this->_bindings[$name]['shared'] == true && $obj) {
            $this->_instances[$name] = $obj;
        }
        return $obj;
    }

    //检测是否已经绑定
    public function has($name)
    {
        return isset($this->_bindings[$name]) or isset($this->_instances[$name]);
    }

    //卸载服务
    public function remove($name)
    {
        unset($this->_bindings[$name], $this->_instances[$name]);
    }

    //设置服务
    public function set($name, $class)
    {
        $this->_registerService($name, $class);
    }

    //设置共享服务
    public function setShared($name, $class)
    {
        $this->_registerService($name, $class, true);
    }

    //注册服务
    private function _registerService($name, $class, $shared = false)
    {
        $this->remove($name);
        if (!($class instanceof Closure) && is_object($class)) {
            $this->_instances[$name] = $class;
        } else {
            $this->_bindings[$name] = array("class" => $class, "shared" => $shared);
        }
    }

    //ArrayAccess接口,检测服务是否存在
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    //ArrayAccess接口,以$di[$name]方式获取服务
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    //ArrayAccess接口,以$di[$name]=$value方式注册服务，非共享
    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }

    //ArrayAccess接口,以unset($di[$name])方式卸载服务
    public function offsetUnset($offset)
    {
        return $this->remove($offset);
    }
}