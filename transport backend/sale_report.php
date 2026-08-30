<?php
error_reporting(0);
include("adminsession.php");
include("function/sale_function.php");
$tblname = "inv_saleentry";
$tblpkey = "sale_id";
$pagename = "sale_report.php";
$modulename = "Sale Details";
$crit = '';
if ($_GET['action'] != '') {
	$action = $_GET['action'];
} else {
	$action = '';
}

$sale_date = date('Y-m-d');

$cond = '';

if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
	$fromdate = addslashes(trim($_GET['fromdate']));
	$todate = addslashes(trim($_GET['todate']));
} else {
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
}

if (isset($_GET['customer_id'])) {
	$customer_id  = trim(addslashes($_GET['customer_id']));
} else
	$customer_id = '';

if (isset($_GET['bill_type'])) {
	$bill_type  = trim(addslashes($_GET['bill_type']));
} else
	$bill_type = '';

$crit = " ";
if ($fromdate != "" && $todate != "") {


	$crit .= " and  sale_date   between '$fromdate' and '$todate'";
}

if ($customer_id != '') {
	$crit .= " and customer_id ='$customer_id'";
}
if ($bill_type != '') {
	$crit .= " and bill_type ='$bill_type'";
}
if ($_GET['saleid'] != "") {

	// echo "update sale_entry  set is_complete=0  where is_complete=1 and saleid='$saleid";
	mysqli_query($connection, "update inv_saleentry  set is_complete=0  where is_complete=1 and saleid='$saleid");
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

	<title> SALE:: CHAARUVI INFOTECH PVT. LTD.</title>

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
									<i class="fa fa-list"></i>Sale Report
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
									Sale List</h3>


									<a href="sale_entry.php" class="btn btn-warning" style="float: right">Click Hear For New Entry
										<i class="fa fa-object-group"></i>
									</a> &nbsp;





									<a href="pdf/pdf_sale_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate;?>&suppartyid=<?php echo $mechanic_id?>" class="btn" style="float: right" target="_blank">Pdf
										<i class="fa fa-file-pdf-o"></i>
									</a> &nbsp;
									<a href="excel/excel_sale_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate;?>&suppartyid=<?php echo $mechanic_id?>" class="btn btn-warning" style="float: right">Excel
										<i class="fa fa-file-excel-o"></i>
									</a>

								</div>
								<div class="box-content nopadding">
									<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
										<thead>
											<tr>
													<th>Sno</th>
											           <th> Date </th>
                                                <th> Customer Name </th>
											
                                            <th> Bill Type </th>
										
                                        <th>Remark</th>
                                       <th> Net Total</th>

											<th>User Name</th>  
											<th>Print</th>
											<th>Action</th>
											</tr>
										</thead>
										<tbody>

											<?php
												$slno = 1;
										 
										$sel = "select * from inv_saleentry where 1=1 $crit && compid='$compid' && sessionid='$sessionid'";
										$res = mysqli_query($connection, $sel);
										while ($row = mysqli_fetch_assoc($res)) {
										    
											$customer_name = $cmn->getvalfield($connection, "m_customer", "cust_name", "customer_id='$row[customer_id]'");
											$total_amt = $cmn->getvalfield($connection, "inv_saleentrydetail", "sum(grandtotal)", "saleid='$row[saleid]'");
											$iteminv_id = $cmn->getvalfield($connection, "inv_saleentrydetail", "iteminv_id", "saleid='$row[saleid]'");
											$qty = $cmn->getvalfield($connection, "inv_saleentrydetail", "qty", "saleid='$row[saleid]'");
											$saleid=$row['saleid'];
										$user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");

											$bill_type=$row['bill_type'];
											$itemcatid = $cmn->getvalfield($connection, "m_iteminv", "iteminv_category_id", "iteminv_id ='$iteminv_id'");
											?>
												<tr>
												<td><?php echo $slno; ?></td>
												<td><?php echo dateformatindia($row['sale_date']); ?></td>

												<td><?php echo $customer_name; ?></td>

												
												<td><?php echo ucfirst($row['bill_type']); ?></td>
												<!-- <td><?php echo $qty; ?></td> -->
												<!-- <td><?php echo $rate; ?></td> -->
												<td><?php echo ucfirst($row['remark']); ?></td>
												<td><?php echo number_format($total_amt,2); ?></td>
												<td><?php echo $user_name; ?></td>

													<td><a class="btn btn-warning" href="pdf/pdf_print_sale_report.php?saleid=<?php echo $row['saleid'];?>" target="_blank">Print</a></td>
													<td class='hidden-480'>

														<a href="sale_entry.php?saleid=<?php echo $row['saleid']; ?>"  class="btn btn-inverse" rel="tooltip" title="Edit">
															<i class="fa fa-edit"></i>
														</a>
														<a href="<?php echo $pagename ?>" onClick="funDel(<?php echo $row['saleid']; ?>)" class="btn btn-danger" rel="tooltip" title="Delete">
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
	
</body>



</html>
