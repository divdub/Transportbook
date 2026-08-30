<?php 
   include("adminsession.php");
 
   $pagename = "voucher_entry.php";
   $modulename = "Voucher Entry";

   ?>

      <div class="tab-pane active" id="main" style="margin-left:0">
      <div class="row">
      <div class="col-sm-12">
         <div class="row">
            <div class="col-sm-12" style="margin-top:20px;">
               <div class="col-sm-3">
                  <h3 class="tbhead" style="margin-top: 1px;">Voucher Entry</h3>
               </div>
               <div class="col-sm-3">
                  <table width="100%" border="0">
                     <tbody>
                        <tr>
                           <td>
                              <div class="check-line">
                               <input type="radio" id="c7" class='icheck-me' name="same3" data-skin="square" data-color="blue" value="multiple" checked>
                       <label class='inline' for="c7"><strong>Multiple Voucher Entry</strong></label>
                              </div>
                           </td>
                           <td>
                              <div class="check-line">
                                 <input type="radio" id="c7" class='icheck-me' name="same3" data-skin="square" data-color="blue" value="single">
                                 <label class='inline' for="c7"><strong>Single Voucher Entry</strong></label>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="box box-bordered box-color" id="showmultiple">
            <div class="box-title">
               <h3>
               <i class="fa fa-list"></i>	
               <h3 class="tbhead">Multiple Voucher Entry</h3>
            </div>
            <div class="box-content nopadding" >
               <form action="#" method="POST" class='form-horizontal form-column form-bordered'>
                  <div class="row">
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">From Date </label>
                           <div class="col-sm-8">
                              <input type="date" name="fromdate" id="fromdate" placeholder="Receive" class="form-control" value="<?php echo $currentdate; ?>" >
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">To Date</label>
                           <div class="col-sm-8">
                              <input type="date" name="todate" id="todate" placeholder="Text input" class="form-control" value="<?php echo $currentdate; ?>" >
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Category</label>
                           <div class="col-sm-8">
         <select name="cat_id" id="cat_id" class='select2-me ' onchange="getcat(this.value);" style="width:100%;">
                                    <option value="">Select</option>
          <?php  $sql = mysqli_query($connection,"Select * from  tpcategory   order by tpcat_id");
										  while($row= mysqli_fetch_array($sql)) { ?>
					<option value="<?php echo $row['tpcat_id']; ?>"><?php echo $row['tp_name']; ?></option>
								<?php } ?>
			<script>
				document.getElementById('cat_id').value ='<?php echo $cat_id; ?>';</script>
							</select>
                           </div>
                        </div>
                     </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Name</label>
                           <div class="col-sm-8">
                        <select name="catname" id="catname" class='select2-me '  style="width:100%;">
                             </select>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-actions">
                           <center>
                             <a type="submit" class="btn btn-primary" onclick="getsearch();">Search</a>
                              <a type="button" onclick="jQuery('#ventry').click();" class="btn btn-red">Reset</a>
                           </center>
                        </div>
                     </div>
                  </div>
                  <div class="row" style="width: 99.99%">
                     <div class="col-sm-12" style="overflow: scroll;height: 500px" id="vouchertable">

                    

                     </div>
                  </div>
               </form>
            </div></div></div>
            <div class="col-sm-12">
            	 <span style="color:#F00;width: 70px;" id="msg"></span>
            <div class="box box-bordered box-color" id="showsingle">
               <div class="box-title">
                  <h3>
                  <i class="fa fa-list"></i>
                  <h3 class="tbhead">Single Voucher Entry </h3>
               </div>
               <div class="box-content nopadding" >
                  <form action="#" method="POST" class='form-horizontal form-column form-bordered'>
                     <div class="row">
                        <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4"> Category</label>
                              <div class="col-sm-8">
                       <select name="tpcat_id" id="tpcat_id" class='select2-me ' onchange="getname(this.value);" style="width:100%;">
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
                              <label for="textfield" class="control-label col-sm-4">Name </label>
                              <div class="col-sm-8">
                          <select name="name" id="name" class='select2-me ' onchange="getdi();" style="width:100%;">
                                
                                    <option value="">Select</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="form-group">
                         <label for="textfield" class="control-label col-sm-4">DI/LR No. </label>
                              <div class="col-sm-8">
                                <select name="dispatch_id" id="dispatch_id" class='select2-me '  style="width:100%;" onchange="getvalue();">
                                
                                    <option value="">Select</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                       
                        <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Bilty Date </label>
                              <div class="col-sm-8">
                                 <input type="date" name="bilty_date" id="bilty_date" placeholder="Enter Consignor Name" class="form-control" readonly >
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-sm-3">
                           <div class="form-group">
                         <label for="textfield" class="control-label col-sm-4">Truck No. </label>
                              <div class="col-sm-8">
                                 <input type="text" name="vehicle_no" id="vehicle_no" placeholder="Enter Consignee Name" class="form-control" readonly >
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Destination	</label>
                              <div class="col-sm-8">
                                 <input type="text" name="destination" id="destination" placeholder="Enter Destination" class="form-control" readonly >
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Weight</label>
                              <div class="col-sm-8">
                                 <input type="text" name="wt_mt" id="wt_mt" placeholder="Enter Truck Number" class="form-control" readonly >
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Receive Weight</label>
                              <div class="col-sm-8">
                                 <input type="text" name="rec_wt" id="rec_wt" placeholder="Enter Owner Name" class="form-control" readonly >
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-sm-3">
                           <div class="form-group">
                             <label for="textfield" class="control-label col-sm-4">Company Rate</label>
                              <div class="col-sm-8">
                                 <input type="text" name="comp_rate" id="comp_rate" placeholder="Company Rate" class="form-control" readonly >
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Own Rate</label>
                              <div class="col-sm-8">
                                 <input type="text" name="own_rate" id="own_rate" placeholder="Own Rate" class="form-control" readonly >
                              </div>
                           </div>
                        </div>
                       <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4"> <span style="color: red">*</span>Freight Amt</label>
                              <div class="col-sm-8">
                                 <input type="text" name="freight_amt" id="freight_amt" placeholder="Amount" class="form-control">
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Freight Rate</label>
                              <div class="col-sm-8">
                          <input type="text" name="freight_rate" id="freight_rate" placeholder="Freight Rate" class="form-control" >
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                       
                          <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Commision</label>
                              <div class="col-sm-8">
                                 <input type="text" name="commision" id="commision" placeholder="Commision" class="form-control"  readonly>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="form-group">
                      <label for="textfield" class="control-label col-sm-4">Bilty Commision</label>
                              <div class="col-sm-8">
                                 <input type="text" name="bilty_commision" id="bilty_commision" placeholder="Bilty Commision" class="form-control" onchange="gettotal();">
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Shortage Amt</label>
                              <div class="col-sm-8">
                                 <input type="text" name="sortamt" id="sortamt" placeholder="Shortage Amount" class="form-control" readonly >
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Shortage MT/BAGS</label>
                              <div class="col-sm-8">
                                <input type="text" name="shortage" id="shortage" placeholder="Shortage " class="form-control" readonly >
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4"><span style="color: red">*</span>Tds %  </label>
                              <div class="col-sm-8">
                                 <input type="text" name="tds" id="tds" placeholder="Tds " onchange="gettds();" class="form-control">
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">TDS Amt </label>
                              <div class="col-sm-8">
                                 <input type="text" name="tds_amt" id="tds_amt" placeholder="Enter Place Name" class="form-control" readonly>
                              </div>
                           </div>
                        </div>

                        <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Diesel Adv. Amt.</label>
                              <div class="col-sm-8">
                                 <input type="text" name="diesel_adv_amt" id="diesel_adv_amt" placeholder="Diesel Advance Amount" class="form-control" readonly >
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Cash Advance </label>
                              <div class="col-sm-8">
                                <input type="text" name="cash_adv" id="cash_adv" placeholder="Cash Advance" class="form-control" readonly >
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4"> GPS Amt</label>
                              <div class="col-sm-8">
                                 <input type="text" name="other_cash_adv" id="other_cash_adv" placeholder="GPS Amt" class="form-control" readonly>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3" style="display:none;">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Consignor Cash Adv.</label>
                              <div class="col-sm-8">
                                 <input type="text" name="consignor_cash_adv" id="consignor_cash_adv" placeholder="Consignor Cash Advance" class="form-control" readonly>
                              </div>
                           </div>
                        </div>
                             <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Adv Paid To</label>
                              <div class="col-sm-8">
                               <input type="text" name="paid_to" id="paid_to" placeholder="Advance Paid To" class="form-control" readonly>
                              </div>
                           </div>
                        </div> 
                           <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Payee Name</label>
                              <div class="col-sm-8">
                               <input type="text" name="payee_name" id="payee_name" placeholder="Payee Name" class="form-control" >
                              </div>
                           </div>
                        </div> 
                          <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Account No.</label>
                              <div class="col-sm-8">
                               <input type="text" name="acc_no" id="acc_no" placeholder="Account Number" class="form-control" >
                              </div>
                           </div>
                        </div> 
                     </div>
                     <div class="row"> 
                          <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Ifsc Code</label>
                              <div class="col-sm-8">
                               <input type="text" name="ifsc_code" id="ifsc_code" placeholder="" class="form-control" >
                              </div>
                           </div>
                        </div> 
                          
                        <div class="col-sm-3" style="display:none;">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Consignee Cash Adv.</label>
                              <div class="col-sm-8">
                                 <input type="text" name="consignee_cash_adv" id="consignee_cash_adv" placeholder="Consignee Cash Advance" class="form-control" readonly >
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="form-group">
                             <label for="textfield" class="control-label col-sm-4">Voucher Date</label>
                              <div class="col-sm-8">
                                 <input type="date" name="payment_date" id="payment_date" placeholder="Consignee Cash Advance" class="form-control"  >
                              </div>
                           </div>
                        </div>
                   
                  
                         <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4"> Bill Type</label>
                              <div class="col-sm-8">
                       <select name="bill_type" id="bill_type" class='select2-me' style="width:100%;" onchange="showGst(this.value);" required>
                                    <option value="">Select</option>
       
               <option value="Challan">Challan</option>
              <option value="Invoice">Invoice</option>        
         <script>
            document.getElementById('bill_type').value ='<?php echo $bill_type; ?>';</script>
                     </select>
                              
                              </div>
                           </div>
                        </div> 
                         <div class="col-sm-3" id="th1">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4"> GST Type</label>
                              <div class="col-sm-8">
                  <select name="gst_type" id="gst_type" class='select2-me' style="width:100%;">
                                    <option value="">Select</option>
       
               <option value="GST">GST</option>
              <option value="IGST">IGST</option>        
         <script>
            document.getElementById('gst_type').value ='<?php echo $gst_type; ?>';</script>
                     </select>
                              
                              </div>
                           </div>
                        </div> </div>
                           <div class="row">
                          <div class="col-sm-3" id="th2">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4"> GST %</label>
                              <div class="col-sm-8">
                  <select name="gstper" id="gstper" class='select2-me' style="width:100%;" onchange="getgstvalue1();">
                                    <option value="">Select</option>
       
               <option value="5">5% </option>
              <option value="12">12%</option> 
              <option value="18">18%</option>    
              <option value="28">28%</option>     
         <script>
            document.getElementById('gstper').value ='<?php echo $gstper; ?>';</script>
                     </select>
                              
                              </div>
                           </div>
                        </div>
                          <div class="col-sm-3" id="th3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Net Amt</label>
                              <div class="col-sm-8">
                                 <input type="text" name="netamt1" id="netamt1" placeholder="Net Amt" class="form-control" readonly>
                              </div>
                           </div>
                        </div>
                     
                        <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">remark</label>
                              <div class="col-sm-8">
                                 <input type="test" name="remark" id="remark" placeholder="Remark" class="form-control"  >
                              </div>
                           </div>
                        </div>     
                   
                         <div class="col-sm-3">
                           <div class="form-group">
                              <label for="textfield" class="control-label col-sm-4">Amt Paid TO</label>
                              <div class="col-sm-8">
                               <input type="text" name="total" id="total" placeholder="Amount Paid To" class="form-control" readonly>
                              </div>
                           </div>
                        </div> 
                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="form-actions">
                              <center>
                           <a type="submit" onclick="savesinglevoucher();" class="btn btn-primary">Save</a>
             <a type="button" onclick="jQuery('#ventry').click();" class="btn btn-red">Cancel</a>
                              </center>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>  
         </div>
     </div>
         <br/>
      </div>
