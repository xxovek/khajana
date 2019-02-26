<?php
include '../config/connection.php';

$response = $response1 = $response2 = [];
$arrJson=$_REQUEST['arr'];

// $arrJson  = explode('}',$myJSON);
$length=count($arrJson);
$keyVal   = 'GST';
$key2=[];
// print_r($arrJson);
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

// print_r($key2);
mysqli_close($con);
exit(json_encode($response));
?>
