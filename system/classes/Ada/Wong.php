<?php
abstract	class	Ada_Wong {
	
	public	static	function	__staticCall($method=NULL, $args=NULL) {

		throw	new	Ada_Exception('Call to undefined method'.$method);
	
	}
}