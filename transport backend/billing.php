<?php
error_reporting(0);
include("adminsession.php");
include("function/bill_function.php");
$tblname = "dispatch_entry";
$tblpkey = "dispatch_id";
$pagename = "billing.php";
$modulename = "Invoice Entry";
$duplicate = '';
if (isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = "";
}

if (isset($_GET['dbillid'])) {
    $dbillid = $_GET['dbillid'];
   
   
} else
   $dbillid = 0;
   $privilege_id =$cmn->getvalfield($connection,"user_privilege","count(privilege_id)","menu_id='6' && submenu_id='11' && subcat_id=0  && user_id='$user_id'");

if(isset($_GET['edit'])) {
	$invoiceid = trim(addslashes($_GET['edit']));
	$invno = $cmn->getvalfield($connection,"invoicebilty","invno","invoiceid='$invoiceid'");
	$invdate = $cmn->getvalfield($connection,"invoicebilty","invdate","invoiceid='$invoiceid'");
	$itemtype = $cmn->getvalfield($connection,"invoicebilty","itemtype","invoiceid='$invoiceid'");	
	$billtype = $cmn->getvalfield($connection,"invoicebilty","billtype","invoiceid='$invoiceid'");
	$gst = $cmn->getvalfield($connection,"invoicebilty","gst","invoiceid='$invoiceid'");	
	$gsttype = $cmn->getvalfield($connection,"invoicebilty","gsttype","invoiceid='$invoiceid'");	
	$planttype=	$cmn->getvalfield($connection,"invoicebilty","planttype","invoiceid='$invoiceid'");	
}
else
{


	
     	// $serial = $cmn->getvalfield($connection, "invoicebilty", "max(sno)", "1=1");
    //  $sno=$serial + 1;


$invoiceid=0;
// $invno='FGC/GA/24/'.$sno;
$invdate = date('Y-m-d');
$itemtype='';
}

if(isset($_GET['search']))
{
	$fromdate = $_GET['fromdate'];
	$todate =  $_GET['todate'];
	$type = $_GET['type'];
	$item_id = $_GET['item_id'];
	
}
else
{  
    $condtionDate='31-03-$y';
    $cuurenntdate=date('d-m-Y');
    if($cuurenntdate>$condtionDate){
         $yy=date('Y');
         $stardate="01-04-".$yy;
       
    }else {
         $yy=date('Y')-1;
        $stardate="01-04-".$yy;
    }
    
	$fromdate = date("Y-m-d", strtotime($stardate));
	$todate = date('Y-m-d');
	$type='';
	$item_id='';
}

if(isset($_GET['item_id']))
{
	$item_id=trim(addslashes($_GET['item_id']));
}
else
$item_id='';
if(isset($_GET['consignor_id']))
{
	$consignor_id=trim(addslashes($_GET['consignor_id']));
}
else
$consignor_id='';
if(isset($_GET['consignee_id']))
{
	$consignee_id=trim(addslashes($_GET['consignee_id']));
}
else
$consignee_id='';


if($fromdate !='' && $todate !='')
{
		$crit.=" and bilty_date between '$fromdate' and '$todate' ";	
}

if($consignor_id !='') {
	$crit .=" and A.consignor_id='$consignor_id' ";
}
if($consignee_id !='') {
	$crit .=" and A.consignee_id='$consignee_id' ";
}
if($item_id !='') {
	$crit .=" and A.item_id='$item_id' ";
}

if($type !='') {
	$crit .=" and A.type='$type' ";
}

