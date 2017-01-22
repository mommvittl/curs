<?php

class manager_indexController extends BasisController {

    public function indexAction() {
        $userList = new accessRepository;
        $this->arrParameterForPage['pathAccess'] = 'index/index';
        $tmp = new indexPage("index/manager_index.tmpl");
        $tmp->displayPage($this->arrParameterForPage);
    }

}
