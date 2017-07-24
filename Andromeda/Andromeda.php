<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2017/6/16
 * Time: 12:42
 */









class Andromeda extends \Framework\Di\Injectable {
    public static $s_arr_query;

    public static function run($di=null){
        self::error();
        self::init();
        self::autoload();
        self::dispatch($di);

    }


    /**
     * 框架初始化
     * Initialization
     */
    private static function init(){
        //Define path constants

        define("FRAMEWORK_PATH", ROOT . DS."Andromeda" . DS);
        define("PUBLIC_PATH", ROOT . "public" . DS);
        define("CONFIG_PATH", APP_PATH . "config" . DS);
        define("CONTROLLER_PATH", APP_PATH . "Controllers" . DS);
        define("MODEL_PATH", APP_PATH . "models" . DS);
        define("VIEW_PATH", APP_PATH . "views" . DS);
        define("CORE_PATH", FRAMEWORK_PATH . "core" . DS);
        define('DB_PATH', FRAMEWORK_PATH . "database" . DS);
        define("LIB_PATH", FRAMEWORK_PATH . "libraries" . DS);
        define("HELPER_PATH", FRAMEWORK_PATH . "helpers" . DS);
        define("UPLOAD_PATH", PUBLIC_PATH . "uploads" . DS);


        //定义模块,控制器,动作,例子:index.php?p=home&c=Index&a=index&param1=xxx&param2=xxx....
        //Define platform,controller,action,example:
        define("PLATFORM",isset($_REQUEST['p'])? $_REQUEST['p']:'home');
        define("CONTROLLER",isset($_REQUEST['c'])? $_REQUEST['c']:'Index');
        define("ACTION", isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index');

        //载入核心类
        //load core class
        require CORE_PATH."Controller.class.php";
        require CORE_PATH."Loader.class.php";
        require CORE_PATH."Mysql.class.php";
        require CORE_PATH."Model.class.php";
        require CORE_PATH."View.class.php";
        require CORE_PATH."Util.class.php";
        require CORE_PATH."Log.class.php";



        $url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];//todo 支持https
        $arr=parse_url($url);
        //echo $url;

        self::$s_arr_query=Util::convertUrlQuery($arr['query']);
        //var_dump($GLOBALS['arr_query']);



        define("CURR_CONTROLLER_PATH",CONTROLLER_PATH.PLATFORM.DS);
        define("CURR_VIEW_PATH",VIEW_PATH.PLATFORM.DS);




        //load configuration file

        //$GLOBALS['config']=include CONFIG_PATH."config.php";

        //start session

        session_start();

    }



    /**
     * 自动加载
     * Auto loading
     */
    private static function autoload(){
        spl_autoload_register(array(__CLASS__,'load'));
    }

    //define a custom load method
    private static function load($className){
        if(substr($className,-10)=="Controller"){
            //it is controller
            $path=CURR_CONTROLLER_PATH."$className.class.php";
            /*var_dump($path);
            die();*/
            include_once $path;

        }elseif(substr($className,-5)=="Model"){
            //it is model
            require MODEL_PATH."$className.php";


        }
    }


    /**
     * 设置路由与调度器
     * @param $di:注入器
     * Routing and dispatching
     */
    private static function dispatch($di){
        // Instantiate the controller class and cass its action method
        $controller_name=CONTROLLER."Controller";
        $action_name=ACTION;
        $controller=new $controller_name;
        $controller->setDI($di);



        $num=count(self::$s_arr_query);
        //echo 'oldNum='.$num;

        self::$s_arr_query=array_slice(self::$s_arr_query,3,$num-3);
        //$controller->$action_name(self::$s_arr_query);//

        $num=count(self::$s_arr_query);
        //echo 'newNum='.$num;
        $str_temp='';

        foreach(self::$s_arr_query as $key=>$value){
            $str_temp=$str_temp.self::$s_arr_query[$key].',';
        }

        $str_temp=rtrim($str_temp,',');
        $fun='$controller->$action_name('.$str_temp.');';
        //$fun='$controller->$action_name(self::$s_arr_query);';
        //echo $fun;
        eval($fun);

    }


    /**
     * 设置错误与异常处理
     */
    private static function error(){
        error_reporting(E_ALL);
        set_error_handler([__CLASS__, 'appError']);
        set_exception_handler([__CLASS__, 'appException']);
        register_shutdown_function([__CLASS__, 'appShutdown']);
    }

    public static function appError(){
        echo '-------error--------';
        $errorArr=error_get_last();
        echo $errorArr['type']."<br>";
        echo $errorArr['message']."<br>";
    }

    /**
     * 设置异常处理
     * @param Throwable $exception
     */
    public static function appException($exception){
        echo '<br>';
        echo "----------exception--------<br>";
        //todo 判断是不是人为抛出的异常,如果是则正常抛,否则都归为系统异常,不向用户暴露错误原因,开启debug模式可以出异常


        echo "code=".$exception->getCode()."<br>";
        echo "message=".$exception->getMessage()."<br>";
        echo "file=".$exception->getFile()."<br>";
        echo "line=".$exception->getLine(),"<br>";
        echo "trace=".$exception->getTraceAsString()."<br>";
    }

    /**
     * php脚本无论正常执行完毕或者异常结束都会调用
     */
    public static function appShutdown(){
        //echo '****shutdown****';
    }

}





