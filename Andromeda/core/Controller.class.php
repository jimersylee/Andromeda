<?php
// base Controller
class Controller{
	//base Controller has a property called $loader, it is an instance of Loader class 
	protected $loader;
	protected $view;
	protected $di;
	public function __construct($di){
		$this->loader=new Loader();
		$this->view=new View();
		$this->di=$di;
		
		
	}
	public function redirect($url,$message,$wait=0){
		if($wait=0){
			header("Location:$url");
			
		}else{
			include CURR_VIEW_PATH."message.html";
			
		}
		exit;
		
	}
	
	protected function assign($name,$value='') {
        $this->view->assign($name,$value);
        return $this;
    }
	
	protected function display($template){
		$this->view->display(CURR_VIEW_PATH.$template);
		
	}
}
