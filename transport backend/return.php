<?php 
   error_reporting(0);
   include("adminsession.php");
   include("function/return_function.php");
   $tblname = "trip_entry";
   $tblpkey = "trip_id";
   $pagename = "return.php";
   $modulename = "Return Entry";
   $duplicate='';
   if (isset($_GET['action'])) {
       $action = $_GET['action'];
   } else {
       $action = "";
   }
   if (isset($_GET['editid'])) {
       $keyvalue = $_GET['editid'];
   } else {
       $keyvalue = 0;
   }
   if(isset($_GET['editid']) != "")
   {
   	 $keyvalue = test_input($_GET['editid']);
   	$sql = mysqli_query($connection,"select * from $tblname where $tblpkey='$keyvalue'");
   	$row = mysqli_fetch_array($sql);
   	 $loding_date = $row['loding_date']; 
   	$trip_no 	 = $row['trip_no'];
   	$item_id    = $row['item_id'];
   	$billing_type=$row['billing_type'];
   	$consignor_id=$row['consignor_id'];
   	$consignee_id=$row['consignee_id'];
   	$fromplaceid=$row['fromplaceid'];
   	$toplaceid=$row['toplaceid'];
   	$vehicle_id=$row['vehicle_id'];
   	$unit_id=$row['unit_id'];
   	$qty_mt_day_trip=$row['qty_mt_day_trip'];
   	$rate=$row['rate'];
   	$frieght_amt=$row['frieght_amt'];
   	$cash_advance=$row['cash_advance'];
   	$diesel_advance=$row['diesel_advance'];
   	$net_amount=$row['net_amount'];
   	$unloading_place=$row['unloading_place'];
   	$unloading_date=$row['unloading_date'];
	   $consignor_adv=$row['consignor_adv'];
	   $office_adv=$row['office_adv'];
	   $remark=$row['remark'];
   	}
   else
   {
	$consignor_adv='';
	$office_adv='';
	$remark='';
   	$loding_date = '';
   	$trip_no  = '';
   	$item_id='';
   	$rate='';
   	$fromplaceid='';
   	$consignor_id='';
   	$toplaceid='';
   	$consignee_id='';
   	$unit_id='1';
   	$vehicle_id='';
   	$qty_mt_day_trip='';
   	$rate='';
   	$billing_type='Consignor';
   	$frieght_amt=' ';
   	$cash_advance='';
   	$diesel_advance='';
   	$net_amount='';
   	$unloading_place='';
   	$unloading_date='';
   }
   if(isset($_POST['submit']))
   {
   	  $loding_date = $_POST['loding_date'];
   	 $trip_no =$_POST['trip_no'];
   	$item_id = $_POST['item_id'];
   	$rate = $_POST['rate'];
   	$consignor_id = $_POST['consignor_id'];
   	$fromplaceid = $_POST['fromplaceid'];
       $consignee_id = $_POST['consignee_id'];
   	$toplaceid = $_POST['toplaceid'];
   	$vehicle_id = $_POST['vehicle_id'];
   	$frieght_amt = $_POST['frieght_amt'];
   	$cash_advance = $_POST['cash_advance'];
   	$diesel_advance = $_POST['diesel_advance'];
   	$billing_type = $_POST['billing_type'];
   	 $net_amount = $_POST['net_amount']; 
		$consignor_adv = $_POST['consignor_adv']; 
		$office_adv = $_POST['office_adv']; 
		$remark = $_POST['remark']; 
   	$unloading_place=$_POST['unloading_place'];
   	$unloading_date = $_POST['unloading_date'] ; 
   	$qty_mt_day_trip = $_POST['qty_mt_day_trip'] ; 
   $unit_id = $_POST['unit_id'] ; 
   
   	$form_data = array('loding_date'=>$loding_date,'office_adv'=>$office_adv,'consignor_adv'=>$consignor_adv,'remark'=>$remark,'trip_no'=>$trip_no,'item_id'=>$item_id,'rate'=>$rate,'consignor_id'=>$consignor_id,'fromplaceid'=>$fromplaceid,'consignee_id'=>$consignee_id,'toplaceid'=>$toplaceid,'vehicle_id'=>$vehicle_id,'frieght_amt'=>$frieght_amt,'cash_advance'=>$cash_advance,'diesel_advance'=>$diesel_advance,'billing_type'=>$billing_type,'net_amount'=>$net_amount,'unloading_place'=>$unloading_place,'unloading_date'=>$unloading_date,'qty_mt_day_trip'=>$qty_mt_day_trip,'unit_id'=>$unit_id,'sessionconsignor_id'=>$consignorid,'comp_id'=>$comp_id,'session_id'=>$session_id,'created_date'=>$currentdate);
   	 
   	if($keyvalue  == 0)
   	{
   	$count = check_duplicate($connection,$tblname,"trip_no='$trip_no'");
   		if($count == 0)
   		{
   			dbRowInsert($connection,$tblname, $form_data);
   	      
   			echo "<script>location='$pagename?action=1'</script>";
   		}
   		else
   		{
   			$duplicate = "ERROR: Duplicate Record...";
   		}
   	}
   	
   	else
   	{
   // echo "'loding_date'=>$loding_date,'trip_no'=>$trip_no,'item_id'=>$item_id,'rate'=>$rate,'consignor_id'=>$consignor_id,'fromplaceid'=>$fromplaceid,'consignee_id'=>$consignee_id,'toplaceid'=>$toplaceid,'vehicle_id'=>$vehicle_id,'frieght_amt'=>$frieght_amt,'cash_advance'=>$cash_advance,'diesel_advance'=>$diesel_advance,'billing_type'=>$billing_type,'net_amount'=>$net_amount,'unloading_place'=>$unloading_place,'unloading_date'=>$unloading_date,'qty_mt_day_trip'=>$qty_mt_day_trip,'unit_id'=>$unit_id,'sessionconsignor_id'=>$consignorid,'comp_id'=>$comp_id,'session_id'=>$session_id,'updated_date'=>$currentdate "; die;   
   		$form_data = array('loding_date'=>$loding_date,'office_adv'=>$office_adv,'consignor_adv'=>$consignor_adv,'remark'=>$remark,'trip_no'=>$trip_no,'item_id'=>$item_id,'rate'=>$rate,'consignor_id'=>$consignor_id,'fromplaceid'=>$fromplaceid,'consignee_id'=>$consignee_id,'toplaceid'=>$toplaceid,'vehicle_id'=>$vehicle_id,'frieght_amt'=>$frieght_amt,'cash_advance'=>$cash_advance,'diesel_advance'=>$diesel_advance,'billing_type'=>$billing_type,'net_amount'=>$net_amount,'unloading_place'=>$unloading_place,'unloading_date'=>$unloading_date,'qty_mt_day_trip'=>$qty_mt_day_trip,'unit_id'=>$unit_id,'sessionconsignor_id'=>$consignorid,'comp_id'=>$comp_id,'session_id'=>$session_id,'updated_date'=>$currentdate);
   		dbRowUpdate($connection,$tblname, $form_data, "$tblpkey='$keyvalue'");
   	
   		echo "<script>location='$pagename?action=2'</script>";
   	}
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
      <title>RETURN :: CHAARUVI INFOTECH PVT. LTD.</title>
      <?php include("inc/top-files.php"); ?>	
   </head>
   <body>
      <!-- Place Modal Start-->
      <div class="modal fade" id="myModal7" role="dialog">
         <div class="modal-dialog" style="width:480px;padding-top: 225px;" >
            <div class="modal-content" style="border-radius: 20px;">
               <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
                  <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
                  <center>
                     <h4 class="modal-title"><b>ADD NEW PLACE<b></h4>
                  </center>
               </div>
               <div class="modal-body" style="padding-top:30px;">
                  <div class="row mb-3">
                     <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">PLACE NAME</label>
                     <div class="col-sm-6">
                        <input type="text" name="place_name" id="place_name"  class="form-control" placeholder="" required>
                     </div>
                  </div>
                  <br>
                  <div class="row mb-3">
                     <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">STATE NAME</label>
                     <div class="col-sm-6">
                        <select name="state_id" id="state_id" class='form-control' required>
                           <option value="">      Select  </option>
                           <?php	$sql = mysqli_query($connection,"Select * from  m_state  order by state_id ");
                              while($row= mysqli_fetch_array($sql)) { ?>
                           <option value="<?php echo $row['state_id']; ?>"><?php echo $row['state_name']; ?></option>
                           <?php } ?>
                        </select>
                     </div>
                  </div>
                  <br>
                  <div class="modal-footer" >
                     <center>
                        <button class="btn btn-primary" onClick="save_place();" tabindex="12"> Save</button>
                        <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a>
                     </center>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Place Modal End-->
      <!-- Driver Modal Start-->
      <div class="modal fade" id="myModal6" role="dialog">
         <div class="modal-dialog" style="width:480px;padding-top: 225px;" >
            <div class="modal-content" style="border-radius: 20px;">
               <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
                  <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
                  <center>
                     <h4 class="modal-title"><b>ADD NEW DRIVER<b></h4>
                  </center>
               </div>
               <div class="modal-body" style="padding-top:30px;">
                  <div class="row mb-3">
                     <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">DRIVER NAME</label>
                     <div class="col-sm-6">
                        <input type="text" name="driver_name" id="driver_name"  class="form-control" placeholder="" required>
                     </div>
                  </div>
                  <br>
                  <div class="row mb-3">
                     <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">MOBILE NO.</label>
                     <div class="col-sm-6">
                        <input type="number" name="mobile_no" id="mobile_no"  class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" required>
                     </div>
                  </div>
                  <br>
                  <div class="modal-footer" >
                     <center>
                        <button class="btn btn-primary" onClick="save_driver();" tabindex="12"> Save</button>
                        <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a>
                     </center>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Driver Modal End-->
      <!-- Vehicle Modal Start-->
      <div class="modal fade" id="myModal5" role="dialog">
         <div class="modal-dialog" style="width:480px;padding-top: 225px;" >
            <div class="modal-content" style="border-radius: 20px;">
               <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
                  <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
                  <center>
                     <h4 class="modal-title"><b>ADD NEW VEHICLE<b></h4>
                  </center>
               </div>
               <div class="modal-body" style="padding-top:30px;">
                  <div class="row mb-3">
                     <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">VEHICLE NO.</label>
                     <div class="col-sm-6">
                        <input type="text" name="vehicle_no" id="vehicle_no"  class="form-control" placeholder="" required>
                     </div>
                  </div>
                  <br>
                  <div class="row mb-3">
                     <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">OWNER NAME  <span class="badge shtcutbtn"><a class="shtcut" onClick="jQuery('#Modal5').modal('show');">+</a></span> </label>
                     <div class="col-sm-6">
                        <select name="owner_id" id="owner_id" class='form-control' required>
                           <option value="">      Select  </option>
                           <?php	$sql = mysqli_query($connection,"Select * from  m_vehicle_owner  order by owner_id ");
                              while($row= mysqli_fetch_array($sql)) { ?>
                           <option value="<?php echo $row['owner_id']; ?>"><?php echo $row['owner_name']; ?></option>
                           <?php } ?>
                        </select>
                     </div>
                  </div>
                  <br>
                  <div class="row mb-3" style="display:none;">
                     <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">AGENT NAME </label>
                     <div class="col-sm-6">
                        <select name="agent_id" id="agent_id" class='form-control' required>
                           <option value="">      Select  </option>
                           <?php	$sql = mysqli_query($connection,"Select * from  m_agent  order by agent_id ");
                              while($row= mysqli_fetch_array($sql)) { ?>
                           <option value="<?php echo $row['agent_id']; ?>"><?php echo $row['agent_name']; ?></option>
                           <?php } ?>
                        </select>
                     </div>
                  </div>
                  <br>
                  <div class="row mb-3">
                     <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">VEHICLE TYPE </label>
                     <div class="col-sm-6">
                        <select name="vehicle_type_id" id="vehicle_type_id" class='form-control' required>
                           <option value="">      Select  </option>
                           <?php	$sql = mysqli_query($connection,"Select * from  m_vehicle_type  order by vehicle_type_id ");
                              while($row= mysqli_fetch_array($sql)) { ?>
                           <option value="<?php echo $row['vehicle_type_id']; ?>"><?php echo $row['no_of_wheels']; ?> - <?php echo $row['vehicle_type']; ?></option>
                           <?php } ?>
                        </select>
                     </div>
                  </div>
                  <br>
                  <div class="modal-footer" >
                     <center>
                        <button class="btn btn-primary" onClick="save_vehicle();" tabindex="12"> Save</button>
                        <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a>
                     </center>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Vehicle Modal End-->
      <!-- Owner Modal Start-->
      <div class="modal fade" id="Modal5" role="dialog">
         <div class="modal-dialog" style="width:480px;padding-top: 225px;" >
            <div class="modal-content" style="border-radius: 20px;">
               <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
                  <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
                  <center>
                     <h4 class="modal-title"><b>ADD NEW OWNER<b></h4>
                  </center>
               </div>
               <div class="modal-body" style="padding-top:30px;">
                  <div class="row mb-3">
                     <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Owner Name</label>
                     <div class="col-sm-6">
                        <input type="text" name="owner_name" id="owner_name"  class="form-control" placeholder="" required>
                     </div>
                  </div>
                  <br>
                  <div class="row mb-3">
                     <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Mobile No.</label>
                     <div class="col-sm-6">
                        <input type="text" name="mobileno1" id="mobileno1"  class="form-control" placeholder="" required>
                     </div>
                  </div>
                  <br>
                  <div class="modal-footer" >
                     <center>
                        <button class="btn btn-primary" onClick="save_owner();" tabindex="12"> Save</button>
                        <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a>
                     </center>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Owner Modal End-->
      <!-- Brand Modal Start-->
      <div class="modal fade" id="myModal4" role="dialog">
         <div class="modal-dialog" style="width:480px;padding-top: 225px;" >
            <div class="modal-content" style="border-radius: 20px;">
               <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
                  <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
                  <center>
                     <h4 class="modal-title"><b>ADD NEW BRAND<b></h4>
                  </center>
               </div>
               <div class="modal-body" style="padding-top:30px;">
                  <div class="row mb-3">
                     <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">BRAND NAME</label>
                     <div class="col-sm-6">
                        <input type="text" name="brand_name" id="brand_name"  class="form-control" placeholder="" required>
                     </div>
                  </div>
                  <br>
                  <div class="modal-footer" >
                     <center>
                        <button class="btn btn-primary" onClick="save_brand();" tabindex="12"> Save</button>
                        <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a>
                     </center>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Brand Modal End-->
      <!-- Item Modal Start-->
      <div class="modal fade" id="myModal3" role="dialog">
         <div class="modal-dialog" style="width:480px;padding-top: 225px;" >
            <div class="modal-content" style="border-radius: 20px;">
               <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
                  <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
                  <center>
                     <h4 class="modal-title"><b>ADD NEW ITEM<b></h4>
                  </center>
               </div>
               <div class="modal-body" style="padding-top:30px;">
                  <div class="row mb-3">
                     <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">ITEM NAME</label>
                     <div class="col-sm-6">
                        <input type="text" name="item_name" id="item_name"  class="form-control" placeholder="" required>
                     </div>
                  </div>
                  <br>
                  <div class="row mb-3">
                     <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">CATEGORY NAME </label>
                     <div class="col-sm-6">
                        <select name="item_category_id" id="item_category_id" class='form-control' required>
                           <option value="">      Select Category </option>
                           <?php	$sql = mysqli_query($connection,"Select * from  m_item_category  order by item_category_id ");
                              while($row= mysqli_fetch_array($sql)) { ?>
                           <option value="<?php echo $row['item_category_id']; ?>"><?php echo $row['category_name']; ?></option>
                           <?php } ?>
                        </select>
                     </div>
                  </div>
                  <br>
                  <div class="row mb-3">
                     <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">UNIT </label>
                     <div class="col-sm-6">
                        <select name="unit_id" id="unit_id" class='form-control' required>
                           <option value="">      Select Unit </option>
                           <?php	$sql = mysqli_query($connection,"Select * from  m_unit  order by unit_id ");
                              while($row= mysqli_fetch_array($sql)) { ?>
                           <option value="<?php echo $row['unit_id']; ?>"><?php echo $row['unit_name']; ?></option>
                           <?php } ?>
                        </select>
                     </div>
                  </div>
                  <br>
                  <div class="modal-footer" >
                     <center>
                        <button class="btn btn-primary" onClick="save_item();" tabindex="12"> Save</button>
                        <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a>
                     </center>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Item Modal End-->
      <!-- Consignor Modal Start-->
      <div class="modal fade" id="myModal2" role="dialog">
         <div class="modal-dialog" style="width:480px;padding-top: 225px;" >
            <div class="modal-content" style="border-radius: 20px;">
               <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
                  <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
                  <center>
                     <h4 class="modal-title"><b>ADD NEW CONSIGNOR<b></h4>
                  </center>
               </div>
               <div class="modal-body" style="padding-top:30px;">
                  <div class="row mb-3">
                     <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">CONSIGNOR NAME</label>
                     <div class="col-sm-6">
                        <input type="text" name="consignor_name" id="consignor_name"  class="form-control" placeholder="" required>
                     </div>
                  </div>
                  <br>
                  <div class="row mb-3">
                     <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">MOBILE NO.</label>
                     <div class="col-sm-6">
                        <input type="number" name="mobile_no" id="mobile_no"  class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10">
                     </div>
                  </div>
                  <br>
                  <div class="modal-footer" >
                     <center>
                        <button class="btn btn-primary" onClick="save_consignor();" tabindex="12"> Save</button>
                        <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a>
                     </center>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Consignor Modal End-->
      <!-- Consignee Modal Start-->
      <div class="modal fade" id="myModal1" role="dialog">
         <div class="modal-dialog" style="width:480px;padding-top: 225px;" >
            <div class="modal-content" style="border-radius: 20px;">
               <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
                  <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
                  <center>
                     <h4 class="modal-title"><b>ADD NEW CONSIGNEE<b></h4>
                  </center>
               </div>
               <div class="modal-body" style="padding-top:30px;">
                  <div class="row mb-3">
                     <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">CONSIGNEE NAME</label>
                     <div class="col-sm-6">
                        <input type="text" name="consignee_name" id="consignee_name"  class="form-control" placeholder="" required>
                     </div>
                  </div>
                  <br>
                  <div class="row mb-3">
                     <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">MOBILE NO.</label>
                     <div class="col-sm-6">
                        <input type="number" name="mobile_no" id="mobile_no"  class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10">
                     </div>
                  </div>
                  <br>
                  <div class="modal-footer" >
                     <center>
                        <button class="btn btn-primary" onClick="save_consignee();" tabindex="12"> Save</button>
                        <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a>
                     </center>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Consignee Modal End-->
      <?php include("inc/model.php"); ?>
      <?php include("inc/top-header.php"); ?>
      <div class="container-fluid nav-hidden" id="content">
         <?php include("inc/left-menu.php"); ?>
         <div id="main">
            <div class="container-fluid">
               <?php include("inc/breadcrumbs.php"); ?>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="box box-bordered box-color satblue" >
                        <div class="box-title">
                           <h3>
                              <i class="fa fa-bars"></i>Return
                           </h3>
                        </div>
                        <div class="box-content nopadding">
                           <ul class="tabs tabs-inline tabs-top">
                              <li class='active'>
                                 <a id="return" data-toggle='tab'>
                                 <i class="fa fa-inbox"></i>Trip Entry</a>
                              </li>
                              <li>
                                 <a id="report" data-toggle='tab' style="background: #fab750; color: #000000">
                                 <i class="fa fa-share"></i>Trip Report</a>
                              </li>
                              <li>
                                 <a id="pay" data-toggle='tab'>
                                 <i class="fa fa-tag"></i>Payment Entry</a>
                              </li>
                              <li>
                                 <a id="payreport" data-toggle='tab' style="background: #fab750; color: #000000">
                                 <i class="fa fa-share"></i>Payment Report</a>
                              </li>
                              <!-- 	<li>
                                 <a id="reciving" data-toggle='tab'>
                                 	<i class="fa fa-tag"></i>Receiving Entry</a>
                                 </li>
                                 <li>
                                 <a id="rcreport" data-toggle='tab' style="background: #fab750; color: #000000">
                                 	<i class="fa fa-share"></i>Receiving Report</a>
                                 </li> -->
                           </ul>
                           <div class="tab-content padding tab-content-inline tab-content-bottom" id="main1" >
                              <div class="tab-pane active" id="first11">
                                 <div class="col-sm-12">
                                    <div class="row" style="padding-top:20px;">
                                       <div class="col-sm-12">
                                          <?php if($duplicate!='') { ?>
                                          <div class="alert alert-warning" >
                                             <button data-dismiss="alert" class="close" type="button">×</button>
                                             <strong><i class="fa fa-clone"></i> Warning! The value you entered is already in the list. </strong> 
                                          </div>
                                          <?php } ?>
                                          <?php include("inc/alert.php"); ?>
                                       </div>
                                    </div>
                                    <div class="box box-bordered box-color">
                                       <div class="box-title">
                                          <h3><i class="fa fa-list"></i>Trip Entry</h3>
                                       </div>
                                       <div class="box-content nopadding" >
                                          <form action="#" method="POST" class='form-horizontal form-column form-bordered' enctype="multipart/form-data">
                                             <div class="row">
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Loading Date<span style="color: red">*</span></label>
                                                      <div class="col-sm-8">
                                                         <input type="date" name="loding_date" id="loding_date" placeholder="Text input"  class="form-control" value="<?php echo $loding_date; ?>" required>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Trip No./LR No.</label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="trip_no" id="trip_no" placeholder="Enter Trip No./LR No."  class="form-control" value="<?php echo $trip_no; ?>" required>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Item </label>
                                                      <div class="col-sm-8">
                                                         <select name="item_id" id="item_id" class='select2-me' style="width:100%;">
                                                            <option value="">      Select  </option>
                                                            <?php	$sql = mysqli_query($connection,"Select * from  m_item  order by item_id");
                                                               while($row= mysqli_fetch_array($sql)) { ?>
                                                            <option value="<?php echo $row['item_id']; ?>"><?php echo $row['item_name']; ?></option>
                                                            <?php } ?>
                                                         </select>
                                                         <script>document.getElementById('item_id').value = '<?php echo $item_id; ?>';</script>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Consignor <span style="color: red">*</span> </label>
                                                      <div class="col-sm-8">
                                                         <select name="consignor_id" id="consignor_id" class='select2-me' style="width:100%;" required >
                                                            <option value="">      Select  </option>
                                                            <?php	$sql = mysqli_query($connection,"Select * from  m_party where p_type='consignor' order by party_id");
                                                               while($row= mysqli_fetch_array($sql)) { ?>
                                                            <option value="<?php echo $row['party_id']; ?>"><?php echo $row['party_name']; ?></option>
                                                            <?php } ?>
                                                         </select>
                                                         <script>document.getElementById('consignor_id').value = '<?php echo $consignor_id; ?>';</script>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Consignee </label>
                                                      <div class="col-sm-8">
                                                         <select name="consignee_id" id="consignee_id" class='select2-me' style="width:100%;">
                                                            <option value="">      Select  </option>
                                                            <?php	$sql = mysqli_query($connection,"Select * from  m_party where p_type='consignee' order by party_id");
                                                               while($row= mysqli_fetch_array($sql)) { ?>
                                                            <option value="<?php echo $row['party_id']; ?>"><?php echo $row['party_name']; ?></option>
                                                            <?php } ?>
                                                         </select>
                                                         <script>document.getElementById('consignee_id').value = '<?php echo $consignee_id; ?>';</script>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">
                                                      Party Billing Type</label>
                                                      <div class="col-sm-8">
                                                         <select data-placeholder="Choose a Country..." name="billing_type" id="billing_type"   style="width:100%" class="formcent select2-me" required>
                                                            <option value="">Select</option>
                                                            <option value="Consignor">Consignor</option>
                                                            <option value="Consignee">Consignee</option>
                                                            <script>	document.getElementById('billing_type').value = '<?php echo $billing_type; ?>';</script>
                                                         </select>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">From Place </label>
                                                      <div class="col-sm-8">
                                                         <select name="fromplaceid" id="fromplaceid" class='select2-me' style="width:100%;">
                                                            <option value="">      Select  </option>
                                                            <?php	$sql = mysqli_query($connection,"Select * from  m_place  order by place_id");
                                                               while($row= mysqli_fetch_array($sql)) { ?>
                                                            <option value="<?php echo $row['place_id']; ?>"><?php echo $row['place_name']; ?></option>
                                                            <?php } ?>
                                                         </select>
                                                         <script>document.getElementById('fromplaceid').value = '<?php echo $fromplaceid ; ?>';</script>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Destination </label>
                                                      <div class="col-sm-8">
                                                         <select name="toplaceid" id="toplaceid" class='select2-me' style="width:100%;">
                                                            <option value="">      Select  </option>
                                                            <?php	$sql = mysqli_query($connection,"Select * from  m_place  order by place_id");
                                                               while($row= mysqli_fetch_array($sql)) { ?>
                                                            <option value="<?php echo $row['place_id']; ?>"><?php echo $row['place_name']; ?></option>
                                                            <?php } ?>
                                                         </select>
                                                         <script>document.getElementById('toplaceid').value = '<?php echo $toplaceid; ?>';</script>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Truck No </label>
                                                      <div class="col-sm-8">
                                                         <select name="vehicle_id" id="vehicle_id" class='select2-me' style="width:100%;"  required>
                                                            <option value="">      Select  </option>
                                                            <?php		
                                                               $sql = mysqli_query($connection,"Select vehicle_id,vehicle_no from  m_vehicle  LEFT JOIN m_vehicle_owner ON m_vehicle.owner_id = m_vehicle_owner.owner_id where owner_type='Self'");
                                                               						  while($row= mysqli_fetch_array($sql)) { 
                                                               	
                                                               
                                                               
                                                               						  	?>
                                                            <option value="<?php echo $row['vehicle_id']; ?>"><?php echo $row['vehicle_no']; ?></option>
                                                            <?php }
                                                               ?>
                                                         </select>
                                                         <script>document.getElementById('vehicle_id').value = '<?php echo $vehicle_id; ?>';</script>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4"> Billing Unit</label>
                                                      <div class="col-sm-8">
                                                         <select name="unit_id" id="unit_id" class='select2-me' style="width:100%;">
                                                         
                                                            <?php	$sql = mysqli_query($connection,"Select * from  m_unit  order by unit_id");
                                                               while($row= mysqli_fetch_array($sql)) { ?>
                                                            <option value="<?php echo $row['unit_id']; ?>"><?php echo $row['unit_name']; ?></option>
                                                            <?php } ?>
                                                              <script>document.getElementById('unit_id').value = '<?php echo $unit_id; ?>';</script>
                                                         </select>
                                                        
                                                         <!--<script>document.getElementById('unit_id').value = '<?php echo $unit_id; ?>';</script>-->
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">Qty/MT/DayTrip  <span style="color: red">*</span></label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="qty_mt_day_trip" id="qty_mt_day_trip" placeholder="Enter Weight" class="form-control" value="<?php echo $qty_mt_day_trip; ?>" required onchange="getTotal();">
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4"> Rate </label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="rate" id="rate" placeholder="Enter Company Rate" class="form-control" value="<?php echo $rate; ?>" onchange="getTotal();">
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4"> Freight Amt </label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="frieght_amt" id="frieght_amt" placeholder="Enter Own Rate" class="form-control" value="<?php echo $frieght_amt; ?>" readonly >
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">
                                                      Cash Advance </label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="cash_advance" id="cash_advance" placeholder="Text input" class="form-control" value="<?php echo $cash_advance; ?>" onchange="getTotal();">
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">
                                                      Diesel Advance  </label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="diesel_advance" id="diesel_advance" placeholder="Text input" class="form-control" value="<?php echo $diesel_advance; ?>" onchange="getTotal();">
                                                      </div>
                                                   </div>
                                                </div>
												<div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">
                                                      Consignor Advance  </label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="consignor_adv" id="consignor_adv" placeholder="Text input" class="form-control" value="<?php echo $consignor_adv; ?>" onchange="getTotal();">
                                                      </div>
                                                   </div>
                                                </div>
												</div>
                                             <div class="row">
												<div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">
                                                      Office Advance  </label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="office_adv" id="office_adv" placeholder="Text input" class="form-control" value="<?php echo $office_adv; ?>" >
                                                      </div>
                                                   </div>
                                                </div>
											
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">
                                                      Net Amount  </label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="net_amount" id="net_amount" placeholder="Text input" class="form-control" value="<?php echo $net_amount; ?>" readonly>
                                                      </div>
                                                   </div>
                                                </div>
                                            
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">
                                                      Unloading Place </label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="unloading_place" id="unloading_place" placeholder="Enter Place Name" class="form-control" value="<?php echo $unloading_place; ?>">
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">
                                                      Unloading date </label>
                                                      <div class="col-sm-8">
                                                         <input type="date" name="unloading_date" id="unloading_date" placeholder="Enter Remark" class="form-control" value="<?php echo $unloading_date; ?>">
                                                      </div>
                                                   </div>
                                                </div>
												</div>
                                             <div class="row">
												<div class="col-sm-3">
                                                   <div class="form-group">
                                                      <label for="textfield" class="control-label col-sm-4">
                                                      Remark  </label>
                                                      <div class="col-sm-8">
                                                         <input type="text" name="remark" id="remark" placeholder="Text input" class="form-control" value="<?php echo $remark; ?>" >
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-sm-12">
                                                   <div class="form-actions">
                                                      <center>
                                                         <input type="submit" name="submit" id="submit" value="Save" class="btn btn-primary">
                                                         <a type="button" href="<?php echo $pagename; ?>"class="btn btn-red">Cancel</a>
                                                      </center>
                                                   </div>
                                                </div>
                                             </div>
                                          </form>
                                       </div>
                                       <div class="box box-color box-bordered red">
                                          <div class="box-title">
                                             <h3>	<i class="fa fa-table"></i>
                                                Recent Trip Details
                                             </h3>
                                             <a href="trip_report.php" class="btn btn-warning" style="float: right">Click Here For All Entry
                                             <i class="fa fa-object-group"></i>
                                             </a> &nbsp;
                                             <!-- <a href="all-dispatch-entry.php" style="text-align: right" target="_blank">All Record</a> -->
                                              		
                                                <a href="pdf/pdf_return_entry.php" class="btn" style="float: right" target="_blank">Pdf 
                                                								<i class="fa fa-file-pdf-o"></i>
                                                							</a> &nbsp;
                                                		<a href="excel/excel_return_entry.php" class="btn btn-warning" style="float: right">Excel
                                                								<i class="fa fa-file-excel-o"></i>
                                                							</a>  
                                          </div>
                                          <div class="box-content nopadding">
                                             <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
                                                <thead>
                                                   <tr>
                                                      <th>S.No</th>
                                                      <th>Trip No.</th>
                                                      <th>Truck No.</th>
                                                      <th class='hidden-350'>Loading Date</th>
                                                      <th>Consignor</th>
                                                      <th>Consignee</th>
                                                      <!-- <th class='hidden-1024'>Truck No.</th> -->
                                                      <th>Destination</th>
                                                      <!-- <th>Item</th> -->
                                                      <th>Weight/MT</th>
                                                      <!-- <th>Qty (Bags)</th> -->
                                                      <th>Company Rate</th>
                                                       <th>Cash Adv</th>	 
                                                       <th>Diesel Adv</th>
                                                       <th>Consignor Adv</th>
                                                        <th>Office Adv</th>
                                                      <th class='hidden-480'>Action</th>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                   <?php
                                                      $sn=1;
                                                      $sql = mysqli_query($connection,"Select * from  $tblname where sessionconsignor_id=$consignorid && session_id=$session_id order by $tblpkey desc limit 10");
                                                      	  while($row= mysqli_fetch_array($sql)) {
                                                      $consignor_name=$cmn->getvalfield($connection,"m_party","party_name","party_id=$row[consignor_id]");
                                                      $consignee_name=$cmn->getvalfield($connection,"m_party","party_name","party_id=$row[consignee_id]");
                                                      $vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
                                                      $destination=$cmn->getvalfield($connection,"m_place","place_name","place_id=$row[toplaceid]");	
                                                      // $item_name=$cmn->getvalfield($connection,"m_item","item_name","item_id=$row[item_id]");								  	
                                                      // 										   ?>
                                                   <tr>
                                                      <td><?php echo $sn++;?></td>
                                                      <td><?php echo $row['trip_no']; ?></td>
                                                      <td class='hidden-1024'><?php echo $vehicle_no; ?></td>
                                                      <td><?php echo dateformatindia($row['loding_date']); ?></td>
                                                      <td><?php echo $consignor_name; ?></td>
                                                      <td class='hidden-350'><?php echo $consignee_name; ?></td>
                                                      <td class='hidden-1024'><?php echo $destination; ?></td>
                                                      <!-- <td class='hidden-1024'><?php echo $item_name; ?></td> -->
                                                      <td><?php echo $row['qty_mt_day_trip']; ?></td>
                                                      <!-- <td><?php echo $row['qty']; ?></td> -->
                                                      <td><?php echo $row['rate']; ?></td>
                                                       <td><?php echo $row['cash_advance']; ?></td>
                                                        <td><?php echo $row['diesel_advance']; ?></td>
                                                         <td><?php echo $row['consignor_adv']; ?></td>
                                                          <td><?php echo $row['office_adv']; ?></td>
                                                      <!-- <td><b><a href="upload/bilty/<?php echo $row['bilty_scan'] ?>" class="text-danger"  target="_blank" download>Download</a></b></td> -->
                                                      <td class='hidden-480'>
                                                         <!-- 	<a href="pdf/pdf_dispatch_printA4.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-warning" rel="tooltip" title="Builty A4"target="_blank" >
                                                            <i class="fa fa-print">A4</i>
                                                            <a href="pdf/pdf_dispatch_printA5.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-info" rel="tooltip" title="Builty A5" style="margin-left: 3px;" target="_blank">
                                                            <i class="fa fa-print">A5</i>
                                                            </a> -->
                                                         <a href="?editid=<?php echo $row['trip_id']; ?>" class="btn btn-inverse" rel="tooltip" title="Edit">
                                                         <i class="fa fa-edit"></i>
                                                         </a>
                                                         <a href="<?php echo $pagename ?>" onClick="funDel(<?php echo $row['trip_id']; ?>)" class="btn btn-danger" rel="tooltip" title="Delete">
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
                                    <br/>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script type="text/javascript" language="javascript">
         $(document).ready(function() { /// Wait till page is loaded
            $('#return').click(function(){
               $('#main1').load('return.php #main1', function() {
               	jQuery('.select2-me').select2();
               	 // jQuery("#advtable").html(data);
         
                    /// can add another function here
               });
            });
         }); //// End of Wait till page is loaded
      </script>
      <script type="text/javascript" language="javascript">
         $(document).ready(function() { /// Wait till page is loaded
            $('#pay').click(function(){
               $('#main1').load('trip_pay.php #main', function() {
               	jQuery('.select2-me').select2();
               	 jQuery('#consignor_show').hide();
          jQuery('#shhide').show();
           jQuery('#consignee_show').hide();
             });
          
            });
         }); //// End of Wait till page is loaded
      </script>
      <script type="text/javascript" language="javascript">
         $(document).ready(function() { /// Wait till page is loaded
            $('#report').click(function(){
             location = 'trip_report.php'; 
            });
         }); //// End of Wait till page is loaded
      </script>
      <script type="text/javascript" language="javascript">
         $(document).ready(function() { /// Wait till page is loaded
            $('#payreport').click(function(){
             location = 'trip_payment_report.php'; 
            });
         }); //// End of Wait till page is loaded
      </script>
      <script type="text/javascript">
         function funDel(id) {
         // alert(id);
             var tablename = '<?php echo $tblname ?>';
             var tableid = '<?php echo $tblpkey ?>';
             if (confirm("Do You want to Delete this record ?")) {
                 // alert(tableid);
                 jQuery.ajax({
                     type: 'POST',
                     url: 'ajax/delete_master.php',
                     data: 'id=' + id + '&tablename=' + tablename + '&tableid=' + tableid,
                     dataType: 'html',
                     success: function(data) {
                         location = '<?php echo $pagename ?>?action=3';
         
                     }
                 }); //ajax close
             }
         }
         
      </script>
   </body>
</html>