<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2017/5/27
 * Time: 14:37
 */

namespace Framework\Di\FactoryDefault;

use Framework\Di;


/**
 * 相当于服务容器
 * Class Factory
 * @package Framework\Di
 */
class FactoryDefault extends Di
{
    /*
     * 设置共享服务
     * @param $name
     * @param $definition
     */
    public function setShared($name, $definition)
    {
        $this->_sharedInstances[$name] = $definition;
    }


    /**
     * 获取共享服务实例
     * @param $name :服务名
     * @param $param_arr :配置
     * @return mixed
     * @throws \Exception
     */
    public function get($name, $param_arr = null)
    {

        $instance = null;

        if (isset($this->_sharedInstances[$name])) {
            $definition = $this->_sharedInstances[$name];
        } else {
            //去独立服务里面去找
            if(isset($this->_services['name'])){
                //找到,new一个新的实例
                $instance=new $name;
                return $instance;
            }else{
                //没找到
                throw new \Exception("Service '" . $name . "' wasn't found in the dependency injection container");
            }



        }

        if (!is_object($definition)) {
            throw new \Exception("Service $name wasn't a object");
        }

        if ($param_arr == null) {
            $instance = call_user_func($definition);
        } else {
            $instance = call_user_func_array($definition, $param_arr);
        }
        return $instance;

    }

    /*
     * 设置独立服务,每次获取的时候会实例化
     * @param $name
     * @param $definition
     */
    public function set($name, $definition)
    {
        $this->_sharedInstances[$name] = $definition;
        $this->_services[$name]=$definition;
    }

    public function __construct()
    {
        return $this;
    }
}