<?php
error_reporting(0);
include("adminsession.php");
include("function/dispatch_function.php");

$tblname = "x_party_entry";
$tblpkey = "di_id";
$pagename = "x_party_entry.php";
$modulename = "X-Party Entry";
$duplicate = '';

$action = isset($_GET['action']) ? $_GET['action'] : "";
$editid = isset($_GET['editid']) ? test_input($_GET['editid']) : 0;

// User privilege


// Existing record
if($editid != 0){
    $row = mysqli_fetch_array(mysqli_query($connection, "SELECT * FROM $tblname WHERE $tblpkey='$editid'"));

    $di_no         = $row['di_no'];
    $bilty_date    = $row['bilty_date'];
    $item_id       = $row['item_id'];
    $brand_id      = $row['brand_id'];
    $wt_mt         = $row['wt_mt'];
    $consignor_id  = $row['consignor_id'];
    $from_id       = $row['from_id'];
    $xconsignee_id = $row['xconsignee_id'];
    $vehicle_id    = $row['vehicle_id'];
    $driver_id     = $row['driver_id'];
    $remark        = $row['remark'];
    $comission     = $row['comission'];
    $inv_no=$row['inv_no'];
    $destination_id=$row['destination_id'];
    $owner_name1   = $cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=(SELECT owner_id FROM m_vehicle WHERE vehicle_id='$vehicle_id')");
    $mobile_no1    = $cmn->getvalfield($connection,"m_driver","mobile_no","driver_id='$driver_id'");
} else {
    // Defaults
    $di_no = $bilty_date = $item_id = $brand_id = $wt_mt  = $from_id = $xconsignee_id = $vehicle_id = $driver_id = $remark =  '';
    $consignor_id = $consignorid;
    $owner_name1 = $mobile_no1 = $inv_no= $destination_id='';
    $comission =20;
}

