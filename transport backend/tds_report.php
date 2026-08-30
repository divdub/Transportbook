<?php 
// error_reporting(0);
include("adminsession.php");
// include("function/dispatch_function.php");
$tblname = "payment";
$tblpkey = "payment_id";
$pagename = "tds_report.php";
$modulename = " Details";
$crit='';
if(isset($_GET['search']))
{
	 $fromdate = $_GET['fromdate'];
 	$todate = $_GET['todate'];
	$paid_to = $_GET['paid_to'];
}
else
{
	$fromdate = $currentdate;
	$todate = $currentdate;

}

if (isset($_GET['paid_to'])) {
    $paid_to = urldecode($_GET['paid_to']);
} else{
    $paid_to = '';
}

if ($fromdate != '' && $todate != '') {
	$crit .= "where voucher_date BETWEEN  '$fromdate' and  '$todate' ";
	//echo $crit;
}

if ($paid_to != '') {
    $crit .= " and payee_name='$paid_to'";
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
	    <!-- Edit Modal Start-->
	<div class="modal fade" id="myModal10" role="dialog">
    <div class="modal-dialog" style="width:900px;padding-top: 150px;" >


      <div class="modal-content" style="border-radius: 20px;">
        <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
          <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
          <center>
          <h4 class="modal-title"><b>EDIT RECEIVE ENTRY<b></h4></center>
        </div>
        <div class="modal-body" style="padding-top:30px;" id="recdata">
    
        </div>

      </div>
    </div>

  </div>
  <!-- Edit Modal End-->


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
									<i class="fa fa-list"></i>TDS Report</h3>
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
												<label for="textfield" class="control-label col-sm-4">Paid To </label>
												<div class="col-sm-8">
												<select name="paid_to" id="paid_to" class='select2-me' style="width:210px;">
                                                        <option value=""> Select  </option>
                                                        <?php

                                                        $sql = mysqli_query($connection, "Select * from paid_to ORDER BY payee_id ");
                                                        while ($row = mysqli_fetch_array($sql)) { ?>

                                                            <option value="<?php echo $row['payee_name']; ?>"><?php echo $row['payee_name']; ?></option>
                                                        <?php } ?>

                                                    </select>
                                                    <script>
                                                        document.getElementById('paid_to').value = '<?php echo $paid_to; ?>';
                                                    </script>
                                                    
												</div>
											</div>
										
										</div>
										
	<!-- 									<div class="col-sm-3">
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
										       <div class="col-sm-3" style="display:none;">
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
										<div class="col-sm-3" style="display:none;">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Owner Name</label>
												<div class="col-sm-8">
												<select name="owner_id" id="owner_id" class='select2-me' style="width:100%;">
								<option value="">      Select  </option>
		<?php	$sql = mysqli_query($connection,"Select * from  m_vehicle_owner  order by owner_id");
										  while($row= mysqli_fetch_array($sql)) { ?>
				<option value="<?php echo $row['owner_id']; ?>"><?php echo $row['owner_name']; ?></option>
								<?php } ?>

											</select>
			<script>document.getElementById('owner_id').value = '<?php echo $owner_id; ?>';</script>
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
					TDS List</h3>
				
		
				<!-- 	<button class="btn btn-warning" style="float: right">Click Hear For All Entry
											<i class="fa fa-object-group"></i>
										</button> &nbsp;
				 -->
				
				
				
		 		
			<a href="pdf/pdf_tds.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&paid_to=<?php echo $paid_to ?>" class="btn" style="float: right" target="_blank">Pdf 
											<i class="fa fa-file-pdf-o"></i>
										</a> &nbsp;
					<a href="excel/excel_tds.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&paid_to=<?php echo $paid_to ?>" class="btn btn-warning" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a> 
										<a onclick="getwhatsapp('<?php echo $fromdate; ?>','<?php echo $todate; ?>','<?php echo $paid_to; ?>');"  style="float: right"><img src="img/whatsapp.png" style="width:30px;height:30px;">
                                          </a>
				
			</div>
			<div class="box-content nopadding"  style="overflow:scroll;">
				<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
					<thead>
					<tr>
					<th>S.No</th>
						<th>DI/LR No.</th>
                                            <th>Bilty Date</th>
                                        	 <th>Paid To</th>
                                        	 <!--<th>Payee Name</th>-->
                                              <th>Destination</th>
                                              <th>Truck Owner</th>
                                              <th>Truck No</th>
                      						<th>Pan No.</th>
                                          <th>Freight Amount</th>
                                          	<th>Paid Amount</th>

                                            <th>TDS Amount</th>
					</tr>
					</thead>
					<tbody>
					
					 <?php
									$sn=1;
				// 			echo		"Select * from  $tblname  $crit && is_receive=1 && consignor_id=$consignorid order by $tblpkey desc";
				$sql = mysqli_query($connection,"Select * from  $tblname  $crit  && tds_amt!=0  && consignorid=$consignorid order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
	$di_no=$cmn->getvalfield($connection,"dispatch_entry","di_no","dispatch_id=$row[dispatch_id]");
		$bilty_date=$cmn->getvalfield($connection,"dispatch_entry","bilty_date","dispatch_id=$row[dispatch_id]");
			$destination_id=$cmn->getvalfield($connection,"dispatch_entry","destination_id","dispatch_id=$row[dispatch_id]");
				$owner_id=$cmn->getvalfield($connection,"dispatch_entry","owner_id","dispatch_id=$row[dispatch_id]");
		   $owner_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$owner_id");
		   	$vehicle_id=$cmn->getvalfield($connection,"dispatch_entry","vehicle_id","dispatch_id=$row[dispatch_id]");
		   $vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$vehicle_id");
		   $place_name=$cmn->getvalfield($connection,"m_place","place_name","place_id=$destination_id");
			$wt_mt=$cmn->getvalfield($connection,"dispatch_entry","wt_mt","dispatch_id=$row[dispatch_id]");
				$comp_rate=$cmn->getvalfield($connection,"dispatch_entry","comp_rate","dispatch_id=$row[dispatch_id]");
				$amt=$comp_rate*$wt_mt;
			$tds_amt=	$row['tds_amt'];
										   ?>
					<tr>
					<td><?php echo $sn++;?></td>
						<td><?php echo $di_no; ?></td>
						<td><?php echo dateformatindia($bilty_date); ?></td>
						
					
						<!--<td><?php echo $row['paid_to']; ?></td>-->
						<td><?php echo $row['payee_name']; ?></td>
							<td><?php echo $place_name; ?></td>
						<td><?php echo $owner_name; ?></td>
						<td><?php echo $vehicle_no; ?></td>
								<td><?php echo $row['panno']; ?></td>
				
					<td><?php echo $amt; ?></td>
						<td><?php echo number_format(round(($row['amt_paid_to']),2)); ?></td>
						
					<td><?php echo $tds_amt; ?></td>
		
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
	<script>
    function getwhatsapp(fromdate,todate,paid_to){

jQuery.ajax({
	  type: 'POST',
	  url: 'pdf_tds_whatsapp.php', 
	  data: 'fromdate='+fromdate+'&todate='+todate+'&paid_to='+paid_to,
	  
	  dataType: 'html',
	  success: function(data){
	   //   alert(data);
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
	jQuery("#myModal_whatsapp").modal('hide');
document.getElementById('msg').innerHTML = 'Sent';

}

});//ajax close
}
</script>
</body>



</html>
