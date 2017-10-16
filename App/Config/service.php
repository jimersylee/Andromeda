<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2017/5/27
 * Time: 14:52
 */

//服务配置
use Andromeda\Mvc\Writer;
use Andromeda\Mvc\SingletonWriter;

$config = [];
//闭包 use支持多多个参数,可以利用此特性传递多个参数
$di->setShared("singletonWriter", function () use ($di, $config) {
    $singletonWriter = SingletonWriter::getInstance($di);
    return $singletonWriter;
});


//setShared 设置共享实例
$di->setShared("logger", function () use ($di) {
    $logger = Log::getInstance($di);
    return $logger;
});

//set 设置独享实例,每次调用都会new一个新的对象
$di->set("writer", function () use ($di, $config) {
    $write = new Writer($di);
    return $write;
});












/*$di->set("writer",function () use ($di){

    return null;
});*/