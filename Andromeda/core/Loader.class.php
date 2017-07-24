<?php
class Loader{
	//load library classes
	public function library($lib){
		include LIB_PATH."$lib.class.php";
		
	}
	//loader helper functions.Naming conversion is xxx_helper.php;
	public function helper($helper){
		include HELPER_PATH."{$helper}_helper.php";
		
	}


	public function registerDir($DirArray){

    }


    /**
     * ????
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