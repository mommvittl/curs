<?php
class teacher_indexController extends BasisController
{
    public function indexAction() { 
		$this->arrParameterForPage['pathAccess'] = 'index/index';
		$tmp = new indexPage("index/teacher_index.tmpl");
		$tmp->displayPage($this->arrParameterForPage);

    }
}