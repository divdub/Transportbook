<?php 
error_reporting(0);
include("adminsession.php");
include("function/account_function.php");
$tblname = " othr_inc_entry";
$tblpkey = "other_inc_id";
$pagename = "other_income_entry.php";
$modulename = "Other Income Entry";

?>

		
	
		<div class="tab-pane active" id="main" style="margin-left:0">
				<div class="row">
					



	      <!-- Pump Modal Start-->
	<div class="modal fade" id="myModal8" role="dialog">
    <div class="modal-dialog" style="width:480px;padding-top: 225px;" >


      <div class="modal-content" style="border-radius: 20px;">
        <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
          <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
          <center>
          <h4 class="modal-title"><b>ADD NEW PUMP<b></h4></center>
        </div>
        <div class="modal-body" style="padding-top:30px;">
          <div class="row mb-3">
            <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">PUMP NAME</label>
            <div class="col-sm-6">
              <input type="text" name="pump_name" id="pump_name"  class="form-control" placeholder="" required>
            </div>
          </div>
         <br>
         
          <div class="row mb-3">
            <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">HEAD NAME</label>
            <div class="col-sm-6">
              <input type="text" name="head_name" id="head_name"  class="form-control" >
            </div>
          </div>
        <br>
          <div class="modal-footer" >
          	<center>
            <button class="btn btn-primary" onClick="save_pump();" tabindex="12"> Save</button>
            <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a></center>
          </div>
        </div>

      </div>
    </div>

  </div>
  <!-- Pump Modal End-->

						<div class="col-sm-12" id="danger">
           
				</div>
				<div class="col-sm-12" id="success">
           
				</div>
					<div class="col-sm-12">
						
						<div class="box box-bordered box-color">
							<div class="box-title">
								
