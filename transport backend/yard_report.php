<?php 
   error_reporting(0);
   include("adminsession.php");
   include("function/dispatch_function.php");
   $tblname = "yard_registration";
   $tblpkey = "registration_id";
   $pagename = "yard_report.php";
   $modulename = "Yard Report";
   $crit="";
   
   if(isset($_GET['search']))
   {
   	 $fromdate = $_GET['fromdate'];
    	$todate = $_GET['todate'];
   	
   }
   else
   {
   	// $fromdate = $currentdate;
   	// $todate = $currentdate;
   		$fromdate = date("Y-m-01");
	$todate = date('Y-m-d');
   
   }
   
   if (isset($_GET['item_id'])) {
   	$item_id = trim(addslashes($_GET['item_id']));
   } else
   	$item_id = '';
   	
   	
   

   	
   	 if (isset($_GET['driver_id'])) {
   	$driver_id = trim(addslashes($_GET['driver_id']));
   } else
   	$driver_id = '';
   
   if (isset($_GET['vehicle_id'])) {
   	$vehicle_id = trim(addslashes($_GET['vehicle_id']));
   } else
   	$vehicle_id = '';
    if (isset($_GET['consignee_id'])) {
   	$consignee_id = trim(addslashes($_GET['consignee_id']));
   } else
   	$consignee_id = '';
   
      	if (isset($_GET['is_voucher'])) {
	$is_voucher = trim(addslashes($_GET['is_voucher']));
} else
	$is_voucher= '';
	
	
   if ($fromdate != '' && $todate != '') {
   	$crit .= "where res_date BETWEEN  '$fromdate' and  '$todate' ";
   	//echo $crit;
   }
   
   if ($vehicle_id != '') {
       $vehicle_no =$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$vehicle_id");
   	$crit .= " and vehicle_no ='$vehicle_no'";
   }
   if ($item_id != '') {
   	$crit .= " and item_id='$item_id'";
   }
    if ($driver_id != '') {
   	$crit .= " and driver_id='$driver_id'";
   }
     if ($consignee_id != '') {
   	$crit .= " and consignee_id='$consignee_id'";
   }
   
      
if ($is_voucher != '') {
	
	$crit .= " and is_voucher='$is_voucher'";
}

if ($is_invoice != '') {
	
	$crit .= " and is_invoice='$is_invoice'";
}

if (isset($_GET['registration_id'])) {
   	$registration_id = trim(addslashes($_GET['registration_id']));
   } else
   	$registration_id = '';
   	
   	$sql = mysqli_query($connection, "UPDATE yard_registration SET is_asign = '1' WHERE registration_id = '$registration_id'");

