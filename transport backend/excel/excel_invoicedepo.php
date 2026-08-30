<?php 
error_reporting(0);
include("../adminsession.php");

$tblname = "invoicebilty";
$tblpkey = "invoiceid";

// Set headers for Excel export
header("Content-Type: application/vnd.ms-excel");
$filename = "excel_invoice" . strtotime("now") . '.xls';
header("Content-Disposition: attachment; filename=" . $filename);


if(isset($_GET['invoiceid'])) {
	$invoiceid = trim(addslashes($_GET['invoiceid']));
}
else
$invoiceid='';

$sql = mysqli_query($connection,"select * from invoicebilty where invoiceid='$invoiceid'");
$row= mysqli_fetch_assoc($sql);
$invdate = $cmn->dateformatindia($row['invdate']);
$invno = $row['invno'];
$itemtype = $row['itemtype'];
$gst = $row['gst'];
$gsttype= $row['gsttype'];
$consigneeid = $cmn->getvalfield($connection,"dispatch_entry","consignee_id","invoiceid='$invoiceid'");
$consignor_id1 = $cmn->getvalfield($connection,"dispatch_entry","consignor_id","invoiceid='$invoiceid'");
$consigneename = $cmn->getvalfield($connection,"m_consignor","consignor_name","consignor_id='$consignor_id1'");
$consigneeaddress = $cmn->getvalfield($connection,"m_consignor","consignor_address","consignor_id='$consignor_id1'");
$consignneepan =  $cmn->getvalfield($connection,"m_consignor","pan_no","consignor_id='$consignor_id1'");
$consignneegst =  $cmn->getvalfield($connection,"m_consignor","gst_no","consignor_id='$consignor_id1'");
$c_logo = $cmn->getvalfield($connection, "m_company", "clogo", "comp_id=$_SESSION[comp_id]");


