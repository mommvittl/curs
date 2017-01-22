<?php

class cpecyalitysRepository {

// COlumnName in MySQL : id, title, priseBasis, description, quantity, bossId, work	
    protected function sendQuery() {
        $this->arrResult = [];
        if ($this->result !== false) {
            $this->row = $this->result->fetchAll();
            if ($this->row) {
                foreach ($this->row as $value) {
                    $arr = [ 
                                'id'                 => $value['id'],
                                'title'              => $value['title'],
                                'priseBasis'   => $value['priseBasis'],
                                'description'  => $value['description'],
                                'quantity'       => $value['quantity'],
                                'bossId'         => $value['bossId'],
                                'work'            => $value['work']
                             ];
                    $this->arrResult[] = cpecialitysModel::fromState( $arr );
                }
                return $this->arrResult;
            }
        }
        return false;
    }
    
     public function getElementById($idData) {
        $this->strQuery = "SELECT s.* FROM `cpecialitys` as s  where s.`id`= ?  ";
        $this->result = $this->db->prepare( $this->strQuery );
        $this->result->execute( array( (int)$idData ) );
        if( $this->result !== false ){
             $this->row = $this->result->fetch();
               if ($this->row){
                   $arr = [ 
                                'id'                 => $this->row['id'],
                                'title'              => $this->row['title'],
                                'priseBasis'   => $this->row['priseBasis'],
                                'description'  => $this->row['description'],
                                'quantity'       => $this->row['quantity'],
                                'bossId'         => $this->row['bossId'],
                                'work'            => $this->row['work']
                             ];
                   return cpecialitysModel::fromState( $arr );
               }
        }
        return false;
    }
    
    public function getAllElement( $colData = 0, $startData = 0 ) {
        $start = abs((int) $startData);
        $col = abs((int) $colData);
        $this->strQuery = "SELECT s.* FROM `cpecialitys` as s  ";
        if ($col) {
            $this->strQuery .= "  LIMIT $start , $col";
        }
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array());
        return $this->sendQuery();
    }
    
     public function countAllElement() {
        $this->strQuery = "SELECT count(*) FROM  `cpecialitys` as s  where  1 ";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute(array());
        if ($this->result !== false) {
            list($col) = $this->result->fetch();
            return $col;
        }
        return false;
    }
    
     public function createElement( $elementData ) {
         $element = $this->findElement( $elementData );
        if ( !$element ) {
            $this->strQuery = "insert into `cpecialitys` values(NULL,?,?,?,?,?,?) ";
            $this->result = $this->db->prepare($this->strQuery);
            $this->result->execute( array(
                                                            $elementData->title, 
                                                            $elementData->priseBasis, 
                                                            $elementData->description, 
                                                            $elementData->quantity, 
                                                            $elementData->bossId, 
                                                            $elementData->work
                                                        ) );
            $countRow = $this->result->rowCount();
            if ($countRow) {  return $countRow;  }     
        }
        return false;
    }
    
     public function findElement($elementData) {
         $this->strQuery = " SELECT s.* FROM `cpecialitys` as s where  "
            . " s.`title`=? and s.`priseBasis`=? and s.`quantity`=? and s.`work`=? ";      
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute( array(
                                                        $elementData->title, 
                                                        $elementData->priseBasis, 
                                                        $elementData->quantity, 
                                                        $elementData->work
                                                        ));
        return $this->sendQuery();
    }
    
    public function deleteElement($elementData) {
        $this->strQuery = "DELETE FROM `cpecialitys` WHERE `id`=? ";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute( array( $elementData->id ) );
        return $this->result->rowCount();
    }
    
    public function updateElement($elementData) {
        $this->strQuery = " UPDATE `cpecialitys` SET `title`=?,`priseBasis`=? , " 
                . " `description`=?,`quantity`=?,`bossId`=?,`work`=? WHERE `id`=? ";
        $this->result = $this->db->prepare($this->strQuery);
        $this->result->execute( array( 
                                                        $elementData->title, 
                                                        $elementData->priseBasis, 
                                                        $elementData->description, 
                                                        $elementData->quantity,
                                                        $elementData->bossId, 
                                                        $elementData->work, 
                                                        $elementData->id
                                                        ));
        return $this->result->rowCount();
    }
    
  
}
