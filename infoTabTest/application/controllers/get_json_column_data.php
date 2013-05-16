<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get_Json_Column_Data extends CI_Controller {

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
        
        /*to set the options*/
       // $chart      = $_POST['chart'];
        //$table		= $_POST['table'];
        //arreglos para comprobaciones de tipos de datos
        $typeArray  = array("double","int","real","float","decimal");
        $numerosArray   =  array("0","1","2","3","4","5","6","7","8","9");
        // Patrón para usar en expresiones regulares (admite letras acentuadas y espacios):
        $patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/";
        $patron_numero  = "/^[[:digit:]]+$/";//"/^ [0-9 ]*$/";
        //traigo los datos propiamente dichos para generar el grafico
        $select   = $this->obtainData($dbhost, $dbusuario, $dbpassword, $script);
       
        $arreglo    = array(
						"categories" => array(),
						"series"=> array()
						);

		$categories	= array();
		$i=0;
        //cargo los values de las que van representar las columnas o barras
        while($rows = $select->fetch(PDO::FETCH_ASSOC)) {//$rows = mysql_fetch_array($result,MYSQL_ASSOC)
			//var_dump($rows);
			$series[]	=	$rows;
            //guardo un arrego para despues armar las columas
            if ($i==0){
                $row[]  = $rows;
            }
            /*
            foreach($rows  as $rowSeries){// $key=>$value
                  $series[]	=array('name'=>$rowSeries, 'data'=>$rowSeries);     
            }*/
            
        }
       
        $i  = 0;
        //bucle para armar las columnas con sus tipos de datos
        //recorro el arreglo guardado en el paso anterior y armo las columnas
        foreach($row[0]  as $key=>$value){
            //$typeField   =  $select->getColumnMeta($i);
           //seteo los tipos de datos de las columnas, los graficos aceptan una sola columna en tipo string
            $type   ="";
            $type   = gettype($value);
            //echo $value;
            if( preg_match($patron_numero, $value) ){
                   //echo "va a ser un numero";
                   $type    = "number";
            }else{
                $type    = "string";
            }
              //if( preg_match($patron_numero, $value) ){
            if(in_array($type, $typeArray )){
               $type    = "number";
            }else{
                
            }
            $categories[$i] = $key;
            //var_dump($type);
            //echo "tipo de dato columna".$i."-->".$type." key->".$key;
            $columnas[] = array('id'=>$key, 'label'=>$key, 'type'=> $type);
            $i++;
        }
        $arreglo["categories"]=$categories;
		$arreglo["series"]=$series; 
        echo json_encode($arreglo);
  //var_dump($rowdatasource);
    }

    function __construct(  ) {
         parent::__construct();
       $this->load->model('jsoncolumndata_model','',TRUE); 
    }
    function obtainChart($chart,$table){
      
        if ($chart!='') {
            $charts = $this->jsoncolumndata_model->getChart($chart,$table);
        }else{
            $charts = "";
        }
        return $charts; 
        
    }
    
    function obtainData($dbhost,$dbusuario,$dbpassword,$script){
         $result =   $this->jsoncolumndata_model->getData( $dbhost,$dbusuario,$dbpassword,$script );
        return $result; 
    }
    
}  