// Form submit
if(isset($_POST['submit'])){
    $di_no         = $_POST['di_no'];
    $bilty_date    = $_POST['bilty_date'];
    $item_id       = $_POST['item_id'];
    $brand_id      = $_POST['brand_id'];
    $wt_mt         = $_POST['wt_mt'];
     $destination_id=$_POST['destination_id'];
     $consignor_id  = $_POST['consignor_id'];
    $from_id       = $_POST['from_id'];
    $xconsignee_id = $_POST['xconsignee_id'];
    $vehicle_id    = $_POST['vehicle_id'];
    $driver_id     = $_POST['driver_id'];
	$mobile_no     = $_POST['mobile_no'];
    $remark        = $_POST['remark'];
    $comission     = $_POST['comission'];
    $inv_no =$_POST['inv_no'];

    $owner_id = $cmn->getvalfield($connection,"m_vehicle","owner_id","vehicle_id='$vehicle_id'");

    $form_data = array(
        'di_no'=>$di_no,
        'bilty_date'=>$bilty_date,
        'item_id'=>$item_id,
        'brand_id'=>$brand_id,
        'wt_mt'=>$wt_mt,
        'destination_id'=>$destination_id,
        'consignor_id'=>$consignor_id,
        'from_id'=>$from_id,
        'inv_no'=>$inv_no,
        'xconsignee_id'=>$xconsignee_id,
        'vehicle_id'=>$vehicle_id,
        'driver_id'=>$driver_id,
        'owner_id'=>$owner_id,
		'mobile_no'=>$mobile_no,
        'remark'=>$remark,
        'comission'=>$comission,
		'comp_id' => $comp_id,
		'session_id' => $session_id
    );
// print_r($form_data); die;
    if($editid == 0){
        // INSERT
        $count = check_duplicate($connection,$tblname,"di_no='$di_no'");
        if($count == 0){
          dbRowInsert($connection,$tblname,$form_data);
            echo "<script>location='$pagename?action=1'</script>";
        } else {
            $duplicate = "ERROR: Duplicate Record...";
        }
    } else {
        // UPDATE
        dbRowUpdate($connection,$tblname,$form_data,"$tblpkey='$editid'");
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

	<title>X-PARTY :: CHAARUVI INFOTECH PVT. LTD.</title>

	<?php include("inc/top-files.php"); ?>
</head>

<body>
   
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
							<input type="text" name="xconsignee_name" id="xconsignee_name" class="form-control" placeholder="" required>
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
							<button class="btn btn-primary" onClick="saveconsignee();" tabindex="12"> Save</button>
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
                    <div class="box-content nopadding">
                        
                        <div class="tab-content padding tab-content-inline tab-content-bottom" id="main1">
                            
                      
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



                                            <h3><i class="fa fa-list"></i>X-Party Entry</h3>


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
                                                            <label for="textfield" class="control-label col-sm-4">Invoice No. </label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="inv_no" id="inv_no" placeholder="Enter Number" class="form-control"  value="<?php echo $inv_no; ?>">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="textfield" class="control-label col-sm-4">Bilty Date. </label>
                                                            <div class="col-sm-8">
                                                                <input type="date" name="bilty_date" id="bilty_date" placeholder="DD/MM/YYYY" class="form-control" value="<?php echo $bilty_date; ?>">
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
                                                   
                                                </div>
                                                <div class="row">
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
                                                      <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="textfield" class="control-label col-sm-4">Comission</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="comission" id="comission" placeholder="Enter Amount" class="form-control"  value="<?php echo $comission; ?>">
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
                                                                <select name="xconsignee_id" id="xconsignee_id" class='select2-me' style="width:100%;">
                                                                    <option value=""> Select </option>
                                                                    <?php $sql = mysqli_query($connection, "Select * from  m_x_consignee  order by xconsignee_id");
                                                                    while ($row = mysqli_fetch_array($sql)) { ?>

                                                                        <option value="<?php echo $row['xconsignee_id']; ?>"><?php echo $row['xconsignee_name']; ?></option>
                                                                    <?php } ?>

                                                                </select>
                                                                <script>
                                                                    document.getElementById('xconsignee_id').value = '<?php echo $xconsignee_id; ?>';
                                                                </script>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-sm-3">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">Destination <span class="badge shtcutbtn"><a class="shtcut" onClick="jQuery('#myModal7').modal('show');">+</a></span></label>
																	<div class="col-sm-8">

																		<select name="destination_id" id="destination_id" class='select2-me' style="width:100%;">
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
                                                                <input type="text" name="owner_id" id="owner_name1" placeholder="Text input" class="form-control" value="<?php echo $owner_name1; ?>" readonly>
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
                                                                <input type="text" name="mobile_no" id="mobile_no1" placeholder="Text input" class="form-control" value="<?php echo $mobile_no1; ?>">
                                                            </div>
                                                        </div>

                                                    </div>
                                                
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="textfield" class="control-label col-sm-4">Remark </label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="remark" id="remark" placeholder="Enter Remark" class="form-control" value="<?php echo $remark; ?>">
                                                            </div>
                                                        </div>

                                                    </div>
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

                                        <div class="box box-color box-bordered">
                                            <div class="box-title">
                                                <h3> <i class="fa fa-table"></i>
                                                    Recent X-party Details</h3>


                                                <a href="all-x-party-entry.php" class="btn btn-warning" style="float: right">Click Here For All Entry
                                                    <i class="fa fa-object-group"></i>
                                                </a> &nbsp;


                                                <!-- <a href="all-dispatch-entry.php" style="text-align: right" target="_blank">All Record</a> -->


                                                <!-- <a href="pdf/pdf_dispatch_entry.php" class="btn" style="float: right" target="_blank">Pdf
                                                    <i class="fa fa-file-pdf-o"></i>
                                                </a> &nbsp;
                                                <a href="excel/excel_dispatch_entry.php" class="btn btn-warning" style="float: right">Excel
                                                    <i class="fa fa-file-excel-o"></i>
                                                </a> -->

                                            </div>
                                            <div class="box-content nopadding">
                                                <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
                                                    <thead>
                                                        <tr>
                                                            <th>S.No</th>
                                                            <th>DI No.</th>
                                                            <th class='hidden-350'>Bilty Date</th>
                                                            <th>Consignor</th>
                                                            <th>Consignee</th>
                                                            <th class='hidden-1024'>Truck No.</th>
                                                            <th>Item</th>
                                                            <th>Weight/MT</th>
                                                            <th>Commision</th>
                                                            <th class='hidden-480'>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sn = 1;
														// echo ("SELECT * FROM $tblname WHERE consignor_id=$consignorid AND comp_id=$comp_id AND session_id=$session_id ORDER BY bilty_date DESC LIMIT 10");
                                                        $sql = mysqli_query($connection, "SELECT * FROM $tblname WHERE consignor_id=$consignorid AND comp_id=$comp_id AND session_id=$session_id ORDER BY bilty_date DESC LIMIT 10");
                                                        while ($row = mysqli_fetch_array($sql)) {
                                                            $consignor_name = $cmn->getvalfield($connection, "m_consignor", "consignor_name", "consignor_id={$row['consignor_id']}");
                                                            $consignee_name = $cmn->getvalfield($connection, "m_x_consignee", "xconsignee_name", "xconsignee_id={$row['xconsignee_id']}");
                                                            $vehicle_no = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id={$row['vehicle_id']}");
                                                            $item_name = $cmn->getvalfield($connection, "m_item", "item_name", "item_id={$row['item_id']}");
                                                          
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $sn++; ?></td>
                                                            <td><?php echo htmlspecialchars($row['di_no']); ?></td>
                                                            <td><?php echo dateformatindia($row['bilty_date']); ?></td>
                                                            <td><?php echo htmlspecialchars($consignor_name); ?></td>
                                                            <td class='hidden-350'><?php echo htmlspecialchars($consignee_name); ?></td>
                                                            <td class='hidden-1024'><?php echo htmlspecialchars($vehicle_no); ?></td>
                                                            <td><?php echo htmlspecialchars($item_name); ?></td>
                                                            <td><?php echo $row['wt_mt']; ?></td>
                                                            <td><?php echo $row['comission']; ?></td>
                                                            <td class='hidden-480'>
                                                                <!--<a href="pdf/pdf_xparty_printA4.php?di_id=<?php echo $row['di_id']; ?>" class="btn btn-warning" rel="tooltip" title="Builty A4" target="_blank">-->
                                                                <!--    <i class="fa fa-print"></i> A4-->
                                                                <!--</a>-->
                                                                <a href="pdf/pdf_xparty_printA5.php?di_id=<?php echo $row['di_id']; ?>" class="btn btn-info" rel="tooltip" title="Builty A5" style="margin-left:3px;" target="_blank">
                                                                    <i class="fa fa-print"></i> A5
                                                                </a>

                                                                <?php if ($user_type == 'admin') { ?>
                                                                    <a href="?editid=<?php echo $row['di_id']; ?>" class="btn btn-inverse" rel="tooltip" title="Edit">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                <?php } ?>

                                                                <?php if ($user_type == 'admin') { ?>
																	<button class="btn btn-danger" 
																			onclick="funDel('<?php echo $row['di_id']; ?>')" 
																			rel="tooltip" 
																			title="Delete">
																		<i class="fa fa-times"></i>
																	</button>
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
                     
                    </div>
				</div>
			</div>
		</div>
	</div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-3gJwYp4y1pA1fJx4g5ZqgNmvQ1WjU6BbXyrfGzB+q7E=" crossorigin="anonymous"></script>
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
		

				<script>
					function saveconsignee() {
    var consignee_name = document.getElementById('xconsignee_name').value;
    var mobile_no = document.getElementById('mobile_no').value;

    if (consignee_name == '') {
        alert('Consignee Name can not be blank!');
        document.getElementById('xconsignee_name').focus();
        return false;
    }

    jQuery.ajax({
        type: 'POST',
        url: 'ajax/ajax_savexconsignee.php',
        data: {
            xconsignee_name: consignee_name,
            mobile_no: mobile_no
        },
        success: function(data) {
            jQuery('#xconsignee_name').val('');
            jQuery('#mobile_no').val('');
            jQuery("#myModal1").modal('hide');
            jQuery('#xconsignee_id').html(data).trigger('change').trigger('select2:select');
        }
    });
}

				</script>
			

</body>



</html>