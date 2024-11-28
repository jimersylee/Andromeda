<?php

/**
 * Template
 */
class Template
{

    private $arrayConfig = array(
        'suffix' => '.tpl',        //模板的后缀
        'templateDir' => "template/", //模板所在的文件夹
        'compileDir' => "cache/",    //编译后存放的目录
        'cache_html' => false,        //是否需要编译成静态的html文件
        'suffix_cache' => '.html',    //设置编译文件的后缀
        'cache_time' => 7200,        //设置多长时间自动更新
        'php_turn' => true,        //设置是否支持php原生代码
        'debug' => false,
    );

    public $file;                        //模板文件名,不带路径
    public $debug = array();            //调试信息
    private $value = array();            //值栈
    private $compileTool;                //编译器
    private $controlData = array();
    static private $instance = null;    //模板类对象

    public function __construct($arrayConfig = array())
    {
        $this->debug['begin'] = microtime(true);
        $this->arrayConfig = array_merge($this->arrayConfig, $arrayConfig);
        //$this->getPath();


        if (!is_dir($this->arrayConfig['templateDir'])) {
            exit("template dir isn't found!");
        }

        if (!is_dir($this->arrayConfig['compileDir'])) {
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                mkdir($this->arrayConfig['compileDir']);
            } else {
                mkdir($this->arrayConfig['compileDir'], 0770, true);
            }
        }

    }

    public function getPath()
    {
        $this->arrayConfig['templateDir'] = strstr(realpath($this->arrayConfig['templateDir']), '\\', '/') . '/';
        $this->arrayConfig['compileDir'] = strstr(realpath($this->arrayConfig['compileDir']), '\\', '/') . '/';
    }

    /**
     * 取得模板引擎的实例
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Template();
        }
        return self::$instance;
    }

    /**
     * 单独设置引擎参数
     * 也支持一次性设置多个参数
     */
    public function setConfig($key, $value = null)
    {
        if (is_array($key)) {
            $this->arrayConfig = $key + $this->arrayConfig;
        } else {
            $this->arrayConfig[$key] = $value;
        }
    }

    /**
     * 获取当前模板引擎配置，仅供调试使用
     */
    public function getConfig($key = null)
    {
        if ($key && array_key_exists($key, $this->arrayConfig)) {
            return $this->arrayConfig[$key];
        } else {
            return $this->arrayConfig;
        }
    }


    /**
     * 注入单个变量
     */
    public function assign($key, $value)
    {
        $this->value[$key] = $value;
    }

    /**
     * 注入数组变量
     */
    public function assignArray($array)
    {
        if (is_array($array)) {
            foreach ($array as $k => $v) {
                $this->value[$k] = $v;
            }
        }
    }

    /**
     * 获取模板的位置
     * @return [type] [description]
     */
    public function path()
    {
        return $this->arrayConfig['templateDir'] . $this->file . $this->arrayConfig['suffix'];
    }

    /**
     * 判断配置文件是否要求缓存
     */
    public function needCache()
    {
        return $this->arrayConfig['cache_html'];
    }

    /**
     * 判断是否需要缓存
     */
    public function reCache($file)
    {
        $flag = false;
        $cacheFile = $this->arrayConfig['compileDir'] . md5($file) . $this->arrayConfig['suffix_cache'];
        if ($this->arrayConfig['cache_html'] === true) {
            //需要缓存
            $timeFlag = (time() - @filemtime($cacheFile)) < $this->arrayConfig['cache_time'] ? true : false;
            if (is_file($cacheFile) && filesize($cacheFile) > 1 && $timeFlag) {
                //缓存存在且未过期
                $flag = true;
            } else {
                $flag = false;
            }
        }
        return $flag;
    }

    /**
     * 展示模板
     */
    public function display($file)
    {
        $this->file = $file;
        echo $this->path()."\n";
        if (!is_file($this->path())) {
            exit('找不到对应的模板');
        }
        $compileFile = $this->arrayConfig['compileDir'] . md5($file) . '.php';
        $cacheFile = $this->arrayConfig['compileDir'] . md5($file) . $this->arrayConfig['suffix_cache'];

        if ($this->reCache($file) === false) {
            //如果需要缓存
            $this->debug['cached'] = 'false';
            $this->compileTool = new Compile($this->path(), $compileFile, $this->arrayConfig);
            if ($this->needCache()) {
                ob_start();
            }
            extract($this->value, EXTR_OVERWRITE);
            if (!is_file($compileFile) || fileatime($compileFile) < filemtime($this->path())) {
                $this->compileTool->value = $this->value;
                $this->compileTool->compile();
                include $compileFile;
            } else {
                include $compileFile;
            }

            if ($this->needCache()) {
                $message = ob_get_contents();
                file_put_contents($cacheFile, $message);
            }
        } else {
            readfile($cacheFile);
            $this->debug['cached'] = 'true';
        }
        $this->debug['spend'] = microtime(true) - $this->debug['begin'];
        $this->debug['count'] = count($this->value);
        $this->debug_info();
    }

    public function debug_info()
    {
        if ($this->arrayConfig['debug'] === true) {
            echo "<br/>", '-------------------- debug_info--------------', "<br/>";
            echo '程序运行日期:', date("Y-m-d h:i:s"), "<br/>";
            echo '模板解析耗时:', $this->debug['spend'], '秒', "<br/>";
            echo '模板包含标签数目:', $this->debug['count'], "<br/>";
            echo '是否使用静态缓存:', $this->debug['cached'], "<br/>";
            echo '模板引擎实例参数:', var_dump($this->getConfig());
        }
    }

    /**
     * 清楚缓存的html文件
     * @return [type] [description]
     */
    public function clean()
    {
        if ($path === null) {
            $path = $this->arrayConfig['compileDir'];
            $path = glob($path . '* ' . $this->arrayConfig['suffix_cache']);
        } else {
            $path = $this->arrayConfig['compileDir'] . md5($path) . $this->arrayConfig['suffix_cache'];
        }
        foreach ((array)$path as $v) {
            unlink($v);
        }
    }
}