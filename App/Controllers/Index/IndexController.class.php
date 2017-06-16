<?php

/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2017/5/27
 * Time: 15:30
 */


/**
 * Class IndexController
 *
 */
use Framework\Mvc\Controller;
class IndexController extends Controller
{
    public function index(){
        $this->writer->hello();
    }

}