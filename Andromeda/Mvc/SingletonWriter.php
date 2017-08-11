<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2017/5/27
 * Time: 15:03
 */

namespace Framework\Mvc;


use Framework\App;


class SingletonWriter extends App
{
    private static $singletonWriter;

    public function __construct($di)
    {
        parent::__construct($di);
        echo "new SingletonWriter<br>";
    }

    public static function getInstance($di)
    {
        if (!self::$singletonWriter) {
            self::$singletonWriter = new self($di);
        }
        return self::$singletonWriter;
    }

    /**
     * 在浏览器输出一些内容
     * @param $content
     */
    public function write($content)
    {
        echo "SingletonWriter write $content";
    }

    public function hello()
    {
        echo "SingletonWriter hello guys<br>";
    }

    public static function staticHello()
    {
        echo "SingletonWriter static hello guys<br>";
    }

    public function setDI($di)
    {
        // TODO: Implement setDI() method.
    }

    public function getDI()
    {
        // TODO: Implement getDI() method.
    }
}