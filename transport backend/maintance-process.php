<?php 
error_reporting(0);
include("adminsession.php");
include("function/maintenance_function.php");
$tblname = "service_entry";
$tblpkey = "service_id";
$pagename = "maintance-process.php";
$modulename = "Maintenance  Entry";
$duplicate='';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = "";
}
if (isset($_GET['service_id'])) {
    $service_id= $_GET['service_id'];
} else {
    $service_id= 0;
}
$privilege_id =$cmn->getvalfield($connection,"user_privilege","count(privilege_id)","menu_id='5' && submenu_id='9' && subcat_id=0  && user_id='$user_id'");
if(isset($_GET['service_id'])!= "")
{
	
	 $service_id= test_input($_GET['service_id']);
	//  echo "select * from $tblname where $tblpkey='$keyvalue'";
	$sql = mysqli_query($connection,"select * from $tblname where $tblpkey='$service_id'");
	$row = mysqli_fetch_array($sql);
	$type = $row['type']; 
	$service_date = $row['service_date']; 
	$vehicle_id1 = $row['vehicle_id'];
	$driver_id1 = $row['driver_id']; 
	$payment_type=$row['payment_type'];
	$amount=$row['amount'];
	 $meter_reading=$row['meter_reading']; 
	$narration=$row['narration'];
	$service_datenext=$row['service_datenext'];
	$bill_type=$row['bill_type'];
	$service_no = $row['service_no'];
	$main_no= $row['main_no'];
	
	}
