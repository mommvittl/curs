<?php

class teacherRepository extends basisRepository {

//ColumnName in MySQL : id,name,surname,birthday,date,telefon,adress,email,skype,status,work	

    protected function sendQuery() {
        $this->arrResult = [];
        if ($this->result !== false) {
            $this->row = $this->result->fetchAll();
            if ($this->row) {
                foreach ($this->row as $value) {
                    $arr = ['id' => $value['0'], 'name' => $value['name'], 'surname' => $value['surname'], 'birthday' => $value['birthday'],
                        'telephon' => $value['telefon'], 'adress' => $value['adress'], 'email' => $value['email'], 'skype' => $value['skype'],
                        'status' => $value['status'], 'work' => $value['work'], 'idAuthent' => $value[10], 'statusAuthent' => $value[11], 'nameAuthent' => $value[12]];
                    $this->arrResult[] = teacherModel::fromState($arr);
                }
                return $this->arrResult;
            }
        }
        return false;
    }

    public function countAllElement() {
        $this->strQuery = "SELECT count(*) FROM `teacher`  where  1 ";
        $this->result = $this->db->query($this->strQuery);
        if ($this->result !== false) {
            list($col) = $this->result->fetch();
            return $col;
        }
        return false;
    }

    public function getAllElement($colData = 0, $startDaata = 0) {
        $start = abs((int) $startDaata);
        $col = abs((int) $colData);
        $this->strQuery = "SELECT t.*,a.`id`,a.`status`,a.`username` FROM `teacher` as t left join `authents` as a on (t.`id`=a.`id_staff`)  ";
        if ($col) {
            $this->strQuery .= "  LIMIT $start , $col";
        }
        $this->result = $this->db->query($this->strQuery);
        return $this->sendQuery();
    }

    public function getElementById($idData) {
        $this->strQuery = "SELECT t.*,a.`id`,a.`status`,a.`username` FROM `teacher` as t left join `authents` as a on (t.`id`=a.`id_staff`)  where t.`id`=?  ";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array((int) $idData));
        $res = $this->sendQuery();
        return ($res !== false) ? $res[0] : false;
    }

    public function findElement($elementData) {
        $this->arrResult = [];
        $this->strQuery = "SELECT t.*,a.`id`,a.`status`,a.`username` FROM `teacher` as t left join `authents` as a on (t.`id`=a.`id_staff`)  where 
			t.`name`=? and t.`surname`=? and t.`birthday`=? and t.`telefon`=? and t.`adress`=? and t.`email`=? and t.`skype`=? and t.`status`=? and t.`work`=? ";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array($elementData->name, $elementData->surname, $elementData->birthday, $elementData->telephon, $elementData->adress,
            $elementData->email, $elementData->skype, $elementData->status, $elementData->work));
        return $this->sendQuery();
    }

    public function createElement($elementData) {
        $teacher = $this->findElement($elementData);
        if (!$teacher) {
            $this->strQuery = "insert into `teacher` values(NULL,?,?,?,?,?,?,?,?,?) ";
            $this->result = $this->db->prepare($this->strQuery);
            $this->result->execute(array($elementData->name, $elementData->surname, $elementData->birthday, $elementData->telephon, $elementData->adress,
                $elementData->email, $elementData->skype, $elementData->status, $elementData->work));
            $countRow = $this->result->rowCount();
            if ($countRow) {
                return $countRow;
            }
        }
        return false;
    }

    public function deleteElement($elementData) {
        $this->strQuery = "DELETE FROM `teacher` WHERE `id`=? ";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array($elementData->id));
        return ($this->result !== false) ? $this->result->rowCount() : false;
    }

    public function updateElement($elementData) {
        $this->strQuery = "UPDATE `teacher` SET `name`=?,`surname`=?,`birthday`=?,`telefon`=?,`adress`=?,`email`=?,
			`skype`=?,`status`=?,`work`=? WHERE `id`=? ";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array($elementData->name, $elementData->surname, $elementData->birthday, $elementData->telephon, $elementData->adress,
            $elementData->email, $elementData->skype, $elementData->status, $elementData->work, $elementData->id));
        return ($this->result !== false) ? $this->result->rowCount() : false;
    }

    public function countForFindByArrParameter($arrParamData) {
        $this->strQuery = "SELECT count(*) FROM `teacher`  where  1 ";
        $arrValue = [];
        if (is_array($arrParamData)) {
            foreach ($arrParamData as $key => $value) {
                if (in_array(trim($key), array('id', 'name', 'surname', 'birthday', 'telephon', 'adress', 'email', 'skype', 'status', 'work'))) {
                    $this->strQuery .= " AND  `" . trim($key) . "` = ? ";
                    $arrValue[] = $value;
                }
            }
            $this->result = $this->db->prepare($this->strQuery);
            $this->result->execute($arrValue);
            if ($this->result !== false) {
                list($col) = $this->result->fetch();
                return $col;
            }
        }
        return false;
    }

    public function findElementByArrParameter($arrParamData, $colData = 0, $startData = 0) {
        $start = abs((int) $startData);
        $col = abs((int) $colData);
        $arrValue = [];
        $this->strQuery = "SELECT t.*,a.`id`,a.`status`,a.`username` FROM `teacher` as t left join `authents` as a on (t.`id`=a.`id_staff`)  where  1 ";
        if (is_array($arrParamData)) {
            foreach ($arrParamData as $key => $value) {
                if (in_array(trim($key), array('id', 'name', 'surname', 'birthday', 'telephon', 'adress', 'email', 'skype', 'status', 'work'))) {
                    $this->strQuery .= " AND  t.`" . trim($key) . "` = ? ";
                    $arrValue[] = trim($value);
                }
            }
            if ($col) {
                $this->strQuery .= " LIMIT $start , $col";
            }

            $this->result = $this->db->prepare($this->strQuery);
            $this->result->execute($arrValue);
            return $this->sendQuery();
        }
    }

    public function countForSearchByArrParametr($arrParamData) {
        $this->strQuery = "SELECT count(*) FROM `teacher`  where  1 ";
        if (is_array($arrParamData)) {
            foreach ($arrParamData as $key => $value) {
                $val = htmlentities($value, ENT_QUOTES);
                if (in_array(trim($key), array('id', 'name', 'surname', 'birthday', 'telephon', 'adress', 'email', 'skype', 'status', 'work'))) {
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
        $this->strQuery = "SELECT t.*,a.`id`,a.`status`,a.`username` FROM `teacher` as t left join `authents` as a on (t.`id`=a.`id_staff`)  where  1 ";
        if (is_array($arrParamData)) {
            foreach ($arrParamData as $key => $value) {
                $val = htmlentities($value, ENT_QUOTES);
                if (in_array(trim($key), array('id', 'name', 'surname', 'birthday', 'telephon', 'adress', 'email', 'skype', 'status', 'work'))) {
                    $this->strQuery .= " AND  t.`" . trim($key) . "` LIKE ('%" . $val . "%') ";
                }
            }
            if ($col) {
                $this->strQuery .= " LIMIT $start , $col";
            }
            $this->result = $this->db->query($this->strQuery);
            return $this->sendQuery();
        }
    }

    public function getArrNoLoginElement() {
        $this->strQuery = "SELECT t.*,a.`id`,a.`status`,a.`username` FROM `teacher` as t left join `authents` as a on (t.`id`=a.`id_staff`)  where  a.`status` is null 
			and a.`id_staff` is null";
        $this->result = $this->db->query($this->strQuery);
        return $this->sendQuery();
    }

}
