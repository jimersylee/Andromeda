<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2017/5/27
 * Time: 14:52
 */

//服务配置
use Framework\Mvc\Writer;

$di->setShared("write",function(){
        $write=new Writer();
        return $write;
});