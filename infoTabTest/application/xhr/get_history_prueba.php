<?php

include('../includes/functions.php');
//from=01-01-1990&to=16-04-2012&debtor=1&arrCheck=1,2,3,4,5&&rows=100&page=1&sidx=tran_date&sord=asc
$from_date='01-01-1990';//$_GET['from'];
$to_date='16-04-2012';//$_GET['to'];
$debtor=1;//$_GET['debtor'];
$arrCheck	= '1,2,3,4,5';//$_GET['arrCheck'];
$arrCheck	= explode(',',$arrCheck);
$page = 1;//$_REQUEST['page']; // get the requested page
$limit = ( isset($_REQUEST['rows']) ) ? $_REQUEST['rows'] : 100; //$_REQUEST['rows'];// get how many rows we want to have into the grid
$sidx = 'tran_date';//$_REQUEST['sidx']; // get index row - i.e. user click to sort
$sord = 'asc';//$_REQUEST['sord']; // get the direction


$link = openConection2();
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

$i=0; $amttot=0; $debitos=0; $creditos=0;

$result = get_debtor_trans_from_to($from_date, $to_date, $debtor,$sidx,$sord,$start, $limit,$arrCheck);

$tabla = "";
//antes....
//$responce[$i]=array("comprobante","tipo","fecha","fecha","fec_venc","cliente","debito","credito","total");

//este ejemplo funciona

$arreglo    = array(
                "cols" => array(array(id=>'tran_date', label=>'tran_date', type=> 'string'),
                    array(id=> 'debito', label=> 'debito', type=> 'number'),
                    array(id=> 'credito', label=> 'credito', type=> 'number'),
                    array(id=> 'total', label=> 'total', type=> 'number')),
                "rows"=> array()
);
$i++;

while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
	$amttot += $row[Total_Amt];
	
	//$responce->rows[$i]['trans_no'] = $row[trans_no];
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
	
    //ANERIORMENTE CON MI DESAGReGADOR DE JSON ESTE ANDA
    /*
	$responce->d[$i][trans_no]=$row[trans_no];
    $responce->d[$i][type]=$row[type];
    $responce->d[$i][tran_date]=$row[tran_date];
    $responce->d[$i][due_date]=$row[due_date];
    $responce->d[$i][br_name]=$row[br_name];
    $responce->d[$i][debito]=$debito;
    $responce->d[$i][credito]=$credito;
    $responce->d[$i][amttot]=$amttot;*/
    
    $a[]  = array(c=>array(array(v=>$row[tran_date]),array(v=>$debito),array(v=>$credito),array(v=>$amttot)));  
   
	$i++;
}
$arreglo["rows"] = $a;
//luego de formar el arreglo lo codificamos a json para devolverlo al js

echo json_encode($arreglo);

?>
