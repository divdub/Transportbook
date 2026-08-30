<?php 
// error_reporting(0);
include("adminsession.php");
// include("function/dispatch_function.php");

$pagename = "owner_ledger_report.php";
$modulename = "Bilty Advance Details";

if(isset($_GET['fromdate'])) {
    $fromdate = $_GET['fromdate'];
  }
  else
  $fromdate=date('Y-m-d');

if(isset($_GET['todate'])) {
    $todate =$_GET['todate'];
  }
  else
  $todate=date('Y-m-d');
if(isset($_GET['owner_id'])) {
    $owner_id =$_GET['owner_id'];
  }
  else
  $owner_id='';



	

  $cond="";
  $cond2="";



if($fromdate !='' && $todate !='' ) {
  $cond .= "and voucher_date between '$fromdate' and '$todate' "; 
    $cond1 .= "and receive_date between '$fromdate' and '$todate' "; 
  
}

if($owner_id !='' ) {
  $cond .= "and catname='$owner_id'"; 
   	 $ownername = $cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id='$owner_id'");
   	 $mobile = $cmn->getvalfield($connection,"m_vehicle_owner","mobileno1","owner_id='$owner_id'");

    $cond1 .= "and catname='$owner_id'"; 
}


	 $currdate_str = strtotime($fromdate);
	
		$currdate = date('Y-m-d', strtotime('-1 day', strtotime($fromdate)));
   	//  $mobile = $cmn->getvalfield($connection,"m_session","session_start","session_id='$session_id'");
		      $payment = $cmn->getvalfield($connection,"payment","sum(amt_paid_to)","consignorid=$consignorid && comp_id=$comp_id && category_id=4  && voucher_date <= '$currdate' and catname='$owner_id'"); 
		      $payment_receive = $cmn->getvalfield($connection,"payment_receive","sum(receive_amt)","consignorid=$consignorid && comp_id=$comp_id && category=4  && receive_date <= '$currdate' and catname='$owner_id'"); 



		$curr_openingbal = $payment - $payment_receive ;

		








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

	<title> OWNER LEDGER REPORT  :: CHAARUVI INFOTECH PVT. LTD.</title>

<?php include("inc/top-files.php"); ?>	
</head>

<body>
	    <!-- Edit Modal Start-->
	<div class="modal fade" id="myModal9" role="dialog">
    <div class="modal-dialog" style="width:900px;padding-top: 150px;" >


      <div class="modal-content" style="border-radius: 20px;">
        <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
          <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
          <center>
          <h4 class="modal-title"><b>EDIT ADVANCE ENTRY<b></h4></center>
        </div>
        <div class="modal-body" style="padding-top:30px;" id="updatedata">
    
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
									<i class="fa fa-list"></i>Owner Ledger </h3>
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
                                       <label for="textfield" class="control-label col-sm-4">Owner Name</label>
                                       <div class="col-sm-8">
                                          <select name="owner_id" id="owner_id" class='select2-me' style="width:100%;">
                                             <option value="">      Select  </option>
                                             <?php		$sql = mysqli_query($connection,"Select * from  m_vehicle_owner  order by owner_id");
                                                while($row= mysqli_fetch_array($sql)) { ?>
                                             <option value="<?php echo $row['owner_id']; ?>"><?php echo $row['owner_name']; ?></option>
                                             <?php } ?>
                                          </select>
                                          <script>document.getElementById('owner_id').value = '<?php echo $owner_id; ?>';</script>
                                       </div>
                                    </div>
                                 </div>
										
  



                                        
										
										
								
										<div class="col-sm-3">
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
			<h3>			 <strong>Opening Balance:
			    <?php echo number_format($curr_openingbal,2);?>
			    </strong>	</h3>
				
			 <?php if($owner_id !=''){ ?> 
			 <a href="pdf_ownerledger.php?fromdate=<?php echo $fromdate ?>&todate=<?php echo $todate ?>&owner_id=<?php echo $owner_id ?>" class="btn btn-warning" style="float: right" target="_blank">Pdf
                              <i class="fa fa-file-pdf-o"></i>
                              </a> 
			  <a onclick="getwhatsapp('<?php echo $fromdate ?>','<?php echo $todate ?>','<?php echo $owner_id ?>','<?php echo $ownername ?>','<?php echo $mobile; ?>',<?php echo $vehicle_id; ?>);" ><img src="img/whatsapp.png" style="width:30px;height:30px;float: right">
                                          </a>
                                          <span style="color:#F00;width: 70px;font-weight:bold;padding-top: 5px;float: right;" id="msg"></span>
                              &nbsp;
                              <?php } ?>
                              
                           <!--     <a  style="float:right;  " href="pdf_comoany_cash_book.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>" target="_blank"> 

                               	<button class="btn btn-primary right" >PDF</button></a> -->
                          
				<!-- 	<button class="btn btn-warning" style="float: right">Click Hear For All Entry
											<i class="fa fa-object-group"></i>
										</button> &nbsp;
				 -->
				
				
				
			<!-- 	
			<a href="pdf/pdf_dispatch_advance.php" class="btn" style="float: right" target="_blank">Pdf 
											<i class="fa fa-file-pdf-o"></i>
										</a> &nbsp;
					<a href="excel/excel_dispatch_advance.php" class="btn btn-warning" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a> 	 -->
				
			</div>
			<div class="box-content nopadding">
					<div class="col-sm-6">
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-bar-chart-o"></i>
									Voucher Details 
								</h3>
							
							</div>
			    
                           
                           
                               
                                    <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
                                    	<thead>
					<tr>
					   <th>S.No</th>
							<th>Voucher Date</th>
						<th>Voucher No.</th>
						<th>Voucher Name</th>
						<th>Paid To</th>
					
						<th>Voucher Amount</th>
						
					
					</tr>
					</thead>
					<tbody>
					
					 <?php
									$sn=1;
