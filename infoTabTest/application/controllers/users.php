<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {
    public $user="";
    public $password="";
    public $logoEmpresa="";
	public function index()
	{
		
	}
    function __construct( ) {
         parent::__construct();
        
       $this->load->model('user_model','',TRUE); 
        //$this->setUpUser($usu, $pass);   
            
    }
    
    function setUpUser($usu,$pass){
          
        if($this->user_model->validate_user($usu,$pass)==TRUE){
			
             $this->user		= $usu;
             $this->password	= $pass;
             $this->logoEmpresa	= $this->user_model->getLogoempresa($usu);
                        
         }else{
             $this->user='';
             // die("user and pass no match!");
            
         }  
          return $this->user; 
    }
    function getAcces(){
        
        $acces = $this->user_model->getAcces($this->user);
       return $acces; 
      
    }
    function getGroups(){
        
        $groups = $this->user_model->getGroups($this->user);
       return $groups; 
      
    }
    function getSubGroups(){
        
        $subGroups = $this->user_model->getSubGroups($this->user);
       return $subGroups; 
      
    }
    /*
    function getUserCharts(){
        $arrayCharts =   $this->user_model->getCharts($this->user);
        return $arrayCharts; 
        
    }
     
    function getUserTemplates(){
         $templates =   $this->user_model->getTemplates($this->user);
        return $templates; 
    }*/
    function getChartsTab($link){
         $getChartsTab =   $this->user_model->getChartsTab($link);
        return $getChartsTab; 
    }
    function getTabs($link){
         $getTabs =   $this->user_model->getTabs($link);
        return $getTabs; 
    }
    
}

?>
