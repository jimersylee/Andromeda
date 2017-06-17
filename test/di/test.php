<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jimersy Lee
 * Date: 2017/6/17
 * Time: 10:47
 */

/*
 *
 * 简单的Di容器实现
 *
 *
 * */



header("Content-Type:text/html;charset=utf8");
class A{
    public $name;
    public $age;
    public function __construct($name=""){
        $this->name = $name;
    }
}

include "Di.php";
$di = new Di();
//匿名函数方式注册一个名为a1的服务
$di->setShared('a1',function($name=""){
    return new A($name);
});
//直接以类名方式注册
$di->set('a2','A');
//直接传入实例化的对象
$di->set('a3',new A("小唐"));

$a1 = $di->get('a1',array("小李"));
echo $a1->name."<br/>";//小李
$a1_1 = $di->get('a1',array("小王"));
echo $a1->name."<br/>";//小李
echo $a1_1->name."<br/>";//小李

$a2 = $di->get('a2',array("小张"));
echo $a2->name."<br/>";//小张
$a2_1 = $di->get('a2',array("小徐"));
echo $a2->name."<br/>";//小张
echo $a2_1->name."<br/>";//小徐

$a3 = $di['a3'];//可以直接通过数组方式获取服务对象
echo $a3->name."<br/>";//小唐