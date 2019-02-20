<?php
include '../config/connection.php';

$response = [];
// session_start();
$custid = $_REQUEST['custid'];


$sql = "SELECT  contactId,contactAddress, contactNumber, country, CState, city, zipcode FROM ContactMaster WHERE contactId In(SELECT ContactId FROM PersonContact WHERE PersonId='$custid')";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_array($result);
$response['contactId'] = $row['contactId'];
$response['contactAddress'] = $row['contactAddress'];
$response['contactNumber'] = $row['contactNumber'];
$response['country'] = $row['country'];
$response['CState'] = $row['CState'];
$response['city'] = $row['city'];
$response['zipcode'] = $row['zipcode'];
mysqli_close($con);
exit(json_encode($response));
?>
