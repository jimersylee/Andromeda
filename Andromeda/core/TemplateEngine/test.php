<?php 
include 'Template.class.php';
$tpl = new Template(['debug'=>true]);
$tpl->assign('data', 'hello world');
$tpl->assign('person', 'htGod');
$tpl->assign('data1', 3);
$arr = array(1,2,3,4,'5',6);
$tpl->assign('b', $arr);
$tpl->display('member');