if($_GET['tabtype']=='d_bill'){
	$variable='d_bill';

	//$liclass="class='active";
}
else if($_GET['tabtype']=='manual_bill'){
	$variable='manual_bill';
	//$liclass="class='active";
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

	<title>BILLING :: CHAARUVI INFOTECH PVT. LTD.</title>

	<?php include("inc/top-files.php"); ?>
</head>

<body onLoad="showdrecord();">
<div class="modal fade" id="myModald" role="dialog">
   <div class="modal-dialog" style="width:850px;padding-top: 225px;">
      <div class="modal-content" style="border-radius: 20px;">
         <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
            <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
            <center>
               <h4 class="modal-title"><b>ADD DEDUCTION<b></h4>
            </center>
         </div>
         <div class="modal-body" style="padding-top:30px;">
            <table class="table table-bordered">
               <thead>
                  <tr>
                     <th style="font-size:15px;font-weight:bold;">Deduction Name</th>
                     <th style="font-size:15px;font-weight:bold;">Sap Doc No.</th>
                     <th style="font-size:15px;font-weight:bold;">Inv/Ref No.</th>
                     <th style="font-size:15px;font-weight:bold;">Date</th>
                     <th style="font-size:15px;font-weight:bold;">Amount</th>
                     <th style="font-size:15px;font-weight:bold;">Remark</th>
                     <th style="font-size:15px;font-weight:bold;">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>
                        <select name="other_id" id="other_id" class="form-control" required>
                           <option value="">Select</option>
                           <?php 
                              $sql = mysqli_query($connection, "Select * from m_deduction order by other_id");
                              while ($row = mysqli_fetch_array($sql)) { ?>
                           <option value="<?php echo $row['other_id']; ?>"><?php echo $row['deduct_name']; ?></option>
                           <?php } ?>
                        </select>
                     </td>
                     <td>
                        <input type="text" name="sap_doc_no" id="sap_doc_no" class="form-control" required>
                     </td>
                     <td>
                        <input type="text" name="inv_ref_no" id="inv_ref_no" class="form-control" required>
                     </td>
                     <td>
                        <input type="date" name="ddate" id="ddate" class="form-control" required>
                     </td>
                     <td>
                        <input type="text" name="damt" id="damt" class="form-control" required>
                     </td>
                     <td>
                        <input type="text" name="dremark" id="dremark" class="form-control" required>
                     </td>
                     <td> <input type="button" class="btn btn-primary" onClick="save_deduction();"  value="ADD" class="form-control" required></td>
                  </tr>
               </tbody>
            </table>
            <div id="showdrecord"></div>
         </div>
         <div class="modal-footer">
            <center>
               <button class="btn btn-primary" tabindex="12" onclick="getdamt();"> Save</button>
               <input type="button" data-dismiss="modal" class="btn btn-danger" value="Close">
               <!-- <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a> -->
            </center>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="myModald1" role="dialog">
		<div class="modal-dialog" style="width:680px;padding-top: 225px;">


			<div class="modal-content" style="border-radius: 20px;">
				<div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
					<!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
					<center>
						<h4 class="modal-title"><b>ADD INCENTIVE / DEDUCT<b></h4>
					</center>
				</div>
				<div class="modal-body" style="padding-top:30px;">
					<div class="row mb-3">
					    <div class="col-sm-6">
							<label>Type <span style="color:red;">*</span></label>
							<select name="type" id="type" class="form-control select2-me">
                                <option value="">Select</option>
								<option value="incentive">Incentive</option>
								<option value="Deduct">Deduct</option>
							</select>
							
						</div>
						<div class="col-sm-6">
							<label>Ref No.<span style="color:red;">*</span></label>
							<input type="text" name="ref_no" id="ref_no" class="form-control">
						</div>
						
					</div>

					<div class="row mb-3">
					    <div class="col-sm-6">
							<label>Received Date<span style="color:red;">*</span></label>
							<input type="date" name="receive_date" id="receive_date1" class="form-control">
						</div>

						<div class="col-sm-6">
							<label>TDS</label>
							<input type="number" name="tds_amt" id="tds_amt1" class="form-control">
						</div>
					
					</div>

					<div class="row mb-3">
					    	<div class="col-sm-6">
							<label>GST</label>
							<input type="number" name="incgst" id="incgst" class="form-control">
						</div>
						<div class="col-sm-6">
							<label>GST Amt</label>
							<input type="number" name="gst_amt1" id="gst_amt1" class="form-control">
						</div>
						

					</div>
					<div class="row mb-3">
					    <div class="col-sm-6">
							<label>Received Amt<span style="color:red;">*</span></label>
							<input type="number" name="received_amt" id="received_amt1" class="form-control">
						</div>
						<div class="col-sm-6">
							<label>Narration</label>
							<input type="text" name="remark" id="remark1" class="form-control">
						</div>
					</div>

					<div class="modal-footer">
						<center>
							<button class="btn btn-primary" onClick="save_insentive();" tabindex="12"> Save</button>
							<input type="button" data-dismiss="modal" class="btn btn-danger" value="Close">
						</center>
					</div>
				</div>

			</div>
		</div>

	</div>
<div class="modal fade" id="myModaldshow" role="dialog">
   <div class="modal-dialog" style="width:850px;padding-top: 225px;">
      <div class="modal-content" style="border-radius: 20px;">
         <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
            <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
            <center>
               <h4 class="modal-title"><b>DEDUCTION DETAILS<b></h4>
            </center>
         </div>
         <div class="modal-body" style="padding-top:30px;">
          
            <div id="showdeduct"></div>
         </div>
         <div class="modal-footer">
            <center>
             
               <input type="button" data-dismiss="modal" class="btn btn-danger" value="Close">
               <!-- <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a> -->
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
									<i class="fa fa-bars"></i>Billing
								</h3>
							</div>
							<div class="box-content nopadding">
								<ul class="tabs tabs-inline tabs-top">
								<?php $subsn = 1;
							$sql1 = mysqli_query($connection, "select * from user_privilege where menu_id='6' && submenu_id!=0 && subcat_id=0 && user_id='$user_id'  order by submenu_id  asc");
							while ($row1 = mysqli_fetch_array($sql1)) { 
								$activity2=$row1['status'];		
								$submenu_id=$row1['submenu_id'];	
								$submenu =$cmn->getvalfield($connection,"m_submenu","submenu","submenu_id='$submenu_id'"); 
							
								$pagelink2 =$cmn->getvalfield($connection,"m_submenu","pagelink","submenu_id='$submenu_id'"); 
								$sub_cat =$cmn->getvalfield($connection,"m_submenu","sub_cat","submenu_id='$submenu_id'");
								
								?>
									<li <?php if($sub_cat==1){ ?> class='active'<?php }?> >
										<a id="<?php echo $pagelink2; ?>" data-toggle='tab'>
											<i class="fa fa-inbox"></i><?php echo ucfirst($submenu); ?></a>
									</li>
									<?php } ?>
									<!-- <li class='active'>
										<a id="dispatch" data-toggle='tab'>
											<i class="fa fa-inbox"></i>Create Invoice</a>
									</li> -->
									<li>
										<a id="report" data-toggle='tab' style="background: #2563eb; color: #ffffff">
											<i class="fa fa-share"></i>Invoice Report</a>
									</li>
										<li>
										<a id="breport" data-toggle='tab' style="background: #2563eb; color: #ffffff">
											<i class="fa fa-share"></i>Invoice Status Report</a>
									</li>
									<!-- <li>
										<a id="manual_bill" data-toggle='tab'>
											<i class="fa fa-tag"></i>Invoice Payment</a>
									</li> -->
									<li>
										<a id="adreport" data-toggle='tab' style="background: #2563eb; color: #ffffff">
											<i class="fa fa-share"></i>Invoice Payment Report</a>
									</li>
									<!-- <li>
										<a id="d_bill" data-toggle='tab'>
											<i class="fa fa-tag"></i>Diesel Bill Entry</a>
									</li> -->
									<li>
										<a id="d_report" data-toggle='tab' style="background: #2563eb; color: #ffffff">
											<i class="fa fa-share"></i>Diesel Bill Report</a>
									</li>
									<!-- <li>
										<a id="d_pay" data-toggle='tab'>
											<i class="fa fa-tag"></i>Diesel Bill Payment</a>
									</li> -->
									<li>
										<a id="d_payreport" data-toggle='tab' style="background: #2563eb; color: #ffffff">
											<i class="fa fa-tag"></i>Diesel Bill Payment Report</a>
									</li>
	<li>
										<a id="dcbook" data-toggle='tab' style="background: #2563eb; color: #ffffff">
											<i class="fa fa-tag"></i>Diesel Cash Book</a>
									</li>
								</ul>
								<div class="tab-content padding tab-content-inline tab-content-bottom" id="main1">
								<?php if($privilege_id==1){ ?>
									<div class="tab-pane active" id="first11">
										<div class="col-sm-12">
											<div class="row" style="padding-top:20px;">
												<div class="col-sm-12">
													<?php if ($duplicate != '') { ?>
														<div class="alert alert-warning">
															<button data-dismiss="alert" class="close" type="button">×</button>
															<strong><i class="fa fa-clone"></i> Warning! The value you entered is already in the list. </strong>
														</div>
													<?php } ?>
													<?php include("inc/alert.php"); ?>
												</div>
											</div>
											<div class="box box-bordered box-color">
												<div class="box-title">



													<h3><i class="fa fa-list"></i>Dispatch Entry</h3>


												</div>

												<div class="box-content nopadding">

													<form action="#" method="get" class='form-horizontal form-column form-bordered' enctype="multipart/form-data">
														<div class="row">
															<div class="col-sm-4">
																<div class="form-group"> <label for="textfield" class="control-label col-sm-4">From Date 
																	<span style="color: red">*</span></label>
															<div class="col-sm-8">
																		<input type="date" name="fromdate" id="fromdate" placeholder="Text input" class="form-control" value="<?php echo $fromdate; ?>" required>
																	</div>
																</div>

															</div>

															<div class="col-sm-4">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">To Date <span style="color: red">*</span></label>
															<div class="col-sm-8">
				<input type="date" name="todate" id="todate" placeholder="Text input" class="form-control" value="<?php echo $todate; ?>" required>
																	</div>
																</div>

															</div>

															<div class="col-sm-4">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">Item <span style="color: red">*</span></label>
																	<div class="col-sm-8">
<select name="item_id" id="item_id" class='select2-me' style="width:100%;" >
											<option value="">Select</option>
							<?php $sql = mysqli_query($connection, "Select * from  m_item  order by item_id");
										while ($row = mysqli_fetch_array($sql)) { ?>
				<option value="<?php echo $row['item_id']; ?>"><?php echo $row['item_name']; ?></option>
																	<?php } ?>
																		</select>
											<script>
				document.getElementById('item_id').value = '<?php echo $item_id; ?>';
																</script>
																	</div>
																</div>

															</div>
                                          </div>
                                          <div class="row">

															<div class="col-sm-4">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">Consignee</label>
																	<div class="col-sm-8">
																		<select name="consignee_id" id="consignee_id" class='select2-me' style="width:100%;">
																		<option value=""> Select </option>
																	<?php $sql = mysqli_query($connection, "Select * from  m_consignee  order by consignee_id");
											while ($row = mysqli_fetch_array($sql)) { ?>
																				<option value="<?php echo $row['consignee_id']; ?>"><?php echo $row['consignee_name']; ?></option>
																			<?php } ?>
																		</select>
																		<script>
																			document.getElementById('consignee_id').value = '<?php echo $consignee_id; ?>';
																		</script>
																	</div>
																</div>

															</div>

															<div class="col-sm-4">
																<div class="form-group">

																	<label for="textfield" class="control-label col-sm-4">Consignor</label>
																	<div class="col-sm-8">
																		<select name="consignor_id" id="consignor_id" class='select2-me' style="width:100%;">
																			<option value=""> Select </option>
																			<?php $sql = mysqli_query($connection, "Select * from  m_consignor  order by consignor_id");
																			while ($row = mysqli_fetch_array($sql)) { ?>
																				<option value="<?php echo $row['consignor_id']; ?>"><?php echo $row['consignor_name']; ?></option>
																			<?php } ?>
																		</select>
																		<script>
																			document.getElementById('consignor_id').value = '<?php echo $consignor_id; ?>';
																		</script>
																	</div>
																</div>
															</div>

															<div class="col-sm-4">
													<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">Type</label>
																	<div class="col-sm-8">
																		<select name="type" id="type" class="form-control" style="width:100%;">
												<option value="">Select</option>
										<option value="Party">Party</option>
										<option value="Depo">Depo</option>
										 <option value="Non Trade">Non Trade</option>
                                    <option value="Clinker">Clinker</option>
                                        <option value="Manual">Manual</option>
																		</select>
														<script>
					document.getElementById('type').value = '<?php echo $type; ?>';
																		</script>
																	</div>
																</div>

															</div>

														</div>

														<div class="row">
															<div class="col-sm-12">
																<div class="form-actions">
																	<center>
		<input type="submit" name="search" class="btn btn-primary" value="Search" onClick="return checkinputmaster('fromdate,todate');" style="width:80px;">
					<a type="button" href="<?php echo $pagename; ?>" class="btn btn-red">Cancel</a>
																	</center>
																</div>
															</div>
														</div>
													</form>
												</div>

												<div class="box box-color box-bordered red">
													<div class="box-title">
														<h3> <i class="fa fa-table"></i>
															 Dispatch Details</h3>


														<!-- <a href="all-dispatch-entry.php" class="btn btn-warning" style="float: right">Click Here For All Entry -->
															<!-- <i class="fa fa-object-group"></i> -->
														<!-- </a> &nbsp; -->


														<!-- <a href="all-dispatch-entry.php" style="text-align: right" target="_blank">All Record</a> -->

 <input type="hidden" id="hiddenid" value="" >

                                       <!-- <input type="button" class="btn btn-success" value="Create Invoice" style="text-align:right; float:right;" onClick="createinvoice();" >  -->

<?php if($invoiceid==0) { ?>
							<input type="button" class="btn btn-success" value="Create Invoice" style="text-align:right; float:right;" onClick="createinvoice();" > <?php } else { ?>
							<input type="button" class="btn btn-success" value="Update Invoice" style="text-align:right; float:right;" onClick="createinvoice();" >
							<?php } ?>




                                       
														<!-- <a href="pdf/pdf_dispatch_entry.php" class="btn" style="float: right" target="_blank">Pdf -->
															<!-- <i class="fa fa-file-pdf-o"></i> -->
														<!-- </a> &nbsp; -->
														<!-- <a href="excel/excel_dispatch_entry.php" class="btn btn-warning" style="float: right">Excel -->
															<!-- <i class="fa fa-file-excel-o"></i> -->
														<!-- </a> -->

													</div>
													<div class="box-content nopadding" style="overflow:scroll;">
													    <br>
													    <center>
														&nbsp; &nbsp;<strong>Search Here</strong> <input id="myInput" type="text" placeholder="Search.." onkeyup="myFunctionsearch()" >
</center>
														<?php if($invoiceid==0) { 
// echo "ok";
															?>

														<table class="table table-hover table-nomargin table-striped table-bordered" style="margin-top:20px;">
															<thead>
																<tr>
																	<th><input type="checkbox" name="chk0" id="chk0" onClick="toggle(this.checked)" />All </th>
                               <th>DI No</th>
                                                <th>Invoice No</th>
                                                 <th>Bilty Date</th>
                                                 <th>Truck No</th>
                                                  <th>GR No</th>
                                               
                                                <th>Consignee</th>
                                                <th>Destination</th>
                                                 <th>Item Name</th> 
                                                <th>Weight/(M.T.)</th>
                                                <th>Rate/MT</th>
                                                <!--<th>Print</th>-->
                                                <th>Freight</th>
                                                <th>Advance</th>
                                                <th>Diesel Rs</th>
                                                <th>Petrol Pump</th>
                                                <th>Brand</th>
												<th>User Name</th>  
															
																</tr>
															</thead>
															<tbody id="myTable">
																   <?php
                                                $slno=1;									
                                                if($user_type=='admin')
                                                {
                                                	$cond="where 1=1 ";	
                                                }
                                                else
                                                {
                                                	$cond="where 1=1 ";	
                                                }
                                         // echo        "select A.* from  dispatch_entry as A left join m_consignee as B on A.consignee_id = B.consignee_id $cond && A.session_id='$session_id' $crit  && A.consignor_id=$consignorid order by dispatch_id desc";
                  $sel = "select A.* from  dispatch_entry as A left join m_consignee as B on A.consignee_id = B.consignee_id $cond && A.session_id='$session_id' $crit  && A.consignor_id=$consignorid && A.comp_id=$comp_id && A.is_invoice=0  && A.session_id=$session_id order by dispatch_id desc";
                                                $res = mysqli_query($connection,$sel);
                                                while($row = mysqli_fetch_array($res))
                                                {									
                                                // $gr_date = $row['gr_date'];
                                                $truckid = $row['vehicle_id'];
                                                $item_id = $row['item_id'];
                                                $consigneeid = $row['consignee_id'];
                                                $destinationid = $row['destination_id'];
                                                $supplier_id = $row['pump_id'];
                                                $brand_id = $row['brand_id'];
                                                $s = $row['bilty_date'];
                                                $dt = new DateTime($s);								
                                                $date = $dt->format('d-m-Y');
                                                $time = $dt->format('H:i:s');	
                                                $user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
                                                $advance = $row['other_cash_adv']+$row['cash_adv'];
                                                ?>
                                             <tr>
                                                <td><input type="checkbox" name="chk<?php echo $slno; ?>" id="chk<?php echo $slno; ?>" onClick="addids()" value="<?php echo $row['dispatch_id']; ?>" <?php //if($exist){ echo "Checked" ;}?>/></td>
                                                <td><?php echo $row['di_no'];?></td>
                                                  <td><?php echo $row['invoice_no'];?></td>
                                                <td><?php echo $cmn->dateformatindia($row['bilty_date']);?></td>
                                                                                                <td><?php echo $cmn->getvalfield($connection," m_vehicle","vehicle_no","vehicle_id='$truckid'");?></td>

                                                <td><?php echo $row['gr_no'];?></td>
                                               <td><?php echo $cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id='$consigneeid'");?></td>
                                                <td><?php echo $cmn->getvalfield($connection,"m_place","place_name","place_id='$destinationid'");?></td>
                                              
                                             
                                                <td><?php echo $cmn->getvalfield($connection,"	m_item","item_name","item_id='$item_id'");?></td>
                                                 <td><?php echo ucfirst($row['wt_mt']);?></td>
                                                <td><?php echo ucfirst($row['own_rate']);?></td>
                                                <!--<td><a href= "pdf_bill_invoice.php?bilty_id=<?php //echo $row['bid_id'];?>" class="btn btn-success" target="_blank" >Print </a></td>-->
                                                <td><?php echo number_format($row['wt_mt'] * $row['own_rate'],2);?></td>
                                                <td><?php echo number_format($advance,2);?></td>
                                                <td><?php echo ucfirst($row['diesel_adv_amt']);?></td>
                                                <td><?php echo $cmn->getvalfield($connection,"m_petrol_pump","pump_name","pump_id='$supplier_id'");?></td>
                                                <td><?php echo $cmn->getvalfield($connection,"m_brand","brand_name","brand_id='$brand_id'");?></td>
													<td><?php echo $user_name; ?></td>
                                             </tr>
                                             <?php
                                                $slno++;
                                                }
                                                ?>															</tbody>
														</table>
<?php } else {
							// echo "hi";
							 ?><table class="table table-hover table-nomargin table-striped table-bordered">
															<thead>
																<tr>
																	<th><input type="checkbox" name="chk0" id="chk0" onClick="toggle(this.checked)" />All </th>
                               <th>DI No</th>
                                                <th>Invoice No</th>
                                                 <th>Bilty Date</th>
                                                 <th>Truck No</th>
                                                  <th>GR No</th>
                                               
                                                <th>Consignee</th>
                                                <th>Destination</th>
                                                 <th>Item Name</th> 
                                                <th>Weight/(M.T.)</th>
                                                <th>Rate/MT</th>
                                                <!--<th>Print</th>-->
                                                <th>Freight</th>
                                                <th>Advance</th>
                                                <th>Diesel Rs</th>
                                                <th>Petrol Pump</th>
                                                <th>Brand</th>
												<th>User Name</th>  
																</tr>
															</thead>
															<tbody id="myTable">
																   <?php
                                                $slno=1;									
                                                if($user_type=='admin')
                                                {
                                                	$cond="where 1=1 ";	
                                                }
                                                else
                                                {
                                                	$cond="where 1=1 ";	
                                                }
                                                
                                           $sel = "select * from dispatch_entry $cond && session_id='$session_id' && consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id  && (is_invoice=0 || invoiceid='$invoiceid') order by invoiceid desc";
                                                $res = mysqli_query($connection,$sel);
                                                while($row = mysqli_fetch_array($res))
                                                {									
                                                // $gr_date = $row['gr_date'];
                                                $truckid = $row['vehicle_id'];
                                                $item_id = $row['item_id'];
                                                $consigneeid = $row['consignee_id'];
                                             $destinationid = $row['destination_id'];
                                                $supplier_id = $row['pump_id'];
                                                $brand_id = $row['brand_id'];
                                                $s = $row['bilty_date'];
                                                $dt = new DateTime($s);								
                                                $date = $dt->format('d-m-Y');
                                                $time = $dt->format('H:i:s');	
                                                $user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
                                                $advance = $row['other_cash_adv']+$row['cash_adv'];
                                                $exist = $cmn->getvalfield($connection,"dispatch_entry","count(*)","invoiceid='$invoiceid' && dispatch_id='$row[dispatch_id]'");	
                                                ?>
                                             <tr>
                                                <td><input type="checkbox" name="chk<?php echo $slno; ?>" id="chk<?php echo $slno; ?>" onClick="addids()" value="<?php echo $row['dispatch_id']; ?>" <?php if($exist !=0){ echo "Checked" ;}?>/></td>
                                               <td><?php echo $row['di_no'];?></td>
                                        <td><?php echo $row['invoice_no'];?></td>          <td><?php echo $cmn->dateformatindia($row['bilty_date']);?></td>
                                                                                             <td><?php echo $cmn->getvalfield($connection," m_vehicle","vehicle_no","vehicle_id='$truckid'");?></td>

                                                <td><?php echo $row['gr_no'];?></td>
                                              
                                              <td><?php echo $cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id='$consigneeid'");?></td>
                                                <td><?php echo $cmn->getvalfield($connection,"m_place","place_name","place_id='$destinationid'");?></td>
                                               
                                                <td><?php echo $cmn->getvalfield($connection,"	m_item","item_name","item_id='$item_id'");?></td>
                                                <td><?php echo ucfirst($row['wt_mt']);?></td>
                                                <td><?php echo ucfirst($row['own_rate']);?></td>
                                                <!--<td><a href= "pdf_bill_invoice.php?bilty_id=<?php //echo $row['bid_id'];?>" class="btn btn-success" target="_blank" >Print </a></td>-->
                                                <td><?php echo number_format($row['wt_mt'] * $row['own_rate'],2);?></td>
                                                <td><?php echo number_format($advance,2);?></td>
                                                <td><?php echo ucfirst($row['diesel_adv_amt']);?></td>
                                                <td><?php echo $cmn->getvalfield($connection,"m_petrol_pump","pump_name","pump_id='$supplier_id'");?></td>
                                                <td><?php echo $cmn->getvalfield($connection,"m_brand","brand_name","brand_id='$brand_id'");?></td>
												<td><?php echo $user_name; ?></td>
                                             </tr>
                                             <?php
                                                $slno++;
                                                }
                                                ?>															</tbody>
														</table>
															<?php } ?>
													</div>
												</div>


											</div>

											<br />
										</div>





									</div>


								</div>
							</div>
						</div>
					</div>
				</div>


				<?php } ?>


			</div>
		</div>
	</div>
	<script type="text/javascript" language="javascript">
		$(document).ready(function() { /// Wait till page is loaded
			$('#gst_pay').click(function() {
				$('#main1').load('gstpayment.php #main', function() {
					jQuery('.select2-me').select2();
					


					/// can add another function here
				});
			});
		}); //// End of Wait till page is loaded
	</script>
	<script type="text/javascript" language="javascript">
		$(document).ready(function() { /// Wait till page is loaded
			$('#manual_bill').click(function() {
				$('#main1').load('manual_bill_payment.php #main', function() {
					jQuery('.select2-me').select2();
					


					/// can add another function here
				});
			});
		}); //// End of Wait till page is loaded
	</script>
	<script type="text/javascript" language="javascript">
		$(document).ready(function() { /// Wait till page is loaded
			$('#dispatch').click(function() {
				$('#main1').load('billing.php #main1', function() {
					jQuery('.select2-me').select2();
					// jQuery("#advtable").html(data);

					/// can add another function here
				});
			});
		}); //// End of Wait till page is loaded
	</script>
	<script type="text/javascript" language="javascript">
		$(document).ready(function() { /// Wait till page is loaded
			$('#d_bill').click(function() {
				$('#main1').load('diesel_bill.php?dbillid=<?php echo $dbillid;?> #main', function() {
					jQuery('.select2-me').select2();
					getsearch();
						// jQuery('#demovalue').val('');   
					});
					/// can add another function here
				});
			});
	
	</script>

	<script type="text/javascript" language="javascript">
		$(document).ready(function() { /// Wait till page is loaded
			$('#report').click(function() {
				location = 'invoice_report.php';
			});
		}); //// End of Wait till page is loaded
	</script>
	<script type="text/javascript" language="javascript">
		$(document).ready(function() { /// Wait till page is loaded
			$('#breport').click(function() {
				location = 'bilty_status_report.php';
			});
		}); //// End of Wait till page is loaded
	</script>
	<script type="text/javascript" language="javascript">
		$(document).ready(function() { /// Wait till page is loaded
			$('#adreport').click(function() {
				location = 'manual_bill_payment_report.php';
			});
		}); //// End of Wait till page is loaded
	</script>
	<script type="text/javascript" language="javascript">
		$(document).ready(function() { /// Wait till page is loaded
			$('#d_report').click(function() {
				location = 'diesel_bill_report.php';
			});
		}); //// End of Wait till page is loaded
	</script>
	<script type="text/javascript" language="javascript">
		$(document).ready(function() { /// Wait till page is loaded
			$('#d_pay').click(function() {
				$('#main1').load('diesel_payment.php #main', function() {
					jQuery('.select2-me').select2();
					


					/// can add another function here
				});
			});
		}); //// End of Wait till page is loaded
	</script>
	<script type="text/javascript" language="javascript">
		$(document).ready(function() { /// Wait till page is loaded
			$('#diesel_adv').click(function() {
				$('#main1').load('diesel_advpayment.php #main', function() {
					jQuery('.select2-me').select2();
					


					/// can add another function here
				});
			});
		}); //// End of Wait till page is loaded
	</script>
	<script type="text/javascript" language="javascript">
		$(document).ready(function() { /// Wait till page is loaded
			$('#d_payreport').click(function() {
				location = 'diesel_pay_report.php';
			});
		}); //// End of Wait till page is loaded
	</script>
	<script type="text/javascript" language="javascript">
		$(document).ready(function() { /// Wait till page is loaded
			$('#dcbook').click(function() {
				location = 'diesel_cash_book.php';
			});
		}); //// End of Wait till page is loaded
	</script>
<script>
$(document).ready(function() {
   $("#<?php echo $variable;?>").trigger('click');
});
</script>
<script>

	 function save_deduction() {
         var other_id = document.getElementById('other_id').value.trim();
          var sap_doc_no = document.getElementById('sap_doc_no').value.trim();
		  var inv_ref_no = document.getElementById('inv_ref_no').value.trim();
         var ddate = document.getElementById('ddate').value.trim();
         var dremark = document.getElementById('dremark').value.trim();
           var damt = document.getElementById('damt').value.trim();
         if(other_id=='') {
         	alert("Please Select deduction");
         	return false;
         }
         else if(damt=='')
         {
         	alert("Please Add Amount");
         	return false;
         } 
         else
         {
         $.ajax({
         		  type: 'POST',
         		  url: 'ajaxbill/save_otherdeduct.php',
         		  data: 'other_id=' + other_id+'&sap_doc_no='+sap_doc_no+'&inv_ref_no='+inv_ref_no+'&ddate='+ddate
         		  +'&dremark='+dremark +'&damt='+damt,
         		  dataType: 'html',
         		  success: function(data){
         			//   alert(data);
					 showdrecord();
					 jQuery('#other_id').val('');
					jQuery('#sap_doc_no').val('');
					jQuery('#inv_ref_no').val('');
					jQuery('#ddate').val('');
					jQuery('#dremark').val('');
					jQuery('#damt').val('');
         			// window.open('pdf_invoice.php?invoiceid='+data, '_blank');
         			//  window.location='?action=1';
         			}		
         		  });//ajax close
         	}	  
         }
         function showdrecord() {
						var id = 0;
			// alert(id);

			jQuery.ajax({
				type: 'POST',
				url: 'ajaxbill/show_drec.php',
				data: 'id=' + id,
				success: function(data) {

					jQuery("#showdrecord").html(data);
				}
			}); //ajax close
		}
		function getddata(id) {
						
			// alert(id);

			jQuery.ajax({
				type: 'POST',
				url: 'ajaxbill/show_deduct.php',
				data: 'id=' + id,
				success: function(data) {

					jQuery("#showdeduct").html(data);
				}
			}); //ajax close
		}
		function getdamt(){
			// alert("ok");
			var id = 0;
			jQuery.ajax({
				type: 'POST',
				url: 'ajaxbill/show_damt.php',
				data: 'id=' + id,
				success: function(data) {
// alert(data);

					jQuery("#deduct").val(data);
					jQuery("#myModald").modal('hide');
					gettotal();
				}
			}); 
		}
</script>
<script type="text/javascript">
        function funDel1(id) {
        
            var tablename = 'other_deduct';
            var tableid = 'deduct_id';
            if (confirm("Do You want to Delete this record ?")) {
                // alert(tableid);
                jQuery.ajax({
                    type: 'POST',
                    url: 'ajax/delete_master.php',
                    data: 'id=' + id + '&tablename=' + tablename + '&tableid=' + tableid,
                    dataType: 'html',
                    success: function(data) {
						showdrecord();
						gettotal();
                    }
                }); //ajax close
            }
        }
    </script>
	  <script>
		
         function funDel(id)
         {    
         	  //alert(id);   
         	  tblname = 'invoicebilty';
         	   tblpkey = 'invoiceid';
         	   pagename  ='<?php echo $pagename; ?>';
         		modulename  ='<?php echo $modulename; ?>';
         	  //alert(tblpkey); 
         	if(confirm("Are you sure! You want to delete this record."))
         	{
         		$.ajax({
         		  type: 'POST',
         		  url: '../ajax/deleteinvoice.php',
         		  data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename,
         		  dataType: 'html',
         		  success: function(data){
         			 // alert(data);
         			 // alert('Data Deleted Successfully');
         			  location=pagename+'?action=10';
         			}
         		
         		  });//ajax close
         	}//confirm close
         } //fun close
         
         
         //below code for date mask
         jQuery(function($){
            $("#fromdate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
          
         });
         
         jQuery(function($){
            $("#todate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
            $("#invdate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
          
         });
         
         
         function addids()
         {
             strids="";
             var cbs = document.getElementsByTagName('input');
             var len = cbs.length;
             for (var i = 1; i < len; i++)
             {
                  if (document.getElementById("chk" + i)!=null)
                  {
                       if (document.getElementById("chk" + i).checked==true)
                       {
                            if(strids=="")
                            strids=strids + document.getElementById("chk" + i).value;
                            else
                            strids=strids + "," + document.getElementById("chk" + i).value;
                        }
                   }
              }
         	// alert(strids);
              document.getElementById("hiddenid").value = strids;
         }
         
         function toggle(source)
         {
         	//alert(source);
         	if(source == true)
         	{
         		//alert("hi");
         		var cbs = document.getElementsByTagName('input');
         		var cond_yes_or_no = "";
         		for (var i=0, len = cbs.length; i < len; i++)
         		{
         			if (cbs[i].type.toLowerCase() == 'checkbox')
         			{
         				cbs[i].checked = true;
         			}
         		}
         		addids()
         	}
         	else
         	{
         		//alert("hello");
         		var cbs = document.getElementsByTagName('input');
         		var cond_yes_or_no = "";
         		for (var i=0, len = cbs.length; i < len; i++)
         		{
         			if (cbs[i].type.toLowerCase() == 'checkbox')
         			{
         				cbs[i].checked = false;
         			}
         		}
         		addids()
         	}
         }
         
         function createinvoice() {
         var hiddenid = document.getElementById('hiddenid').value;
         //alert(hiddenid);
         if(hiddenid=='') {
         	alert("Please Select Bilty");
         	return false;
         }
         else
         {
         
         
         	$('#myModal').modal('show');
         	
         }
         
         }
       
         function saveinvoice() {
         
         var hiddenid = document.getElementById('hiddenid').value.trim();
          
         var invoiceno = document.getElementById('invoiceno').value.trim();
          var sno = document.getElementById('sno').value.trim();
		  var serial = document.getElementById('serial').value.trim();
		    var cserial = document.getElementById('cserial').value.trim();
		     var pserial = document.getElementById('pserial').value.trim();
         var invdate = document.getElementById('invdate').value.trim();
         var itemtype = document.getElementById('itemtype').value.trim();
           var billtype = document.getElementById('billtype').value.trim();
           var planttype = document.getElementById('planttype').value.trim();
		   var gst = document.getElementById('gst').value.trim();
		   var gsttype = document.getElementById('gsttype').value.trim();
         
         var invoiceid = '<?php echo $invoiceid; ?>';
         // alert(invoiceno);
          // alert(itemtype);
         // alert(invdate);
         if(hiddenid=='') {
         	alert("Please Select Bilty");
         	return false;
         }
         else if(invoiceno=='')
         {
         	alert("Please Add Invoice No");
         	return false;
         } else if(invdate=='')
         {
         	alert("Please Add Invoice Date");
         	return false;
         } else if(itemtype=='') {
         	alert("Please Select Type");
         	return false;
         }
         else
         {
         $.ajax({
         		  type: 'POST',
         		  url: 'ajaxbill/ajax_create_invoice.php',
         		  data: 'hiddenid=' + hiddenid+'&invoiceno='+invoiceno+'&invdate='+invdate+'&invoiceid='+invoiceid+'&gsttype='+gsttype
         		  +'&itemtype='+itemtype +'&sno='+sno+'&billtype='+billtype+'&serial='+serial+'&planttype='+planttype+'&gst='+gst+'&cserial='+cserial+'&pserial='+pserial,
         		  dataType: 'html',
         		  success: function(data){
         			//    alert(data);
         			// window.open('pdf_invoice.php?invoiceid='+data, '_blank');
         			 window.location='?action=1';
         			}		
         		  });//ajax close
         	}	  
         }
         
         $(document).ready(function(){
           $("#myInput").on("keyup", function() {
             var value = $(this).val().toLowerCase();
             $("#myTable tr").filter(function() {
               $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
             });
           });
         });
         
         addids();
         
     function myFunctionsearch(){
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
    

      </script>	
      <div id="myModal" class="modal fade" role="dialog">
         <div class="modal-dialog" style="width:480px;padding-top: 225px;">
            <!-- Modal content-->
            <div class="modal-content" style="border-radius: 20px;">
               <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
                  <center>
                     <h4 class="modal-title">Create Invoice</h4>
                  </center>
               </div>
               <div class="modal-body" style="padding-top:30px;">
                  <div class="form-group">
                       <div class="row mb-3">
                        <label for="itemtype"  class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;"><strong>Plant :</strong></label>
                        <div class="col-sm-6">
                           <select id="planttype" class="select2-me" style="width:100%;" onchange="getnumber(this.value);">
                              <option value="scl-raipur">SCL-Raipur</option>
                              <option value="scl-raipur-gu-ii">SCL-Raipur-GU-II</option>
                              <option value="bihar">Bihar</option>
                              <option value="odisha">Odisha</option>
                               <option value="manual">Manual </option>
                           </select>
                           <script> document.getElementById('planttype').value='<?php echo $planttype; ?>'; </script>
                        </div>
                     </div>
                     <br>    
                      
                      
				  <div class="row mb-3">
                        <label for="itemtype"  class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;"><strong>Bill Type :</strong></label>
                        <div class="col-sm-6">
                           <select id="billtype" class="select2-me" style="width:100%;" onchange="getnumber(this.value);">
                              <option value="Party">Party</option>
                              <option value="Dump">Dump</option>
                                <option value="Non Trade">Non Trade</option>
                                    <option value="Clinker">Clinker</option>
                                        <option value="Manual">Manual</option>
                                        <option value="Pre Loading">Pre Loading</option>
                              
                           </select>
                           <script> document.getElementById('billtype').value='<?php echo $billtype; ?>'; </script>
                        </div>
                     </div>
                     <br>
                     <div class="row mb-3">
                        <label for="email" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;"><strong>Invoice No :</strong></label>
                        <div class="col-sm-6">
                           <input type="text" class="form-control" id="invoiceno"  readonly value="<?php echo $invno; ?>">
                           	<input type="hidden" name="sno" id="sno" placeholder="Enter Bilty No." class="form-control" value="<?php echo $sno; ?>" readonly>
					<input type="hidden" name="serial" id="serial" placeholder="Enter Bilty No." class="form-control" value="<?php echo $serial; ?>" readonly>
					<input type="hidden" name="cserial" id="cserial" placeholder="Enter Bilty No." class="form-control" value="<?php echo $cserial; ?>" readonly>
						<input type="hidden" name="pserial" id="pserial" placeholder="Enter Bilty No." class="form-control" value="<?php echo $pserial; ?>" readonly>
						</div>
                     </div>
                     <br>
                     <div class="row mb-3">
                        <label for="invdate" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;"><strong>Invoice Date :</strong></label>
                        <div class="col-sm-6">
                           <input type="text" class="form-control" id="invdate" value="<?php echo dateformatindia($invdate); ?>">
                        </div>
                     </div>
                     <br>
                     <div class="row mb-3">
                        <label for="itemtype"  class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;"><strong>Type :</strong></label>
                        <div class="col-sm-6">
                           <select id="itemtype" class="select2-me" style="width:100%;">
                              <option value="CEMENT">Cement</option>
                              <option value="LOOSE CLINKER">Clinker</option>
                           </select>
                           <script> document.getElementById('itemtype').value='<?php echo $itemtype; ?>'; </script>
                        </div>
                     </div>
                     <br>
					  <div class="row mb-3">
                        <label for="gsttype"  class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;"><strong>GST Type:</strong></label>
                        <div class="col-sm-6">
                           <select id="gsttype" class="select2-me" style="width:100%;">
							 <option value="gst">CGST/SGST</option>
							 <option value="igst">IGST</option>
                           </select>
                           <script> document.getElementById('gsttype').value='<?php echo $gsttype; ?>'; </script>
                        </div>
                     </div>
					 <br>
                     <div class="row mb-3">
                        <label for="gst"  class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;"><strong>GST :</strong></label>
                        <div class="col-sm-6">
                           <select id="gst" class="select2-me" style="width:100%;">
							 <option value="5">5%</option>
							 <option value="9">9%</option>
                              <option value="12">12%</option>
                              <option value="18">18%</option>
							 
                           </select>
                           <script> document.getElementById('gst').value='<?php echo $gst; ?>'; </script>
                        </div>
                     </div>
                     <br>
                     <!-- <button type="submit" class="btn btn-default btn-success" onClick="saveinvoice()" style="margin-top:-8px;">Submit</button> -->
                  </div>
               </div>
               <div class="modal-footer">
                  <center>
                     <button class="btn btn-primary" onClick="saveinvoice();" tabindex="12"> Save</button>
                     <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a>
                  </center>
               </div>
            </div>
         </div>
      </div>

</body>



</html>