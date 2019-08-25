<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2017/5/27
 * Time: 14:24
 */

use Andromeda\Di\FactoryDefault\FactoryDefault;


include "./vendor/autoload.php";
$whoops = new \Whoops\Run();
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
$whoops->register();


//分隔符 window与linux不同
define("DS", DIRECTORY_SEPARATOR);

define('ROOT', __DIR__ . DS);

//echo BASE_PATH;

define('APP_PATH', ROOT . 'App' . DS);//定义app目录
//echo APP_PATH;

// 环境常量
define('IS_CLI', PHP_SAPI == 'cli' ? true : false);


include ROOT . "/Andromeda/DiInterface.php";
include ROOT . "/Andromeda/Di.php";
include ROOT . "/Andromeda/Di/FactoryDefault.php";
include ROOT . "/Andromeda/Di/InjectionAwareInterface.php";
include ROOT . "/Andromeda/Di/Injectable.php";

include ROOT . "/Andromeda/App.php";
include ROOT . "/Andromeda/Andromeda.php";
include ROOT . "/Andromeda/Request.php";
include ROOT . "/Andromeda/Exception.php";


//容器
$di = new FactoryDefault();


require_once "Andromeda/Andromeda.php";
include ROOT . "/Andromeda/Mvc/Controller.php";


//载入路由配置 handle routes

include APP_PATH . "Config/router.php";

//载入服务配置 read service
include APP_PATH . "Config/service.php";

//载入自动加载配置
include APP_PATH . "Config/loader.php";

//应用(组件)
$app = new \Andromeda\App($di);

Andromeda::run($di);


















