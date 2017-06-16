<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2017/6/16
 * Time: 14:07
 */

namespace Framework\Di;


interface InjectionAwareInterface
{
    public function setDI($di);
    public function getDI();

}