<?php 
   error_reporting(0);
   include("adminsession.php");
   include("function/dispatch_function.php");
   $tblname = "x_party_entry";
   $tblpkey = "di_id";
   $pagename = "all-x-party-entry.php";
   $modulename = "X-Party Entry";
   $crit="";
   
   if(isset($_GET['search']))
   {
   	 $fromdate = $_GET['fromdate'];
    	$todate = $_GET['todate'];
   	
   }
   else
   {
   	$fromdate = $currentdate;
   	$todate = $currentdate;
   	
   
   }
   
   if (isset($_GET['item_id'])) {
   	$item_id = trim(addslashes($_GET['item_id']));
   } else
   	$item_id = '';
   	
   	 if (isset($_GET['brand_id'])) {
   	$brand_id = trim(addslashes($_GET['brand_id']));
   } else
   	$brand_id = '';
   
   if (isset($_GET['vehicle_id'])) {
   	$vehicle_id = trim(addslashes($_GET['vehicle_id']));
   } else
   	$vehicle_id = '';
    if (isset($_GET['xconsignee_id'])) {
   	$xconsignee_id = trim(addslashes($_GET['xconsignee_id']));
   } else
   	$xconsignee_id = '';
   
   
   if ($fromdate != '' && $todate != '') {
   	$crit .= "where bilty_date BETWEEN  '$fromdate' and  '$todate' ";
   	//echo $crit;
   }
   
   if ($vehicle_id != '') {
   	$crit .= " and vehicle_id='$vehicle_id'";
   }
   if ($item_id != '') {
   	$crit .= " and item_id='$item_id'";
   }
    if ($brand_id != '') {
   	$crit .= " and brand_id='$brand_id'";
   }
     if ($xconsignee_id != '') {
   	$crit .= " and xconsignee_id='$xconsignee_id'";
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
      <title> ALL X_PARTY :: CHAARUVI INFOTECH PVT. LTD.</title>
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
                              <i class="fa fa-list"></i>X-Party Filter
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
                                 <div class="col-sm-2">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">To Date <span style="color: red">*</span></label>
                                       <div class="col-sm-8">
                                          <input type="date" name="todate" id="todate" placeholder="Text input" class="form-control" value="<?php echo $todate; ?>" required>
                                       </div>
                                    </div>
                                 </div>
                                  	<div class="col-sm-2">
                                    <div class="form-group">
                                    	<label for="textfield" class="control-label col-sm-4">Brand </label>
                                    	<div class="col-sm-8">
                                    <select name="brand_id" id="brand_id" class='select2-me' style="width:100%;" >
                                    	<option value="">Select</option>
                                    <?php	$sql = mysqli_query($connection,"Select * from  m_brand  order by brand_id");
                                       while($row= mysqli_fetch_array($sql)) { ?>
                                     	
                                    <option value="<?php echo $row['brand_id']; ?>"><?php echo $row['brand_name']; ?></option>
                                    <?php } ?>
                                    
                                    </select>
                                    <script>document.getElementById('brand_id').value = '<?php echo $brand_id; ?>';</script>
                                    
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
                                 <div class="col-sm-2">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">Item Name</label>
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
                              </div>
                              <div class="row">
                                     <div class="col-sm-3">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">Consignee Name</label>
                                       <div class="col-sm-8">
                                          <select name="xconsignee_id" id="xconsignee_id" class='select2-me' style="width:100%;">
                                             <option value="">      Select  </option>
                                             <?php	$sql = mysqli_query($connection,"Select * from  m_x_consignee  order by xconsignee_id");
                                                while($row= mysqli_fetch_array($sql)) { ?>
                                             <option value="<?php echo $row['xconsignee_id']; ?>"><?php echo $row['xconsignee_name']; ?></option>
                                             <?php } ?>
                                          </select>
                                          <script>document.getElementById('xconsignee_id').value = '<?php echo $xconsignee_id; ?>';</script>
                                       </div>
                                    </div>
                                 </div>
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
                                 X-Party  Filter List
                              </h3>
                              <a  href="x_party_entry.php" class="btn btn-warning" style="float: right">Click Here For New Entry
                              <i class="fa fa-object-group"></i>
                              </a> &nbsp;
                              <!--<a href="pdf/pdf_dispatch_entry.php?fromdate=<?php echo $fromdate ?>&todate=<?php echo $todate ?>&vehicle_id=<?php echo $vehicle_id ?>&item_id=<?php echo $item_id ?>&brand_id=<?php echo $brand_id ?>&consignee_id=<?php echo $consignee_id ?>" class="btn" style="float: right" target="_blank">Pdf -->
                              <!--<i class="fa fa-file-pdf-o"></i>-->
                              <!--</a> &nbsp;-->
                              <!--<a href="excel/excel_dispatch_entry.php?fromdate=<?php echo $fromdate ?>&todate=<?php echo $todate ?>&vehicle_id=<?php echo $vehicle_id ?>&item_id=<?php echo $item_id ?>&brand_id=<?php echo $brand_id ?>&consignee_id=<?php echo $consignee_id ?>" class="btn btn-warning" style="float: right">Excel-->
                              <!--<i class="fa fa-file-excel-o"></i>-->
                              <!--</a> -->
                                <!--<a onclick="getwhatsapp1('<?php echo $fromdate; ?>','<?php echo $todate; ?>','<?php echo $vehicle_id; ?>','<?php echo $item_id; ?>','<?php echo $brand_id; ?>','<?php echo $consignee_id; ?>');" ><img src="img/whatsapp.png" style="width:30px;height:30px;">-->
                                <!--          </a>-->
                                <!--          <span style="color:#F00;width: 70px;font-weight:bold;padding-top: 5px;" id="msg1"></span>-->
                           </div>
                           <div class="box-content nopadding" style="overflow:scroll;">
                              <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
                                 <thead>
                                    <tr>
                                       <th>S.No</th>
                                       <th>DI No.</th>
                                       <th class='hidden-350'>Bilty Date</th>
                                       <th>Consignor</th>
                                       <th>Consignee</th>
                                       <th class='hidden-1024'>Truck No.</th>
                                       <th>Owner Name</th>
                                       <th>Item</th>
                                       <th>Brand</th>
                                       <th>Weight/MT</th>
                                       <th>Qty (Bags)</th>
                                       <th class='hidden-480'>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    $sn = 1;
                    // echo  "SELECT * FROM $tblname $crit consignor_id=$consignorid AND comp_id=$comp_id AND session_id=$session_id  ORDER BY bilty_date DESC LIMIT 10";
                                    $sql = mysqli_query($connection, "SELECT * FROM $tblname $crit and consignor_id=$consignorid AND comp_id=$comp_id AND session_id=$session_id  ORDER BY bilty_date DESC ");
                                    while ($row = mysqli_fetch_array($sql)) {
                                       $consignor_name = $cmn->getvalfield($connection, "m_consignor", "consignor_name", "consignor_id={$row['consignor_id']}");
                                       $consignee_name = $cmn->getvalfield($connection, "m_x_consignee", "xconsignee_name", "xconsignee_id={$row['xconsignee_id']}");
                                       $vehicle_no = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id={$row['vehicle_id']}");
                                       $owner_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$row[owner_id]");
                                       $item_name = $cmn->getvalfield($connection, "m_item", "item_name", "item_id={$row['item_id']}");
                                       $brand_name=$cmn->getvalfield($connection,"m_brand","brand_name","brand_id=$row[brand_id]");	
                                     
                                    ?>
                                    <tr>
                                       <td><?php echo $sn++; ?></td>
                                       <td><?php echo htmlspecialchars($row['di_no']); ?></td>
                                       <td><?php echo dateformatindia($row['bilty_date']); ?></td>
                                       <td><?php echo htmlspecialchars($consignor_name); ?></td>
                                       <td class='hidden-350'><?php echo htmlspecialchars($consignee_name); ?></td>
                                       <td class='hidden-1024'><?php echo htmlspecialchars($vehicle_no); ?></td>
                                       <td class='hidden-1024'><?php echo $owner_name; ?></td>
                                       <td><?php echo htmlspecialchars($item_name); ?></td>
                                       <td class='hidden-1024'><?php echo $brand_name; ?></td>
                                       <td><?php echo $row['wt_mt']; ?></td>
                                       <td><?php echo $row['qty']; ?></td>
                                       <td class='hidden-480'>
                                             <!--<a href="pdf/pdf_xparty_printA4.php?di_id=<?php echo $row['di_id']; ?>" class="btn btn-warning" rel="tooltip" title="Builty A4" target="_blank">-->
                                             <!--   <i class="fa fa-print"></i> A4-->
                                             <!--</a>-->
                                             <a href="pdf/pdf_xparty_printA5.php?di_id=<?php echo $row['di_id']; ?>" class="btn btn-info" rel="tooltip" title="Builty A5" style="margin-left:3px;" target="_blank">
                                                <i class="fa fa-print"></i> A5
                                             </a>

                                             <?php if ($user_type == 'admin') { ?>
                                                <a href="x_party_entry.php?editid=<?php echo $row['di_id']; ?>" class="btn btn-inverse" rel="tooltip" title="Edit">
                                                   <i class="fa fa-edit"></i>
                                                </a>
                                             <?php } ?>

                                             <?php if ($user_type == 'admin') { ?>
                              <button class="btn btn-danger" 
                                    onclick="funDel('<?php echo $row['di_id']; ?>')" 
                                    rel="tooltip" 
                                    title="Delete">
                                 <i class="fa fa-times"></i>
                              </button>
                           <?php } ?>

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