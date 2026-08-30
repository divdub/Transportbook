<?php 
error_reporting(0);
include("adminsession.php");
include("function/purchase_function.php");
$tblname = "inv_payment";
$tblpkey = "payment_id";
$pagename = "paysale_entry.php";
$modulename = "Sale Payment";
$tblname = "payment";
$tblpkey = "paymentid";

$paymentdate = date('Y-m-d');
if(isset($_GET['action']))
{
$action = addslashes(trim($_GET['action']));
}
else
{
	$action = "";
}
if(isset($_GET['paymentid']))
$keyvalue = $_GET['paymentid'];
else
$keyvalue = 0;

if(isset($_POST['save'])) {

	$paymentdate = $_POST['paymentdate'];	
//   echo "update payment set iscomp=1 where type='purchase' && iscomp=0";
	mysqli_query($connection,"update inv_payment set iscomp=1 where type='sale' && iscomp=0 && compid='$compid' && sessionid='$sessionid'");	
	echo "<script>window.location='paypurchase_entry.php?action=1'</script>";
   
}



?>

	<body onload="showsalepay();">	
	
		<div class="tab-pane active" id="main" style="margin-left:0">
				<div class="row">
				<div class="col-sm-12" id="danger">
           
				</div>
				<div class="col-sm-12" id="success">
           
				</div>
					<div class="col-sm-12">
						
						<div class="box box-bordered box-color">
							<div class="box-title">
								
<h3><i class="fa fa-list"></i> Payment  Entry</h3>
								
		</div>
							<div class="box-content nopadding" >
								<form action="#" method="POST" class='form-horizontal form-column form-bordered'>
								   	<div class="row">
															<div class="col-sm-3">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">Date <span style="color: red">*</span></label>
																	<div class="col-sm-8">
	                                                              <input type="date" name="paymentdate" id="paymentdate" value="<?php echo $paymentdate; ?>" placeholder="Text input" class="form-control" readonly>
<input type="hidden" name="purchaseid" id="purchaseid"  style="width:30px;"  value="<?php echo $purchaseid; ?>" autofocus autocomplete="off" />
																	</div>
																</div>

															</div>
	</div>
														
															<pre style="font-weight: bold; color: red"><h5 style="color:#FF0000" id="prebal"></h5></pre>
															<div>
															     
																<table class="table">
																	<thead style="position: sticky;  top: 0;">

																		<tr>

																			<th>Customer Name</th>
																			<th>Paid Amount</th>
																			<th>Disc(Rs.)</th>
																			<th>Payment Mode</th>
																			<th>Narration</th>
																			
																		
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																			<td>
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


																			</td>
																			<td><input type="text" name="paid_amt" id="paid_amt" class="form-control"   value="<?php echo $paid_amt; ?>"  />
																			</td>

																			<td><input type="text" name="disc" id="disc" class="form-control" value="<?php echo $disc; ?>"></td>
																			<td> <select name="pay_type" id="pay_type" class="select2-me" style="width:100%;">
                                           		<option value="">-Select-</option>
																			<option value="NEFT/Net Banking">NEFT/Net Banking</option>
																			<option value="upi">UPI</option>
																				<option value="cash">CASH</option>
                                           </select>
                                           <script>document.getElementById('pay_type').value = '<?php echo $pay_type ; ?>'; </script></td>
																			<td><input type="text" name="narration" id="narration" class="form-control" placeholder=" " value="<?php echo $narration; ?>"></td>
																			
																			<td><a class="btn btn-primary" style="width: 50px;" onclick="addlist();">Add</a></td>
																			


																	</tbody>
																</table>
																<br>
															</div>


													</div>
							
							<div class="box box-color box-bordered red" >
			<div class="box-title">
			<h3><i class="fa fa-table"></i>Recent Payment Details</h3>
				

				
				
			</div>
				
			<div class="box-content nopadding" id="showsalepayrecord">
		
			
			</div>
		</div>
						</div><br/>
					</div>
					
					
						<div class="form-actions">
		
												<center>
		 								
			          		<button type="submit"  onclick="savesaleupper()" class="btn btn-primary">Save</button>
						<a type="button" href="<?php echo $pagename; ?>"class="btn btn-red">Cancel</a>
												</center>	
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
						<th>Customer  Name</th>
						<th>Paid Amount</th>

                        
					</tr>
					<tr>
						<td>  <select data-placeholder="Choose a Suppliers..." id="s_customer_id" class="formcent select2-me" tabindex="2" style="width:250px;"  onChange="getprebal();" >

                                       <option value="">Select </option>
                                       <?php
                                                $sql = mysqli_query($connection, "select * from  m_customer  order by cust_name");
                                                while ($row = mysqli_fetch_array($sql)) {
                                                   
											// $item_category_name = $cmn->getvalfield($connection, "item_categories", "item_category_name", "itemcatid='$row[itemcatid]'");

                                                ?>
                                                   <option value="<?php echo $row['customer_id']; ?>"><?php echo $row['cust_name']; ?></option>

                                                <?php } ?>
                                                <script>
                                                   document.getElementById('customer_id').value = '<?php echo $customer_id; ?>';
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
				<td><input type="date" id="s_paymentdate" class="form-control" value="" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > </td>
				
		
                <td> 
                  <!-- <input type="text" id="s_pay_type" class="form-control" value="" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > </td> -->
              <select data-placeholder="Choose Payment Type..." id="s_pay_type" class="formcent select2-me" style="width:180px;">
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