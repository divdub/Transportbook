<?php 
error_reporting(0);
include("adminsession.php");
include("function/dispatch_function.php");
$tblname = "dispatch_entry";
$tblpkey = "dispatch_id";
$pagename = "all-dispatch-advance.php";
$modulename = "Bilty Advance Details";
$crit='';
if(isset($_GET['search']))
{
	 $fromdate = $_GET['fromdate'];
 	$todate = $_GET['todate'];
	
}
else
{
	$fromdate = date('Y-m-01');
	$todate = $currentdate;

}

if (isset($_GET['consignor_id'])) {
	$consignor_id = trim(addslashes($_GET['consignor_id']));
} else
	$consignor_id = '';
	
	
if (isset($_GET['pay_type'])) {
	$pay_type = trim(addslashes($_GET['pay_type']));
} else
	$pay_type= '';	
	

if (isset($_GET['vehicle_id'])) {
	$vehicle_id = trim(addslashes($_GET['vehicle_id']));
} else
	$vehicle_id = '';


if ($fromdate != '' && $todate != '') {
	$crit .= "where bilty_date BETWEEN  '$fromdate' and  '$todate' ";
	//echo $crit;
}

if ($vehicle_id != '') {
	$crit .= " and vehicle_id='$vehicle_id'";
}
if ($consignor_id != '') {
	$crit .= " and consignor_id='$consignor_id'";
}

