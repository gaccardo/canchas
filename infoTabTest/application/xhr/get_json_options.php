<?php

//include('../includes/functions.php');
include('../includes/config.php');
//include('../libs/connection.php');
include('../libs/mysql.php');
//include('../libs/firebird.php');
$chart		=$_GET['chart'];
$datasource	=$_GET['datasource'];
$script		=$_GET['sql'];

$link = openConection();


//sql to get the chart params anf info
$sqlChart       = "SELECT * FROM charts WHERE nombre='$chart'";
$resultChart    = mysql_query($sqlChart,$link);
$row = mysql_fetch_array($resultChart,MYSQL_ASSOC);

//sql to get the datasource
$sqldatasource      = "SELECT user,passwd,driver,string,tipo FROM datasources WHERE nombre='$datasource'";
$resultdatasource   = mysql_query($sqldatasource,$link);
$rowdatasource      = mysql_fetch_array($resultdatasource,MYSQL_ASSOC);

//sql to get the script sql
$sqlscript      = "SELECT consulta FROM scripts WHERE nombre='$script'";
$resultscript   = mysql_query($sqlscript,$link);
$rowscript      = mysql_fetch_array($resultscript,MYSQL_ASSOC);

$tipo	= $rowdatasource['tipo'];
//$con = new $tipo ( $rowdatasource['string'], $rowdatasource['driver'],  $rowdatasource['user'], $rowdatasource['passwd'] );

$noCols =  array("id", "cols", "tpo", "nombre"); 	
$tipoChart =   "tpo";	 	 
$chartOptions   = '';
$dataSource     = $rowdatasource['string'].','.$rowdatasource['driver'].','.$rowdatasource['user'].','.$rowdatasource['passwd'];
$sql            = $rowscript['consulta'];
$chartOptions    = array();
foreach($row  as $key=>$value){
    if(in_array($key, $noCols )){
        if($key==$tipoChart){
			$grafico	=	$value;
		}
    }else{
        if($value!='' || $value!=NULL){
            //$options .= $key.':'.$value.',';
            //$chartOptions[] = $key.':'.$value;
            //$o[]  = array($key=>$value);
            //$options[] = $o;
            $chartOptions[$key]=$value;
        }
    }
}
$chart  = array('c'=>$chartOptions);
/*$chart  = array('b'=>$chartOptions);
$saraza = json_encode($chart);
echo '"'.addslashes($saraza).'"';*/

//$chartOptions	= implode(";",$chartOptions);
echo json_encode($chart);  
?>
