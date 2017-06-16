<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2017/5/27
 * Time: 14:52
 */

//服务配置
use Framework\Mvc\Writer;


$di->setShared("writer",function() use ($di){
        $write=new Writer($di);
        $write->setDI($di);
        return $write;
});