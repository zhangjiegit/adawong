<?php
class Controller_Welcome extends Controller {
	
	public function	action_index() {
		//获取参数
		var_dump($this->request->params());
	}

	public function action_say() {
		echo __FUNCTION__,":我正在执行\t";
	}

	public function before() {
		echo __FUNCTION__,":我优先执行\t";
	}

	public function after() {
		echo __FUNCTION__,':我最后执行';
	}
}