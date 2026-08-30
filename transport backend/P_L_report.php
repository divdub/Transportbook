<?php 
   error_reporting(0);
   include("adminsession.php");
   $tblname = "dispatch_entry";
   $tblpkey = "dispatch_id";
   $pagename = "P_L_report.php";
   $modulename = "Vehicle Ledger ";
   $crit="";
   
   if(isset($_GET['search']))
   {
   	 $fromdate = $_GET['fromdate'];
    	$todate = $_GET['todate'];
   	
   }
   else
   {
	$fromdate = date("Y-m-d", strtotime("-3 months"));
	$todate = date('Y-m-d');
   
   }
   
   if (isset($_GET['vehicle_id'])) {
   	$vehicle_id = trim(addslashes($_GET['vehicle_id']));
   } else
   	$vehicle_id = '';
   	
   if (isset($_GET['cat_id'])) {
   	$cat_id = trim(addslashes($_GET['cat_id']));
   } else
   	$cat_id = '';
      	
   if (isset($_GET['catname'])) {
   	$catname = trim(addslashes($_GET['catname']));
   } else
   	$catname = '';
    
   if ($fromdate != '' && $todate != '') {
   	$crit .= "where bilty_date BETWEEN  '$fromdate' and  '$todate' ";
   	//echo $crit;
   }
   
   if ($vehicle_id != '') {
   	$crit .= " and vehicle_id='$vehicle_id'";
   }
   if($cat_id=='1') {
      $crit .= " and agent_id='$catname'";
      $cat_name=$cmn->getvalfield($connection,"m_agent","agent_name","agent_id=$catname");
      $mobile = $cmn->getvalfield($connection,"m_agent","mobileno1","agent_id=$catname");
   }
   if($cat_id=='2') {
      $crit .= " and consignee_id='$catname'";
      $cat_name=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id=$catname");
      $mobile = $cmn->getvalfield($connection,"m_consignee","mobile_no","consignee_id=$catname");
   }
   if($cat_id=='4') {
      $crit .= " and owner_id='$catname'";
      $cat_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$catname");
      $mobile = $cmn->getvalfield($connection,"m_vehicle_owner","mobileno1","owner_id=$catname");
   }
   ?>
