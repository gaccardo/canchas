<?php
include('../includes/config.php');

$datasource	= $_GET['datasource'];
$source = "";
$source = explode(',',$datasource);
$dbhost = $source[0];
$db     = $source[1];
$dbusuario  = $source[2];
$dbpassword = $source[3];

$script		= $_GET['sql'];
$tipo       = $_GET['tipo'];

/*to set the options*/
$chart		=$_GET['chart'];
$link = openConection();
//arreglos para comprobaciones de tipos de datos
$typeArray  = array("double","int","real","float","decimal");
$numerosArray   =  array("0","1","2","3","4","5","6","7","8","9");
// Patrón para usar en expresiones regulares (admite letras acentuadas y espacios):
$patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/";
$patron_numero	= "/^[[:digit:]]+$/";//"/^ [0-9 ]*$/";
$conn = new PDO($dbhost, $dbusuario, $dbpassword);

$select = $conn->query($script);

$i  = 0;
$arreglo    = array(
                "cols" => array(),
                "rows"=> array(),
                "p"=>array()
               );
$i	= 0;
//cargo los values de las que van representar las columnas o barras
while($rows = $select->fetch(PDO::FETCH_ASSOC)) {//$rows = mysql_fetch_array($result,MYSQL_ASSOC)

	//guardo un arrego para despues armar las columas
    if ($i==0){
		$row[]	= $rows;
	}
	$v="";
	foreach($rows  as $key=>$value){
        //me fijo que mierda es y si llega a tener un numero lo paso a entero
        if( preg_match($patron_numero, $value) ){
		   //echo "va a ser un numero";
		   settype($value, "integer");
		}else{
			
		}
               
        //cargo el primer arreglo de valores
		$v[]  = array(v=>$value);
	}
		
	$a[]  = array(c=>$v);
	$arreglo["rows"]=$a;
}
$a[]  = array(c=>$v);


$i	= 0;
//bucle para armar las columnas con sus tipos de datos
//recorro el arreglo guardado en el paso anterior y armo las columnas
foreach($row[0]  as $key=>$value){
	//$typeField   =  $select->getColumnMeta($i);
   //seteo los tipos de datos de las columnas, los graficos aceptan una sola columna en tipo string
    $type	="";
    $type	= gettype($value);
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
	
	//var_dump($type);
	//echo "tipo de dato columna".$i."-->".$type." key->".$key;
	$columnas[] = array(id=>$key, label=>$key, type=> $type);
	$i++;
}
$arreglo["cols"]    = $columnas;

//sql to get the chart params anf info
$sqlChart       = "SELECT * FROM charts WHERE nombre='$chart'";
$resultChart    = mysql_query($sqlChart,$link);
$rowOptions = mysql_fetch_array($resultChart,MYSQL_ASSOC);
$noCols =  array("id", "cols", "tpo", "nombre"); 	
$tipoChart =   "tpo";	 
foreach($rowOptions  as $key=>$value){
    if(in_array($key, $noCols )){
        if($key==$tipoChart){
			$grafico	=	$value;
		}
    }else{
        if($value!='' || $value!=NULL){
           $chartOptions[$key]=$value;
        }
    }
}
$arreglo["p"]=$chartOptions;

echo json_encode($arreglo);
?>
