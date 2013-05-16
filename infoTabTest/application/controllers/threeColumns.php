<?php
     if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    include_once("users.php");
     session_start();
class ThreeColumns extends CI_Controller {

    public function index(){
         $this->load->helper(array('url','form'));
         
         if($this->session->userdata('userData')){
            $logedUser  = $this->session->userdata('userData');
           $usuario = new Users();
           //var_dump($usuario);
            $userName = $usuario->setUpUser($logedUser['usuario'],$logedUser['pass']);
           $userCharts  = $usuario->getUserCharts();
          // var_dump($userCharts);
        }else{
            Die('no se logeo');
           //If no session, redirect to login page
           //redirect('login', 'refresh');
         }
        
         $data['user']=$usuario->user;
         $data['title']   = "Dashboards";
         $data['charts']    = $userCharts;           
         $this->load->view('header',$data); 
        $this->load->view('threeColumns_view');
       
    }
    function __construct(  ) {
         parent::__construct();
        
    }
    function __destruct(){
        parent::__destruct();
    }
    
    
}
?>