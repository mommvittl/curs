<?php

class manager_teacherAjaxController extends basisAjaxController {

    protected $accessRepository;
    protected $teacherRepository;
    protected $user;
    protected $userArray;
    protected $teacher;
    protected $teacherArray;
    protected $pagerModel;
    protected $validator;

    public function __construct() {
        parent::__construct();
        $this->teacherRepository = new teacherRepository;
    }

    public function getNotLoggetTeacherAction() {
        $this->strResponse = "";
        $this->teacherArray = $this->teacherRepository->getArrNoLoginElement();
        if (is_array($this->teacherArray)) {
            $arr = [];
            foreach ($this->teacherArray as $value) {
                $arr = $value->getArrForXMLDocument();
                $this->strResponse .= "<nextElement>" . json_encode($arr) . "</nextElement>";
            }
        }
        $this->returnXmlResponse($this->strResponse);
    }

    public function teachersListAction() {
        $this->strResponse = "";
        $page = ( isset($_POST['page']) ) ? (int) $_POST['page'] : 1;
        $arrParam = ( isset($_POST['arrParam']) ) ? json_decode($_POST['arrParam'], true) : null;
        if ($arrParam && is_array($arrParam)) {
            $colPage = $this->teacherRepository->countForFindByArrParameter($arrParam);
            $this->pagerModel = new pagerModel($colPage, COLSTRINGINLIST);
            $arrPageData = $this->pagerModel->getArrPage($page);
            if ($arrPageData && is_array($arrPageData)) {
                $this->strResponse .= "<pager>" . json_encode($arrPageData['arrPage']) . "</pager>";
                $page = $arrPageData['page'];
            } else {
                $page = 1;
            }
            $this->teacherArray = $this->teacherRepository->findElementByArrParameter($arrParam, COLSTRINGINLIST, (int) ( COLSTRINGINLIST * ($page - 1) ));
        } else {
            $colPage = $this->teacherRepository->countAllElement();
            $this->pagerModel = new pagerModel($colPage, COLSTRINGINLIST);
            $arrPageData = $this->pagerModel->getArrPage($page);
            if ($arrPageData && is_array($arrPageData)) {
                $this->strResponse .= "<pager>" . json_encode($arrPageData['arrPage']) . "</pager>";
                $page = $arrPageData['page'];
            } else {
                $page = 1;
            }
            $this->teacherArray = $this->teacherRepository->getAllElement(COLSTRINGINLIST, (int) ( COLSTRINGINLIST * ($page - 1) ));
        }
        $this->strResponse .= "<page>" . $page . "</page>";
        if ($this->teacherArray && is_array($this->teacherArray)) {
            foreach ($this->teacherArray as $value) {
                $arr = $value->getArrForXMLDocument();
                $this->strResponse .= "<nextElement>" . json_encode($arr) . "</nextElement>";
            }
        } else {
            $this->strResponse = "";
        }
        $this->returnXmlResponse($this->strResponse);
    }

    public function teachersPersonalAction() {
        $idTeach = (isset($_POST['idElement']) ) ? (int) $_POST['idElement'] : 0;
        $this->strResponse = "";
        $this->teacher = $this->teacherRepository->getElementById($idTeach);
        if (is_object($this->teacher)) {
            $arr = $this->teacher->getArrForXMLDocument();
            $this->strResponse .= "<nextElement>" . json_encode($arr) . "</nextElement>";
        }
        $this->returnXmlResponse($this->strResponse);
    }

    public function teachersAddAction() {
        $paramAddUpd = ( isset($_POST['paramAddUpd']) ) ? $_POST['paramAddUpd'] : 'add';
        $idTeach = (isset($_POST['idElement']) ) ? (int) $_POST['idElement'] : 0;
        $this->strResponse = "";
        $arrInputValue = (isset($_POST['arrInputValue']) ) ? json_decode($_POST['arrInputValue'], true) : false;
        if (is_array($arrInputValue)) {
            $arrInputValue['status'] = 'teacher';
            $arrInputValue['work'] = '1';
            $this->teacher = teacherModel::fromState($arrInputValue);
            if (is_object($this->teacher)) {
                if (teachersValidate::validate($this->teacher)) {
//					var_dump($paramAddUpd);
                    if ($paramAddUpd == 'update') {
                        $teach = $this->teacherRepository->getElementById($idTeach);
                        if (is_object($teach)) {
                            $this->teacher->id = $idTeach;
                            $this->teacherRepository->updateElement($this->teacher);
                            $this->strResponse .= "<flagResult idElement='" . $idTeach . "'>0</flagResult><resultAddTeacher>Ок.Данные обновлены</resultAddTeacher>";
                        } else {
                            $this->strResponse .= "<flagResult>2</flagResult><resultAddTeacher>Некорректные данные</resultAddTeacher>";
                        }
                    } else {
                        $teach = $this->teacherRepository->findElementByArrParameter(array('name' => $this->teacher->name, 'surname' => $this->teacher->surname, 'birthday' => $this->teacher->birthday));
                        if (is_object($teach[0])) {
                            $this->strResponse .= "<flagResult>1</flagResult><resultAddTeacher>Такой преподаватель уже есть в базе</resultAddTeacher>";
                        } else {
                            $this->teacherRepository->createElement($this->teacher);
                            $this->strResponse .= "<flagResult>0</flagResult><resultAddTeacher>Ок.Новый преподаватель добавлен в базу</resultAddTeacher>";
                        }
                    }
                } else {
//					var_dump($this->teacher);
                    $this->strResponse .= "<flagResult>2</flagResult><resultAddTeacher>Некорректные данные</resultAddTeacher>";
                    $this->strResponse .= "<nextElement>" . json_encode($this->teacher->getArrForXMLDocument()) . "</nextElement>";
                }
            } else {
                $this->strResponse .= "<flagResult>1</flagResult><resultAddTeacher>Error...ошибка передачи данных</resultAddTeacher>";
            }
//			var_dump($this->teacher);			
        } else {
            $this->strResponse .= "<flagResult>1</flagResult><resultAddTeacher>Error...ошибка передачи данных</resultAddTeacher>";
        }

        $this->returnXmlResponse($this->strResponse);
    }

    public function deleteTeacherAction() {
        $this->strResponse = "";
        $idTeach = (isset($_POST['idElement']) ) ? (int) $_POST['idElement'] : 0;
        $this->teacher = $this->teacherRepository->getElementById($idTeach);
        if (is_object($this->teacher)) {
            $this->teacher->work = 0;
            $this->teacherRepository->updateElement($this->teacher);
        }
        $this->returnXmlResponse($this->strResponse);
    }

    public function updateTeacherAction() {
        $this->returnXmlResponse("<flagResult>2</flagResult><resultAddTeacher>Некорректные данные</resultAddTeacher>");
    }

}
