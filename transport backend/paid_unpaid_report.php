<?php 
   error_reporting(0);
   include("adminsession.php");
   $tblname = "dispatch_entry";
   $tblpkey = "dispatch_id";
   $pagename = "paid_unpaid_report.php";
   $modulename = "Payment Entry";
   $crit="";
   
   if(isset($_GET['search']))
   {
   	 $fromdate = $_GET['fromdate'];
    	$todate = $_GET['todate'];
   	
   }
   else
   {
	$fromdate = date("Y-m-d", strtotime("-3 months"));
	$todate = date('Y-m-d');
   
   }
   
   if (isset($_GET['vehicle_id'])) {
   	$vehicle_id = trim(addslashes($_GET['vehicle_id']));
   } else
   	$vehicle_id = '';
   	
   
   if (isset($_GET['selectype'])) {
   	$selectype = trim(addslashes($_GET['selectype']));
   } else
   	$selectype = '';
   if (isset($_GET['owner_id'])) {
   $owner_id = trim(addslashes($_GET['owner_id']));
} else
   $owner_id = '';
   
   if ($fromdate != '' && $todate != '') {
   	$crit .= "where bilty_date BETWEEN  '$fromdate' and  '$todate' ";
   	//echo $crit;
   }
   
   if ($selectype != '') {
   	$crit .= " and is_complete='$selectype'";
   }
   if ($vehicle_id != '') {
   	$crit .= " and vehicle_id='$vehicle_id'";
   }
   if ($owner_id != '') {
   $crit .= " and owner_id='$owner_id'";
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
      <title> PAYMENT :: CHAARUVI INFOTECH PVT. LTD.</title>
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
                              <i class="fa fa-list"></i>Paid / Unpaid Report
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
                                       <label for="textfield" class="control-label col-sm-4">Select Type</label>
                                       <div class="col-sm-8">
                                         
                                                      		<select id="selectype" name="selectype" class="select2-me input-large" style="width:100%;">
                        <option value=""> - All - </option>
                      
                            <option value="1">Paid</option>
                            <option value="0">Unpaid</option>
                           
                       
                        </select>
                        <script>document.getElementById('selectype').value = '<?php echo $selectype; ?>';</script>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-3">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">Vehicle No</label>
                                       <div class="col-sm-8">
                                          <select name="vehicle_id" id="vehicle_id" class='select2-me' style="width:100%;">
                                             <option value="">      Select  </option>
                                             <?php	$sql = mysqli_query($connection,"Select * from  m_vehicle  order by vehicle_id");
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
                                  <div class="col-sm-4">
                                 <div class="form-group">
                                    <label for="textfield" class="control-label col-sm-4">Owner Name</label>
                                    <div class="col-sm-8">
                                       <select name="owner_id" id="owner_id" class='select2-me' style="width:100%;">
                                          <option value=""> Select </option>
                                          <?php $sql = mysqli_query($connection, "Select * from  m_vehicle_owner  order by owner_id");
                                          while ($row = mysqli_fetch_array($sql)) { ?>
                                             <option value="<?php echo $row['owner_id']; ?>"><?php echo $row['owner_name']; ?></option>
                                          <?php } ?>
                                       </select>
                                       <script>
                                          document.getElementById('owner_id').value = '<?php echo $owner_id; ?>';
                                       </script>
                                    </div>
                                 </div>
                              </div>
                                 <div class="col-sm-8">
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
                              Paid / Unpaid List
                              </h3>
                              <!--<a  href="dispatch-process.php" class="btn btn-warning" style="float: right">Click Here For New Entry-->
                              <!--<i class="fa fa-object-group"></i>-->
                              <!--</a> &nbsp;-->
                              <a href="pdf/pdf_paid_unpaid.php?fromdate=<?php echo $fromdate ?>&todate=<?php echo $todate ?>&selectype=<?php echo $selectype ?>&vehicle_id=<?php echo $vehicle_id ?>&owner_id=<?php echo $owner_id ?>" class="btn" style="float: right" target="_blank">Pdf 
                              <i class="fa fa-file-pdf-o"></i>
                              </a> &nbsp;
                              <a href="excel/excel_dispatch_entry.php?fromdate=<?php echo $fromdate ?>&todate=<?php echo $todate ?>&selectype=<?php echo $selectype ?>&vehicle_id=<?php echo $vehicle_id ?>&owner_id=<?php echo $owner_id ?>" class="btn btn-warning" style="float: right">Excel
                              <i class="fa fa-file-excel-o"></i>
                              </a> 
                              <a onclick="getwhatsapp('<?php echo $fromdate; ?>','<?php echo $todate; ?>','<?php echo $owner_id; ?>');"  style="float: right"><img src="img/whatsapp.png" style="width:30px;height:30px;">
                                          </a>
                           </div>
                           <div class="box-content nopadding" style="overflow:scroll;">
                              <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
                                 <thead>
                                    <tr>
                                       <th>S.No</th>
                                       <th>DI No.</th>
                                       <th>Bilty No.</th>
                                       <th class='hidden-350'>Bilty Date</th>
                                       <th>Consignor</th>
                                       <th>Consignee</th>
                                       <th class='hidden-1024'>Truck No.</th>
                                       <th>Owner Name</th>
                                       <th>Destination</th>
                                       <th>Item</th>
                                       <th>Weight/MT</th>
                                       
                                       <th>Own Rate</th>
                                           <th>Freight</th>
                                            <th>Voucher No</th>
											 <th>Status</th>
											 <th>Payment Date</th>
                                       <th>Paid To</th>
                                       <!--<th class='hidden-480'>Action</th>-->
                                    </tr>
                                 </thead>
                                 <tbody>
                                  
                                       <?php
                                          $sn=1;
                                        //   echo		"Select * from  $tblname  $crit  && consignor_id=$consignorid order by $tblpkey desc";
                                          $sql = mysqli_query($connection,"Select * from  $tblname  $crit  && consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id order by $tblpkey desc");
                                          	  while($row= mysqli_fetch_array($sql)) {
                                          $consignor_name=$cmn->getvalfield($connection,"m_consignor","consignor_name","consignor_id=$row[consignor_id]");
                                          $consignee_name=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id=$row[consignee_id]");
                                          $vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
                                          $destination=$cmn->getvalfield($connection,"m_place","place_name","place_id=$row[destination_id]");	
                                          $item_name=$cmn->getvalfield($connection,"m_item","item_name","item_id=$row[item_id]");				
                                              $owner_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$row[owner_id]");
                                     $is_voucher=$row['is_voucher'];
                                     $checkbox=$row['checkbox'];
                                   
                                     $is_complete = $row['is_complete'];
                                              	$voucher_id = $cmn->getvalfield($connection,"payment","voucher_id","dispatch_id='$row[dispatch_id]' && category_id='4'");
									$rate= $cmn->getvalfield($connection,"payment","freight_rate","dispatch_id='$row[dispatch_id]' && category_id='4'");
								if($is_complete=='0') { 
								    $status="Unpaid";
								    } else {
								      $status="Paid";
								    }
								     
								$payee_name = $cmn->getvalfield($connection,"payment","payee_name","voucher_id='$voucher_id' && consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id");
									$paydate = $cmn->getvalfield($connection,"payment_receive","receive_date","voucher_no='$voucher_id' && consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id");
                                               
                                          	   ?>
                                    <tr>
                                       <td><?php echo $sn++;?></td>
                                       <td><?php echo $row['di_no']; ?></td>
                                       <td><?php echo $row['bilty_no']; ?></td>
                                       <td><?php echo dateformatindia($row['bilty_date']); ?></td>
                                       <td><?php echo $consignor_name; ?></td>
                                       <td class='hidden-350'><?php echo $consignee_name; ?></td>
                                       <td class='hidden-1024'><?php echo $vehicle_no; ?></td>
                                         <td class='hidden-1024'><?php echo $owner_name; ?></td>
                                       <td class='hidden-1024'><?php echo $destination; ?></td>
                                       <td class='hidden-1024'><?php echo $item_name; ?></td>
                                       <td><?php echo $row['wt_mt']; ?></td>
                                       <!--<td><?php echo $row['qty']; ?></td>-->
                                       <td><?php echo $rate; ?></td>
                                         <td><?php echo number_format($row['wt_mt'] * $rate,2);?></td>
                                        
                                              <td><?php echo $voucher_id;?></td>
				                                <td><?php echo $status;?></td> 
				                                <td><?php echo dateformatindia($paydate);?></td>  <td><?php echo $payee_name;?></td> 
                                       <!--<td><b><a href="upload/bilty/<?php echo $row['bilty_scan'] ?>" class="text-danger"  target="_blank" download>Download</a></b></td>-->
                                       <!--<td class='hidden-480'>-->
                                       <!--   <a href="pdf/pdf_dispatch_printA4.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-warning" rel="tooltip" title="Builty A4"target="_blank" >-->
                                       <!--   <i class="fa fa-print">A4</i>-->
                                       <!--   <a href="pdf/pdf_dispatch_printA5.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-info" rel="tooltip" title="Builty A5" style="margin-left: 3px;" target="_blank">-->
                                       <!--   <i class="fa fa-print">A5</i>-->
                                       <!--   </a>-->
                                       <!--    <?php if($is_voucher=='0'){ ?>-->
                                       <!--        <a href="dispatch-process.php?editid=<?php echo $row['dispatch_id']; ?>" class="btn btn-inverse" rel="tooltip" title="Edit">-->
                                       <!--   <i class="fa fa-edit"></i>-->
                                       <!--   </a>-->
                                       <!--<?php } ?>-->
                                       <!--   <?php if($user_type=='admin'){ ?>-->
                                       <!--   <a href="dispatch-process.php?editid=<?php echo $row['dispatch_id']; ?>" class="btn btn-inverse" rel="tooltip" title="Edit">-->
                                       <!--   <i class="fa fa-edit"></i>-->
                                       <!--   </a>-->
                                          
                                       <!--   <a href="<?php echo $pagename ?>" onClick="funDel(<?php echo $row['dispatch_id']; ?>)" class="btn btn-danger" rel="tooltip" title="Delete">-->
                                       <!--   <i class="fa fa-times"></i>-->
                                       <!--   </a>-->
                                       <!--   <?php } ?>-->
                                       <!--</td>-->
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
						<input type="hidden" name="w_category" id="w_category" class="form-control" value="" style="font-weight:bold; " autocomplete="off" readonly>

                            <input type="text" name="w_bill_name" id="w_bill_name" class="form-control" value="" style="font-weight:bold; " autocomplete="off" >
                           

                           </td>

						<td>
                        <input type="number" name="w_mobile" id="w_mobile" placeholder="Mobile No" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" value="<?php echo $w_mobile; ?>" required>              
                 
                    </td>


					</tr>
				
                 

		
				
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" name="s_save" id="s_save" onClick="sendfile();">Send</button>
				<button data-dismiss="modal" class="btn btn-danger">Close</button>
				<input type="hidden" id="s_saleid" value="">

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
         
         function getwhatsapp(fromdate,todate,owner_id){

jQuery.ajax({
	  type: 'POST',
	  url: 'pdf_paid_unpaid_wp.php', 
	  data: 'fromdate='+fromdate+'&todate='+todate+'&owner_id='+owner_id,
	  
	  dataType: 'html',
	  success: function(data){
		jQuery('#myModal_whatsapp').modal('show');
		
		}
		
	  });
}

function sendfile(){
	var fromdate = document.getElementById('fromdate').value;
            var mobile = document.getElementById('w_mobile').value;
           
            var bill_name = document.getElementById('w_bill_name').value;


if(mobile==''){
    alert("Please Enter Mobile No.");
    return false;
}

jQuery.ajax({
type: 'POST',
url: 'whatsappreport.php',
data: 'mobile='+mobile+'&bill_name='+bill_name+'&fromdate='+fromdate,
dataType: 'html',
success: function(data){
    alert(data);
	jQuery("#myModal_whatsapp").modal('hide');
// document.getElementById('msg').innerHTML = 'Sent';

}

});//ajax close
}
         
      </script>
   </body>
</html>