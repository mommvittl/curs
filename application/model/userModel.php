<?php

class userModel extends basisModel {

//ColumnName in MySQL : id,login,password,status,username,id_staff	
    protected $arrColumnName = ['id', 'login', 'password', 'status', 'username', 'idStaff'];
    protected $id = false;
    protected $login = false;
    protected $password = false;
    protected $status = false;
    protected $username = false;
    protected $idStaff = false;

    public static function fromState($state) {
        return new self($state);
    }

    public function getArrForXMLDocument() {
        return array('id' => $this->id, 'name' => $this->name, 'surname' => $this->surname, 'birthday' => $this->birthday, 'telephon' => $this->telephon,
            'adress' => $this->adress, 'email' => $this->email, 'skype' => $this->skype, 'status' => $this->status, 'work' => $this->work);
    }

}
