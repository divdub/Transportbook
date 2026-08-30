<?php
include("adminsession.php");
//    error_reporting(0);
$pagename = "dispatch_entry.php";

$dup = '';
if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
	$fromdate = $_GET['fromdate'];

	$todate = $_GET['todate'];
	$vehicle_id = trim(addslashes($_GET['vehicle_id']));
} else {
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
}

if (isset($_GET['vehicle_id'])) {
	$vehicle_id = trim(addslashes($_GET['vehicle_id']));
} else
	$vehicle_id = '';

if ($fromdate != '' && $todate != '') {
	$crit .= "bilty_date BETWEEN  '$fromdate' and  '$todate' ";
	//echo $crit;
}

if ($vehicle_id != '') {
	$crit .= " and vehicle_id='$vehicle_id'";
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

	<!-- <title>Trip Master</title> -->
	

	<?php include("inc/top-files.php"); ?>
</head>

<body onLoad="showrecord();">

	<?php include("inc/model.php"); ?>
	<?php include("inc/top-header.php"); ?>
	<div>
		<center>
			<h3>Trip Details</h3>
		</center>
	</div>


	<div class="box-content nopadding" style="overflow:scroll">
		<table class="table  table-bordered">
			<thead>

				<th>Sno </th>

				<th>Loding Date </th>
				 <th>Trip No./LR No. </th> 
				<th>Item Name </th>
					<!-- <th>Unloading Place </th> -->
				<!-- <th>Consignor(Party) </th>
											<th>Consignee(Party)</th> -->
				<th>Party Billing Type </th>
				<!-- <th>From Place </th>
											<th>To place </th> -->
				<th>Truck No. </th>
				<!-- <th>Billing Unit </th> -->
				<th>Qty</th>
				<th>Own Rate </th>
				<th>Company Rate  </th>
				<!-- <th>Trip Expenses </th> -->
				<th>Frieght Amt  </th>
				<!-- 
											<th>TP Name </th>
											<th>TP Amt </th>
										
											<th>Unloading Date </th>
											<th>Upload Builty </th> -->
				 <th>Action</th> 


			</thead>
			<tbody>

				<?php $sn = 1;
	// echo "select * from dispatch_entry where comp_id='$comp_id' and  $crit ";
				$sql = mysqli_query($connection, "select * from dispatch_entry where comp_id='$comp_id' and  $crit ");
				while ($row = mysqli_fetch_array($sql)) {

					$itemcategoryname = $cmn->getvalfield($connection, "m_item", "item_name", "item_id='$row[item_id]'");

					// $party_type = $cmn->getvalfield($connection, "m_supplier", "party_type", "dispatch_id='consignor' && party_type='$row[party_name]'");

					// $party_name = $cmn->getvalfield($connection, "m_supplier", "party_name", "supplier_id='$row[supplier_id]'");
					$place_name = $cmn->getvalfield($connection, "m_place", "place_name", "place_id='$row[place_id]'");
					$vehicle_no = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id='$row[vehicle_id]'");
					$unit_name = $cmn->getvalfield($connection, "m_unit", "unit_name", "unit_id='$row[unit_id]'");
					// $Consignor = $cmn->getvalfield($connection, "m_supplier", "party_name", "supplier_id='$row[consignorid]'");
					// $Consignee = $cmn->getvalfield($connection, "m_supplier", "party_name", "supplier_id='$row[consigneeid]'");
					$fromplace = $cmn->getvalfield($connection, "m_place", "place_name", "place_id='$row[place_id]'");
				$net_amount=	$row['comp_rate']*$row['qty'];
					// $tp_name = $cmn->getvalfield($connection, "tp_master", "tp_name", "tp_id='$row[tp_id]'");
					$totalamt += $net_amount;
                   $ft_amt += $row['own_rate'];
                  $te_amt += $row['comp_rate'];
				?>
					<tr>
					    <!--<a href="dispatch_entry_view.php?view=<?php echo $row['dispatch_id']?>" >-->
						<td><?php echo $sn++; ?></td>
						<td><?php echo date('d-m-Y', strtotime($row['bilty_date'])); ?></td>
						 <td><?php echo $row['di_no']; ?></td> 
						<td><?php echo $itemcategoryname; ?></td>
		<!-- <td><?php echo $row['unloading_place']; ?></td> -->
						<!-- <td><?php echo $Consignor; ?></td>	
											<td><?php echo $Consignee; ?></td> -->
						<td><?php echo $row['billing_type']; ?></td>
						<!-- <td><?php echo $fromplace; ?></td>	
											<td><?php echo $toplace; ?></td> -->

						<td><?php echo $vehicle_no; ?></td>
						<!-- <td><?php echo $unit_name; ?></td> -->
						<td><?php echo $row['qty']; ?></td>
						<td><?php echo $row['own_rate']; ?></td>
						<td><?php echo $row['comp_rate']; ?></td>
						<!-- <td><?php echo $row['trip_expenses']; ?></td> -->
						<td><?php echo $net_amount; ?></td>
						<!-- <td><?php echo $tp_name; ?></td>	
											<td><?php echo $row['tp_amount']; ?></td>
									
											<td><?php echo $row['bilty_date']; ?></td>
											<td><?php echo $row['upload_builty']; ?></td> -->


						 <td>
												<!--<a href='dispatch_entry.php?editid=<?php echo $row['dispatch_id']; ?>' class="btn btn-magenta">Edit</a>-->
												<!--<a  onClick="funDel(<?php echo $row['dispatch_id']; ?>)" class="btn btn-satblue">Delete</a>-->
												<a href='dispatch_entry_view.php?view=<?php echo $row['dispatch_id']; ?>' class="btn btn-primary">View</a>

											</td> 
					<?php } ?>
					</tr>
					</tbody>
					<tfoot>
					<tr>
						<td colspan="7" style="text-align:center;" > <b>Total</b></td>

						<td colspan=""></td>
						<td><b><?php echo $te_amt; ?></b></td>
						<td><b><?php echo $totalamt; ?></b></td>
						<td></td>

					</tr>

			</tfoot>
		</table>
		<!-- <div class="table-pagination">
									<a href="#" class='disabled'>First</a>
									<a href="#" class='disabled'>Previous</a>
									<span>
										<a href="#" class='active'>1</a>
										<a href="#">2</a>
										<a href="#">3</a>
									</span>
									<a href="#">Next</a>
									<a href="#">Last</a>
								</div> -->
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

			var tablename = 'dispatch_entry';
			var tableid = 'dispatch_id';

			if (confirm("Do You want to Delete this record ?")) {
				jQuery.ajax({
					type: 'POST',
					url: 'ajax/delete_master.php',
					data: 'id=' + id + '&tablename=' + tablename + '&tableid=' + tableid,
					dataType: 'html',
					success: function(data) {

						location = 'dispatch_entry.php?action=3';
					}
				}); //ajax close
			}
		}


		function funDel1(id) {
			var tablename = 'trip_expenses';
			var tableid = 'trip_expenses_id';

			if (confirm("Do You want to Delete this record ?")) {
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



		function addlist() {


			var inc_ex_id = document.getElementById("inc_ex_id").value;
			var trip_no = document.getElementById("trip_no").value;
			//alert(trip_no);

			var amt = document.getElementById("amt").value;

			var category = document.getElementById("category").value;

			if (inc_ex_id == '') {
				// alert(partid);
				alert('Expanse Name can not be blank!');
				document.getElementById('partid').focus();
				return false;
			}

			jQuery.ajax({
				type: 'POST',
				url: 'save_trip_model.php',
				data: 'inc_ex_id=' + inc_ex_id + '&amt=' + amt + '&category=' + category + '&trip_no=' + trip_no,
				success: function(data) {
					//alert(data);
					showrecord();
					jQuery("#amt").val('');

					// jQuery("#inc_ex_id").val('');
					// jQuery("#category").val('');

					jQuery("#category").val('').trigger("liszt:updated");
					jQuery('#category').val('').trigger('select2-me:updated');
					jQuery("#inc_ex_id").val('').trigger("liszt:updated");
					jQuery('#inc_ex_id').val('').trigger('select2-me:updated');
					jQuery('#inc_ex_id').trigger('liszt:activate'); // for autofocus
					jQuery("#inc_ex_id").focus();

				}
			}); //ajax close
		}

		function savedata() {

			jQuery.ajax({
				type: 'POST',
				url: 'save_trip.php',
				data: 'inc_ex_id=' + inc_ex_id,
				success: function(data) {
					jQuery("#trip_expenses").val(data);
					jQuery("#category").val('');
					jQuery("#myModal1").modal('hide');
					getTotal();
				}
			}); //ajax close

			// else {
			//    // alert("update");
			//    jQuery.ajax({
			// 	  type: 'POST',
			// 	  url: 'update_rojnamcha_payment.php',
			// 	  data: 'payment_date=' + payment_date + '&partid=' + partid + '&remark=' + remark + '&total_amt=' + total_amt + '&emppay_id=' + emppay_id,
			// 	  success: function(data) {
			// 		  //alert(data);
			// 		 showrecord();

			// 		 jQuery("#qty").val('');
			// 		 jQuery("#remark").val('');
			// 		 jQuery("#total_amt").val('');
			// 		 jQuery("#partid").val('').trigger("liszt:updated");
			// 		 jQuery('#partid').val('').trigger('chzn-single:updated');
			// 		 jQuery('#partid').trigger('liszt:activate'); // for autofocus
			// 		 jQuery("#partid").focus();

			// 	  }
			//    }); //ajax close
		}

		function showrecord() {
			var id = 0;
			jQuery.ajax({
				type: 'POST',
				url: 'show_tripexp.php',
				data: 'id=' + id,
				success: function(data) {
					jQuery("#showsalerecord").html(data);
				}
			}); //ajax close
		}


		function getTotal() {

			var qty_mt_day_trip = parseFloat(jQuery('#qty_mt_day_trip').val());
			var rate = parseFloat(jQuery('#rate').val());
			var frieght_amt = parseFloat(jQuery('#frieght_amt').val());
			var trip_expenses = parseFloat(jQuery('#trip_expenses').val());
			var tp_amount = parseFloat(jQuery('#tp_amount').val());
			//alert(tp_amount);
			var net_amount = parseFloat(jQuery('#net_amount').val());
			if (!isNaN(qty_mt_day_trip) && !isNaN(rate)) {
				var total = qty_mt_day_trip * rate;

			}

			jQuery('#frieght_amt').val(total);



			if (!isNaN(trip_expenses)) {
				var total = net_amount - trip_expenses;
				// alert(total);

			}

			if (!isNaN(tp_amount)) {
				var total = net_amount - tp_amount;
				// alert(net_amount);
				//alert(trip_expenses);
				// alert(total);


			}
			jQuery('#net_amount').val(total);
		}

		// datatables
	</script>
</body>



</html>