// 			echo  "Select * from  payment  where consignorid=$consignorid && comp_id=$comp_id && category_id=4 $cond && session_id=$session_id GROUP BY voucher_id order by payment_id desc ";
				$sql = mysqli_query($connection,"Select * from  payment  where consignorid=$consignorid && comp_id=$comp_id && category_id=4 $cond && session_id=$session_id GROUP BY voucher_id order by payment_id desc ");
										  while($row= mysqli_fetch_array($sql)) {
	
$category=$row['category_id'];
if($category==1){
	$cname="Agent";
	
$agent_id=$cmn->getvalfield($connection,"dispatch_entry","agent_id","dispatch_id='$row[dispatch_id]'");
$vname=$cmn->getvalfield($connection,"m_agent","agent_name","agent_id='$agent_id'");
$catid=$agent_id;	
} 
if($category==2){
	$cname="Consignee";
	
$consignee_id=$cmn->getvalfield($connection,"dispatch_entry","consignee_id","dispatch_id='$row[dispatch_id]'");
$vname=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id='$consignee_id'");
$catid=$consignee_id;
} 
if($category==4) {
	$cname="Truck Owner";
	
$owner_id=$cmn->getvalfield($connection,"dispatch_entry","owner_id","dispatch_id='$row[dispatch_id]'");
$vname=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id='$owner_id'");
$catid=$owner_id;

}
$amt_paid_to=$cmn->getvalfield($connection,"payment","sum(amt_paid_to)","voucher_id='$row[voucher_id]' && consignorid=$consignorid && session_id=$session_id && comp_id=$comp_id ");
					  	
										   ?>
					<tr>
					<td><?php echo $sn++;?></td>
							<td><?php echo dateformatindia($row['voucher_date']); ?></td>
						<td><a href="pdf/pdf_voucher_report_A4.php?voucher_id=<?php echo $row['voucher_id']; ?>&category_id=4"  rel="tooltip" title="Voucher A5" style="margin-left: 3px;" target="_blank">
					<?php echo $row['voucher_id']; ?></a></td>
						
			
						<td><?php echo $vname; ?></td>
						<td><?php echo $row['payee_name']; ?>
					
					<td><?php echo $amt_paid_to; ?></td>
					
					</tr>
					
					<?php
						$netbilty += $amt_paid_to;
					} ?>
					</tbody>
                                        <tfoot class="bg-light-blue">
                                           <tr>
                                                                                                
                                                <th colspan="5" style="text-align:right">Total</th>                                                
                                                                                              
                                                <th  style="text-align:right"><i class="fa fa-inr"></i> <?php echo number_format(round($netbilty),2); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
