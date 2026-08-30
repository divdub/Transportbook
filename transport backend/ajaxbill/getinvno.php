<?php 
include("../adminsession.php");

$billtype = $_REQUEST['billtype']; 
$planttype = $_REQUEST['planttype']; 

$invprefix = $cmn->getvalfield($connection, "m_session", "invprefix", "session_id='$session_id'");
$yearshort1 = $invprefix + 1;
// Set plant prefix code based on planttype
switch(strtolower(trim($planttype))) {
    case 'scl-raipur':
        $plantprefix = '1040'.$yearshort1.'1';
        break;
    case 'scl-raipur-gu-ii':
        $plantprefix = '1046'.$yearshort1.'1';
        break;
    case 'manual':
        $plantprefix = '1046';  // Manual plant code
        break;
    default:
        $plantprefix = '0000000'; // fallback
        break;
}

// Initialize variables to prevent undefined notices
$sno = '';
$sno1 = '';
$invno = '';

// For Party bill
if ($billtype == 'Party') {
    if (strtolower(trim($planttype)) == 'manual') {
        $yearshort = date('y'); // e.g. 25 for 2025
      
      if($consignorid==1){
         
             $sno = $cmn->getcode1($connection, "invoicebilty", "sno", "sessionid='$session_id' AND planttype='$planttype' AND consignorid='$consignorid'"); 
       $invno = "$plantprefix/GA/$yearshort/$sno";
      } else {
             $sno1 = $cmn->getcode2($connection, "invoicebilty", "serial", "sessionid='$session_id' AND planttype='$planttype' AND consignorid='$consignorid'"); 
          $invno = "JKLC-GA0$sno1";
      }
    } else {
          if($consignorid==1){
        $sno = $cmn->getcode($connection, "invoicebilty", "sno", "sessionid='$session_id' AND planttype='$planttype' AND consignorid='$consignorid'");
        $invno = 'PGA' . $plantprefix . $sno;
          }else {
               $sno1 = $cmn->getcode2($connection, "invoicebilty", "serial", "sessionid='$session_id' AND planttype='$planttype' AND consignorid='$consignorid'"); 
          $invno = "JKLC-GA0$sno1";
          }
    }
}
// For Transport or Other bill types
elseif($billtype == 'Dump') {
    if (strtolower(trim($planttype)) == 'manual') {
        $yearshort = date('y'); // e.g. 25 for 2025
      
      if($consignorid==1){
            $sno1 = $cmn->getcode1($connection, "invoicebilty", "serial", "sessionid='$session_id' AND planttype='$planttype' AND consignorid='$consignorid'");
        $invno = "GA/FGC/$yearshort/$sno1";
      } else {
            $sno1 = $cmn->getcode2($connection, "invoicebilty", "serial", "sessionid='$session_id' AND planttype='$planttype' AND consignorid='$consignorid'");
          $invno = "JKLC-GA0$sno1";
      }
    } else {
        $sno1 = $cmn->getcode($connection, "invoicebilty", "serial", "sessionid='$session_id' AND planttype='$planttype' AND consignorid='$consignorid'");
        $invno = 'SGA' . $plantprefix . $sno1;
    }
} 
elseif($billtype == 'Clinker') {
    // if (strtolower(trim($planttype)) == 'manual') {
    //     $yearshort = date('y'); // e.g. 25 for 2025
              $cserial = $cmn->getcode1($connection, "invoicebilty", "cserial", "sessionid='$session_id'  AND consignorid='$consignorid'");
       $invno = "GA/FCC/$invprefix/$cserial";
    //   if($consignorid==1){
    //         $sno1 = $cmn->getcode1($connection, "invoicebilty", "serial", "sessionid='$session_id' AND planttype='$planttype' AND consignorid='$consignorid'");
    //     $invno = "GA/FGC/$yearshort/$sno1";
    //   } else {
    //         $sno1 = $cmn->getcode2($connection, "invoicebilty", "serial", "sessionid='$session_id' AND planttype='$planttype' AND consignorid='$consignorid'");
    //       $invno = "JKLC-GA$sno1";
    //   }
    // } else {
    //     $sno1 = $cmn->getcode($connection, "invoicebilty", "serial", "sessionid='$session_id' AND planttype='$planttype' AND consignorid='$consignorid'");
    //     $invno = 'SGA' . $plantprefix . $sno1;
    // }
} elseif($billtype == 'Pre Loading') {
    
      $pserial = $cmn->getcode1($connection, "invoicebilty", "pserial", "sessionid='$session_id'  AND consignorid='$consignorid'");
     $invno = "7704/GA/$invprefix/$pserial";
}


else {
     if($consignorid==2){
     $sno1 = $cmn->getcode2($connection, "invoicebilty", "serial", "sessionid='$session_id' AND planttype='$planttype' AND consignorid='$consignorid'");
          $invno = "JKLC-GA0$sno1";
     }else{
         
     }
}

echo $invno . "|" . $sno . "|" . $sno1 ."|".$cserial."|".$pserial;
?>