if ($pay_type != '') {
	$crit .= " and pay_type='$pay_type'";
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
	 
<div class="modal fade" id="myModald" role="dialog">
   <div class="modal-dialog" style="width:850px;padding-top: 225px;">
      <div class="modal-content" style="border-radius: 20px;">
         <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
            <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
            <center>
               <h4 class="modal-title"><b>ADD / Deduction<b></h4>
            </center>
         </div>
         <div class="modal-body" style="padding-top:30px;">
            <table class="table table-bordered">
               <thead>
                  <tr>
                     <th style="font-size:15px;font-weight:bold;">Extra Name</th>
                     <th style="font-size:15px;font-weight:bold;">Action</th>

                     <!-- <th style="font-size:15px;font-weight:bold;">Sap Doc No.</th> -->
                     <!-- <th style="font-size:15px;font-weight:bold;">Inv/Ref No.</th> -->
                     <th style="font-size:15px;font-weight:bold;">Date</th>
                     <th style="font-size:15px;font-weight:bold;">Amount</th>

                     <th style="font-size:15px;font-weight:bold;">Remark</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                    

<td>
    <select name="deduct_id" id="deduction_id" class="form-control" required>
        <option value="">Select </option>
        <?php 
        $sql = mysqli_query($connection, "SELECT * FROM m_deduct ORDER BY deduct_id");
        while ($row = mysqli_fetch_array($sql)) { ?>
            <option value="<?php echo $row['deduct_id']; ?>">
                <?php echo $row['deduct_name']; ?>
            </option>
        <?php } ?>
    </select>
</td>
<td>
    <select name="deduct_type" id="deduct_type" class="form-control" required>
        <option value="">Select Type</option>
        <option value="add">Release</option>
        <option value="subtract">Hold</option>
    </select>
</td>

<td>
	   <input type="date" name="date" id="date" class="form-control" required>
    <input type="hidden" name="dispatch_id1" id="dispatch_id1" class="form-control" required>
</td>

<td>
    <input type="text" name="amount" id="amount" class="form-control" required placeholder="Amount">
</td>

<td>
    <input type="text" name="remark" id="remark" class="form-control" required placeholder="Remark">
</td>

<td>
    <input type="button" class="btn btn-primary" onClick="save_deduction();" value="ADD">
</td>                  </tr>
               </tbody>
            </table>
            <div id="showdrecord"></div>
         </div>
         <div class="modal-footer">
            <center>
               <button class="btn btn-primary" tabindex="12" onclick="getsavedamt();"> Save</button>
               <input type="button" data-dismiss="modal" class="btn btn-danger" value="Close">
               <!-- <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a> -->
            </center>
         </div>
      </div>
   </div>
</div>
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
									<i class="fa fa-list"></i>Dispatch Advance</h3>
							</div>
<div class="box-content nopadding">
<form action="#" method="GET" class='form-horizontal form-column form-bordered'>
                              <div class="row">
                                 <div class="col-sm-4">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">From Date <span style="color: red">*</span></label>
                                       <div class="col-sm-8">
                                          <input type="date" name="fromdate" id="fromdate" placeholder="Text input" class="form-control" value="<?php echo $fromdate; ?>" required>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-4">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">To Date <span style="color: red">*</span></label>
                                       <div class="col-sm-8">
                                          <input type="date" name="todate" id="todate" placeholder="Text input" class="form-control" value="<?php echo $todate; ?>" required>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-4">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">Truck No.</label>
                                       <div class="col-sm-8">
                                          <select name="vehicle_id" id="vehicle_id" class='select2-me' style="width:100%;">
                                             <option value="">      Select  </option>
                                             <?php $sql = mysqli_query($connection,"Select * from  m_vehicle  order by vehicle_id");
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
                                       <label for="textfield" class="control-label col-sm-4">Consignor</label>
                                       <div class="col-sm-8">
                                          <select name="consignor_id" id="consignor_id" class='select2-me' style="width:100%;">
                                             <option value="">      Select  </option>
                                             <?php $sql = mysqli_query($connection,"Select * from  m_consignor  order by consignor_id");
                                                while($row= mysqli_fetch_array($sql)) { ?>
                                             <option value="<?php echo $row['consignor_id']; ?>"><?php echo $row['consignor_name']; ?></option>
                                             <?php } ?>
                                          </select>
                                          <script>document.getElementById('consignor_id').value = '<?php echo $consignor_id; ?>';</script>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-4">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">Pay Type</label>
                                       <div class="col-sm-8">
                                          <select name="pay_type" id="pay_type" class='select2-me' style="width:100%;">
                                             <option value="">Select</option>
                                             <option value="phone pay">Phone Pay</option>
                                             <option value="cash">Cash</option>
                                          </select>
                                          <script>document.getElementById('pay_type').value = '<?php echo $pay_type; ?>';</script>
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
					Dispatch Advance List</h3>
				
		
				<!-- 	<button class="btn btn-warning" style="float: right">Click Hear For All Entry
											<i class="fa fa-object-group"></i>
										</button> &nbsp;
				 -->
				
				
				
				
			<a href="pdf/pdf_dispatch_advance.php" class="btn" style="float: right" target="_blank">Pdf 
											<i class="fa fa-file-pdf-o"></i>
										</a> &nbsp;
					<a href="excel/excel_dispatch_advance.php?fromdate=<?php echo $fromdate ?>&todate=<?php echo $todate ?>&vehicle_id=<?php echo $vehicle_id ?>&pay_type=<?php echo $pay_type ?>" class="btn btn-warning" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a> 	
				
			</div>
			<div class="box-content nopadding" style="overflow:scroll;">
				<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
					<thead>
					<tr>
					<th>S.No</th>
						<th>DI No.</th>
						<th>Bilty No.</th>
						<th>Truck No.</th>
						<th>Owner Name</th>
						<th>Freight Amt</th>
						<th>Bilty Date</th>
						<th>Diesel Adv. Amt.</th>
						<th>Cash Advance</th>
						<th>GPS Amt</th>
						<th>AdBlue Adv.</th>
						 <th>Pay Type </th>
						 <th>Extra Amt</th>
						 <th>User Name</th>  
                         <th style="display:none;">Consignee Cash Adv.</th>
						<th>Action</th>
					</tr>
					</thead>
					<tbody>
					
					 <?php
									$sn=1;
							// echo		"Select * from  $tblname  $crit && is_advance=1  order by $tblpkey desc";
				$sql = mysqli_query($connection,"Select * from  $tblname  $crit && is_advance=1 && consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
	$vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
	   $owner_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$row[owner_id]");
	   $pump_name=$cmn->getvalfield($connection,"m_petrol_pump","pump_name","pump_id=$row[pump_id]");
	    $mobile=$cmn->getvalfield($connection,"m_petrol_pump","mobile_no","pump_id=$row[pump_id]");
	 $wt_mt =$row['wt_mt'];
     $own_rate=$row['own_rate'];
     $freight_amt=$wt_mt * $own_rate;
						  	$is_voucher=$row['is_voucher'];
							$user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[addvuser_id]");
										   ?>
					<tr  <?php if($row['checkbox']=='1') { ?> style="background-color:#ADD8E6;" <?php } ?>>
					<td><?php echo $sn++;?></td>
						<td><?php echo $row['di_no']; ?></td>
						<td><?php echo $row['bilty_no']; ?></td>
						<td><?php echo $vehicle_no; ?></td>
						<td class='hidden-1024'><?php echo $owner_name; ?></td>
						<td><?php echo $freight_amt; ?></td>
						<td><?php echo dateformatindia($row['bilty_date']); ?></td>
						<td><?php echo $row['diesel_adv_amt']; ?></td>
						<td><?php echo $row['cash_adv']; ?></td>
						<td><?php echo $row['other_cash_adv']; ?></td>
						<td><?php echo $row['consignor_cash_adv']; ?></td>
						<td><?php echo ucfirst($row['pay_type']); ?></td>
						<td> <span class="badge shtcutbtn"><a class="shtcut" onClick="jQuery('#myModald').modal('show');jQuery('#dispatch_id1').val('<?php echo $row['dispatch_id']; ?>');showdrecordd('<?php echo $row['dispatch_id']; ?>');"><?php echo $row['deduct']; ?></a></span></td>
						<td><?php echo $user_name; ?></td>
						<td style="display:none;"><?php echo $row['consignee_cash_adv']; ?></td>
						<td>
							<a href="pdf/pdf_dispatch_advanceA4.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-warning" rel="tooltip" title="Builty A4" target="_blank">
			<i class="fa fa-print">A4</i>
			<a href="pdf/pdf_dispatch_advanceA5.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-info" rel="tooltip" title="Builty A5" style="margin-left: 3px;" target="_blank">
			<i class="fa fa-print">A5</i>
		</a>
			<a href="pdf/pdf_dieselslip.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-info" rel="tooltip" title="Diesel Slip" style="margin-left: 3px;" target="_blank">
			<i class="fa fa-print" >Diesel Slip</i>
		</a>
		<?php if($row['pump_id']!=0){ ?>
		 <a onclick="getwhatsapp('<?php echo $row['dispatch_id']; ?>','<?php echo $row['pump_id']; ?>','<?php echo $pump_name; ?>','<?php echo $mobile; ?>');" ><img src="img/whatsapp.png" style="width:30px;height:30px;">
                                          </a>
                                          <?php } ?>
	  <?php if($user_type=='admin'){ ?>

		<a onClick="edit('<?php echo $row['dispatch_id'];?>','edit');" class="btn btn-inverse" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
				
		<a onClick="edit('<?php echo $row['dispatch_id'];?>','del');"  class="btn btn-danger" rel="tooltip" title="Delete">
			<i class="fa fa-times"></i>
		</a>
		    <?php } ?>
		</td>
					</tr>
					
					<?php
					$totcashadv+=$row['cash_adv'];
					$totdieseladv+=$row['diesel_adv_amt'];
					} ?>
					<tfoot>
					    <tr>
					        <td>
					            <td colspan="6"></td>
					            <td><?php echo $totdieseladv; ?></td>
					            <td><?php echo $totcashadv; ?></td>
					        </td>
					    </tr>
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
                            <input type="hidden" name="w_pump_id" id="w_pump_id" class="form-control" value="" style="font-weight:bold; " autocomplete="off" readonly>

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
	    function getwhatsapp(billid,pump_id,bill_name,mobile){
// alert(billid);
		jQuery.ajax({
			  type: 'POST',
			  url: 'pdf_dispatch_advanceA5_whatsapp.php', 
			  data: 'billid='+billid,
			  dataType: 'html',
			  success: function(data){
			     // alert(data);
            getnum(billid,pump_id,bill_name,mobile);
				// sendfile(billid,bill_name,mobile);
				}
				
			  });//ajax close
}


function getnum(billid,pump_id,bill_name,mobile) {
// 	alert(pump_id);
   jQuery('#myModal_whatsapp').modal('show');
   jQuery('#w_billid').val(billid);
      jQuery('#w_pump_id').val(pump_id);
      jQuery('#w_bill_name').val(bill_name);
      jQuery('#w_mobile').val(mobile);
   
}
  
  
        function sendfile(){

         var billid = document.getElementById('w_billid').value;
            var mobile = document.getElementById('w_mobile').value;
            var bill_name = document.getElementById('w_bill_name').value;
            var owner_id = document.getElementById('w_pump_id').value;
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
