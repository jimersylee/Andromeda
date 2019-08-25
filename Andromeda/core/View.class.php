<?php

/**
 * mvc的v类
 * Class View
 */
class View
{

    private $data = array();

    private $render = false;


    public function __construct()
    {
    }

    public function __destruct()
    {

    }

    /**
     * 直接设置view页面
     * set view page directly
     * @param $template
     */
    public function setView($template)
    {

        $filePath = VIEW_PATH . $template . '.html'; //todo 增加配置支持其他后缀的模板
        if (file_exists($filePath)) {

            $this->render = $filePath;

        }
    }

    /**
     * 渲染变量
     * assign variable
     * @param $variable
     * @param string $value
     */
    public function assign($variable, $value = '')
    {
        if (is_array($variable)) {

            $this->data = array_merge($this->data, $variable);
        } else {

            $this->data[$variable] = $value;
        }


    }

    /**
     * 显示模板
     * display tempalte
     * @param $template
     */
    public function display($template)
    {
        $data = $this->data;

        $filePath = $template . '.html'; //todo 加配置支持其他后缀的模板
        if (file_exists($filePath)) {

            $this->render = $filePath;

        }

        if (isset($this)) {
            include($this->render);
        }

    }


}