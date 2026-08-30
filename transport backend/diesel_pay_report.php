<?php 
   error_reporting(0);
   include("adminsession.php");
   $tblname = "diesel_pay";
   $tblpkey = "dpayid";
   $pagename = "diesel_pay_report.php";
   $modulename = " Details";
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
   
  	
   
   if (isset($_GET['dbillid'])) {
   	$dbillid = trim(addslashes($_GET['dbillid']));
   } else
   	$dbillid = '';
   if (isset($_GET['pump_id'])) {
   	$pump_id = trim(addslashes($_GET['pump_id']));
   } else
   	$pump_id = '';
   
   if ($fromdate != '' && $todate != '') {
   	$crit .= "where rcv_date BETWEEN  '$fromdate' and  '$todate' ";
   	//echo $crit;
   }
   
   if ($dbillid != '') {
   	$crit .= " and dbillid='$dbillid'";
   }
     if ($pump_id != '') {
   	$crit .= " and pump_id='$pump_id'";
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
                              <i class="fa fa-list"></i>Diesel Payment Report
                           </h3>
                        </div> 
                        <div class="box-content nopadding" >
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
                                 <!-- 	<div class="col-sm-3">
                                    <div class="form-group">
                                    	<label for="textfield" class="control-label col-sm-4">Item <span style="color: red">*</span></label>
                                    	<div class="col-sm-8">
                                    <select name="item_id" id="item_id" class='select2-me' style="width:230px;" required>
                                    	<option value="">Select</option>
                                    <?php	$sql = mysqli_query($connection,"Select * from  m_item  order by item_id");
                                       while($row= mysqli_fetch_array($sql)) { ?>
                                     	
                                    <option value="<?php echo $row['item_id']; ?>"><?php echo $row['item_name']; ?></option>
                                    <?php } ?>
                                    
                                    </select>
                                    <script>document.getElementById('item_id').value = '<?php echo $item_id; ?>';</script>
                                    
                                    	</div>
                                    </div>
                                    
                                    </div> -->
                                 <div class="col-sm-3">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">Bill No.</label>
                                       <div class="col-sm-8">
                                          <select name="dbillid" id="dbillid" class='select2-me' style="width:100%;">
                                             <option value="">      Select  </option>
                                             <?php		$sql = mysqli_query($connection,"Select * from  dieselbill where sessionid=$session_id && consignorid=$consignorid order by dbillid");
                                                while($row= mysqli_fetch_array($sql)) { ?>
                                             <option value="<?php echo $row['dbillid']; ?>"><?php echo $row['dbillno']; ?></option>
                                             <?php } ?>
                                          </select>
                                          <script>document.getElementById('dbillid').value = '<?php echo $dbillid; ?>';</script>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-3">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">Pump Name.</label>
                                       <div class="col-sm-8">
                                          <select name="pump_id" id="pump_id" class='select2-me' style="width:100%;">
                                             <option value="">      Select  </option>
                                             <?php		$sql = mysqli_query($connection,"Select * from  m_petrol_pump  order by pump_id");
                                                while($row= mysqli_fetch_array($sql)) { ?>
                                             <option value="<?php echo $row['pump_id']; ?>"><?php echo $row['pump_name']; ?></option>
                                             <?php } ?>
                                          </select>
                                          <script>document.getElementById('pump_id').value = '<?php echo $pump_id; ?>';</script>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-sm-12">
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
                        <div class="box box-color box-bordered red">
                           <div class="box-title">
                              <h3>	<i class="fa fa-table"></i>
                                Diesel Payment List
                              </h3>
                              <!-- <a  href="billing.php" class="btn btn-warning" style="float: right">Click Here For New Entry
                              <i class="fa fa-object-group"></i>
                              </a> &nbsp;
                              <a href="pdf/pdf_invoice_entry.php" class="btn" style="float: right" target="_blank">Pdf 
                              <i class="fa fa-file-pdf-o"></i>
                              </a> &nbsp;
                              <a href="excel/excel_invoice_entry.php" class="btn btn-warning" style="float: right">Excel
                              <i class="fa fa-file-excel-o"></i>
                              </a>  -->
                           </div>
                           <div class="box-content nopadding">
                              <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
                                 <thead>
                                    <tr>
                                    <th>S.No</th>
                           <th>Bill No.</th>
                           <th>Paid Date</th>
                          <th>Pump Name</th> 
                           <th>Paid Amount</th>
                            <th>Payment Mode</th> 
                           <th>Remark</th>
                           <th>User Name</th>
                            <th>Print</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                  
                                 <?php
									$sn=1;
									// echo "Select * from  $tblname  order by $tblpkey desc limit 10" ;
				$sql = mysqli_query($connection,"Select * from  $tblname $crit && consignorid=$consignorid && sessionid=$session_id order by $tblpkey desc limit 10");
										  while($row= mysqli_fetch_array($sql)) {
                                 $invno = $cmn->getvalfield($connection,"dieselbill","dbillno","dbillid='$row[dbillid]'");
                                 	$pump_name = $cmn->getvalfield($connection,"m_petrol_pump","pump_name","pump_id='$row[pump_id]'"); 	
                                 		$mobile = $cmn->getvalfield($connection,"m_petrol_pump","mobile_no","pump_id='$row[pump_id]'"); 
                                       $user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
							   ?>
                                    <tr>
                                    <td><?php echo $sn++;?></td>
						
						<td><?php echo $invno; ?></td>
						<td><?php echo dateformatindia($row['rcv_date']); ?></td>
                   <td><?php echo $pump_name;?></td>
                  <td class='hidden-350'><?php echo $row['rcv_amt']; ?></td>
                   <td class='hidden-350'><?php echo $row['pay_mode']; ?></td>      
                  <td class='hidden-350'><?php echo $row['bill_remark']; ?></td>   
                  <td><?php echo $user_name; ?></td>
                         <td><a href= "pdf/pdf_dieselpay.php?dpayid=<?php echo $row['dpayid'];?>" class="btn btn-success" target="_blank">Print</a>
                           <a onclick="getwhatsapp('<?php echo $row['dpayid']; ?>','<?php echo $row['pump_id']; ?>','<?php echo $pump_name; ?>','<?php echo $mobile; ?>');" ><img src="img/whatsapp.png" style="width:30px;height:30px;">
                                          </a>
                                          <span style="color:#F00;width: 70px;font-weight:bold;padding-top: 5px;" id="msg<?php echo $row['dpayid']; ?>"></span>
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


    function funDel1(id)
         {    
              //alert(id);   
              tblname = 'invoicebilty';
               tblpkey = 'invoiceid';
               pagename  ='<?php echo $pagename; ?>';
               modulename  ='<?php echo $modulename; ?>';
              //alert(tblpkey); 
            if(confirm("Are you sure! You want to delete this record."))
            {
               $.ajax({
                 type: 'POST',
                 url: 'ajaxbill/deleteinvoice.php',
                 data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename,
                 dataType: 'html',
                 success: function(data){
                   // alert(data);
                   // alert('Data Deleted Successfully');
                    location=pagename+'?action=10';
                  }
               
                 });//ajax close
            }//confirm close
         } //fun close
         
             
function getwhatsapp(billid,owner_id,bill_name,mobile){
// alert(billid);
		jQuery.ajax({
			  type: 'POST',
			  url: 'pdf_dieselpay_whatsapp.php', 
			  data: 'billid='+billid,
			  dataType: 'html',
			  success: function(data){
			     // alert(data);
            getnum(billid,owner_id,bill_name,mobile);
				// sendfile(billid,bill_name,mobile);
				}
				
			  });//ajax close
}


function getnum(billid,owner_id,bill_name,mobile) {
// 	alert("ok");
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
            var type ="pump";
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