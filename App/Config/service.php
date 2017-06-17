<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2017/5/27
 * Time: 14:52
 */

//服务配置
use Framework\Mvc\Writer;

$config=[];
//闭包 use支持多多个参数,可以利用此特性传递多个参数
$di->setShared("writer",function() use ($di,$config){
        $write=new Writer($di);
        $write->setDI($di);
        return $write;
});


/*$di->set("writer",function () use ($di){

    return null;
});*/