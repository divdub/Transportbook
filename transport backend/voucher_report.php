<?php 
error_reporting(0);
include("adminsession.php");
 include("function/payment_function.php");
$tblname = "payment";
$tblpkey = "payment_id";
$pagename = "voucher_report.php";
$modulename = "Voucher Report";
$crit='';
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

if (isset($_GET['cat_id'])) {
	$category_id = trim(addslashes($_GET['cat_id']));
} else
	$category_id = '';

if (isset($_GET['payee_name'])) {
	$payee_name = trim(addslashes($_GET['payee_name']));
} else
	$payee_name = '';

if (isset($_GET['is_paid'])) {
	$is_paid = trim(addslashes($_GET['is_paid']));
} else
	$is_paid = '';
	
	if (isset($_GET['is_approve'])) {
   	$is_approve = trim(addslashes($_GET['is_approve']));
   } else
   	$is_approve = '';
   	
   	if (isset($_GET['user_id'])) {
   	$user_id = trim(addslashes($_GET['user_id']));
   } else
   	$user_id = '';
   

if ($fromdate != '' && $todate != '') {
	$crit .= "where voucher_date BETWEEN  '$fromdate' and  '$todate' ";
	//echo $crit;
}

if ($category_id != '') {
	
	$crit .= " and category_id='$category_id'";
}


if ($payee_name != '') {
	$crit .= " and payee_name='$payee_name' ";
//   $cat_name=$cmn->getvalfield($connection,"m_agent","agent_name","agent_id=$catname");

}
// if ($catname != '' && $category_id == 2) {
// 	$crit .= " and catname='$catname' ";
//   $cat_name=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id=$catname");
// }
// if ($catname != '' && $category_id == 4) {
//       $crit .= " and catname='$catname' ";
// 	  $cat_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$catname");
// }

if ($is_paid != '') {

	$crit .= " and is_paid='$is_paid'";
}

