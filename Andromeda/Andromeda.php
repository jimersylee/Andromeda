<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2017/6/16
 * Time: 12:42
 */


class Andromeda extends \Framework\Di\Injectable
{
    public static $s_arr_query;

    public static function run($di = null)
    {
        //self::error();
        self::init();
        self::autoload();
        self::dispatch($di);

    }


    /**
     * 框架初始化
     * Initialization
     */
    private static function init()
    {
        //Define path constants

        define("FRAMEWORK_PATH", ROOT . DS . "Andromeda" . DS);
        define("PUBLIC_PATH", ROOT . "Public" . DS);
        define("CONFIG_PATH", APP_PATH . "Config" . DS);
        define("CONTROLLER_PATH", APP_PATH . "Controllers" . DS);
        define("MODEL_PATH", APP_PATH . "Models" . DS);
        define("VIEW_PATH", APP_PATH . "Views" . DS);
        define("CORE_PATH", FRAMEWORK_PATH . "core" . DS);
        define('DB_PATH', FRAMEWORK_PATH . "database" . DS);
        define("LIB_PATH", FRAMEWORK_PATH . "libraries" . DS);
        define("HELPER_PATH", FRAMEWORK_PATH . "helpers" . DS);
        define("UPLOAD_PATH", PUBLIC_PATH . "uploads" . DS);


        //定义模块,控制器,动作,例子:index.php?p=home&c=Index&a=index&param1=xxx&param2=xxx....
        //Define platform,controller,action,example:
        define("PLATFORM", isset($_REQUEST['p']) ? $_REQUEST['p'] : 'home');
        define("CONTROLLER", isset($_REQUEST['c']) ? $_REQUEST['c'] : 'Index');
        define("ACTION", isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index');

        //载入核心类
        //load core class
        require CORE_PATH . "Controller.class.php";
        require CORE_PATH . "Loader.class.php";
        require CORE_PATH . "Mysql.class.php";
        require CORE_PATH . "Model.class.php";
        require CORE_PATH . "View.class.php";
        require CORE_PATH . "Util.class.php";
        require CORE_PATH . "Log.class.php";


        $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];//todo 支持https
        $arr = parse_url($url);
        //echo $url;

        if (!isset($arr['query'])) {
            //默认访问home模块的Index控制器的index方法
            self::$s_arr_query = ['home', 'index', 'index'];
        } else {
            self::$s_arr_query = Util::convertUrlQuery($arr['query']);
        }


        define("CURR_CONTROLLER_PATH", CONTROLLER_PATH . PLATFORM . DS);
        define("CURR_VIEW_PATH", VIEW_PATH . PLATFORM . DS);


        //load configuration file

        $GLOBALS['config'] = include CONFIG_PATH . "config.php";

        //start session

        session_start();

    }


    /**
     * 自动加载
     * Auto loading
     */
    private static function autoload()
    {
        spl_autoload_register(array(__CLASS__, 'load'));
    }

    //define a custom load method
    private static function load($className)
    {
        if (substr($className, -10) == "Controller") {
            //it is controller
            $path = CURR_CONTROLLER_PATH . "$className.class.php";
            /*var_dump($path);
            die();*/
            include_once $path;

        } elseif (substr($className, -5) == "Model") {
            //it is model
            require MODEL_PATH . "$className.class.php";


        }
    }


    /**
     * 设置路由与调度器
     * @param $di :注入器
     * Routing and dispatching
     */
    private static function dispatch($di)
    {
        // Instantiate the controller class and cass its action method
        $controller_name = CONTROLLER . "Controller";
        $action_name = ACTION;
        $controller = new $controller_name;
        $controller->setDI($di);


        $num = count(self::$s_arr_query);
        //echo 'oldNum='.$num;
        //取出前3个参数后面的参数组
        self::$s_arr_query = array_slice(self::$s_arr_query, 3, $num - 3);
        //$controller->$action_name(self::$s_arr_query);//

        $num = count(self::$s_arr_query);
        //echo 'newNum='.$num;
        /*$str_temp = '';
        foreach (self::$s_arr_query as $key => $value) {
            $str_temp = $str_temp . '"'.self::$s_arr_query[$key] . '",';
        }

        Log::write($str_temp);
        $str_temp = rtrim($str_temp, ',');

        $fun = '$controller->$action_name(' . $str_temp . ');';
        Log::write($fun);
        //$fun='$controller->$action_name(self::$s_arr_query);';
        //echo $fun;
        eval($fun);*/

        //解析有几个参数就组几个参数
        //$param=self::getFucntionParameter('$controller->$action_name',self::$s_arr_query);
        //Log::write(json_encode(self::$s_arr_query));
        //call_user_func(array($controller_name,$action_name),['p1'=>"2222"],['p2'=>"11111"]);
        $reflect = new \ReflectionMethod($controller_name, $action_name);
        //处理一下参数
        $params=self::bindParams($reflect,self::$s_arr_query);

        $reflect->invokeArgs($controller, $params);

    }

    /**
     * 绑定参数
     * @param \ReflectionMethod| \ReflectionFunction $reflect
     * @param array $vars
     */
    private static function bindParams($reflect, $vars = [])
    {
        $args = [];
        //反射的方法存在参数
        if ($reflect->getNumberOfParameters() > 0) {
            //判断数组类型,数字数组时按顺序绑定参数
            $params = $reflect->getParameters();
            foreach ($params as $param) {
                $args[] = self::getParamValue($param, $vars);
            }
        }

        return $args;
    }


    /**
     * 设置错误与异常处理
     */
    private static function error()
    {
        error_reporting(E_ALL);
        set_error_handler([__CLASS__, 'appError']);
        set_exception_handler([__CLASS__, 'appException']);
        register_shutdown_function([__CLASS__, 'appShutdown']);
    }

    public static function appError()
    {
        echo '-------error--------';
        $errorArr = error_get_last();
        echo $errorArr['type'] . "<br>";
        echo $errorArr['message'] . "<br>";
    }

    /**
     * 设置异常处理
     * @param Throwable $exception
     */
    public static function appException($exception)
    {
        echo '<br>';
        echo "----------exception--------<br>";
        //todo 判断是不是人为抛出的异常,如果是则正常抛,否则都归为系统异常,不向用户暴露错误原因,开启debug模式可以出异常


        echo "code=" . $exception->getCode() . "<br>";
        echo "message=" . $exception->getMessage() . "<br>";
        echo "file=" . $exception->getFile() . "<br>";
        echo "line=" . $exception->getLine(), "<br>";
        echo "trace=" . $exception->getTraceAsString() . "<br>";
    }

    /**
     * php脚本无论正常执行完毕或者异常结束都会调用
     */
    public static function appShutdown()
    {
        //echo '****shutdown****';
    }

    /**
     * 获取参数值,并判断是否必要参数没填
     * @param \ReflectionParameter $param
     * @param $vars
     * @return array
     */
    private static function getParamValue($param, $vars)
    {   //参数名字
        $name = $param->getName();
        //参数的类
        $class = $param->getClass();

        if ($class) {
            //todo:参数是个类的情况
            return null;
        } else {
            if (isset($vars[$name])) {
                $result = $vars[$name];
            } elseif ($param->isDefaultValueAvailable()) {
                $result = $param->getDefaultValue();
            } else {
                throw new \InvalidArgumentException("method param is missing:" . $name);
            }
        }

        return $result;


    }

}