else
{
	$service_no=$cmn->getcode($connection,"service_entry","service_no","1=1 && consignorid=$consignorid && session_id=$session_id && type='Service'");
	$main_no=$cmn->getcode($connection,"service_entry","main_no","1=1 && consignorid=$consignorid && session_id=$session_id && type='Maintenance'");
	$service_date = date('Y-m-d');
	$vehicle_id1  = '';
	$driver_id1 = '';
	$type='';
	$mechanic_id1='';
	$payment_type='';
	$amount='';
	$meter_reading='';
	$narration='';
	$meter_readingnext='';
	$service_datenext=date('Y-m-d');
	$bill_type='';

}
if(isset($_POST['submit']))
{
	$service_date = $_POST['service_date'];
	$vehicle_id =$_POST['vehicle_id'];
	$driver_id = $_POST['driver_id'];
	$type = $_POST['type'];
	$payment_type = $_POST['payment_type'];
	$meter_reading = $_POST['meter_reading'];
	$narration = $_POST['narration'];
	$meter_readingnext = $_POST['meter_readingnext'];
	$service_datenext = $_POST['service_datenext'];
	$bill_type = $_POST['bill_type'];
	$main_no= $_POST['main_no'];
	$service_no=$_POST['service_no'];

	if($type=='Service'){
			$main_no='';
		}else {
			$service_no='';
		}
	$form_data = array('service_date'=>$service_date,'type'=>$type, 'payment_type'=>$payment_type, 'service_no'=>$service_no, 'main_no'=>$main_no,  'vehicle_id'=>$vehicle_id,'meter_reading'=>$meter_reading,'driver_id'=>$driver_id,'meter_readingnext'=>$meter_readingnext,'service_datenext'=>$service_datenext,'narration'=>$narration,'bill_type'=>$bill_type,'consignorid'=>$consignorid,'comp_id'=>$comp_id,'session_id'=>$session_id,'created_date'=>$currentdate,'user_id' => $user_id);
	 
	if($service_id== '0')
	{

	    dbRowInsert($connection,$tblname, $form_data);
	   $service_id= mysqli_insert_id($connection);
	   
	   mysqli_query($connection, "update service_detail set service_id='$service_id' where service_id='0'  && consignorid='$consignorid'  && session_id='$session_id'");
	   echo "<script>location='$pagename?action=1'</script>";
	
	}
	
	else
	{


		$form_data = array('service_date'=>$service_date,'type'=>$type,'payment_type'=>$payment_type, 'service_no'=>$service_no, 'main_no'=>$main_no, 'vehicle_id'=>$vehicle_id,'meter_reading'=>$meter_reading,'driver_id'=>$driver_id,'meter_readingnext'=>$meter_readingnext,'service_datenext'=>$service_datenext,'narration'=>$narration,'bill_type'=>$bill_type,'consignorid'=>$consignorid,'comp_id'=>$comp_id,'session_id'=>$session_id,'updated_date'=>$currentdate);
		 dbRowUpdate($connection,$tblname, $form_data, "$tblpkey='$service_id'");
		echo "<script>location='$pagename?action=2'</script>";
	}
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

	<title>MAINTENANCE :: CHAARUVI INFOTECH PVT. LTD.</title>

<?php include("inc/top-files.php"); ?>	
</head>

<body onload="showrecord(<?php echo $service_id; ?>);">
	<?php include("inc/model.php"); ?>
	
	<?php include("inc/top-header.php"); ?>
	
	
	<div class="container-fluid nav-hidden" id="content">
		<?php include("inc/left-menu.php"); ?>
		
		
		
		<div id="main">
			<div class="container-fluid">
				<?php include("inc/breadcrumbs.php"); ?>
				
				
				<div class="row">
					<div class="col-sm-12">
						<div class="box box-bordered box-color satblue" >
							<div class="box-title">
								<h3>
									<i class="fa fa-bars"></i>Maintenance</h3>
							</div>
							<div class="box-content nopadding">
								<ul class="tabs tabs-inline tabs-top">
								<?php $subsn = 1;
							$sql1 = mysqli_query($connection, "select * from user_privilege where menu_id='5' && submenu_id!=0 && subcat_id=0 && user_id='$user_id'  order by submenu_id  asc");
							while ($row1 = mysqli_fetch_array($sql1)) { 
								$activity2=$row1['status'];		
								$submenu_id=$row1['submenu_id'];	
								$submenu =$cmn->getvalfield($connection,"m_submenu","submenu","submenu_id='$submenu_id'"); 
							
								$pagelink2 =$cmn->getvalfield($connection,"m_submenu","pagelink","submenu_id='$submenu_id'"); 
								$sub_cat =$cmn->getvalfield($connection,"m_submenu","sub_cat","submenu_id='$submenu_id'");
								
								?>
									<li <?php if($sub_cat==0){ ?> class='active'<?php }?> >
										<a id="<?php echo $pagelink2; ?>" data-toggle='tab'>
											<i class="fa fa-inbox"></i><?php echo ucfirst($submenu); ?></a>
									</li>
									<?php } ?>
									<!-- <li class='active'>
										<a id="service" data-toggle='tab'>
											<i class="fa fa-inbox"></i>Service Entry</a>
									</li> -->
									<li>
										<a id="report" data-toggle='tab' style="background: #2563eb; color: #ffffff">
											<i class="fa fa-share"></i>Maintenance Report</a>
									</li>
									<!-- <li>
										<a id="maintenance" data-toggle='tab'>
											<i class="fa fa-tag"></i>Maintenance Entry</a>
									</li> -->
									<li>
										<a id="mreport" data-toggle='tab' style="background: #2563eb; color: #ffffff">
											<i class="fa fa-share"></i>Payment Report</a>
									</li>
								
								</ul>
							<div class="tab-content padding tab-content-inline tab-content-bottom" id="main1">
									<?php if ($privilege_id == 1) { ?>
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



														<h3><i class="fa fa-list"></i> Service / Maintenance Entry</h3>


													</div>

													<div class="box-content nopadding">

													<form action="#" method="POST" class='form-horizontal form-column form-bordered' enctype="multipart/form-data">
									<div class="row">
															<div class="col-sm-3">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">Type <span style="color: red">*</span></label>
																	<div class="col-sm-8">

																		<select name="type" id="type" class="form-control"  required>
																			<option value="">-Select-</option>
																			<option value="Service">Service</option>
																			<option value="Maintenance">Maintenance</option>

																		</select>
																		<script>
																			document.getElementById('type').value = '<?php echo $type; ?>';
																		</script>

																	</div>
																</div>

															</div>
	                                                              <div class="col-sm-3" id='sr' style="display:none;">
																<div class="form-group" >
																	<label for="textfield" class="control-label col-sm-4" >Service No</label>
																	<div class="col-sm-8" id='sr1' style="display:none;">
																		<input type="text" name="service_no" id="service_no" value="<?php echo $service_no; ?>" placeholder="Text input" class="form-control" readonly>
																	</div>
																</div>

															</div>

															<div class="col-sm-3" id='mn' style="display:none;">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">Maintenance No</label>
																	<div class="col-sm-8" id='mn1' style="display:none;">
																		<input type="text" name="main_no" id="main_no" value="<?php echo $main_no; ?>" placeholder="Text input" class="form-control" readonly>
																	</div>
																</div>

															</div>

															<div class="col-sm-3">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4"> Date<span style="color: red">*</span></label>
																	<div class="col-sm-8">
																		<input type="date" name="service_date" id="service_date" value="<?php echo $service_date; ?>" placeholder="Text input" class="form-control">
																	</div>
																</div>

															</div>


															<div class="col-sm-3">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">Truck No.<span style="color: red">*</span></label>
																	<div class="col-sm-8">
																		<select name="vehicle_id" id="vehicle_id" class='select2-me' style="width:100%;" required>
																			<option value=""> Select </option>
																			<?php $sql = mysqli_query($connection, "Select * from  m_vehicle where status='0' order by vehicle_id");
																			while ($row = mysqli_fetch_array($sql)) { ?>

																				<option value="<?php echo $row['vehicle_id']; ?>"><?php echo $row['vehicle_no']; ?></option>
																			<?php } ?>

																		</select>
																		<script>
																			document.getElementById('vehicle_id').value = '<?php echo $vehicle_id1; ?>';
																		</script>
																	</div>
																</div>

															</div>
														
													
                                                    	<div class="col-sm-3">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">Driver name</label>
																	<div class="col-sm-8">
																		<select name="driver_id" id="driver_id" class='select2-me' style="width:100%;">
																			<option value=""> Select </option>
																			<?php $sql = mysqli_query($connection, "Select * from  m_driver  order by driver_id");
																			while ($row = mysqli_fetch_array($sql)) { ?>

																				<option value="<?php echo $row['driver_id']; ?>"><?php echo $row['driver_name']; ?></option>
																			<?php } ?>

																		</select>
																		<script>
																			document.getElementById('driver_id').value = '<?php echo $driver_id1; ?>';
																		</script>
																	</div>
																</div>
															</div>
															</div>
															<div class="row">
															<div class="col-sm-3">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">Meter Reading</label>
																	<div class="col-sm-8">
																		<input type="text" name="meter_reading" id="meter_reading" value="<?php echo $meter_reading; ?>" placeholder="Text input" class="form-control">
																	</div>
																</div>

															</div>

															<div class="col-sm-3">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">Billing Type</label>
																	<div class="col-sm-8">
																		<select name="bill_type" id="bill_type" class='select2-me' onchange="set_payment1(this.value);" style="width:100%;">
																			<option value="">-Select-</option>
																			<option value="cash">CASH</option>
																			<option value="credit">CREDIT</option>

																		</select>
																		<script>
																			document.getElementById('bill_type').value = '<?php echo $bill_type; ?>';
																		</script>

																	</div>
																</div>

															</div>

                                             	<div class="col-sm-3" id="pays" style="display:none;">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">Pay Mode</label>
																	<div class="col-sm-8">
																		 <select name="payment_type" id="payment_type" class="formcent select2-me" style="width:100%;">
                                           		<option value="">-Select-</option>
                                               	<option value="cash">CASH</option>
                                               	<option value="cheque">CHEQUE</option>
                                               <option value="upi">UPI</option>
                                           </select>
                                           <script>document.getElementById('payment_type').value = '<?php echo $payment_type ; ?>'; </script>																	</div>
																</div>

															</div>
															<div class="col-sm-3">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">Narration</label>
																	<div class="col-sm-8">
																		<input type="text" name="narration" id="narration" value="<?php echo $narration; ?>" placeholder="Text input" class="form-control">
																	</div>
																</div>

															</div>


														

														</div>
															<pre style="font-weight: bold; color: red"></pre>


															<div>
																<table class="table">
																	<thead style="position: sticky;  top: 0;">

																		<tr>

																			<th>Mechanic / Service Name</th>
																			<th>Service Head</th>
																			<th>Next Service Date</th>
																			<th>Next Meter Reading</th>
																			<th>Amount</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																			<td>
																				<select name="mechanic_id" id="mechanic_id" class="select2-me" style="width:100%;">
																					<option value="">-Select-</option>
																					<?php
																					$sql = mysqli_query($connection, "select * from mechanic_service_master");
																					while ($row = mysqli_fetch_assoc($sql)) {

																					?>
																						<option value="<?php echo $row['mechanic_id']; ?>"><?php echo $row['mechanic_name']; ?></option>
																					<?php
																					}
																					?>
																				</select>
																				<script>
																					document.getElementById('mechanic_id').value = '<?php echo $mechanic_id; ?>';
																				</script>


																			</td>
																			<td><select name="head_id" id="head_id" class="select2-me" style="width:100%;">
																					<option value="">-Select-</option>
																					<?php
																					$sql = mysqli_query($connection, "select * from head_master");
																					while ($row = mysqli_fetch_assoc($sql)) {
																					?>
																						<option value="<?php echo $row['head_id']; ?>"><?php echo $row['head_name'] ?></option>
																					<?php
																					}
																					?>
																				</select>
																				<script>
																					document.getElementById('type').value = '<?php echo $type; ?>';
																				</script>
																			</td>

																			<td><input type="date" name="service_datenext" id="service_datenext" class="form-control" value="<?php echo $service_datenext; ?>"></td>
																			<td><input type="text" name="meater_readingnext" id="meater_readingnext" class="form-control" value="<?php echo $meater_readingnext; ?>"></td>
																			<td><input type="text" name="amount" id="amount" class="form-control" placeholder=" " value="<?php echo $amount; ?>"></td>
																			<td><a class="btn btn-primary" style="width: 50px;" tabindex="27" onclick="getSave();">Add</a></td>
																			<input type="hidden" name="servicedetailid" id="servicedetailid" value="<?php echo $servicedetailid; ?>">

	                                                                        <input type="hidden" name="service_id" id="service_id" value="<?php echo $service_id; ?>">
																	</tbody>
																</table>
																<br>
															</div>


													</div>
							
						<div class="box box-color box-bordered red">
												<div class="box-title">
													<h3> <i class="fa fa-table"></i>
														Recent Service / Maintenance Details

													</h3>


												

												</div>
												<div class="row-fluid">
   	<div class="box-content nopadding" id="showsalerecord">
   </div>
												<div class="row">
										<div class="col-sm-12">
											<div class="form-actions">
												<center>
		 									
				<input type="submit" name="submit" id="submit" value="Save" class="btn btn-primary">
						<a type="button" href="<?php echo $pagename; ?>"class="btn btn-red">Cancel</a>
												</center>	
											</div>
										</div>
									</div>
													</form>
												</div>

											
											</div><br />
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
	</div>
	<script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#maintenance').click(function(){
      $('#main1').load('maintenance_entry.php #main', function() {
      jQuery('.select2-me').select2();
      
      });
   });
}); //// End of Wait till page is loaded
</script>
<script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#service').click(function(){
      $('#main1').load('maintance-process.php #main1', function() {
      	jQuery('.select2-me').select2();
      	 // jQuery("#advtable").html(data);

           /// can add another function here
      });
   });
}); //// End of Wait till page is loaded
</script>
<script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#report').click(function(){
    location = 'maintenance_report.php'; 
   });
}); //// End of Wait till page is loaded
</script>

<script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#mreport').click(function(){
    location = 'mpay_report.php'; 
   });
}); //// End of Wait till page is loaded
</script>

<script type="text/javascript">
       function funDel(id) {
			// alert(id);
			var tablename = '<?php echo 'service_detail' ?>';
			var tableid = '<?php echo 'servicedetailid' ?>';
			if (confirm("Do You want to Delete this record ?")) {
				// alert(tableid);
				jQuery.ajax({
					type: 'POST',
					url: 'ajax/delete_master.php',
					data: 'id=' + id + '&tablename=' + tablename + '&tableid=' + tableid,
					dataType: 'html',
					success: function(data) {
						showrecord();

					}
				}); //ajax close
			}
		}

    </script>
</body>



</html>
