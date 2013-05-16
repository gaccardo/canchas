<?php
     if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    include_once("users.php");
     session_start();
class Dashboard extends CI_Controller {

   var $logedUser;
   
    public function index()
    {
          $this->load->helper(array('url','form'));
         
         if($this->session->userdata('userData')){
            $logedUser  = $this->session->userdata('userData');
           $usuario = new Users();
           $userName = $usuario->setUpUser($logedUser['usuario'],$logedUser['pass']);
           $userAcces   = $usuario->getAcces();
           $groups      = $usuario->getGroups();
           $subGroups      = $usuario->getSubGroups();
           $data['user']      = $usuario->user;
           $data['logoEmpresa']=$usuario->logoEmpresa;
           $data['title']     = "Dashboards";
           $this->load->view('internalHeader_view',$data);
           $data['groups']    = $groups;
           $data['subGroups']    = $subGroups;
           $data['acces']      = $userAcces;
         
         //open the dashboard container
             $this->load->view('dashboard_container_view',$data);
           // $this->load->view('defaultDashboard_view',$data);
            $this->load->view('home_view',$data);
            $this->load->view('dashboard_close_view',$data);
        }else{
            //Die('no se logeo');
           //If no session, redirect to login page
           redirect('login', 'refresh');
         }
   }
    function __construct(  ) {
         parent::__construct();
        
    }
    /*function __destruct(){
        parent::__destruct();
    }*/
    
    function showTabs($link){
        if ($link!='') {
            $this->load->helper(array('url','form'));
         
            if($this->session->userdata('userData')){
                $logedUser  = $this->session->userdata('userData');
               $usuario = new Users();
               $userName = $usuario->setUpUser($logedUser['usuario'],$logedUser['pass']);
              
               $userAcces   = $usuario->getAcces();
               $groups      = $usuario->getGroups();
               $subGroups      = $usuario->getSubGroups();
               $data['user']      = $usuario->user;
               $data['logoEmpresa']=$usuario->logoEmpresa;
               $data['title']     = "Dashboards";
               $this->load->view('internalHeader_view',$data);
               $data['groups']    = $groups;
               $data['subGroups']    = $subGroups;
               $data['acces']      = $userAcces;
             //cargo las tabs para ese link 
                $tabs  = $usuario->getTabs($link); 
                $tabCharts  = $usuario->getChartsTab($link); 
                $data['templates'] = $tabs; 
               
             //open the dashboard container
                $this->load->view('dashboard_container_view',$data);
				$data['functions_charts'] =  array();
                //usada cuando quiero pasa las funciones al template y no al dashboars_close $dato['functions_charts'] =  array();
            //var_dump($tabs);
            $functions =  array();
               if (count($tabs) ){
					foreach( $tabs as $tab ){
							 // $functions =  array();
						 //  $data['functions_charts'] =  array();
						if(count($tabCharts)>0){
							foreach ($tabCharts as $chart) {
								if ($tab->idTab==$chart->idTab) {
									
								if($chart->titulo=='' || $chart->titulo==NULL){
									$titulo	=	'Grafico de Pruebas';
								}else{
									$titulo	= $chart->titulo;
								}
								$functionChart	= $chart->chartFunction."('".$chart->chart."','".$chart->connection."','".$chart->scriptSql."','".$chart->divToChart."','".$chart->chartTable."','".$titulo."',false,'".$chart->tabDrillDown."','".$chart->tooltipText."');";
									 $functions[]    = $tab->nombre.'|'.$functionChart;
								  //$data['functions_charts']   = $functions;
							}else{
									
								}
							}
							
							
							
							}else{$functionChart='';$functions='';}
						/*foreach ($tabCharts as $chart) {
								if ($tab->idTab==$chart->idTab) {
									
								if($chart->titulo=='' || $chart->titulo==NULL){
									$titulo	=	'Grafico de Pruebas';
								}else{
									$titulo	= $chart->titulo;
								}
								$functionChart	= $chart->chartFunction."('".$chart->chart."','".$chart->connection."','".$chart->scriptSql."','".$chart->divToChart."','".$chart->chartTable."','".$titulo."',false,'".$chart->tabDrillDown."');";
									 $functions[]    = $functionChart;
								  //$data['functions_charts']   = $functions;
							}else{
									
								}
							}
							*/
							//var_dump($functions);
						$dato['name'] = $tab->nombre;
						$dato['TabTitulo'] = $tab->titulo;
						//load the template
						//pasar las funciones al template $dato['functions_charts']   = $functions;
						$this->load->view($tab->template."_view",$dato);
					}
			$data['functions_charts']   = $functions;
			}else{
			
			}
        //close the dashboard container
                $this->load->view('dashboard_close_view',$data);
         }else{
            //Die('no se logeo');
           //If no session, redirect to login page
           redirect('login', 'refresh');
         }
        
        
        } else {
           redirect('dashboard', 'refresh'); 
        }
        
       
    
    }
}
?>
