<?php

class manager_auditoriasAjaxController extends basisAjaxController {

    protected $validator;
    protected $arrAuditorias;
    protected $auditorias;
    protected $auditoriasRepository;

    public function __construct() {
        parent::__construct();
        $this->auditoriasRepository = new auditoriasRepository;
    }

    public function elementsListAction() {
        $this->strResponse = "";
        $page = ( isset($_POST['page']) ) ? (int) $_POST['page'] : 1;
        $arrParam = ( isset($_POST['arrParam']) ) ? json_decode($_POST['arrParam'], true) : null;
        if ($arrParam && is_array($arrParam)) {
            $this->arrAuditorias = $this->auditoriasRepository->findElementByArrParameter($arrParam);
        } else {
            $this->arrAuditorias = $this->auditoriasRepository->getAllElement($arrParam);
        }
        if ($this->arrAuditorias && is_array($this->arrAuditorias)) {
            foreach ($this->arrAuditorias as $value) {
                $arr = $value->getArrForXMLDocument();
                $this->strResponse .= "<nextElement>" . json_encode($arr) . "</nextElement>";
            }
        }
        $this->returnXmlResponse($this->strResponse);
    }

    public function elementsDeleteAction() {
        $this->strResponse = "";
        $idElement = (isset($_POST['idElement']) ) ? (int) $_POST['idElement'] : 0;
        $this->auditorias = $this->auditoriasRepository->getElementById($idElement);
        if (is_object($this->auditorias)) {
            $this->auditorias->work = 0;
//			var_dump($this->auditorias);
            $this->auditoriasRepository->updateElement($this->auditorias);
        }
        $this->returnXmlResponse($this->strResponse);
    }

    public function elementsUpdateAction() {
        $this->strResponse = "";
        $paramAddUpd = ( isset($_POST['paramAddUpd']) ) ? $_POST['paramAddUpd'] : 'add';
        $idElement = ( isset($_POST['idElement']) ) ? (int) $_POST['idElement'] : 0;
        $arrInputValue = ( isset($_POST['arrInputValue']) ) ? json_decode($_POST['arrInputValue'], true) : false;
        if (!is_array($arrInputValue)) {
            $this->returnXmlResponse("<flagResult>1</flagResult><resultAddElement>Error...ошибка передачи данных</resultAddElement>");
        }
        $arrInputValue['work'] = '1';
        $this->auditorias = auditoriasModel::fromState($arrInputValue);
        if (!is_object($this->auditorias) || !auditoriasValidate::validate($this->auditorias)) {
            $this->returnXmlResponse("<flagResult>2</flagResult><resultAddElement>Некорректные входные данные</resultAddElement>");
        }
        if ($paramAddUpd == 'update') {
            $auditor = $this->auditoriasRepository->getElementById($idElement);
            if (!is_object($auditor)) {
                $this->returnXmlResponse("<flagResult>2</flagResult><resultAddElement>Некорректные входные данные</resultAddElement>");
            }
            $this->auditorias->id = $idElement;
            $this->auditoriasRepository->updateElement($this->auditorias);
            $this->strResponse .= "<flagResult idElement='" . $idTeach . "'>0</flagResult><resultAddElement>Ок.Данные обновлены</resultAddElement>";
        } else {
            $auditor = $this->auditoriasRepository->findElementByArrParameter(array('title' => $this->auditorias->title, 'adress' => $this->auditorias->adress));
            if (is_object($auditor[0])) {
                $this->returnXmlResponse("<flagResult>1</flagResult><resultAddElement>Такая аудитория уже есть в базе</resultAddElement>");
            }
            $this->auditoriasRepository->createElement($this->auditorias);
            $this->strResponse .= "<flagResult>0</flagResult><resultAddElement>Ок.Новя аудитория добавлен в базу</resultAddElement>";
        }
        $this->returnXmlResponse($this->strResponse);
    }

}
