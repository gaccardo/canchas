<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    include_once("users.php");
    session_start();
class Login extends CI_Controller {
	   var $usuarioLogueado; 
    function __construct( ) {
         parent::__construct();
        
    }
	public function index()
	{
        
        $this->load->helper(array('url','form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Usuario', 'required');
        $this->form_validation->set_rules('userpass', 'Contraseña', 'required');
        $this->form_validation->set_error_delimiters('<em>','</em>');
	   // $this->load->view('login_view');
		    
		if($this->input->post('login'))
        {
            if($this->form_validation->run())
            {
              $user_name = $this->input->post('username');
              $user_pass = $this->input->post('userpass');
              $usuario = new Users();
               //var_dump($usuario);
              $userName = $usuario->setUpUser($user_name, $user_pass);
              if($userName!=''){
                   
                  // $pages   = $usuario->getHtmlAcces();
                  //$data['pages']=$pages;
                     $data['user']=$usuario->user;
                     $data['title']   = "Menu";
                     $data['logoEmpresa']=$usuario->logoEmpresa;
                     $this->usuarioLogueado = $usuario;
                     $sess_array = array('usuario'=>$usuario->user,'pass'=>$usuario->password,'logoEmpresa'=>$usuario->logoEmpresa);
                     $this->session->set_userdata('userData', $sess_array);
                     // user has been logged in
                     $this->load->view('header',$data); 
                     //$this->load->view('menu_view',$data);
                     redirect('dashboard');
                       // redirect('threeColumns');
              }else{
                  $data['errorMsg'] = "Usuario o Password erroneos";
                  $data['display']   = "block";
                  $data['title']   = "User Console";
                  $this->load->view('header',$data); 
                  $this->load->view('login_view',$data);
              }
              
            }else{
                 $data['title']   = "User Console";
                $this->load->view('header',$data); 
                $this->load->view('login_view');
            }
        }else{
             $this->logout();
                     
        }
        
		
	
	}
   public function logout()
     {
         $this->session->unset_userdata('userData');
        session_destroy();
        $data['title']   = "User Console";
        $this->load->view('header',$data); 
        $data['display']   = "none";
        $this->load->view('login_view',$data);
     }
}

?>
