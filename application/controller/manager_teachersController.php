<?php
class manager_teachersController extends BasisController
{
    public function indexAction($idTeacherData = 0 ) { 
		$idTecher = (int)$idTeacherData; 
//		$userList = new accessRepository;
		$this->arrParameterForPage['pathAccess'] = 'teachers/index';	
		$this->arrParameterForPage['idTeacherData'] = $idTecher;	
		$this->page = new indexPage("teachers/manager_teachersIndex.tmpl");
		$this->page->displayPage($this->arrParameterForPage);
    }
	
	public function createAction(){
		$this->arrParameterForPage['pathAccess'] = 'teachers/create'; 
		$this->page = new indexPage("teachers/manager_teachersCreate.tmpl");		
		$this->page->displayPage($this->arrParameterForPage);	
	}

	
}