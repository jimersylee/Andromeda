<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2017/5/27
 * Time: 14:24
 */

use Framework\Di\FactoryDefault\FactoryDefault;

define('BASE_PATH',__DIR__);
//echo BASE_PATH;

define('APP_PATH',BASE_PATH.'/App');
//echo APP_PATH;

include BASE_PATH."/Framework/DiInterface.php";
include BASE_PATH."/Framework/Di.php";
include BASE_PATH."/Framework/Di/FactoryDefault.php";


//容器
$di=new FactoryDefault();

//引用服务
include APP_PATH . "/Config/service.php";






//应用(组件)
$app=new \Framework\App($di);

var_dump($di->_sharedInstances);



