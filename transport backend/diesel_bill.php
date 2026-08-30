<?php 
error_reporting(0);
include("adminsession.php");
$tblname = "dispatch_entry";
$tblpkey = "dispatch_id";
$pagename = "diesel_bill.php";
$modulename = "Diesel Bill Entry";
$fromdate=$currentdate;
$todate=$currentdate;
$di_no='';
$bilty_no='';
$consignee_name1='';
$consignor_name1='';
$owner_name='';
$wt_mt='';
$qty='';
$place_name='';
$vehicle_no1='';
if (isset($_GET['dbillid'])) {
    $dbillid = $_GET['dbillid'];
   
   
} else
   $dbillid = 0;

   ?>

      <div class="tab-pane active" id="main" style="margin-left:0">
      <div class="row">
      <div class="col-sm-12">
        
         <div class="box box-bordered box-color" id="showmultiple">
            <div class="box-title">
               <h3>
               <i class="fa fa-list"></i>	
               <h3 class="tbhead">Diesel Bill Entry</h3>
            </div>
            <div class="box-content nopadding" >
               <form action="#" method="POST" class='form-horizontal form-column form-bordered'>
                  <div class="row">
                     <div class="col-sm-2">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">From Date </label>
                           <div class="col-sm-8">
                              <input type="date" name="fromdate" id="fromdate" placeholder="Receive" class="form-control" value="<?php echo $fromdate; ?>">
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-2">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">To Date</label>
                           <div class="col-sm-8">
                              <input type="date" name="todate" id="todate" placeholder="Text input" class="form-control" value="<?php echo $fromdate; ?>">
                           </div>
                        </div>
                     </div>
                    
                           <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Truck No.</label>
                           <div class="col-sm-8">
                               <select name="vehicle_id" id="vehicle_id" class='select2-me' style="width:100%;">
                                    <option value="">Select</option>
                  <?php	$sql = mysqli_query($connection,"Select * from m_vehicle order by vehicle_id ");
										  while($row= mysqli_fetch_array($sql)) { ?>
					<option value="<?php echo $row['vehicle_id']; ?>"><?php echo $row['vehicle_no']; ?></option>
								<?php } ?>
			<script>
				document.getElementById('vehicle_id').value ='<?php echo $vehicle_id; ?>';</script>
							</select>
                           </div>
                        </div>
                     </div>
                           <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Petrol Pump Name </label>
                           <div class="col-sm-8">
                                     <select name="pump_id" id="pump_id" class='select2-me' style="width:100%;">
                                    <option value="">Select</option>
                  <?php	$sql = mysqli_query($connection,"Select * from m_petrol_pump order by pump_id ");
										  while($row= mysqli_fetch_array($sql)) { ?>
					<option value="<?php echo $row['pump_id']; ?>"><?php echo $row['pump_name']; ?></option>
								<?php } ?>
			<script>
				document.getElementById('pump_id').value ='<?php echo $pump_id; ?>';</script>
							</select>
                           </div>
                        </div>
                     </div>
                      <input type="hidden" name="dbillid" id="dbillid" placeholder="Text input" class="form-control" value="<?php echo $dbillid; ?>">
                     </div>
                     <div class="row">
                     <div class="col-sm-12">
                        <div class="form-actions">
                           <center>
                             <a type="submit" class="btn btn-primary" onclick="getsearch();">Search</a>
                              <a type="button" onclick="jQuery('#d_bill').click();" class="btn btn-red">Reset</a>
                           </center>
                        </div>
                     </div>
                  </div>
                  <div class="row" style="width: 99.99%">
                     <div class="col-sm-12" style="overflow: scroll;height: 500px" id="dieseltable">

                    

                     </div>
                  </div>
               </form>
            </div></div></div>
         
          
         <br/>
      </div>
