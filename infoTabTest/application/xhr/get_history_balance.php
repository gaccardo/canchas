<?php
//incluimos el archivo con las funciones
include('../includes/functionsPivot.php');

/*a continuacion extraemos los parametros enviados por ajax
 * almacenamos c/u en una variable php $miVariable para poder pasarsela a la funcion
 * que procesa la consulta sql,
 * los parametros se obtienen de la siguiente manera $_GET['miParametro'] donde 'miParametro'
 * el el nombre de la variable envida por url al ajax
 * */
 
$from_date=$_GET['from'];
$to_date=$_GET['to'];
$debtor=$_GET['debtor'];

$from = dma2Amd($from_date);
$to = dma2Amd($to_date);

$i=0; $amttot=0; $debitos=0; $creditos=0;
//a continuacion llamamos a la funcion que ejecuta la consulta en mysql y devuelve un recordest
//NOTA: tener la precaucion de actualizar los parametros que envia la funcion de acuerdo a los 
//que se reciben desde el archivo example.php
$result = get_debtor_trans_from_to($from_date, $to_date, $debtor);

//iteramos el recordset para crear el array en json que vamos a enviar
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
	//$row es un registro del recorset,
	//referenciamos a un elemento de row llamandolo por el nombre del campo que devolvio la consulta por ejemplo $row[Total_Amt]
	$amttot += $row[Total_Amt];
	
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
    //asignacion de los campos al arreglo
	$responce->d[$i][trans_no]=$row[trans_no];
    $responce->d[$i][type]=$row[type];
    $responce->d[$i][tran_date]=$row[tran_date];
    $responce->d[$i][due_date]=$row[due_date];
    $responce->d[$i][br_name]=$row[br_name];
    $responce->d[$i][debito]=$debito;
    $responce->d[$i][credito]=$credito;
    $responce->d[$i][amttot]=$amttot;
   // array($row[trans_no],$row[type],$row[tran_date],$row[due_date],$row[br_name],$debito,$credito,$amttot);
	$i++;
}
//luego de formar el arreglo lo codificamos a json para devolverlo al js
echo json_encode($responce);

?>
