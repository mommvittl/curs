<?php

class accessRepository extends basisRepository {

//ColumnName in MySQL : id,login,password,status,username,id_staff		
    protected $login = false;
    protected $password = false;
    protected $arrResult = [];

    protected function sendQuery() {
        $this->arrResult = [];
        if ($this->result !== false) {
            $this->row = $this->result->fetchAll();
            if ($this->row) {
                foreach ($this->row as $value) {
                    $arr = ['id' => $value['id'], 'login' => $value['login'], 'password' => $value['password'], 'status' => $value['status'],
                        'username' => $value['username'], 'idStaff' => $value['id_staff']];
                    $arrResult[] = userModel::fromState($arr);
                }
                return $arrResult;
            }
        }
        return false;
    }

    public function getUserByLogin($userLogg, $userPassw) {
        $this->login = hash("sha256", $userLogg);
        $this->password = hash("sha256", $userPassw);
        $this->strQuery = "select * from `authents` where `login`=? and `password`=? ";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array($this->login, $this->password));
        return $this->sendQuery()[0];
    }

    public function registrationNewUser($loginData, $passwordData, $usernameData) {
        $this->login = hash("sha256", $loginData);
        $this->password = hash("sha256", $passwordData);
        $this->strQuery = "insert into `authents` set `login`=?,`password`=?,`username`=?";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array($this->login, $this->password, $usernameData));
        return ( $this->result->rowCount() ) ? $this->getUserByLogin($loginData, $passwordData) : false;
    }

    public function getElementById($idData) {
        $this->strQuery = "select * from `authents` where `id`=?  ";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array((int) $idData));
        return $this->sendQuery()[0];
    }

    public function getNewUser() {
        $this->strQuery = "SELECT * FROM `authents` WHERE `id_staff` is null AND `status` is null";
        $this->result = $this->db->query($this->strQuery);
        return $this->sendQuery();
    }

    public function countAllElement() {
        $this->strQuery = "SELECT count(*) from `authents` ";
        $this->result = $this->db->query($this->strQuery);
        if ($this->result !== false) {
            list($col) = $this->result->fetch();
            return $col;
        }
        return false;
    }

    public function getAllElement($colData = 0, $startData = 0) {
        $start = abs((int) $startData);
        $col = abs((int) $colData);
        $this->strQuery = "SELECT * from `authents` ";
        if ($col) {
            $this->strQuery .= " LIMIT $start , $col";
        }
        $this->result = $this->db->query($this->strQuery);
        return $this->sendQuery();
    }

    public function createElement($elementData) {
        
    }

    public function findElement($elementData) {
        
    }

    public function updateElement($elementData) {
        $this->strQuery = "UPDATE `authents` SET `status`= ?, `username`= ?, `id_staff`= ? WHERE `id`= ? ";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array($elementData->status, $elementData->username, $elementData->idStaff, $elementData->id));
        return ($this->result !== false) ? $this->result->rowCount() : false;
    }

    public function deleteElement($elementData) {
        $this->strQuery = "DELETE FROM `authents`  WHERE `id`= ? ";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array($elementData->id));
        return ($this->result !== false) ? $this->result->rowCount() : false;
    }

    public function countElementByArrParametr($arrParamData) {
        $this->strQuery = "SELECT count(*) from `authents`  where 1 ";
        if (is_array($arrParamData)) {
            foreach ($arrParamData as $key => $value) {
                $val = htmlentities($value, ENT_QUOTES);
                if (in_array(trim($key), array('id', 'login', 'password', 'status', 'username', 'id_staff'))) {
                    $this->strQuery .= " AND  `" . trim($key) . "` LIKE ('%" . $val . "%') ";
                }
            }
            $this->result = $this->db->query($this->strQuery);
            if ($this->result !== false) {
                list($col) = $this->result->fetch();
                return $col;
            }
        }
        return false;
    }

    public function searchElementByArrParametr($arrParamData, $colData = 0, $startData = 0) {
        $start = abs((int) $startData);
        $col = abs((int) $colData);
        $this->strQuery = "SELECT * from `authents`  where 1 ";
        if (is_array($arrParamData)) {
            foreach ($arrParamData as $key => $value) {
                $val = htmlentities($value, ENT_QUOTES);
                if (in_array(trim($key), array('id', 'login', 'password', 'status', 'username', 'id_staff'))) {
                    $this->strQuery .= " AND  `" . trim($key) . "` LIKE ('%" . $val . "%') ";
                }
            }
            if ($col) {
                $this->strQuery .= " LIMIT $start , $col";
            }
            $this->result = $this->db->query($this->strQuery);
            return $this->sendQuery();
        }
    }

}
