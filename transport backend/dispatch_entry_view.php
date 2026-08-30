<?php
include("adminsession.php");
//    error_reporting(0);
$pagename = "dispatch_entry_view.php";

$dup = '';
if ($_GET['view'] != 0) {

				
    $sql = mysqli_query($connection, "select * from dispatch_entry WHERE dispatch_id='$_GET[view]'");
	$row = mysqli_fetch_array($sql);



	$bilty_date = $row['bilty_date'];
	$di_no = $row['di_no'];
	$item_id = $row['item_id'];

	$itemcategoryname = $cmn->getvalfield($connection, "m_item", "item_name", "item_id=$item_id");

     $consignor_id = $row['consignor_id'];
    $Consignor = $cmn->getvalfield($connection, "m_consignor", "consignor_name", "consignor_id=$consignor_id");
   $consignee_id = $row['consignee_id']; 
    $billing_type = $row['billing_type'];
    $from_id = $row['from_id'];
    $destination_id = $row['destination_id'];
$Consignee = $cmn->getvalfield($connection, "m_consignee", "consignee_name", "consignee_id=$consignee_id"); 
$fromplace = $cmn->getvalfield($connection, "m_place", "place_name", "place_id=$from_id");
$toplace = $cmn->getvalfield($connection, "m_place","place_name", "place_id=$destination_id");
$vehicle_id = $row['vehicle_id']; 
$qty = $row['qty']; 
$own_rate = $row['own_rate']; 
$frieght_amt = $row['comp_rate']*$qty;

$vehicle_no = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id=$vehicle_id"); 
$unloading_place = $row['unloading_place'];
$unloading_date = $row['bilty_date'];
$upload_builty = $row['bilty_scan'];


} else {
	$bilty_date = '';
	$trip_no = '';
	$item_id = '';

	$consignor_id = '';
	$consignee_id = '';
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
													<b><?php echo date('d-m-Y', strtotime($bilty_date)); ?></b>
												</div>
											</div>

										</div>

										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Trip No./LR No.</label>
												<div class="col-sm-8">
													<b> <?php echo $di_no; ?></b>
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
												<label for="textfield" class="control-label col-sm-4">Qty/MT/DayTrip</label>
												<div class="col-sm-8">
											    <b> <?php echo $qty;?></b>

												</div>
											</div>

										</div>


										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Rate</label>
												<div class="col-sm-8">
											    <b> <?php echo $own_rate;?></b>

												</div>
											</div>

										</div>
                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Freight Amt</label>
												<div class="col-sm-8">
											    <b> <?php echo $frieght_amt;?></b>

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
	<b><a href="upload/bilty/<?php echo $upload_builty ?>" class="text-danger"  target="_blank" download>Download</a></b>
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