<?php
error_reporting(0);
include("adminsession.php");
include("function/itemissue_function.php");
$tblname = "issueentrydetail";
$tblpkey = "issuedetailid";
$pagename = "issueentry_detail.php";
$modulename = "Issue Entry Detail";
if (isset($_GET['search'])) {
  $fromdate = addslashes($_GET['fromdate']);
  $todate = addslashes($_GET['todate']);
  $vehicle_id = trim(addslashes($_GET['vehicle_id']));
  $iteminv_id = $_GET['iteminv_id'];
 $issueid = $cmn->getvalfield($connection, "issueentrydetail", "issueid", "iteminv_id='$iteminv_id'");
  $driver_id = $_GET['driver_id'];
} else {
   $fromdate = date('Y-m-d', strtotime('-1 month'));
  $todate = date('Y-m-d');
  $vehicle_id = '';
  $truckid = '';
  $is_rep = '';
  $excrec = '';
  $issueid='';
}
$crit = " where 1=1 ";
if ($fromdate != '' && $todate != '') {
  $crit .= " and  issudate between '$fromdate' and '$todate' ";
}

if ($vehicle_id != '') {
  $crit .= " and vehicle_id='$vehicle_id'";
}

if ($iteminv_id != '') {
  $crit .= " and iteminv_id='$iteminv_id' ";
}

if ($driver_id != '') {
  $crit .= " and driver_id='$driver_id' ";
}

$cond = " where 1=1 ";


if ($vehicle_id!= '') {
  $cond .= " and vehicle_id='$vehicle_id'";
}

if ($iteminv_id!= '') {
  $cond .= " and iteminv_id='$iteminv_id' ";
}

if ($driver_id!= '') {
  $cond .= " and driver_id='$driver_id'";
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

	<title> ITEM ISSUE:: CHAARUVI INFOTECH PVT. LTD.</title>

<?php include("inc/top-files.php"); ?>	
</head>

<body>
	
	<?php include("inc/model.php"); ?>
	
	<?php include("inc/top-header.php"); ?>
	
	
	<div class="container-fluid nav-hidden" id="content" >
		<?php include("inc/left-menu.php"); ?>
		
		
		
		<div id="main">
			<div class="container-fluid">
				
				<?php include("inc/breadcrumbs.php"); ?>
				
				
				<div class="row">
					<div class="col-sm-12">
						<div class="box box-bordered box-color satblue">
							<div class="box-title">
								<h3>
									<i class="fa fa-list"></i>Issue Entry Report
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
										    
										
										  
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Truck No</label>
												<div class="col-sm-8">
													<select name="vehicle_id" id="vehicle_id" class='select2-me' style="width:100%;">
																			<option value=""> Select </option>
																			<?php $sql = mysqli_query($connection, "Select * from  m_vehicle where status='0' order by vehicle_id");
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
										
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Driver Name <span style="color: red">*</span></label>
												<div class="col-sm-8">
												<select name="driver_id" id="driver_id" class='select2-me' style="width:100%;">
																			<option value=""> Select </option>
																			<?php $sql = mysqli_query($connection, "Select * from  m_driver  order by driver_id");
																			while ($row = mysqli_fetch_array($sql)) { ?>

																				<option value="<?php echo $row['driver_id']; ?>"><?php echo $row['driver_name']; ?> / <?php echo $row['mobile_no']; ?></option>
																			<?php } ?>

																		</select>
																		<script>
																			document.getElementById('driver_id').value = '<?php echo $driver_id; ?>';
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
									Issue Entry List</h3>


									<a href="issueentry.php" class="btn btn-warning" style="float: right">Click Hear For New Entry
										<i class="fa fa-object-group"></i>
									</a> &nbsp;





									<a href="pdf/pdf_item_issue_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate;?>&vehicle_id=<?php echo $vehicle_id?>&driver_id=<?php echo $driver_id?>" class="btn" style="float: right" target="_blank">Pdf
										<i class="fa fa-file-pdf-o"></i>
									</a> &nbsp;
									<a href="excel/excel_item_issue_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate;?>&vehicle_id=<?php echo $vehicle_id?>&driver_id=<?php echo $driver_id?>" class="btn btn-warning" style="float: right">Excel
										<i class="fa fa-file-excel-o"></i>
									</a>

								</div>
								<div class="box-content nopadding">
									<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
										<thead>
											<tr>
											<th>Sno</th>
                      <th>Truck No</th>
                      <th>Driver Name</th>
                      <th>Issue No</th>
                      <th>Issue Date</th>
                      <th>Meter Reading</th>
                      <!--<th>Return Category</th>-->
                      <th>Remark</th>

                      <th>Total Qty</th>
					  <th>User Name</th>  
                      <th>Print</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>

											<?php
											$slno = 1;

										 $sel = "select * from issueentry  $crit && compid='$compid' && sessionid='$sessionid' ORDER BY `issueid` DESC";
                    
                    $res = mysqli_query($connection, $sel);
                    while ($row = mysqli_fetch_array($res)) {
                      $vehicle_id = $row['vehicle_id'];
                      $driver_id= $row['driver_id'];
                      $iteminv_id = $row['iteminv_id'];
                      
                       $vehicle_no = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id='$vehicle_id'");
                      $drivername = $cmn->getvalfield($connection, "m_driver", "driver_name", "driver_id='$driver_id'");
                      $mobile_no = $cmn->getvalfield($connection, "m_driver", "mobile_no", "driver_id='$driver_id'");
                 
                      $total_qty = $cmn->getvalfield($connection, "issueentrydetail", "sum(qty)", "issueid='$row[issueid]'");

											?>
												<tr>
												 <td><?php echo $slno; ?></td>
                        <td><?php echo  $vehicle_no; ?></td>
                        <td><?php echo $drivername; ?>/<?php echo $mobile_no; ?></td>

                        <td><?php echo $row['issuno']; ?></td>
                        <td><?php echo $cmn->dateformatindia($row['issudate']); ?></td>
                        <td><?php echo $row['meterread']; ?></td>
                        <!--<td><?php echo  $is_repname; ?></td>-->
                        <td><?php echo $row['remark']; ?></td>
                        <td><?php echo $total_qty; ?></td>
						<td><?php echo $user_name; ?></td>
                        <td><a class="btn btn-warning" href="pdf/pdf_print_item_issue_report.php?issueid=<?php echo $row['issueid'];?>" target="_blank">Print</a></td>

													<td class='hidden-480'>

														<a href="issueentry.php?editid=<?php echo $row['issueid']; ?>" class="btn btn-inverse" rel="tooltip" title="Edit">
															<i class="fa fa-edit"></i>
														</a>
														<a href="<?php echo $pagename ?>" onClick="funDelnew(<?php echo $row['issueid']; ?>)" class="btn btn-danger" rel="tooltip" title="Delete">
															<i class="fa fa-times"></i>
														</a>
													</td>
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