</br></br>

                       

                        </div></div>
                        		<div class="col-sm-6">
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-bar-chart-o"></i>
									Voucher Payment
								</h3>
							</div>
			    
                           
                           
                               
                                    <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
                                       	<thead>
					<tr>
					<th>S.No</th>
				<th>Pay Date</th>
					<th>Voucher No.</th>
					<th>Voucher Name</th>
					<th>Paid To</th>
					<th>Slip No.</th>
					<th>Pay Amount.</th>
					
				
				
					</tr>
					</thead>
					<tbody>
					
					 <?php
									$sn=1;
							// echo		"Select * from  $tblname  $crit && consignorid=$consignorid order by $tblpkey desc";
				$sql = mysqli_query($connection,"Select * from  payment_receive   where category=4 && consignorid=$consignorid && comp_id=$comp_id $cond1 && session_id=$session_id order by pay_receive_id desc");
										  while($row= mysqli_fetch_array($sql)) {
										      	$paid_to=$cmn->getvalfield($connection,"payment","payee_name","voucher_id='$row[voucher_no]' && consignorid='$consignorid' && session_id=$session_id && comp_id=$comp_id ");
	
$category=$row['category'];
if($category==1){
	$cname="Agent";
	$voucher_no=$row['voucher_no'];
	
} 
if($category==2){
	$cname="Consignee";
$voucher_no=$row['voucher_no'];
	

} 
if($category==4) {
	$cname="Truck Owner";
	$voucher_no=$row['voucher_no'];

}

						  	
										   ?>
					<tr>
					<td><?php echo $sn++;?></td>
						<td><?php echo dateformatindia($row['receive_date']); ?></td>
						<td><?php echo $voucher_no; ?></td>
						<td><?php echo $row['voucher_name']; ?></td>
							<td><?php echo $paid_to; ?></td>
						<td><?php echo $row['rec_no']; ?></td>
					<td><?php echo $row['receive_amt']; ?></td>
				
				

					
					</tr>
					
					<?php 
						$gtotal += $row['receive_amt'];
					} ?>
					</tbody>
                                        <tfoot class="bg-light-blue">
                                           <tr>
                                                                                                
                                                <th colspan="6" style="text-align:right">Total</th>                                                
                                                                                              
                                                <th  style="text-align:right"><i class="fa fa-inr"></i> <?php echo number_format(round($gtotal),2); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
</br></br>

                       

                        </div></div>
                                  <?php $balamt =$curr_openingbal + $netbilty - $gtotal; 
					 ?>    
                    <table class="table" width="99%" border="1"   style="font-size:14px; margin-right: 10px; margin-left: 10px;" >
                        	<tr bgcolor="#CCCCCC">
                            	<td>&nbsp;   </td><td>&nbsp;   </td>
                            	<td align="right"><strong>Balance Amt : <i class="fa fa-inr"></i> <?php echo number_format(round($balamt),2); ?></strong></td>
                            </tr>
                           
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
						<!-- <input type="hidden" name="w_category" id="w_category" class="form-control" value="" style="font-weight:bold; " autocomplete="off" readonly> -->

                            <input type="text" name="w_bill_name" id="w_bill_name" class="form-control" value="" style="font-weight:bold; " autocomplete="off" readonly>
                            <!-- <input type="hidden" name="w_owner_id" id="w_owner_id" class="form-control" value="" style="font-weight:bold; " autocomplete="off" readonly> -->

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
	<script>
	   
	   function getwhatsapp(fromdate,todate,owner_id,bill_name,mobile){
	   
	   jQuery.ajax({
			type: 'POST',
			url: 'pdf_ownerledger_whatsapp.php', 
			data: 'fromdate='+fromdate+'&todate='+todate+'&owner_id='+owner_id
			,
			dataType: 'html',
			success: function(data){
			
			 // sendfile(vehicle_id,cat_id,bill_name,mobile);
			 // getnum(billid,category,owner_id,bill_name,mobile);
			 getnum(owner_id,bill_name,mobile);
  
			 }
			 
			});//ajax close
	   }
 
	   function getnum(owner_id,bill_name,mobile) {
	 
	 jQuery('#myModal_whatsapp').modal('show');
	 jQuery('#w_billid').val(owner_id);
	//  jQuery('#w_category').val(cat_id);
	// 	jQuery('#w_owner_id').val(catname);
		jQuery('#w_bill_name').val(bill_name);
		jQuery('#w_mobile').val(mobile);
	 
  }
 
	   function sendfile(){
		  var billid = document.getElementById('w_billid').value;
		  var owner_id = document.getElementById('w_billid').value;
			 var mobile = document.getElementById('w_mobile').value;
			 var bill_name = document.getElementById('w_bill_name').value;
			 var numupdate = document.getElementById('numupdate');
			 var type ="owner";
			 
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
		  jQuery("#myModal_whatsapp").modal('hide');
	   document.getElementById('msg').innerHTML = 'Sent';
	   
	   }
	   
	   });//ajax close
	   }
	   </script>	
</body>



</html>
