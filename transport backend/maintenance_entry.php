<?php
error_reporting(0);
include("adminsession.php");
include("function/maintenance_function.php");
$tblname = "maintenance_entry";
$tblpkey = "main_id";
$pagename = "maintenance_entry.php";
$modulename = "Maintenance Entry";
$duplicate = '';
$diesel_adv_amt = '';

if (isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = "";
}
if (isset($_GET['main_id'])) {
	$keyvalue = $_GET['main_id'];
} else {
	$keyvalue = 0;
}



?>



<div class="tab-pane active" id="main" style="margin-left:0">
	<div class="row">

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
	

		<div class="col-sm-12" id="danger">

		</div>
		<div class="col-sm-12" id="success">

		</div>
		<div class="col-sm-12">

			<div class="box box-bordered box-color">
				<div class="box-title">

					<h3><i class="fa fa-list"></i> Payment Entry</h3>

				</div>
				<div class="box-content nopadding">
					<form action="#" method="POST" class='form-horizontal form-column form-bordered'>
						<div class="row">


 


							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4">Payment For <span style="color: red">*</span></label>
									<div class="col-sm-8">
										<select name="pay_type" id="pay_type" class="formcent select2-me" style="width:224px;" onchange="gettype(this.value);" required> 
                                           		<option value="">-Select-</option>
                                               	<option value="Service">Service</option>
                                               	<option value="Maintenance">Maintenance</option>
                                              <option value="other">Other Inc/Exp</option>
                                           </select>
                                           <script>document.getElementById('pay_type').value = '<?php echo $pay_type ; ?>'; </script>

									</div>
								</div>

							</div>


                                     <div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4">Payment For <span style="color: red">*</span></label>
									<div class="col-sm-8">
									<select name="bill_id" id="bill_id"  class="formcent select2-me" style="width:224px;" onchange="getdetails();" required>
                    </select>
                                          <script>document.getElementById('bill_id').value = '<?php echo $bill_id ; ?>'; </script>

									</div>
								</div>

							</div>


							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4">Truck No. <span style="color: red">*</span></label>
									<div class="col-sm-8">
											<input type="text" name="vehicle_id" value="<?php echo $truckno; ?>"   id="vehicle_id" autocomplete="off"   class="form-control"  readonly>

									</div>
								</div>

							</div>



							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4">Driver Name </label>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="driver_id" id="driver_id" value="<?php echo $driver; ?>" data-date="true" readonly>

									</div>
								</div>

							</div>


						
						</div>

						<div class="row">

	                                              <div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4"> Date. </label>
									<div class="col-sm-8">
										<input type="date" name="mdate" value="<?php echo $mdate; ?>" id="mdate" autocomlepte="off"  class="form-control" >
									</div>
								</div>

							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4">Mechanic Name.</label>
									<div class="col-sm-8">
										<input type="text" name="mechanic_id" value="<?php echo $mechanic_name; ?>" id="mechanic_id" autocomplete="off"  class="form-control"  readonly>
									</div>


								</div>

							</div>



							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4">Maintenance / Spare <span style="color: red">*</span></label>
									<div class="col-sm-8">
										<input type="text" name="head_id" value="<?php echo $head_name; ?>" id="head_id" autocomplete="off"  class="form-control"  readonly>
									</div>
								</div>

							</div>

							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4">Bal. Amount </label>
									<div class="col-sm-8">
										<input type="text" name="amount" id="amount1" placeholder=" " class="form-control" value="" readonly>
									</div>
								</div>

							</div>
						</div>

							


						<div class="row">


						<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4">Paid Amount </label>
									<div class="col-sm-8">
										<input type="text" name="amount" id="amount" placeholder=" " class="form-control" value="<?php echo $amount; ?>">
									</div>
								</div>

							</div>
						

							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4"> Pay type</label>
									<div class="col-sm-8">
										<select name="payment_type" id="payment_type" class='form-control'>
											<option value=" ">Select</option>
											<option value="Cash">Cash </option>
											<option value="Credit">Credit </option>
										</select>
										<script>
											document.getElementById('payment_type').value = '<?php echo $payment_type; ?>';
										</script>
									</div>
								</div>

							</div>


							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4">Payment Mode</label>
									<div class="col-sm-8">
										<select name="payment_mode" id="payment_mode" class='form-control'>
											<option value=" ">Select</option>
											<option value="Cash">Cash </option>
											<option value="Cheque">Cheque </option>
											<option value="UPI">UPI </option>
										</select>
										<script>
											document.getElementById('payment_mode').value = '<?php echo $payment_mode; ?>';
										</script>
									</div>
								</div>

							</div>




							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4">Remark </label>
									<div class="col-sm-8">
										<input type="text" name="remark" id="remark" placeholder=" " class="form-control" value="<?php echo $remark; ?>">
									</div>
								</div>

							</div>
							<input type="hidden" name="main_id" id="main_id" placeholder=" " class="form-control" value="<?php echo $main_id; ?>">
						</div>


						<div class="row">
							<div class="col-sm-12">
								<div class="form-actions">
									<center>
										<a type="submit" onclick="getmaintenanceentry();" value="Save" class="btn btn-primary">Save</a>
										<a type="button" onclick="jQuery('#maintenance').click();" class="btn btn-red">Cancel</a>
									</center>
								</div>
							</div>
						</div>
					</form>
				</div>

				<div class="box box-color box-bordered red">
					<div class="box-title">
						<h3><i class="fa fa-table"></i>Recent Payment Details</h3>


						<a href="maintenance_report.php" class="btn btn-warning" style="float: right">Click Hear For All Entry
							<i class="fa fa-object-group"></i>
						</a> &nbsp;


						<!-- <a href="all-dispatch-entry.php" style="text-align: right" target="_blank">All Record</a> -->


						<a href="pdf/pdf_maintenance.php" class="btn" style="float: right" target="_blank">Pdf
							<i class="fa fa-file-pdf-o"></i>
						</a> &nbsp;
						<a href="excel/excel_maintenance.php" class="btn btn-warning" style="float: right">Excel
							<i class="fa fa-file-excel-o"></i>
						</a>

					</div>
					<div class="box-content nopadding">
						<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
							<thead>
								<tr>
									<th>S.No</th>

									<th>Truck No.</th>
									<th>Driver Name</th>
									<th> Date</th>
									<th>Mechanic Name.</th>
									<th>Maintenance / Spare </th>
									<th>Amount</th>
									<th>Payment Mode</th>
									<th>Remark</th>
									<th>User Name</th> 
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$sn = 1;
// echo "Select * from  $tblname where consignorid=$consignorid  order by $tblpkey desc limit 10";
								$sql = mysqli_query($connection, "Select * from  $tblname where consignorid=$consignorid  order by $tblpkey desc limit 10");
								while ($row = mysqli_fetch_array($sql)) {
									// $vehicle_no = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id=$row[vehicle_id]");
									// $mechanic_name = $cmn->getvalfield($connection, "mechanic_service_master", "mechanic_name", "mechanic_id=$row[mechanic_id]");
									// $driver_name = $cmn->getvalfield($connection, "m_driver", "driver_name", "driver_id=$row[driver_id]");
									// $head_name = $cmn->getvalfield($connection, "head_master", "head_name", "head_id=$row[head_id]");
$user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");

								?>
									<tr>
										<td><?php echo $sn++; ?></td>

										<td><?php echo $row['vehicle_id']; ?></td>
										<td><?php echo $row['driver_id']; ?></td>
										<td><?php echo dateformatindia($row['mdate']); ?></td>
										<td><?php echo $row['mechanic_id']; ?></td>
										<td><?php echo $row['head_id']; ?></td>
										<td><?php echo $row['amount']; ?></td>
										<td><?php echo $row['payment_mode']; ?></td>
										<td><?php echo $row['remark']; ?></td>
										<td><?php echo $user_name; ?></td>
										<td>
											<a onClick="modelFun('<?php echo $row['vehicle_id']; ?>','<?php echo $row['driver_id']; ?>','<?php echo $row['mdate']; ?>','<?php echo $row['mechanic_id']; ?>','<?php echo $row['head_id']; ?>','<?php echo $row['amount']; ?>','<?php echo $row['payment_mode']; ?>','<?php echo $row['remark']; ?>','<?php echo $row['payment_type']; ?>','<?php echo $row['main_id']; ?>')" class="btn btn-inverse" rel="tooltip" title="Edit">
												<i class="fa fa-edit"></i>
											</a>
											<a onclick="funDeletem(<?php echo $row['main_id']; ?>);" class="btn btn-danger" rel="tooltip" title="Delete">
												<i class="fa fa-times"></i>
											</a>
										</td>
									</tr>

								<?php } ?>
							</tbody>
						</table>

					</div>
				</div>
			</div><br />
		</div>