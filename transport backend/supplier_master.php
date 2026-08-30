<?php 
include("adminsession.php");
$tblname = "m_supplier";
$tblpkey = "supplier_id";
$pagename = "supplier_master.php";
$modulename = "Supplier Master";
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
	 $supp_name = $row['supp_name']; 
	$mobile_no  = $row['mobile_no'];
	$email_id=$row['email_id'];
	$hname=$row['hname'];
	$saddress=$row['saddress'];
	$place_id=$row['place_id'];
	$gst_no=$row['gst_no'];
    $pan_no=$row['pan_no'];
    $acc_holder_name=$row['acc_holder_name'];
    $acc_no=$row['acc_no']; 
    $ifsc_code=$row['ifsc_code']; 
    $bank_name=$row['bank_name']; 
    $branch_name=$row['branch_name']; 
    $acc_type=$row['acc_type']; 
}
else
{
	$supp_name = '';
	$mobile_no  = '';
	$hname  = '';
	$email_id='';
	$saddress  = '';
	$place_id  = '';
	$gst_no  = '';
	$pan_no  = '';
	$acc_holder_name  = '';
	$acc_no  = '';
	$ifsc_code  = '';
	$bank_name  = '';
	$branch_name  = '';
	$acc_type  = '';
}
if(isset($_POST['submit']))
{
	  $supp_name = $_POST['supp_name'];
	 $mobile_no =$_POST['mobile_no'];
	 $hname =$_POST['hname'];
	 $email_id=$_POST['email_id'];
	 $saddress =$_POST['saddress'];
	 $place_id =$_POST['place_id'];
	 $gst_no =$_POST['gst_no'];
	 $pan_no =$_POST['pan_no'];
	 $acc_holder_name =$_POST['acc_holder_name'];
	 $acc_no =$_POST['acc_no'];
	 $ifsc_code =$_POST['ifsc_code'];
	 $bank_name =$_POST['bank_name'];
	 $branch_name =$_POST['branch_name'];
	 $acc_type =$_POST['acc_type'];

	$form_data = array('supp_name'=>$supp_name,'mobile_no'=>$mobile_no,'email_id'=>$email_id,'hname'=>$hname,'consignorid'=>$consignorid,'saddress'=>$saddress,'place_id'=>$place_id,'gst_no'=>$gst_no,'pan_no'=>$pan_no,'acc_holder_name'=>$acc_holder_name,'acc_no'=>$acc_no,'ifsc_code'=>$ifsc_code,'bank_name'=>$bank_name,'branch_name'=>$branch_name,'acc_type'=>$acc_type,'created_date'=>$currentdate);
	 
	if($keyvalue  == 0)
	{
		$count = check_duplicate($connection,$tblname,"supp_name='$supp_name' && consignorid='$consignorid' && mobile_no='$mobile_no'");
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
	$form_data = array('supp_name'=>$supp_name,'mobile_no'=>$mobile_no,'email_id'=>$email_id,'hname'=>$hname,'saddress'=>$saddress,'place_id'=>$place_id,'gst_no'=>$gst_no,'pan_no'=>$pan_no,'acc_holder_name'=>$acc_holder_name,'acc_no'=>$acc_no,'ifsc_code'=>$ifsc_code,'bank_name'=>$bank_name,'branch_name'=>$branch_name,'acc_type'=>$acc_type,'updated_date'=>$currentdate);
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

	<title>SUPPLIER MASTER :: CHAARUVI INFOTECH PVT. LTD.</title>

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
                <div class="row">
					<div class="col-sm-12">
						<div class="box box-bordered box-color">
							<div class="box-title">
								<h3>
									<i class="fa fa-list"></i>Supplier Master</h3>
							</div>
							<div class="box-content nopadding">
								<form action="#" method="POST" class='form-horizontal form-column form-bordered'>
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Supplier Name <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="text" name="supp_name" id="supp_name" placeholder="Enter Supplier Name" class="form-control" value="<?php echo $supp_name; ?>" required>
												</div>
											</div>
										
										</div>
                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Head/Owner Name </label>
												<div class="col-sm-8">
													<input type="text" name="hname" id="hname" placeholder="Enter Name" class="form-control" value="<?php echo $hname; ?>">
												</div>
											</div>
										
										</div>
										
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Mobile No. <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="number" name="mobile_no" id="mobile_no" placeholder="Contact No." class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" value="<?php echo $mobile_no; ?>" required>
												</div>
											</div>
										
										</div>
                                    </div>


									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Email Id</label>
												<div class="col-sm-8">
													<input type="email" name="email_id" id="email_id" placeholder="Email Id" class="form-control" value="<?php echo $email_id; ?>">
												</div>
											</div>
										
										</div>
                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">GST No.</label>
												<div class="col-sm-8">
													<input type="text" name="gst_no" id="gst_no" placeholder="GST Number" class="form-control" value="<?php echo $gst_no; ?>" maxlength="15">
												</div>
											</div>
										
										</div>
										
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">PAN No.</label>
												<div class="col-sm-8">
													<input type="text" name="pan_no" id="pan_no" placeholder="Pan Number" class="form-control" value="<?php echo $pan_no; ?>" maxlength="10">
												</div>
											</div>
										
										</div>
                                    </div>


									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Address</label>
												<div class="col-sm-8">
													<input type="text" name="saddress" id="saddress" placeholder="Enter Address" class="form-control" value="<?php echo $saddress; ?>">
												</div>
											</div>
										
										</div>
                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4"> City</label>
												<div class="col-sm-8">
                                                <select name="place_id" id="place_id" class='select2-me' style="width:350px;">
                                                	<option value="">      Select State </option>
											<?php		$sql = mysqli_query($connection,"Select * from  m_place  order by place_id ");
										  while($row= mysqli_fetch_array($sql)) {
     $state_name=$cmn->getvalfield($connection,"m_state","state_name","state_id=$row[state_id]");
										   ?>
										  	
												<option value="<?php echo $row['place_id']; ?>"><?php echo $row['place_name']."-".$state_name; ?></option>
								<?php } ?>

											</select>
					<script>document.getElementById('place_id').value = '<?php echo $place_id; ?>';</script>
												</div>
											</div>
										
										</div>
										
										
                                    </div>
									
										<pre style="font-weight: bold; color: red">Bank Details</pre>
									
										<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Account Holder Name</label>
												<div class="col-sm-8">
													<input type="text" name="acc_holder_name" id="acc_holder_name" placeholder="Enter Name" class="form-control" value="<?php echo $acc_holder_name; ?>">
												</div>
											</div>
										
										</div>


                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">A/C No.</label>
												<div class="col-sm-8">
													<input type="text" name="acc_no" id="acc_no" placeholder="Account Number" class="form-control" value="<?php echo $acc_no; ?>" maxlength="16">
												</div>
											</div>
										
										</div>


										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">IFSC Code</label>
												<div class="col-sm-8">
													<input type="text" name="ifsc_code" id="ifsc_code" placeholder="IFSC Code" class="form-control" value="<?php echo $ifsc_code; ?>" maxlength="15">
												</div>
											</div>
										
										</div>
										
										
                                        </div>
									
									
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Bank Name</label>
												<div class="col-sm-8">
													<input type="text" name="bank_name" id="bank_name" placeholder="Bank Name" class="form-control"value="<?php echo $bank_name; ?>">
												</div>
											</div>
										
										</div>


                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Branch Name</label>
												<div class="col-sm-8">
													<input type="text" name="branch_name" id="branch_name" placeholder="Branch Name" class="form-control" value="<?php echo $branch_name; ?>">
												</div>
											</div>
										
										</div>


										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Account Type</label>
												<div class="col-sm-8">
                                                <select name="acc_type" id="acc_type" class='form-control'>
                                                	<option value="">Select</option>
												<option value="Saving">Saving</option>
												<option value="Current">Current</option>
													</select>
											   <script>document.getElementById('acc_type').value = '<?php echo $acc_type; ?>';</script>
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
						</div>
					</div>
				</div>
								
				<div class="row">
					<div class="col-sm-12">
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-table"></i>
									Supplier Details
								</h3>
				<a href="pdf/pdf_m_supplier.php" class="btn" style="float: right" target="_blank">Pdf 
										<i class="fa fa-file-pdf-o"></i></a> &nbsp;
			<a href="excel/excel_supplier.php" class="btn btn-warning" style="float: right">Excel
							<i class="fa fa-file-excel-o"></i></a> 	
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-colvis">
									<thead>
										<tr>
						<th>S.No</th>
						<th>Supplier Name</th>
						<th>Head/Owner Name</th>
						<th>Mobile No.</th>
						<th>City</th>
						<th>Address</th>
						<th class='hidden-480'>Action</th>
					</tr>
					</thead>
					<tbody>
						 <?php
										$sn=1;
								// 		echo "Select * from  $tblname  where consignorid=$consignorid order by $tblpkey desc";
						$sql = mysqli_query($connection,"Select * from  $tblname  where consignorid=$consignorid order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
				// 						      if($row['place_id']!=''){
				// $place_name=$cmn->getvalfield($connection,"m_place","place_name","place_id=$row[place_id]");
				// $state_id=$cmn->getvalfield($connection,"m_place","state_id","place_id=$row[place_id]");
				// $state_name=$cmn->getvalfield($connection,"m_state","state_name","state_id=$state_id");
				// 				}		   ?>
					<tr>
						<td><?php echo $sn++; ?></td>
						<td><?php echo $row['supp_name']; ?></td>
						<td><?php echo $row['hname']; ?></td>
						<td><?php echo $row['mobile_no']; ?></td>
						<td><?php echo $place_name."-".$state_name; ?></td>
						<td class='hidden-350'><?php echo $row['saddress']; ?></td>
						<td class='hidden-480'> <?php if ($user_type == 'admin') { ?>
			<a href="?editid=<?php echo $row['supplier_id']; ?>" class="btn btn-primary" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
							  <a href="<?php echo $pagename ?>" class="btn btn-danger" onClick="funDel(<?php echo $row['supplier_id']; ?>)" rel="tooltip" title="Delete"><i class="fa fa-times"></i></a>
							  	<?php } ?></td>
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
	 <script type="text/javascript">
        function funDel(id) {
        
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
									