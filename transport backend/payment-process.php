<?php
error_reporting(0);
include("adminsession.php");
include("function/payment_function.php");
$tblname = "dispatch_entry";
$tblpkey = "dispatch_id";
$pagename = "payment-process.php";
$modulename = "Payment Entry";
if (isset($_GET['action'])) {
   $action = $_GET['action'];
} else {
   $action = "";
}
if (isset($_GET['edit'])) {
   $keyvalue = $_GET['edit'];
} else {
   $keyvalue = '';
}
$privilege_id = $cmn->getvalfield($connection, "user_privilege", "count(privilege_id)", "menu_id='2' && submenu_id='4' && subcat_id=0  && user_id='$user_id'");

if (isset($_GET['edit']) != "") {
   $keyvalue = test_input($_GET['edit']);
   $sql = mysqli_query($connection, "select * from tpa_entry where tpa_id='$keyvalue'");
   $row = mysqli_fetch_array($sql);
   $catid = $row['tpcat_id'];
   $categoryid = $row['category_id'];
   $dispatch_id = $row['dispatch_id'];
   $di_no = $row['di_no'];
   if ($catid == 1) {

      $tpaname = $cmn->getvalfield($connection, "m_agent", "agent_name", "agent_id='$row[category_id]'");
   }
   if ($catid == 2) {
      $tpaname = $cmn->getvalfield($connection, "m_consignee", "consignee_name", "consignee_id='$row[category_id]'");
   }
   if ($catid == 4) {
      $tpaname = $cmn->getvalfield($connection, "m_vehicle_owner", "owner_name", "owner_id='$row[category_id]'");
   }
}
$vehicle_id = $cmn->getvalfield($connection, "dispatch_entry", "vehicle_id", "dispatch_id ='$row[dispatch_id]'");
$destination_id = $cmn->getvalfield($connection, "dispatch_entry", "destination_id", "dispatch_id ='$row[dispatch_id]'");
$from_id = $cmn->getvalfield($connection, "dispatch_entry", "from_id", "dispatch_id ='$row[dispatch_id]'");
$owner_id = $cmn->getvalfield($connection, "dispatch_entry", "owner_id", "dispatch_id ='$row[dispatch_id]'");
$item_id = $cmn->getvalfield($connection, "dispatch_entry", "item_id", "dispatch_id ='$row[dispatch_id]'");
$truck_no = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id ='$vehicle_id'");
$toplace = $cmn->getvalfield($connection, "m_place", "place_name", "place_id ='$destination_id'");
$fromplace = $cmn->getvalfield($connection, "m_place", "place_name", "place_id ='$from_id'");

$ownername = $cmn->getvalfield($connection, "m_vehicle_owner", "owner_name", "owner_id ='$owner_id'");

$item_name = $cmn->getvalfield($connection, "m_item", "item_name", "item_id ='$item_id'");

// $amt = $row['amt'];
// $rate = $row['rate'];

$wt_mt = $cmn->getvalfield($connection, "dispatch_entry", "wt_mt", "dispatch_id ='$row[dispatch_id]'");

$ownrate = $cmn->getvalfield($connection, "dispatch_entry", "own_rate", "dispatch_id ='$row[dispatch_id]'");
$freightamt = $wt_mt * $ownrate;
// $balamt=$freightamt -$amt;
// $balrate=$ownrate -$rate;

$paid_to = $cmn->getvalfield($connection, "dispatch_entry", "paid_to", "dispatch_id ='$row[dispatch_id]'");

$tparemark = $cmn->getvalfield($connection, "dispatch_entry", "tparemark", "dispatch_id ='$row[dispatch_id]'");
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
   <title>PAYMENT :: CHAARUVI INFOTECH PVT. LTD.</title>
   <?php include("inc/top-files.php"); ?>
</head>

