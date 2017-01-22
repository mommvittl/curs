<?php

class manager_accessAjaxController extends basisAjaxController {

    private $accessRepository;
    private $teacherRepository;
    private $user;
    private $userArray;
    private $teacher;
    private $teacherArray;

    public function getAllElementAction() {
        $this->accessRepository = new accessRepository;
        $this->teacherRepository = new teacherRepository;
        $this->userArray = $this->accessRepository->getAllElement();
        $this->strResponse = "";
        if (is_array($this->userArray)) {
            foreach ($this->userArray as $value) {
                $arr = [];
                if ($value->idStaff) {
                    $this->teacher = $this->teacherRepository->getElementById($value->idStaff);
                    if (is_object($this->teacher)) {
                        $arr = $this->teacher->getArrForXMLDocument();
                    }
                }
                $arr['idUser'] = $value->id;
                $arr['statusUser'] = $value->status;
                $arr['username'] = $value->username;
                $this->strResponse .= "<nextElement>" . json_encode($arr) . "</nextElement>";
            }
        }
        $this->returnXmlResponse($this->strResponse);
    }

    public function deleteElementAction() {
        $idUser = (isset($_POST['idUser'])) ? (int) $_POST['idUser'] : 0;
        $this->accessRepository = new accessRepository;
        $this->user = $this->accessRepository->getElementById($idUser);
        if (is_object($this->user)) {
            $this->accessRepository->deleteElement($this->user);
        }
        $this->getAllElementAction();
    }

    public function updateStatusElementAction() {
        $newStatus = (isset($_POST['status']) && in_array($_POST['status'], array('teacher', 'manager'))) ? $_POST['status'] : 'teacher';
        $idUser = (isset($_POST['idUser'])) ? (int) $_POST['idUser'] : 0;
        $this->accessRepository = new accessRepository;
        $this->user = $this->accessRepository->getElementById($idUser);
        if (is_object($this->user) && in_array($this->user->status, array('teacher', 'manager'))) {
            $this->user->status = $newStatus;
            $this->accessRepository->updateElement($this->user);
        }
        $this->getAllElementAction();
    }

    public function updateTeacherForUserAction() {
        $this->strResponse = "";
        $idUser = (isset($_POST['idUser'])) ? (int) $_POST['idUser'] : 0;
        $idTeach = (isset($_POST['idTeach'])) ? (int) $_POST['idTeach'] : 0;
        $this->accessRepository = new accessRepository;
        $this->teacherRepository = new teacherRepository;
        $this->teacher = $this->teacherRepository->getElementById($idTeach);
        $this->user = $this->accessRepository->getElementById($idUser);
        if (!is_object($this->teacher) || ($this->teacher->idAuthent) || ($this->teacher->statusAuthent) || ($this->teacher->nameAuthent)) {
            $this->getAllElementAction();
        }
        if (!is_object($this->user) || ($this->user->status) || ($this->user->idStaff)) {
            $this->getAllElementAction();
        }
        $this->user->status = 'teacher';
        $this->user->idStaff = $this->teacher->id;
        $this->accessRepository->updateElement($this->user);
        $this->getAllElementAction();
    }

}
