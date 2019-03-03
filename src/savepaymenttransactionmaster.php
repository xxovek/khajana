<?php
include '../config/connection.php';
session_start();
  $companyId = $_SESSION['company_id'];
  echo $companyId."\n";
  $formid = $_REQUEST['formid'];
  echo $formid."\n";
  $formtype = $_REQUEST['formtype'];
  echo $formtype."\n";
  $htransactionid = $_REQUEST['htransactionid'];
  echo $htransactionid."\n";
  $personId=$_REQUEST['customername'];
  echo $personId."\n";
  $amtreceivedpayment=$_REQUEST['amtreceivedpayment'];
  echo $amtreceivedpayment."\n";
  $transactionidarray=$_REQUEST['transactionidarray'];
  // print_r($transactionidarray)."\n";

  // echo count($transactionidarray)."\n";
  // echo $transactionidarray[0]."\n";
  // echo $transactionidarray[1]."\n";
  $amountpaymentarray=$_REQUEST['amountpaymentarray'];
  $paymentopenbalarray = $_REQUEST['paymentopenbalarray'];
  // print_r($amountpaymentarray)."\n";
  $paymentemailaddress=$_REQUEST['paymentemailaddress'];
  echo $paymentemailaddress."\n";
  $paymentrcpdate=$_REQUEST['paymentrcpdate'];
  echo $paymentrcpdate."\n";
  $paymentmethod=$_REQUEST['paymentmethod'];
  echo $paymentmethod."\n";
  $paymentReferenceno=$_REQUEST['paymentReferenceno'];
  echo $paymentReferenceno."\n";
  $paymentdepositeto=$_REQUEST['paymentdepositeto'];
  echo $paymentdepositeto."\n";
  $memopayment=$_REQUEST['memopayment'];
  echo $memopayment."\n";
  $spanamounttoapply=$_REQUEST['spanamounttoapply'];
  echo $spanamounttoapply."\n";
  $spanamounttocredit=$_REQUEST['spanamounttocredit'];
  echo $spanamounttocredit."\n";
  // echo $transactionid;
  // $personId = $_REQUEST['personId'];
  $phidecontactid = $_REQUEST['phidecontactid'];
  echo $phidecontactid."\n";
  $financialyear = Date('Y');
  echo $financialyear."\n";
  // if($contactId==0){
  //   $contactId="NULL";
  // }
    // echo $contactId;
  // $contactId = !empty($contactId) ? "'$contactId'" : "NULL";
  $sql1 = "SELECT TransactionNumber FROM TransactionMaster where companyId=$companyId and TransactionTypeId='$formid' ORDER BY TransactionId DESC LIMIT 1";
  $result1 = mysqli_query($con,$sql1);
  $TransactionNumber=0;
  if(mysqli_num_rows($result1)>0)
  {
      $row1 = mysqli_fetch_array($result1);
      $TransactionNumber = $row1['TransactionNumber']+1;
  }
  else
  {
     $TransactionNumber=1;
  }
  echo $TransactionNumber."\n";
  $transactionstatus = "Partial";
  if($amtreceivedpayment===$spanamounttoapply){
    $transactionstatus = "Closed";
  }
  if($spanamounttoapply<=0){
    $transactionstatus = "Unapplied";
  }
  echo $transactionstatus;
  $sql_insert = "INSERT INTO TransactionMaster(companyId,PersonId,contactId,TransactionTypeId,FinancialYear,TransactionNumber
    ,DateCreated,remarks,TransactionStatus
    ,ReferenceNumber,PaymentTypeId,AmountRecieved,AccountId) VALUES
  ($companyId,$personId,$phidecontactid,'$formid','$financialyear','$TransactionNumber','$paymentrcpdate','$memopayment','$transactionstatus','$paymentReferenceno','$paymentmethod','$amtreceivedpayment','$paymentdepositeto')";
  echo $sql_insert."\n";
  if(mysqli_query($con,$sql_insert)){
    $item_id = mysqli_insert_id($con);
    $response['msg'] = 'Inserted';
    $response['ItemDetailId'] =  $item_id;
    $lengthcount = count($transactionidarray);
    echo "length array".$lengthcount."\n";
    $sqlin = "INSERT INTO PaymentTransaction(TransactionId, TransactionId_P, Amount) VALUES";
    $i =0;
    for($i = 1;$i<$lengthcount;$i++){
      echo $transactionidarray[$i]."\n";
      echo $amountpaymentarray[$i]."\n";
      echo $paymentopenbalarray[$i]."\n";
    // $transactionid = "$transactionidarray[$i]";
    // echo $transactionid;
    // $amountpayment = $amountpaymentarray[$i];
    // echo $amountpayment;
     $sqlin .= '('.$transactionidarray[$i].','.$item_id.','.$amountpaymentarray[$i].')';
    }
    // echo $sqlin;

  }
  else
    {
    $response['msg'] = 'Server Error Please Try again';
  }
mysqli_close($con);
// exit(json_encode($response));
 ?>
