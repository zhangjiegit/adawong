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
		//��֤���������Ȩ��
		if ($refObject->isAbstract()) {
			throw new Ada_Exception('The requested URL was not found on this server');
		}
		//���������Ƿ�̳�Controller
		if (!$refObject->isSubclassOf('Controller')) {
			throw new Ada_Exception('The requested URL was not found on this server');
		}
		//�������
		if (isset($matchs['params'])) {
			$request->params = $matchs['params'];
		}
		unset($refObject);
		//��֤action�Ƿ����
		$controller = new $this->class($request);
		if (method_exists($controller, $this->action)) {
			$refMethod = new ReflectionMethod($controller, $this->action);
			if ($refMethod->isPublic()) {
				$request->response->body($this->invoke($controller, array('before', $this->action, 'after')));
				unset($controller, $refMethod);
				return TRUE;
			}
		}
		throw new Ada_Exception('The requested URL was not found on this server');
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

	/**
	* ���ÿ�������ָ������	
	* @param Controller $controller ������
	* @param Array $methods ���Ʒ��� array('before', 'action', 'after')
	* @return String
	*/
	private function invoke(Controller $controller, $methods=array()) {
		ob_start();
		foreach ($methods as $method) {
			if (method_exists($controller, $method)) {
				$refMethod = new ReflectionMethod($controller, $method);
				if ($refMethod->isPublic()) {
					$refMethod->invoke($controller);
				}
				unset($refMethod);
			}
		}
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	public function __destruct() {
		unset($this->class, $this->action);
	}
}