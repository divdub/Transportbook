<?php
error_reporting(0);
include("adminsession.php");
$pagename = "purchase_report.php";
$modulename = "Purchase Report";

$tblname = "purchaseentry";
$tblpkey = "purchaseid";
if ($_GET['action'] != '') {
	$action = $_GET['action'];
} else {
	$action = '';
}

$purchase_date = date('Y-m-d');

$cond = '';

if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
	$fromdate = addslashes(trim($_GET['fromdate']));
	$todate = addslashes(trim($_GET['todate']));
} else {
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
}

if (isset($_GET['supplier_id'])) {
	$supplier_id  = trim(addslashes($_GET['supplier_id']));
} else
	$supplier_id= '';

if (isset($_GET['bill_type'])) {
	$bill_type  = trim(addslashes($_GET['bill_type']));
} else
	$bill_type = '';

$crit = " ";
if ($fromdate != "" && $todate != "") {


	$crit .= " and  purchase_date   between '$fromdate' and '$todate'";
}

if ($supplier_id != '') {
	$crit .= " and supplier_id ='$supplier_id'";
}
if ($bill_type != '') {
	$crit .= " and bill_type ='$bill_type'";
}
if ($_GET['purchaseid'] != "") {

	
	mysqli_query($connection, "update purchase_entry  set is_complete=0  where is_complete=1 and purchaseid='$purchaseid");
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

	<title>Purchase:: CHAARUVI INFOTECH PVT. LTD.</title>

<?php include("inc/top-files.php"); ?>	
</head>

<body>

	<?php include("inc/model.php"); ?>
	
	<?php include("inc/top-header.php"); ?>
	
	
	<div class="container-fluid nav-hidden" id="content" >
		<?php include("inc/left-menu.php"); ?>
		
		
		
		<div id="main">
			<div class="container-fluid">
				
				<?php include("inc/breadcrumbs.php"); ?>
				
				
				<div class="row">
					<div class="col-sm-12">
						<div class="box box-bordered box-color satblue">
							<div class="box-title">
								<h3>
									<i class="fa fa-list"></i>Purchase Report
								  </h3>
							</div>
							<div class="box-content nopadding">
								<form action="#" method="GET" class='form-horizontal form-column form-bordered'>
									<div class="row">
										<div class="col-sm-2">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">From Date <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="date" name="fromdate" id="fromdate" placeholder="Text input" class="form-control" value="<?php echo $fromdate; ?>" required>
												</div>
											</div>
										
										</div>
										
										<div class="col-sm-2">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">To Date <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="date" name="todate" id="todate" placeholder="Text input" class="form-control" value="<?php echo $todate; ?>" required>
												</div>
											</div>
										
										</div>
										    
										
										  
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Supplier Name</label>
												<div class="col-sm-8">
												<select name="mechanic_id" id="mechanic_id" class='select2-me' style="width:100%;">
				<option value="">      Select  </option>
				<?php	$sql = mysqli_query($connection,"Select * from  mechanic_service_master  order by mechanic_id");
										  while($row= mysqli_fetch_array($sql)) { ?>
										  	
												<option value="<?php echo $row['mechanic_id']; ?>"><?php echo $row['mechanic_name']; ?></option>
								<?php } ?>

											</select>
			<script>document.getElementById('mechanic_id').value = '<?php echo $mechanic_id ; ?>';</script>

												</div>
											</div>
										
										</div>
										
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Bill type <span style="color: red">*</span></label>
												<div class="col-sm-8">
												<select name="head_id" id="head_id" class='select2-me' style="width:100%;">
				<option value="">      Select  </option>
					<option value="">      Invoice  </option>
						<option value="">      Challan  </option>

											</select>
			<script>document.getElementById('head_id').value = '<?php echo $head_id ; ?>';</script>
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
									<h3> <i class="fa fa-table"></i>
									Purchase List</h3>


									<a href="maintance-process.php" class="btn btn-warning" style="float: right">Click Hear For New Entry
										<i class="fa fa-object-group"></i>
									</a> &nbsp;





									<a href="pdf/pdf_purchese_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate;?>suppartyid=<?php echo $mechanic_id?>" class="btn" style="float: right" target="_blank">Pdf
										<i class="fa fa-file-pdf-o"></i>
									</a> &nbsp;
									<a href="excel/excel_purchese.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate;?>suppartyid=<?php echo $mechanic_id?>" class="btn btn-warning" style="float: right">Excel
										<i class="fa fa-file-excel-o"></i>
									</a>

								</div>
								<div class="box-content nopadding">
									<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
										<thead>
											<tr>
												<th>Sno</th>
											     <th> Date </th>
                                                 <th> Supplier Name </th>
											
												<th>Bill No. </th>
                                            <th> Bill Type </th>
											<th> Qty </th>
                                           <th>Remark</th>
                                       <th> Net Total</th>
                                        <th>User Name</th>  
										<th> Print</th>
										
											<th>Action</th>
											</tr>
										</thead>
										<tbody>

										<?php
										$slno = 1;
									
										$sel = "select * from purchaseentry where 1=1 $crit && compid='$compid' &&  sessionid='$sessionid' order by billno desc  ";
										$res = mysqli_query($connection, $sel);
										while ($row = mysqli_fetch_assoc($res)) {
											$supplier_name = $cmn->getvalfield($connection, "m_supplier", "supp_name", "supplier_id='$row[supplier_id]'");
											$total_amt = $cmn->getvalfield($connection, "purchasentry_detail", "sum(nettotal)", "purchaseid='$row[purchaseid]'");
											$itemid = $cmn->getvalfield($connection, "purchasentry_detail", "iteminv_id", "purchaseid='$row[purchaseid]'");
											$qty = $cmn->getvalfield($connection, "purchasentry_detail", "sum(qty)", "purchaseid='$row[purchaseid]'");
											$purchaseid=$row['purchaseid'];
											$bill_type=$row['bill_type'];
											$user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
											$iteminv_category_id = $cmn->getvalfield($connection, "m_iteminv", "iteminv_category_id", "iteminv_id='$itemid'");
										?>
											<tr>
												<td><?php echo $slno; ?></td>
												<td><?php echo dateformatindia($row['purchase_date']); ?></td>

												<td><?php echo $supplier_name; ?></td>
												<td><?php echo ucfirst($row['billno']); ?></td>
												
												<td><?php echo ucfirst($row['bill_type']); ?></td>
												<td><?php echo $qty; ?></td>
												<td><?php echo ucfirst($row['remark']); ?></td>
												<td><?php echo number_format($total_amt,2); ?>
												<td><?php echo $user_name; ?></td>
												<td><a class="btn btn-warning" href="pdf/pdf_print_purchese_report.php?purchaseid=<?php echo $row['purchaseid'];?>" target="_blank">Print</a></td>
													<td class='hidden-480'>

														<a href="purchase-entry.php?purchaseid=<?php echo $row['purchaseid']; ?>" class="btn btn-inverse" rel="tooltip" title="Edit">
															<i class="fa fa-edit"></i>
														</a>
														<a href="<?php echo $pagename ?>" onClick="fundelupper(<?php echo $row['purchaseid']; ?>)" class="btn btn-danger" rel="tooltip" title="Delete">
															<i class="fa fa-times"></i>
														</a>
													</td>
												</tr>

											<?php } ?>
										</tbody>
									</table>
			</div>
		</div>
						</div>
					</div>
				</div>
				
				
				
				
				
			</div>
		</div>
	</div>
		<script>
		function fundelupper(id) {
			alert(id);   
			tblname = '<?php echo $tblname; ?>';
			tblpkey = '<?php echo $tblpkey; ?>';
			pagename = '<?php echo $pagename; ?>';
			modulename = '<?php echo $modulename; ?>';
			alert(tblpkey); 
			if (confirm("Are you sure! You want to delete this record.")) {
				$.ajax({
					type: 'POST',
					url: 'ajax/deletepurchaseupper.php',
					data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' + modulename,
					dataType: 'html',
					success: function(data) {
				alert(data);
						// alert('Data Deleted Successfully');
						location = pagename + '?action=10';
					}

				}); //ajax close
			} //confirm close
		} //fun close

		

	
	</script>
</body>



</html>
