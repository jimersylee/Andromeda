<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2017/5/27
 * Time: 15:03
 */

namespace Framework\Mvc;


use Framework\App;
use Framework\DiInterface;

class Writer extends App
{
    public function write(){
        echo "write sth";
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