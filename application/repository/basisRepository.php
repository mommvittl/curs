<?php
abstract class basisRepository{
	
	protected $db = null;
	protected $strQuery;
	protected $result;
	protected $row;		
	protected $arrResult;		
	
    public function __construct(){
        $this->db = PDOLib::getInstance()->getPdo();
    }	
	
	abstract public function createElement($elementData);
	abstract public function findElement($elementData);
	abstract public function updateElement($elementData);
	abstract public function deleteElement($elementData);	
}


