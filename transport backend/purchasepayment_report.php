<?php
error_reporting(0);
include("adminsession.php");
$pagename = "purchase_report.php";
$modulename = "Purchase Report";
include("function/purchase_function.php");
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

	<title> PAYMENT:: CHAARUVI INFOTECH PVT. LTD.</title>

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
									<i class="fa fa-list"></i>Payment Report
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
									Payment List</h3>


									<a href="maintance-process.php" class="btn btn-warning" style="float: right">Click Hear For New Entry
										<i class="fa fa-object-group"></i>
									</a> &nbsp;





									<a href="pdf/pdf_service.php" class="btn" style="float: right" target="_blank">Pdf
										<i class="fa fa-file-pdf-o"></i>
									</a> &nbsp;
									<a href="excel/excel_service.php" class="btn btn-warning" style="float: right">Excel
										<i class="fa fa-file-excel-o"></i>
									</a>

								</div>
								<div class="box-content nopadding">
									<table class="table table-nomargin table-striped table-bordered dataTable dataTable-colvis">
										<thead>
											<tr>
											   <td>Sn</td>
                     	<td>Customer</td>
                     	<td>Payment Date</td>
                        <td>Paid Amount</td>
						<td >Disc Amount</td>
                        <td >Payment Mode</td> 
                        <td >Narration</td> 
						<th>User Name</th>
                        <td >Print</td>
                        <td >Action</td>

											</tr>
										</thead>
										<tbody>

										<?php
										$slno = 1;
									
										$sel = "select * from inv_payment where  type='purchase' && iscomp=1 && compid='$compid' && sessionid='$sessionid'order by paymentid desc";
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
												<td><?php echo $slno++; ?></td>
							<td> <?php echo $cmn->getvalfield($connection,"m_supplier","supp_name","supplier_id='$row[supplier_id]'"); ?></td>
                              <td><?php echo dateformatindia($row['paymentdate']); ?></td>  
						<td style="text-align:right;"><?php echo number_format($row['paid_amt'],2); ?></td>
						<td style="text-align:right;"><?php echo number_format($row['discamt'],2); ?></td>
						<td><?php echo $row['pay_type']; ?></td>  
						<td><?php echo $row['narration']; ?></td>  
						             <td><?php echo $user_name; ?></td>
                           <td><a href="pdf_puchase_payment.php?paymentid=<?php echo $row['paymentid'];?>" target="_blank" class="btn btn-success">Print </a>

                                   </td>          
                          
													<td class='hidden-480'>
                                 <input type="button" class="btn btn-primary" name="add_data_list" id="add_data_list" onClick="editselected('<?php echo $row['paymentid']; ?>','<?php echo $row['paymentdate']; ?>','<?php echo $row['supplier_id']; ?>','<?php echo $row['paid_amt']; ?>','<?php echo $row['narration']; ?>','<?php echo $row['discamt']; ?>','<?php echo $row['pay_type']; ?>');" value="E"> &nbsp;
														<!--<a href="purchase-entry.php?purchaseid=<?php echo $row['purchaseid']; ?>" class="btn btn-inverse" rel="tooltip" title="Edit">-->
														<!--	<i class="fa fa-edit"></i>-->
														<!--</a>-->
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
	
	
	
												 <div id="myModal_product" class="modal fade" role="dialog">
            <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 ><strong>Update Entry</strong></h4>
                    </div>

                    <div class="modal-body">
                        <table class="table table-bordered table-condensed">
                                   <tr>
						<th>Supplier Name</th>
						<th>Paid Amount</th>

					</tr>
					<tr>
						<td>  <select data-placeholder="Choose a Suppliers..." id="s_sup_id" class="formcent select2-me" tabindex="2" style="width:250px;"  onChange="getprebal();" >
                                    <!--<select data-placeholder="Choose a Suppliers..." name="sup_id" id="sup_id" tabindex="2" style="width:200px"  class="formcent select2-me" required>-->
                                       <option value="">Select </option>
                                       <?php
                                       $sql = mysqli_query($connection, "select * from  m_supplier  order by supp_name");
                                       while ($row = mysqli_fetch_array($sql)) {

                                       ?>
                                          <option value="<?php echo $row['supplier_id']; ?>"><?php echo $row['supp_name']; ?></option>

                                       <?php } ?>
                                       <script>
                                          document.getElementById('supplier_id').value = '<?php echo $sup_id ; ?>';
                                       </script>
						</td>
						<td>
						<input type="text" id="s_paid_amt" class="form-control"  value=""  style="font-weight:bold; " autocomplete="off"  >   
					
					</td>				
					</tr>

					<tr>
						<th>Disc Amount</th>
						<th>Narration</th>
					</tr>
					<tr>
						<td><input class="form-control" type="text" id="s_discamt" value="" placeholder='Disc Amt'></td>
						<td>
						<input class="form-control" type="text" id="s_narration" value="" placeholder='Remark'>
						</td>

					</tr>
					<tr> 
			<th>Payment Date</th>
			 <th>Payment Mode</th> 
			 <th></th>            
          
            </tr>
            <tr>
				<td><input type="date" id="s_paymentdate" class="form-control" value=""  data-mask > </td>
				
		
                <td> 
                  <!-- <input type="text" id="s_pay_type" class="form-control" value="" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > </td> -->
              <select data-placeholder="Choose Payment Type..." id="s_pay_type" class="formcent select2-me" tabindex="4" style="width:180px;">
                                       <option value="">Select</option>
                                              <option value="NEFT/Net Banking">NEFT/Net Banking</option>

                                       <option value="UPI">UPI</option>
                                       <option value="Cash">Cash</option>
                             
                                    </select>
                                    <script>
                                       document.getElementById('bill_type').value ='<?php echo $bill_type; ?>';
                                    </script> 
	
				 </td>					    
									             
            </tr>
					




                        </table>
                    </div>
                    <div class="modal-footer">
					<button class="btn btn-primary" name="s_save" id="s_save" onClick="updatesale();">Save</button>
               <button data-dismiss="modal" class="btn btn-danger">Close</button>
			   <input type="hidden" id="s_paymentid" value="" >
			   
                    </div>
                </div>
            <!-- /.modal-dialog -->
         </div>
      </div>
   </div>  
  
</body>



</html>
