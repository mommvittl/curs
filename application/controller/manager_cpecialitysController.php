<?php

class manager_cpecialitysController extends basisController{
  
     public function indexAction($idElementData = 0) {
        $idElement = (int) $idElementData;
        $this->arrParameterForPage['pathAccess'] = 'cpecyalitys/index';
        $this->arrParameterForPage['idElementData'] = $idElement;
        $this->page = new indexPage("cpecyalitys/manager_cpecyalitysIndex.tmpl");
        $this->page->displayPage($this->arrParameterForPage);
    }

    public function createAction() {
        $this->arrParameterForPage['pathAccess'] = 'cpecyalitys/create';
        $this->page = new indexPage("cpecyalitys/manager_cpecyalitysCreate.tmpl");
        $this->page->displayPage($this->arrParameterForPage);
    }
    
}
