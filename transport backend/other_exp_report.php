<?php 
error_reporting(0);
include("adminsession.php");
// include("function/dispatch_function.php");
$tblname = "other_expense_entry";
$tblpkey = "other_exp_id";
$pagename = "other_exp_report.php";
$modulename = "Expense Details";
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

if (isset($_GET['otherid'])) {
	$otherid = trim(addslashes($_GET['otherid']));
} else
	$otherid = '';


if (isset($_GET['payment_mode'])) {
	$payment_mode = trim(addslashes($_GET['payment_mode']));
} else
	$payment_mode = '';
	

if (isset($_GET['vehicle_id'])) {
	$vehicle_id = trim(addslashes($_GET['vehicle_id']));
} else
	$vehicle_id = '';


if ($fromdate != '' && $todate != '') {
	$crit .= "where exp_date BETWEEN  '$fromdate' and  '$todate' ";
	//echo $crit;
}

// if ($vehicle_id != '') {
// 	$crit .= " and vehicle_id='$vehicle_id'";
// }
if ($otherid != '') {
	$crit .= " and otherid='$otherid'";
}

if ($payment_mode != '') {
	$crit .= " and payment_mode='$payment_mode'";
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

	<title> ACCOUNT:: CHAARUVI INFOTECH PVT. LTD.</title>

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
									<i class="fa fa-list"></i> Other Expense Report
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
								
										  
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4"> Other Expense</label>
												<div class="col-sm-8">
												<select name="otherid" id="otherid" class='select2-me' style="width:100%;">
				<option value="">      Select  </option>
				<?php	$sql = mysqli_query($connection,"Select * from  otherexp_master  order by otherid");
										  while($row= mysqli_fetch_array($sql)) { ?>
										  	
												<option value="<?php echo $row['otherid']; ?>"><?php echo $row['head_name']; ?></option>
								<?php } ?>

											</select>
			<script>document.getElementById('otherid').value = '<?php echo $otherid ; ?>';</script>

												</div>
											</div>
										
										</div>
										
											<div class="col-sm-3">
																			<div class="form-group">
			<label for="textfield" class="control-label col-sm-4"> Payment Mode</label>
												<div class="col-sm-8">
					<select name="payment_mode" id="payment_mode" class='form-control'>
												<option value=" ">Select</option>
												<option value="Cash">Cash </option>
												<option value="Cheque">Cheque  </option>
												<option value="UPI">UPI  </option>
												</select>
	<script>document.getElementById('payment_mode').value = '<?php echo $payment_mode; ?>';</script>
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
					Other Expense  Detail </h3>
				
		
				<!-- 	<button class="btn btn-warning" style="float: right">Click Hear For All Entry
											<i class="fa fa-object-group"></i>
										</button> &nbsp;
				 -->
				
				
				
				
			<a href="pdf/pdf_othr_exp.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&otherid=<?php echo $otherid; ?>&payment_mode=<?php echo $payment_mode; ?>" class="btn" style="float: right" target="_blank">Pdf 
											<i class="fa fa-file-pdf-o"></i>
										</a> &nbsp;
					<a href="excel/excel_othr_exp.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&otherid=<?php echo $otherid; ?>&payment_mode=<?php echo $payment_mode; ?>" class="btn btn-warning" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a> 	
				
			</div>
			<div class="box-content nopadding">
				<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
					<thead>
					<tr>
					<th>S.No</th>
						<th> Date</th>
						<th>Other Expense</th>
						<!--<th class='hidden-350'>Truck No</th>-->
						<!-- <th>Mechanic/Service Name*</th> -->
						<th>Amount</th>
						<!--<th class='hidden-1024'>Driver Name</th>-->
						<!--<th>Payment Type</th>-->
						<th>Payment Mode</th>
						<!-- <th>Next Meter Reading</th> -->
						<!-- <th>Qty (Bags)</th> -->
						<th>Narration</th>	
						
                            <th>User Name</th>  
						<!-- <th>Bilty Scan</th>	 -->
						<?php if($user_type=='admin'){ ?>
						<th class='hidden-480'>Action</th>
						<?php } ?>
					</tr>
					</thead>
					<tbody>
					
					 <?php
									$sn=1;
							// echo		"Select * from  $tblname  $crit  order by $tblpkey desc";
				$sql = mysqli_query($connection,"Select * from  $tblname  $crit && consignorid=$consignorid && session_id=$session_id order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
	$head_name=$cmn->getvalfield($connection,"otherexp_master","head_name","otherid=$row[otherid]");
$user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
// $vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
// $driver_name=$cmn->getvalfield($connection,"m_driver","driver_name","driver_id=$row[driver_id]");
						  	$tamt+=$row['amount'];
										   ?>
					<tr>
							<td><?php echo $sn++;?></td>
						<td><?php echo dateformatindia($row['exp_date']); ?></td>
						<td><?php echo $head_name; ?></td>
						
						<!--<td><?php echo $vehicle_no; ?></td>-->
						<!-- <td class='hidden-350'><?php echo $mechanic_name; ?></td> -->
						<td><?php echo $row['amount']; ?></td>
						<!--<td class='hidden-1024'><?php echo $driver_name; ?></td>-->
						<!--<td><?php echo $row['bill_type']; ?></td>-->
						<!-- <td><?php echo dateformatindia($row['service_datenext']); ?></td> -->
						<td><?php echo $row['payment_mode']; ?></td>
						<td><?php echo $row['narration']; ?></td>
						<td><?php echo $user_name; ?></td>
						<?php if($user_type=='admin'){ ?>
						<td class='hidden-480'>
		
		<!--<a href="?editid=<?php echo $row['other_exp_id']; ?>" class="btn btn-inverse" rel="tooltip" title="Edit">-->
		<!--	<i class="fa fa-edit"></i>-->
		<!--</a>-->
		
		<a href="<?php echo $pagename ?>" onClick="funDel(<?php echo $row['other_exp_id']; ?>)" class="btn btn-danger" rel="tooltip" title="Delete">
			<i class="fa fa-times"></i>
		</a></td> <?php } ?>
					</tr>
					
					
					<?php } ?>
					<tfoot>
					<tr>
					   
					    <td colspan=3 style="text-align:center;">TOTAL AMOUNT</td>
					    <td colspan="4"><?php echo $tamt; ?></td>
					</tr>
					</tfoot>
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
