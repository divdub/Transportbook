<?php 
error_reporting(0);
include("adminsession.php");
$tblname = "trip_payment";
$tblpkey = "pay_id";
$pagename = "trip_pay.php";
$modulename = "Payment Entry";


?>

		
	
		<div class="tab-pane active" id="main" style="margin-left:0">
				<div class="row">
					
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
								
<h3><i class="fa fa-list"></i> Payment Entry</h3>
								
		</div>
							<div class="box-content nopadding" >
								<form action="#" method="POST" class='form-horizontal form-column form-bordered'>
									<div class="row">
									
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Party Type <span style="color: red">*</span></label>
												<div class="col-sm-8">
												<select name="billing_type" id="billing_type" class='select2-me' onChange="gettype(this.value);" style="width:100%;">
													<option value="">Select</option>
		
														<option value="Consignor">Consignor</option>
														<option value="Consignee">Consignee</option>

			<script>
				document.getElementById('billing_type').value ='<?php echo $billing_type; ?>';</script>
							</select>
							
												</div>
											</div>
										
										</div>
									
										
										
										<div class="col-sm-3" id="shhide">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Party Name</label>
												<div class="col-sm-8">
<input type="text" name="bilty_no" id="bilty_no" placeholder="party_name." class="form-control" readonly value="<?php echo $bilty_no; ?>">
	<script>
				document.getElementById('bilty_no').value ='<?php echo $bilty_no; ?>';</script>
												</div>
											</div>
										
										</div>
														
										<div class="col-sm-3" id="consignor_show">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Consignor</label>
												<div class="col-sm-8">
			<select name="consignor_id" id="consignor_id" class='select2-me' onchange="getDetails(this.value,'consignor');" style="width:100%;" required>
												<option value=" "> Select</option>
		<?php	$sql = mysqli_query($connection,"Select * from  m_party  where p_type='consignor' order by party_id ");
										  while($row= mysqli_fetch_array($sql)) { ?>
											<option value="<?php echo $row['party_id']; ?>"><?php echo $row['party_name']; ?></option>
								<?php } ?>
							</select>
							<script>
				document.getElementById('consignor_id').value ='<?php echo $consignor_id; ?>';</script>
												</div>
											</div>
										
										</div>

										<div class="col-sm-3" id="consignee_show">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Consignee </label>
												<div class="col-sm-8">
			<select name="consignee_id" id="consignee_id" class='select2-me' onchange="getDetails(this.value,'consignee');" style="width:100%;" required>
												<option value=" "> Select</option>
		<?php	$sql = mysqli_query($connection,"Select * from  m_party  where p_type='consignee' order by party_id ");
										  while($row= mysqli_fetch_array($sql)) { ?>
											<option value="<?php echo $row['party_id']; ?>"><?php echo $row['party_name']; ?></option>
								<?php } ?>
							</select>
							<script>
				document.getElementById('consignee_id').value ='<?php echo $consignee_id; ?>';</script>
												</div>
											</div>
										
										</div>
														
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Trip No </label>
												<div class="col-sm-8">
													<select name="trip_id" id="trip_id" class='select2-me' onchange="getTrip(this.value);" style="width:100%;" required>
									<option value=" "> Select</option>
												<?php
	$sql = mysqli_query($connection, "select * from trip_entry where sessionconsignor_id=$consignorid && session_id=$session_id");

																		
														while ($row = mysqli_fetch_array($sql)) {
														             
														?>
														
															
												<option value="<?php echo $row['trip_id'];?>"><?php echo $row['trip_no'];?></option>
<?php } ?>
							</select>
						<!-- 	<script>
				document.getElementById('trip_id').value ='<?php echo $trip_id; ?>';</script> -->
												</div>
											</div>
										
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Loading Date </label>
												<div class="col-sm-8">
													<input type="text" name="loding_date" id="loding_date" placeholder="DD/MM/YYYY" class="form-control" readonly value="<?php echo $loding_date; ?>">
												</div>
											</div>
										
										</div>
										
                                    </div>

									<div class="row">
																		<div class="col-sm-3">
																			<div class="form-group">
			<label for="textfield" class="control-label col-sm-4">
Truck No.    <span style="color: red">*</span></label>
																				<div class="col-sm-8">
				<input type="text" name="truck_no" id="truck_no" placeholder="Vehicle Number" class="form-control" readonly value="<?php echo $truck_no; ?>">
																				</div>
																			</div>

																		</div>

																		<div class="col-sm-3">
																			<div class="form-group">
							<label for="textfield" class="control-label col-sm-4">
