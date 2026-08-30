<?php
error_reporting(0);
include("adminsession.php");
include("function/dispatch_function.php");
$tblname = "dispatch_entry";
$tblpkey = "dispatch_id";
$pagename = "dispatch-process.php";
$modulename = "Dispatch Entry";
$duplicate = '';
if (isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = "";
}
if (isset($_GET['editid'])) {
	$editid = $_GET['editid'];
} else {
	$editid = 0;
}
$privilege_id = $cmn->getvalfield($connection, "user_privilege", "count(privilege_id)", "menu_id='1' && submenu_id='1' && subcat_id=0  && user_id='$user_id'");
if (isset($_GET['editid']) != "") {
	$editid = test_input($_GET['editid']);
	$sql = mysqli_query($connection, "select * from $tblname where $tblpkey='$editid'");
	$row = mysqli_fetch_array($sql);
	$di_no = $row['di_no'];
	$order_no 	 = $row['order_no'];
	$odn_no    = $row['odn_no'];
	$bilty_no    = $row['bilty_no'];
	$bilty_date = $row['bilty_date'];
	$invoice_no = $row['invoice_no'];
	$invoice_date = $row['invoice_date'];
	$gr_no = $row['gr_no'];
	$gr_date = $row['gr_date'];
	$item_id = $row['item_id'];
	$brand_id = $row['brand_id'];
	$wt_mt = $row['wt_mt'];
	$qty = $row['qty'];
	$comp_rate = $row['comp_rate'];
	$own_rate = $row['own_rate'];
	$consignor_id = $row['consignor_id'];
	$from_id = $row['from_id'];
	$consignee_id = $row['consignee_id'];
	$destination_id = $row['destination_id'];
	$vehicle_id = $row['vehicle_id'];
	$driver_id = $row['driver_id'];
	$eway_billno = $row['eway_billno'];
	$billing_type = $row['billing_type'];
	$bilty_scan = $row['bilty_scan'];
	$remark = $row['remark'];
	$inv_km = $row['inv_km'];
	$type = $row['type'];
	$paid_to = $row['paid_to'];
	$tparemark = $row['tparemark'];
	$checkbox = $row['checkbox'];
	$owner_id = $cmn->getvalfield($connection, "m_vehicle", "owner_id", "vehicle_id=$vehicle_id");
	$agent_id = $cmn->getvalfield($connection, "m_vehicle", "agent_id", "vehicle_id=$vehicle_id");
	$agent_name1 = $cmn->getvalfield($connection, "m_agent", "agent_name", "agent_id=$agent_id");
	$owner_name1 = $cmn->getvalfield($connection, "m_vehicle_owner", "owner_name", "owner_id=$owner_id");
	$mobile_no1 = $cmn->getvalfield($connection, "m_driver", "mobile_no", "driver_id=$driver_id");
	$balamt = $cmn->getvalfield($connection, "tpa_entry", "sum(amt)", "dispatch_id ='$editid'");
	$balrate = $cmn->getvalfield($connection, "tpa_entry", "sum(rate)", "dispatch_id ='$editid'");
	$freightamt = $wt_mt * $own_rate;
	//  echo $freightamt;
	//  $balamt=$amt;
	//  $balrate=$own$rate;

} else {
	$di_no = '';
	$odn_no = '';
	$order_no  = '';

	$serial = $cmn->getvalfield($connection, "dispatch_entry", "max(sno)", "consignor_id=$consignorid && session_id='$session_id'");
	// 		$serial=$sno + 1;
	$sno = $serial + 1;
	// 		$sno
	$bilty_no = '00' . $sno;

	$bilty_date = '';
	$invoice_no = '';
	$invoice_date = '';
	if($consignorid=='3'){
	$gr_no = '00' . $sno;
	}else{
	    $gr_no = '';
	}
	$type = '';
	$gr_date = '';
	$item_id = '';
	$brand_id = '';
	$wt_mt = '';
	$qty = '';
	$comp_rate = '';
	$own_rate = '';
	$consignor_id = $consignorid;
	if ($consignorid == 4) {
		$from_id = '5';
	} else {
		$from_id = '';
	}
	$consignee_id = '';
	$destination_id = '';
	$vehicle_id = '';
	$driver_id = '';
	$eway_billno = '';
	$billing_type = 'Consignor';
	$bilty_scan = ' ';
	$remark = '';
	$inv_km = '';
	$owner_name1 = '';
	$mobile_no1 = '';
	$agent_name1 = '';
	$checkbox = '';
	$paid_to = 'Truck Owner';
	$tparemark = '';
}
if (isset($_POST['submit'])) {
	$di_no = $_POST['di_no'];
	$sno = $_POST['sno'];
	$order_no = $_POST['order_no'];
	$odn_no = $_POST['odn_no'];
	$bilty_no = $_POST['bilty_no'];
	$bilty_date = $_POST['bilty_date'];
	$invoice_no = $_POST['invoice_no'];
	$invoice_date = $_POST['invoice_date'];
	$gr_no = $_POST['gr_no'];
	$gr_date = $_POST['gr_date'];
	$item_id = $_POST['item_id'];
	$brand_id = $_POST['brand_id'];
	$wt_mt = $_POST['wt_mt'];
	$qty = $_POST['qty'];
	$comp_rate = $_POST['comp_rate'];
	$own_rate = $_POST['own_rate'];
	$consignor_id = $_POST['consignor_id'];
	$from_id = $_POST['from_id'];
	$consignee_id = $_POST['consignee_id'];
	$destination_id = $_POST['destination_id'];
	$vehicle_id = $_POST['vehicle_id'];
	$driver_id = $_POST['driver_id'];
	$eway_billno = $_POST['eway_billno'];
	$remark = $_POST['remark'];
	$inv_km = $_POST['inv_km'];
	$billing_type = $_POST['billing_type'];
	$bilty_scan = $_FILES['bilty_scan'];
	$type = $_POST['type'];
	$paid_to = $_POST['paid_to'];
	// 	echo $paid_to; die;
	$tparemark = $_POST['tparemark'];

	$checkbox = $_POST['chk'];
	$agent_id = $cmn->getvalfield($connection, "m_vehicle", "agent_id", "vehicle_id='$vehicle_id'");
	$owner_id = $cmn->getvalfield($connection, "m_vehicle", "owner_id", "vehicle_id='$vehicle_id'");

	$form_data = array('di_no' => $di_no, 'inv_km' => $inv_km, 'order_no' => $order_no, 'odn_no' => $odn_no, 'tparemark' => $tparemark, 'sno' => $sno, 'paid_to' => $paid_to, 'bilty_no' => $bilty_no, 'bilty_date' => $bilty_date, 'type' => $type, 'invoice_no' => $invoice_no, 'invoice_date' => $invoice_date, 'gr_no' => $gr_no, 'gr_date' => $gr_date, 'item_id' => $item_id, 'brand_id' => $brand_id, 'wt_mt' => $wt_mt, 'qty' => $qty, 'comp_rate' => $comp_rate, 'own_rate' => $own_rate, 'consignor_id' => $consignor_id, 'from_id' => $from_id, 'consignee_id' => $consignee_id, 'destination_id' => $destination_id, 'vehicle_id' => $vehicle_id, 'owner_id' => $owner_id, 'agent_id' => $agent_id, 'driver_id' => $driver_id, 'checkbox' => $checkbox, 'eway_billno' => $eway_billno, 'remark' => $remark, 'billing_type' => $billing_type, 'comp_id' => $comp_id, 'session_id' => $session_id, 'created_date' => $currentdate, 'user_id' => $user_id);

	if ($editid  == 0) {
		$count = check_duplicate($connection, $tblname, "di_no='$di_no'");
		if ($count == 0) {
			dbRowInsert($connection, $tblname, $form_data);
			$lastid = $connection->insert_id;
			$imgpath2 = "upload/bilty/";

			$uploaded_filename1 = uploadImage($imgpath2, $bilty_scan);
			// echo "update tpa_entry  set dispatch_id='$lastid' where dispatch_id='0'";die;
			mysqli_query($connection, "update $tblname set bilty_scan='$uploaded_filename1' where $tblpkey='$lastid'");
			// mysqli_query($connection, "update tpa_entry set dispatch_id='$lastid' , di_no = '$di_no' ,bilty_date = '$bilty_date' where dispatch_id='0'  && consignorid = '$_SESSION[consignor_id]'");
			mysqli_query($connection, "update tpa_entry  set dispatch_id='$lastid' , di_no = '$di_no' ,bilty_date = '$bilty_date' where dispatch_id='0'");
			echo "<script>location='$pagename?action=1'</script>";
		} else {
			$duplicate = "ERROR: Duplicate Record...";
		}
	} else {

		if ($_FILES['bilty_scan']['tmp_name'] != "") {

			//delete old file
			$sql = mysqli_query($connection, "select * from $tblname where $tblpkey='$editid'");
			$rowimg = mysqli_fetch_array($sql);

			$oldimg = $rowimg["bilty_scan"];
			if ($oldimg != "") {
				unlink("upload/bilty/$oldimg");
			}
			$imgpath = "upload/bilty/";
			//insert new file
			$uploaded_filename = uploadImage($imgpath, $bilty_scan);

			mysqli_query($connection, "update $tblname set bilty_scan='$uploaded_filename' where $tblpkey='$editid'");
		}
		$form_data = array('di_no' => $di_no, 'inv_km' => $inv_km, 'order_no' => $order_no, 'bilty_no' => $bilty_no, 'odn_no' => $odn_no, 'type' => $type, 'paid_to' => $paid_to, 'bilty_date' => $bilty_date, 'invoice_no' => $invoice_no, 'invoice_date' => $invoice_date, 'gr_no' => $gr_no, 'gr_date' => $gr_date, 'item_id' => $item_id, 'brand_id' => $brand_id, 'wt_mt' => $wt_mt, 'qty' => $qty, 'comp_rate' => $comp_rate, 'own_rate' => $own_rate, 'consignor_id' => $consignor_id, 'from_id' => $from_id, 'consignee_id' => $consignee_id, 'destination_id' => $destination_id, 'vehicle_id' => $vehicle_id, 'owner_id' => $owner_id, 'agent_id' => $agent_id, 'driver_id' => $driver_id, 'eway_billno' => $eway_billno, 'remark' => $remark, 'checkbox' => $checkbox, 'billing_type' => $billing_type, 'comp_id' => $comp_id, 'session_id' => $session_id, 'updated_date' => $currentdate);
		dbRowUpdate($connection, $tblname, $form_data, "$tblpkey='$editid'");
		mysqli_query($connection, "update tpa_entry  set di_no ='$di_no',bilty_date ='$bilty_date' where dispatch_id='$editid'");
		echo "<script>location='$pagename?action=2'</script>";
	}
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

	<title>DISPATCH :: CHAARUVI INFOTECH PVT. LTD.</title>

	<?php include("inc/top-files.php"); ?>
</head>

<body onload="checkModal(<?php echo $checkbox ?>);">
	<!-- Place Modal Start-->
	<div class="modal fade" id="myModal7" role="dialog">
		<div class="modal-dialog" style="width:480px;padding-top: 225px;">


			<div class="modal-content" style="border-radius: 20px;">
				<div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
					<!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
					<center>
						<h4 class="modal-title"><b>ADD NEW PLACE<b></h4>
					</center>
				</div>
				<div class="modal-body" style="padding-top:30px;">
					<div class="row mb-3">
						<label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">PLACE NAME</label>
						<div class="col-sm-6">
							<input type="text" name="place_name" id="place_name" class="form-control" placeholder="" required>
						</div>
					</div>
					<br>

					<div class="row mb-3">
						<label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">STATE NAME</label>
						<div class="col-sm-6">
							<select name="state_id" id="state_id" class='form-control' required>
								<option value=""> Select </option>
								<?php $sql = mysqli_query($connection, "Select * from  m_state  order by state_id ");
								while ($row = mysqli_fetch_array($sql)) { ?>
									<option value="<?php echo $row['state_id']; ?>"><?php echo $row['state_name']; ?></option>
								<?php } ?>

							</select>
						</div>
					</div>
					<br>
					<div class="modal-footer">
						<center>
							<button class="btn btn-primary" onClick="save_place();" tabindex="12"> Save</button>
							<input type="button" data-dismiss="modal" class="btn btn-danger" value="Close">

							<!-- <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a> -->
						</center>
					</div>
				</div>

			</div>
		</div>

	</div>
	<!-- Place Modal End-->
	<!-- Driver Modal Start-->
	<div class="modal fade" id="myModal6" role="dialog">
		<div class="modal-dialog" style="width:480px;padding-top: 225px;">


			<div class="modal-content" style="border-radius: 20px;">
				<div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
					<!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
					<center>
						<h4 class="modal-title"><b>ADD NEW DRIVER<b></h4>
					</center>
				</div>
				<div class="modal-body" style="padding-top:30px;">
					<div class="row mb-3">
						<label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">DRIVER NAME</label>
						<div class="col-sm-6">
							<input type="text" name="driver_name" id="driver_name" class="form-control" placeholder="" required>
						</div>
					</div>
					<br>

					<div class="row mb-3">
						<label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">MOBILE NO.</label>
						<div class="col-sm-6">
							<input type="number" name="mobile_no" id="mobile_no" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" required>
						</div>
					</div>
					<br>
					<div class="modal-footer">
						<center>
							<button class="btn btn-primary" onClick="save_driver();" tabindex="12"> Save</button>
							<input type="button" data-dismiss="modal" class="btn btn-danger" value="Close">

							<!-- <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a> -->
						</center>
					</div>
				</div>

			</div>
		</div>

	</div>
	<!-- Driver Modal End-->

	<!-- Vehicle Modal Start-->
	<div class="modal fade" id="myModal5" role="dialog">
		<div class="modal-dialog" style="width:480px;padding-top: 225px;">


			<div class="modal-content" style="border-radius: 20px;">
				<div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
					<!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
					<center>
						<h4 class="modal-title"><b>ADD NEW VEHICLE<b></h4>
					</center>
				</div>
				<div class="modal-body" style="padding-top:30px;">
					<div class="row mb-3">
						<label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">VEHICLE NO.</label>
						<div class="col-sm-6">
							<input type="text" name="vehicle_no" id="vehicle_no" class="form-control" placeholder="" required>
						</div>
					</div>
					<br>
					<div class="row mb-3">
						<label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">OWNER NAME
							<!--<span class="badge shtcutbtn"><a class="shtcut" onClick="jQuery('#Modal5').modal('show');">+</a></span> -->
						</label>
						<div class="col-sm-6">
							<select name="owner_id" id="owner_id" class='form-control' required>
								<option value=""> Select </option>
								<?php $sql = mysqli_query($connection, "Select * from  m_vehicle_owner  order by owner_id ");
								while ($row = mysqli_fetch_array($sql)) { ?>
									<option value="<?php echo $row['owner_id']; ?>"><?php echo $row['owner_name']; ?></option>
								<?php } ?>

							</select>
						</div>
					</div>
					<br>
					<div class="row mb-3" style="display:none;">
						<label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">AGENT NAME </label>
						<div class="col-sm-6">
							<select name="agent_id" id="agent_id" class='form-control' required>
								<option value=""> Select </option>
								<?php $sql = mysqli_query($connection, "Select * from  m_agent  order by agent_id ");
								while ($row = mysqli_fetch_array($sql)) { ?>
									<option value="<?php echo $row['agent_id']; ?>"><?php echo $row['agent_name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<br>
					<div class="row mb-3">
						<label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">VEHICLE TYPE </label>
						<div class="col-sm-6">
							<select name="vehicle_type_id" id="vehicle_type_id" class='form-control' required>
								<option value=""> Select </option>
								<?php $sql = mysqli_query($connection, "Select * from  m_vehicle_type  order by vehicle_type_id ");
								while ($row = mysqli_fetch_array($sql)) { ?>
									<option value="<?php echo $row['vehicle_type_id']; ?>"><?php echo $row['no_of_wheels']; ?> - <?php echo $row['vehicle_type']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<br>
					<div class="modal-footer">
						<center>
							<button class="btn btn-primary" onClick="save_vehicle();" tabindex="12"> Save</button>
							<input type="button" data-dismiss="modal" class="btn btn-danger" value="Close">

							<!-- <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a> -->
						</center>
					</div>
				</div>

			</div>
		</div>

	</div>
	<!-- Vehicle Modal End-->
	<!-- Owner Modal Start-->
	<div class="modal fade" id="Modal5" role="dialog">
		<div class="modal-dialog" style="width:480px;padding-top: 225px;">


			<div class="modal-content" style="border-radius: 20px;">
				<div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
					<!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
					<center>
						<h4 class="modal-title"><b>ADD NEW OWNER<b></h4>
					</center>
				</div>
				<div class="modal-body" style="padding-top:30px;">
					<div class="row mb-3">
						<label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Owner Name</label>
						<div class="col-sm-6">
							<input type="text" name="owner_name" id="owner_name" class="form-control" placeholder="" required>
						</div>
					</div>
					<br>
					<div class="row mb-3">
						<label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Mobile No.</label>
						<div class="col-sm-6">
							<input type="text" name="mobileno1" id="mobileno1" class="form-control" placeholder="" required>
						</div>
					</div>


					<br>
					<div class="modal-footer">
						<center>
							<button class="btn btn-primary" onClick="save_owner();" tabindex="12"> Save</button>
							<input type="button" data-dismiss="modal" class="btn btn-danger" value="Close">

							<!-- <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a> -->
						</center>
					</div>
				</div>

			</div>
		</div>

	</div>
	<!-- Owner Modal End-->
	<!-- Brand Modal Start-->
	<div class="modal fade" id="myModal4" role="dialog">
		<div class="modal-dialog" style="width:480px;padding-top: 225px;">


			<div class="modal-content" style="border-radius: 20px;">
				<div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
					<!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
					<center>
						<h4 class="modal-title"><b>ADD NEW BRAND<b></h4>
					</center>
				</div>
				<div class="modal-body" style="padding-top:30px;">
					<div class="row mb-3">
						<label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">BRAND NAME</label>
						<div class="col-sm-6">
							<input type="text" name="brand_name" id="brand_name" class="form-control" placeholder="" required>
						</div>
					</div>

					<br>
					<div class="modal-footer">
						<center>
							<button class="btn btn-primary" onClick="save_brand();" tabindex="12"> Save</button>
							<input type="button" data-dismiss="modal" class="btn btn-danger" value="Close">

							<!-- <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a> -->
						</center>
					</div>
				</div>

			</div>
		</div>

	</div>
	<!-- Brand Modal End-->

	<!-- Item Modal Start-->
	<div class="modal fade" id="myModal3" role="dialog">
		<div class="modal-dialog" style="width:480px;padding-top: 225px;">


			<div class="modal-content" style="border-radius: 20px;">
				<div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
					<!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
					<center>
						<h4 class="modal-title"><b>ADD NEW ITEM<b></h4>
					</center>
				</div>
				<div class="modal-body" style="padding-top:30px;">
					<div class="row mb-3">
						<label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">ITEM NAME</label>
						<div class="col-sm-6">
							<input type="text" name="item_name" id="item_name" class="form-control" placeholder="" required>
						</div>
					</div>
					<br>
					<div class="row mb-3">
						<label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">CATEGORY NAME </label>
						<div class="col-sm-6">
							<select name="item_category_id" id="item_category_id" class='form-control' required>
								<option value=""> Select Category </option>
								<?php $sql = mysqli_query($connection, "Select * from  m_item_category  order by item_category_id ");
								while ($row = mysqli_fetch_array($sql)) { ?>
									<option value="<?php echo $row['item_category_id']; ?>"><?php echo $row['category_name']; ?></option>
								<?php } ?>

							</select>
						</div>
					</div>
					<br>
					<div class="row mb-3">
						<label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">UNIT </label>
						<div class="col-sm-6">
							<select name="unit_id" id="unit_id" class='form-control' required>
								<option value=""> Select Unit </option>
								<?php $sql = mysqli_query($connection, "Select * from  m_unit  order by unit_id ");
								while ($row = mysqli_fetch_array($sql)) { ?>
									<option value="<?php echo $row['unit_id']; ?>"><?php echo $row['unit_name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<br>
					<div class="modal-footer">
						<center>
							<button class="btn btn-primary" onClick="save_item();" tabindex="12"> Save</button>
							<input type="button" data-dismiss="modal" class="btn btn-danger" value="Close">

							<!-- <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a> -->
						</center>
					</div>
				</div>

			</div>
		</div>

	</div>
	<!-- Item Modal End-->

	<!-- Consignor Modal Start-->
	<div class="modal fade" id="myModal2" role="dialog">
		<div class="modal-dialog" style="width:480px;padding-top: 225px;">


			<div class="modal-content" style="border-radius: 20px;">
				<div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
					<!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
					<center>
						<h4 class="modal-title"><b>ADD NEW CONSIGNOR<b></h4>
					</center>
				</div>
				<div class="modal-body" style="padding-top:30px;">
					<div class="row mb-3">
						<label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">CONSIGNOR NAME</label>
						<div class="col-sm-6">
							<input type="text" name="consignor_name" id="consignor_name" class="form-control" placeholder="" required>
						</div>
					</div>
					<br>

					<div class="row mb-3">
						<label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">MOBILE NO.</label>
						<div class="col-sm-6">
							<input type="number" name="mobile_no" id="mobile_no" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10">
						</div>
					</div>
					<br>
					<div class="modal-footer">
						<center>
							<button class="btn btn-primary" onClick="save_consignor();" tabindex="12"> Save</button>
							<input type="button" data-dismiss="modal" class="btn btn-danger" value="Close">

							<!-- <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a> -->
						</center>
					</div>
				</div>

			</div>
		</div>

	</div>
	<!-- Consignor Modal End-->

	<!-- Consignee Modal Start-->
	<div class="modal fade" id="myModal1" role="dialog">
		<div class="modal-dialog" style="width:480px;padding-top: 225px;">


			<div class="modal-content" style="border-radius: 20px;">
				<div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
					<!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
					<center>
						<h4 class="modal-title"><b>ADD NEW CONSIGNEE<b></h4>
					</center>
				</div>
				<div class="modal-body" style="padding-top:30px;">
					<div class="row mb-3">
						<label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">CONSIGNEE NAME</label>
						<div class="col-sm-6">
							<input type="text" name="consignee_name" id="consignee_name" class="form-control" placeholder="" required>
						</div>
					</div>
					<br>

					<div class="row mb-3">
						<label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">MOBILE NO.</label>
						<div class="col-sm-6">
							<input type="number" name="mobile_no" id="mobile_no" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10">
						</div>
					</div>
					<br>
					<div class="modal-footer">
						<center>
							<button class="btn btn-primary" onClick="save_consignee();" tabindex="12"> Save</button>
							<input type="button" data-dismiss="modal" class="btn btn-danger" value="Close">
						</center>
					</div>
				</div>

			</div>
		</div>

	</div>
	<!-- Consignee Modal End-->
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
									<i class="fa fa-bars"></i>Dispatch
								</h3>
							</div>
							<div class="box-content nopadding">
								<ul class="tabs tabs-inline tabs-top">
									<!-- <li class='active'>
										<a id="dispatch" data-toggle='tab'>
											<i class="fa fa-inbox"></i>Dispatch Entry</a>
									</li> -->
									<?php $subsn = 1;
									$sql1 = mysqli_query($connection, "select * from user_privilege where menu_id='1' && submenu_id!=0 && subcat_id=0 && user_id='$user_id'  order by submenu_id  asc");
									while ($row1 = mysqli_fetch_array($sql1)) {
										$activity2 = $row1['status'];
										$submenu_id = $row1['submenu_id'];
										$submenu = $cmn->getvalfield($connection, "m_submenu", "submenu", "submenu_id='$submenu_id'");

										$pagelink2 = $cmn->getvalfield($connection, "m_submenu", "pagelink", "submenu_id='$submenu_id'");
										$sub_cat = $cmn->getvalfield($connection, "m_submenu", "sub_cat", "submenu_id='$submenu_id'");

									?>
										<li <?php if ($sub_cat == 1) { ?> class='active' <?php } ?>>
											<a id="<?php echo $pagelink2; ?>" data-toggle='tab'>
												<i class="fa fa-inbox"></i><?php echo ucfirst($submenu); ?></a>
										</li>
									<?php } ?>

									<li>
										<a id="report" data-toggle='tab' style="background: #2563eb; color: #ffffff">
											<i class="fa fa-share"></i>Dispatch Report</a>
									</li>

									<li>
										<a id="adreport" data-toggle='tab' style="background: #2563eb; color: #ffffff">
											<i class="fa fa-share"></i>Advance Report</a>
									</li>

									<li>
										<a id="rcreport" data-toggle='tab' style="background: #2563eb; color: #ffffff">
											<i class="fa fa-share"></i>Receiving Report</a>
									</li>

								</ul>
								<div class="tab-content padding tab-content-inline tab-content-bottom" id="main1">

									<?php if ($privilege_id == 1) { ?>
										<div class="tab-pane active" id="first11">
											<div class="col-sm-12">
												<div class="row" style="padding-top:20px;">
													<div class="col-sm-12">
														<?php if ($duplicate != '') { ?>
															<div class="alert alert-warning">
																<button data-dismiss="alert" class="close" type="button">×</button>
																<strong><i class="fa fa-clone"></i> Warning! The value you entered is already in the list. </strong>
															</div>
														<?php } ?>
														<?php include("inc/alert.php"); ?>
													</div>
												</div>
												<div class="box box-bordered box-color">
													<div class="box-title">



														<h3><i class="fa fa-list"></i>Dispatch Entry</h3>


													</div>

													<div class="box-content nopadding">

														<form action="" method="POST" class='form-horizontal form-column form-bordered' enctype="multipart/form-data">
															<div class="row">
																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">DI/LR No. <span style="color: red">*</span></label>
																		<div class="col-sm-8">
																			<input type="text" name="di_no" id="di_no" placeholder="Enter Number" class="form-control" required value="<?php echo $di_no; ?>">
																		</div>
																	</div>

																</div>

																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Order No.</label>
																		<div class="col-sm-8">
																			<input type="text" name="order_no" id="order_no" placeholder="Order No." class="form-control" value="<?php echo $order_no; ?>">
																		</div>
																	</div>

																</div>
																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Odn No.</label>
																		<div class="col-sm-8">
																			<input type="text" name="odn_no" id="odn_no" placeholder="Order No." class="form-control" value="<?php echo $odn_no; ?>">
																		</div>
																	</div>

																</div>
																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Bilty No. </label>
																		<div class="col-sm-8">
																			<input type="text" name="bilty_no" id="bilty_no" placeholder="Enter Bilty No." class="form-control" value="<?php echo $bilty_no; ?>" readonly>
																			<input type="hidden" name="sno" id="sno" placeholder="Enter Bilty No." class="form-control" value="<?php echo $sno; ?>" readonly>


																		</div>
																	</div>

																</div>

															</div>
															<div class="row">
																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Bilty Date. <span style="color: red">*</span> </label>
																		<div class="col-sm-8">
																			<input type="date" name="bilty_date" id="bilty_date" placeholder="DD/MM/YYYY" class="form-control" value="<?php echo $bilty_date; ?>" required>
																		</div>
																	</div>

																</div>


																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Invoice No <span style="color: red">*</span></label>
																		<div class="col-sm-8">
																			<input type="text" name="invoice_no" id="invoice_no" placeholder="Invoice Number" class="form-control" value="<?php echo $invoice_no; ?>" required>
																		</div>
																	</div>
																</div>

																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Invoice Date</label>
																		<div class="col-sm-8">
																			<input type="date" name="invoice_date" id="invoice_date" placeholder="Text input" class="form-control" value="<?php echo $invoice_date; ?>">
																		</div>
																	</div>

																</div>

																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">GR No <span style="color: red">*</span></label>
																		<div class="col-sm-8">
																			<input type="text" name="gr_no" id="gr_no" placeholder="GR Number" class="form-control" value="<?php echo $gr_no; ?>" required>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">GR Date <span style="color: red">*</span></label>
																		<div class="col-sm-8">
																			<input type="date" name="gr_date" id="gr_date" placeholder="Text input" class="form-control" value="<?php echo $gr_date; ?>" required>
																		</div>
																	</div>

																</div>

																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4"> Item <span style="color: red">*</span> <span class="badge shtcutbtn"><a class="shtcut" onClick="jQuery('#myModal3').modal('show');">+</a></span></label>
																		<div class="col-sm-8">
																			<select name="item_id" id="item_id" class='select2-me' style="width:100%;" required onchange="itemname(this.value);">
																				<option value=""> Select </option>
																				<?php $sql = mysqli_query($connection, "Select * from  m_item  order by item_id");
																				while ($row = mysqli_fetch_array($sql)) { ?>

																					<option value="<?php echo $row['item_id']; ?>"><?php echo $row['item_name']; ?></option>


																				<?php } ?>

																			</select>
																			<script>
																				document.getElementById('item_id').value = '<?php echo $item_id; ?>';
																			</script>
																		</div>
																	</div>

																</div>


																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4"> Brand <span class="badge shtcutbtn"><a class="shtcut" onClick="jQuery('#myModal4').modal('show');">+</a></span></label>
																		<div class="col-sm-8">
																			<select name="brand_id" id="brand_id" class='select2-me' style="width:100%;">
																				<option value=""> Select </option>
																				<?php $sql = mysqli_query($connection, "Select * from  m_brand  order by brand_id");
																				while ($row = mysqli_fetch_array($sql)) { ?>

																					<option value="<?php echo $row['brand_id']; ?>"><?php echo $row['brand_name']; ?></option>
																				<?php } ?>

																			</select>
																			<script>
																				document.getElementById('brand_id').value = '<?php echo $brand_id; ?>';
																			</script>
																		</div>
																	</div>

																</div>
																<div class="col-sm-3">
																	<div class="form-group">

																		<label for="textfield" class="control-label col-sm-4">Weight/MT <span style="color: red">*</span></label>
																		<div class="col-sm-8">
																			<input type="text" name="wt_mt" id="wt_mt" placeholder="Enter Weight" class="form-control" value="<?php echo $wt_mt; ?>" required onchange="itemname();">
																		</div>
																	</div>

																</div>


															</div>
															<div class="row">
																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Qty (Bags)</label>
																		<div class="col-sm-8">
																			<input type="text" name="qty" id="qty" placeholder="Enter Quantity" class="form-control" value="<?php echo $qty; ?>">
																		</div>
																	</div>

																</div>

																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Company Rate <span style="color: red">*</span> </label>
																		<div class="col-sm-8">
																			<input type="text" name="comp_rate" id="comp_rate" placeholder="Enter Company Rate" class="form-control" value="<?php echo $comp_rate; ?>" required onchange="calcOwnRate();">
																		</div>
																	</div>

																</div>


																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Own Rate <span style="color: red">*</span></label>
																		<div class="col-sm-8">
																			<input type="text" name="own_rate" id="own_rate" placeholder="Enter Own Rate" class="form-control" value="<?php echo $own_rate; ?>" required onchange="validateamt();">
																		</div>
																	</div>

																</div>

																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Consignor <span style="color: red">*</span> <span class="badge shtcutbtn">
																				<a class="shtcut" onClick="jQuery('#myModal2').modal('show');">+</a></span></label>
																		<div class="col-sm-8">
																			<select name="consignor_id" id="consignor_id" class='select2-me' style="width:100%;" required>
																				<option value=""> Select </option>
																				<?php $sql = mysqli_query($connection, "Select * from  m_consignor  order by consignor_id");
																				while ($row = mysqli_fetch_array($sql)) { ?>

																					<option value="<?php echo $row['consignor_id']; ?>"><?php echo $row['consignor_name']; ?></option>
																				<?php } ?>

																			</select>
																			<script>
																				document.getElementById('consignor_id').value = '<?php echo $consignor_id; ?>';
																			</script>
																		</div>
																	</div>

																</div>
															</div>
															<div class="row">
																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">From Place <span class="badge shtcutbtn"><a class="shtcut" onClick="jQuery('#myModal7').modal('show');">+</a></span></label>
																		<div class="col-sm-8">
																			<select name="from_id" id="from_id" class='select2-me' style="width:100%;">
																				<option value=""> Select </option>
																				<?php $sql = mysqli_query($connection, "Select * from  m_place  order by place_id");
																				while ($row = mysqli_fetch_array($sql)) { ?>

																					<option value="<?php echo $row['place_id']; ?>"><?php echo $row['place_name']; ?></option>
																				<?php } ?>

																			</select>
																			<script>
																				document.getElementById('from_id').value = '<?php echo $from_id; ?>';
																			</script>
																		</div>
																	</div>

																</div>



																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Consignee <span class="badge shtcutbtn"><a class="shtcut" onClick="jQuery('#myModal1').modal('show');">+</a></span></label>
																		<div class="col-sm-8">
																			<select name="consignee_id" id="consignee_id" class='select2-me' style="width:100%;">
																				<option value=""> Select </option>
																				<?php $sql = mysqli_query($connection, "Select * from  m_consignee  order by consignee_id");
																				while ($row = mysqli_fetch_array($sql)) { ?>

																					<option value="<?php echo $row['consignee_id']; ?>"><?php echo $row['consignee_name']; ?></option>
																				<?php } ?>

																			</select>
																			<script>
																				document.getElementById('consignee_id').value = '<?php echo $consignee_id; ?>';
																			</script>
																		</div>
																	</div>

																</div>


																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Destination <span class="badge shtcutbtn"><a class="shtcut" onClick="jQuery('#myModal7').modal('show');">+</a></span></label>
																		<div class="col-sm-8">

																			<select name="destination_id" id="destination_id" class='select2-me' style="width:100%;" onchange="getrate();">
																				<option value=""> Select </option>
																				<?php $sql = mysqli_query($connection, "Select * from  m_place  order by place_id");
																				while ($row = mysqli_fetch_array($sql)) { ?>

																					<option value="<?php echo $row['place_id']; ?>"><?php echo $row['place_name']; ?></option>
																				<?php } ?>

																			</select>
																			<script>
																				document.getElementById('destination_id').value = '<?php echo $destination_id; ?>';
																			</script>
																		</div>
																	</div>
																</div>


																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Truck No <span style="color: red">*</span> <span class="badge shtcutbtn"><a class="shtcut" onClick="jQuery('#myModal5').modal('show');">+</a></span></label>
																		<div class="col-sm-8">
																			<select name="vehicle_id" id="vehicle_id" class='select2-me' style="width:100%;" onChange="getOwner(this.value);" required>
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
															</div>
															<div class="row">
																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Owner Name</label>
																		<div class="col-sm-8">
																			<input type="text" name="owner_name1" id="owner_name1" placeholder="Text input" class="form-control" value="<?php echo $owner_name1; ?>" readonly>
																		</div>
																	</div>

																</div>

																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Driver Name <span class="badge shtcutbtn"><a class="shtcut" onClick="jQuery('#myModal6').modal('show');">+</a></span> </label>
																		<div class="col-sm-8">
																			<select name="driver_id" id="driver_id" class='select2-me' style="width:100%;" onChange="getdriver(this.value);" required>
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


																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Driver Mo. No. </label>
																		<div class="col-sm-8">
																			<input type="text" name="mobile_no1" id="mobile_no1" placeholder="Text input" class="form-control" value="<?php echo $mobile_no1; ?>">
																		</div>
																	</div>

																</div>

																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">E-way Bill No </label>
																		<div class="col-sm-8">
																			<input type="text" name="eway_billno" id="eway_billno" placeholder="Enter Bill No." class="form-control" value="<?php echo $eway_billno; ?>">
																		</div>
																	</div>

																</div>
															</div>
															<div class="row">
																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Billing Type</label>
																		<div class="col-sm-8">
																			<select name="billing_type" id="billing_type" class='form-control'>
																				<option value=" ">Select</option>
																				<option value="Consignor">Consignor </option>
																				<option value="Consignee">Consignee </option>
																			</select>
																			<script>
																				document.getElementById('billing_type').value = '<?php echo $billing_type; ?>';
																			</script>
																		</div>
																	</div>

																</div>


																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Type </label>
																		<div class="col-sm-8">
																			<select name="type" id="type" class="form-control" style="width:100%;">
																				<option value="">Select</option>
																				<option value="Party">Party</option>
																				<option value="Depo">Depo</option>
																				<option value="Non Trade">Non Trade</option>
																				<option value="Clinker">Clinker</option>
																				<option value="Manual">Manual</option>
																			</select>
																			<script>
																				document.getElementById('type').value = '<?php echo $type; ?>';
																			</script>
																		</div>
																	</div>

																</div>
																<input type="hidden" name="balamt" id="balamt" placeholder="Enter Amount" value="<?php echo $balamt ?>" class="form-control">
																<input type="hidden" name="balrate" id="balrate" placeholder="Enter Amount" value="<?php echo $balrate ?>" class="form-control">

																<input type="hidden" name="editid" id="editid" placeholder="Enter Amount" value="<?php echo $editid ?>" class="form-control">
																<input type="hidden" id="tpa_id" placeholder="Enter Amount" class="form-control">


																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Bilty Scan </label>
																		<div class="col-sm-8">
																			<input type="file" name="bilty_scan" id="bilty_scan" placeholder="Text input" class="form-control" value="<?php echo $bilty_scan; ?>">
																		</div>
																	</div>

																</div>


																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Invoice Km </label>
																		<div class="col-sm-8">
																			<input type="text" name="inv_km" id="inv_km" placeholder="Enter Invoice km" class="form-control" value="<?php echo $inv_km; ?>">
																		</div>
																	</div>

																</div>
															</div>
															<div class="row">
																<div class="col-sm-3">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Remark </label>
																		<div class="col-sm-8">
																			<input type="text" name="remark" id="remark" placeholder="Enter Remark" class="form-control" value="<?php echo $remark; ?>">
																		</div>
																	</div>

																</div>
															</div>
															<div class="col-sm-12" style="display:flex; justify-content:center; align-items:center; padding: 10px 0;">
																<input type="checkbox" name="chk" onclick="checkModal(this);" id="checkbox" <?php if ($checkbox == 1) { ?> checked <?php } ?> style="width:18px; margin-right: 8px; cursor: pointer;">
																<span style="font-size:16px; font-weight: bold; cursor: pointer;" onclick="document.getElementById('checkbox').click();"> Is Difference Payment? </span>
															</div>
															<div class="row">
																<div class="col-sm-12">
																	<div class="form-actions">
																		<center>

																			<input type="submit" name="submit" id="submit" value="Save" class="btn btn-primary">
																			<a type="button" href="<?php echo $pagename; ?>" class="btn btn-red">Cancel</a>
																		</center>
																	</div>
																</div>
															</div>

													</div>

													<div class="box box-color box-bordered red">
														<div class="box-title">
															<h3> <i class="fa fa-table"></i>
																Recent Dispatch Details</h3>
															<a href="all-dispatch-entry.php" class="btn btn-warning" style="float: right">Click Here For All Entry
																<i class="fa fa-object-group"></i>
															</a> &nbsp;


															<!-- <a href="all-dispatch-entry.php" style="text-align: right" target="_blank">All Record</a> -->


															<a href="pdf/pdf_dispatch_entry.php" class="btn" style="float: right" target="_blank">Pdf
																<i class="fa fa-file-pdf-o"></i>
															</a> &nbsp;
															<a href="excel/excel_dispatch_entry.php" class="btn btn-warning" style="float: right">Excel
																<i class="fa fa-file-excel-o"></i>
															</a>

														</div>
														<div class="box-content nopadding" style="overflow:scroll;">
															<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
																<thead>
																	<tr>
																		<th>S.No</th>
																		<th>DI No.</th>
																		<th>Bilty No.</th>
																		<th class='hidden-350'>Bilty Date</th>
																		<th>Consignor</th>
																		<th>Consignee</th>
																		<th class='hidden-1024'>Truck No.</th>
																		<th>Destination</th>
																		<th>Item</th>
																		<th>Weight/MT</th>
																		<!-- <th>Qty (Bags)</th> -->
																		<th>Company Rate</th>
																		<th>User Name</th>
																		<th class='hidden-480'>Action</th>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	$sn = 1;
																	$sql = mysqli_query($connection, "Select * from  $tblname where consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id order by bilty_date desc limit 10");
																	while ($row = mysqli_fetch_array($sql)) {
																		$consignor_name = $cmn->getvalfield($connection, "m_consignor", "consignor_name", "consignor_id=$row[consignor_id]");
																		$consignee_name = $cmn->getvalfield($connection, "m_consignee", "consignee_name", "consignee_id=$row[consignee_id]");
																		$vehicle_no = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id=$row[vehicle_id]");
																		$destination = $cmn->getvalfield($connection, "m_place", "place_name", "place_id=$row[destination_id]");
																		$item_name = $cmn->getvalfield($connection, "m_item", "item_name", "item_id=$row[item_id]");
																		$is_voucher = $row['is_voucher'];
																		$user_name = $cmn->getvalfield($connection, "m_userlogin", "user_name", "user_id=$row[user_id]");


																	?>
																		<tr>

																			<td><?php echo $sn++; ?></td>
																			<td><?php echo $row['di_no']; ?></td>
																			<td><?php echo $row['bilty_no']; ?></td>
																			<td><?php echo dateformatindia($row['bilty_date']); ?></td>
																			<td><?php echo $consignor_name; ?></td>
																			<td class='hidden-350'><?php echo $consignee_name; ?></td>
																			<td class='hidden-1024'><?php echo $vehicle_no; ?></td>
																			<td class='hidden-1024'><?php echo $destination; ?></td>
																			<td class='hidden-1024'><?php echo $item_name; ?></td>
																			<td><?php echo $row['wt_mt']; ?></td>
																			<!-- <td><?php echo $row['qty']; ?></td> -->
																			<td><?php echo $row['comp_rate']; ?></td>
																			<td><?php echo $user_name; ?></td>
																			<!-- <td><b><a href="upload/bilty/<?php echo $row['bilty_scan'] ?>" class="text-danger"  target="_blank" download>Download</a></b></td> -->
																			<td class='hidden-480'>
																				<a href="pdf/pdf_dispatch_printA4.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-warning" rel="tooltip" title="Builty A4" target="_blank">
																					<i class="fa fa-print">A4</i>
																					<a href="pdf/pdf_dispatch_printA5.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-info" rel="tooltip" title="Builty A5" style="margin-left: 3px;" target="_blank">
																						<i class="fa fa-print">A5</i>
																					</a>

																					<?php if ($is_voucher == '0' && $user_type == 'admin') { ?>
																						<a href="?editid=<?php echo $row['dispatch_id']; ?>" onchange="checkModal(<?php echo $row['checkbox']; ?>);" class="btn btn-inverse" rel="tooltip" title="Edit">
																							<i class="fa fa-edit"></i>
																						</a>
																					<?php } ?>

																					<?php if ($user_type == 'admin') { ?>


																						<a href="<?php echo $pagename ?>" onClick="funDel(<?php echo $row['dispatch_id']; ?>)" class="btn btn-danger" rel="tooltip" title="Delete">
																							<i class="fa fa-times"></i>
																						</a>
																					<?php } ?>
																			</td>
																		</tr>

																	<?php } ?>
																</tbody>
															</table>
														</div>
													</div>
												</div><br />
											</div>
										</div>
								</div>
							<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="myModal8" role="dialog" onload="showrecord();">
		<div class="modal-dialog" style="width:900px;padding-top: 150px;">

			<div class="modal-content" style="border-radius: 20px;">
				<div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
					<!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
					<center>
						<h4 class="modal-title"><b>Freight Bifurcation
								<b></h4>
					</center>
				</div>

				<div class="modal-body" style="padding-top:30px;">
					<div class="row col-12" style="padding-left: 15px;">
						<h5 style="padding-left:80px;font-weight: bold; color: red;"> Balance Amount : <span id="balamt1"></span> &nbsp; &nbsp;Balance Rate :<span id="balrate1"></span> </h5>

						<div class="row mb-6">

							<label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Adv Deduct From</label>

							<div class="col-sm-3">
								<select name="paid_to" id="paid_to" class='select2-me' style="width:100%;">
									<option value=" "> Select</option>
									<option value="Agent">Agent </option>
									<option value="Consignee">Consignee</option>
									<option value="Truck Owner">Truck Owner </option>
								</select>
								<script>
									document.getElementById('paid_to').value = '<?php echo $paid_to; ?>';
								</script>


							</div>





							<label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;"> Remark</label>
							<div class="col-sm-3">
								<input type="text" name="tparemark" id="tparemark" placeholder="Enter Remark" class="form-control" value="<?php echo $tparemark; ?>">
								<input type="hidden" name="tpavehicle_id" id="tpavehicle_id" placeholder="Enter Remark" class="form-control" value="<?php echo $tparemark; ?>">
								<input type="hidden" name="tpaconsignee_id" id="tpaconsignee_id" placeholder="Enter Remark" class="form-control" value="<?php echo $tparemark; ?>">
								<input type="hidden" name="tpawt_mt" id="tpawt_mt" placeholder="Enter Remark" class="form-control" value="<?php echo $tparemark; ?>">
								<input type="hidden" name="tpaown_rate" id="tpaown_rate" placeholder="Enter Remark" class="form-control" value="<?php echo $tparemark; ?>">


							</div>
						</div> <br>
						</form>
						<div class="row mb-6">
							<label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Category</label>

							<div class="col-sm-3">
								<select name="tpcat_id" id="tpcat_id" class='select2-me' style="width:100%;" onChange="gettpacatid();" required>
									<option value=""> Select </option>
									<?php $sql = mysqli_query($connection, "Select * from  tpcategory  order by tpcat_id");
									while ($row = mysqli_fetch_array($sql)) { ?>
										<option value="<?php echo $row['tpcat_id']; ?>"><?php echo $row['tp_name']; ?></option>
									<?php } ?>
									<script>
										document.getElementById('tpcat_id').value = '<?php echo $tpcat_id; ?>';
									</script>
								</select>


							</div>





							<label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;"> Name</label>
							<div class="col-sm-3">
								<select name="category_id" id="category_id" class="form-control">
									<option value="">Select</option>

									<option value="<?php echo $category_id ?>"><?php echo $cat_name; ?></option>
									<script>
										document.getElementById('category_id').value = '<?php echo $category_id; ?>';
									</script>
								</select>
							</div>
						</div> <br>



						<div class="row mb-6">
							<label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Rate <span style="color: red">*</span></label>
							<div class="col-sm-3">

								<input type="text" name="rate" id="rate" placeholder="Enter Rate" class="form-control" value="<?php echo $rate; ?>" required onchange="getamt();">
							</div>
							<label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Amount <span style="color: red">*</span></label>
							<div class="col-sm-3">
								<input type="text" name="amt" id="amt" placeholder="Enter Amount" class="form-control" value="<?php echo $amt; ?>" required>
							</div>
						</div>
						<br>

						<div class="modal-footer">
							<center>
								<a type="submit" value="Save" class="btn btn-primary" onclick="gettpaentry();">Add</a>
								<!-- <a type="button" href="<?php echo $pagename; ?>" class="btn btn-red">Cancel</a> -->
							</center>
						</div>
					</div>

					<div id="showrecord"></div>
					<br>
					<div class="modal-footer">
						<center>

							<input type="button" data-dismiss="modal" class="btn btn-danger" value="Close">

							<!-- <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a> -->
						</center>
					</div>
				</div>

				<script type="text/javascript" language="javascript">
					$(document).ready(function() { /// Wait till page is loaded
						$('#advance').click(function() {
							$('#main1').load('d-advance.php #main', function() {
								jQuery('.select2-me').select2();
								$("#advtable").load('ajax/show_advtable.php #advtable', function() {
									// jQuery("#advtable").html(data);
									$("#advtable").show();
									$("#showtoast").hide();
								});


								/// can add another function here
							});
						});
					}); //// End of Wait till page is loaded
				</script>
				<script type="text/javascript" language="javascript">
					$(document).ready(function() { /// Wait till page is loaded
						$('#dispatch').click(function() {
							$('#main1').load('dispatch-process.php #main1', function() {
								jQuery('.select2-me').select2();
								// jQuery("#advtable").html(data);

								/// can add another function here
							});
						});
					}); //// End of Wait till page is loaded
				</script>
				<script type="text/javascript" language="javascript">
					$(document).ready(function() { /// Wait till page is loaded
						$('#reciving').click(function() {
							$('#main1').load('d-receiving.php #main', function() {
								jQuery('.select2-me').select2();
								$("#showsingle").hide();
								$('input[type="radio"]').click(function() {
									var demovalue = $(this).val();

									if (demovalue == 'single') {
										$("#showmultiple").hide();
										$("#showsingle").show();
									}
									if (demovalue == 'multiple') {
										$("#showmultiple").show();
										$("#showsingle").hide();
									}
									// jQuery('#demovalue').val('');   
								});
								/// can add another function here
							});
						});
					}); //// End of Wait till page is loaded
				</script>

				<script type="text/javascript" language="javascript">
					$(document).ready(function() { /// Wait till page is loaded
						$('#report').click(function() {
							location = 'all-dispatch-entry.php';
						});
					}); //// End of Wait till page is loaded
				</script>
				<script type="text/javascript" language="javascript">
					$(document).ready(function() { /// Wait till page is loaded
						$('#adreport').click(function() {
							location = 'all-dispatch-advance.php';
						});
					}); //// End of Wait till page is loaded
				</script>
				<script type="text/javascript" language="javascript">
					$(document).ready(function() { /// Wait till page is loaded
						$('#rcreport').click(function() {
							location = 'all-receive-report.php';
						});
					}); //// End of Wait till page is loaded
				</script>
				<script>



				</script>
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


					function checkModal(checkbox) {
						// Assuming checkbox is passed as 'this' from the HTML element
						// alert(checkbox);
						// Retrieve the value of checkbox with id 'checkbox1'
						// var checkbox1 = document.getElementById('checkbox1').value;
						var consignee_id = document.getElementById('consignee_id').value;
						var vehicle_id = document.getElementById('vehicle_id').value;
						var own_rate = document.getElementById('own_rate').value;
						var wt_mt = document.getElementById('wt_mt').value;
						var balamt = document.getElementById('balamt').value;
						var balrate = document.getElementById('balrate').value;
						var editid = document.getElementById('editid').value;
						// Check the value of checkbox1
						if (editid != 0) {
							// If checkbox1 is 1, show modal and call showrecord()
							// alert(checkbox);
							if (checkbox == 1) {
								showrateintpa(consignee_id, vehicle_id, own_rate, wt_mt, balrate, balamt, editid);
								showrecord();
								jQuery('#checkbox').val(1);
							} else if (checkbox.checked) {
								showrateintpa(consignee_id, vehicle_id, own_rate, wt_mt, balrate, balamt, editid);
								showrecord();
								jQuery('#checkbox').val(1);
							} else {
								jQuery('#checkbox').val(0);
							}
						} else {
							if (checkbox.checked) {
								// alert("ok");
								showrateintpa(consignee_id, vehicle_id, own_rate, wt_mt);
								showrecord(); // Call showrecord() function
								jQuery('#checkbox').val(1);

								// (checkbox.value = "1"); 

								// Toggle checkbox value and show alert
							} else {
								// showrateintpa(consignee_id,vehicle_id,own_rate,wt_mt);
								// showrecord(); 
								jQuery('#checkbox').val(0);
								// (checkbox.value = "0"); // Toggle checkbox value and show alert

							}
						}
						// alert(checkbox.value);
						// Toggle checkbox value and show modal based on new checkbox value

					}
				</script>
</body>



</html>