<?php
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

function company_info()
{
  include '../config/connection.php';
  $invoice_number = $_REQUEST['tid'];

  $sql1 = "SELECT * FROM `TransactionMaster` WHERE TransactionId='$invoice_number'";
  $result1 = mysqli_query($con,$sql1);
  $row1 = mysqli_fetch_array($result1);
  $cId=$row1['companyId'];
  $uid=$row1['PersonId'];
  $sql = "SELECT companyName,contactAddress,contactNumber,country,CState, city,zipcode,logo FROM
   `CompanyMaster` cm,`ContactMaster` c WHERE cm.`contactId`=c.`contactId` AND cm.`CompanyId`='$cId'";
   $sql_person = "SELECT * FROM PersonMaster PM  LEFT JOIN PersonContact PC ON PC.PersonId = PM.PersonId LEFT JOIN ContactMaster CM ON CM.contactId = PC.ContactId
  WHERE PM.PersonId = $uid AND CM.AddressId=1";
   $sql_cust =mysqli_query($con, $sql_person);
  $response = [];
  if($result = mysqli_query($con,$sql)){
    if(mysqli_num_rows($result)>0){
      $row = mysqli_fetch_array($result);
      $row_cust = mysqli_fetch_array($sql_cust);

      $sql_shipaddr =mysqli_query($con, "SELECT * FROM PersonMaster PM  LEFT JOIN PersonContact PC ON PC.PersonId = PM.PersonId LEFT JOIN ContactMaster CM ON CM.contactId = PC.ContactId WHERE PM.PersonId = $uid AND CM.AddressId=2");
      $row_shipaddr = mysqli_fetch_array($sql_shipaddr);

  $person='';
  $person.=' <tr>
    <td width="100%">
    <table width="100%" cellspacing="0" cellpadding="0">
    <tr>
    <td width="50%" style="border-top:1px solid; height:100px; padding-left:10px;" valign="top">
    <!-- Invoice Details -->
    <table>
    <tr>
    <td style="height:25px;"><strong>Invoice Number : </strong>'.$row1['FinancialYear'].'-'.$row1['TransactionNumber'].' </td>
    </tr>
    <tr>
    <td style="height:25px;"><strong>'.ucwords($row['companyName']).'.</strong></td>
    </tr>
    <tr>
    <td style="height:25px;">'.$row['contactAddress'].'<br>'.$row['country'].',' .$row['CState'].','.$row['city'].','.$row['zipcode'].'<br>'.$row['contactNumber'].'</td>
    </tr>

    </table>
    <!-- Invoice Details -->
    </td>
    <td width="50%" style="border-top:1px solid; padding-left:10px;" valign="top">
    <!-- Invoice Other Details -->
    <table >
    <tr>
    <td style="height:20px;"><strong>Invoice Date : </strong></td>
    <td>'.date('M d, Y', strtotime($row1['DateCreated'])).'</td>
    </tr>
    <tr>
    <td style="height:20px;"><strong>Due Date : </strong>  </td>
    <td>'.date('M d, Y', strtotime($row1['DueDate'])).'</td>
    </tr>
    </table>
    <!-- Invoice Other Details -->
    </td>
    </tr>
    </table>
    </td>
    </tr>

    <tr>
    </tr>
    </table>
    </td>
    </tr>

    <tr>
    <td width="100%">
    <table width="100%" cellspacing="0" cellpadding="0">
    <tr>
    <td width="50%" style="border-top:1px solid; height:100px; padding-left:10px;" valign="top">
    <!-- Invoice Details -->
    <table>
    <tr>
    <td ><strong>Billed To:</strong></td>
    </tr>
    <tr>
    <td style="height:25px;"><strong>'.ucwords($row_cust['FirstName'].' '.$row_cust['lastName']).'.</strong> </td>
    </tr>
    <tr>
    <td style="height:25px;">'.$row_cust['contactAddress'].'<br>'.$row_cust['country'].',' .$row_cust['CState'].','.$row_cust['city'].','.$row_cust['zipcode'].'<br>'  .$row_cust['EmailId'].'<br>'. $row_cust['contactNumber'].'</td>
    </tr>

    </table>
    <!-- Invoice Details -->
    </td>
    <td width="50%" style="border-top:1px solid; padding-left:10px;" valign="top">
    <!-- Invoice Other Details -->';
    if(mysqli_num_rows($sql_shipaddr)>0)
    {
      $row_cust['contactAddress']=$row_shipaddr['contactAddress'];
      $row_cust['country']=$row_shipaddr['country'];
      $row_cust['CState']=$row_shipaddr['CState'];
      $row_cust['city']=$row_shipaddr['city'];
      $row_cust['zipcode']=$row_shipaddr['zipcode'];
    }
    $person.='<table >
    <tr>
    <td ><strong>Shipped To:</strong></td>
    </tr>
    <tr>
    <td style="height:25px;"><strong>'.ucwords($row_cust['FirstName'].' '.$row_cust['lastName']).'.</strong> </td>
    </tr>
    <tr>
    <td style="height:25px;">'.$row_cust['contactAddress'].'<br>'.$row_cust['country'].',' .$row_cust['CState'].','.$row_cust['city'].','.$row_cust['zipcode'].'<br>'  .$row_cust['EmailId'].'<br>'. $row_cust['contactNumber'].'</td>
    </tr>
    </table>';
  }
}
    return $person;
    // echo $person;
}
function notes(){
  $invoice_number = $_REQUEST['tid'];
  include '../config/connection.php';
$note='';

  $sql = "SELECT * FROM `TransactionMaster` WHERE TransactionId='$invoice_number'";
  $response = [];
  if($result = mysqli_query($con,$sql)){
    if(mysqli_num_rows($result)>0){
      $row = mysqli_fetch_array($result);
      $note.=$row['remarks'].'<br>';
    }
  }

  return $note;
}
function fetch_Items(){
  $invoice_number = $_REQUEST['tid'];
  include '../config/connection.php';

  $sql="SELECT IDM.ItemId,IM.ItemName,SM.SizeValue,IM.Unit,TD.rate, TD.itemDetailId,TD.qty,TD.TaxType,TD.TaxPercent,TM.discount,IFNULL(TD.discountAmount,0) as discountAmount,TD.description,TM.TransactionId,TM.FinancialYear,TM.TransactionNumber,TM.DueDate,TM.DateCreated,TM.PersonId,TM.contactId
   FROM TransactionDetails TD LEFT JOIN TransactionMaster TM ON TM.TransactionId = TD.TransactionId
  LEFT JOIN ItemDetailMaster IDM ON IDM.itemDetailId = TD.itemDetailId
  LEFT JOIN ItemMaster IM ON IM.ItemId = IDM.ItemId
  LEFT JOIN   SizeMaster SM ON SM.SizeId = IDM.sizeId
  WHERE  TM.TransactionId =  $invoice_number";
  $response = [];
  $itemtable='';
$i=0;
  if($result = mysqli_query($con,$sql)){
    if(mysqli_num_rows($result)>0){
      while($row = mysqli_fetch_array($result))
      {
        $total=($row['qty']*$row['rate'])-(($row['qty']*$row['rate'])*(($row['discountAmount']/100)));
$itemtable.=' <tr>
    <td style="width:10%;border:1px solid black;text-align:center;">'.($i+1).'</td>
    <td style="width:40%;text-align:left; padding-left:10px;border-top:1px solid black;border-bottom:1px solid black;text-align:le;">'.$row['ItemName'].' '.$row['SizeValue'].' '.$row['Unit'].'</td>
    <td style="width:20%;border:1px solid black;text-align:center;">'.$row['qty'].'</td>
    <td style="width:20%;border-top:1px solid black;border-bottom:1px solid black;text-align:center;">'. $row['rate'].'</td>
    <td style="width:20%;border:1px solid black;text-align:center;">'.$row['discountAmount'].'</td>
      <td style="width:20%;border:1px solid black;text-align:center;">'.round($total,2).'</td>
      <td style="width:20%;border:1px solid black;text-align:center;">'.$row['TaxPercent'].'% '.$row['TaxType'].'</td>
</tr>';
}
}
}
return $itemtable;
}
function subtotal(){
  $invoice_number = $_REQUEST['tid'];
  include '../config/connection.php';

$sql="SELECT IDM.ItemId,IM.ItemName,TD.rate, TD.itemDetailId,TD.qty,TD.TaxType,TD.TaxPercent,TM.discount,IFNULL(TD.discountAmount,0) as discountAmount,TD.description,TM.TransactionId,TM.FinancialYear,TM.TransactionNumber,TM.DueDate,TM.DateCreated,TM.PersonId,TM.contactId
FROM TransactionDetails TD LEFT JOIN TransactionMaster TM ON TM.TransactionId = TD.TransactionId
LEFT JOIN ItemDetailMaster IDM ON IDM.itemDetailId = TD.itemDetailId
LEFT JOIN ItemMaster IM ON IM.ItemId = IDM.ItemId
WHERE TM.TransactionId =  $invoice_number";
// echo $sql;
  $response = [];
$taxcal='';
  $subtotal=0;
  if($result = mysqli_query($con,$sql)){
    if(mysqli_num_rows($result)>0){
      while($row = mysqli_fetch_array($result))
      {
        $total=$row['qty']*$row['rate'];
        $total1=($total-($total*($row['discountAmount']/100)));
        $subtotal+=$total1;
        array_push($response,[
            'iname' => $row['ItemName'],
            'qty' => $row['qty'],
            'rate' => $row['rate'],
            'total' => $total1,
            'tax' => $row['TaxPercent'].'% '.$row['TaxType'],
            'name' =>$row['TaxType'],
            'discount' =>$row['discount'],
            'discountAmount' =>$row['discountAmount'],
            'taxpercent' =>$row['TaxPercent']
            ]);
    }
  }
  }
  $finaltab=taxcal($response,$subtotal,$response[0]['discount']);
  return $finaltab;
}
function taxcal($param,$param1,$param2)
{
$total=$param1;
include '../config/connection.php';

$response = $response1 = $response2 = [];
$arrJson=$param;
$taxtable='';
$length=count($arrJson);
$keyVal   = 'GST';
$key2=[];
for ($i=0; $i <$length ; $i++) {
  $fl=0;
  $flag=$result1=0;
  $result=$arrJson[$i]['total'];
  if($arrJson[$i]['name']!=$keyVal)
  {
    array_push($response,[
        'tname' => $arrJson[$i]['name'],
        'tval'=> $arrJson[$i]['taxpercent'],
        'taxamt'=> $arrJson[$i]['total'],
        'val'=> $arrJson[$i]['total']*(($arrJson[$i]['taxpercent'])/100)
        ]);
  }
  else  {
    if($i==($length-1) && !(in_array($arrJson[$i]['taxpercent'],$key2)))
    {
      $tax1=($arrJson[$i]['taxpercent'])/2;
      array_push($response,[
          'tname' => 'CGST',
          'tval'=> ($arrJson[$i]['taxpercent'])/2,
          'taxamt'=>$arrJson[$i]['total'],
          'val'=> $arrJson[$i]['total']*(($tax1)/100)
          ]);
          array_push($response,[
              'tname' => 'SGST',
              'tval'=>($arrJson[$i]['taxpercent'])/2,
              'taxamt'=>$arrJson[$i]['total'],
              'val'=> $arrJson[$i]['total']*(($tax1)/100)
              ]);
              break;
    }
    elseif (!(in_array($arrJson[$i]['taxpercent'],$key2))) {
      for ($j=($i+1); $j <$length ; $j++) {
        if ($arrJson[$i]['taxpercent']==$arrJson[$j]['taxpercent']) {
          $tax=($arrJson[$i]['taxpercent'])/2;
          $result+=($arrJson[$j]['total']);
          $key2[]=$arrJson[$i]['taxpercent'];
          $fl=1;
        }

      }
      if($fl==1)
      {
        array_push($response,[
            'tname' => 'CGST',
            'tval'=> $tax,
            'taxamt'=> $result,
            'val'=> $result*($tax/100)
            ]);
            array_push($response,[
                'tname' => 'SGST',
                'tval'=> $tax,
                'taxamt'=> $result,
                'val'=>$result*($tax/100)
                ]);
              }
              else {
                $tax2=($arrJson[$i]['taxpercent'])/2;
                array_push($response,[
                    'tname' => 'CGST',
                    'tval'=> ($arrJson[$i]['taxpercent'])/2,
                    'taxamt'=> $arrJson[$i]['total'],
                    'val'=>  $arrJson[$i]['total']*(($tax2)/100)
                    ]);
                    array_push($response,[
                        'tname' => 'SGST',
                        'tval'=> ($arrJson[$i]['taxpercent'])/2,
                        'taxamt'=> $arrJson[$i]['total'],
                        'val'=> $arrJson[$i]['total']*(($tax2)/100)
                        ]);
              }
    }


    }
  }

  for ($i = 0; $i < count($response); $i++) {
    $total+=$response[$i]['val'];

    $taxtable.='<tr>
        <td  style="width=10%;border-bottom:1px solid black;border-right:1px solid black;">
        '.$response[$i]['tname'].' @ '.$response[$i]['tval'].
        '% on  '.round($response[$i]['taxamt'],2).'
        </td>
        <td style="width=10%;border-bottom:1px solid black;" >
      '.round($response[$i]['val'],2).'
        </td>
    </tr>';
  }
  $discounttotal=($total)*($param2)/100;
  $finaltotal=$total-$discounttotal;
  $taxtable.='
  <tr >
      <td  style="width=10%;border-bottom:1px solid black;border-right:1px solid black" >
       <strong>Sub - Total</strong>
      </td>
      <td style="width=10%;border-bottom:1px solid black;">
       '.round($param1,2).'
      </td>
  </tr>

<tr>
<td  style="width=20%;border-bottom:1px solid black;border-right:1px solid black">
<strong> Total</strong>
</td>
<td style="width=20%;border-bottom:1px solid black;">
 '.round($total,2).'
</td>
</tr>
  <tr>
  <td  style="width=20%;border-bottom:1px solid black;border-right:1px solid black" >
   <strong>Discount Value</strong>
  </td>
  <td style="width=50%;border-bottom:1px solid black;">
   '.round($discounttotal,2).'
  </td>
  </tr>
  <tr>
      <td  style="width=20%;border-right:1px solid black"  >
       <strong>GRAND TOTAL</strong>
      </td>
      <td style="width=50%;">
       <strong>'.round($finaltotal,2).'</strong>
      </td>
  </tr>';
return $taxtable;
}