<!doctype html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
      <!-- Apple devices fullscreen -->
      <meta name="apple-mobile-web-app-capable" content="yes" />
      <!-- Apple devices fullscreen -->
      <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
      <title> VEHICLE LEDGER :: CHAARUVI INFOTECH PVT. LTD.</title>
      <?php include("inc/top-files.php"); ?>	
   </head>
   <body>
      <?php include("inc/model.php"); ?>
      <?php include("inc/top-header.php"); ?>
      <div class="container-fluid nav-hidden" id="content">
         <?php include("inc/left-menu.php"); ?>
         <div id="main">
            <div class="container-fluid">
               <?php include("inc/breadcrumbs.php"); ?>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="box box-bordered box-color satblue">
                        <div class="box-title">
                           <h3>
                              <i class="fa fa-list"></i>Vehicle Ledger Report
                           </h3>
                        </div>
                        <div class="box-content nopadding">
                           <form action="#" method="GET" class='form-horizontal form-column form-bordered'>
                              <div class="row">
                                 <div class="col-sm-2">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">From Date <span style="color: red">*</span></label>
                                       <div class="col-sm-8">
                                          <input type="date" name="fromdate" id="fromdate" placeholder="Text input" class="form-control" value="<?php echo $fromdate; ?>" required>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-2">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">To Date <span style="color: red">*</span></label>
                                       <div class="col-sm-8">
                                          <input type="date" name="todate" id="todate" placeholder="Text input" class="form-control" value="<?php echo $todate; ?>" required>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-2">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Category</label>
                           <div class="col-sm-8">
                              <select name="cat_id" id="cat_id" class='select2-me'  style="width:100%;" onchange="getcat(this.value);">
                                 <option value="">Select</option>
                                 <?php $sql = mysqli_query($connection, "Select * from  tpcategory   order by tpcat_id");
                                 while ($row = mysqli_fetch_array($sql)) { ?>
                                    <option value="<?php echo $row['tpcat_id']; ?>"><?php echo $row['tp_name']; ?></option>
                                 <?php } ?>
                                 <script>
                                    document.getElementById('cat_id').value = '<?php echo $cat_id; ?>';
                                 </script>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Name</label>
                           <div class="col-sm-8">
                              <select name="catname" id="catname" class='select2-me ' style="width:100%;" onchange="gettruckno();">
                              <option value="<?php echo $catname ?>"><?php echo $cat_name;?></option> 

                              </select>
                              <script>
                                    document.getElementById('catname').value = '<?php echo $catname; ?>';
                                 </script>
                           </div>
                        </div>
                     </div>
                                 <div class="col-sm-3">
                                
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">Truck No.</label>
                                       <div class="col-sm-8">
                                          <select name="vehicle_id" id="vehicle_id" class='select2-me' style="width:100%;">
                                             <option value="">      Select  </option>
                                             <?php		$sql = mysqli_query($connection,"Select * from  m_vehicle  order by vehicle_id");
                                                while($row= mysqli_fetch_array($sql)) { ?>
                                             <option value="<?php echo $row['vehicle_id']; ?>"><?php echo $row['vehicle_no']; ?></option>
                                             <?php } ?>
                                          </select>
                                          <script>document.getElementById('vehicle_id').value = '<?php echo $vehicle_id; ?>';</script>
                                       </div>
                                    </div>
                              </div>

                              <div class="row">
                                 <div class="col-sm-12">
                                    <div class="form-actions">
                                       <center>
                                          <input type="submit" name="search" class="btn btn-primary" value="Search">  
                                          <a type="button" href="<?php echo $pagename; ?>" class="btn btn-red">Cancel</a>
                                       </center>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
               <div class="box box-color box-bordered red" style="overflow:scroll;">
                           <div class="box-title">
                              <h3>	<i class="fa fa-table"></i>
                              Vehicle Ledger List
                              </h3>
                              <!--<a  href="dispatch-process.php" class="btn btn-warning" style="float: right">Click Here For New Entry-->
                              <!--<i class="fa fa-object-group"></i>-->
                              <!--</a> &nbsp;-->
                              <!--<a href="pdf/pdf_dispatch_entry.php?fromdate=<?php echo $fromdate ?>&todate=<?php echo $todate ?>&is_invoice=<?php echo $is_invoice ?>&item_id=<?php echo $item_id ?>" class="btn" style="float: right" target="_blank">Pdf -->
                              <!--<i class="fa fa-file-pdf-o"></i>-->
                              <!--</a> &nbsp;-->
                              <?php if($vehicle_id !=''){ ?>        
                 <a href="pdf_vehicleledger.php?vehicle_id=<?php echo $vehicle_id; ?>&fromdate=<?php echo $fromdate ?>&todate=<?php echo $todate ?>&cat_id=<?php echo $cat_id ?>&catname=<?php echo $catname ?>" class="btn btn-warning" style="float: right" target="_blank">Pdf
                              <i class="fa fa-file-pdf-o"></i>
                              </a>  &nbsp;
   <a onclick="getwhatsapp('<?php echo $fromdate ?>','<?php echo $todate ?>','<?php echo $cat_id ?>','<?php echo $catname ?>','<?php echo $cat_name ?>','<?php echo $mobile; ?>',<?php echo $vehicle_id; ?>);" ><img src="img/whatsapp.png" style="width:30px;height:30px;float: right">
                                          </a>
                                          <span style="color:#F00;width: 70px;font-weight:bold;padding-top: 5px;float: right;" id="msg"></span>
                              &nbsp;
                              <?php } ?>
                           </div>
                           <div class="box-content nopadding">
                              <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis dataTable-scroll-x dataTable-scroll-y" >
                                 <thead>
                                    <tr>
                                       <th>S.No</th>
                                       <th>DI No.</th>
                                       <th>Bilty No.</th>
                                       <th class='hidden-350'>Bilty Date</th>
                                    
                                       <th>Consignee</th>
                                    
                                       <th>Owner Name</th>
                                       <th>Destination</th>
                                       <th>Item</th>
                                       <th>Weight/MT</th>
                                       
                                       <th>Own Rate</th>
                                           <th>Freight</th>
                                           <th> Advance & Gps </th>
                                           <th>Bilty Commision</th>
                                           <th>Shortage Amt</th>
                                           <th>Tds Amt </th>
                                           <th>Bank Charges </th>
                                         
                                           <th>Voucher No.</th>
                                        
                                         
                                           <th>Final Payment  Amt </th>
                                       <th class='hidden-480'>Paid Amount</th>
                                       <th>Balance</th>
                                    </tr>
                                 </thead>
                                 <?php if($vehicle_id !=''){ 
                                    
                                    if($cat_id ==4) { ?>

                                 <tbody>
                                  
                                       <?php
                                          $sn=1;
                                        //   echo	"Select * from  $tblname  $crit  && consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id order by $tblpkey desc";
                                          $sql = mysqli_query($connection,"Select * from  $tblname  $crit  && consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id order by $tblpkey desc");
                                          	  while($row= mysqli_fetch_array($sql)) {
                                          $consignor_name=$cmn->getvalfield($connection,"m_consignor","consignor_name","consignor_id=$row[consignor_id]");
                                          $consignee_name=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id=$row[consignee_id]");
                                          $vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
                                          $destination=$cmn->getvalfield($connection,"m_place","place_name","place_id=$row[destination_id]");	
                                          $item_name=$cmn->getvalfield($connection,"m_item","item_name","item_id=$row[item_id]");				
                                              $owner_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$row[owner_id]");
                                     $is_voucher=$row['is_voucher'];
                                     $checkbox=$row['checkbox'];
                                   $checkbox = $row['checkbox'];
                                   $paid_to=$row['paid_to'];
                                   if( $checkbox=='0'){
                                    $rate=$row['own_rate'];
                                    $frt=$row['wt_mt'] * $row['own_rate'];
                                    $adv = $row['other_cash_adv'] + $row['cash_adv'] + $row['diesel_adv_amt'];

                                    } else {
                                       $rate= $cmn->getvalfield($connection,"tpa_entry","rate","dispatch_id='$row[dispatch_id]' && tpcat_id='4'");
                                       $frt= $cmn->getvalfield($connection,"tpa_entry","amt","dispatch_id='$row[dispatch_id]' && tpcat_id='4'");
if($paid_to=='Truck Owner') {
   $adv = $row['other_cash_adv'] + $row['cash_adv'] + $row['diesel_adv_amt'];

} else {
   $adv='0';
}
                                      
   

                                    } 

                                    $bank_charge = $cmn->getvalfield($connection,"payment","bank_charge","dispatch_id='$row[dispatch_id]' && category_id='4'");

                        $owneramt= $cmn->getvalfield($connection,"payment","amt_paid_to","dispatch_id='$row[dispatch_id]' && category_id='4'");
                        $tds_amt = $cmn->getvalfield($connection,"payment","tds_amt","dispatch_id='$row[dispatch_id]' && category_id='4'");
                        $sortamt = $cmn->getvalfield($connection,"payment","sortamt","dispatch_id='$row[dispatch_id]' && category_id='4'");
                                    $voucher_id = $cmn->getvalfield($connection,"payment","voucher_id","dispatch_id='$row[dispatch_id]' && category_id='4'");

                                    
                                                                      $bilty_commision = $cmn->getvalfield($connection,"payment","bilty_commision","dispatch_id='$row[dispatch_id]' && category_id='4'");
                                    $amt_paid = $cmn->getvalfield($connection,"payment","amt_paid_to","dispatch_id='$row[dispatch_id]' && is_paid='1' && category_id='4'");
if($amt_paid==''){$amt_paid='0';}
if($owneramt==''){ $owneramt='0';}               
				$payee_name = $cmn->getvalfield($connection,"payment","payee_name","voucher_id='$voucher_id' && consignorid=$consignorid");
			$paydate = $cmn->getvalfield($connection,"payment_receive","receive_date","voucher_no='$voucher_id' && consignorid=$consignorid");
                                            $final=$owneramt ; 
                                            $bal=$final - $amt_paid;

  

                                          	   ?>
                                    <tr>
                                       <td><?php echo $sn++;?></td>
                                       <td><?php echo $row['di_no']; ?></td>
                                       <td><?php echo $row['bilty_no']; ?></td>
                                       <td><?php echo dateformatindia($row['bilty_date']); ?></td>
                                      
                                       <td class='hidden-350'><?php echo $consignee_name; ?></td>
                                    
                                         <td class='hidden-1024'><?php echo $owner_name; ?></td>
                                       <td class='hidden-1024'><?php echo $destination; ?></td>
                                       <td class='hidden-1024'><?php echo $item_name; ?></td>
                                       <td><?php echo $row['wt_mt']; ?></td>
                                     
                                       <td><?php echo $rate; ?></td>
                                         <td><?php echo number_format($frt);?></td>
                                         <td><?php echo $adv; ?></td>
                                         <td><?php echo $bilty_commision; ?></td>
                                         <td><?php echo $sortamt; ?></td>
                                         <td><?php echo $tds_amt; ?></td>
                                       
                                         <td><?php echo $bank_charge; ?></td>
                                         <td><?php echo $voucher_id;?></td>
      
<td class='hidden-1024'><?php echo $owneramt; ?></td>
                                 
                                       
                                         <td class='hidden-1024'><?php echo $amt_paid; ?></td>
                                         
                                         <td class='hidden-1024'><?php echo $bal; ?></td>
                   
				   
                                    </tr>
                                    <?php } }  ?>
                                 </tbody>
                                 <?php   if($cat_id ==2) { ?>

<tbody>
 
      <?php
         $sn=1;
         // echo		"Select * from  $tblname  $crit  && consignor_id=$consignorid && checkbox=1 &&comp_id=$comp_id && session_id=$session_id order by $tblpkey desc";
         $sql = mysqli_query($connection,"Select * from  $tblname  $crit  && consignor_id=$consignorid && checkbox=1 &&comp_id=$comp_id && session_id=$session_id order by $tblpkey desc");
              while($row= mysqli_fetch_array($sql)) {
         $consignor_name=$cmn->getvalfield($connection,"m_consignor","consignor_name","consignor_id=$row[consignor_id]");
         $consignee_name=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id=$row[consignee_id]");
         $vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
         $destination=$cmn->getvalfield($connection,"m_place","place_name","place_id=$row[destination_id]");	
         $item_name=$cmn->getvalfield($connection,"m_item","item_name","item_id=$row[item_id]");				
             $owner_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$row[owner_id]");
    $is_voucher=$row['is_voucher'];
    
  $paid_to=$row['paid_to'];
  $tpa_id= $cmn->getvalfield($connection,"tpa_entry","tpa_id","dispatch_id='$row[dispatch_id]' && tpcat_id='2'");

      $rate= $cmn->getvalfield($connection,"tpa_entry","rate","dispatch_id='$row[dispatch_id]' && tpcat_id='2'");
      $frt= $cmn->getvalfield($connection,"tpa_entry","amt","dispatch_id='$row[dispatch_id]' && tpcat_id='2'");
if($paid_to=='Consignee') {
$adv = $row['other_cash_adv'] + $row['cash_adv'] + $row['diesel_adv_amt'];

} else {
$adv='0';
}
     


$bank_charge = $cmn->getvalfield($connection,"payment","bank_charge","dispatch_id='$row[dispatch_id]' && category_id='2'");


$tds_amt = $cmn->getvalfield($connection,"payment","tds_amt","dispatch_id='$row[dispatch_id]' && category_id='2'");
$sortamt = $cmn->getvalfield($connection,"payment","sortamt","dispatch_id='$row[dispatch_id]' && category_id='2'");
   $consigneeamt= $cmn->getvalfield($connection,"payment","amt_paid_to","dispatch_id='$row[dispatch_id]' && category_id='2'");
   $voucher_id = $cmn->getvalfield($connection,"payment","voucher_id","dispatch_id='$row[dispatch_id]' && category_id='2'");

   
                                     $bilty_commision = $cmn->getvalfield($connection,"payment","bilty_commision","dispatch_id='$row[dispatch_id]' && category_id='2'");
   $amt_paid = $cmn->getvalfield($connection,"payment","amt_paid_to","dispatch_id='$row[dispatch_id]' && is_paid='1' && category_id='2'");
if($amt_paid==''){$amt_paid='0';}
if($consigneeamt==''){ $consigneeamt='0';}
$payee_name = $cmn->getvalfield($connection,"payment","payee_name","voucher_id='$voucher_id' && consignorid=$consignorid");
$paydate = $cmn->getvalfield($connection,"payment_receive","receive_date","voucher_no='$voucher_id' && consignorid=$consignorid");
           $final=$consigneeamt; 
           $bal=$final - $amt_paid;



          if($tpa_id!='') {    ?>
   <tr>
      <td><?php echo $sn++;?></td>
      <td><?php echo $row['di_no']; ?></td>
      <td><?php echo $row['bilty_no']; ?></td>
      <td><?php echo dateformatindia($row['bilty_date']); ?></td>
     
      <td class='hidden-350'><?php echo $consignee_name; ?></td>
   
        <td class='hidden-1024'><?php echo $owner_name; ?></td>
      <td class='hidden-1024'><?php echo $destination; ?></td>
      <td class='hidden-1024'><?php echo $item_name; ?></td>
      <td><?php echo $row['wt_mt']; ?></td>
    
      <td><?php echo $rate; ?></td>
        <td><?php echo number_format($frt);?></td>
        <td><?php echo $adv; ?></td>
        <td><?php echo $bilty_commision; ?></td>
        <td><?php echo $sortamt; ?></td>
        <td><?php echo $tds_amt; ?></td>
        <td><?php echo $bank_charge; ?></td>
       
        <td><?php echo $voucher_id;?></td>
        
<td class='hidden-1024'><?php echo $consigneeamt; ?></td>

      
        <td class='hidden-1024'><?php echo $amt_paid; ?></td>
        
        <td class='hidden-1024'><?php echo $bal; ?></td>

   </tr>
   <?php } } } ?>
                                 </tbody>
                                 <?php   if($cat_id ==1) { ?>

<tbody>
 
      <?php
         $sn=1;
         // echo		"Select * from  $tblname  $crit  && consignor_id=$consignorid && checkbox=1 &&comp_id=$comp_id && session_id=$session_id order by $tblpkey desc";
         $sql = mysqli_query($connection,"Select * from  $tblname  $crit  && consignor_id=$consignorid && checkbox=1 &&comp_id=$comp_id && session_id=$session_id order by $tblpkey desc");
              while($row= mysqli_fetch_array($sql)) {
         $consignor_name=$cmn->getvalfield($connection,"m_consignor","consignor_name","consignor_id=$row[consignor_id]");
         $consignee_name=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id=$row[consignee_id]");
         $vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
         $destination=$cmn->getvalfield($connection,"m_place","place_name","place_id=$row[destination_id]");	
         $item_name=$cmn->getvalfield($connection,"m_item","item_name","item_id=$row[item_id]");				
             $owner_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$row[owner_id]");
    $is_voucher=$row['is_voucher'];
    
  $paid_to=$row['paid_to'];
  $tpa_id= $cmn->getvalfield($connection,"tpa_entry","tpa_id","dispatch_id='$row[dispatch_id]' && tpcat_id='1'");

      $rate= $cmn->getvalfield($connection,"tpa_entry","rate","dispatch_id='$row[dispatch_id]' && tpcat_id='1'");
      $frt= $cmn->getvalfield($connection,"tpa_entry","amt","dispatch_id='$row[dispatch_id]' && tpcat_id='1'");
if($paid_to=='Agent') {
$adv = $row['other_cash_adv'] + $row['cash_adv'] + $row['diesel_adv_amt'];

} else {
$adv='0';
}
     


   
$bank_charge = $cmn->getvalfield($connection,"payment","bank_charge","dispatch_id='$row[dispatch_id]' && category_id='1'");

$tds_amt = $cmn->getvalfield($connection,"payment","tds_amt","dispatch_id='$row[dispatch_id]' && category_id='1'");
$sortamt = $cmn->getvalfield($connection,"payment","sortamt","dispatch_id='$row[dispatch_id]' && category_id='1'");
   $consigneeamt= $cmn->getvalfield($connection,"payment","amt_paid_to","dispatch_id='$row[dispatch_id]' && category_id='1'");
   $voucher_id = $cmn->getvalfield($connection,"payment","voucher_id","dispatch_id='$row[dispatch_id]' && category_id='1'");

   
                                     $bilty_commision = $cmn->getvalfield($connection,"payment","bilty_commision","dispatch_id='$row[dispatch_id]' && category_id='1'");
   $amt_paid = $cmn->getvalfield($connection,"payment","amt_paid_to","dispatch_id='$row[dispatch_id]' && is_paid='1' && category_id='1'");
if($amt_paid==''){$amt_paid='0';}
if($consigneeamt==''){ $consigneeamt='0';}
$payee_name = $cmn->getvalfield($connection,"payment","payee_name","voucher_id='$voucher_id' && consignorid=$consignorid");
$paydate = $cmn->getvalfield($connection,"payment_receive","receive_date","voucher_no='$voucher_id' && consignorid=$consignorid");
           $final=$consigneeamt; 
           $bal=$final - $amt_paid;



             if($tpa_id !=''){  ?>
   <tr>
      <td><?php echo $sn++;?></td>
      <td><?php echo $row['di_no']; ?></td>
      <td><?php echo $row['bilty_no']; ?></td>
      <td><?php echo dateformatindia($row['bilty_date']); ?></td>
     
      <td class='hidden-350'><?php echo $consignee_name; ?></td>
   
        <td class='hidden-1024'><?php echo $owner_name; ?></td>
      <td class='hidden-1024'><?php echo $destination; ?></td>
      <td class='hidden-1024'><?php echo $item_name; ?></td>
      <td><?php echo $row['wt_mt']; ?></td>
    
      <td><?php echo $rate; ?></td>
        <td><?php echo number_format($frt);?></td>
        <td><?php echo $adv; ?></td>
        <td><?php echo $bilty_commision; ?></td>
        <td><?php echo $sortamt; ?></td>
        <td><?php echo $tds_amt; ?></td>
        <td><?php echo $bank_charge; ?></td>
        
        <td><?php echo $voucher_id;?></td>

<td class='hidden-1024'><?php echo $consigneeamt; ?></td>

      
        <td class='hidden-1024'><?php echo $amt_paid; ?></td>
        
        <td class='hidden-1024'><?php echo $bal; ?></td>

   </tr>
   <?php } } } ?>
                                 </tbody>
                                 <?php } ?>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="modal fade" id="myModal_whatsapp" role="dialog">
		<div class="modal-dialog" style="width:480px;padding-top: 225px;">


			<div class="modal-content" style="border-radius: 20px;">
				<div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
					<!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
					<center>
						<h4 class="modal-title"><b>Send Message<b></h4>
					</center>
				</div>
   
			<div class="modal-body" style="flex-wrap: wrap-reverse;display: flex;">
				<span style="color:#F00;" id="suppler_model_error"></span> 
				<table class="table table-condensed table-bordered">
					<tr>
						<th>Bill Name <span style="color:#F00;"> * </span> </th>
						<th>Contact No.</th>

					</tr>
					<tr>
						<td>
						<input type="hidden" name="w_category" id="w_category" class="form-control" value="" style="font-weight:bold; " autocomplete="off" readonly>

                            <input type="text" name="w_bill_name" id="w_bill_name" class="form-control" value="" style="font-weight:bold; " autocomplete="off" readonly>
                            <input type="hidden" name="w_owner_id" id="w_owner_id" class="form-control" value="" style="font-weight:bold; " autocomplete="off" readonly>

                           </td>

						<td>
                        <input type="number" name="w_mobile" id="w_mobile" placeholder="Mobile No" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" value="<?php echo $w_mobile; ?>" required>              
                 <!-- <input type="text" name="w_mobile" id="w_mobile" class="form-control" value="" style="font-weight:bold; " autocomplete="off"> -->
						<input type="hidden" name="w_billid" id="w_billid" class="form-control" value="" style="font-weight:bold; " autocomplete="off">
                    </td>


					</tr>
				
                 

					<tr>
                    <input type="checkbox" name="numupdate" id="numupdate" value="1"  style="width:18px;"/>  <span style="font-size:16px;margin-top:10px;"> &nbsp; Update Mobile Number</span>  
                    <!-- <input type="checkbox" id="layername1" name="layername" value="Drone Image" onclick="showLayerMap(1);"  /> -->
                    </tr>
				
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" name="s_save" id="s_save" onClick="sendfile();">Send</button>
				<button data-dismiss="modal" class="btn btn-danger">Close</button>
				<input type="hidden" id="s_saleid" value="">

			</div>
		</div>

    </div>
   <script>
      
