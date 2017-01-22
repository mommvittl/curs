<?php
class manager_studentsAjaxController extends basisAjaxController{

    protected $studentsRepository;
    protected $students;
    protected $studentsArray;
    protected $pagerModel;

	
    public function __construct(){
        parent::__construct();
        $this->studentsRepository = new studentsRepository;
    }
	
    public function elementListAction(){
        $this->strResponse = "";
        $page = ( isset($_POST['page']) ) ?  (int)$_POST['page'] : 1 ;
        $arrParam = ( isset($_POST['arrParam']) ) ? json_decode($_POST['arrParam'],true) : null ;
        if( $arrParam && is_array($arrParam) ){
            $colPage = $this->studentsRepository->countForFindByArrParameter($arrParam);
            $this->pagerModel = new pagerModel($colPage, COLSTRINGINLIST );
            $arrPageData = $this->pagerModel->getArrPage($page);
            if($arrPageData && is_array($arrPageData) ){
                $this->strResponse .= "<pager>".json_encode($arrPageData['arrPage'])."</pager>";
                $page = $arrPageData['page'];
            }else{ $page = 1; }		
            $this->studentsArray = $this->studentsRepository->findElementByArrParameter($arrParam,COLSTRINGINLIST ,(int)( COLSTRINGINLIST * ($page-1) ));	
        }else{
            $colPage = $this->studentsRepository->countAllElement();
            $this->pagerModel = new pagerModel($colPage, COLSTRINGINLIST );
            $arrPageData = $this->pagerModel->getArrPage($page);	
            if($arrPageData && is_array($arrPageData) ){
	$this->strResponse .= "<pager>".json_encode($arrPageData['arrPage'])."</pager>";
                  $page = $arrPageData['page'];
            }else{ $page = 1; }
            $this->studentsArray = $this->studentsRepository->getAllElement(COLSTRINGINLIST ,(int)( COLSTRINGINLIST * ($page-1) ));
        }
		
        $this->strResponse .= "<page>".$page."</page>";
        if($this->studentsArray && is_array($this->studentsArray)){
            foreach($this->studentsArray as $value){
                $arr = $value->getArrForXMLDocument();			
                $this->strResponse .= "<nextElement>".json_encode($arr)."</nextElement>";
            }
        }else{ $this->strResponse = ""; }
		
        $this->returnXmlResponse($this->strResponse);
    }   
	
    public function elementPersonalAction(){
        $idElement = (isset($_POST['idElement']) ) ? (int)$_POST['idElement'] : 0 ;
        $this->strResponse = "";
        $this->students = $this->studentsRepository->getElementById($idElement);
        if(is_object($this->students)){
            $arr = $this->students->getArrForXMLDocument();
            $this->strResponse .= "<nextElement>".json_encode($arr)."</nextElement>";
        }
//		var_dump($arr);	
        $this->returnXmlResponse($this->strResponse);
    }
	
    public function elementSearchAction(){
        $searchValue = (isset($_POST['searchValue']) ) ?trim($_POST['searchValue']) : "" ;
        $this->strResponse = "";
        $this->studentsArray = $this->studentsRepository->searchElementByArrParametr( array('surname' => $searchValue ) );
        if($this->studentsArray && is_array($this->studentsArray)){
            $arr = [];	
            foreach($this->studentsArray as $value){
                $arr[] = $value->getArrForXMLDocument();
            }	
            $this->strResponse .= "<nextElement>".json_encode($arr)."</nextElement>";		
        }else{ $this->strResponse = ""; }		
        $this->returnXmlResponse($this->strResponse);
    }
    
    public function studentsAddAction() {
      //  var_dump($_POST);
        $paramAddUpd = ( isset($_POST['paramAddUpd']) ) ? $_POST['paramAddUpd'] : 'add' ;
        $idElem = (isset($_POST['idElement']) ) ? (int)$_POST['idElement'] : 0 ;
        $this->strResponse = "";
        $arrInputValue = (isset($_POST['arrInputValue']) ) ? json_decode($_POST['arrInputValue'],true) : false ;
        if(is_array($arrInputValue) ){
            $arrInputValue['work'] = '1';
            $arrInputValue['dogovor'] = '1';
            $this->students = studentsModel::fromState($arrInputValue);
            if( !is_object($this->students) ){
                $this->returnXmlResponse( "<flagResult>1</flagResult><resultAddElement>Error...ошибка передачи данных</resultAddElement>" );
            }
            if( !studentsValidate::validate( $this->students )){
                $this->strResponse .= "<flagResult>2</flagResult><resultAddElement>Некорректные данные</resultAddElement>";
                $this->strResponse .= "<nextElement>" . json_encode( $this->students->getArrForXMLDocument() ) . "</nextElement>";
                $this->returnXmlResponse( $this->strResponse );
            }
            if($paramAddUpd == 'update'){
                 $stud = $this->studentsRepository->getElementById($idElem); 
                if(!is_object($stud)){  
                   $this->returnXmlResponse(  "<flagResult>2</flagResult><resultAddTeacher>Некорректные данные</resultAddTeacher>" );
                } 
                $this->students->id = $idElem;
                $this->teacherRepository->updateElement($this->students);
                $this->strResponse .= "<flagResult idElement='" . $idElem . "'>0</flagResult><resultAddTeacher>Ок.Данные обновлены</resultAddTeacher>"; 					
                  $this->returnXmlResponse( $this->strResponse ); 					
            }else{
                $arr = [ 'name'=>$this->students->name,'surname'=>$this->students->surname,'birthday'=>$this->students->birthday ];
                $stud = $this->studentsRepository->findElementByArrParameter( $arr ); 
                if(is_object($stud[0])) {
                    $this->strResponse .= "<flagResult>1</flagResult><resultAddElement>Такой студент уже есть в базе</resultAddElement>";
                    $this->returnXmlResponse( $this->strResponse );
                }
                $this->studentsRepository->createElement($this->students);
                $this->strResponse .= "<flagResult>0</flagResult><resultAddElement>Ок.Новый студент добавлен в базу</resultAddElement>"; 
                $this->returnXmlResponse( $this->strResponse );
            }	
        }
    }
        
}