$companygst  = $cmn->getvalfield($connection,"m_company","gst_no","comp_id=$_SESSION[comp_id]");
// $companysaac  = $cmn->getvalfield($connection,"m_company","saaccode","1 = 1");
$companypan  = $cmn->getvalfield($connection,"m_company","pan_no", "comp_id=$_SESSION[comp_id]");
$cname = $cmn->getvalfield($connection, "m_company", "cname", "comp_id=$_SESSION[comp_id]");
$mobileno1 = $cmn->getvalfield($connection, "m_company", "mobileno1", "comp_id=$_SESSION[comp_id]");
$mobileno2 = $cmn->getvalfield($connection, "m_company", "mobileno2", "comp_id=$_SESSION[comp_id]");
$caddress = $cmn->getvalfield($connection, "m_company", "caddress", "comp_id=$_SESSION[comp_id]");
$emailid = $cmn->getvalfield($connection, "m_company", "emailid", "comp_id=$_SESSION[comp_id]");
$clogo = $cmn->getvalfield($connection, "m_company", "clogo", "comp_id=$_SESSION[comp_id]");
$user = $cmn->getvalfield($connection, "m_userlogin", "user_name", "user_id=$_SESSION[user_id]");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice Export</title>
    <style type="text/css">
        table, th, td {
            border: 1px solid;
            padding: 5px;
            text-align: left;
        }

        .container, 
        .container1 {
            display: flex;
            width: 100%;
            justify-content: space-between;
        }

        .upper {
            width: 50%;
            text-align: left;  
        }
       .upper1 {
            width: 50%;
            text-align: left;
          
        }

        .lower, .lower1 {
            width: 50%;
            text-align: right;
           
        }

        .description {
            text-align: center;
            margin: 15px 0;
        }

        h1 {
            font-size: 20px;
            margin: 5px 0;
            font-weight: bold;
        }
        p {
            font-size: 20px;
            margin: 5px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="conatiner" style="display: flex; width: 100%; margin-left: 10px">

        <p style="text-align: right; margin-left: 820px">Original for Recipient</p>
        <p style="text-align: right; margin-left: 820px">Duplicate for Supplier</p>

    <div class="upper" style=" width: 50%;">
        <h1 style="margin-top: 50px; font-size: 40px; text-align: center; " > <?php echo $cname ?></h1>
        <h1 style="margin-left: 80px;text-align: center; margin-bottom: 20px"> <?php echo $caddress ?></h1>
    </div>
    <div class="lower" style=" width: 50%;  margin-right: 10px">
        <p style="margin-left: 820px"> Quantity & Freight Rate</p>
        <p style="margin-left: 820px"> Verified Bill Passed For Rs :</p>
        <p style="margin-left: 820px">Authorised Signatory</p>
    </div>
</div>

<div class="conatiner1" style="display: flex; width: 100%; margin-right: 10px">
    <div class="upper1" style=" width: 50%;">
        <h1 style="margin-left: 80px"> <?php echo $consigneename ?></h1>
        <h1 style="margin-left: 80px"> <?php echo $consigneeaddress ?></h1>
        <h1 style="margin-left: 80px">PAN NO-<?php echo $consignneepan ?></h1>   
        <h1 style="margin-left: 80px">GST NO -<?php echo $consignneegst ?></h1>
    </div>
    <div class="lower1" style=" width: 50%; margin-left: 10px">
        <h1 style=" margin-left: 820px">FREIGHT BILL NO: <?php echo $invno ?></h1>
        <h1 style="margin-left: 820px">DATE: <?php echo $invdate ?></h1>
        <h1 style="margin-left: 820px"> PAN NO: <?php echo $companypan ?></h1>
        <h1 style="margin-left: 820px">GST NO: <?php echo $companygst  ?></h1>
        <h1 style="margin-left: 820px">VENDOR CODE : 13001370</h1>
        <h1 style="margin-left: 820px">PLACE TO SUPPLY : CHATTISHGARH</h1>
        <h1 style="margin-left: 820px">STATE CODE :22</h1>
        <h1 style="margin-left: 820px">SAC CODE :996511</h1>
    </div>
    <div class="description">
        <p>Service Description : FREIGHT AMOUNT CHARGED FOR TRANSPORTATION OF CEMENT(GTA)
        </p>
    </div>
</div>
    <table>
        <thead>
           <th>sno</th>
            <th>  INVOICE NO </th>
            <th>  GR DATE</th>
            <th> GR/LR NO</th>
             <th> DI NO</th>
             <th>TRUCK NO </th>
               <th>DEPOT NAME & DEST</th> 
              <th>  D.QTY </th>
               <th> FRT AMT.</th>
                <th> NET AMT</th> 
               <th>  IGST</th>
                 <th> CGST</th>
                  <th> SGST </th>
                  <th> GST TOTAL</th>
                 
           
                
                
            </tr>
            <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>(MT)</th>
            <th>MT</th>
            <th></th>
              <?php if($gsttype=="gst"){ ?>
            <th></th>
            <th><?php echo ($gst/2).'%'; ?></th>
           <th><?php echo ($gst/2).'%'; ?></th>
            <?php } else { ?>
              <th><?php echo $gst.'%'; ?></th>
              <th></th>
             <th></th>
            <?php } ?>
            <th></th>
                 
            </tr>
        </thead>
        <tbody>
            <?php
           $sn=1;
           $tot_wt=0;
           $tot_own_rate=0;
           $nettotal_amt=0;
           $tot_gst=0;
           $sql2 = mysqli_query($connection,"select * from dispatch_entry where invoiceid='$invoiceid' order by gr_date asc");
           while($row2=mysqli_fetch_assoc($sql2)) {
           
               $invoiceno = $row2['invoice_no'];
               $gr_date = $row2['gr_date'];
               $gr_no = $row2['gr_no'];
               $di_no = $row2['di_no'];
               $truckid = $row2['vehicle_id'];
               $consignee_id = $row2['consignee_id'];
               $destination_id = $row2['destination_id'];
               $totalweight = $row2['wt_mt'];
               $comp_rate = $row2['comp_rate'];
                   $own_rate = $row2['own_rate'];
               $consignee_name = $cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id='$consignee_id'");
               $truckno = $cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id='$truckid'");
                   $truckno = $cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id='$truckid'");
                            //  $gst_type = $cmn->getvalfield($connection,"payment","gst_type","dispatch_id='$row2[dispatch_id]'");
                               //  $gstper = $cmn->getvalfield($connection,"payment","gstper","dispatch_id='$row2[dispatch_id]'");
               $deliverat = $cmn->getvalfield($connection,"m_place","place_name","place_id='$destination_id'");
               $total_amt = $totalweight * $comp_rate;
             
              
               
	$gstamt =  ($total_amt * $gst)/100;
	$grandtotal=$total_amt+$gstamt;
   if($gsttype=="gst"){
       
        $igst='0';
        $gst1=$gstamt/2; 

    }else{
        $igst=$gstamt;
        $gst1='0';
    }
    $tot_wt += $totalweight;
	$tot_own_rate += $comp_rate;
	$nettotal_amt += $total_amt;
	$tot_gst += $gstamt;
            ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $invoiceno; ?></td>
                <td><?php echo $gr_date; ?></td>
                <td><?php echo  $gr_no ; ?></td>
                <td><?php echo $di_no ?></td>
                <td><?php echo $truckno?></td>
                <td><?php echo $deliverat?></td>
                <td><?php echo   $totalweight ?></td>
                <td><?php echo  $comp_rate ?></td>
                <td><?php echo number_format($total_amt,2)?></td>
                <td><?php echo number_format($igst,2)?></td>
                <td><?php echo number_format($gst1,2); ?></td>
                <td><?php echo number_format($gst1,2);?></td>
                <td><?php echo number_format($gstamt,2)?></td>
            </tr>
            
            <?php } ?>
            <tr>
                <td colspan="7" style="text-align: right;">TOTAL</td>
                <td><?php echo number_format($tot_wt, 2); ?></td>
                <td>0</td>
                <td><?php echo number_format($nettotal_amt, 2); ?></td>
                <td>0</td>
                <td><?php echo number_format($tot_gst / 2, 2); ?></td>
                <td><?php echo number_format($tot_gst / 2, 2); ?></td>
                <td><?php echo number_format($tot_gst, 2); ?></td>
            </tr>
            <tr>
                <td colspan="9"></td>
                <td colspan="2">TOTAL AMOUNT</td>
                <td colspan="3" style="text-align: center;"><?php echo number_format($nettotal_amt + $tot_gst, 2); ?></td>
            </tr>
            <tr>
                <td colspan="14">
                    <?php echo "In Words: Nine Lakh Eight Hundred And Seventeen Rupees Twelve Paise only"; ?>
                </td>
            </tr>

            
        </tbody>
    </table>
    <div>
        <h1 style="text-align: right; font-size: 20px; font-weight: bold">TOTAL : <?php echo number_format($nettotal_amt + $tot_gst, 2); ?></h1>
        <div style="display: flex; width: 50%; justify-content: space-between;">
        <p style="width: 48%;">
        1. I/we have taken registration under the CGST Act, 2017 and have exercised the option to pay tax for: 
        on services of GTA in relation to transport of goods supplied by us during the Financial Year <?php echo  $session_name; ?> 
        under forward charge only.
    </p>

    <p style="width: 48%; text-align: right; font-weight: bold">
        <?php echo $cname; ?>
    </p>
    <p style="width: 48%; text-align: right; font-weight: bold">
      Authorised Signatory
    </p>
</div>       
    </div>
</body>
</html>
