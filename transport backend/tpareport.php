<?php 
error_reporting(0);
include("adminsession.php");
 include("function/payment_function.php");
$tblname = "tpa_entry";
$tblpkey = "tpa_id";
$pagename = "tpareport.php";
$modulename = "TPA Report";
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

// if(isset($_GET['cat_id']))
// {
// 	 $cat_id = $_GET['cat_id'];
// }
// else
// 	$cat_id = '';


if(isset($_GET['cat_id']))
{
	 $cat_id = $_GET['cat_id'];
}
else
{
	$cat_id = '';
}


if (isset($_GET['catname'])) {
	$catname = trim(addslashes($_GET['catname']));
} else
	$catname = '';


if ($fromdate != '' && $todate != '') {
	$crit .= "where bilty_date BETWEEN  '$fromdate' and  '$todate' ";
	//echo $crit;
}

if ($di_no != '') {
	$crit .= " and di_no='$di_no'";
}

if ($cat_id != '') {
	$crit .= " and tpcat_id='$cat_id'";
}

if ($catname != '' && $cat_id == 1) {
	
  $cat_name=$cmn->getvalfield($connection,"m_agent","agent_name","agent_id=$catname");
   $crit .= " and category_id='$catname' ";
}
if ($catname != '' && $cat_id == 2) {
	
  $cat_name=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id=$catname");
   $crit .= " and category_id='$catname' ";
}
if ($catname != '' && $cat_id == 4) {
     
	  $cat_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$catname");
	  $crit .= " and category_id='$catname' ";
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
									<i class="fa fa-list"></i>TPA Report</h3>
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
												<label for="textfield" class="control-label col-sm-4">DI No.</label>
												<div class="col-sm-8">
													 	<input type="text" name="di_no" id="di_no" placeholder="Text input" class="form-control" value="<?php echo $di_no; ?>" >
												</div>
											</div>
										
										</div>
										</div>
										<div class="row">
										<div class="col-sm-4">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">Category</label>
                                       <div class="col-sm-8">
                                          <select name="cat_id" id="cat_id" class='select2-me' style="width:100%;" onchange="getcat(this.value);">
                                             <option value="">      Select  </option>
                                             <?php		$sql = mysqli_query($connection,"Select * from  tpcategory  order by tpcat_id");
                                                while($row= mysqli_fetch_array($sql)) { ?>
                                             <option value="<?php echo $row['tpcat_id']; ?>"><?php echo $row['tp_name']; ?></option>
                                             <?php } ?>
                                               <script>document.getElementById('cat_id').value = '<?php echo $cat_id; ?>';</script>
                                          </select>
                                        
                                       </div>
                                    </div>
                                 </div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4"> Name</label>
												<div class="col-sm-8">
													   <select name="catname" id="catname" class='select2-me '  style="width:100%;">
                           
													   <option value="<?php echo $catname ?>"><?php echo $cat_name;?></option> 
													</select>
									 <script>document.getElementById('catname').value = '<?php echo $catname; ?>';</script>	
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
					TPA List</h3>
				
		
				<!-- 	<button class="btn btn-warning" style="float: right">Click Hear For All Entry
											<i class="fa fa-object-group"></i>
										</button> &nbsp;
				 -->
				
				
				
				
			<a href="pdf/pdf_tpareport.php?fromdate=<?php echo $fromdate ?>&todate=<?php echo $todate ?>&di_no=<?php echo $di_no ?>&cat_id=<?php echo $cat_id ?>&catname=<?php echo $catname ?>" class="btn" style="float: right" target="_blank">Pdf 
											<i class="fa fa-file-pdf-o"></i>
										</a> &nbsp;
					<a href="excel/excel_tpareport.php?fromdate=<?php echo $fromdate ?>&todate=<?php echo $todate ?>&di_no=<?php echo $di_no ?>" class="btn btn-warning" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a> 	
										
										<a onclick="getwhatsapp('<?php echo $fromdate; ?>','<?php echo $todate; ?>','<?php echo $cat_id; ?>','<?php echo $catname; ?>');"  style="float: right"><img src="img/whatsapp.png" style="width:30px;height:30px;">
                                          </a>
                        <span style="color:#F00;width: 70px;font-weight:bold;padding-top: 5px;" id="msg"></span>
				
			</div>
			<div class="box-content nopadding">
				<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
					<thead>
					<tr>
					<th>S.No</th>
					 <th>DI/LR No. </th>
					<th>Bilty Date</th>

					<th>Category</th>
					<th>Category Name</th>
					<th>Rate</th>
					<th>Amount.</th>
					
					<th>Action</th>
					</tr>
					</thead>
					<tbody>
					
					 <?php
									$sn=1;
				// 			echo		"Select * from  $tblname  $crit && is_create=0 && consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id order by $tblpkey desc";
				$sql = mysqli_query($connection,"Select * from  $tblname  $crit && is_create=0 && consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
	
$category=$row['tpcat_id'];
if($category==1){
	$cname="Agent";
	$catname = $cmn->getvalfield($connection,"m_agent","agent_name","agent_id = '$row[category_id]'");

} 
if($category==2){
	$cname="Consignee";
	$catname = $cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id = '$row[category_id]'");

} 
if($category==4) {
	$cname="Truck Owner";
		$catname = $cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id = '$row[category_id]'");
}

						  	
										   ?>
					<tr>
					<td><?php echo $sn++;?></td>
					<td><?php echo $row['di_no']; ?></td>
					<td><?php echo dateformatindia($row['bilty_date']); ?></td>
						<td><?php echo $cname; ?></td>
						<td><?php echo $catname; ?></td>
						<td><?php echo $row['rate']; ?></td>
						<!-- <td><?php echo $di_no; ?></td> -->
					<td><?php echo $row['amt']; ?></td>
					
		 <td class='hidden-480'>
                                          <!--<a href="payment-process.php?edit=<?php echo $row['tpa_id']; ?>" class="btn btn-inverse" rel="tooltip" title="Edit">-->
                                          <!--<i class="fa fa-edit"></i>-->
                                          <!--</a>-->
                                        <?php if($user_type=='admin'){ ?>  
                                        <a onClick="funDelete2(<?php echo $row['tpa_id']; ?>)" class="btn btn-danger" rel="tooltip" title="Delete">
			<i class="fa fa-times"></i>
		</a>
		<?php } ?>
                                       </td>

			<!-- 			<td>
							
			<a href="pdf/pdf_voucher_A5.php?voucher_no=<?php echo $row['voucher_no']; ?>&category=<?php echo $row['category']; ?>" class="btn btn-info" rel="tooltip" title="Voucher A5" style="margin-left: 3px;" target="_blank">
			<i class="fa fa-print">Print Receipt</i>
		</a>
		</td> -->
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
                            <!--<input type="hidden" name="w_owner_id" id="w_owner_id" class="form-control" value="" style="font-weight:bold; " autocomplete="off" readonly>-->

                           </td>

						<td>
                        <input type="number" name="w_mobile" id="w_mobile" placeholder="Mobile No" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" value="<?php echo $w_mobile; ?>" required>              
                 <!-- <input type="text" name="w_mobile" id="w_mobile" class="form-control" value="" style="font-weight:bold; " autocomplete="off"> -->
						<!--<input type="hidden" name="w_billid" id="w_billid" class="form-control" value="" style="font-weight:bold; " autocomplete="off">-->
                    </td>


					</tr>
				
                 

					<!--<tr>-->
     <!--               <input type="checkbox" name="numupdate" id="numupdate" value="1"  style="width:18px;"/>  <span style="font-size:16px;margin-top:10px;"> &nbsp; Update Mobile Number</span>  -->
                    <!-- <input type="checkbox" id="layername1" name="layername" value="Drone Image" onclick="showLayerMap(1);"  /> -->
     <!--               </tr>-->
				
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
	   
function getwhatsapp(fromdate,todate,cat_id,catname){

jQuery.ajax({
	  type: 'POST',
	  url: 'pdf_tpareport_whatsapp.php', 
	  data: 'fromdate='+fromdate+'&todate='+todate+'&cat_id='+cat_id+'&catname='+catname
	  ,
	  dataType: 'html',
	  success: function(data){
		jQuery('#myModal_whatsapp').modal('show');
		}
		
	  });//ajax close
}


// function getnum(billid,category,owner_id,bill_name,mobile) {
	
// 	jQuery('#myModal_whatsapp').modal('show');
// 	jQuery('#w_billid').val(billid);
// 	jQuery('#w_category').val(category);
// 	   jQuery('#w_owner_id').val(owner_id);
// 	   jQuery('#w_bill_name').val(bill_name);
// 	   jQuery('#w_mobile').val(mobile);
	
//  }

function sendfile(){
	var fromdate = document.getElementById('fromdate').value;
            var mobile = document.getElementById('w_mobile').value;
            // var bill_name = document.getElementById('w_bill_name').value;
            // var category = document.getElementById('w_category').value;
// 			var owner_id = document.getElementById('w_owner_id').value;
            var bill_name = document.getElementById('w_bill_name').value;
//             var numupdate = document.getElementById('numupdate');
// 			if (category == 1){ 
// 			var type ="agent";
// 			} else if(category == 2){
// 				var type ="consignee";
// 			} else {
// 				var type ="owner";
// 			}
//   if (numupdate.checked == true){ 
//   var upval='1';
//   } else {
//     var upval='0';
//   }
            

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
