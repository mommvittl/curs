<?php

class manager_studentsController extends BasisController {

    public function indexAction($idElementData = 0) {
        $idElement = (int) $idElementData;
        $this->arrParameterForPage['pathAccess'] = 'students/index';
        $this->arrParameterForPage['idElementData'] = $idElement;
        $this->page = new indexPage("students/manager_studentsIndex.tmpl");
        $this->page->displayPage($this->arrParameterForPage);
    }

    public function createAction() {
        $this->arrParameterForPage['pathAccess'] = 'students/create';
        $this->page = new indexPage("students/manager_studentsCreate.tmpl");
        $this->page->displayPage($this->arrParameterForPage);
    }

}
