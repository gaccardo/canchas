<?php

include('../includes/functionsGrilla.php');

$from_date=$_GET['from'];
$to_date=$_GET['to'];
$debtor=$_GET['debtor'];
$arrCheck	= $_GET['arrCheck'];
$arrCheck	= explode(',',$arrCheck);
$page = $_REQUEST['page']; // get the requested page
$limit = ( isset($_REQUEST['rows']) ) ? $_REQUEST['rows'] : 100; //$_REQUEST['rows'];// get how many rows we want to have into the grid
$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
$sord = $_REQUEST['sord']; // get the direction


$link = openConection();
$from = dma2Amd($from_date);
$to = dma2Amd($to_date);

//sql to count and calculate limits and pages
$sql = "SELECT COUNT(*) AS count FROM 0_debtor_trans WHERE 0_debtor_trans.debtor_no='$debtor'";
if ($from_date != "")
		$sql .= "  AND 0_debtor_trans.tran_date > '$from'";
if ($to_date != "")
	$sql .= "  AND 0_debtor_trans.tran_date < '$to'";
    $sql .= "  AND ( ";
foreach($arrCheck as  $filtro){
		switch( $filtro ){
			case '1':
				
				$arrayOR[] = "  (0_debtor_trans.type = 10) ";  
                 $all = '0';
			break;
			case '2':
				
				$arrayOR[] = "  (0_debtor_trans.type = 13) ";
                 $all = '0';
			break;
			case '3':
				
				$arrayOR[] = " (0_debtor_trans.type = 12 OR 0_debtor_trans.type = 2 OR 0_debtor_trans.type = 1) ";
                 $all = '0';
			break;
			case '4':
				
				$arrayOR[] = "  (0_debtor_trans.type = 11) ";
                 $all = '0';
			break;
			case '5':
                $order = "0_debtor_trans.tran_date";
               // var_dump($order);
                $sql = "SELECT COUNT(*) AS count
                   from 0_debtor_trans
                  WHERE 0_debtor_trans.debtor_no='$debtor'";
                if ($from_date != "")
                    $sql .= "  AND 0_debtor_trans.tran_date > '$from'";
                if ($to_date != "")
                    $sql .= "  AND 0_debtor_trans.tran_date < '$to'";
                //$sql .= "group by 0_debtor_trans.trans_no,0_debtor_trans.type order by ".$order." LIMIT $start , $limit;";
				//$result = mysql_query($sql);
                $all = '1';
			break;
			default:
				$sql .= " ";
			
        }
}
if($all=='1'){
  
}else{
    $or = implode(" OR ",$arrayOR);	
    $sql.= $or . ")"; 
}
//var_dump($sql);
        
$result = mysql_query($sql);
$row    = mysql_fetch_array($result,MYSQL_ASSOC);
$count  = $row['count'];
if( $count >0 ) {
	$total_pages = ceil($count/$limit);
} else {
	$total_pages = 0;
}
if ($page > $total_pages) $page=$total_pages;
$start = $limit*$page - $limit; // do not put $limit*($page - 1)
if ($start<0) $start = 0;

$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;
$i=0; $amttot=0; $debitos=0; $creditos=0;

$result = get_debtor_trans_from_to($from_date, $to_date, $debtor,$sidx,$sord,$start, $limit,$arrCheck);

$tabla = "";


while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
	$amttot += $row[Total_Amt];
	
	$responce->rows[$i]['trans_no'] = $row[trans_no];
    //the debito and credito fields
    if($row["Total_Amt"]<=0){
            $credito = abs($row["Total_Amt"]);
            $creditos+=$credito ;
            $debito = 0;
                      
    }elseif($row["Total_Amt"]>=0){
            $credito =0;
            $debito = $row["Total_Amt"];
            $debitos+=$debito;
    }else{
        
    }
    switch( $row[type] ){
			case '1':
				$tipo = " Transferencia Bancaria";
			break;
			case '2':
				$tipo = " Deposito Bancario";
			break;
			case '10':
				$tipo = " Factura";
			break;
			case '11':
				$tipo = " Nota de Credito";
			break;
			case '12':
				$tipo = " Pago";
			break;
			case '13':
				$tipo = " Remito";
			break;
	}
	
	$responce->rows[$i]['cell']=array($row[trans_no],$tipo,$row[tran_date],$row[due_date],$row[br_name],$debito,$credito,$amttot);
	$i++;
}

$responce->userdata['debitos'] = $debitos;
$responce->userdata['creditos'] = $creditos;
$responce->userdata['saldo'] = $amttot;
$responce->userdata['name'] = 'Totals:';
echo json_encode($responce);
    
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

