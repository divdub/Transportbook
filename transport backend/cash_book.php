<?php
// error_reporting(0);
include("adminsession.php");
// include("function/dispatch_function.php");

$pagename = "cash_book.php";
$modulename = "Bilty Advance Details";

if (isset($_GET['fromdate'])) {
	$fromdate = $_GET['fromdate'];
} else
	$fromdate = date('Y-m-d');

if (isset($_GET['todate'])) {
	$todate = $_GET['todate'];
} else
	$todate = date('Y-m-d');





$cond = "";
$cond2 = "";



if ($fromdate != '' && $todate != '') {
	$cond = "and inc_date between '$fromdate' and '$todate' ";
	$cond1 = "and exp_date between '$fromdate' and '$todate' ";
	$cond2 = " and cash_adv_date between '$fromdate' and '$todate' ";
		$cond3 = " and saledate between '$fromdate' and '$todate' ";
	
}

$prevbalance = $cmn->getcashopeningplant($connection, $fromdate, $comp_id, $consignorid, $session_id);
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

	<title> CASH BOOK :: CHAARUVI INFOTECH PVT. LTD.</title>

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
									<i class="fa fa-list"></i>Cash Book
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
									<h3> <strong>Opening Balance: <?php
										echo number_format($prevbalance, 2); ?></strong> </h3>
									<a style="float:right;  " href="pdfcash_book.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>" target="_blank" class="btn btn-warning">

										PDF <i class="fa fa-file-pdf-o"></i></a>
									<a onclick="getwhatsapp('<?php echo $fromdate; ?>', '<?php echo $todate ?>')"><img src="img/whatsapp.png" style="width:30px;height:30px;float: right"></a>
									<span style="color:#F00;width: 70px;font-weight:bold;padding-top: 5px;float: right;" id="msg"></span>
										&nbsp;
										
									<a href="excel_cashbook.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>" class="btn btn-warning" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a>	
										
										
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
								<div class="box-content nopadding">
									<div class="col-sm-6">
										<div class="box box-color box-bordered">
											<div class="box-title">
												<h3>
													<i class="fa fa-bar-chart-o"></i>
													Other Income
												</h3>
											</div>

											<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
												<thead>
													<tr>
														<th>S No</th>
														<th>Date</th>
														<!--<th>Vehicle No.</th> -->
														<th>Head</th>

														<th>Amount</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$netbilty = 0;

													$slno = 1;
													// 	echo		"SELECT * FROM `othr_inc_entry`  where 1=1 and bill_type='Cash' and session_id='$session_id'  && consignorid=$consignorid $cond order by inc_date desc";
													$sql_table1 = "SELECT * FROM `othr_inc_entry`  where 1=1  and session_id='$session_id' && amount!=0 && consignorid=$consignorid $cond order by inc_date desc";

													$res_table1 = mysqli_query($connection, $sql_table1);
													while ($row_table1 = mysqli_fetch_assoc($res_table1)) {

														$paymentdate = $row_table1['inc_date'];
														$incomeamount = $row_table1['amount'];

														$head_id = $row_table1['otherid'];
														$vehicle_id = $row_table1['vehicle_id'];
														$headname = $cmn->getvalfield($connection, "otherexp_master", "head_name", "otherid='$head_id'");
														$payeename = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id='$vehicle_id'");

													?>
														<tr>
															<td><?php echo $slno++; ?></td>
															<td><?php echo $cmn->dateformatindia($paymentdate); ?></td>
															<!--<td><?php echo $payeename; ?></td> -->
															<td><?php echo $headname; ?></td>

															<td><?php echo $incomeamount; ?></td>

														</tr>

													<?php
														$netbilty += $incomeamount;
													}
													?>


												</tbody>
												<tfoot class="bg-light-blue">
													<tr>

														<th colspan="3" style="text-align:right">Total</th>

														<th style="text-align:right"><i class="fa fa-inr"></i> <?php echo number_format(round($netbilty), 2); ?></th>
													</tr>
												</tfoot>
											</table>
											</br></br><div class="box-title">
												<h3>
													<i class="fa fa-bar-chart-o"></i>
													Sale Income
												</h3>
											</div>
											<table border="1" width="100%" class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">

												<thead>

													<tr>
														<th>S No</th>
														<th>Date</th>
													<th>AdBlue Name</th>
														<th>Truck NO</th>
														<th>Amount</th>



													</tr>
												</thead>
												<tbody>
													<?php
													$sr = 1;
												
													$saleincome = 0;
													// echo "select * from dispatch_entry where 1=1  $cond2 and session_id='$session_id' and (cash_adv !=0)  order by cash_adv_date desc";
													$sql_tablen = "select * from saleentry where 1=1 $cond3 && session_id='$session_id'  && consignorid=$consignorid and payment_mode ='Cash' order by saledate desc";
													$res_tablen = mysqli_query($connection, $sql_tablen);
													while ($row_tablen = mysqli_fetch_assoc($res_tablen)) {
														$saledate = $row_tablen['saledate'];
														$truckno = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id='$row_tablen[vehicle_id]'");
														 $adblue_name=$cmn->getvalfield($connection,"m_adblue","adblue_name","adblue_id=$row_tablen[adblue_id]");
													?>
														<tr>
															<td><?php echo $sr++; ?></td>
															<td><?php echo dateformatindia($saledate); ?></td>
																<td align="right"> <?php echo $adblue_name; ?></td>

															<td align="right"> <?php echo $truckno; ?></td>
															<td align="right"><?php echo $row_tablen['amount']; ?></td>



														</tr>

													<?php
														$saleincome += $row_tablen['amount'];
													
													}
													?>
												</tbody>
												<tfoot class="bg-light-blue">
													<tr>

														<th colspan="4" style="text-align:right">Total</th>

														<th style="text-align:right"><?php echo number_format(round($saleincome), 2); ?></th>



													</tr>
												</tfoot>
											</table>

										</div>
									</div>
									<div class="col-sm-6">
										<div class="box box-color lightred box-bordered">
											
											<div class="box-title">
												<h3>
													<i class="fa fa-bar-chart-o"></i>
													Other Expense
												</h3>
											</div>
											<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
												<thead>

													<tr>
														<th>S No</th>
														<th>Date</th>

														<th>Head</th>
														<th>Narration</th>
														<th>Amount</th>


													</tr>
												</thead>
												<tbody>
													<?php
													$netbilty1 = 0;

													$slno = 1;
													$sql_table = "SELECT * FROM `other_expense_entry`  where 1=1  and session_id='$session_id' && amount!=0 && consignorid=$consignorid $cond1 order by exp_date desc";

													$res_table = mysqli_query($connection, $sql_table);
													while ($row_table = mysqli_fetch_assoc($res_table)) {

														$paymentdate = $row_table['exp_date'];
														$expamount = $row_table['amount'];

														$head_id = $row_table['otherid'];
														$narration = $row_table['narration'];
														$headname = $cmn->getvalfield($connection, "otherexp_master", "head_name", "otherid='$head_id'");

													?>
														<tr>
															<td><?php echo $slno++; ?></td>
															<td><?php echo $cmn->dateformatindia($paymentdate); ?></td>

															<td><?php echo $headname; ?></td>
															<td><?php echo $narration; ?></td>
															<td><?php echo $expamount; ?></td>

														</tr>

													<?php
														$netbilty1 += $expamount;
													}
													?>


												</tbody>
												<tfoot class="bg-light-blue">
													<tr>

														<th colspan="4" style="text-align:right">Total</th>

														<th style="text-align:right"><i class="fa fa-inr"></i> <?php echo number_format(round($netbilty1), 2); ?></th>
													</tr>
												</tfoot>
											</table>
											</br></br>
											<div class="box-title">
												<h3>
													<i class="fa fa-bar-chart-o"></i>
													Dispatch Advance
												</h3>
											</div>


											<table border="1" width="100%" class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">

												<thead>

													<tr>
														<th>S No</th>
														<th>Date</th>
														<th>DI No</th>
														<th>Truck NO</th>
														<th>Cash Adv</th>



													</tr>
												</thead>
												<tbody>
													<?php
													$slno = 1;
													$netadv = 0;
													$netotherAdv = 0;
													// echo "select * from dispatch_entry where 1=1  $cond2 and session_id='$session_id' and (cash_adv !=0)  order by cash_adv_date desc";
													$sql_table2 = "select * from dispatch_entry where 1=1  $cond2 and session_id='$session_id'  && consignor_id=$consignorid and (cash_adv !=0)  order by cash_adv_date desc";
													$res_table2 = mysqli_query($connection, $sql_table2);
													while ($row_table2 = mysqli_fetch_assoc($res_table2)) {
														$cash_adv_date = $row_table2['cash_adv_date'];
														$truckno = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id='$row_table2[vehicle_id]'");
													?>
														<tr>
															<td><?php echo $slno++; ?></td>
															<td><?php echo dateformatindia($cash_adv_date); ?></td>
															<td><?php echo $row_table2['di_no']; ?></td>

															<td align="right"> <?php echo $truckno; ?></td>
															<td align="right"><?php echo $row_table2['cash_adv']; ?></td>



														</tr>

													<?php
														$netadv += $row_table2['cash_adv'];
														$netotherAdv += $row_table2['other_cash_adv'];
													}
													?>
												</tbody>
												<tfoot class="bg-light-blue">
													<tr>

														<th colspan="4" style="text-align:right">Total</th>

														<th style="text-align:right"><?php echo number_format(round($netadv), 2); ?></th>



													</tr>
												</tfoot>
											</table>


										</div>
										
									</div>
									
								
								<?php $balamt = $prevbalance + $netbilty - $netadv - $netbilty1 + $saleincome; ?>
									<table class="table" width="100%" border="1" style="font-size:14px;">
    									<tr bgcolor="#CCCCCC">
    										<td>&nbsp; </td>
    										<td>&nbsp; </td>
    										<td align="right"><strong>Balance Amt : <i class="fa fa-inr"></i> <?php echo number_format(round($balamt), 2); ?></strong></td>
    									</tr>

							        </table>
							    </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- whatsapp model open -->
	<div class="modal fade" id="myModal_whatsapp" role="dialog">
		<div class="modal-dialog" style="width:480px;padding-top: 225px;">
			<div class="modal-content" style="border-radius: 20px;">
				<div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
					<!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
					<center>
						<h4 class="modal-title"><b>Send Message<b></h4>
					</center>
				</div>
				<div class="modal-body" style="flex-wrap: wrap-reverse;display: flex;">
					<span style="color:#F00;" id="suppler_model_error"></span>
					<table class="table table-condensed table-bordered">
						<tr>
							<th>Bill Name <span style="color:#F00;"> * </span> </th>
							<th>Contact No.</th>
						</tr>
						<tr>
							<td>
								<!-- <input type="hidden" name="w_category" id="w_category" class="form-control" value="" style="font-weight:bold; " autocomplete="off" readonly> -->
								<input type="text" name="w_bill_name" id="w_bill_name" class="form-control" value="" style="font-weight:bold; " autocomplete="off">
								<!-- <input type="hidden" name="w_owner_id" id="w_owner_id" class="form-control" value="" style="font-weight:bold; " autocomplete="off" readonly> -->
							</td>
							<td>
								<input type="number" name="w_mobile" id="w_mobile" placeholder="Mobile No" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" value="<?php echo $w_mobile; ?>" required>
								<!-- <input type="text" name="w_mobile" id="w_mobile" class="form-control" value="" style="font-weight:bold; " autocomplete="off"> -->
								<input type="hidden" name="w_billid" id="w_billid" class="form-control" value="" style="font-weight:bold; " autocomplete="off">
							</td>
						</tr>
						<tr >
							<input type="checkbox" name="numupdate" id="numupdate" value="1" style="width:18px;display: none;" /> <span style="font-size:16px;margin-top:10px;"></span>
							<!-- <input type="checkbox" id="layername1" name="layername" value="Drone Image" onclick="showLayerMap(1);"  /> -->
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" name="s_save" id="s_save" onClick="sendfile();">Send</button>
					<button data-dismiss="modal" class="btn btn-danger">Close</button>
					<!-- <input type="hidden" id="s_saleid" value=""> -->
				</div>
			</div>
		</div>
	</div>
		<script>
			function getwhatsapp(fromdate,todate){
				// var fromdate = document.getElementById('fromdate').value;
				// var todate = document.getElementById('todate').value;
				// alert(fromdate);
				jQuery.ajax({
					type: 'POST',
					url: 'pdf_cashbook_whatsapp.php',
					data: 'fromdate=' + fromdate + '&todate=' + todate,
					dataType: 'html',
					success: function(data) {
						// sendfile(vehicle_id,cat_id,bill_name,mobile);
						// getnum(billid,category,owner_id,bill_name,mobile);
						getnum(fromdate,todate);
					}
				});
			}

			function getnum(fromdate,todate) {
				// alert(fromdate);
				jQuery('#myModal_whatsapp').modal('show');
				jQuery('#w_billid').val(fromdate);
			
			}

			function sendfile() {
				var billid = document.getElementById('w_billid').value;
				// var owner_id = document.getElementById('w_billid').value;
				var mobile = document.getElementById('w_mobile').value;
				var bill_name = document.getElementById('w_bill_name').value;
				var numupdate = document.getElementById('numupdate');
				var type = "cashbook";

				if (numupdate.checked == true) {
					var upval = '1';
				} else {
					var upval = '0';
				}


				if (mobile == '') {
					alert("Please Enter Mobile No.");
					return false;
				}

				jQuery.ajax({
					type: 'POST',
					url: 'whatsapp.php',
					data: 'billid=' + billid + '&mobile=' + mobile + '&bill_name=' + bill_name  + '&type=' + type + '&upval=' + upval,
					dataType: 'html',
					success: function(data) {
						jQuery("#myModal_whatsapp").modal('hide');
						document.getElementById('msg').innerHTML = 'Sent';

					}

				}); //ajax close
			}
		</script>

</body>



</html>