<?php
class	Controller_Welcome extends Controller {
	
		public 	function	action_index() {
			//获取参数
			var_dump($this->request->params());
		}
}