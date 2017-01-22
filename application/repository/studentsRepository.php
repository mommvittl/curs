<?php

class studentsRepository extends basisRepository {

// COlumnName in MySQL : id,name,surname,birthday,telefon,adress,email,skype,characteristic,dogovor,work	

    protected function sendQuery() {
        $this->arrResult = [];
        if ($this->result !== false) {
            $this->row = $this->result->fetchAll();
            if ($this->row) {
                foreach ($this->row as $value) {
                    $arr = ['id' => $value['id'], 'name' => $value['name'], 'surname' => $value['surname'], 'birthday' => $value['birthday'],
                        'telephon' => $value['telefon'], 'adress' => $value['adress'], 'email' => $value['email'], 'skype' => $value['skype'],
                        'characteristic' => $value['characteristic'], 'dogovor' => $value['dogovor'], 'work' => $value['work'], 'idGroups' => $value['id_group']];
                    $this->arrResult[] = teacherModel::fromState($arr);
                }
                return $this->arrResult;
            }
        }
        return false;
    }

    public function getElementById($idData) {
        $this->strQuery = "SELECT s.*,gl.`id_group` FROM `students` as s left join `groups_list` as gl on (s.`id`=gl.`id_student`)  where s.`id`=?  ";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array((int) $idData));
        if ($this->result !== false) {
            $this->row = $this->result->fetch();
            if ($this->row) {
                $arr = ['id' => $this->row[0], 'name' => $this->row['name'], 'surname' => $this->row['surname'], 'birthday' => $this->row['birthday'],
                    'telephon' => $this->row['telefon'], 'adress' => $this->row['adress'], 'email' => $this->row['email'], 'skype' => $this->row['skype'],
                    'characteristic' => $this->row['characteristic'], 'dogovor' => $this->row['dogovor'], 'work' => $this->row['work'], 'idGroups' => $this->row['id_group']];
                return studentsModel::fromState($arr);
            }
        }
        return false;
    }

    public function getAllElement($colData = 0, $startDaata = 0) {
        $start = abs((int) $startDaata);
        $col = abs((int) $colData);
        $this->strQuery = "SELECT s.*,gl.`id_group` FROM `students` as s left join `groups_list` as gl on (s.`id`=gl.`id_student`) ";
        if ($col) {
            $this->strQuery .= "  LIMIT $start , $col";
        }
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array());
        return $this->sendQuery();
    }

    public function countAllElement() {
        $this->strQuery = "SELECT count(*) FROM  `students` as s  where  1 ";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array());
        if ($this->result !== false) {
            list($col) = $this->result->fetch();
            return $col;
        }
        return false;
    }

    public function createElement($elementData) {
        $element = $this->findElement($elementData);
        if (!$element) {
            $this->strQuery = "insert into `students` values(NULL,?,?,?,?,?,?,?,?,?,?) ";
            $this->result = $this->db->prepare($this->strQuery);
            $this->result->execute(array($elementData->name, $elementData->surname, $elementData->birthday, $elementData->telephon, $elementData->adress,
                $elementData->email, $elementData->skype, $elementData->characteristic, $elementData->dogovor, $elementData->work));
            $countRow = $this->result->rowCount();
            if ($countRow) {
                return $countRow;
            }
        }
        return false;
    }

    public function findElement($elementData) {
        $this->strQuery = "SELECT s.* FROM `students` as s where s.`name`=? and s.`surname`=? and s.`birthday`=? 
			and s.`telefon`=? and s.`adress`=? and s.`email`=? and s.`skype`=? and s.`dogovor`=?  and s.`work`=? ";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array($elementData->name, $elementData->surname, $elementData->birthday, $elementData->telephon, $elementData->adress,
            $elementData->email, $elementData->skype, $elementData->dogovor, $elementData->work));
        return $this->sendQuery();
    }

    public function updateElement($elementData) {
        $this->strQuery = "UPDATE `students` SET `name`=?,`surname`=?,`birthday`=?,`telefon`=?,`adress`=?,`email`=?,
			`skype`=?,`characteristic`=?,`dogovor`=?,`work`=? WHERE `id`=? ";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array($elementData->name, $elementData->surname, $elementData->birthday, $elementData->telephon, $elementData->adress,
            $elementData->email, $elementData->skype, $elementData->characteristic, $elementData->dogovor, $elementData->work, $elementData->id));
        return $this->result->rowCount();
    }

    public function deleteElement($elementData) {
        $this->strQuery = "DELETE FROM `students` WHERE `id`=? ";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array($elementData->id));
        return $this->result->rowCount();
    }

    public function findElementByArrParameter($arrParamData, $colData = 0, $startData = 0) {

        $start = abs((int) $startData);
        $col = abs((int) $colData);
        $arrValue = [];
        $this->strQuery = "SELECT s.*,gl.`id_group` FROM `students` as s left join `groups_list` as gl on (s.`id`=gl.`id_student`) where  1 ";
        if (is_array($arrParamData)) {
            foreach ($arrParamData as $key => $value) {
                if (in_array(trim($key), array('id', 'name', 'surname', 'birthday', 'telephon', 'adress', 'email', 'skype', 'kharacteristica', 'dogovor', 'work'))) {
                    $this->strQuery .= " AND  s.`" . trim($key) . "` = ? ";
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

    public function countForFindByArrParameter($arrParamData) {
        $this->strQuery = "SELECT count(*) FROM  `students` as s  where  1 ";
        $arrValue = [];
        if (is_array($arrParamData)) {
            foreach ($arrParamData as $key => $value) {
                if (in_array(trim($key), array('id', 'name', 'surname', 'birthday', 'telephon', 'adress', 'email', 'skype', 'kharacteristica', 'dogovor', 'work'))) {
                    $this->strQuery .= " AND  s.`" . trim($key) . "` = ? ";
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

    public function countStudentForAddToGroup() {
        $this->strQuery = "SELECT count(*) FROM `students` as s left join  `groups_list` as gl on (s.`id`=gl.`id_student`) WHERE s.`work`='1' and (gl.`id_group` is null) ";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array());
        if ($this->result !== false) {
            list($col) = $this->result->fetch();
            return $col;
        }
        return false;
    }

    public function getStudentForAddToGroup($colData = 0, $startDaata = 0) {
        $start = abs((int) $startDaata);
        $col = abs((int) $colData);
        $this->strQuery = "SELECT s.* FROM `students` as s left join  `groups_list` as gl on (s.`id`=gl.`id_student`) WHERE s.`work`='1' and (gl.`id_group` is null) ";
        if ($col) {
            $this->strQuery .= " LIMIT $start , $col ";
        }
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array());
        return $this->sendQuery();
    }

    public function searchElementByArrParametr($arrParamData, $colData = 0, $startData = 0) {
        $start = abs((int) $startData);
        $col = abs((int) $colData);
        $this->strQuery = "SELECT s.*,gl.`id_group` FROM `students` as s left join `groups_list` as gl on (s.`id`=gl.`id_student`) where  1 ";
        if (is_array($arrParamData)) {
            foreach ($arrParamData as $key => $value) {
                $val = htmlentities($value, ENT_QUOTES);
                if (in_array(trim($key), array('id', 'name', 'surname', 'birthday', 'telephon', 'adress', 'email', 'skype', 'kharacteristica', 'dogovor', 'work'))) {
                    $this->strQuery .= " AND  s.`" . trim($key) . "` LIKE ('%" . $val . "%') ";
                }
            }
            if ($col) {
                $this->strQuery .= " LIMIT $start , $col";
            }
            $this->result = $this->db->prepare($this->strQuery);
            $this->result->execute(array());
            return $this->sendQuery();
        }
    }

    public function countForSearchByArrParametr($arrParamData) {
        $this->strQuery = "SELECT count(*) FROM `students`  where  1 ";
        if (is_array($arrParamData)) {
            foreach ($arrParamData as $key => $value) {
                if (in_array(trim($key), array('id', 'name', 'surname', 'birthday', 'telephon', 'adress', 'email', 'skype', 'kharacteristica', 'dogovor', 'work'))) {
                    $this->strQuery .= " AND  `" . trim($key) . "` LIKE ('%" . $value . "%') ";
                }
            }
            $this->result = $this->db->prepare($this->strQuery);
            $this->result->execute(array());
            if ($this->result !== false) {
                list($col) = $this->result->fetch();
                return $col;
            }
        }
        return false;
    }

    public function globalSearchByArrParam($arrParamData) {
        $this->arrResult = [];
        $this->strQuery = "SELECT s.* FROM `students` as s where 1 ";
        if (is_array($arrParamData)) {
            foreach ($arrParamData as $key => $value) {
                if (in_array(trim($key), array('id', 'name', 'surname', 'birthday', 'telefon', 'telefon', 'adress', 'email', 'skype', 'characteristic', 'dogovor', 'work'))) {
                    $this->strQuery .= " AND  s.`" . trim($key) . "` LIKE ('%" . $value . "%') ";
                }
            }
            $this->result = $this->db->prepare($this->strQuery);
            $this->result->execute($arrValue);
            if ($this->result !== false) {
                $this->row = $this->result->fetchAll();
                if ($this->row) {
                    foreach ($this->row as $value) {
                        $arr = ['id' => $value[0], 'name' => $value['name'], 'surname' => $value['surname'], 'birthday' => $value['birthday'],
                            'telephon' => $value['telefon'], 'adress' => $value['adress'], 'email' => $value['email'], 'skype' => $value['skype'],
                            'characteristic' => $value['characteristic'], 'dogovor' => $value['dogovor'], 'work' => $value['work']];
                        $this->arrResult[] = studentsModel::fromState($arr);
                    }
                    return $this->arrResult;
                }
            }
        }
        return false;
    }

}
