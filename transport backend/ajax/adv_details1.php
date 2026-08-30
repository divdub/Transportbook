<?php 
   include("../adminsession.php");
     $dispatch_id = $_REQUEST['dispatch_id']; 
   
    $sql = mysqli_query($connection, "select * from dispatch_entry where dispatch_id=$dispatch_id");
   
     $row = mysqli_fetch_array($sql);
    
    $di_no =$row['di_no'];
   $wt_mt=$row['wt_mt'];
   $own_rate=$row['own_rate'];
   $freight_amt= $wt_mt* $own_rate;
     $consignee_cash_adv =$row['consignee_cash_adv'];
     $consignee_cash_adv_date=$row['consignee_cash_adv_date'];
     $consignor_cash_adv_date=$row['consignor_cash_adv_date'];
     $consignor_cash_adv=$row['consignor_cash_adv'];
     $pump_id=$row['pump_id'];
     $diesel_rate=$row['diesel_rate'];
     $diesel_ltr=$row['diesel_ltr'];
     $diesel_adv_amt=$row['diesel_adv_amt'];
      $cash_adv=$row['cash_adv'];
       $cash_adv_date=$row['cash_adv_date'];
        $other_cash_adv=$row['other_cash_adv'];
         $other_cash_adv_date=$row['other_cash_adv_date'];
       $dispatch_id =$row['dispatch_id'];
    $is_advance=$row['is_advance'];
   $adblue_id=$row['adblue_id'];
   $adv_remark=$row['adv_remark'];
   $pay_type=$row['pay_type'];
   $rate=$row['rate'];
    $adblueqty=$row['adblueqty'];
   ?>
