<?php
class auditoriasValidate{
	public function __construct(){
		
	}
	
	public static function validate(&$elementData){
		if( is_object($elementData) ){
			
			
			return true;
		}
		return false;
	}
	
}