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

use Andromeda\Mvc\Controller;

class IndexController extends BaseController
{
    public function index()
    {
        $this->writer->hello();
        $this->writer->hello();
        $this->writer->hello();
        Log::write("hehehehe");
        $this->singletonWriter->hello();
        $this->singletonWriter->hello();
        $this->singletonWriter->hello();
        $this->singletonWriter::staticHello();


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

    public function paramTest($p1,$p2=22,$p3){
        Log::write("eeeee");
        var_dump($p1);
        var_dump($p2);
        var_dump($p3);

    }

    public function testTpl(){
        $tpl=new Template();
        $tpl->assign('data', 'hello world');
        $tpl->assign('person', 'htGod');
        $tpl->assign('data1', 3);
        $arr = array(1,2,3,4,'5',6);
        $tpl->assign('b', $arr);
        $tpl->display('member');
    }


}