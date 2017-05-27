<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2017/5/27
 * Time: 15:11
 */

namespace Framework\Di;


use Framework\DiInterface;


/**
 * Class Injectable
 * @property \Framework\Mvc\Writer $writer
 */
abstract class Injectable
{

    protected $_dependencyInjector;



    public function setDI(DiInterface $dependenceInjector)
    {
        $this->_dependencyInjector=$dependenceInjector;
    }

    public function getDI()
    {
        return $this->_dependencyInjector;
    }





}