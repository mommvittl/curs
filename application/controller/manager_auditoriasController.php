<?php
    
class manager_auditoriasController extends BasisController
{
    public function indexAction($idAuditoriasData = 0) { 
         $idAuditorias = (int)$idAuditoriasData; 
         $this->arrParameterForPage['pathAccess'] = 'auditorias/index';	
         $this->arrParameterForPage['idAuditoriasData'] = $idAuditorias;	
         $tmp = new indexPage("auditorias/manager_auditoriasIndex.tmpl");
         $tmp->displayPage($this->arrParameterForPage);
    }
    
    public function createAction() {
         $this->arrParameterForPage['pathAccess'] = 'auditorias/create';		
         $tmp = new indexPage("auditorias/manager_auditoriasCreate.tmpl");
         $tmp->displayPage($this->arrParameterForPage);
    }
    
}