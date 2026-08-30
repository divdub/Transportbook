<?php 
   include("../adminsession.php");
     $dispatch_id = $_REQUEST['dispatch_id']; 
   
    $sql = mysqli_query($connection, "select * from dispatch_entry where dispatch_id=$dispatch_id");
   
     $row = mysqli_fetch_array($sql);
    
    $di_no =$row['di_no'];
   $wt_mt=$row['wt_mt'];
  
     $rec_wt =$row['rec_wt'];
     $rec_qty=$row['rec_qty'];
     $qty=$row['qty'];
     $unloading_place=$row['unloading_place'];
     $rec_date=$row['rec_date'];
     $bilty_date=$row['bilty_date'];
     $receive_type=$row['receive_type'];
     $wt=$wt_mt-$rec_wt;
     $qt=$qty-$rec_qty;
     $shortage=$wt."/".$qt;
    $dispatch_id=$row['dispatch_id'];
   ?>
<div id="updatedata">
   <div class="row col-12" style="padding-left: 15px;">
      <div class="row mb-6">
         <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">DI No.</label>
         <div class="col-sm-3">
          
            <input type="text" name="di_no" id="di_no"  class="form-control" placeholder="" required value="<?php echo $di_no;?>" readonly>
             <input type="hidden" name="dispatch_id" id="dispatch_id"  class="form-control" placeholder="" required value="<?php echo $dispatch_id;?>" readonly>
         </div>
         <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Bilty date</label>
         <div class="col-sm-3">
            <input type="date" name="bilty_date" id="bilty_date"  class="form-control" placeholder="" required value="<?php echo $bilty_date;?>" readonly>
         </div>
      </div>
      <br>
      <div class="row mb-6">
      <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">WT (MT/KG)</label>
      <div class="col-sm-3">
          <input type="text" name="wt_mt" id="wt_mt"  class="form-control" placeholder="" required value="<?php echo $wt_mt;?>" readonly>
      </div>
      <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">QTY (Bags)</label>
      <div class="col-sm-3">
         <input type="text" name="qty" id="qty"  class="form-control" value="<?php echo $qty; ?>" readonly>
      </div></div><br>
      <div class="row mb-6">
      <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Rec Wt (MT/KG)</label>
      <div class="col-sm-3">
         <input type="text" name="rec_wt" id="rec_wt"  class="form-control" value="<?php echo $rec_wt; ?>" onchange="shortval();">
      </div>
  
      <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Rec Qty (Bags)</label>
      <div class="col-sm-3">
         <input type="text" name="rec_qty" id="rec_qty"  class="form-control" value="<?php echo $rec_qty; ?>" onchange="shortval();">
      </div></div><br>
      <div class="row mb-6">
      <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Unloading Place</label>
      <div class="col-sm-3">
         <input type="text" name="unloading_place" id="unloading_place"  class="form-control" value="<?php echo $unloading_place; ?>">
      </div>
      <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Shortage MT/KG/BAGS</label>
 
                              <div class="col-sm-3">
                                 <input type="text" name="shortage" id="shortage" placeholder="0/0" class="form-control" readonly value="<?php echo $shortage; ?>" >
                              </div>
     </div><br>
      <div class="row mb-6">
          <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Rec Type</label>
      <div class="col-sm-3">
        <select name="receive_type" id="receive_type" class='form-control' onchange="shortval();">
                                    <option value="">Select </option>
                                    <option value="0">No Shortage</option>
                                    <option value="1">Shortage </option>
                                    <option value="2">Damage</option>
                                 </select>
                                 <script>
            document.getElementById('receive_type').value ='<?php echo $receive_type; ?>';</script>
      </div>
      <label for="inputText" class="col-sm-3 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Rec. Date</label>
      <div class="col-sm-3">
         <input type="date" name="rec_date" id="rec_date"  class="form-control" value="<?php echo $rec_date; ?>">
      </div>
   
      </div><br>
  
</div>
<br>
<div class="modal-footer" >
   <center>
      <a class="btn btn-primary" onclick="updaterec();" tabindex="12"> Update</a>
      <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a>
   </center>
</div>
</div>