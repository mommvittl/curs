<?php
abstract class basisController	
{
	protected $pathAccess;
	protected $page;
	protected $userRegistrationId;
	protected $arrParameterForPage = [];
	
    public function __construct(){
		$this->userRegistrationId = ( isset($_SESSION['id']) ) ? trim($_SESSION['id']) : null ;
		$this->arrParameterForPage['sessionUserName'] =  ( isset($_SESSION['username']) ) ? trim($_SESSION['username']) : 'incognito' ;
    }
}