<?php
class	Controller_Welcome extends Controller {
	
		public 	function	action_index() {
			//��ȡ����
			var_dump($this->request->params());
		}
}