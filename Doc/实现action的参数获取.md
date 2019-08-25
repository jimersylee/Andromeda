###实现从url或者post参数中取出调用action的参数

示例代码,取自ThinkPHP3.2.3

```
public static function invokeAction($module,$action){
	if(!preg_match('/^[A-Za-z](\w)*$/',$action)){
		// 非法操作
		throw new \ReflectionException();
	}
	//执行当前操作
	$method =   new \ReflectionMethod($module, $action);
	if($method->isPublic() && !$method->isStatic()) {
		$class  =   new \ReflectionClass($module);
		// 前置操作
		if($class->hasMethod('_before_'.$action)) {
			$before =   $class->getMethod('_before_'.$action);
			if($before->isPublic()) {
				$before->invoke($module);
			}
		}
		// URL参数绑定检测
		if($method->getNumberOfParameters()>0 && C('URL_PARAMS_BIND')){
			switch($_SERVER['REQUEST_METHOD']) {
				case 'POST':
					$vars    =  array_merge($_GET,$_POST);
					break;
				case 'PUT':
					parse_str(file_get_contents('php://input'), $vars);
					break;
				default:
					$vars  =  $_GET;
			}
			$params =  $method->getParameters();
			$paramsBindType     =   C('URL_PARAMS_BIND_TYPE');
			foreach ($params as $param){
				$name = $param->getName();
				if( 1 == $paramsBindType && !empty($vars) ){
					$args[] =   array_shift($vars);
				}elseif( 0 == $paramsBindType && isset($vars[$name])){
					$args[] =   $vars[$name];
				}elseif($param->isDefaultValueAvailable()){
					$args[] =   $param->getDefaultValue();
				}else{
					E(L('_PARAM_ERROR_').':'.$name);
				}   
			}
			// 开启绑定参数过滤机制
			if(C('URL_PARAMS_SAFE')){
				$filters     =   C('URL_PARAMS_FILTER')?:C('DEFAULT_FILTER');
				if($filters) {
					$filters    =   explode(',',$filters);
					foreach($filters as $filter){
						$args   =   array_map_recursive($filter,$args); // 参数过滤
					}
				}                        
			}
			array_walk_recursive($args,'think_filter');
			$method->invokeArgs($module,$args);
		}else{
			$method->invoke($module);
		}
		// 后置操作
		if($class->hasMethod('_after_'.$action)) {
			$after =   $class->getMethod('_after_'.$action);
			if($after->isPublic()) {
				$after->invoke($module);
			}
		}
	}else{
		// 操作方法不是Public 抛出异常
		throw new \ReflectionException();
	}
    }

```