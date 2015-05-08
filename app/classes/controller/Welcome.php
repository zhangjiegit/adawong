<?php
class	Controller_Welcome extends Controller {
	
		public 	function	action_index() {

			var_dump($this->request->params());
		}
}