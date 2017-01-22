<?php

class teacherModel extends basisModel {

//ColumnName in MySQL : id,name,surname,birthday,date,telefon,adress,email,skype,status,work	
    protected $arrColumnName = ['id', 'name', 'surname', 'birthday', 'telephon', 'adress', 'email', 'skype', 'status', 'work', 'idAuthent', 'statusAuthent', 'nameAuthent'];
    protected $id = false;
    protected $name = false;
    protected $surname = false;
    protected $birthday = false;
    protected $telephon = false;
    protected $adress = false;
    protected $email = false;
    protected $skype = false;
    protected $status = false;
    protected $work = false;
    protected $idAuthent = false;
    protected $statusAuthent = false;
    protected $nameAuthent = false;

    public static function fromState($state) {
        return new self($state);
    }

    public function getArrForXMLDocument() {
        return array('id' => $this->id, 'name' => $this->name, 'surname' => $this->surname, 'birthday' => $this->birthday, 'telephon' => $this->telephon,
            'adress' => $this->adress, 'email' => $this->email, 'skype' => $this->skype, 'status' => $this->status, 'work' => $this->work,
            'idAuthent' => $this->idAuthent, 'statusAuthent' => $this->statusAuthent, 'nameAuthent' => $this->nameAuthent);
    }

}