function getcat(cat_id) {
  
  jQuery.ajax({
 type: 'POST',
        url: 'ajaxpayment/getcat.php',
        data:'cat_id='+cat_id,
        dataType: 'html',
        success: function(data)
        {
        
          jQuery('#catname').html(data).trigger('change').trigger('select2:select');

        }
      
});
}
     
function gettruckno() {
  var cat_id=$('#cat_id').val();
  var catname=$('#catname').val();
//   alert(catname);
  jQuery.ajax({
 type: 'POST',
        url: 'ajaxpayment/gettruckno.php',
        data:'cat_id='+cat_id+'&catname='+catname,
        dataType: 'html',
        success: function(data)
        {
        // alert(data);
          jQuery('#vehicle_id').html(data).trigger('change').trigger('select2:select');

        }
      
});
}


   </script>
   <script>
	   
      function getwhatsapp(fromdate,todate,cat_id,catname,bill_name,mobile,vehicle_id){
      
      jQuery.ajax({
           type: 'POST',
           url: 'pdf_vehicleledger_whatsapp.php', 
           data: 'fromdate='+fromdate+'&todate='+todate+'&vehicle_id='+vehicle_id+'&cat_id='+cat_id+'&catname='+catname
           ,
           dataType: 'html',
           success: function(data){
           
            // sendfile(vehicle_id,cat_id,bill_name,mobile);
            // getnum(billid,category,owner_id,bill_name,mobile);
            getnum(vehicle_id,cat_id,catname,bill_name,mobile);
 
            }
            
           });//ajax close
      }

      function getnum(vehicle_id,cat_id,catname,bill_name,mobile) {
	
	jQuery('#myModal_whatsapp').modal('show');
	jQuery('#w_billid').val(vehicle_id);
	jQuery('#w_category').val(cat_id);
	   jQuery('#w_owner_id').val(catname);
	   jQuery('#w_bill_name').val(bill_name);
	   jQuery('#w_mobile').val(mobile);
	
 }

      function sendfile(){
         var billid = document.getElementById('w_billid').value;
            var mobile = document.getElementById('w_mobile').value;
         
            var category = document.getElementById('w_category').value;
			var owner_id = document.getElementById('w_owner_id').value;
            var bill_name = document.getElementById('w_bill_name').value;
            var numupdate = document.getElementById('numupdate');
			if (category == 1){ 
			var type ="agent";
			} else if(category == 2){
				var type ="consignee";
			} else {
				var type ="owner";
			}
  if (numupdate.checked == true){ 
   var upval='1';
  } else {
    var upval='0';
  }
            

if(mobile==''){
    alert("Please Enter Mobile No.");
    return false;
}

      jQuery.ajax({
      type: 'POST',
      url: 'whatsapp.php',
      data: 'billid='+billid+'&mobile='+mobile+'&bill_name='+bill_name+'&owner_id='+owner_id+'&type='+type+'&upval='+upval,
      dataType: 'html',
      success: function(data){
         jQuery("#myModal_whatsapp").modal('hide');
      document.getElementById('msg').innerHTML = 'Sent';
      
      }
      
      });//ajax close
      }
      </script>	
   </body>
</html>