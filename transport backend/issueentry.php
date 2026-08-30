<?php
error_reporting(0);
include("adminsession.php");
include("function/itemissue_function.php");
$tblname = "issueentry";
$tblpkey = "issueid";
$pagename = "issueentry.php";
$modulename = "Issue  Entry";
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
$privilege_id = $cmn->getvalfield($connection, "user_privilege", "count(privilege_id)", "menu_id='5' && submenu_id='9' && subcat_id=0  && user_id='$user_id'");
if (isset($_GET['editid']) != "") {
	$keyvalue = test_input($_GET['editid']);
	$btn_name = "Update";
	
	$sqledit = "SELECT * from $tblname where $tblpkey = $keyvalue";
	$rowedit = mysqli_fetch_array(mysqli_query($connection,$sqledit));
	$issuno  =  $rowedit['issuno'];
	$issudate  =  $rowedit['issudate'];
	$vehicle_id  =  $rowedit['vehicle_id'];
	$remark  =  $rowedit['remark'];	
	$driver_id =  $rowedit['driver_id'];	
	$meterread =  $rowedit['meterread'];
} else {
		$issudate=date('Y-m-d'); 
   	$issuno  = $cmn->getcode($connection,"issueentry","issuno","1=1");		 
	$vehicle_id  = '';	 
	$remark  = '';
	 $driver_id= '';
	 $meterread= '';
}
if (isset($_POST['submit'])) {
	$issueid=trim(addslashes($_POST['issueid']));
	$issuno = trim(addslashes($_POST['issuno']));
	$issudate = trim(addslashes($_POST['issudate']));
	$vehicle_id = trim(addslashes($_POST['vehicle_id']));
	$remark = trim(addslashes($_POST['remark']));
	$driver_id=  trim(addslashes($_POST['driver_id']));
	$meterread = $_POST['meterread'];
	

if ($issueid == 0) {
	mysqli_query($connection,"insert into issueentry set issuno = '$issuno', issudate = '$issudate',driver_id = '$driver_id', vehicle_id = '$vehicle_id',
        remark='$remark',meterread='$meterread',createdby='$createdby', ipaddress='$ipaddress',compid='$compid',sessionid='$sessionid',createdate='$createdate',user_id='$user_id'");
 
	   $action = 1;
	   $process = "insert";
	   $keyvalue = mysqli_insert_id($connection);
	   mysqli_query($connection,"update issueentrydetail set issueid='$keyvalue' where issueid='0'");
	} else {
    mysqli_query($connection,"update  issueentry set issuno = '$issuno', issudate = '$issudate',driver_id = '$driver_id', vehicle_id = '$vehicle_id',
	remark='$remark',meterread='$meterread',createdby='$createdby', ipaddress='$ipaddress',sessionid='$sessionid',createdate='$createdate' WHERE issueid = '$keyvalue'");
 
	   $action = 2;
	   $process = "updated";
	}

	echo "<script>location='$pagename?action=$action'</script>";
		
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

	<title>ITEM ISSUE :: CHAARUVI INFOTECH PVT. LTD.</title>

	<?php include("inc/top-files.php"); ?>
</head>

<body onload="getrecord()">
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
									<i class="fa fa-bars"></i>Item Issue Entry
								</h3>
							</div>
							<div class="box-content nopadding">
								<ul class="tabs tabs-inline tabs-top">
							
								
										<li class='active'>
											<a id="item_issue" data-toggle='tab'>
									<i class="fa fa-inbox"></i>Item Issue Entry</a>
										</li>
									
								
									<li>
										<a id="itemissuereport" data-toggle='tab' style="background: #2563eb; color: #ffffff">
											<i class="fa fa-share"></i>Item Issue  Report</a>
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



														<h3><i class="fa fa-list"></i> Item Issue Entry</h3>


													</div>

													<div class="box-content nopadding">

													<form action="#" method="POST" class='form-horizontal form-column form-bordered' enctype="multipart/form-data">
								                      	<div class="row">
															<div class="col-sm-3">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">Truck No <span style="color: red">*</span></label>
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
	<div class="col-sm-3">
																<div class="form-group" >
																	<label for="textfield" class="control-label col-sm-4" >Driver Name </label>
																	<div class="col-sm-8" >
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
																	<label for="textfield" class="control-label col-sm-4"> 	Issue No. <span style="color: red">*</span></label>
																	<div class="col-sm-8">
																		<input type="text" name="issuno" id="issuno" value="<?php echo $issuno; ?>" placeholder="Text input" class="form-control">
																	</div>
																</div>

															</div>

															
															
															
															
															<div class="col-sm-3">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4"> Date<span style="color: red">*</span></label>
																	<div class="col-sm-8">
																	   <input type="date" name="issudate" id="issudate" value="<?php echo $issudate; ?>" placeholder="Text input" class="form-control">
																		
																	</div>
																</div>

															</div>


														
														
													
                                                    	
															</div>
															<div class="row">
															    
															    	<div class="col-sm-3">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">Meter Reading<span style="color: red">*</span></label>
																	<div class="col-sm-8">
																		
																	<input type="text" name="meterread" id="meterread" value="<?php echo $meterread; ?>" placeholder="Text input" class="form-control">
																	</div>
																</div>

															</div> 
															
															

															<div class="col-sm-3">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">Remark</label>
																	<div class="col-sm-8">
																		<input type="text" name="remark" id="remark" value="<?php echo $remark; ?>" placeholder="Text input" class="form-control">
																	</div>
																</div>

															</div>

                                             <td><input type="hidden" name="issueid" id="issueid" class="form-control text-red"  value="<?php echo $keyvalue;?>"  style="font-weight:bold;"  autocomplete="off"></td>
														


														

														</div>
															<pre style="font-weight: bold; color: red"> <h5 style="color:#FF0000" id="stockin"></h5></pre>


															<div>
																<table class="table">
																   
																	<thead style="position: sticky;  top: 0;">

																		<tr>

																			<th>Category</th>
																			<th>ITEM</th>
																			<th>UOM</th>
																			<th>Qty</th>
																			<th>Issue Category</th>
																			<th>Issue Remark</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																			<td>
																			    
																			        <select id="issue_cate" name='issue_cate'  class="select2-me"  style="width:100%;" onChange="showItems(this.value)" >
                                 	<option value="">--</option>
                                 	<option value="New Item">New Item</option>
                                    <option value="Repaired">Repairable Item</option>
                                      <option value="Exchange">Exchange Item</option>
                                 </select>
								
																			</td>
																			<td><select name="iteminv_id" id="iteminv_id" class="select2-me" style="width:100%;" onChange="getDetails();">
																					<option value="">-Select-</option>
																					<?php
																					$sql = mysqli_query($connection, "select * from m_iteminv");
																					while ($row = mysqli_fetch_assoc($sql)) {

																					?>
																						<option value="<?php echo $row['iteminv_id']; ?>"><?php echo $row['item_name']; ?></option>
																					<?php
																					}
																					?>
																				</select>
																				<script>
																					document.getElementById('iteminv_id').value = '<?php echo $iteminv_id; ?>';
																				</script>
																			</td>

																			<td><input class="form-control" type="text"  id="unitname" value=""  ></td>
																			 <input type="hidden" id="iteminv_category_id">
																			<td><input type="text" name="qty" id="qty" class="form-control" placeholder=" " value=""></td>
																			<td><select id="is_rep" class="form-control">
                                 	<option value="">--</option>
                                 		<option value="For New Vehicle"> For New Vehicle</option>
                                 	<option value="Scrap">Scrap</option>
                                    <option value="Repaired"Repaired>Repairable</option>
                                      <option value="Exchange">Exchange</option>
                                 </select></td>
                                 
                                  <td id="new1" style="display:none;">
                                 <select id="returnitem_id" class="select2-me" style="width:250px;">
                                <option value="" >--Choose Item--</option>
                                <?php
                                //where cat_id not in (5,8)
                               $resprod = mysqli_query($connection,"select * from purchasentry_detail  order by iteminv_id");
                                while($rowprod = mysqli_fetch_array($resprod))
                                {
											
												$item_name = $cmn->getvalfield($connection, "m_iteminv","item_name", "iteminv_id='$rowprod[iteminv_id]' and iteminv_category_id!='5'");
												$itemcatid = $cmn->getvalfield($connection, "m_iteminv", "iteminv_category_id", "iteminv_id='$rowprod[iteminv_id]'");
												$item_category_name = $cmn->getvalfield($connection, "m_iteminv_category", "category_name", "iteminv_category_id='$iteminv_category_id' and iteminv_category_id!='5'");
											
												if($itemcatid!='5'){ ?>
                                <option value="<?php echo $rowprod['purdetail_id']; ?>"><?php echo $item_name; ?>/<?php echo $rowprod['purdetail_id']; ?>/<?php echo $item_category_name; ?></option>
                                <?php
                                }}
                                ?>
                                </select>
                                 </td>
																			
																			<td><input type="text" name="remark1" id="remark1" class="form-control" placeholder=" " value="<?php echo $remark1; ?>"></td>
																			<td><a class="btn btn-primary" style="width: 50px;" tabindex="27" onclick="addlist();">Add</a></td>
																			
 <td style="display:none;"><input  type="text" id="stock" value=""  ></td>

																	</tbody>
																</table>
																<br>
															</div>


													</div>
													
													<div class="box box-color box-bordered red">
												<div class="box-title">
													<h3> <i class="fa fa-table"></i>
														Recent Item Issue Details

													</h3>


												

												</div>
												<div class="row-fluid">
   	<div class="box-content nopadding" id="showissuerecord">
   </div>
												<div class="row">
										<div class="col-sm-12">
											<div class="form-actions">
												<center>
		 									
				<input type="submit" name="submit" id="submit" value="Save" class="btn btn-primary">
						<a type="button" href="<?php echo $pagename; ?>"class="btn btn-red">Cancel</a>
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
			$('#item_issue').click(function() {
				$('#main1').load('issueentry.php #main', function() {
					jQuery('.select2-me').select2();

				});
			});
		}); //// End of Wait till page is loaded
	</script>
	<script type="text/javascript" language="javascript">
		$(document).ready(function() { /// Wait till page is loaded
			$('#sale').click(function() {
				$('#main1').load('sale_entry.php #main1', function() {
					jQuery('.select2-me').select2();
					// jQuery("#advtable").html(data);

					/// can add another function here
				});
			});
		}); //// End of Wait till page is loaded
	</script>
	<script type="text/javascript" language="javascript">
		$(document).ready(function() { /// Wait till page is loaded
			$('#itemissuereport').click(function() {
				location = 'issueentry_detail.php';
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