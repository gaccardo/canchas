<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get_Json_Grid extends CI_Controller {

    public function index()
    {
        
        $datasource = $_POST['datasource'];
        $source 	= "";
        $source 	= explode(',',$datasource);
        $dbhost 	= $source[0];
        $db     	= $source[1];
        $dbusuario  = $source[2];
        $dbpassword = $source[3];
        
        $script     = $_POST['sql'];
        $tipo       = $_POST['tipo'];
		$desde		= ( isset($_POST['desde']) ) ? $_POST['desde'] : null;
        $hasta		= ( isset($_POST['hasta']) ) ? $_POST['hasta'] : null;
        $idSucu		= ( isset($_POST['sucursal']) ) ? $_POST['sucursal'] : null;
        if($desde!=null && $hasta!=null && $idSucu!=null){
			$desde	= substr($desde, 6, 4)."-".substr($desde, 3, 2)."-".substr($desde, 0, 2);
			$hasta	= substr($hasta, 6, 4)."-".substr($hasta, 3, 2)."-".substr($hasta, 0, 2);
			//$where	= "WHERE  fecha<='".$hasta."' and fecha>='".$desde."' and t.id_sucursal=''1'' ";
			$patron1	= '{$desde}';
			$patron2	= '{$hasta}';
			$patron3	= '{$idSucu}';
			$script = str_replace($patron1,$desde,$script);
			$script = str_replace($patron2,$hasta,$script);
			$script = str_replace($patron3,$idSucu,$script);
			/*$script	= preg_replace($patron1, $desde, $script);
			$script	= preg_replace($patron2, $hasta, $script);
			$script	= preg_replace($patron3, $idSucu, $script);*/
			 //var_dump($script);
			
		}else{
		
		}
		//var_dump($script);
        $select   	= $this->obtainData($dbhost, $dbusuario, $dbpassword, $script);
        $i  = 0;
        $ingreso	= 0;
        $egreso		= 0;
        //cargo los values de las que van representar las columnas o barras
        while($rows = $select->fetch(PDO::FETCH_ASSOC)) {//$rows = mysql_fetch_array($result,MYSQL_ASSOC)
        
            //guardo un arrego para despues armar las columas
            
            $registro   = array();
            $j=0;
            foreach($rows  as $key=>$value){
               // $registro[$key] = $value;  
                $registro[$j] = $value;
                if($key=="ingreso"){
					$ingreso+=$value;
				}
				if($key=="egreso"){
					$egreso+=$value;
				}
                $j++;  
                
            }
            $responce->rows[$i]['cell']=$registro;
            $i++;
           
        }
       
		$responce->page = 1;
		$responce->total = 10;
		$responce->records = 50;
		$responce->userdata['ingreso'] = $ingreso;
		$responce->userdata['egreso'] = $egreso;
		$responce->userdata['name'] = 'Ingreso:';
       echo json_encode($responce);
      
  
    }

    function __construct(  ) {
         parent::__construct();
       $this->load->model('jsongrid_model','',TRUE); 
    }
    function obtainChart($chart){
      
        if ($chart!='') {
            $charts = $this->jsongrid_model->getChart($chart);
        }else{
            $charts = "";
        }
        return $charts; 
        
    }
    
    function obtainData($dbhost,$dbusuario,$dbpassword,$script){
         $result =   $this->jsongrid_model->getData( $dbhost,$dbusuario,$dbpassword,$script );
        return $result; 
    }
    
    
}  