if ($sql) {
    header("Location: " . $_SERVER['PHP_SELF']);
  
} else {
    echo "Error updating record: " . mysqli_error($connection);
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
      <title> ALL DISPATCH :: CHAARUVI INFOTECH PVT. LTD.</title>
      <?php include("inc/top-files.php"); ?>	
   </head>
   <body>
   <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width:480px;padding-top: 225px;" >


      <div class="modal-content" style="border-radius: 20px;">
        <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
          <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
          <center>
          <h4 class="modal-title"><b>Check Otp<b></h4></center>
        </div>
        <div class="modal-body" style="padding-top:30px;">
          <div class="row mb-3">
            <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Enter 4 Digit Code</label>
            <div class="col-sm-6">
			
              <input type="text" name="otp" id="otp"  class="form-control" placeholder="" required>
			  <input type="hidden" id="ref_id" value="" >
            </div>
          </div>
         <br>
         <input type="hidden" id="type" value="" >
		 
          <div class="modal-footer" >
          	<center>
            <button class="btn btn-primary" onClick="checkdispatchotp();" tabindex="12">Check</button>
            <a><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a></center>
          </div>
        </div>

      </div>
    </div>

  </div>
      <?php include("inc/model.php"); ?>
      <?php include("inc/top-header.php"); ?>
      <div class="container-fluid nav-hidden" id="content">
         <?php include("inc/left-menu.php"); ?>
         <div id="main">
            <div class="container-fluid">
               <?php include("inc/breadcrumbs.php"); ?>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="box box-bordered box-color satblue">
                        <div class="box-title">
                           <h3>
                              <i class="fa fa-list"></i>Yard Filter
                           </h3>
                        </div>
                        <div class="box-content nopadding">
                           <form action="#" method="GET" class='form-horizontal form-column form-bordered'>
                              <div class="row">
                                 <div class="col-sm-3">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">From Date <span style="color: red">*</span></label>
                                       <div class="col-sm-8">
                                          <input type="date" name="fromdate" id="fromdate" placeholder="Text input" class="form-control" value="<?php echo $fromdate; ?>" required>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-3">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">To Date <span style="color: red">*</span></label>
                                       <div class="col-sm-8">
                                          <input type="date" name="todate" id="todate" placeholder="Text input" class="form-control" value="<?php echo $todate; ?>" required>
                                       </div>
                                    </div>
                                 </div>
                                  	<div class="col-sm-3">
                                    <div class="form-group">
                                    	<label for="textfield" class="control-label col-sm-4">Driver </label>
                                    	<div class="col-sm-8">
                                    <select name="driver_id" id="driver_id" class='select2-me' style="width:100%;" >
                                    	<option value="">Select</option>
                                    <?php	$sql = mysqli_query($connection,"Select * from  m_driver  order by driver_id");
                                       while($row= mysqli_fetch_array($sql)) { ?>
                                     	
                                    <option value="<?php echo $row['driver_id']; ?>"><?php echo $row['driver_name']; ?></option>
                                    <?php } ?>
                                    
                                    </select>
                                    <script>document.getElementById('driver_id').value = '<?php echo $driver_id; ?>';</script>
                                    
                                    	</div>
                                    </div>
                                    
                                    </div>
                                 <div class="col-sm-3">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">Truck No.</label>
                                       <div class="col-sm-8">
                                          <select name="vehicle_id" id="vehicle_id" class='select2-me' style="width:100%;">
                                             <option value="">      Select  </option>
                                             <?php		$sql = mysqli_query($connection,"Select * from  m_vehicle  order by vehicle_id");
                                                while($row= mysqli_fetch_array($sql)) { ?>
                                             <option value="<?php echo $row['vehicle_id']; ?>"><?php echo $row['vehicle_no']; ?></option>
                                             <?php } ?>
                                          </select>
                                          <script>document.getElementById('vehicle_id').value = '<?php echo $vehicle_id; ?>';</script>
                                       </div>
                                    </div>
                                 </div>
                                 
                              </div>
                              <div class="row">
                                    
                                    
                           
                                 <div class="col-sm-9">
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
               <div class="box box-color box-bordered red" >
                           <div class="box-title">
                              <h3>	<i class="fa fa-table"></i>
                                 Yard Filter Report
                              </h3>
                              
                                <!--<a onclick="getwhatsapp1('<?php echo $fromdate; ?>','<?php echo $todate; ?>','<?php echo $vehicle_id; ?>','<?php echo $item_id; ?>','<?php echo $driver_id; ?>','<?php echo $consignee_id; ?>');" ><img src="img/whatsapp.png" style="width:30px;height:30px;">-->
                                <!--          </a>-->
                                <!--          <span style="color:#F00;width: 70px;font-weight:bold;padding-top: 5px;" id="msg1"></span>-->
                           </div>
                           <div class="box-content nopadding" style="overflow:scroll;">
                              <table class="table table-hover table-nomargin  table-bordered dataTable dataTable-colvis" >
                                 <thead>
                                    <tr>
                                       <th>S.No</th>
                                       <th> Date</th>
                                       <th >Truck No.</th>
                                      
                                       <th>Driver</th>
                                       
                                       <th>Location</th>
                                       <th>Remark</th>
                                       
                                       <th class='hidden-480'>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                  
                                       <?php
                                          $sn=1;
                                        //   echo		"Select * from  $tblname  $crit  && consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id order by $tblpkey desc";
                                    //   echo "Select * from  $tblname  $crit order by $tblpkey desc"; die;
                                          $sql = mysqli_query($connection,"Select * from  $tblname  $crit and is_asign='0' order by $tblpkey desc");
                                          	  while($row= mysqli_fetch_array($sql)) {
                                        
                                          $driver_name =$cmn->getvalfield($connection,"m_driver","driver_name","driver_id=$row[driver_id]");	
                                          
                                    
							
								
								$backgroundColor = ($countent > 1) ? 'background-color:grey;' : '';

                                          	   ?>
                                          	   	<tr style="<?php echo $backgroundColor; ?>">
                                    <!--<tr <?php if($row['checkbox']=='1') { ?> style="background-color:#ADD8E6;" <?php } ?>>-->
                                       <td><?php echo $sn++;?></td>
                                       <td><?php echo $row['res_date']; ?></td>
                                      
                                       <td><?php echo $row['vehicle_no']; ?></td>
                                      	<td><?php echo $driver_name; ?></td>
                                       
                                       
                                        <td><?php echo $row['location']; ?></td>
                                       
                                      <td><?php echo $row['remark']; ?></td>
                                       <td style="display:flex;justify-content:space-between;align-items:center;">
                                            <!--<input type="submit" name="assign" class="btn btn-warning" value="Assign">  -->
                                          <a href="?registration_id=<?php echo $row['registration_id']; ?>" class="btn btn-warning" rel="tooltip" title="Assign"target="_blank" >
                                          Assign </a>
                                          </td>
                                      
                                          <?php if($user_type=='admin'){ ?>
                                   
                                         
 
                                         
                                          <?php } ?>
                                         
                                    </tr>
                                    <?php } ?>
                                    
                                   	<tfoot>
					
					</tfoot>
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
      <div class="modal fade" id="myModal_whatsapp" role="dialog">
		<div class="modal-dialog" style="width:480px;padding-top: 225px;">


			<div class="modal-content" style="border-radius: 20px;">
				<div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
					<!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
					<center>
						<h4 class="modal-title"><b>Send Message<b></h4>
					</center>
				</div>
   
			<div class="modal-body" style="flex-wrap: wrap-reverse;display: flex;">
				<span style="color:#F00;" id="suppler_model_error"></span> 
				<table class="table table-condensed table-bordered">
					<tr>
						<th>Bill Name <span style="color:#F00;"> * </span> </th>
						<th>Contact No.</th>

					</tr>
					<tr>
						<td>
                            <input type="text" name="w_bill_name" id="w_bill_name" class="form-control" value="" style="font-weight:bold; " autocomplete="off" readonly>
                            <input type="hidden" name="w_owner_id" id="w_owner_id" class="form-control" value="" style="font-weight:bold; " autocomplete="off" readonly>

                           </td>

						<td>
                        <input type="number" name="w_mobile" id="w_mobile" placeholder="Mobile No" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" value="<?php echo $w_mobile; ?>" required>              
                 <!-- <input type="text" name="w_mobile" id="w_mobile" class="form-control" value="" style="font-weight:bold; " autocomplete="off"> -->
						<input type="hidden" name="w_billid" id="w_billid" class="form-control" value="" style="font-weight:bold; " autocomplete="off">
                    </td>


					</tr>
				
                 

					<tr>
                    <input type="checkbox" name="numupdate" id="numupdate" value="1"  style="width:18px;"/>  <span style="font-size:16px;margin-top:10px;"> &nbsp; Update Mobile Number</span>  
                    <!-- <input type="checkbox" id="layername1" name="layername" value="Drone Image" onclick="showLayerMap(1);"  /> -->
                    </tr>
				
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" name="s_save" id="s_save" onClick="sendfile();">Send</button>
				<button data-dismiss="modal" class="btn btn-danger">Close</button>
				<input type="hidden" id="s_saleid" value="">

			</div>
		</div>

    </div>
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
         
function getwhatsapp(billid,owner_id,bill_name,mobile){

		jQuery.ajax({
			  type: 'POST',
			  url: 'pdf_dispatch_printA5_whatsapp.php', 
			  data: 'billid='+billid,
			  dataType: 'html',
			  success: function(data){
            getnum(billid,owner_id,bill_name,mobile);
				// sendfile(billid,bill_name,mobile);
				}
				
			  });//ajax close
}


function getnum(billid,owner_id,bill_name,mobile) {
	
   jQuery('#myModal_whatsapp').modal('show');
   jQuery('#w_billid').val(billid);
      jQuery('#w_owner_id').val(owner_id);
      jQuery('#w_bill_name').val(bill_name);
      jQuery('#w_mobile').val(mobile);
   
}
  
  
        function sendfile(){

         var billid = document.getElementById('w_billid').value;
            var mobile = document.getElementById('w_mobile').value;
            var bill_name = document.getElementById('w_bill_name').value;
            var owner_id = document.getElementById('w_owner_id').value;
            var type ="owner";
            var bill_name = document.getElementById('w_bill_name').value;
            var numupdate = document.getElementById('numupdate');
         
  if (numupdate.checked == true){ 
   var upval='1';
  } else {
    var upval='0';
  }
            

if(mobile==''){
    alert("Please Enter Mobile No.");
    return false;
}
jQuery.ajax({
      type: 'POST',
      url: 'whatsapp.php',
      data: 'billid='+billid+'&mobile='+mobile+'&bill_name='+bill_name+'&owner_id='+owner_id+'&type='+type+'&upval='+upval,
      dataType: 'html',
      success: function(data){
// alert(data);
         jQuery("#myModal_whatsapp").modal('hide');
    document.getElementById('msg'+billid).innerHTML = 'Sent';
   
        }
        
      });//ajax close
}
      </script>
   </body>
</html>