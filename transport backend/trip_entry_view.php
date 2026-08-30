<?php
include("adminsession.php");
//    error_reporting(0);
$pagename = "trip_entry.php";

$dup = '';


if (isset($_POST['submit'])) {
	$loding_date = $_POST['loding_date'];
	$trip_no = $_POST['trip_no'];
	$item_id = $_POST['item_id'];
	$consignorid = $_POST['consignorid'];
	$consigneeid = $_POST['consigneeid'];

	$toplaceid = $_POST['toplaceid'];
	$fromplaceid = $_POST['fromplaceid'];
	$vehicle_id = $_POST['vehicle_id'];
	$unit_id = $_POST['unit_id'];
	$qty_mt_day_trip = $_POST['qty_mt_day_trip'];
	$rate = $_POST['rate'];
	$frieght_amt = $_POST['frieght_amt'];
	$billing_type = $_POST['billing_type'];

	$trip_expenses = $_POST['trip_expenses'];
	$net_amount = $_POST['net_amount'];
	$tp_id = $_POST['tp_id'];
	$tp_amount = $_POST['tp_amount'];
  
	$unloading_place = $_POST['unloading_place'];
	$unloading_date = $_POST['unloading_date'];
	$upload_builty = $_FILES['upload_builty'];
	$trip_id = $_POST['trip_id'];
	if ($trip_id == '') {
		$sqlcheckdup = mysqli_query($connection, "SELECT * FROM trip_entry WHERE trip_id='trip_id'");


		$check = mysqli_num_rows($sqlcheckdup);
		if ($check > 0) {
			$dup = "<div class='alert alert-danger'>
   			<strong>Error!</strong> Error : Duplicate Record.
   			</div>";
		} else {


			$doc_name = $upload_builty['name'];
			$tm = "DOC";
			$tm .= microtime(true) * 1000;
			$ext = pathinfo($doc_name, PATHINFO_EXTENSION);
			$doc_name = $tm . "." . $ext;
			move_uploaded_file($upload_builty['tmp_name'], "uploaded/builty/" . $doc_name);
			// echo "INSERT into trip_entry set loding_date='$loding_date',trip_no='$trip_no',item_id='$item_id',billing_type='$billing_type',consignorid='$consignorid',consigneeid='$consigneeid',fromplaceid='$fromplaceid',toplaceid='$toplaceid',vehicle_id='$vehicle_id',unit_id='$unit_id',qty_mt_day_trip='$qty_mt_day_trip',rate='$rate',frieght_amt='$frieght_amt',trip_expenses='$trip_expenses',net_amount='$net_amount',upload_builty='$doc_name',userid='$userid',createdate='$createdate'";die;	   
			mysqli_query($connection, "INSERT into trip_entry set loding_date='$loding_date',trip_no='$trip_no',item_id='$item_id',billing_type='$billing_type',consignorid='$consignorid',consigneeid='$consigneeid',fromplaceid='$fromplaceid',toplaceid='$toplaceid',vehicle_id='$vehicle_id',unit_id='$unit_id',qty_mt_day_trip='$qty_mt_day_trip',rate='$rate',frieght_amt='$frieght_amt',trip_expenses='$trip_expenses',net_amount='$net_amount',tp_id='$tp_id',tp_amount='$tp_amount',unloading_place='$unloading_place',unloading_date='$unloading_date',upload_builty='$doc_name',userid='$userid',createdate='$createdate'");
			$action = 1;
			echo "<script>location='trip_entry.php?action=$action'</script>";
		}
	} else {
		$doc_name = $upload_builty['name'];
		$tm = "DOC";
		$tm .= microtime(true) * 1000;
		$ext = pathinfo($doc_name, PATHINFO_EXTENSION);
		$doc_name = $tm . "." . $ext;
		move_uploaded_file($upload_builty['tmp_name'], "uploaded/builty/" . $doc_name);
// 		if ($_FILES['upload_builty']['tmp_name'] != "") {

// echo "UPDATE trip_entry set loding_date='$loding_date',trip_no='$trip_no',item_id='$item_id',billing_type='$billing_type',consignorid='$consignorid',consigneeid='$consigneeid',fromplaceid='$fromplaceid',toplaceid='$toplaceid',vehicle_id='$vehicle_id',unit_id='$unit_id',qty_mt_day_trip='$qty_mt_day_trip',rate='$rate',frieght_amt='$frieght_amt',trip_expenses='$trip_expenses',net_amount='$net_amount',upload_builty='$doc_name',userid='$userid',createdate='$createdate' WHERE trip_id='$_GET[editid]'";die;
			mysqli_query($connection, "UPDATE trip_entry set loding_date='$loding_date',trip_no='$trip_no',item_id='$item_id',billing_type='$billing_type',consignorid='$consignorid',consigneeid='$consigneeid',fromplaceid='$fromplaceid',toplaceid='$toplaceid',vehicle_id='$vehicle_id',unit_id='$unit_id',qty_mt_day_trip='$qty_mt_day_trip',rate='$rate',frieght_amt='$frieght_amt',trip_expenses='$trip_expenses',net_amount='$net_amount',tp_id='$tp_id',tp_amount='$tp_amount',unloading_place='$unloading_place',unloading_date='$unloading_date',upload_builty='$doc_name',userid='$userid',createdate='$createdate' WHERE trip_id='$_GET[editid]'");
			$action = 2;
			echo "<script>location='trip_entry.php?action=$action'</script>";
// 		}
	}
}
if ($_GET['view'] != '') {
	$sql = mysqli_query($connection, "select * from trip_entry WHERE trip_id='$_GET[view]'");
	$row = mysqli_fetch_array($sql);
	$loding_date = $row['loding_date'];
	$trip_no = $row['trip_no'];
	$item_id = $row['item_id'];
	$itemcategoryname = $cmn->getvalfield($connection, "item_master", "itemcategoryname", "item_id=$item_id");
	$consignorid = $row['consignorid'];
	 $Consignor = $cmn->getvalfield($connection, "supplier_master", "party_name", "supplier_id=$consignorid");
	$consigneeid = $row['consigneeid']; 
	$billing_type = $row['billing_type'];
 $Consignee = $cmn->getvalfield($connection, "supplier_master", "party_name", "supplier_id=$consigneeid");
	$fromplaceid = $row['fromplaceid'];
	$toplaceid = $row['toplaceid'];
 $billing_type=$row['billing_type'];
	$vehicle_id = $row['vehicle_id']; 
		 $vehicle_no = $cmn->getvalfield($connection, "vehicle_master", "vehicle_no", "vehicle_id=$vehicle_id"); 
	$unit_id = $row['unit_id'];
	$tds = $row['tds_amt'];
	$qty_mt_day_trip = $row['qty_mt_day_trip'];
	$rate = $row['rate'];
	$frieght_amt = $row['frieght_amt'];
		 $trip_exself = $cmn->getvalfield($connection, "trip_expenses", "sum(amt)", "trip_no='$row[trip_no]' && category='Self' && vehicle_id=$vehicle_id"); 
	 $trip_exconsignee= $cmn->getvalfield($connection, "trip_expenses", "sum(amt)", "trip_no='$row[trip_no]' && category='Consignee'  && vehicle_id=$vehicle_id");
	  $trip_exconsignor = $cmn->getvalfield($connection, "trip_expenses", "sum(amt)", "trip_no='$row[trip_no]' && category='Consignor'  && vehicle_id=$vehicle_id");
	  if($trip_exconsignee==''){ $trip_exconsignee=0;}
	    if($trip_exself==''){ $trip_exself=0;}
	      if($trip_exconsignor==''){ $trip_exconsignor=0;}
	$trip_expenses = $row['trip_expenses'];
	$net_amount = $row['net_amount'];
 if($billing_type=='Consignor'){
     $pfamt=$frieght_amt - $trip_exconsignor ;
     
 }
if($billing_type=='Consignee'){
     $pfamt=$frieght_amt - $trip_exconsignee ;
     
 }
	$tp_id = $row['tp_id'];
	 $tp_name = $cmn->getvalfield($connection, "tp_master", "tp_name", "tp_id=$tp_id");
	$tp_amount = $row['tp_amount'];
   $fromplace = $cmn->getvalfield($connection, "city_master", "city_name", "city_id=$fromplaceid");
    $toplace = $cmn->getvalfield($connection, "city_master", "city_name", "city_id=$toplaceid");
   

	$unloading_place = $row['unloading_place'];
	$unloading_date = $row['unloading_date'];
	$upload_builty = $row['upload_builty'];

    $unit_name = $cmn->getvalfield($connection, "unit_master", "unit_name", "unit_id=$unit_id");
} else {
	$loding_date = '';
	$trip_no = '';
	$item_id = '';

	$consignorid = '';
	$consigneeid = '';
	$billing_type = '';

	$fromplaceid = '';
	$toplaceid = '';
	$vehicle_id = '';

	$unit_id = '';
	$qty_mt_day_trip = '';
	$rate = '';
	$frieght_amt = '';
	$trip_expenses = '';

	$net_amount = '';

	$tp_id = '';
	$tp_amount = '';
	$unloading_place = '';

	$unloading_date = '';
	$upload_builty = '';
}


