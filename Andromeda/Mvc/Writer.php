<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2017/5/27
 * Time: 15:03
 */

namespace Framework\Mvc;


use Framework\App;


class Writer extends App
{
    /**
     * 在浏览器输出一些内容
     * @param $content
     */
    public function write($content){
        echo "write $content";
    }

    public function hello(){
        echo "hello guys";
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