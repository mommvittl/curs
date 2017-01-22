<?php

class auditoriasRepository extends basisRepository {

    //ColumnName in MySQL : id,title,adress,description,work

    protected function sendQuery() {
        $this->arrResult = [];
        if ($this->result !== false) {
            $this->row = $this->result->fetchAll();
            if ($this->row) {
                foreach ($this->row as $value) {
                    $arr = ['id' => $value['id'], 'title' => $value['title'], 'adress' => $value['adress'], 'description' => $value['description'], 'work' => $value['work']];
                    $this->arrResult[] = auditoriasModel::fromState($arr);
                }
                return $this->arrResult;
            }
        }
        return false;
    }

    public function getElementById($idData) {
        $this->strQuery = "SELECT * FROM `auditorias`  where `id`=?  ";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array((int) $idData));
        $auditorias = $this->sendQuery();
        if ($auditorias && is_array($auditorias)) {
            return $auditorias[0];
        } else {
            return false;
        }
    }

    public function getAllElement() {
        $this->strQuery = "SELECT * FROM `auditorias` ";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array());
        return $this->sendQuery();
    }

    public function createElement($elementData) {
        $teacher = $this->findElement($elementData)[0];
        if (!$teacher) {
            $this->strQuery = "insert into `auditorias` values(NULL,?,?,?,?) ";
            $this->result = $this->db->prepare($this->strQuery);
            $this->result->execute(array($elementData->title, $elementData->adress, $elementData->description, $elementData->work));
            $countRow = $this->result->rowCount();
            if ($countRow) {
                return $countRow;
            }
        }
        return false;
    }

    public function findElement($elementData) {
        $this->arrResult = [];
        $this->strQuery = "SELECT * FROM `auditorias` where `title`=? and `adress`=? and `description`=? and `work`=? ";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array($elementData->title, $elementData->adress, $elementData->description, $elementData->work));
        return $this->sendQuery();
    }

    public function deleteElement($elementData) {
        $this->strQuery = "DELETE FROM `auditorias` WHERE `id`=? ";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array($elementData->id));
        $countRow = $this->result->rowCount();
        return ($countRow) ? $countRow : false;
    }

    public function updateElement($elementData) {
        $this->strQuery = "UPDATE `auditorias` SET `title`=?, `adress`=?, `description`=?, `work`=?  WHERE `id`=? ";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array($elementData->title, $elementData->adress, $elementData->description, $elementData->work, $elementData->id));
        $countRow = $this->result->rowCount();
        return ($countRow) ? $countRow : false;
    }

    public function findElementByArrParameter($arrParam) {
        $arrValue = [];
        $this->strQuery = "SELECT * FROM `auditorias` where 1 ";
        if (is_array($arrParam)) {
            foreach ($arrParam as $key => $value) {
                if (in_array(trim($key), array('id', 'title', 'adress', 'description', 'work'))) {
                    $this->strQuery .= " AND  `" . trim($key) . "` = ? ";
                    $arrValue[] = trim($value);
                }
            }
            $this->result = $this->db->prepare($this->strQuery);
            $this->result->execute($arrValue);
            return $this->sendQuery();
        }
        return false;
    }

    public function searchElementByArrParametr($arrParam) {
        $this->strQuery = "SELECT * FROM `auditorias` where 1 ";
        if (is_array($arrParam)) {
            foreach ($arrParam as $key => $value) {
                $val = htmlentities($value, ENT_QUOTES);
                if (in_array(trim($key), array('id', 'title', 'adress', 'description', 'work'))) {
                    $this->strQuery .= " AND `" . trim($key) . "` LIKE ('%" . trim($val) . "%') ";
                }
            }
            $this->result = $this->db->prepare($this->strQuery);
            $this->result->execute(array());
            return $this->sendQuery();
        }
        return false;
    }

}