<h3><i class="fa fa-list"></i> Other Income Entry
</h3>
								
		</div>
							<div class="box-content nopadding" >
								<form action="#" method="POST" class='form-horizontal form-column form-bordered'>
									<div class="row">
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Income Date  <span style="color: red">*</span></label>
												<div class="col-sm-8">
												<input type="date" name="inc_date" id="inc_date" placeholder=" " class="form-control"  value="<?php echo $inc_date; ?>">
												</div>
											</div>
										
										</div>
										
										
										
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Other Income</label>
												<div class="col-sm-8">
				<select name="otherid" id="otherid" class='select2-me' style="width:100%;"  required>
				<option value="">      Select  </option>
				<?php		$sql = mysqli_query($connection,"Select * from  otherexp_master  order by otherid");
										  while($row= mysqli_fetch_array($sql)) { ?>
										  	
												<option value="<?php echo $row['otherid']; ?>"><?php echo $row['head_name']; ?></option>
								<?php } ?>

											</select>
		<script>document.getElementById('otherid').value = '<?php echo $otherid; ?>';</script>
												</div>
											</div>
										
										</div>
										
										
										<div class="col-sm-3" style="display:none;">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4"> Truck No.  </label>
												<div class="col-sm-8">
												<select name="vehicle_id" id="vehicle_id" class='select2-me' style="width:100%;"  required>
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
										<div class="col-sm-3"  style="display:none;">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Driver name</label>
												<div class="col-sm-8">
														<select name="driver_id" id="driver_id" class='select2-me' style="width:100%;"required>
				<option value="">      Select  </option>
				<?php		$sql = mysqli_query($connection,"Select * from  m_driver  order by driver_id");
										  while($row= mysqli_fetch_array($sql)) { ?>
										  	
												<option value="<?php echo $row['driver_id']; ?>"><?php echo $row['driver_name']; ?> / <?php echo $row['mobile_no']; ?></option>
								<?php } ?>

											</select>
		<script>document.getElementById('driver_id').value = '<?php echo $driver_id; ?>';</script>
	</select>
												</div>
											</div>
										
										</div>
										
                                	
																		<div class="col-sm-3">
																			<div class="form-group">
							<label for="textfield" class="control-label col-sm-4">Amount </label>
																				<div class="col-sm-8">
					<input type="text" name="amount" id="amount" placeholder=" " class="form-control"  value="<?php echo $amount; ?>">
																				</div>
																			</div>

																		</div>

																		<div class="col-sm-3" style="display:none;">
																			<div class="form-group">
			<label for="textfield" class="control-label col-sm-4" > Billing type</label>
																		<div class="col-sm-8">
								<select name="bill_type" id="bill_type" class='form-control'>
												<option value=" ">Select</option>
												<option value="Cash">Cash </option>
												<option value="Credit">Credit  </option>
												</select>
	<script>document.getElementById('bill_type').value = '<?php echo $bill_type; ?>';</script>	
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
													<option value="Plant ATM Withdrawl">Plant ATM Withdrawl</option>
														<option value="RTGS">RTGS</option>
												</select>
	<script>document.getElementById('payment_mode').value = '<?php echo $payment_mode; ?>';</script>
																				</div>
											</div>

																		</div>
														 </div>

									<div class="row">
									    	<div class="col-sm-3">
																			<div class="form-group">
					<label for="textfield" class="control-label col-sm-4">Transaction Id  </label>
																				<div class="col-sm-8">
					<input type="text" name="txnid" id="txnid" placeholder=" " class="form-control"  value="<?php echo $txnid; ?>">
																				</div>
																			</div>

																		</div>
																		<div class="col-sm-3">
																			<div class="form-group">
					<label for="textfield" class="control-label col-sm-4">Remark  </label>
																				<div class="col-sm-8">
					<input type="text" name="narration" id="narration" placeholder=" " class="form-control"  value="<?php echo $narration; ?>">
																				</div>
																			</div>

																		</div>
																	</div>
									
								<input type="hidden" name="other_inc_id" id="other_inc_id" placeholder=" " class="form-control"  value="<?php echo $other_inc_id ; ?>">
									<div class="row">
										<div class="col-sm-12">
											<div class="form-actions">
												<center>
			<a type="submit" onclick="getotherinc();"  value="Save" class="btn btn-primary">Save</a>
						<a type="button" onclick="jQuery('#other_inc').click();" class="btn btn-red">Cancel</a>
												</center>	
											</div>
										</div>
									</div>
								</form>
							</div>
							
							<div class="box box-color box-bordered red" >
			<div class="box-title">
			<h3><i class="fa fa-table"></i>Other Income  Details</h3>
				

					<a href="other_inc_report.php" class="btn btn-warning" style="float: right">Click Hear For All Entry
											<i class="fa fa-object-group"></i>
										</a> &nbsp;
				
				
					<!-- <a href="all-dispatch-entry.php" style="text-align: right" target="_blank">All Record</a> -->
				
				
		<a href="pdf/pdf_othr_inc.php" class="btn" style="float: right" target="_blank">Pdf 
											<i class="fa fa-file-pdf-o"></i>
										</a> &nbsp;
					<a href="excel/excel_othr_inc.php" class="btn btn-warning" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a> 	
				
			</div>
			<div class="box-content nopadding"  >
						<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
					<thead>
					<tr>
						<th>S.No</th>
						
						<!--<th>Truck No.</th>-->
						<!--<th>Driver Name</th>-->
						<th> Date</th>
						<th>Other Income</th>
						<!-- <th>Maintenance / Spare </th> -->
						<th>Amount</th>
						<th>Payment Mode</th>
						<th>Transaction Id</th>
            <th>Remark</th>
			<th>User Name</th>
						<th>Action</th>
					</tr>
					</thead>
					<tbody>
						 <?php
									$sn=1;
				// echo		"Select * from  $tblname   order by $tblpkey desc limit 10";
			$sql = mysqli_query($connection,"Select * from  $tblname where consignorid=$consignorid && session_id=$session_id order by $tblpkey desc limit 10");
										  while($row= mysqli_fetch_array($sql)) {
	
				$head_name=$cmn->getvalfield($connection,"otherexp_master","head_name","otherid=$row[otherid]");			  	
									$user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
										   ?>
					<tr>
					<td><?php echo $sn++;?></td>
				
						<td><?php echo dateformatindia($row['inc_date']); ?></td>
						<!-- <td><?php echo $mechanic_name; ?></td> -->
						<td><?php echo $head_name; ?></td>
						<td><?php echo $row['amount']; ?></td>
						<td><?php echo $row['payment_mode']; ?></td>
						<td><?php echo $row['txnid']; ?></td>
						<td><?php echo $row['narration']; ?></td>
						<td><?php echo $user_name; ?></td>
						<td>
						    <?php if($user_type=='admin'){ ?>
	<a  onClick="otheinc_detail('<?php echo $row['inc_date']; ?>','<?php echo $row['otherid']; ?>','<?php echo $row['amount']; ?>','<?php echo $row['payment_mode']; ?>','<?php echo $row['narration']; ?>','<?php echo $row['bill_type']; ?>','<?php echo $row['other_inc_id']; ?>','<?php echo $row['txnid']; ?>')" class="btn btn-inverse" rel="tooltip" title="Edit">
			<i class="fa fa-edit"></i>
		</a>
		
		<a onclick="funDel1(<?php echo $row['other_inc_id']; ?>);" class="btn btn-danger" rel="tooltip" title="Delete">
			<i class="fa fa-times"></i>
		</a>
		<?php } ?>
		</td>
					</tr>
					
					<?php } ?>
					</tbody>
				</table>
				<script type="text/javascript">
   
    </script>
			</div>
		</div>
						</div><br/>
					</div>
										
										
		