Freight Amt  </label>
																				<div class="col-sm-8">
					<input type="text" name="frieght_amt" id="frieght_amt" placeholder="Freight Amount" class="form-control" readonly value="<?php echo $freightamt; ?>">
																				</div>
																			</div>

																		</div>

																		<div class="col-sm-3">
																			<div class="form-group">
			<label for="textfield" class="control-label col-sm-4">Total Advance </label>
																		<div class="col-sm-8">
					<input type="text" name="tadv" id="tadv" placeholder="Cash + Diesel + consignor " class="form-control" readonly value="<?php echo $tadv; ?>">
																				</div>
											</div>

																		</div>


																		<div class="col-sm-3">
																			<div class="form-group">
			<label for="textfield" class="control-label col-sm-4">Balance Amt </label>
												<div class="col-sm-8">
				<input type="text" name="net_amount" id="net_amount" placeholder="Balance Amount" class="form-control" readonly value="<?php echo $net_amount; ?>">
																				</div>
											</div>

																		</div>
																	</div>
									
									<div class="row">
																		<div class="col-sm-3">
																			<div class="form-group">
					<label for="textfield" class="control-label col-sm-4">Discount /Deduct  </label>
																				<div class="col-sm-8">
					<input type="text" name="deduct_amt" id="deduct_amt" placeholder="Deduct Amount"  onchange="getnetamt();" class="form-control"  value="<?php echo $deduct_amt; ?>">
																				</div>
																			</div>

																		</div>
						<div class="col-sm-3">
																			<div class="form-group">
							<label for="textfield" class="control-label col-sm-4">
Net Amount</label>
																				<div class="col-sm-8">
						<input type="text" name="total_amt" id="total_amt" placeholder="Net Amount" class="form-control"  value="<?php echo $total_amt; ?>" readonly>
																				</div>
																			</div>
</div>
																		<div class="col-sm-3">
																			<div class="form-group">
							<label for="textfield" class="control-label col-sm-4">
Received Amt.</label>
																				<div class="col-sm-8">
						<input type="text" name="rec_amt" id="rec_amt" placeholder="Enter Amount" class="form-control"  value="<?php echo $rec_amt; ?>">
																				</div>
																			</div>

																		</div>

																		<div class="col-sm-3">
																			<div class="form-group">
							<label for="textfield" class="control-label col-sm-4">
Receive Date </label>
														<div class="col-sm-8">	
				<input type="date" name="rec_date" id="rec_date" placeholder="Owner Name" class="form-control"  value="<?php echo $rec_date; ?>">
																				</div>
																			</div>

																		</div>
						</div>
									
									<div class="row">
												


																		<div class="col-sm-3">
																			<div class="form-group">
							<label for="textfield" class="control-label col-sm-4">
