<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get_Json_Pivot extends CI_Controller {

    public function index()
    {
        
        $datasource = $_POST['datasource'];
        $source = "";
        $source = explode(',',$datasource);
        $dbhost = $source[0];
        $db     = $source[1];
        $dbusuario  = $source[2];
        $dbpassword = $source[3];
        
        $script     = $_POST['sql'];
        //$tipo       = $_POST['tipo'];
               
        $select   = $this->obtainData($dbhost, $dbusuario, $dbpassword, $script);
       //cargo los values de las que van representar las columnas o barras
       if ($select) {
		   /*to pivot*/
		   $i	= 0;
			//cargo los values de las que van representar las columnas o barras
			while($rows = $select->fetch(PDO::FETCH_ASSOC)) {
				//guardo un arreglo para despues armar las columas
				if ($i==0){
					$row[]	= $rows;
				}

				foreach($rows  as $key=>$value){
					 //asignacion de los campos al arreglo
					$responce->d[$i][$key]=$value;
				}
				$i++;
				
			}
		}else{
			$responce="saracatunga";
		}	   /*to pivot*/
      echo json_encode($responce);
  
    }

    function __construct(  ) {
         parent::__construct();
       $this->load->model('jsonpivot_model','',TRUE); 
    }
    /*desde ajax se debe llamar a esta funcion directamente como en completionChart
     * y devuelve las opciones separadas por |*/
    function obtainChart(){
		/*to set the options*/
        $chart      = $_POST['chart'];
        $table		= $_POST['table'];
        if ($chart!='') {
            $charts = $this->jsonpivot_model->getChart($chart,$table);
        }else{
            $charts = "";
        }
        echo $charts; 
        
    }
    
    function obtainData($dbhost,$dbusuario,$dbpassword,$script){
         $result =   $this->jsonpivot_model->getData( $dbhost,$dbusuario,$dbpassword,$script );
        return $result; 
    }
    
}  