<body onload="showrecord(<?php echo $dispatch_id; ?>)">
   <div class="modal fade" id="myshowpaidto" role="dialog">
      <div class="modal-dialog" style="padding-top: 225px;">
         <div class="modal-content" style="border-radius: 20px;">

            <!-- Modal Header -->
            <div class="modal-header" style="background-color:#29465B; color: white; border-top-left-radius: 18px; border-top-right-radius: 18px;">
               <h4 class="modal-title text-center w-100"><b>PAID TO DETAILS</b></h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" style="padding: 30px 40px;">
               <div class="row mb-3">
                  <div class="col-md-4"><b>Account Number:</b></div>
                  <div class="col-md-8" id="accountno"></div>
               </div>
               <div class="row mb-3">
                  <div class="col-md-4"><b>IFSC Code:</b></div>
                  <div class="col-md-8" id="Ifsccode"></div>
               </div>
               <div class="row mb-3">
                  <div class="col-md-4"><b>PAN Number:</b></div>
                  <div class="col-md-8" id="Panno"></div>
               </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
               <center>
                  <input type="button" data-dismiss="modal" class="btn btn-danger" value="Close">
               </center>
            </div>

         </div>
      </div>
   </div>

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
                           <i class="fa fa-bars"></i>Payment
                        </h3>
                     </div>
                     <div class="box-content nopadding">
                        <ul class="tabs tabs-inline tabs-top">
                           <?php $subsn = 1;
                           $sql1 = mysqli_query($connection, "select * from user_privilege where menu_id='2' && submenu_id!=0 && subcat_id=0 && user_id='$user_id'  order by submenu_id  asc");
                           while ($row1 = mysqli_fetch_array($sql1)) {
                              $activity2 = $row1['status'];
                              $submenu_id = $row1['submenu_id'];
                              $submenu = $cmn->getvalfield($connection, "m_submenu", "submenu", "submenu_id='$submenu_id'");

                              $pagelink2 = $cmn->getvalfield($connection, "m_submenu", "pagelink", "submenu_id='$submenu_id'");
                              $sub_cat = $cmn->getvalfield($connection, "m_submenu", "sub_cat", "submenu_id='$submenu_id'");

                           ?>
                              <li <?php if ($sub_cat == 1) { ?> class='active' <?php } ?>>
                                 <a id="<?php echo $pagelink2; ?>" data-toggle='tab'>
                                    <i class="fa fa-inbox"></i><?php echo ucfirst($submenu); ?></a>
                              </li>
                           <?php } ?>
                           <!-- <li class='active'>
                              <a id="tpaentry" data-toggle='tab'>
                                 <i class="fa fa-inbox"></i>Voucher Entry</a>
                           </li> -->


                           <li>
                              <a id="vreport" data-toggle='tab'>
                                 <i class="fa fa-share"></i>Voucher Report</a>
                           </li>
                           <!-- <li>
                              <a id="vpayment" data-toggle='tab'>
                                 <i class="fa fa-tag"></i>Voucher Payment</a>
                           </li> -->
                           <li>
                              <a id="report" data-toggle='tab' style="background: #2563eb; color: #ffffff">
                                 <i class="fa fa-share"></i>Payment Report</a>
                           </li>
                           <li>
                              <a id="preport" data-toggle='tab' style="background: #2563eb; color: #ffffff">
                                 <i class="fa fa-share"></i>Paid/Unpaid Report</a>
                           </li>

                        </ul>
                        <div class="tab-content padding tab-content-inline tab-content-bottom" id="main1">
                           <?php if ($privilege_id == 1) { ?>
                              <div class="row">
                                 <div class="col-sm-12">
                                    <div class="row">
                                       <div class="col-sm-12" style="margin-top:20px;">
                                          <div class="col-sm-3">
                                             <h3 class="tbhead" style="margin-top: 1px;">Voucher Entry</h3>
                                          </div>
                                          <div class="col-sm-3">
                                             <table width="100%" border="0">
                                                <tbody>
                                                   <tr>
                                                      <td>
                                                         <div class="check-line">
                                                            <input id="c7" type="radio" name="example" value="multiple" checked>
                                                            <label class='inline' for="c7"><strong>Multiple Voucher Entry</strong></label>
                                                         </div>
                                                      </td>
                                                      <td>
                                                         <div class="check-line">
                                                            <input id="c71" type="radio" name="example" value="single">

                                                            <label class='inline' for="c71"><strong>Single Voucher Entry</strong></label>
                                                         </div>
                                                      </td>







                                                   </tr>
                                                </tbody>
                                             </table>
                                          </div>
                                       </div>
                                    </div>

                                    <div class="box box-bordered box-color" id="showmultiple">
                                       <div class="box-title">
                                          <h3>
                                             <i class="fa fa-list"></i>
                                             <h3 class="tbhead">Multiple Voucher Entry</h3>
                                       </div>
                                       <div class="box-content nopadding">
                                          <form action="#" method="POST" class='form-horizontal form-column form-bordered'>
                                             <table class="table table-bordered" id="voucher-filter-table">
                                                <tr>
                                                   <!-- From Date -->
                                                   <td>
                                                      <label>From Date</label>
                                                   </td>
                                                   <td>
                                                      <label>To Date</label>
                                                   </td>
                                                   <td>
                                                      <label>Category</label>
                                                   </td>
                                                   <td>
                                                      <label>Name</label>
                                                   </td>
                                                   <td>
                                                      <label>Item</label>
                                                   </td>
                                                   <td>
                                                      <label>Vehicle No</label>
                                                   </td>
                                                </tr>
                                                <!-- To Date -->
                                                <td>
                                                   <input type="date" name="fromdate" id="fromdate"
                                                      class="form-control"
                                                      value="<?php echo $currentdate; ?>">
                                                </td>
                                                <td>
                                                   <input type="date" name="todate" id="todate"
                                                      class="form-control"
                                                      value="<?php echo $currentdate; ?>">
                                                </td>

                                                <td>
                                                   <select name="cat_id" id="cat_id" class="form-control select2-me" onchange="getcat(this.value);">
                                                      <option value="">Select</option>
                                                      <?php
                                                      $sql = mysqli_query($connection, "SELECT * FROM tpcategory ORDER BY tpcat_id");
                                                      while ($row = mysqli_fetch_array($sql)) { ?>
                                                         <option value="<?php echo $row['tpcat_id']; ?>">
                                                            <?php echo $row['tp_name']; ?>
                                                         </option>
                                                      <?php } ?>
                                                   </select>

                                                   <script>
                                                      document.getElementById('cat_id').value = '<?php echo $cat_id; ?>';
                                                   </script>
                                                </td>

                                                <!-- Name -->

                                                <td>
                                                   <select name="catname" id="catname" class="form-control select2-me">
                                                   </select>
                                                </td>
                                                <td>
                                                   <select name="item_id" id="item_id" class="form-control select2-me">
                                                      <option value="">Select</option>
                                                      <?php
                                                      $sql = mysqli_query($connection, "SELECT * FROM m_item ORDER BY item_id");
                                                      while ($row = mysqli_fetch_array($sql)) { ?>
                                                         <option value="<?php echo $row['item_id']; ?>">
                                                            <?php echo $row['item_name']; ?>
                                                         </option>
                                                      <?php } ?>
                                                   </select>

                                                   <script>
                                                      document.getElementById('item_id').value = '<?php echo $item_id; ?>';
                                                   </script>
                                                </td>
                                                <td>
                                                   <select name="vehicle_id" id="vehicle_id" class="form-control select2-me">
                                                      <option value="">Select</option>
                                                      <?php
                                                      $sql = mysqli_query($connection, "SELECT * FROM m_vehicle ORDER BY vehicle_id");
                                                      while ($row = mysqli_fetch_array($sql)) { ?>
                                                         <option value="<?php echo $row['vehicle_id']; ?>">
                                                            <?php echo $row['vehicle_no']; ?>
                                                         </option>
                                                      <?php } ?>
                                                   </select>

                                                   <script>
                                                      document.getElementById('vehicle_id').value = '<?php echo $vehicle_id; ?>';
                                                   </script>
                                                </td>
                                                </tr>

                                                <tr>
                                                   <!-- Buttons -->
                                                   <td colspan="6" style="text-align:center; border-top:none !important; border-left:none !important; border-right:none !important; border-bottom:1px solid rgba(70,130,180,0.4) !important; padding: 10px 0;">
                                                      <a class="btn btn-primary" onclick="getsearch();">Search</a>
                                                      <a href="payment-process.php" class="btn btn-danger">Reset</a>
                                                   </td>
                                                </tr>
                                             </table>
                                             <div class="row" style="width: 99.99%">
                                                <div class="col-sm-12" style="overflow: scroll;height: 500px" id="vouchertable">



                                                </div>
                                             </div>
                                          </form>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-12">
                                    <span style="color:#F00;width: 70px;" id="msg"></span>
                                    <div class="box box-bordered box-color" id="showsingle">
                                       <div class="box-title">
                                          <h3>
                                             <i class="fa fa-list"></i>
                                             <h3 class="tbhead">Single Voucher Entry </h3>
                                       </div>
                                       <div class="box-content nopadding">
                                          <form action="#" method="POST" class='form-horizontal form-column form-bordered'>
                                             <div class="row">
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4"> Category</label>
                                                      <div class="col-sm-8">
                                                         <select name="tpcat_id" id="tpcat_id" class='select2-me ' onchange="getname(this.value);" style="width:100%;">
                                                            <option value="">Select</option>
                                                            <?php $sql = mysqli_query($connection, "Select * from  tpcategory   order by tpcat_id");
                                                            while ($row = mysqli_fetch_array($sql)) { ?>
                                                               <option value="<?php echo $row['tpcat_id']; ?>"><?php echo $row['tp_name']; ?></option>
                                                            <?php } ?>
                                                            <script>
                                                               document.getElementById('tpcat_id').value = '<?php echo $tpcat_id; ?>';
                                                            </script>
                                                         </select>

                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Name </label>
                                                      <div class="col-sm-8">
                                                         <select name="name" id="name" class='select2-me ' onchange="getdi();" style="width:100%;">

                                                            <option value="">Select</option>
                                                         </select>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">DI/LR No. </label>
                                                      <div class="col-sm-8">
                                                         <select name="dispatch_id" id="dispatch_id" class='select2-me ' style="width:100%;" onchange="getvalue();">

                                                            <option value="">Select</option>
                                                         </select>
                                                      </div>
                                                   </div>
                                                </div>

                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Bilty Date </label>
                                                      <div class="col-sm-8">
                                                         <input type="date" name="bilty_date" id="bilty_date" placeholder="Enter Consignor Name" class="form-control" readonly>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Truck No. </label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="vehicle_no" id="vehicle_no" placeholder="Enter Consignee Name" class="form-control" readonly>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Destination </label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="destination" id="destination" placeholder="Enter Destination" class="form-control" readonly>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Weight</label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="wt_mt" id="wt_mt" placeholder="Enter Truck Number" class="form-control" readonly>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Receive Weight</label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="rec_wt" id="rec_wt" placeholder="Enter Owner Name" class="form-control" readonly>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Company Rate</label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="comp_rate" id="comp_rate" placeholder="Company Rate" class="form-control" readonly>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Own Rate</label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="own_rate" id="own_rate" placeholder="Own Rate" class="form-control" readonly>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4"> <span style="color: red">*</span>Freight Amt</label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="freight_amt" id="freight_amt" placeholder="Amount" class="form-control">
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Freight Rate</label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="freight_rate" id="freight_rate" placeholder="Freight Rate" class="form-control">
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="row">

                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Commision</label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="commision" id="commision" placeholder="Commision" class="form-control" readonly>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Bilty Commision</label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="bilty_commision" id="bilty_commision" placeholder="Bilty Commision" class="form-control" onchange="gettotal();">
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Shortage Amt</label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="sortamt" id="sortamt" placeholder="Shortage Amount" class="form-control" readonly>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Shortage MT/BAGS</label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="shortage" id="shortage" placeholder="Shortage " class="form-control" readonly>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4"><span style="color: red">*</span>Tds % </label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="tds" id="tds" placeholder="Tds " onchange="gettds();" class="form-control">
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">TDS Amt </label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="tds_amt" id="tds_amt" placeholder="Enter Place Name" class="form-control" readonly>
                                                      </div>
                                                   </div>
                                                </div>

                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Diesel Adv. Amt.</label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="diesel_adv_amt" id="diesel_adv_amt" placeholder="Diesel Advance Amount" class="form-control" readonly>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Cash Advance </label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="cash_adv" id="cash_adv" placeholder="Cash Advance" class="form-control" readonly>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>

                                             <div class="row">
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4"> GPS Amt</label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="other_cash_adv" id="other_cash_adv" placeholder="GPS Amt" class="form-control" readonly>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3" style="display:none;">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Consignor Cash Adv.</label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="consignor_cash_adv" id="consignor_cash_adv" placeholder="Consignor Cash Advance" class="form-control" readonly>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Adv Paid To</label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="paid_to" id="paid_to" placeholder="Advance Paid To" class="form-control" readonly>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Payee Name</label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="payee_name" id="payee_name" placeholder="Payee Name" class="form-control">
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Account No.</label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="acc_no" id="acc_no" placeholder="Account Number" class="form-control">
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Ifsc Code</label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="ifsc_code" id="ifsc_code" placeholder="" class="form-control">
                                                      </div>
                                                   </div>
                                                </div>

                                                <div class="col-sm-3" style="display:none;">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Consignee Cash Adv.</label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="consignee_cash_adv" id="consignee_cash_adv" placeholder="Consignee Cash Advance" class="form-control" readonly>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Voucher Date</label>
                                                      <div class="col-sm-8">
                                                         <input type="date" name="payment_date" id="payment_date" placeholder="Consignee Cash Advance" class="form-control">
                                                      </div>
                                                   </div>
                                                </div>


                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4"> Bill Type</label>
                                                      <div class="col-sm-8">
                                                         <select name="bill_type" id="bill_type" class='select2-me' style="width:100%;" onchange="showGst(this.value);" required>
                                                            <option value="">Select</option>

                                                            <option value="Challan">Challan</option>
                                                            <option value="Invoice">Invoice</option>
                                                            <script>
                                                               document.getElementById('bill_type').value = '<?php echo $bill_type; ?>';
                                                            </script>
                                                         </select>

                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3" id="th1">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4"> GST Type</label>
                                                      <div class="col-sm-8">
                                                         <select name="gst_type" id="gst_type" class='select2-me' style="width:100%;">
                                                            <option value="">Select</option>

                                                            <option value="GST">GST</option>
                                                            <option value="IGST">IGST</option>
                                                            <script>
                                                               document.getElementById('gst_type').value = '<?php echo $gst_type; ?>';
                                                            </script>
                                                         </select>

                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-sm-3" id="th2">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4"> GST %</label>
                                                      <div class="col-sm-8">
                                                         <select name="gstper" id="gstper" class='select2-me' style="width:100%;" onchange="getgstvalue1();">
                                                            <option value="">Select</option>

                                                            <option value="5">5% </option>
                                                            <option value="12">12%</option>
                                                            <option value="18">18%</option>
                                                            <option value="28">28%</option>
                                                            <script>
                                                               document.getElementById('gstper').value = '<?php echo $gstper; ?>';
                                                            </script>
                                                         </select>

                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3" id="th3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Net Amt</label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="netamt1" id="netamt1" placeholder="Net Amt" class="form-control" readonly>
                                                      </div>
                                                   </div>
                                                </div>

                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">remark</label>
                                                      <div class="col-sm-8">
                                                         <input type="test" name="remark" id="remark" placeholder="Remark" class="form-control">
                                                      </div>
                                                   </div>
                                                </div>

                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Amt Paid TO</label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="total" id="total" placeholder="Amount Paid To" class="form-control" readonly>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-sm-12">
                                                   <div class="form-actions">
                                                      <center>
                                                         <a type="submit" onclick="savesinglevoucher();" class="btn btn-primary">Save</a>
                                                         <a type="button" onclick="jQuery('#ventry').click();" class="btn btn-red">Cancel</a>
                                                      </center>
                                                   </div>
                                                </div>
                                             </div>
                                          </form>
                                       </div>
                                    </div>
                                 </div>

                                 <br />
                              </div>
                           <?php } ?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <script type="text/javascript" language="javascript">
      $(document).ready(function() { /// Wait till page is loaded
         $('#report').click(function() {
            location = 'payment_report.php';
         });
      });
   </script>
   <script type="text/javascript" language="javascript">
      $(document).ready(function() { /// Wait till page is loaded
         $('#preport').click(function() {
            location = 'paid_unpaid_report.php';
         });
      });
   </script>
   <script type="text/javascript" language="javascript">
      $(document).ready(function() { /// Wait till page is loaded
         $('#vreport').click(function() {
            location = 'voucher_report.php';
         });
      });
   </script>
   <script type="text/javascript" language="javascript">
      $(document).ready(function() { /// Wait till page is loaded
         $('#tpareport').click(function() {

            location = 'tpareport.php';
         });
      });
   </script>
   <script type="text/javascript" language="javascript">
      $(document).ready(function() { /// Wait till page is loaded

         jQuery('.select2-me').select2();
         $("#showsingle").hide();


         $('input[type="radio"][name=example]').click(function() {

            var demovalue = $(this).val();
            //  alert(demovalue);

            if (demovalue == 'single') {
               $("#showmultiple").hide();
               $("#showsingle").show();
            }
            if (demovalue == 'multiple') {
               $("#showmultiple").show();
               $("#showsingle").hide();
            }
            // jQuery('#demovalue').val('');   
         });
         /// can add another function here
      });
   </script>
   <script type="text/javascript" language="javascript">
      $(document).ready(function() { /// Wait till page is loaded
         $('#ventry').click(function() {
            $('#main1').load('voucher_entry.php #main', function() {
               jQuery('.select2-me').select2();
               $("#showsingle").hide();
               $('input[type="radio"]').click(function() {
                  var demovalue = $(this).val();

                  if (demovalue == 'single') {
                     $("#showmultiple").hide();
                     $("#showsingle").show();
                  }
                  if (demovalue == 'multiple') {
                     $("#showmultiple").show();
                     $("#showsingle").hide();
                  }
                  // jQuery('#demovalue').val('');   
               });
            });
            /// can add another function here
         });
      });
      //// End of Wait till page is loaded
   </script>
   <script type="text/javascript" language="javascript">
      $(document).ready(function() { /// Wait till page is loaded
         $('#vpayment').click(function() {
            $('#main1').load('voucher_payment.php #main', function() {
               jQuery('.select2-me').select2();
               // jQuery('#demovalue').val('');   
            });
         });
      }); //// End of Wait till page is loaded
   </script>
   <script></script>
   <script type="text/javascript">
      function funDel(id) {
         // alert(id);
         var tablename = '<?php echo $tblname ?>';
         var tableid = '<?php echo $tblpkey ?>';
         if (confirm("Do You want to Delete this record ?")) {
            // alert(tableid);
            jQuery.ajax({
               type: 'POST',
               url: 'ajax/delete_master.php',
               data: 'id=' + id + '&tablename=' + tablename + '&tableid=' + tableid,
               dataType: 'html',
               success: function(data) {
                  location = '<?php echo $pagename ?>?action=3';

               }
            }); //ajax close
         }
      }
   </script>
</body>

</html>