<?php
error_reporting(0);
include("adminsession.php");
include("function/account_function.php");
$tblname = "account_setting";
$tblpkey = "account_id";
$pagename = "account.php";
$modulename = "Account Settings";
$duplicate = '';
if (isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = "";
}
if (isset($_GET['editid'])) {
	$keyvalue = $_GET['editid'];
} else {
	$keyvalue = 0;
}
$privilege_id = $cmn->getvalfield($connection, "user_privilege", "count(privilege_id)", "menu_id='4' && submenu_id='6' && subcat_id=0  && user_id='$user_id'");
$sql = mysqli_query($connection, "select * from account_setting where consignorid=$consignorid && session_id=$session_id");
$row = mysqli_fetch_assoc($sql);
$account_id = $row['account_id'];

$cashopeningbal = $row['cashopeningbal'];
$bankopeningbal = $row['bankopeningbal'];
$open_bal_date = $row['open_bal_date'];
$office_opening_bal = $row['office_opening_bal'];
$office_open_bal_date = $row['office_open_bal_date'];

if (isset($_POST['submit'])) {

	$account_id = $_POST['account_id'];
	$cashopeningbal = $_POST['cashopeningbal'];
	$bankopeningbal = $_POST['bankopeningbal'];
	$open_bal_date = $_POST['open_bal_date'];

	$office_opening_bal = $_POST['office_opening_bal'];
	$office_open_bal_date = $_POST['office_open_bal_date'];

	if ($account_id == '') {
		// echo "'cashopeningbal'=>$cashopeningbal,'bankopeningbal'=>$bankopeningbal,'open_bal_date'=>$open_bal_date,'office_opening_bal'=>$office_opening_bal,'office_open_bal_date'=>$office_open_bal_date,'comp_id'=>$comp_id,'session_id'=>$session_id,'consignorid'=>$consignorid,'created_date'=>$currentdate"; 
		$form_data = array('cashopeningbal' => $cashopeningbal, 'bankopeningbal' => $bankopeningbal, 'open_bal_date' => $open_bal_date, 'office_opening_bal' => $office_opening_bal, 'office_open_bal_date' => $office_open_bal_date, 'comp_id' => $comp_id, 'session_id' => $session_id, 'consignorid' => $consignorid, 'created_date' => $currentdate, 'user_id' => $user_id);
		dbRowInsert($connection, $tblname, $form_data);
		echo "<script>location='$pagename?action=1'</script>";
	} else {

		// echo "update  account_setting set cashopeningbal = '$cashopeningbal', bankopeningbal = '$bankopeningbal',open_bal_date='$open_bal_date',office_opening_bal='$office_opening_bal',office_open_bal_date='$office_open_bal_date','session_id'=>$session_id,
		// consignorid='$consignorid',updated_date='$currentdate',
		// 	comp_id = '$comp_id' where account_id='$account_id'";die;
		$sql_update = "update  account_setting set cashopeningbal = '$cashopeningbal', bankopeningbal = '$bankopeningbal',open_bal_date='$open_bal_date',office_opening_bal='$office_opening_bal',office_open_bal_date='$office_open_bal_date',session_id='$session_id',
consignorid='$consignorid',updated_date='$currentdate',
	comp_id = '$comp_id' where account_id='$account_id'";

		mysqli_query($connection, $sql_update);
		$keyvalue = $account_id;
		// $cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'updated');
		echo "<script>location='account.php?action=2'</script>";
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

	<title>ACCOUNT :: CHAARUVI INFOTECH PVT. LTD.</title>

	<?php include("inc/top-files.php"); ?>
</head>

<body>
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
									<i class="fa fa-bars"></i>Account
								</h3>
							</div>
							<div class="box-content nopadding">
								<ul class="tabs tabs-inline tabs-top">
									<?php $subsn = 1;
									$sql1 = mysqli_query($connection, "select * from user_privilege where menu_id='4' && submenu_id!=0 && subcat_id=0 && user_id='$user_id'  order by submenu_id  asc");
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
									<!-- <li class='active'>
										<a id="account" data-toggle='tab'>
										<i class="fa fa-inbox"></i>Account Settings</a>
									</li>
								<li>
										<a id="other_exp" data-toggle='tab'>
											<i class="fa fa-tag"></i>Other Expense Entry</a>
									</li> -->
									<li>
										<a id="exreport" data-toggle='tab' style="background: #2563eb; color: #ffffff">
											<i class="fa fa-share"></i>Other Expense Report</a>
									</li>
									<!-- <li>
							<a id="other_inc" data-toggle='tab'>
							<i class="fa fa-tag"></i>Other Income Entry</a>
									</li> -->
									<li>
										<a id="increport" data-toggle='tab' style="background: #2563eb; color: #ffffff">
											<i class="fa fa-share"></i>Other Income Report</a>
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



														<h3><i class="fa fa-list"></i>Account Entry</h3>


													</div>

													<div class="box-content nopadding">

														<form action="#" method="POST" class='form-horizontal form-column form-bordered' enctype="multipart/form-data">
															<div class="row">
																<div class="col-sm-6">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">

																			Plant Opening Balance(Cash) <span style="color: red">*</span></label>
																		<div class="col-sm-8">
																			<input type="text" name="cashopeningbal" id="cashopeningbal" placeholder="Enter Number" class="form-control" required value="<?php echo $cashopeningbal; ?>">
																		</div>
																	</div>

																</div>

																<div class="col-sm-4" style="display:none;">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4"> Plant Opening Balance(Bank) </label>
																		<div class="col-sm-8">
																			<input type="text" name="bankopeningbal" id="bankopeningbal" placeholder="Enter Number" class="form-control" value="<?php echo $bankopeningbal; ?>">
																		</div>
																	</div>

																</div>

																<div class="col-sm-6">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Plant Opening Balance Date </label>
																		<div class="col-sm-8">
																			<input type="date" name="open_bal_date" id="open_bal_date" placeholder="Enter Number" class="form-control" required value="<?php echo $open_bal_date; ?>">
																		</div>
																	</div>

																</div>


															</div>

															<div class="row" style="display:none;">

																<div class="col-sm-4">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Office Opening Balance</label>
																		<div class="col-sm-8">
																			<input type="text" name="office_opening_bal" id="office_opening_bal" placeholder="Enter Number" class="form-control" value="<?php echo $office_opening_bal; ?>">

																		</div>
																	</div>

																</div>
																<div class="col-sm-4">
																	<div class="form-group">
																		<label for="textfield" class="control-label col-sm-4">Office Opening Balance Date :<span style="color: red">*</span></label>
																		<div class="col-sm-8">
																			<input type="date" name="office_open_bal_date" id="office_open_bal_date" placeholder="Enter Number" class="form-control" value="<?php echo $office_open_bal_date; ?>">

																		</div>
																	</div>
																</div>






															</div>

															<div class="row">




															</div>

															<div class="row">
																<div class="col-sm-12">
																	<div class="form-actions">
																		<center>
																			<input type="hidden" name="account_id" id="account_id" value="<?php echo $account_id; ?>">
																			<input type="submit" name="submit" id="submit" value="Save" class="btn btn-primary">
																			<a type="button" href="<?php echo $pagename; ?>" class="btn btn-red">Cancel</a>
																		</center>
																	</div>
																</div>
															</div>
														</form>
													</div>


												</div><br />
											</div>
										<?php } ?>




										</div>


								</div>
							</div>
						</div>
					</div>
				</div>





			</div>
		</div>
	</div>
	<script type="text/javascript" language="javascript">
		$(document).ready(function() { /// Wait till page is loaded
			$('#maintenance').click(function() {
				$('#main1').load('maintenance_entry.php #main', function() {
					jQuery('.select2-me').select2();

				});
			});
		}); //// End of Wait till page is loaded
	</script>
	<script type="text/javascript" language="javascript">
		$(document).ready(function() { /// Wait till page is loaded
			$('#account').click(function() {
				$('#main1').load('account.php #main1', function() {
					jQuery('.select2-me').select2();
					// jQuery("#advtable").html(data);

					/// can add another function here
				});
			});
		}); //// End of Wait till page is loaded
	</script>


	<script type="text/javascript" language="javascript">
		$(document).ready(function() { /// Wait till page is loaded
			$('#other_exp').click(function() {
				$('#main1').load('other_expense_entry.php #main', function() {
					jQuery('.select2-me').select2();

				});
			});
		}); //// End of Wait till page is loaded
	</script>
	<script type="text/javascript" language="javascript">
		$(document).ready(function() { /// Wait till page is loaded
			$('#other_inc').click(function() {
				$('#main1').load('other_income_entry.php #main', function() {
					jQuery('.select2-me').select2();

				});
			});
		}); //// End of Wait till page is loaded
	</script>


	<script type="text/javascript" language="javascript">
		$(document).ready(function() { /// Wait till page is loaded
			$('#exreport').click(function() {
				location = 'other_exp_report.php';
			});
		}); //// End of Wait till page is loaded
	</script>
	<script>
		$(document).ready(function() { /// Wait till page is loaded
			$('#increport').click(function() {
				location = 'other_inc_report.php';
			});
		}); //// End of Wait till page is loaded
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
	</script>
</body>



</html>