<?php

class JsonPivot_Model extends CI_Model {

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
        $chartOptions   = array();  
        $headerRowIndexes	=$rowOptions[0]['headerRowIndexes'];
        $headerColIndexes	=$rowOptions[0]['headerColIndexes'];
        $filterIndexes		=$rowOptions[0]['filterIndexes'];
        $dataColumnIndex	=$rowOptions[0]['dataColumnIndex'];
       /* foreach($rowOptions  as $k=>$v){
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
            
        }*/
        //$arreglo["p"]=$chartOptions;
       return $headerRowIndexes.'|'.$headerColIndexes.'|'.$filterIndexes.'|'.$dataColumnIndex;
        
        
    }
    function getData( $dbhost,$dbusuario,$dbpassword,$script ){
		$select	= null;
       try{
			$conn = new PDO($dbhost, $dbusuario, $dbpassword);
			$select = $conn->query($script);
		}catch(PDOException $e) {
			//echo 'Please contact Admin: '.$e->getMessage();
        }
                  
        return  $select;
    }
    
}
?>
