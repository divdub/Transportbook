<?php 
error_reporting(0);
include("adminsession.php");
// include("function/dispatch_function.php");
$tblname = "payment";
$tblpkey = "payment_id";
$pagename = "commision_report.php";
$modulename = " Details";
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




if ($fromdate != '' && $todate != '') {
	$crit .= "where voucher_date BETWEEN  '$fromdate' and  '$todate' ";
	//echo $crit;
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
	<div class="modal fade" id="myModal10" role="dialog">
    <div class="modal-dialog" style="width:900px;padding-top: 150px;" >


      <div class="modal-content" style="border-radius: 20px;">
        <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
          <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
          <center>
          <h4 class="modal-title"><b>EDIT RECEIVE ENTRY<b></h4></center>
        </div>
        <div class="modal-body" style="padding-top:30px;" id="recdata">
    
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
							<div class="box-title">
								<h3>
									<i class="fa fa-list"></i>Transporting Commission  Report</h3>
							</div>
							<div class="box-content nopadding">
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
										       <div class="col-sm-3" style="display:none;">
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
										<div class="col-sm-3" style="display:none;">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Owner Name</label>
												<div class="col-sm-8">
												<select name="owner_id" id="owner_id" class='select2-me' style="width:100%;">
								<option value="">      Select  </option>
		<?php	$sql = mysqli_query($connection,"Select * from  m_vehicle_owner  order by owner_id");
										  while($row= mysqli_fetch_array($sql)) { ?>
				<option value="<?php echo $row['owner_id']; ?>"><?php echo $row['owner_name']; ?></option>
								<?php } ?>

											</select>
			<script>document.getElementById('owner_id').value = '<?php echo $owner_id; ?>';</script>
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
					Transporting Commission  List</h3>
				
		
				<!-- 	<button class="btn btn-warning" style="float: right">Click Hear For All Entry
											<i class="fa fa-object-group"></i>
										</button> &nbsp;
				 -->
				
				
				
		<!-- 		
			<a href="pdf/pdf_dispatch_advance.php" class="btn" style="float: right" target="_blank">Pdf 
											<i class="fa fa-file-pdf-o"></i>
										</a> &nbsp;
					<a href="excel/excel_dispatch_advance.php" class="btn btn-warning" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a> 	 -->
				
			</div>
			<div class="box-content nopadding"  style="overflow:scroll;">
				<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
					<thead>
					<tr>
					<th>S.No</th>
						<th>DI/LR No.</th>
                                            <th>Bilty Date</th>
                                                 <th>Truck No</th>
                                        	 <th>Consignee</th>
                                        	 <!--<th>Payee Name</th>-->
                                              <th>Destination</th>
                                              <th>Total Weight</th>
                                         
                      						<th>Qty</th>
                                          <th>Transport Commision</th>
                                          	<th>Final Commision</th>

                                            <!--<th>TDS Amount</th>-->
					</tr>
					</thead>
					<tbody>
					
					 <?php
									$sn=1;
				// 			echo		"Select * from  $tblname  $crit && is_receive=1 && consignor_id=$consignorid order by $tblpkey desc";
				$sql = mysqli_query($connection,"Select * from  $tblname  $crit  && commision!=0  && consignorid=$consignorid order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
	$di_no=$cmn->getvalfield($connection,"dispatch_entry","di_no","dispatch_id=$row[dispatch_id]");
		$bilty_date=$cmn->getvalfield($connection,"dispatch_entry","bilty_date","dispatch_id=$row[dispatch_id]");
			$destination_id=$cmn->getvalfield($connection,"dispatch_entry","destination_id","dispatch_id=$row[dispatch_id]");
				// $owner_id=$cmn->getvalfield($connection,"dispatch_entry","owner_id","dispatch_id=$row[dispatch_id]");
		  // $owner_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$owner_id");
		   	$vehicle_id=$cmn->getvalfield($connection,"dispatch_entry","vehicle_id","dispatch_id=$row[dispatch_id]");
		   	 	$consignee_id=$cmn->getvalfield($connection,"dispatch_entry","consignee_id","dispatch_id=$row[dispatch_id]");
		   $vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$vehicle_id");
		   $place_name=$cmn->getvalfield($connection,"m_place","place_name","place_id=$destination_id");
		    $consignee_name=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id=$consignee_id");
			$wt_mt=$cmn->getvalfield($connection,"dispatch_entry","wt_mt","dispatch_id=$row[dispatch_id]");
				$qty=$cmn->getvalfield($connection,"dispatch_entry","qty","dispatch_id=$row[dispatch_id]");
				$amt=$comp_rate*$wt_mt;
			$commision=	$row['commision'];
										   ?>
					<tr>
					<td><?php echo $sn++;?></td>
						<td><?php echo $di_no; ?></td>
						<td><?php echo dateformatindia($bilty_date); ?></td>
						<td><?php echo $vehicle_no; ?></td>
					
						<td><?php echo $consignee_name; ?></td>
						<!--<td><?php echo $row['payee_name']; ?></td>-->
							<td><?php echo $place_name; ?></td>
						<td><?php echo $wt_mt; ?></td>
						
						<!--<td><?php     echo $cmn->getvalfield($connection,"m_vehicle_owner","pan_no","owner_id='$owner_id'"); ?></td>-->
					<td><?php echo $qty; ?></td>
						<!--<td><?php echo number_format(round(($row['commision']),2)); ?></td>-->
						
					<td><?php echo $commision; ?></td>
			<td><?php echo $commision * $wt_mt ; ?></td>
					</tr>
					
					<?php } ?>
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