if ($is_approve != '') {
   	$crit .= " and is_approve='$is_approve'";
   }
   if ($user_id != '') {
   	$crit .= " and approved_by='$user_id'";
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

	<title> ALL VOUCHER :: CHAARUVI INFOTECH PVT. LTD.</title>

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
            <button class="btn btn-primary" onClick="checkotp();" tabindex="12">Check</button>
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
									<i class="fa fa-list"></i>Voucher Report</h3>
							</div>
							<div class="box-content nopadding">
								<form action="#" method="GET" class='form-horizontal form-column form-bordered'>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">From Date <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="date" name="fromdate" id="fromdate" placeholder="Text input" class="form-control" value="<?php echo $fromdate; ?>" required>
												</div>
											</div>
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">To Date <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="date" name="todate" id="todate" placeholder="Text input" class="form-control" value="<?php echo $todate; ?>" required>
												</div>
											</div>
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Category</label>
												<div class="col-sm-8">
													<select name="cat_id" id="cat_id" class='select2-me' style="width:100%;" >
														<option value="">Select</option>
														<?php $sql = mysqli_query($connection,"Select * from  tpcategory  order by tpcat_id");
															while($row= mysqli_fetch_array($sql)) { ?>
														<option value="<?php echo $row['tpcat_id']; ?>"><?php echo $row['tp_name']; ?></option>
														<?php } ?>
														<script>document.getElementById('cat_id').value = '<?php echo $category_id; ?>';</script>
													</select>
												</div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Payee Name</label>
												<div class="col-sm-8">
													<select name="payee_name" id="payee_name" class='select2-me' style="width:100%;" >
														<option value="">Select</option>
														<?php $sql = mysqli_query($connection,"Select * from  payment group by payee_name");
															while($row= mysqli_fetch_array($sql)) { ?>
														<option value="<?php echo $row['payee_name']; ?>"><?php echo $row['payee_name']; ?></option>
														<?php } ?>
														<script>document.getElementById('payee_name').value = '<?php echo $payee_name; ?>';</script>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Approved</label>
												<div class="col-sm-8">
													<select name="is_approve" id="is_approve" class='select2-me' style="width:100%;">
														<option value="">Select</option>
														<option value="1">Approved</option>
														<option value="0">UnApproved</option>
													</select>
													<script>document.getElementById('is_approve').value = '<?php echo $is_approve; ?>';</script>
												</div>
											</div>
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Approved By</label>
												<div class="col-sm-8">
													<select name="user_id" id="user_id" class='select2-me' style="width:100%;">
														<option value="">Select</option>
														<?php $sql = mysqli_query($connection,"Select * from  m_userlogin  order by user_id");
															while($row= mysqli_fetch_array($sql)) { ?>
														<option value="<?php echo $row['user_id']; ?>"><?php echo $row['user_name']; ?></option>
														<?php } ?>
													</select>
													<script>document.getElementById('user_id').value = '<?php echo $user_id; ?>';</script>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<div class="form-actions" style="border-top:none; text-align:center;">
												<input type="submit" name="search" class="btn btn-primary" value="Search">  
												<a type="button" href="<?php echo $pagename; ?>" class="btn btn-red">Cancel</a>
											</div>
										</div>
									</div>
								</form>
							</div>
							
							
							<div class="box box-color box-bordered red">
			<div class="box-title">
			<h3>	<i class="fa fa-table"></i>
					Voucher List</h3>
				
		
				<!-- 	<button class="btn btn-warning" style="float: right">Click Hear For All Entry
											<i class="fa fa-object-group"></i>
										</button> &nbsp;
				 -->
				
				
				
				
			<a href="pdf/pdf_voucher_report.php" class="btn" style="float: right" target="_blank">Pdf 
											<i class="fa fa-file-pdf-o"></i> 
										</a> &nbsp;
					<a href="excel/excel_voucher_report.php?fromdate=<?php echo $row['fromdate']; ?>?todate=<?php echo $row['todate']; ?>?category_id=<?php echo $row['category_id']; ?>?payee_name=<?php echo $row['payee_name']; ?>" class="btn btn-warning" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a> 	
				
			</div>
			<div class="box-content nopadding" style="overflow:scroll;">
				<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
					<thead>
					<tr>
					   <th>S.No</th>
						<th>Category</th>
						<th>Voucher No.</th>
						<th>Voucher Name</th>
						<th>Paid To</th>
						<th>Voucher Date</th>
						<th>Voucher Amount</th>
						<th>User Name</th> 
						<th>Status</th>
						<th>Approve</th>
						<th>Action</th>
					</tr>
					</thead>
					<tbody>
					
					 <?php
									$sn=1;
// 			echo  "Select * from  $tblname  $crit  && consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id GROUP BY voucher_id order by $tblpkey desc ";
				$sql = mysqli_query($connection,"Select * from  $tblname  $crit  && consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id GROUP BY voucher_id order by $tblpkey desc ");
										  while($row= mysqli_fetch_array($sql)) {
	$user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
$category=$row['category_id'];
if($category==1){
	$cname="Agent";
	
$agent_id=$cmn->getvalfield($connection,"dispatch_entry","agent_id","dispatch_id='$row[dispatch_id]'");
$vname=$cmn->getvalfield($connection,"m_agent","agent_name","agent_id='$agent_id'");
$catid=$agent_id;	
$mobile = $cmn->getvalfield($connection,"m_agent","mobileno1","agent_id='$agent_id'");

} 
if($category==2){
	$cname="Consignee";
	
$consignee_id=$cmn->getvalfield($connection,"dispatch_entry","consignee_id","dispatch_id='$row[dispatch_id]'");
$vname=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id='$consignee_id'");
$mobile = $cmn->getvalfield($connection,"m_consignee","mobile_no","consignee_id='$consignee_id'");

$catid=$consignee_id;
} 
if($category==4) {
	$cname="Truck Owner";
	
$owner_id=$cmn->getvalfield($connection,"dispatch_entry","owner_id","dispatch_id='$row[dispatch_id]'");
$vname=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id='$owner_id'");
$mobile = $cmn->getvalfield($connection,"m_vehicle_owner","mobileno1","owner_id='$owner_id'");

$catid=$owner_id;

}
$approve_by  = $cmn->getvalfield($connection, "m_userlogin", "user_name", "user_id=$row[approved_by]");
$amt_paid_to=$cmn->getvalfield($connection,"payment","sum(amt_paid_to)","voucher_id='$row[voucher_id]' && consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id");
		$totalpaidamt += $amt_paid_to; // ✅ accumulate total amount					  	
										   ?>
					<tr>
					<td><?php echo $sn++;?></td>
						<td><?php echo $cname; ?></td>
						<td><?php echo $row['voucher_id']; ?></td>
						
			
						<td><?php echo $vname; ?></td>
						<td><?php echo $row['payee_name']; ?>
						<td><?php echo dateformatindia($row['voucher_date']); ?></td>
					<td><?php echo round($amt_paid_to,2); ?></td>
					<td><?php echo $user_name; ?></td>
					<td>
					    <?php if($row['status']=='0'){ ?>
					    <span onclick="chngstatus('<?php echo $row['voucher_id']; ?>','<?php echo $row['status']; ?>','')" style="color:green;">Unhold</span>
				  
					 <?php }  else { ?>
					    <span onclick="chngstatus('<?php echo $row['voucher_id']; ?>','<?php echo $row['status']; ?>','<?php echo $row['stremark']; ?>')" style="color:red;">Hold</span>
					 <?php   } ?>
					</td>
					<td>
						<?php if ($row['is_approve'] == 0) { ?>

							<a onclick="isapprove('<?php echo $row['voucher_id']; ?>');" class="btn btn-warning">
								OK
							</a>

						<?php } else { ?>

							<a class="btn btn-success">
								Approved BY <?php echo $approve_by; ?>
							</a>

						<?php } ?>
					</td>
						<td>
						   
			<a href="pdf/pdf_voucher_report_A5.php?voucher_id=<?php echo $row['voucher_id']; ?>&category_id=<?php echo $category; ?>" class="btn btn-info" rel="tooltip" title="Voucher A5" style="margin-left: 3px;" target="_blank">
			<i class="fa fa-print">A5</i>
		</a>
			<a href="pdf/pdf_voucher_report_A4.php?voucher_id=<?php echo $row['voucher_id']; ?>&category_id=<?php echo $category; ?>" class="btn btn-info" rel="tooltip" title="Voucher A4" style="margin-left: 3px;" target="_blank">
			<i class="fa fa-print"> A4</i>
		</a>
			<a href="pdf/pdf_voucher_report_A4L.php?voucher_id=<?php echo $row['voucher_id']; ?>&category_id=<?php echo $category; ?>" class="btn btn-info" rel="tooltip" title="Voucher A4L" style="margin-left: 3px;" target="_blank">
			<i class="fa fa-print">A4L</i>
		</a>
		<a onclick="getwhatsapp('<?php echo $row['voucher_id']; ?>','<?php echo $category; ?>','<?php echo $catid; ?>','<?php echo $vname; ?>','<?php echo $mobile; ?>');" ><img src="img/whatsapp.png" style="width:30px;height:30px;">
                                          </a>
                                          <span style="color:#F00;width: 70px;font-weight:bold;padding-top: 5px;" id="msg<?php echo $row['voucher_id']; ?><?php echo $category; ?>"></span>
                                     
		 <?php if($user_type=='admin'){ 
						    
						   if($row['is_paid']==0){ ?>
			   <a onClick="edit('<?php echo $row['voucher_id'];?>','edit');" class="btn btn-inverse" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
	
						<!-- <a href="voucheredit.php?editid=<?php echo $row['voucher_id']; ?>" class="btn btn-primary" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a> -->
						<a onClick="edit('<?php echo $row['voucher_id'];?>','del');"  class="btn btn-danger" rel="tooltip" title="Delete">
			<i class="fa fa-times"></i>
		</a>
						<!-- <a class="btn btn-danger" onClick="voucherdelete('<?php echo $row['voucher_id']; ?>')" rel="tooltip" title="Delete"><i class="fa fa-times"></i></a>	 -->
						   <?php } } ?>
		</td>
					</tr>
					
					<?php } ?>
					
					<tr>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td><strong>Total</strong></td>
												<td><strong><?php echo number_format($totalpaidamt, 2); ?></strong></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
					
					
					
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
    </div>
    	<div class="modal fade" id="myModal_status" role="dialog">
		<div class="modal-dialog" style="width:480px;padding-top: 225px;">


			<div class="modal-content" style="border-radius: 20px;">
				<div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
				
					<center>
						<h4 class="modal-title"><b>Change Status<b></h4>
					</center>
				</div>
   
			<div class="modal-body" style="flex-wrap: wrap-reverse;display: flex;">
				<span style="color:#F00;" id="suppler_model_error"></span> 
				<table class="table table-condensed table-bordered">
					<tr>
						<th>Status <span style="color:#F00;"> * </span> </th>
						<th>Reason</th>

					</tr>
					<tr>
						<td>
						<input type="hidden" name="voucher_id" id="voucher_id" class="form-control" value="" style="font-weight:bold; " autocomplete="off" readonly>

                           	<select name="status" id="status" class='select2-me' style="width:100%;" required>
													<option value="1"> Hold  </option>
		
                                  	<option value="0"> Unhold  </option>
											</select>
                           </td>

						<td>
                        <input type="text" name="stremark" id="stremark" placeholder="" class="form-control"  value="<?php echo $stremark; ?>" required>              
                
                    </td>


					</tr>
				
                 

				
				
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" name="s_save" id="s_save" onClick="savestatus();">Save</button>
				<button data-dismiss="modal" class="btn btn-danger">Close</button>

			</div>
		</div>

    </div>
    </div>
	<script>
		function voucherdelete(voucher_id) {
        
		var tablename = '<?php echo $tblname ?>';
		var tableid = '<?php echo $tblpkey ?>';
		if (confirm("Do You want to Delete this record ?")) {
			// alert(tableid);
			jQuery.ajax({
				type: 'POST',
				url: 'ajaxpayment/delete_voucher.php',
				data: 'voucher_id=' + voucher_id + '&tablename=' + tablename + '&tableid=' + tableid,
				dataType: 'html',
				success: function(data) {
				// 	alert(data);
					location = '<?php echo $pagename ?>?action=3';

				}
			}); //ajax close
		}
	}

	    
function getwhatsapp(billid,category,owner_id,bill_name,mobile){
// 	alert(billid);
// 	alert(category);
// 	alert(owner_id);
// 	alert(bill_name);
// 	alert(mobile);
jQuery.ajax({
	  type: 'POST',
	  url: 'pdf_voucher_A4L_whatsapp.php', 
	  data: 'billid='+billid+'&category='+category
	  ,
	  dataType: 'html',
	  success: function(data){
// 	  alert(data);
		// sendfile(billid,category,bill_name,mobile);
		getnum(billid,category,owner_id,bill_name,mobile);
		}
		
	  });//ajax close
}


function getnum(billid,category,owner_id,bill_name,mobile) {

	jQuery('#myModal_whatsapp').modal('show');
	jQuery('#w_billid').val(billid);
	jQuery('#w_category').val(category);
	   jQuery('#w_owner_id').val(owner_id);
	   jQuery('#w_bill_name').val(bill_name);
	   jQuery('#w_mobile').val(mobile);
	
 }

function sendfile(){

	var billid = document.getElementById('w_billid').value;
            var mobile = document.getElementById('w_mobile').value;
            var bill_name = document.getElementById('w_bill_name').value;
            var category = document.getElementById('w_category').value;
			var owner_id = document.getElementById('w_owner_id').value;
            var bill_name = document.getElementById('w_bill_name').value;
            var numupdate = document.getElementById('numupdate');
			if (category == 1){ 
			var type ="agent";
			} else if(category == 2){
				var type ="consignee";
			} else {
				var type ="owner";
			}
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
document.getElementById('msg'+billid+category).innerHTML = 'Sent';

}

});//ajax close
}

function chngstatus(voucher_id,status,stremark){
    // alert(status);
  	jQuery('#myModal_status').modal('show');  
  	jQuery('#voucher_id').val(voucher_id);
  	jQuery('#status').val(status).trigger('change').trigger('select2:select');
  	jQuery('#stremark').val(stremark);
}

function savestatus(){
    var voucher_id = document.getElementById('voucher_id').value;
            var status = document.getElementById('status').value;
             var stremark = document.getElementById('stremark').value;
             
jQuery.ajax({
type: 'POST',
url: 'ajaxpayment/chngstatus.php',
data: 'voucher_id='+voucher_id+'&status='+status+'&stremark='+stremark,
dataType: 'html',
success: function(data){
	jQuery("#myModal_status").modal('hide');
// document.getElementById('msg'+billid+category).innerHTML = 'Sent';

}

});
}
function isapprove(id) {

	var action = 'voucher';

	if (confirm("Are you sure want to approve this voucher?")) {
		$.ajax({
			type: 'POST',
			url: 'ajax/approve.php',
			data: {
				voucher_id: id,
				voucher: action
			},
			success: function(data) {
			    alert(data);
				alert("Approved Successfully");
				location.reload();
			}
		});
	}
}
	</script>
</body>



</html>
