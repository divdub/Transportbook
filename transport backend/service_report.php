<?php 
error_reporting(0);
include("adminsession.php");
// include("function/dispatch_function.php");
$tblname = "service_entry";
$tblpkey = "service_id";
$pagename = "service_report.php";
$modulename = "Service Details";
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
	$crit .= "where service_date BETWEEN  '$fromdate' and  '$todate' ";
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
									<i class="fa fa-list"></i>Service Report
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
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Service Head <span style="color: red">*</span></label>
												<div class="col-sm-8">
												<select name="head_id" id="head_id" class='select2-me' style="width:100%;">
				<option value="">      Select  </option>
				<?php	$sql = mysqli_query($connection,"Select * from  head_master  order by head_id");
										  while($row= mysqli_fetch_array($sql)) { ?>
										  	
												<option value="<?php echo $row['head_id']; ?>"><?php echo $row['head_name']; ?></option>
								<?php } ?>

											</select>
			<script>document.getElementById('head_id').value = '<?php echo $head_id ; ?>';</script>
												</div>
											</div>
										
										</div>
										  
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Mechanic Name</label>
												<div class="col-sm-8">
												<select name="mechanic_id" id="mechanic_id" class='select2-me' style="width:100%;">
				<option value="">      Select  </option>
				<?php	$sql = mysqli_query($connection,"Select * from  mechanic_service_master  order by mechanic_id");
										  while($row= mysqli_fetch_array($sql)) { ?>
										  	
												<option value="<?php echo $row['mechanic_id']; ?>"><?php echo $row['mechanic_name']; ?></option>
								<?php } ?>

											</select>
			<script>document.getElementById('mechanic_id').value = '<?php echo $mechanic_id ; ?>';</script>

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
					Service Detail List</h3>
				
		
					<a href="maintance-process.php" class="btn btn-warning" style="float: right">Click Hear For New Entry
											<i class="fa fa-object-group"></i>
										</a> &nbsp;
				
				
				
				
				
			<a href="pdf/pdf_service.php" class="btn" style="float: right" target="_blank">Pdf 
											<i class="fa fa-file-pdf-o"></i>
										</a> &nbsp;
					<a href="excel/excel_service.php" class="btn btn-warning" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a> 	
				
			</div>
			<div class="box-content nopadding">
				<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
					<thead>
					<tr>
					<th>S.No</th>
						<th>Service Date</th>
						<th>Service Head</th>
						<th class='hidden-350'>Truck No</th>
						<th>Mechanic/Service Name*</th>
						<th>Amount</th>
						<th class='hidden-1024'>Driver Name</th>
						<th>Meter Reading</th>
						<th>Next Service Date</th>
						<th>Next Meter Reading</th>
						<!-- <th>Qty (Bags)</th> -->
						<th>Narration</th>	
						<!-- <th>Bilty Scan</th>	 -->
						<th class='hidden-480'>Action</th>
					</tr>
					</thead>
					<tbody>
					
					 <?php
									$sn=1;
							// echo		"Select * from  $tblname  $crit  order by $tblpkey desc";
				$sql = mysqli_query($connection,"Select * from  $tblname  $crit && consignorid=$consignorid order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
	$head_name=$cmn->getvalfield($connection,"head_master","head_name","head_id=$row[head_id]");
	$mechanic_name=$cmn->getvalfield($connection,"mechanic_service_master","mechanic_name","mechanic_id=$row[mechanic_id]");
	$vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
$driver_name=$cmn->getvalfield($connection,"m_driver","driver_name","driver_id=$row[driver_id]");
						  	
										   ?>
					<tr>
							<td><?php echo $sn++;?></td>
						<td><?php echo dateformatindia($row['service_date']); ?></td>
						<td><?php echo $head_name; ?></td>
						
						<td><?php echo $vehicle_no; ?></td>
						<td class='hidden-350'><?php echo $mechanic_name; ?></td>
						<td><?php echo $row['amount']; ?></td>
						<td class='hidden-1024'><?php echo $driver_name; ?></td>
						<td><?php echo $row['meter_reading']; ?></td>
						<td><?php echo dateformatindia($row['service_datenext']); ?></td>
						<td><?php echo $row['meter_readingnext']; ?></td>
						<td><?php echo $row['narration']; ?></td>
						<td class='hidden-480'>
		
		<a href="maintance-process.php?editid=<?php echo $row['service_id']; ?>" class="btn btn-inverse" rel="tooltip" title="Edit">
			<i class="fa fa-edit"></i>
		</a>
		<a href="<?php echo $pagename ?>" onClick="funDel(<?php echo $row['service_id']; ?>)" class="btn btn-danger" rel="tooltip" title="Delete">
			<i class="fa fa-times"></i>
		</a></td>
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
