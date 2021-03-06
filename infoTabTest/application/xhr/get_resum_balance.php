<?php

include('../includes/functionsGrilla.php');

$from_date	= $_GET['from'];
$to_date	= $_GET['to'];
$debtor		= $_GET['debtor'];
$arrCheck	= $_GET['arrCheck'];
$arrCheck	= explode(',',$arrCheck);
$page = $_REQUEST['page']; // get the requested page
$limit = ( isset($_REQUEST['rows']) ) ? $_REQUEST['rows'] : 10; //$_REQUEST['rows'];// get how many rows we want to have into the grid
$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
$sord = $_REQUEST['sord']; // get the direction


$link = openConection();
$from = dma2Amd($from_date); //substr($from_date, 6, 4)."-".substr($from_date, 3, 2)."-".substr($from_date, 0, 2);
$to = dma2Amd($to_date);//substr($to_date, 6, 4)."-".substr($to_date, 3, 2)."-".substr($to_date, 0, 2);

//sql to count and calculate limits and pages
$sql = "SELECT COUNT(*) AS count FROM 0_debtor_trans WHERE 0_debtor_trans.debtor_no='$debtor'";
if ($from_date != "")
		$sql .= "  AND 0_debtor_trans.tran_date > '$from'";
if ($to_date != "")
	$sql .= "  AND 0_debtor_trans.tran_date < '$to'";
		
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

$result = get_debtor_trans_resum_from_to($from_date, $to_date, $debtor,$start, $limit,$arrCheck);
if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
header("Content-type: application/xhtml+xml;charset=utf-8"); } else {
header("Content-type: text/xml;charset=utf-8");
}
$et = ">";
echo "<?xml version='1.0' encoding='utf-8'?$et\n";

echo "<rows>";
echo "<page>".$page."</page>";
echo "<total>".$total_pages."</total>"; 
echo "<records>".$count."</records>";
$currTrans = 0;
// be sure to put text data in CDATA
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
    if($row[saldo]<>0){
        $amttot += $row[saldo];
       
        switch( $row[type] ){
                case '1':
                    $tipo = " Transferencia Bancaria";
                    $total = ($row[total]*(-1));
                break;
                case '2':
                    $tipo = " Deposito Bancario";
                    $total = ($row[total]*(-1));
                break;
                case '10':
                    $tipo = " Factura";
                    $total = $row[total];
                break;
                case '11':
                    $tipo = " Nota de Credito";
                    $total = ($row[total]*(-1));
                break;
                case '12':
                    $tipo = " Pago";
                    $total = ($row[total]*(-1));
                break;
                case '13':
                    $tipo = " Remito";
                    $total = $row[total];
                break;
        }
        echo "<row id='".$row[trans_no]."_".$row[type]."'>";			
        echo "<cell>". $row[trans_no]."</cell>";
        echo "<cell>". $tipo."</cell>";
        echo "<cell>". $row[tran_date]."</cell>";
        echo "<cell>". $row[due_date]."</cell>";
        echo "<cell><![CDATA[". $row[br_name]."]]></cell>";
        echo "<cell>". $total."</cell>";
        echo "<cell>". $row[saldo]."</cell>";
        echo "<cell>". $amttot."</cell>";
        echo "</row>";
    }
}
echo "</rows>";		
?>
