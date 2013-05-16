<?php

include('../includes/functionsGrilla.php');
$debtor=$_GET['debtor'];
$trans_no = $_GET['trans_no'];
$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
$sord = $_REQUEST['sord']; // get the direction
$arrCheck	= $_GET['arrCheck'];
$arrCheck	= explode(',',$arrCheck);
$saldo  = $_REQUEST['saldo'];
$tipo   = $_REQUEST['tipo'];
$link = openConection();


$result = get_detail_alloc_from_trans($trans_no, $debtor,$tipo,$arrCheck, $sidx, $sord );

if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
header("Content-type: application/xhtml+xml;charset=utf-8"); } else {
header("Content-type: text/xml;charset=utf-8");
}
$et = ">";
echo "<?xml version='1.0' encoding='utf-8'?$et\n";
echo "<rows>";
// be sure to put text data in CDATA
$amttot = $saldo;
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
    
    
    switch( $row[type] ){
                case '1':
                    $tipoD = " Transferencia Bancaria";
                    $amttot -= $row[alloc];
                    $debito = $row[alloc];
                break;
                case '2':
                    $tipoD = " Deposito Bancario";
                    $amttot -= $row[alloc];
                    $debito = $row[alloc];
                break;
                case '10':
                    $tipoD = " Factura";
                    $amttot += $row[alloc];
                    $credito = $row[alloc];
                break;
                case '11':
                    $tipoD = " Nota de Credito";
                    $amttot -= $row[alloc];
                    $debito = $row[alloc];
                break;
                case '12':
                    $tipoD = " Pago";
                    $amttot -= $row[alloc];
                    $debito = $row[alloc];
                break;
                case '13':
                    $tipoD = " Remito";
                    $amttot += $row[alloc];
                    $credito = $row[alloc];
                break;
        }
        
	echo "<row>";			
	echo "<cell>". $row[trans_no]."</cell>";
    /*if($row["Total_Amt"]<=0){
            $credito = abs($row["Total_Amt"]);
            $creditos+=$credito ;
            $debito = 0;
                      
    }elseif($row["Total_Amt"]>=0){
            $credito =0;
            $debito = $row["Total_Amt"];
            $debitos+=$debito;
    }else{
        
    }*/
    
	echo "<cell>". $tipoD."</cell>";
    echo "<cell>". $row[tran_date]."</cell>";
    echo "<cell>". $row[due_date]."</cell>";
    echo "<cell><![CDATA[". $row[br_name]."]]></cell>";
	echo "<cell>".$credito."</cell>";
	echo "<cell>". $debito."</cell>";
	echo "<cell>". $amttot."</cell>";
	echo "</row>";
}
echo "</rows>";		

    
/*
 * 
 * metodologia
 * voy a traer todas las transacciones del cliente con la consulta con la que arme la vista,
 * me va a mostrar un campo Total_amt con signos + o - ademas de la data del cliente
 * despues con un bucle while, voy acumulando ese campo asi
 * while ($myrow = db_fetch($result))
	{zaraza....zaraza
	* $running_total += $myrow["total_amt"];
	* }
	* con eso tengo el alance por registros
	* para obtener el balance total uso la funcion get_debtor_balance_from_to()
	* que lo unico que devuelve es la suma de esos valores, es decir 
	* un solo valor que es balance final
 * 
 * 
 * */
?>