<div id="updatedata">
   <div class="row col-12" style="padding-left: 15px;">
      <div class="row mb-6">
         <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">DI No.</label>
         <div class="col-sm-3">
             <input type="text" name="di_no" id="di_no"  class="form-control" placeholder="" required value="<?php echo $di_no;?>" readonly>
             <input type="hidden" name="dispatch_id" id="dispatch_id"  class="form-control" placeholder="" required value="<?php echo $dispatch_id;?>" readonly>
            <!-- <input type="text" name="di_no" id="di_no"  class="form-control" placeholder="" required value="<?php echo $di_no;?>"> -->
         </div>
         <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Freight Amt</label>
         <div class="col-sm-3">
            <input type="text" name="freight_amt" id="freight_amt"  class="form-control" placeholder="" required value="<?php echo $freight_amt;?>" readonly>
         </div>
      </div>
      <br>
      <div class="row mb-6">
      <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Petrol Pump </label>
      <div class="col-sm-3">
         <select name="pump_id" id="pump_id" class='form-control' onchange="getpumprate(this.value);" >
            <option value=" "> Select</option>
            <?php $sql = mysqli_query($connection,"Select * from  m_petrol_pump  order by pump_id ");
               while($row= mysqli_fetch_array($sql)) { ?>
            <option value="<?php echo $row['pump_id']; ?>"><?php echo $row['pump_name']; ?></option>
            <?php } ?>
         </select>
         <script>
            document.getElementById('pump_id').value ='<?php echo $pump_id; ?>';
         </script>
      </div>
      <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Diesel Rate</label>
      <div class="col-sm-3">
         <input type="text" name="diesel_rate" id="diesel_rate"  class="form-control" value="<?php echo $diesel_rate; ?>">
      </div></div><br>
      <div class="row mb-6">
      <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Diesel Ltr</label>
      <div class="col-sm-3">
         <input type="text" name="diesel_ltr" id="diesel_ltr"  class="form-control" value="<?php echo $diesel_ltr; ?>" onchange="getdieselamt();">
      </div>
  
      <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Diesel Adv. Amt.</label>
      <div class="col-sm-3">
         <input type="text" name="diesel_adv_amt" id="diesel_adv_amt"  class="form-control" value="<?php echo $diesel_adv_amt; ?>">
      </div></div><br>
      <div class="row mb-6">
      <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Cash Advance</label>
      <div class="col-sm-3">
         <input type="text" name="cash_adv" id="cash_adv"  class="form-control" value="<?php echo $cash_adv; ?>">
      </div>
  
      <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Cash Adv. Date</label>
      <div class="col-sm-3">
         <input type="date" name="cash_adv_date" id="cash_adv_date"  class="form-control" value="<?php echo $cash_adv_date; ?>">
      </div></div><br>
      <div class="row mb-6">
      <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">GPS Amt</label>
      <div class="col-sm-3">
         <input type="text" name="other_cash_adv" id="other_cash_adv"  class="form-control" value="<?php echo $other_cash_adv; ?>">
      </div>
   
      <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">GPS Amt Date</label>
      <div class="col-sm-3">
         <input type="date" name="other_cash_adv_date" id="other_cash_adv_date"  class="form-control" value="<?php echo $other_cash_adv_date; ?>">
      </div></div><br>
      <div class="row mb-12">
           <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">AdBlue	 </br>
           Stock :<span id="stock1" style="color:red;"></span></label>
      <div class="col-sm-3">
        	<select name="adblue_id" id="adblue_id" class='form-control' onchange="getstock(this.value);" style="width:100%;">
												<option value=" "> Select</option>
		<?php	$sql = mysqli_query($connection,"Select * from  m_adblue  order by adblue_id ");
										  while($row= mysqli_fetch_array($sql)) { ?>
											<option value="<?php echo $row['adblue_id']; ?>"><?php echo $row['adblue_name']; ?></option>
								<?php } ?>
							</select>
								<script>
				document.getElementById('adblue_id').value ='<?php echo $adblue_id; ?>';</script>
      </div>
      
    <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Rate</label>
      <div class="col-sm-3">
					<input type="text" name="rate" id="rate" placeholder="Enter AdBlue Rate" class="form-control" value="<?php echo $rate; ?>" onchange="getadblueamt();">
      </div>
   
      <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;display:none;">Consignor Cash Adv Date.</label>
      <div class="col-sm-3" style="display:none;">
         <input type="date" name="consignor_cash_adv_date" id="consignor_cash_adv_date"  class="form-control" value="<?php echo $consignor_cash_adv_date; ?>" >
      </div>
   </div>
   <div class="row mb-12">
      <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Qty.</label>
      <div class="col-sm-3">
       	<input type="text" name="adblueqty" id="adblueqty" placeholder="Enter Qty" class="form-control" value="<?php echo $adblueqty; ?>" onchange="getadblueamt();">
										<input type="hidden" name="stock" id="stock" placeholder="Enter Qty" class="form-control" value="<?php echo $adblueqty; ?>" onchange="getadblueamt();">
      </div>
  
     <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">AdBlue Amount</label>
      <div class="col-sm-3">
         <input type="text" name="consignor_cash_adv" id="consignor_cash_adv"  class="form-control" value="<?php echo $consignor_cash_adv; ?>" >
      </div>
   </div>
   <br>
   
   <div class="row mb-12">
      <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Pay Type.</label>
      <div class="col-sm-3">
     <select name="pay_type" id="pay_type" class='form-control' style="width:100%;">
						    <option value=""> Select</option>
						    <option value="phone pay">Phone Pay</option>
						    <option value="cash">Cash</option>
						</select>
						<script>
				document.getElementById('pay_type').value ='<?php echo $pay_type; ?>';</script>
										
      </div>
  
					<label for="inputText" class="control-label col-sm-3" style="font-size:15px;font-weight:bold ;width: 190px;">Narration</label>
																				<div class="col-sm-3">
					<input type="text" name="adv_remark" id="adv_remark" placeholder="Enter Remark" class="form-control" value="<?php echo $adv_remark; ?>">
																				</div>
																		
</div>
   
   </div>
   <br>
   
   
   <div class="row mb-12" style="display:none;">
      <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Consignee Cash Adv.</label>
      <div class="col-sm-3">
         <input type="text" name="consignee_cash_adv" id="consignee_cash_adv"  class="form-control" value="<?php echo $consignee_cash_adv; ?>">
      </div>
  
      <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Consignee Cash Adv Date.</label>
      <div class="col-sm-3">
         <input type="date" name="consignee_cash_adv_date" id="consignee_cash_adv_date"  class="form-control" value="<?php echo $consignee_cash_adv_date; ?>" >
      </div>
   </div>
</div>
<br>
<div class="modal-footer" >
   <center>
      <a class="btn btn-primary" onclick="getadventry2();" tabindex="12"> Save</a>
      <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a>
   </center>
</div>
</div>