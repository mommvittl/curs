<?php
class errorException{
	
	public static function 	getErrorMessage($strErr,$numErr){
		echo "<html><head><meta charset=\"utf-8\"><title>Error</title><style>.errorDiv { width: 100%; max-width: 600px; text-align: center;
		margin: 0 auto; background: #E0B639; color: #800000; height: 100%; max-height: 600px; border: 6px double #800000; font: 2rem/2.5rem arial;  }
		</style></head><body><div class=\"errorDiv\"><h1>Sorry...Error...</h1><H2>".$strErr."</H2></div></body></html>";		
	}
}