<?php
class registerLineModel extends basisModel{
//columnsName in MySQL : id_temetable,id_group,id_student,attendance,assesment,homework,remarks.	
	protected $idTemetable = null;
	protected $idGroup = null;
	protected $idStudent = null;
	protected $attendance = null;
	protected $assesment = null;
	protected $homework = null;
	protected $remarks = null;
	protected $student = null;
	protected $studentCreateFlag = false;
	
	public function __construct($arrParameter = []){	
		if(!empty($arrParameter) && (is_array($arrParameter)) ){
			foreach($arrParameter as $key=>$value){
				if( in_array($key,array('idTemetable','idGroup','idStudent','attendance','assesment','homework','remarks','studentCreateFlag') ) ){
					$this->$key = $value;
				}
			}
			if(!empty($this->idStudent) && $this->studentCreateFlag ){ $this->student = ( new studentsRepository)->getElementById($this->idStudent); }
		}		
	}	
	
	public static function fromState($state){
        return new self($state);
    }
	
	public function getArrForXMLDocument(){
		$arr = [ 'idTemetable'=>$this->idTemetable,'idGroup'=>$this->idGroup,'idStudent'=>$this->idStudent,'attendance'=>$this->attendance,
		'assesment'=>$this->assesment,'homework'=>$this->homework,'remarks'=>$this->remarks ];
		$arr['studentName']	= (is_object($this->student) ) ? $this->student->name : null ;
		$arr['studentSurname']	= (is_object($this->student)) ? $this->student->surname : null ;
		return $arr;
	}
	
	public function __set($parametrName,$valueName){
		if (in_array($parametrName,array('idTemetable','idGroup','idStudent','attendance','assesment','homework','remarks') ) ){
			$this->$parametrName = $valueName;
		}
	}
}