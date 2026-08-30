<?php
error_reporting(0);
include("adminsession.php");
// include("function/dispatch_function.php");
$tblname = "service_entry";
$tblpkey = "service_id";
$pagename = "mpay_report.php";
$modulename = "Service Details";
$crit = '';
if (isset($_GET['search'])) {
	$fromdate = $_GET['fromdate'];
	$todate = $_GET['todate'];
} else {
	$fromdate = $currentdate;
	$todate = $currentdate;
}

if (isset($_GET['head_id'])) {
	$head_id = trim(addslashes($_GET['head_id']));
} else
	$head_id = '';
if (isset($_GET['mechanic_id'])) {
	$mechanic_id = trim(addslashes($_GET['mechanic_id']));
} else
	$mechanic_id = '';

if (isset($_GET['vehicle_id'])) {
	$vehicle_id = trim(addslashes($_GET['vehicle_id']));
} else
	$vehicle_id = '';


if ($fromdate != '' && $todate != '') {
	$crit .= "where mdate BETWEEN  '$fromdate' and  '$todate' ";
	//echo $crit;
}

if ($vehicle_id != '') {
	$crit .= " and vehicle_id='$vehicle_id'";
}
if ($head_id != '') {
	$crit .= " and head_id='$head_id'";
}
if ($mechanic_id != '') {
	$crit .= " and mechanic_id='$mechanic_id'";
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

	<title> SERVICE:: CHAARUVI INFOTECH PVT. LTD.</title>

	<?php include("inc/top-files.php"); ?>
</head>

<body>
	<!-- Edit Modal Start-->
	<div class="modal fade" id="myModal9" role="dialog">
		<div class="modal-dialog" style="width:900px;padding-top: 150px;">


			<div class="modal-content" style="border-radius: 20px;">
				<div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
					<!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
					<center>
						<h4 class="modal-title"><b>EDIT ADVANCE ENTRY<b></h4>
					</center>
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
							<div class="box-title">
								<h3>
									<i class="fa fa-list"></i>Payment Report

								</h3>
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
										<div class="col-sm-2" style="display:none;">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Truck No.</label>
												<div class="col-sm-8">
													<select name="vehicle_id" id="vehicle_id" class='select2-me' style="width:100%;">
														<option value=""> Select </option>
														<?php $sql = mysqli_query($connection, "Select * from  m_vehicle  order by vehicle_id");
														while ($row = mysqli_fetch_array($sql)) { ?>
															<option value="<?php echo $row['vehicle_id']; ?>"><?php echo $row['vehicle_no']; ?></option>
														<?php } ?>
													</select>
													<script>
														document.getElementById('vehicle_id').value = '<?php echo $vehicle_id; ?>';
													</script>
												</div>
											</div>
										</div>
										<div class="col-sm-3" style="display:none;">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Service Head <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<select name="head_id" id="head_id" class='select2-me' style="width:100%;">
														<option value=""> Select </option>
														<?php $sql = mysqli_query($connection, "Select * from  head_master  order by head_id");
														while ($row = mysqli_fetch_array($sql)) { ?>

															<option value="<?php echo $row['head_id']; ?>"><?php echo $row['head_name']; ?></option>
														<?php } ?>

													</select>
													<script>
														document.getElementById('head_id').value = '<?php echo $head_id; ?>';
													</script>
												</div>
											</div>

										</div>

										<div class="col-sm-3" style="display:none;">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Mechanic Name</label>
												<div class="col-sm-8">
													<select name="mechanic_id" id="mechanic_id" class='select2-me' style="width:100%;">
														<option value=""> Select </option>
														<?php $sql = mysqli_query($connection, "Select * from  mechanic_service_master  order by mechanic_id");
														while ($row = mysqli_fetch_array($sql)) { ?>

															<option value="<?php echo $row['mechanic_id']; ?>"><?php echo $row['mechanic_name']; ?></option>
														<?php } ?>

													</select>
													<script>
														document.getElementById('mechanic_id').value = '<?php echo $mechanic_id; ?>';
													</script>

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
									<h3> <i class="fa fa-table"></i>
										Payment Detail List</h3>


									<!--<a href="maintance-process.php" class="btn btn-warning" style="float: right">Click Hear For New Entry-->
									<!--	<i class="fa fa-object-group"></i>-->
									<!--</a> &nbsp;-->





									<!--<a href="pdf/pdf_service.php" class="btn" style="float: right" target="_blank">Pdf-->
									<!--	<i class="fa fa-file-pdf-o"></i>-->
									<!--</a> &nbsp;-->
									<!--<a href="excel/excel_service.php" class="btn btn-warning" style="float: right">Excel-->
									<!--	<i class="fa fa-file-excel-o"></i>-->
									<!--</a>-->

								</div>
								<div class="box-content nopadding">
									<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
										<thead>
											<tr>
									<th>Sno</th>
									<th>Pay Type</th>
								    <th>Truck No.</th>
									<th>Driver Name</th>
									<th> Date</th>
									<th>Mechanic Name.</th>
									<th>Maintenance / Spare </th>
									<th>Amount</th>
									<th>Payment Mode</th>
									<th>Remark</th>
									<th>User Name</th>  
											</tr>
										</thead>
										<tbody>
						 <?php
									$sn=1;
				//echo "Select * from  maintenance_entry $crit && comp_id=$comp_id && session_id=$session_id  order by main_id desc";
			$sql = mysqli_query($connection,"Select * from  maintenance_entry $crit && comp_id='$comp_id'  && consignorid='$consignorid'  && session_id=$session_id  order by main_id desc");
										  while($row= mysqli_fetch_array($sql)) {
	
			$user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
							   ?>
					<tr>
					<td><?php echo $sn++;?></td>
				<td><?php echo $row['pay_type']; ?></td>
						<td><?php echo $row['vehicle_id']; ?></td>
										<td><?php echo $row['driver_id']; ?></td>
										<td><?php echo dateformatindia($row['mdate']); ?></td>
										<td><?php echo $row['mechanic_id']; ?></td>
										<td><?php echo $row['head_id']; ?></td>
										<td><?php echo $row['amount']; ?></td>
										<td><?php echo $row['payment_mode']; ?></td>
										<td><?php echo $row['remark']; ?></td>
										<td><?php echo $user_name; ?></td>
	<!--					<td>-->
	<!--					    <?php if($user_type=='admin'){ ?>-->
	<!--<a  onClick="pay_detail('<?php echo $row['type']; ?>','<?php echo $row['otherid']; ?>','<?php echo $row['amount']; ?>','<?php echo $row['payment_mode']; ?>','<?php echo $row['payremark']; ?>','<?php echo $row['bill_type']; ?>','<?php echo $row['other_inc_id']; ?>')" class="btn btn-inverse" rel="tooltip" title="Edit">-->
	<!--		<i class="fa fa-edit"></i>-->
	<!--	</a>-->
		
	<!--	<a onclick="funDel1(<?php echo $row['other_inc_id']; ?>);" class="btn btn-danger" rel="tooltip" title="Delete">-->
	<!--		<i class="fa fa-times"></i>-->
	<!--	</a>-->
	<!--	<?php } ?>-->
	<!--	</td>-->
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