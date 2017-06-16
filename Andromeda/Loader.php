<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2017/6/16
 * Time: 9:28
 */

/**
 * 载入器
 * Class Loader
 */
class Loader{

    /**
     * 自动加载
     * Auto loading
     */
    private static function autoload(){
        spl_autoload_register(array(__CLASS__,'load'));
    }

    //define a custom load method
    private static function load($className){
        if(substr($className,-10)=="Controller"){
            //it is controller
            require_once CURR_CONTROLLER_PATH."$className.class.php";

        }elseif(substr($className,-5)=="Model"){
            //it is model
            require_once MODEL_PATH."$className.class.php";


        }
    }

}