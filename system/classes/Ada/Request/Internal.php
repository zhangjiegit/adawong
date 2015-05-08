<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* �ڲ����������ʵ����
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class	Ada_Request_Internal	extends	Ada_Request {
	
	private $class;

	private $action;
	
	/**
	* ���췽��
	*/
	public	function	__construct(Request &$request, $matchs) {
		$this->path($matchs);
		if (!class_exists($this->class)) {
			throw new Ada_Exception('The requested URL was not found on this server');
		}
		$refObject = new ReflectionClass($this->class);
		//��֤�������Ƿ���Ȩ��
		if ($refObject->isAbstract()) {
			throw new Ada_Exception('The requested URL was not found on this server');
		}
		//���������Ƿ�̳�Controller
		if (!$refObject->isSubclassOf('Controller')) {
			throw new Ada_Exception('The requested URL was not found on this server');
		}
		$request->params = $matchs['params'];
		unset($refObject);
		//��֤action�Ƿ����
		$controller = new $this->class($request);
		if (!method_exists($controller, $this->action)) {
			throw new Ada_Exception('The requested URL was not found on this server');
		}
		$refMethod = new ReflectionMethod($this->class, $this->action);
		//��֤action����Ȩ��
		if($refMethod->ispublic()) {
			ob_start();
			$refMethod->invoke($controller);
			$request->response->body(ob_get_contents());
			ob_end_clean();
			unset($refMethod, $controller);
		} else {
			throw	new	Ada_Exception('The requested URL was not found on this server');
		}
	}
	/**
	* ƥ���������action
	* @param Array $matchs
	* @return String
	*/
	private function path($matchs) {
		$path = 'Controller'.DIRECTORY_SEPARATOR;
		if (isset($matchs['directory'])) {
			$path = $path.$matchs['directory'].DIRECTORY_SEPARATOR;
		}
		$path = $path.$matchs['controller'];
		$this->action = 'action_'.$matchs['action'];
		$this->class = str_replace(DIRECTORY_SEPARATOR, '_', $path);
	}

	public function __destruct() {
		unset($this->class, $this->action);
	}
}