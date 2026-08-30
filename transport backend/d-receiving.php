<?php
error_reporting(0);
include("adminsession.php");
$tblname = "dispatch_entry";
$tblpkey = "dispatch_id";
$pagename = "d-receiving.php";
$modulename = "Bilty Receive Entry";
$fromdate = $currentdate;
$todate = $currentdate;
$di_no = '';
$bilty_no = '';
$consignee_name1 = '';
$consignor_name1 = '';
$owner_name = '';
$wt_mt = '';
$qty = '';
$place_name = '';
$vehicle_no1 = '';
?>

<div class="tab-pane active" id="main" style="margin-left:0">
   <div class="row">
      <div class="col-sm-12">
         <div class="row">
            <div class="col-sm-12" style="margin-top:20px;">
               <div class="col-sm-3">
                  <h3 class="tbhead" style="margin-top: 1px;">Bilty Receiving Entry</h3>
               </div>
               <div class="col-sm-3">
                  <table width="100%" border="0">
                     <tbody>
                        <tr>
                           <td>
                              <div class="check-line">
                                 <input type="radio" id="c7" class='icheck-me' name="same3" data-skin="square" data-color="blue" value="multiple" checked>
                                 <label class='inline' for="c7"><strong>Multiple Receiving Entry</strong></label>
                              </div>
                           </td>
                           <td>
                              <div class="check-line">
                                 <input type="radio" id="c7" class='icheck-me' name="same3" data-skin="square" data-color="blue" value="single">
                                 <label class='inline' for="c7"><strong>Single Receiving Entry</strong></label>
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
                  <h3 class="tbhead">Multiple Receiving Entry</h3>
            </div>
            <div class="box-content nopadding">
               <form action="#" method="POST" class='form-horizontal form-column form-bordered' enctype="multipart/form-data">
                  <div class="row">
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">From Date </label>
                           <div class="col-sm-8">
                              <input type="date" name="fromdate" id="fromdate" placeholder="Receive" class="form-control" value="<?php echo $fromdate; ?>">
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">To Date</label>
                           <div class="col-sm-8">
                              <input type="date" name="todate" id="todate" placeholder="Text input" class="form-control" value="<?php echo $fromdate; ?>">
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">DI No/ LR No. </label>
                           <div class="col-sm-8">
                              <input type="text" name="di_no" id="di_no" placeholder="Enter DI No." class="form-control" value="<?php echo $di_no; ?>">
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Truck No.</label>
                           <div class="col-sm-8">
                              <select name="vehicle_id" id="vehicle_id" class='select2-me' style="width:100%;">
                                 <option value="">Select</option>
                                 <?php $sql = mysqli_query($connection, "Select * from m_vehicle order by vehicle_id ");
                                 while ($row = mysqli_fetch_array($sql)) { ?>
                                    <option value="<?php echo $row['vehicle_id']; ?>"><?php echo $row['vehicle_no']; ?></option>
                                 <?php } ?>
                                 <script>
                                    document.getElementById('vehicle_id').value = '<?php echo $vehicle_id; ?>';
                                 </script>
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Truck No.</label>
                           <div class="col-sm-8">
                              <select name="vehicle_id" id="vehicle_id" class='select2-me' style="width:100%;">
                                 <option value="">Select</option>
                                 <?php $sql = mysqli_query($connection, "Select * from m_vehicle order by vehicle_id ");
                                 while ($row = mysqli_fetch_array($sql)) { ?>
                                    <option value="<?php echo $row['vehicle_id']; ?>"><?php echo $row['vehicle_no']; ?></option>
                                 <?php } ?>
                                 <script>
                                    document.getElementById('vehicle_id').value = '<?php echo $vehicle_id; ?>';
                                 </script>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Owner Name </label>
                           <div class="col-sm-8">
                              <select name="owner_id" id="owner_id1" class='select2-me' style="width:100%;">
                                 <option value="">Select</option>
                                 <?php $sql = mysqli_query($connection, "Select * from m_vehicle_owner order by owner_id ");
                                 while ($row = mysqli_fetch_array($sql)) { ?>
                                    <option value="<?php echo $row['owner_id']; ?>"><?php echo $row['owner_name']; ?></option>
                                 <?php } ?>
                                 <script>
                                    document.getElementById('owner_id').value = '<?php echo $owner_id; ?>';
                                 </script>
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="form-actions" style="border-top:none; text-align:center;">
                           <a type="submit" class="btn btn-primary" onclick="getsearch();">Search</a>
                           <a type="button" onclick="jQuery('#reciving').click();" class="btn btn-red">Reset</a>
                        </div>
                     </div>
                  </div>
                  <div class="row" style="width: 99.99%">
                     <div class="col-sm-12" style="overflow: scroll;height: 500px" id="mulrectableid">


                     </div>
                  </div>
               </form>
            </div>
         </div>

      </div>
   </div>
