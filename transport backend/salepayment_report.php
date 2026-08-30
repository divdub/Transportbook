<?php
error_reporting(0);
include("adminsession.php");
$pagename = "salepayment_report.php";
$modulename = "Payment Report";

$tblname = "inv_payment";
$tblpkey = "paymentid";
if ($_GET['action'] != '') {
	$action = $_GET['action'];
} else {
	$action = '';
}

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


	$crit .= " and  paymentdate   between '$fromdate' and '$todate'";
}

if ($customer_id != '') {
	$crit .= " and customer_id ='$customer_id'";
}
if ($bill_type != '') {
	$crit .= " and bill_type ='$bill_type'";
}
if ($_GET['saleid'] != "") {

	// echo "update purchase_entry  set is_complete=0  where is_complete=1 and saleid='$saleid";
	mysqli_query($connection, "update sale_entry  set is_complete=0  where is_complete=1 and saleid='$saleid");
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
												<label for="textfield" class="control-label col-sm-4">Customer Name</label>
												<div class="col-sm-8">
												<select name="customer_id" id="customer_id" class="select2-me" style="width:100%;" onChange="getprebal();">
                                           		<option value="">-Select-</option>
																		 <?php 
																		 $sql = mysqli_query($connection, "select * from  m_customer  order by cust_name");
                                       while ($row = mysqli_fetch_array($sql)) {

                                       ?>
                                          <option value="<?php echo $row['customer_id']; ?>"><?php echo $row['cust_name']; ?></option>

                                       <?php } ?>
                                           </select>
                                       <script>
                                          document.getElementById('customer_id').value = '<?php echo $customer_id; ?>';
                                       </script>
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


									<a href="sale_entry.php" class="btn btn-warning" style="float: right">Click Hear For New Entry
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
									<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
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
									
										$sel = "select * from inv_payment where  type='sale' && iscomp=1 && compid='$compid' && sessionid='$sessionid'order by paymentid desc";
										$res = mysqli_query($connection, $sel);
										while ($row = mysqli_fetch_assoc($res)) {
										$user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
											$bill_type=$row['bill_type'];
											
											$iteminv_category_id = $cmn->getvalfield($connection, "m_iteminv", "iteminv_category_id", "iteminv_id='$itemid'");
										?>
											<tr>
												<td><?php echo $slno++; ?></td>
							<td> <?php echo $cmn->getvalfield($connection,"m_customer","cust_name","customer_id='$row[customer_id]'"); ?></td>
                                <td><?php echo dateformatindia($row['paymentdate']); ?></td>  
						<td style="text-align:right;"><?php echo number_format($row['paid_amt'],2); ?></td>
						<td style="text-align:right;"><?php echo number_format($row['discamt'],2); ?></td>
						<td><?php echo $row['pay_type']; ?></td>  
						<td><?php echo $row['narration']; ?></td>  
						<td><?php echo $user_name; ?></td>
						             
                           <td><a href="pdf_puchase_payment.php?paymentid=<?php echo $row['paymentid'];?>" target="_blank" class="btn btn-success">Print </a>

                                   </td>          
                          
													<td class='hidden-480'>

															<input type="button" class="btn btn-primary" name="add_data_list" id="add_data_list" onClick="editselected('<?php echo $row['paymentid']; ?>','<?php echo $row['paymentdate']; ?>','<?php echo $row['customer_id']; ?>','<?php echo $row['paid_amt']; ?>','<?php echo $row['narration']; ?>','<?php echo $row['discamt']; ?>','<?php echo $row['pay_type']; ?>');" value="E"> &nbsp;
														<!--<a href="<?php echo $pagename ?>" onClick="fundelupper(<?php echo $row['paymentid']; ?>)" class="btn btn-danger" rel="tooltip" title="Delete">-->
														<!--	<i class="fa fa-times"></i>-->
														<!--</a>-->
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
						<th>Customer Name</th>
						<th>Paid Amount</th>

					</tr>
					<tr>
						<td>  <select  id="s_customer_id" class="formcent select2-me"  style="width:250px;"  onChange="getprebal();" >
                                    <!--<select data-placeholder="Choose a Suppliers..." name="sup_id" id="sup_id" tabindex="2" style="width:200px"  class="formcent select2-me" required>-->
                                       <option value="">Select </option>
                                       <?php
                                       $sql = mysqli_query($connection, "select * from  m_customer  order by cust_name");
                                       while ($row = mysqli_fetch_array($sql)) {

                                       ?>
                                          <option value="<?php echo $row['customer_id']; ?>"><?php echo $row['cust_name']; ?></option>

                                       <?php } ?>
                                       <script>
                                          document.getElementById('customer_id').value = '<?php echo $customer_id ; ?>';
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
		<script>
		
		
		 function editselected(paymentid,paymentdate,customer_id,paid_amt,narration,disc,pay_type){

	jQuery('#myModal_product').modal('show');
	jQuery('#s_paymentid').val(paymentid);

	jQuery('#s_discamt').val(disc);
	jQuery('#s_paymentdate').val(paymentdate);
	jQuery('#s_paid_amt').val(paid_amt);
	jQuery('#s_narration').val(narration);

   $("#s_customer_id").select2().select2('val', customer_id);	

	jQuery('#s_paymentid').val(paymentid);

   $("#s_pay_type").select2().select2('val', pay_type);	

}
		
		
		function fundelupper(id) {
		   
			tblname = '<?php echo $tblname; ?>';
			tblpkey = '<?php echo $tblpkey; ?>';
			pagename = '<?php echo $pagename; ?>';
			modulename = '<?php echo $modulename; ?>';
		
			if (confirm("Are you sure! You want to delete this record.")) {
				$.ajax({
					type: 'POST',
					url: 'ajax/deletepurchaseupper.php',
					data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' + modulename,
					dataType: 'html',
					success: function(data) {
			
						// alert('Data Deleted Successfully');
						location.reload();
					}

				}); //ajax close
			} //confirm close
		} //fun close

		
  
function updatesale() {
		
		var customer_id = document.getElementById('s_customer_id').value.trim();
		var paid_amt = document.getElementById('s_paid_amt').value.trim();
		var pay_type = document.getElementById('s_pay_type').value.trim();

		var disc = document.getElementById('s_discamt').value.trim();
		var narration = document.getElementById('s_narration').value.trim();
		var paymentdate = document.getElementById('s_paymentdate').value.trim();
		var paymentid= document.getElementById('s_paymentid').value.trim();
	
		
		if(paymentdate=='') {
			  alert("Please Select Date");
			  return false;
		}
		
		
		if(customer_id=='') {
			  alert("Please Select Customer");
			  return false;
		}
		
		
		if(paid_amt=='' || paid_amt=='0') {
			  alert("Paid Amount cant be Balnk/Zero");
			  return false;
		}
		
		
		
		   jQuery.ajax({
				   type: 'POST',
				   url: 'ajaxsale/savesalepur.php',
				   data: 'paymentdate='+paymentdate+'&paid_amt='+paid_amt+'&disc='+disc+'&narration='+narration+'&pay_type='+pay_type+'&customer_id='+customer_id+'&paymentid='+paymentid,
				 //   data: 'paymentdate='+paymentdate+'&paid_amt='+paid_amt+'&narration='+narration+'&customer_id='+customer_id+'&paymentid='+paymentid,
				   dataType: 'html',
				   success: function(data){		
					
				   jQuery('#s_customer_id').val('');
				   jQuery('#s_pay_type').val('');
				   jQuery('#s_paid_amt').val('');
				   jQuery('#s_narration').val('');
				   jQuery('#s_paymentdate').val('');
				   jQuery('#s_paymentid').val('');
				   jQuery('#myModal_product').modal('hide');
				   	 
			
						location.reload();
						  }				
					  });//ajax close
			
		
		
		}
	
	</script>
</body>



</html>
