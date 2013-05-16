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
//arreglos para comprobaciones de tipos de datos
$typeArray  = array("double","int","real","float","decimal");
$numerosArray   =  array("0","1","2","3","4","5","6","7","8","9");

$conn = new PDO($dbhost, $dbusuario, $dbpassword);
$select = $conn->query($script);

//$stmt = $conn->query("select * from Person.ContactType");
//$metadata = $select->getColumnMeta(1);
//var_dump($metadata);
//$link = openConn($dbhost, $db, $dbusuario, $dbpassword);
//$result    = mysql_query($script,$link);


$i  = 0;
$arreglo    = array(
                "cols" => array(),
                "rows"=> array()
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
        foreach( $numerosArray as $numero ){
        $resultado = strpos($value, $numero);
            if($resultado !== FALSE){
               settype($value, "integer");
            }
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
    foreach( $numerosArray as $numero ){
        $resultado = strpos($value, $numero);
        if($resultado !== FALSE){
           $type    = "number";
        }
    }
	//$type   = mysql_field_type($result, $i);
    if(in_array($type, $typeArray )){
       $type    = "number";
    }else{
        
    }
	//echo "tipo de dato columna".$i."-->".$type." key->".$key;
	$columnas[] = array(id=>$key, label=>$key, type=> $type);
	$i++;
}
$arreglo["cols"]    = $columnas;


echo json_encode($arreglo);
?>
