<?php

class JsonColumnData_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
   
   function getChart($chart,$table){
	   //echo $chart;
       $sqlChart = $this->db->query('SELECT * FROM '.$table.' WHERE nombre="'.$chart.'"');
        if($sqlChart->num_rows>0){
           $rowOptions = $sqlChart->result() ;
         }else{
           $row = NULL;      
         }
         $noCols =  array("id", "cols", "tpo", "nombre");   
        $tipoChart =   "tpo";  
        $chartOptions	= array();  
        
        foreach($rowOptions  as $k=>$v){
			foreach($v as $key=>$value){
				
				if(in_array($key, $noCols )){
					if($key==$tipoChart){
						$grafico    =   $value;
					}
				}else{
					if($value!='' || $value!=NULL){
					   $chartOptions[$key]=$value;
					}
				}
					
				}
			
        }
        //$arreglo["p"]=$chartOptions;
       return $chartOptions;
        
        
    }
    function getData( $dbhost,$dbusuario,$dbpassword,$script ){
       try{
        $conn = new PDO($dbhost, $dbusuario, $dbpassword);
        }catch(PDOException $e) {
        echo 'Please contact Admin: '.$e->getMessage();
        }
              
        $select = $conn->query($script);
        
        return  $select;
    }
    
}
?>