</div>
<div class="col-sm-12">
   <div class="box box-bordered box-color" id="showsingle">
      <div class="box-title">
         <h3>
            <i class="fa fa-list"></i>
            <h3 class="tbhead">Single Bilty Receiving </h3>
      </div>
      <div class="box-content nopadding">
         <form action="#" method="POST" class='form-horizontal form-column form-bordered' enctype="multipart/form-data">
            <div class="row">
               <div class="col-sm-3">
                  <div class="form-group">
                     <label for="textfield" class="control-label col-sm-4"> DI/LR No. </label>
                     <div class="col-sm-8">
                        <select name="dispatch_id" id="dispatch_id" class='select2-me' style="width:100%;" onchange="getreceive(this.value);">
                           <option value="">Select</option>
                           <?php $sql = mysqli_query($connection, "Select * from  $tblname where  is_receive=0 && consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id order by $tblpkey ");
                           while ($row = mysqli_fetch_array($sql)) { ?>
                              <option value="<?php echo $row['dispatch_id']; ?>"><?php echo $row['di_no']; ?></option>
                           <?php } ?>
                           <script>
                              document.getElementById('dispatch_id').value = '<?php echo $dispatch_id; ?>';
                           </script>
                        </select>

                        </select>
                     </div>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label for="textfield" class="control-label col-sm-4"> Bilty No. </label>
                     <div class="col-sm-8">
                        <input type="text" name="bilty_no" id="bilty_no" placeholder="Bilty No." class="form-control" readonly value="<?php echo $bilty_no; ?>">
                        <!-- <select name="select" id="bilty_no" class='form-control'>
                                    <option value="1">012</option>
                                    <option value="2">524</option>
                                 </select> -->
                     </div>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label for="textfield" class="control-label col-sm-4">Bilty Date. </label>
                     <div class="col-sm-8">
                        <input type="date" name="bilty_date" id="bilty_date" placeholder="Text input" class="form-control" readonly value="<?php echo $bilty_date; ?>">
                     </div>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label for="textfield" class="control-label col-sm-4">Consignor </label>
                     <div class="col-sm-8">
                        <input type="text" name="consignor_name1" id="consignor_name1" placeholder="Enter Consignor Name" class="form-control" readonly value="<?php echo $consignor_name1; ?>">
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-3">
                  <div class="form-group">
                     <label for="textfield" class="control-label col-sm-4">Consignee </label>
                     <div class="col-sm-8">
                        <input type="text" name="consignee_name1" id="consignee_name1" placeholder="Enter Consignee Name" class="form-control" readonly value="<?php echo $consignee_name1; ?>">
                     </div>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label for="textfield" class="control-label col-sm-4">Ship to City </label>
                     <div class="col-sm-8">
                        <input type="text" name="place_name" id="place_name1" placeholder="Enter Destination" class="form-control" readonly value="<?php echo $place_name; ?>">
                     </div>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label for="textfield" class="control-label col-sm-4">Truck No.</label>
                     <div class="col-sm-8">
                        <input type="text" name="vehicle_no1" id="vehicle_no1" placeholder="Enter Truck Number" class="form-control" readonly value="<?php echo $vehicle_no1; ?>">
                     </div>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label for="textfield" class="control-label col-sm-4">Owner Name</label>
                     <div class="col-sm-8">
                        <input type="text" name="owner_name" id="owner_name" placeholder="Enter Owner Name" class="form-control" readonly value="<?php echo $owner_name; ?>">
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-3">
                  <div class="form-group">
                     <label for="textfield" class="control-label col-sm-4">Dis. Weight/MT </label>
                     <div class="col-sm-8">
                        <input type="text" name="wt_mt" id="wt_mt" placeholder="Enter Weight" class="form-control" readonly value="<?php echo $wt_mt; ?>">
                     </div>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label for="textfield" class="control-label col-sm-4">Dis. Qty(Bags) </label>
                     <div class="col-sm-8">
                        <input type="text" name="qty" id="qty" placeholder="Enter Quantity" class="form-control" readonly value="<?php echo $qty; ?>">
                     </div>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label for="textfield" class="control-label col-sm-4">Rec. Weight(MT) <span style="color: red">*</span> </label>
                     <div class="col-sm-8">
                        <input type="text" name="rec_wt" id="rec_wt" placeholder="Enter Receive Weight" class="form-control" onchange="shortval();">
                     </div>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label for="textfield" class="control-label col-sm-4">Rec. Qty(Bags) </label>
                     <div class="col-sm-8">
                        <input type="text" name="rec_qty" id="rec_qty" placeholder="Enter Receive Quantity" class="form-control" onchange="shortval();">
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-3">
                  <div class="form-group">
                     <label for="textfield" class="control-label col-sm-4">Receiving Date <span style="color: red">*</span></label>
                     <div class="col-sm-8">
                        <input type="date" name="rec_date" id="rec_date" placeholder="DD/MM/YYYY" value="<?php echo $currentdate; ?>" class="form-control">
                     </div>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label for="textfield" class="control-label col-sm-4">Unloading Place</label>
                     <div class="col-sm-8">
                        <input type="text" name="unloading_place" id="unloading_place" placeholder="Enter Place Name" class="form-control">
                     </div>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label for="textfield" class="control-label col-sm-4">Shortage MT/BAGS</label>
                     <div class="col-sm-8">
                        <input type="text" name="shortage" id="shortage" placeholder="0/0" class="form-control" readonly>
                     </div>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label for="textfield" class="control-label col-sm-4">Receiving Type </label>
                     <div class="col-sm-8">
                        <select name="receive_type" id="receive_type" class='form-control' onchange="shortval();">
                           <option value="">Select </option>
                           <option value="0">No Shortage</option>
                           <option value="1">Shortage </option>
                           <option value="2">Damage</option>
                        </select>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-3">
                  <div class="form-group">
                     <label for="textfield" class="control-label col-sm-4">Upload Rec.</label>
                     <div class="col-sm-8">
                        <input type="file" name="rec_img" id="rec_img" class="form-control">
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-12">
                  <div class="form-actions">
                     <center>
                        <a type="submit" onclick="getrecentry();" class="btn btn-primary">Update</a>
                        <a type="button" onclick="jQuery('#reciving').click();" class="btn btn-red">Cancel</a>
                     </center>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
<br />
</div>