<?php

abstract class basisAjaxController {

    protected $functionHandler;
    protected $xmlString;
    protected $strResponse;

    public function __construct() {
        header('Content-Type: text/XML');
//		header(' Cache-Control: no-cache');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
        header('Cache-Control: no-cache, must-revalidate');
        header('Pragma: no-cache');
//		$this->functionHandler = trim($_POST['functionHandler']);
    }

    protected function returnXmlResponse($data = "") {
//		$this->xmlString = "<response><functionHandler>".$this->functionHandler."</functionHandler>";
        $this->xmlString = "<response>" . $data . "</response>";
        exit($this->xmlString);
    }

}
