<?php 
error_reporting(0);
include("adminsession.php");
// include("function/dispatch_function.php");
$tblname = "manualinv";
$tblpkey = "minvid ";
$pagename = "manual_bill_payment_report.php";
// $modulename = "Bilty Advance Details";
$crit='';
if(isset($_GET['search']))
{
	 $fromdate = $_GET['fromdate'];
 	$todate = $_GET['todate'];
	
}
else
{
	$fromdate = $currentdate;
	$todate = $currentdate;

}

if (isset($_GET['consignor_id'])) {
	$consignor_id = trim(addslashes($_GET['consignor_id']));
} else
	$consignor_id = '';
	

if (isset($_GET['vehicle_id'])) {
	$vehicle_id = trim(addslashes($_GET['vehicle_id']));
} else
	$vehicle_id = '';


if ($fromdate != '' && $todate != '') {
	$crit .= "where bilty_date BETWEEN  '$fromdate' and  '$todate' ";
	//echo $crit;
}

if ($vehicle_id != '') {
	$crit .= " and vehicle_id='$vehicle_id'";
}
if ($consignor_id != '') {
	$crit .= " and consignor_id='$consignor_id'";
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

	<title> ALL DISPATCH :: CHAARUVI INFOTECH PVT. LTD.</title>

<?php include("inc/top-files.php"); ?>	
</head>

<body>
	    <!-- Edit Modal Start-->
	<div class="modal fade" id="myModal9" role="dialog">
    <div class="modal-dialog" style="width:900px;padding-top: 150px;" >


      <div class="modal-content" style="border-radius: 20px;">
        <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
          <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
          <center>
          <h4 class="modal-title"><b>EDIT ADVANCE ENTRY<b></h4></center>
        </div>
        <div class="modal-body" style="padding-top:30px;" id="updatedata">
    
        </div>

      </div>
    </div>

  </div>
  <!-- Edit Modal End-->


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
						<!-- 	<div class="box-title" >
								<h3>
									<i class="fa fa-list"></i>Dispatch Advance</h3>
							</div> -->
							<div class="box-content nopadding" style="display:none;">
								<form action="#" method="GET" class='form-horizontal form-column form-bordered'>
									<div class="row">
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">From Date <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="date" name="fromdate" id="fromdate" placeholder="Text input" class="form-control" value="<?php echo $fromdate; ?>" required>
												</div>
											</div>
										
										</div>
										
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">To Date <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="date" name="todate" id="todate" placeholder="Text input" class="form-control" value="<?php echo $todate; ?>" required>
												</div>
											</div>
										
										</div>
										
	<!-- 									<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Item <span style="color: red">*</span></label>
												<div class="col-sm-8">
											<select name="item_id" id="item_id" class='select2-me' style="width:230px;" required>
												<option value="">Select</option>
									<?php	$sql = mysqli_query($connection,"Select * from  m_item  order by item_id");
										  while($row= mysqli_fetch_array($sql)) { ?>
										  	
								<option value="<?php echo $row['item_id']; ?>"><?php echo $row['item_name']; ?></option>
								<?php } ?>

											</select>
			<script>document.getElementById('item_id').value = '<?php echo $item_id; ?>';</script>
												</div>
											</div>
										
										</div> -->
										       <div class="col-sm-3">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">Truck No.</label>
                                       <div class="col-sm-8">
                                          <select name="vehicle_id" id="vehicle_id" class='select2-me' style="width:230px;">
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
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Consignor</label>
												<div class="col-sm-8">
												<select name="consignor_id" id="consignor_id" class='select2-me' style="width:230px;">
								<option value="">      Select  </option>
		<?php	$sql = mysqli_query($connection,"Select * from  m_consignor  order by consignor_id");
										  while($row= mysqli_fetch_array($sql)) { ?>
				<option value="<?php echo $row['consignor_id']; ?>"><?php echo $row['consignor_name']; ?></option>
								<?php } ?>

											</select>
			<script>document.getElementById('consignor_id').value = '<?php echo $consignor_id; ?>';</script>
												</div>
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
							
							
							<div class="box box-color box-bordered red">
			<div class="box-title">
			<h3>	<i class="fa fa-table"></i>
					Bill Payment List</h3>
				
		
				<!-- 	<button class="btn btn-warning" style="float: right">Click Hear For All Entry
											<i class="fa fa-object-group"></i>
										</button> &nbsp;
				 -->
				
				
				
				
			<a href="pdf/pdf_billpayment.php" class="btn" style="float: right" target="_blank">Pdf 
											<i class="fa fa-file-pdf-o"></i>
										</a> &nbsp;
					<a href="excel/excel_billpayment.php" class="btn btn-warning" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a> 	
				
			</div>
			<div class="box-content nopadding">
		 <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
                     <thead>
                        <tr>
						<th>S.No</th>
                           <th>Invoice No.</th>
                           <th>Receive Date</th>
                           <th>Tds Amt</th>
                            <th>Gst Amt </th>
                           <th>Deduct Amount</th>
                           <th>Received Amount</th>
                           <!-- <th>Deduct Amount</th> -->
                           <th>Remark</th>
                           <th>User Name</th>  
                        </tr>
                     </thead>
                     <tbody>
                 		 <?php
								$sn=1;
								$total_tdsamt= 0;
								$total_gstamt= 0;
								$total_deduct= 0; 
								$total_received= 0; 
								
							    // 	echo "Select * from  $tblname where consignorid=$consignorid && session_id=$session_id order by $tblpkey desc " ;
							  
			                    $sql = mysqli_query($connection,"Select * from  $tblname where consignorid=$consignorid && session_id=$session_id order by $tblpkey desc ");
								 
								 while($row= mysqli_fetch_array($sql)) {
									
									$user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
									$total_tdsamt += $row['tds_amt'];
									$total_gstamt += $row['gst_amt'];
									$total_deduct += $row['deduct'];
									$total_received += $row['received_amt'];
									if($row['type'] == 'incentive' || $row['type'] == 'Deduct'){
                                           $invno = $row['ref_no'];
                                       }else{
                                            $invno = $cmn->getvalfield($connection, "invoicebilty", "invno", "invoiceid='$row[invoiceid]'");
                                       }
						   ?>

                        <tr>
    						<td><?php echo $sn++;?></td>
    						
    						<td><?php echo $invno; ?></td>
    						<td><?php echo dateformatindia($row['receive_date']); ?></td>
                            <td class='hidden-350'><?php echo $row['tds_amt']; ?></td>
                            <td class='hidden-350'><?php echo $row['gst_amt']; ?></td>
        					<td class='hidden-350'><?php echo $row['deduct']; ?></td>
                            <td class='hidden-350'><?php echo $row['received_amt']; ?></td>
                            <td class='hidden-350'><?php echo $row['remark']; ?></td>   
                          <td><?php echo $user_name; ?></td>
                        </tr>
                        
                             <?php } 
                        
                            ?>
                        </body>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td style="text-align:right; font-size:14px; font-weight:800"><b>Total</b></td>
                                <td style="font-size:14px; font-weight:800"><b><?= $total_tdsamt; ?></b></td>
                                <td style="font-size:14px; font-weight:800"><b><?= $total_gstamt; ?></b></td>
                                <td style="font-size:14px; font-weight:800"><b><?= $total_deduct; ?></b></td>
                                <td style="font-size:14px; font-weight:800"><b><?= $total_received; ?></b></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                         
                      </table>
    			</div>
    		</div>
						</div>
					</div>
				</div>
				
				
				
				
				
			</div>
		</div>
	</div>
	
</body>



</html>
