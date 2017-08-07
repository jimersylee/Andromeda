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
    public function index()
    {
        $this->writer->hello();
        $this->writer->hello();
        $this->writer->hello();
        $this->logger->err("a");
        /*$this->logger->err("b");
        $this->logger->err("c");*/
        //\Andromeda\Logger\Logger::ERR("www");

    }

    public function getUsers()
    {
        Log::ERR("访问getUser");
        $userModel = new UserModel("user");
        $result = $userModel->getUsers();
        $this->assign('page', 'home/getuser');
        $this->assign('result', $result);
        $this->display('getUser');

    }


}