$sql = mysqli_query($connection, "select * from trip_entry");
while ($row = mysqli_fetch_array($sql)) {

    // $itemcategoryname = $cmn->getvalfield($connection, "item_master", "itemcategoryname", "item_id='$row[item_id]'");
    
        //  $party_type = $cmn->getvalfield($connection, "supplier_master", "party_type", "trip_id='consignor' && party_type='$row[party_name]'");

    // // $party_name = $cmn->getvalfield($connection, "supplier_master", "party_name", "supplier_id='$row[supplier_id]'");
    // $place_name = $cmn->getvalfield($connection, "place_master", "place_name", "place_id='$row[place_id]'");
    // // $vehicle_no = $cmn->getvalfield($connection, "vehicle_master", "vehicle_no", "vehicle_id='$row[vehicle_id]'");
    // $unit_name = $cmn->getvalfield($connection, "unit_master", "unit_name", "unit_id='$row[unit_id]'");

    // // $Consignor = $cmn->getvalfield($connection, "supplier_master", "party_name", "supplier_id='$row[consignorid]'");
    // // $Consignee = $cmn->getvalfield($connection, "supplier_master", "party_name", "supplier_id=$consigneeid");
    // $fromplace = $cmn->getvalfield($connection, "city_master", "city_name", "city_id='$row[fromplaceid]'");
    // $toplace = $cmn->getvalfield($connection, "city_master", "city_name", "city_id='$row[toplaceid]'");
    // $tp_name = $cmn->getvalfield($connection, "tp_master", "tp_name", "tp_id='$row[tp_id]'");


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
	<div class="modal fade" role="dialog" id="myModal1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Expances list</h4>
				</div>
				<!-- /.modal-header -->
			
			</div>
			</td>

		

			</tr>
			</tbody>

			<input type="hidden" name="emppay_id" id="emppay_id" class="input-xxlarge" style="width:50px;" value="<?php echo $emppay_id; ?>" autofocus autocomplete="off" />

			</table>
			<hr />
			
		</div>
	
	</div>
	<!-- /.modal-body -->

	<!-- /.modal-footer -->
	</div>
	<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
	</div>

	<div class="container-fluid nav-hidden" id="content">
		<?php include("inc/left-menu.php"); ?>

		<div id="main">
			<div class="container-fluid">
				<div class="page-header">

					<div class="pull-right">
						<ul class="minitiles">
							<li class='grey'>
								<a href="#">
									<i class="fa fa-cogs"></i>
								</a>
							</li>
							<li class='lightgrey'>
								<a href="#">
									<i class="fa fa-globe"></i>
								</a>
							</li>
						</ul>
						<ul class="stats">
							<li class='satgreen'>
								<i class="fa fa-money"></i>
								<div class="details">
									<span class="big">$324,12</span>
									<span>Balance</span>
								</div>
							</li>
							<li class='lightred'>
								<i class="fa fa-calendar"></i>
								<div class="details">
									<span class="big">February 22, 2013</span>
									<span>Wednesday, 13:56</span>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="breadcrumbs">
					<ul>
						<li>
							<a href="more-login.html">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>

							<a href="forms-basic.html">Forms</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="forms-basic.html">Basic forms</a>
						</li>
					</ul>
					<div class="close-bread">
						<a href="#">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>


				<div class="row">
					<div class="col-sm-12">
						<div class="box box-bordered box-color">
							<div class="box-title">
								
							</div>
							<div class="box-content nopadding">
								<form action="#" method="POST" class='form-horizontal form-column form-bordered' enctype="multipart/form-data">

									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Loding Date</label>
												<div class="col-sm-8">
													<b><?php echo date('d-m-Y', strtotime($loding_date)); ?></b>
												</div>
											</div>

										</div>

										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Trip No./LR No.</label>
												<div class="col-sm-8">
													<b> <?php echo $trip_no; ?></b>
												</div>
											</div>

										</div>

										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4"> Item</label>
												<div class="col-sm-8">
                                                <b> <?php echo $itemcategoryname;?></b>


												</div>
											</div>

										</div>

									</div>


									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4"> Consignor(Party)</label>
												<div class="col-sm-8">
											    <b> <?php echo $Consignor;?></b>

												</div>
											</div>

										</div>


										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4"> Consignee(Party)</label>
												<div class="col-sm-8">
                                                <b> <?php echo $Consignee;?></b>

												</div>
											</div>

										</div>

										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4"> Party Billing Type</label>
												<div class="col-sm-8">
                                                <b> <?php echo $billing_type;?></b>


												</div>
											</div>

										</div>
									</div>


									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4"> From </label>
												<div class="col-sm-8">
                                                <b> <?php echo $fromplace;?></b>

												</div>
											</div>

										</div>

										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4"> To Place</label>
												<div class="col-sm-8">
											    <b> <?php echo $toplace;?></b>

												</div>
											</div>

										</div>

										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4"> Truck No.</label>
												<div class="col-sm-8">
                                                <b> <?php echo $vehicle_no; ?></b>

												</div>
											</div>

										</div>
									</div>


									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4"> Billing Unit</label>
												<div class="col-sm-8">
											    <b> <?php echo $unit_name;?></b>

												</div>
											</div>

										</div>



										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Qty/MT/DayTrip</label>
												<div class="col-sm-8">
											    <b> <?php echo $qty_mt_day_trip;?></b>

												</div>
											</div>

										</div>


										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Rate</label>
												<div class="col-sm-8">
											    <b> <?php echo $rate;?></b>

												</div>
											</div>

										</div>
									</div>


									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Freight Amt</label>
												<div class="col-sm-8">
											    <b> <?php echo $frieght_amt;?></b>

												</div>
											</div>

										</div>

										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Expenses(Self)</label>
												<div class="col-sm-8">
											    <b> <?php echo $trip_exself;?></b>

												</div>
											</div>

										</div>
	<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Expenses(Consignor)</label>
												<div class="col-sm-8">
											    <b> <?php echo $trip_exconsignor;?></b>

												</div>
											</div>

										</div>
										</div>
											<div class="row">
											<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Expenses(Consignee)</label>
												<div class="col-sm-8">
											    <b> <?php echo $trip_exconsignee;?></b>

												</div>
											</div>

										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">TDS Amt</label>
												<div class="col-sm-8">
											    <b> <?php echo $tds;?></b>

												</div>
											</div>

										</div>
									
									
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Net Amount</label>
												<div class="col-sm-8">
                                                <b> <?php echo $net_amount;?></b>


												</div>
											</div>
										
										</div>

									</div>
									<div class="row">

										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Unloading Place</label>
												<div class="col-sm-8">
											    <b> <?php echo $unloading_place;?></b>

												</div>
											</div>

										</div>
								
									
									<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Unloading date</label>
												<div class="col-sm-8">
											    <b> <?php echo dateformatindia($unloading_date);?></b>

												</div>
											</div>

										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Upload Bilty</label>
												<div class="col-sm-8">
												<!--echo    "uploaded/builty/<?php echo $upload_builty ?>";-->
	<b><a href="uploaded/builty/<?php echo $upload_builty ?>" class="text-danger"  target="_blank" download>Download</a></b>
												<!--<img style="width: 80px; height: 80px;border-radius: 10px;border: 2px solid black;" src="uploaded/builty/<?php echo $upload_builty ?>" alt="<?php echo $upload_builty; ?>" />-->
												</div>
											</div>

										</div>


									</div>


								</form>
							</div>
						</div>
					</div>
				</div>

	</div>

</body>



</html>