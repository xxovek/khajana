<?php
include '../config/connection.php';
session_start();
$companyId = $_SESSION['company_id'];

$scheme=$_REQUEST['scheme'];
$from=$_REQUEST['from'];
$upto=$_REQUEST['upto'];
$item=$_REQUEST['item'];
$onpurchase=$_REQUEST['onpurchase'];
$freeqty=$_REQUEST['freeqty'];

$response=[];
if(!empty($_REQUEST['sId']))
{
  $sId=$_REQUEST['sId'];
  $sql_insert = "UPDATE SchemeMaster SET schemeType='$scheme',FromDate='$from',UptoDate='$upto',ItemDetailId='$item',OnPurchase='$onpurchase'
  ,freeQty='$freeqty'  WHERE SchemeId=$sId";
   if(mysqli_query($con,$sql_insert)){
     $response['msg'] = 'Scheme '.$scheme.' Updated Successfully';
   }else {
     $response['msg'] = 'Server Error Please Try again';
   }
}
else {
    $sql_insert = "INSERT INTO SchemeMaster(companyId,schemeType,FromDate,UptoDate,ItemDetailId,OnPurchase,freeQty)
     VALUES($companyId,'$scheme','$from','$upto','$item','$onpurchase','$freeqty')";
     if(mysqli_query($con,$sql_insert)){
       $response['msg'] = ' New  '.$scheme.' Scheme Added Successfully';
     }else {
       $response['msg'] = 'Server Error Please Try again';
     }
}

mysqli_close($con);
exit(json_encode($response));
 ?>