Payment Mode</label>
																				<div class="col-sm-8">
				<select name="payment_mode" id="payment_mode" tabindex="13" class='form-control'>
														<option value="">Select</option>
														<option value="Cash">Cash</option>
														<option value="NEFT">NEFT</option>
														<option value="UPI">UPI</option>
														<script>
															document.getElementById('payment_mode').value = '<?php echo $payment_mode; ?>';
														</script>
													</select>
																				</div>
																			</div>

																		</div>
											
																		<div class="col-sm-3">
																			<div class="form-group">
						<label for="textfield" class="control-label col-sm-4" style="color: #F16567">Remark   </label>
																				<div class="col-sm-8">
						<input type="text" name="pay_remark" id="pay_remark" placeholder="Enter Remark" class="form-control" value="<?php echo $pay_remark; ?>">
																				</div>
																			</div>

																		</div>

																	</div>
									
									<input type="hidden" name="pay_id" id="pay_id" placeholder="Enter Remark" class="form-control" value="<?php echo $pay_id; ?>">
															

									
									<div class="row">
										<div class="col-sm-12">
											<div class="form-actions">
												<center>
			<a type="submit" onclick="getpaysave();"  value="Save" class="btn btn-primary">Save</a>
						<a type="button" onclick="jQuery('#pay').click();" class="btn btn-red">Cancel</a>
												</center>	
											</div>
										</div>
									</div>
								</form>
							</div>
							
							<div class="box box-color box-bordered red" >
			<div class="box-title">
			<h3><i class="fa fa-table"></i>Recent Payment Details</h3>
				

					<a href="trip_payment_report.php" class="btn btn-warning" style="float: right">Click Hear For All Entry
											<i class="fa fa-object-group"></i>
										</a> &nbsp;
				
				
					<!-- <a href="all-dispatch-entry.php" style="text-align: right" target="_blank">All Record</a> -->
				
				
		<!-- <a href="pdf/pdf_dispatch_advance.php" class="btn" style="float: right" target="_blank">Pdf 
											<i class="fa fa-file-pdf-o"></i>
										</a> &nbsp;
					<a href="excel/excel_dispatch_advance.php" class="btn btn-warning" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a> 	 -->
				
			</div>
			<div class="box-content nopadding" >
			<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
					<thead>
					<tr>
						<th>S.No</th>
						<th>Trip No.</th>
						<th>Truck No.</th>
						<th class='hidden-350'>Receive Date</th>
						<th>Consignor</th>
						<th>Consignee</th>
						<!-- <th class='hidden-1024'>Truck No.</th> -->
						<!-- <th>Destination</th> -->
						<!-- <th>Item</th> -->
						<th>Deduct Amt</th>
						<!-- <th>Qty (Bags)</th> -->
						<th>Receive Amt</th>	
						<!-- <th>Bilty Scan</th>	 -->
						<th class='hidden-480'>Action</th>
					</tr>
					</thead>
					<tbody>
	 <?php
									$sn=1;
								// echo	"Select * from  $tblname where sessionconsignor_id=$consignorid  order by $tblpkey desc limit 10";
				$sql = mysqli_query($connection,"Select * from  $tblname where sessionconsignor_id=$consignorid  order by $tblpkey desc limit 10");
										  while($row= mysqli_fetch_array($sql)) {
	$consignor_name=$cmn->getvalfield($connection,"m_party","party_name","party_id=$row[consignor_id]");
	$consignee_name=$cmn->getvalfield($connection,"m_party","party_name","party_id=$row[consignee_id]");

$trip_no=$cmn->getvalfield($connection,"trip_entry","trip_no","trip_id=$row[trip_id]");	
$vehicle_id=$cmn->getvalfield($connection,"trip_entry","vehicle_id","trip_id=$row[trip_id]");								  	
	$vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$vehicle_id");
	?>
					<tr>
						<td><?php echo $sn++;?></td>
						<td><?php echo $trip_no; ?></td>
						<td class='hidden-1024'><?php echo $vehicle_no; ?></td>
						<td><?php echo dateformatindia($row['rec_date']); ?></td>
						<td><?php echo $consignor_name; ?></td>
						<td class='hidden-350'><?php echo $consignee_name; ?></td>
					
						<!-- <td class='hidden-1024'><?php echo $destination; ?></td> -->
						<!-- <td class='hidden-1024'><?php echo $item_name; ?></td> -->
						<!-- <td><?php echo $row['rec_date']; ?></td> -->
						<td><?php echo $row['deduct_amt']; ?></td>
						<td><?php echo $row['rec_amt']; ?></td>
						<!-- <td><b><a href="upload/bilty/<?php echo $row['bilty_scan'] ?>" class="text-danger"  target="_blank" download>Download</a></b></td> -->
						<td class='hidden-480'>
	<!-- 	<a href="pdf/pdf_dispatch_printA4.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-warning" rel="tooltip" title="Builty A4"target="_blank" >
			<i class="fa fa-print">A4</i>
	<a href="pdf/pdf_dispatch_printA5.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-info" rel="tooltip" title="Builty A5" style="margin-left: 3px;" target="_blank">
			<i class="fa fa-print">A5</i>
		</a> -->
	<!-- 	<a      onClick="paydetail('<?php echo $row['pay_id']; ?>','<?php echo $row['billing_type']; ?>','<?php echo $row['consignor_id']; ?>','<?php echo $row['consignee_id']; ?>','<?php echo $row['deduct_amt']; ?>','<?php echo $row['rec_amt']; ?>','<?php echo $row['rec_date']; ?>','<?php echo $row['payment_mode']; ?>','<?php echo $row['pay_remark']; ?>','<?php echo $row['trip_id']; ?>')"  class="btn btn-inverse" rel="tooltip" title="Edit">
			<i class="fa fa-edit"></i>
		</a> -->
		<a  onClick="funDel1(<?php echo $row['pay_id']; ?>)" class="btn btn-danger" rel="tooltip" title="Delete">
			<i class="fa fa-times"></i>
		</a></td>
					</tr>
					
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
						</div><br/>
					</div>
										
										
		
