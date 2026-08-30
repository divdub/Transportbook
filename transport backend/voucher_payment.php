<?php 
error_reporting(0);
   include("adminsession.php");
   $tblname = "payment_receive";
   $tblpkey = "pay_receive_id";
   $pagename = "voucher_payment.php";
   $modulename = "Voucher Payment";

   ?>
      <div class="tab-pane active" id="main" style="margin-left:0">
      <div class="row">
         <div class="col-sm-12">
            <div class="box box-bordered box-color">
               <div class="box-title">
                  <!-- <span style="color: white; font-weight: bold">Success! Data Insert Successfully. <i class="fa fa-check-circle"></i></span>
                     <span style="color: white; font-weight: bold">Warning! The value you entered is already in the list. <i class="fa fa-clone"></i></span>
                     <span style="color: white; font-weight: bold">Warning! Data not inserted kindly fill mandatory field. <i class="fa fa-warning"></i></span>	 -->							
                  <h3>
                  <i class="fa fa-list"></i>	
                  <h3 class="tbhead">Voucher Payment </h3>
               </div>
               <div class="box-content nopadding" >
                  <form action="#" method="POST" class='form-horizontal form-column form-bordered'>
                     <div class="row">
                        <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Category<span style="color: red">*</span></label>
                              <div class="col-sm-8">
                              <select name="tpcat_id" id="tpcat_id" class='select2-me ' onchange="getvoucherno(this.value);" style="width:100%;">
                                    <option value="">Select</option>
          <?php  $sql = mysqli_query($connection,"Select * from  tpcategory   order by tpcat_id");
										  while($row= mysqli_fetch_array($sql)) { ?>
					<option value="<?php echo $row['tpcat_id']; ?>"><?php echo $row['tp_name']; ?></option>
								<?php } ?>
						<script>
				document.getElementById('tpcat_id').value ='<?php echo $tpcat_id; ?>';</script>
							</select>

                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Voucher No.</label>
                              <div class="col-sm-8">
                                <select name="voucher_no" id="voucher_no" class='select2-me '  style="width:100%;" onchange="vouchdetail();">
                                	<option value="">Select</option>
                                </select>
                              </div>
                           </div>
                        </div>
                       
                        <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Voucher Name</label>
                              <div class="col-sm-8">
                                 <input type="text" name="voucher_name" id="voucher_name" placeholder="Voucher Name" class="form-control" readonly>
                                    <input type="hidden" name="catname" id="catname" placeholder="Voucher Name" class="form-control" readonly>
                              </div>
                           </div>
                        </div>
                  
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Voucher Amt</label>
                           <div class="col-sm-8">
                              <input type="text" name="amt_paid_to" id="amt_paid_to" placeholder="Voucher Amount" class="form-control" readonly>
                           </div>
                        </div>
                     </div>
                        </div>
                     <div class="row">
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Balance Amt</label>
                           <div class="col-sm-8">
                              <input type="text" name="balance_amt" id="balance_amt" placeholder="Balance Amount" class="form-control" readonly>
                           </div>
                        </div>
                     </div>

                     <div class="col-sm-3">
                        <div class="form-group">
                            <!--<label for="textfield" class="control-label col-sm-4"><a onClick="jQuery('#myshowpaidto').modal('show');">Paid to </a><span style="color: red">*</span></label>-->
                           <label for="textfield" class="control-label col-sm-4">Paid to <span style="color: red">*</span></label>
                           <div class="col-sm-8">
                              <input type="text" name="payee_name" id="payee_name" placeholder="Payee Name" class="form-control" readonly>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Paid Amt <span style="color: red">*</span></label>
                           <div class="col-sm-8">
                              <input type="text" name="receive_amt" id="receive_amt" placeholder="Enter Amount" class="form-control">
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Slip no.</label>
                           <div class="col-sm-8">
                              <input type="text" name="rec_no" id="rec_no" placeholder="Slip No." class="form-control" readonly>
                           </div>
                        </div>
                     </div>
               
               
               </div>
               <div class="row">
               <div class="col-sm-3">
               <div class="form-group">
               <label for="textfield" class="control-label col-sm-4"> Paid Date <span style="color: red">*</span> </label>
               <div class="col-sm-8">
               <input type="date" name="receive_date" id="receive_date" placeholder="Text input" class="form-control">
               </div>
               </div>
               </div>
                  <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Payment Mode.</label>
                              <div class="col-sm-8">
                                <select name="pay_mode" id="pay_mode" class='select2-me '  style="width:100%;" >
                                 <option value="">Select</option>
                                 <option value="CASH">CASH</option>
                                 <option value="NEFT">NEFT</option>
                                 <option value="CHEQUE">CHEQUE</option>
                                </select>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Bank Name<span style="color: red">*</span></label>
                              <div class="col-sm-8">
                              <select name="bankid" id="bankid" class='select2-me '  style="width:100%;">
                                    <option value="">Select</option>
          <?php  $sql = mysqli_query($connection,"Select * from  m_bank    order by bankid ");
										  while($row= mysqli_fetch_array($sql)) { ?>
					<option value="<?php echo $row['bankid']; ?>"><?php echo $row['bank_name']; ?></option>
								<?php } ?>
						<script>
				document.getElementById('bankid').value ='<?php echo $bankid; ?>';</script>
							</select>

                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
               <div class="form-group">
               <label for="textfield" class="control-label col-sm-4">UTR /Refrence No.</label>
               <div class="col-sm-8">
               <input type="text" name="utrno" id="utrno" placeholder="Enter Number" class="form-control">
               </div>
               </div>
               </div>
               </div>

               <div class="row">
               <div class="col-sm-3">
               <div class="form-group">
               <label for="textfield" class="control-label col-sm-4"> Remark </label>
               <div class="col-sm-8">
               <input type="text" name="remark" id="remark" placeholder="Enter Remark" class="form-control">
               </div>
               </div>
               </div>
               </div>
               
               <div class="row">
               <div class="col-sm-12">
               <div class="form-actions">
               <center>
               	  <a type="submit" onclick="savevoucherpayment();" class="btn btn-primary">Save</a>
             <a type="button" onclick="jQuery('#vpayment').click();" class="btn btn-red">Cancel</a>
               
               </center>
               </div>
               </div>
               </div>
               </form>
            </div>
            <div class="box box-color box-bordered red">
               <div class="box-title">
                  <h3>	<i class="fa fa-table"></i>
                     Recent Payment  Details
                  </h3>
                  <!-- <a href="all-dispatch-entry.php" class="btn btn-warning" style="float: right">Click Hear For All Entry -->
                  <!-- <i class="fa fa-object-group"></i> -->
                  <!-- </a> &nbsp; -->
                  <!-- <a href="all-dispatch-entry.php" style="text-align: right" target="_blank">All Record</a> -->
                  <!-- <button class="btn" style="float: right">Export
                  <i class="fa fa-file-pdf-o"></i>
                  </button> &nbsp; -->
                  <!-- <button class="btn btn-warning" style="float: right">Export -->
                  <!-- <i class="fa fa-file-excel-o"></i> -->
                  <!-- </button> 		 -->
               </div>
               <div class="box-content nopadding">
                  <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
                     <thead>
                        <tr>
                           <th>S.No</th>
                           <th>Category</th>
                           <th>Voucher No.</th>
                           <th class='hidden-350'>Voucher Name</th>
                            <th class='hidden-350'>Paid To</th>
                           <th class='hidden-1024'>Slip No.</th>
                           <th class='hidden-480'>Paid Amount</th>
                           <th>Receive Date</th> 
                           <th>Payment Mode</th>
                           <th>Remark</th>
                           
                        </tr>
                     </thead>
                     <tbody>
                     		 <?php
									$sn=1;
									// echo "Select * from  $tblname where consignorid=5 order by $tblpkey desc limit 10" ;
				$sql = mysqli_query($connection,"Select * from  $tblname where consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id order by $tblpkey desc limit 10");
										  while($row= mysqli_fetch_array($sql)) {
	$voucher_no=$cmn->getvalfield($connection,"payment","voucher_no","voucher_no='$row[voucher_no]' && consignorid='$consignorid' && comp_id=$comp_id && session_id=$session_id");									  	
	$paid_to=$cmn->getvalfield($connection,"payment","payee_name","voucher_id='$row[voucher_no]' && consignorid='$consignorid' && comp_id=$comp_id && session_id=$session_id");

if($row['category']==1){
	$cname="Agent";
	
} 
if($row['category']==2){
	$cname="Consignee";
	
} 
if($row['category']==4) {
	$cname="Truck Owner";
	
}
										   ?>

                        <tr>
                    	<td><?php echo $sn++;?></td>
						<td><?php echo $cname; ?></td>
						<td><?php echo $row['voucher_no']; ?></td>
						<td class='hidden-350'><?php echo $row['voucher_name']; ?></td>
							<td class='hidden-350'><?php echo $paid_to; ?></td>
						<td class='hidden-350'><?php echo $row['rec_no']; ?></td>
						<td class='hidden-350'><?php echo $row['receive_amt']; ?></td>
						<td><?php echo dateformatindia($row['receive_date']); ?></td>
                  <td class='hidden-350'><?php echo $row['pay_mode']; ?></td>
                  
						<td class='hidden-350'><?php echo $row['remark']; ?></td>
						
                          
                        </tr>
                    <?php } ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <br/>
      </div>
