<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2017/5/27
 * Time: 15:03
 */

namespace Andromeda\Mvc;


use Andromeda\App;


class Writer extends App
{

    public function __construct($di)
    {
        parent::__construct($di);
        echo "new Writer<br>";
    }

    /**
     * 在浏览器输出一些内容
     * @param $content
     */
    public function write($content){
        echo "write $content<br>";
    }

    public function hello(){
        echo "hello guys<br>";
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