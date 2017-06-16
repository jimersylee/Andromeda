<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2017/5/27
 * Time: 15:24
 */

namespace Framework\Mvc;


use Framework\Di\Injectable;

abstract class Controller extends Injectable
{
    protected $loader;
    protected $view;
    protected $di;

    public function __get($name)
    {

        $instance=null;
        if (isset($this->_dependencyInjector->_sharedInstances[$name])) {
            $definition = $this->_dependencyInjector->_sharedInstances[$name];
        } else {
            throw new \Exception("Service '" . $name . "' wasn't found in the dependency injection container");
        }

        if (is_object($definition)) {
            $instance = call_user_func($definition);
        }
        return $instance;

    }


    public function __construct($di=null)
    {
        $this->loader=new \Loader();
        $this->view=new \View();
        $this->_dependencyInjector=$di;
    }




    public function redirect($url,$message,$wait=0){
        if($wait=0){
            header("Location:$url");

        }else{
            include CURR_VIEW_PATH."message.html";

        }
        exit;

    }

    protected function assign($name,$value='') {
        $this->view->assign($name,$value);
        return $this;
    }

    protected function display($template){
        $this->view->display(CURR_VIEW_PATH.$template);

    }

    /**
     * 浏览器友好的变量输出
     * @param mixed $var 变量
     * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
     * @param string $label 标签 默认为空
     * @param boolean $strict 是否严谨 默认为true
     * @return void|string
     */
    protected function dump($var, $echo=true, $label=null, $strict=true) {
        $label = ($label === null) ? '' : rtrim($label) . ' ';
        if (!$strict) {
            if (ini_get('html_errors')) {
                $output = print_r($var, true);
                $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
            } else {
                $output = $label . print_r($var, true);
            }
        } else {
            ob_start();
            var_dump($var);
            $output = ob_get_clean();
            if (!extension_loaded('xdebug')) {
                $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
                $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
            }
        }
        if ($echo) {
            echo($output);
            return null;
        }else
            return $output;
    }


}

