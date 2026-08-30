<?php
error_reporting(0);
include("adminsession.php");
$tblname = "dispatch_entry";
$tblpkey = "dispatch_id";
$pagename = "d-advance.php";
$modulename = "Bilty Advance Entry";
$duplicate = '';
$diesel_adv_amt = '';
$cash_adv = '';
$diesel_rate = '';
$consignor_cash_adv = '';
$diesel_ltr = '';
$other_cash_adv = '';
$consignee_cash_adv = '';
if (isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = "";
}
if (isset($_GET['dispatch_id'])) {
	$keyvalue = $_GET['dispatch_id'];
} else {
	$keyvalue = 0;
}

if ($keyvalue == 0) {
	$bilty_no = '';
	$bilty_date = '';
	$consignor_name1 = '';
	$consignee_name1 = '';
	$vehicle_no1 = '';
	$mobileno1 = '';
	$order_no = '';
	$owner_name = '';
	$wt_mt = '';
	$freight_amt = '';
	$own_rate = '';
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
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog" style="width:480px;padding-top: 225px;">


				<div class="modal-content" style="border-radius: 20px;">
					<div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
						<!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
						<center>
							<h4 class="modal-title"><b>Check Otp<b></h4>
						</center>
					</div>
					<div class="modal-body" style="padding-top:30px;">
						<div class="row mb-3">
							<label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Enter 4 Digit Code</label>
							<div class="col-sm-6">

								<input type="text" name="otp" id="otp" class="form-control" placeholder="" required>
								<input type="hidden" id="ref_id" value="">
							</div>
						</div>
						<br>
						<input type="hidden" id="type" value="">

						<div class="modal-footer">
							<center>
								<button class="btn btn-primary" onClick="checkotp();" tabindex="12">Check</button>
								<a><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a>
							</center>
						</div>
					</div>

				</div>
			</div>

		</div>

		<!-- Pump Modal Start-->
		<div class="modal fade" id="myModal8" role="dialog">
			<div class="modal-dialog" style="width:480px;padding-top: 225px;">


				<div class="modal-content" style="border-radius: 20px;">
					<div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
						<!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
						<center>
							<h4 class="modal-title"><b>ADD NEW PUMP<b></h4>
						</center>
					</div>
					<div class="modal-body" style="padding-top:30px;">
						<div class="row mb-3">
							<label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">PUMP NAME</label>
							<div class="col-sm-6">
								<input type="text" name="pump_name" id="pump_name" class="form-control" placeholder="" required>
							</div>
						</div>
						<br>

						<div class="row mb-3">
							<label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">HEAD NAME</label>
							<div class="col-sm-6">
								<input type="text" name="head_name" id="head_name" class="form-control">
							</div>
						</div>
						<br>
						<div class="modal-footer">
							<center>
								<button class="btn btn-primary" onClick="save_pump();" tabindex="12"> Save</button>
								<a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a>
							</center>
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

					<h3><i class="fa fa-list"></i> Bilty Advance Entry</h3>

				</div>
				<div class="box-content nopadding">
					<form action="#" method="POST" class='form-horizontal form-column form-bordered'>
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4">DI/LR No. <span style="color: red">*</span></label>
									<div class="col-sm-8">
										<select name="dispatch_id" id="dispatch_id" class='select2-me' onChange="getdispatch();" style="width:100%;">
											<option value="">Select</option>
											<?php $sql = mysqli_query($connection, "Select * from  $tblname  where is_advance != 1 && consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id  order by $tblpkey ");
											while ($row = mysqli_fetch_array($sql)) { ?>
												<option value="<?php echo $row['dispatch_id']; ?>"><?php echo $row['di_no']; ?></option>
											<?php } ?>
											<script>
												document.getElementById('dispatch_id').value = '<?php echo $dispatch_id; ?>';
											</script>
										</select>

									</div>
								</div>

							</div>



							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4">Bilty No. </label>
									<div class="col-sm-8">
										<input type="text" name="bilty_no" id="bilty_no" placeholder="Bilty No." class="form-control" readonly value="<?php echo $bilty_no; ?>">
										<script>
											document.getElementById('bilty_no').value = '<?php echo $bilty_no; ?>';
										</script>
									</div>
								</div>

							</div>


							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4">Bilty Date. </label>
									<div class="col-sm-8">
										<input type="date" name="bilty_date" id="bilty_date" placeholder="DD/MM/YYYY" class="form-control" readonly value="<?php echo $bilty_date; ?>">
									</div>
								</div>

							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4">Order No.</label>
									<div class="col-sm-8">
										<input type="text" name="order_no" id="order_no" placeholder="Order Number" class="form-control" readonly value="<?php echo $order_no; ?>">
									</div>
								</div>

							</div>

						</div>

						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4">Consignor <span style="color: red">*</span></label>
									<div class="col-sm-8">
										<input type="text" name="consignor_name" id="consignor_name1" placeholder="Consignee Name" class="form-control" readonly value="<?php echo $consignor_name1; ?>">
									</div>
								</div>

							</div>

							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4">Consignee </label>
									<div class="col-sm-8">
										<input type="text" name="consignee_name" id="consignee_name1" placeholder="Consignee Name" class="form-control" readonly value="<?php echo $consignee_name1; ?>">
									</div>
								</div>

							</div>

							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4"> Weight/MT </label>
									<div class="col-sm-8">
										<input type="text" name="wt_mt" id="wt_mt" placeholder="Weight/MT " class="form-control" readonly value="<?php echo $wt_mt; ?>">
									</div>
								</div>

							</div>


							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4"> Own Rate </label>
									<div class="col-sm-8">
										<input type="text" name="own_rate" id="own_rate" placeholder="Own Rate" class="form-control" readonly value="<?php echo $own_rate; ?>">
									</div>
								</div>

							</div>
						</div>

						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4">Freight Amt </label>
									<div class="col-sm-8">
										<input type="text" name="freight_amt" id="freight_amt" placeholder="Freight Amount" class="form-control" readonly value="<?php echo $freight_amt; ?>">
									</div>
								</div>

							</div>

							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4">Truck No.</label>
									<div class="col-sm-8">
										<input type="text" name="vehicle_no" id="vehicle_no1" placeholder="Truck Number" class="form-control" readonly value="<?php echo $vehicle_no1; ?>">
									</div>
								</div>

							</div>

							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4">Owner Name </label>
									<div class="col-sm-8">
										<input type="text" name="owner_name" id="owner_name" placeholder="Owner Name" class="form-control" readonly value="<?php echo $owner_name; ?>">
									</div>
								</div>

							</div>


							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4">Owner Mobile No.</label>
									<div class="col-sm-8">
										<input type="text" name="mobileno1" id="mobileno1" placeholder="Contact Number" class="form-control" readonly value="<?php echo $mobileno1; ?>">
									</div>
								</div>

							</div>
						</div>

						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4" style="color: #F16567">Petrol Pump <span class="badge shtcutbtn"><a class="shtcut" onClick="jQuery('#myModal8').modal('show');">+</a></span></label>
									<div class="col-sm-8">
										<select name="pump_id" id="pump_id" class='select2-me' onchange="getpumprate(this.value);" style="width:100%;">
											<option value=" "> Select</option>
											<?php $sql = mysqli_query($connection, "Select * from  m_petrol_pump  order by pump_id ");
											while ($row = mysqli_fetch_array($sql)) { ?>
												<option value="<?php echo $row['pump_id']; ?>"><?php echo $row['pump_name']; ?></option>
											<?php } ?>
										</select>
										<script>
											document.getElementById('pump_id1').value = '<?php echo $pump_id; ?>';
										</script>
									</div>
								</div>

							</div>

							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4" style="color: #F16567">Diesel Rate </label>
									<div class="col-sm-8">
										<input type="text" name="diesel_rate" id="diesel_rate" placeholder="Current Rate" class="form-control" value="<?php echo $diesel_rate; ?>" onchange="getdieselamt();">
									</div>
								</div>

							</div>



							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4" style="color: #F16567">Diesel Adv. Amt. </label>
									<div class="col-sm-8">
										<input type="text" name="diesel_adv_amt" id="diesel_adv_amt" placeholder="Diesel Advance Amount" class="form-control" value="<?php echo $diesel_adv_amt; ?>" onchange="getdieselamt();">
										<script>
											document.getElementById('diesel_adv_amt').value = '<?php echo $diesel_adv_amt; ?>';
										</script>
									</div>
								</div>

							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4" style="color: #F16567">Diesel Ltr. </label>
									<div class="col-sm-8">
										<input type="text" name="diesel_ltr" id="diesel_ltr" placeholder="Diesel" class="form-control" value="<?php echo $diesel_ltr; ?>">
									</div>
								</div>

							</div>

						</div>


						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4" style="color:#73085B">Cash Advance</label>
									<div class="col-sm-8">
										<input type="text" name="cash_adv" id="cash_adv" placeholder="Cash Advance" class="form-control" value="<?php echo $cash_adv; ?>">
									</div>
								</div>

							</div>

							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4" style="color:sienna">Pay Type</label>
									<div class="col-sm-8">
										<select name="pay_type" id="pay_type" class='select2-me' style="width:100%;">
											<option value=""> Select</option>
											<option value="phone pay">Phone Pay</option>
											<option value="cash">Cash</option>
										</select>
										<script>
											document.getElementById('pay_type').value = '<?php echo $pay_type; ?>';
										</script>
									</div>
								</div>

							</div>




							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4" style="color:#73085B">Cash Adv. Date</label>
									<div class="col-sm-8">
										<input type="date" name="cash_adv_date" id="cash_adv_date" placeholder="Text input" class="form-control" value="<?php echo $cash_adv_date; ?>">
									</div>
								</div>

							</div>

							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4" style="color:blueviolet">GPS Amount</label>
									<div class="col-sm-8">
										<input type="text" name="other_cash_adv" id="other_cash_adv" placeholder="GPS Amount" class="form-control" value="<?php echo $other_cash_adv; ?>">
									</div>
								</div>

							</div>



						</div>

						<div class="row" style="display:none;">

							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4" style="color:darkcyan"> Consignor Cash Adv Date. </label>
									<div class="col-sm-8">
										<input type="date" name="consignor_cash_adv_date" id="consignor_cash_adv_date" placeholder="Text input" class="form-control" value="<?php echo $consignor_cash_adv_date; ?>">
									</div>
								</div>

							</div>

							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4" style="color:sienna"> Consignee Cash Adv. </label>
									<div class="col-sm-8">
										<input type="text" name="consignee_cash_adv" id="consignee_cash_adv" placeholder="Consignee Cash Advance" class="form-control" value="<?php echo $consignee_cash_adv; ?>">
									</div>
								</div>

							</div>


							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4" style="color:sienna">Consignee Cash Adv. Date </label>
									<div class="col-sm-8">
										<input type="date" name="consignee_cash_adv_date" id="consignee_cash_adv_date" placeholder="Text input" class="form-control" value="<?php echo $consignee_cash_adv_date; ?>">
									</div>
								</div>

							</div>
						</div>


						<div class="row">

							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4" style="color:blueviolet">GPS Date </label>
									<div class="col-sm-8">
										<input type="date" name="other_cash_adv_date" id="other_cash_adv_date" placeholder="Text input" class="form-control" value="<?php echo $other_cash_adv_date; ?>">
									</div>
								</div>

							</div>


							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4" style="color: #F16567">AdBlue </br>
										Stock :<span id="stock1" style="color:red;"></span> </label>
									<div class="col-sm-8">
										<select name="adblue_id" id="adblue_id" class='select2-me' onchange="getstock(this.value);" style="width:100%;">
											<option value=" "> Select</option>
											<?php $sql = mysqli_query($connection, "Select * from  m_adblue  order by adblue_id ");
											while ($row = mysqli_fetch_array($sql)) { ?>
												<option value="<?php echo $row['adblue_id']; ?>"><?php echo $row['adblue_name']; ?></option>
											<?php } ?>
										</select>
										<script>
											document.getElementById('adblue_id').value = '<?php echo $adblue_id; ?>';
										</script>
									</div>
								</div>

							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4" style="color:sienna">Qty</label>
									<div class="col-sm-8">
										<input type="text" name="adblueqty" id="adblueqty" placeholder="Enter Qty" class="form-control" value="<?php echo $adblueqty; ?>" onchange="getadblueamt();">
										<input type="hidden" name="stock" id="stock" placeholder="Enter Qty" class="form-control" value="<?php echo $adblueqty; ?>" onchange="getadblueamt();">

									</div>
								</div>

							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4" style="color:sienna">Rate </label>
									<div class="col-sm-8">
										<input type="text" name="rate" id="rate" placeholder="Enter AdBlue Rate" class="form-control" value="<?php echo $rate; ?>" onchange="getadblueamt();">
									</div>
								</div>
							</div>


						</div>


						<div class="row">

							<!-- AdBlue Amount -->
							<div class="col-sm-3">
								<div class="form-group">
									<label class="control-label col-sm-4" style="color:darkcyan">
										AdBlue Amount
									</label>
									<div class="col-sm-8">
										<input type="text" name="consignor_cash_adv"
											id="consignor_cash_adv"
											class="form-control">
									</div>
								</div>
							</div>

							<!-- Narration -->
							<div class="col-sm-3">
								<div class="form-group">
									<label class="control-label col-sm-4" style="color:sienna">
										Narration
									</label>
									<div class="col-sm-8">
										<input type="text" name="adv_remark"
											id="adv_remark"
											class="form-control">
									</div>
								</div>
							</div>

							<!-- ✅ Deduction Amount (NEW) -->
							<!-- <div class="col-sm-3">
        <div class="form-group">
            <label class="control-label col-sm-4" style="color:#F16567">
                Deduction
                <span class="badge shtcutbtn">
                    <a class="shtcut"
                       onclick="openDeductionModal()">+</a>
                </span>
            </label>
            <div class="col-sm-8">
                <input type="text"
                       id="total_deduction"
                       name="total_deduction"
                       class="form-control"
                       readonly
                       value=""> -->
							<!-- </div>
        </div>
    </div> -->
							<div class="col-sm-3">
								<div class="form-group">
									<label for="textfield" class="control-label col-sm-4"> Extra Amt <span class="badge shtcutbtn"><a class="shtcut" onClick="jQuery('#myModald').modal('show');loadDeductionTotal();">+</a></span></label>
									<div class="col-sm-8">
										<input type="text" name="deduct" id="deduct" placeholder="Enter Amt" class="form-control" onchange="gettotal();">
									</div>
								</div>
							</div>

							<!-- </div> -->
							<div class="row">
								<div class="col-sm-12">
									<div class="form-actions">
										<!-- <center>
			<a type="submit" onclick="getadventry();"  value="Save" class="btn btn-primary">Save</a> -->

										<center>
											<a type="submit" onclick="getadventry();" class="btn btn-primary">Save</a>

											<!-- <button type="button"
            class="btn btn-warning"
            data-toggle="modal"
            data-target="#deductionModal">
        Deduction Amount
    </button> -->

											<!-- <label class="control-label col-sm-4" style="color:#F16567">
    Deduction Amount
    <span class="badge shtcutbtn">
        <a class="shtcut" onclick="openDeductionModal()">+</a>
    </span>
</label> -->

											<a type="button" onclick="jQuery('#advance').click();" class="btn btn-red">Cancel</a>
										</center>
										<!-- <a type="button" onclick="jQuery('#advance').click();" class="btn btn-red">Cancel</a>
												</center>	 -->
									</div>
								</div>
							</div>
					</form>
				</div>

				<div class="box box-color box-bordered red">
					<div class="box-title">
						<h3><i class="fa fa-table"></i>Recent Advance Details</h3>


						<a href="all-dispatch-advance.php" class="btn btn-warning" style="float: right">Click Hear For All Entry
							<i class="fa fa-object-group"></i>
						</a> &nbsp;


						<!-- <a href="all-dispatch-entry.php" style="text-align: right" target="_blank">All Record</a> -->


						<a href="pdf/pdf_dispatch_advance.php" class="btn" style="float: right" target="_blank">Pdf
							<i class="fa fa-file-pdf-o"></i>
						</a> &nbsp;
						<a href="excel/excel_dispatch_advance.php" class="btn btn-warning" style="float: right">Excel
							<i class="fa fa-file-excel-o"></i>
						</a>

					</div>
					<div class="box-content nopadding" id="advtable">

					</div>
				</div>

				<body onLoad="showdrecord();showdrecordd();">
					<div class="modal fade" id="myModald" role="dialog">
						<div class="modal-dialog" style="width:850px;padding-top: 225px;">
							<div class="modal-content" style="border-radius: 20px;">
								<div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
									<!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
									<center>
										<h4 class="modal-title"><b>ADD / Deduction<b></h4>
									</center>
								</div>
								<div class="modal-body" style="padding-top:30px;">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th style="font-size:15px;font-weight:bold;">Extra Name</th>
												<th style="font-size:15px;font-weight:bold;">Action</th>

												<!-- <th style="font-size:15px;font-weight:bold;">Sap Doc No.</th> -->
												<!-- <th style="font-size:15px;font-weight:bold;">Inv/Ref No.</th> -->
												<th style="font-size:15px;font-weight:bold;">Date</th>
												<th style="font-size:15px;font-weight:bold;">Amount</th>

												<th style="font-size:15px;font-weight:bold;">Remark</th>
											</tr>
										</thead>
										<tbody>
											<tr>


												<td>
													<select name="deduct_id" id="deduction_id" class="form-control" required>
														<option value="">Select </option>
														<?php
														$sql = mysqli_query($connection, "SELECT * FROM m_deduct ORDER BY deduct_id");
														while ($row = mysqli_fetch_array($sql)) { ?>
															<option value="<?php echo $row['deduct_id']; ?>">
																<?php echo $row['deduct_name']; ?>
															</option>
														<?php } ?>
													</select>
												</td>
												<td>
													<select name="deduct_type" id="deduct_type" class="form-control" required>
														<option value="">Select Type</option>
														<option value="add">Release</option>
														<option value="subtract">Hold</option>
													</select>
												</td>

												<td>
													<input type="date" name="date" id="date" class="form-control" required>
												</td>

												<td>
													<input type="text" name="amount" id="amount" class="form-control" required placeholder="Amount">
												</td>

												<td>
													<input type="text" name="remark" id="remark" class="form-control" required placeholder="Remark">
												</td>

												<td>
													<input type="button" class="btn btn-primary" onClick="save_deduction();" value="ADD">
												</td>
											</tr>
										</tbody>
									</table>
									<div id="showdrecord"></div>
								</div>
								<div class="modal-footer">
									<center>
										<button class="btn btn-primary" tabindex="12" onclick="getdamt();"> Save</button>
										<input type="button" data-dismiss="modal" class="btn btn-danger" value="Close">
										<!-- <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a> -->
									</center>
								</div>
							</div>
						</div>
					</div>
					<div class="modal fade" id="myModaldshow" role="dialog">
						<div class="modal-dialog" style="width:850px;padding-top: 225px;">
							<div class="modal-content" style="border-radius: 20px;">
								<div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
									<!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
									<center>
										<h4 class="modal-title"><b>Extra DETAILS<b></h4>
									</center>
								</div>
								<div class="modal-body" style="padding-top:30px;">

									<div id="showdeduct"></div>
								</div>
								<div class="modal-footer">
									<center>

										<input type="button" data-dismiss="modal" class="btn btn-danger" value="Close">
										<!-- <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a> -->
									</center>
								</div>
							</div>
						</div>
					</div>



					<!-- </script> -->
					<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
					<script>

					</script>