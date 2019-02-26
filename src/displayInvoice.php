<?php
include '../config/connection.php';
session_start();
$companyId = $_SESSION['company_id'];
$sql = "SELECT TM.TransactionId,PM.FirstName,PM.lastName,TM.DateCreated, COALESCE(TM.DueDate,'-') as DueDate,CONCAT(TM.FinancialYear,'-',TM.TransactionNumber) as InvoiceNumber,
(SUM(TD.qty*TD.rate)+(SUM(TD.qty*TD.rate*(IFNULL(TD.TaxPercent,0.00000001))*0.01))) AS TOTAL
 FROM TransactionMaster TM INNER JOIN TransactionDetails TD ON TD.TransactionId = TM.TransactionId
 LEFT JOIN PersonMaster PM ON PM.PersonId = TM.PersonId
 LEFT JOIN TransactionType TT ON TT.TransactionTypeId =TM.TransactionTypeId
 where TM.companyId = $companyId AND TM.TransactionTypeId =1
 GROUP BY TM.TransactionId,TT.TransactionTypeId";

$bal = 0;
$status = '-';
$response = [];
if($result = mysqli_query($con,$sql)or die(mysqli_error($con))){
  if(mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_array($result)){
      array_push($response,[
        'InvoiceNumber' => $row['InvoiceNumber'],
        'TId' => $row['TransactionId'],
        'Total' => $row['TOTAL'],
        'Balance' => $bal,
        'name' => ucwords($row['FirstName'].' '.$row['lastName']),
        'DateCreated' => $row['DateCreated'],
        'status' => $status,
        'DueDate' => $row['DueDate']
      ]);
    }
  }
}


mysqli_close($con);
exit(json_encode($response));
?>