$html='<body style="font-family:verdana;font-size:12px;">

	<div id="page-wrap" >

  <table width="100%" style="border:1px solid;" cellspacing="0" cellpadding="0">
  <tr>
  <td style="height:30px; border-bottom:1px solid;" valign="top">
  <h1 style="text-align:center; font-weight:bolder; text-transform:uppercase; margin-top:3px; margin-bottom:3px;"><b>Tax Invoice</b></h1>
  </td>
  </tr>
  <tr>
  <td style="height:60px;" valign="top">

  <table width="100%" cellspacing="0" cellpadding="0">
'.company_info().'
  <!-- Invoice Other Details -->
  </td>
  </tr>
  </table>

    <div id="content">
      <div id="invoice_body"><br>

        <table cellspacing="0" cellpadding="0" width="100%">
          <tr style="background:#fff;">
              <td style="width:10%;border:1px solid black;text-align:center;"><strong>SR No.</strong></td>
              <td style="width:40%;border-bottom:1px solid black;border-top:1px solid black;text-align:left; padding-left:10px;">
              <strong>Description</strong></td>
              <td style="width:20%;border:1px solid black;text-align:center;"><strong>Quantity</strong></td>
              <td style="width:20%;border-top:1px solid black;border-bottom:1px solid black;text-align:center;"><strong>Unit Cost</strong></td>
                <td style="width:20%;border:1px solid black;text-align:center;"><strong>Discount</strong></td>
                <td style="width:20%;border:1px solid black;text-align:center;"><strong>Amount</strong></td>
              <td style="width:20%;color: #000000;border:1px solid black;text-align:center;"><strong>Tax</strong></td>
          </tr>
        '.fetch_Items().'
          </table>


        </div>
    </div>
    </table>
    <br>
    <table style="float:right;width:50%;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;border-top:1px solid black;">
  '.subtotal().'

  </table>
	</div>
  <h5>Notes</h5>
  <p class="text-muted" id="notes">'.notes().'</p>
</body>';

$dompdf->setPaper('A4', 'portrait');
$dompdf->loadHtml($html);

$dompdf->render();
$dompdf->stream("Fastinvo.pdf", array("Attachment" => false));

exit(0);
?>
