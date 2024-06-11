<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2017/5/27
 * Time: 15:11
 */

namespace Andromeda\Di;




abstract class Injectable implements InjectionAwareInterface
{

    protected $_dependencyInjector;

    protected $_eventsManager;





    public function setDI( $dependenceInjector)
    {
        $this->_dependencyInjector=$dependenceInjector;
    }

    public function getDI()
    {
        return $this->_dependencyInjector;
    }


    public function setEventsManager($eventsManager){
        $this->_eventsManager=$eventsManager;
    }

    public function getEventsManager(){
        return $this->_eventsManager;
    }







}