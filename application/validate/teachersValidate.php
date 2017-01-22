<?php
class teachersValidate{
	public function __construct(){
		
	}
	
	public static function validate(&$elementData){
		if( is_object($elementData) ){
			
			$elementData->name = filter_var( (string)$elementData->name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
			if( ($elementData->name === false) || (strlen($elementData->name) < 3 )){ return false; }
			
			$elementData->surname = filter_var( (string)$elementData->surname, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
			if( ($elementData->surname === false) || (strlen($elementData->surname) < 3 )){ return false; }
//			var_dump($elementData->birthday);
			list($year,$month,$day) = explode("-",$elementData->birthday);
			
			if( !checkdate($month,$day,$year) ||  ((date('Y') - $year) < 15) || ((date('Y') - $year) > 90) ){ 
				$elementData->birthday = false;
				return false; 
			}
			
			if( !preg_match("/^(\([0-9 ]{3,7}\))?[0-9 -]+$/",$elementData->telephon) ){ 
				$elementData->telephon = false;
				return false; 
			}
			
			$elementData->adress = filter_var( (string)$elementData->adress, FILTER_SANITIZE_STRING);
			if( ($elementData->adress === false) || (strlen($elementData->adress) < 3 )){ 
				$elementData->adress = false;
				return false; 
			}
			
			$elementData->email = filter_var( (string)$elementData->email, FILTER_VALIDATE_EMAIL);
			if( ($elementData->email === false) || (strlen($elementData->email) < 3 )){ 
				$elementData->email = false;
				return false; 
			}
			
			$elementData->skype = filter_var( (string)$elementData->skype, FILTER_SANITIZE_URL);
			if( ($elementData->skype === false) || (strlen($elementData->skype) < 3 )){ 
				$elementData->skype = false;
				return false; 
			}
			
			$elementData->status = (in_array($elementData->status,array('teacher')) ) ? (string)$elementData->status : false;
			if($elementData->skype === false){ return false;  }
			
			$elementData->work = (in_array($elementData->work,array(0,1)) ) ? (int)$elementData->work : false;
			if($elementData->work === false){ return false;  }
			
			return true;
		}
		return false;
	}

}