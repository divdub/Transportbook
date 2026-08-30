<?php 
error_reporting(0);
include("adminsession.php");
$tblname = "m_consignor";
$tblpkey = "consignor_id";
$pagename = "consignor-master.php";
$modulename = "Consignor Master";
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
	 $consignor_name = $row['consignor_name']; 
	$mobile_no  = $row['mobile_no'];
	$email_id=$row['email_id'];
	$consignor_address=$row['consignor_address'];
	$place_id=$row['place_id'];
	$gst_no=$row['gst_no'];
    $pan_no=$row['pan_no'];
    $opn_balnc=$row['opn_balnc'];
    $opn_balnc_date=$row['opn_balnc_date'];
    $acc_holder_name=$row['acc_holder_name'];
    $acc_no=$row['acc_no']; 
    $ifsc_code=$row['ifsc_code']; 
    $bank_name=$row['bank_name']; 
    $branch_name=$row['branch_name']; 
    $acc_type=$row['acc_type']; 
}
else
{
	$consignor_name = '';
	$mobile_no  = '';
	$email_id  = '';
	$consignor_address  = '';
	$place_id  = '';
	$gst_no  = '';
	$pan_no  = '';
	$opn_balnc  = '';
	$opn_balnc_date  = '';
	$acc_holder_name  = '';
	$acc_no  = '';
	$ifsc_code  = '';
	$bank_name  = '';
	$branch_name  = '';
	$acc_type  = '';
}
if(isset($_POST['submit']))
{
	  $consignor_name = $_POST['consignor_name'];
	 $mobile_no =$_POST['mobile_no'];
	 $email_id =$_POST['email_id'];
	 $consignor_address =$_POST['consignor_address'];
	 $place_id =$_POST['place_id'];
	 $gst_no =$_POST['gst_no'];
	 $pan_no =$_POST['pan_no'];
     $opn_balnc =$_POST['opn_balnc'];
	 $opn_balnc_date =$_POST['opn_balnc_date'];
	 $acc_holder_name =$_POST['acc_holder_name'];
	 $acc_no =$_POST['acc_no'];
	 $ifsc_code =$_POST['ifsc_code'];
	 $bank_name =$_POST['bank_name'];
	 $branch_name =$_POST['branch_name'];
	 $acc_type =$_POST['acc_type'];

	$form_data = array('consignor_name'=>$consignor_name,'mobile_no'=>$mobile_no,'email_id'=>$email_id,'consignor_address'=>$consignor_address,'place_id'=>$place_id,'gst_no'=>$gst_no,'pan_no'=>$pan_no,'opn_balnc'=>$opn_balnc,'opn_balnc_date'=>$opn_balnc_date,'acc_holder_name'=>$acc_holder_name,'acc_no'=>$acc_no,'ifsc_code'=>$ifsc_code,'bank_name'=>$bank_name,'branch_name'=>$branch_name,'acc_type'=>$acc_type,'created_date'=>$currentdate);
	 
	if($keyvalue  == 0)
	{
		$count = check_duplicate($connection,$tblname,"consignor_name='$consignor_name'");
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

	$form_data = array('consignor_name'=>$consignor_name,'mobile_no'=>$mobile_no,'email_id'=>$email_id,'consignor_address'=>$consignor_address,'place_id'=>$place_id,'gst_no'=>$gst_no,'pan_no'=>$pan_no,'opn_balnc'=>$opn_balnc,'opn_balnc_date'=>$opn_balnc_date,'acc_holder_name'=>$acc_holder_name,'acc_no'=>$acc_no,'ifsc_code'=>$ifsc_code,'bank_name'=>$bank_name,'branch_name'=>$branch_name,'acc_type'=>$acc_type,'updated_date'=>$currentdate);
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

	<title>Consignor Master :: Chaaruvi Infotech Pvt. Ltd.</title>

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
					<div class="box box-bordered box-color">
							<div class="box-title">
								
								<h3>
									<i class="fa fa-bars"></i>Consignor Master</h3>							
								
							</div>
							<div class="box-content nopadding">
								<form action="#" method="POST" class='form-horizontal form-column form-bordered'>
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Consignor Name <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="text" name="consignor_name" id="consignor_name" placeholder="Enter Consignor Name" class="form-control" value="<?php echo $consignor_name; ?>" required>
												</div>
											</div>
										
										</div>
										
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Mobile No.</label>
												<div class="col-sm-8">
													<input type="number" name="mobile_no" id="mobile_no" placeholder="Contact No." class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" value="<?php echo $mobile_no; ?>" >
												</div>
											</div>
										
										</div>
										
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Email ID </label>
												<div class="col-sm-8">
													<input type="email" name="email_id" id="email_id" placeholder="Email Id" class="form-control" value="<?php echo $email_id; ?>">
												</div>
											</div>
										
										</div>
                                    </div>


									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Address</label>
												<div class="col-sm-8">
													<input type="text" name="consignor_address" id="consignor_address" placeholder="Enter Address" class="form-control" value="<?php echo $consignor_address; ?>">
												</div>
											</div>
										
										</div>


                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4"> City</label>
												<div class="col-sm-8">
                                            <select name="place_id" id="place_id" class='select2-me' style="width:350px;">
                                                	<option value="">      Select  </option>
				<?php	$sql = mysqli_query($connection,"Select * from  m_place  order by place_id ");
										  while($row= mysqli_fetch_array($sql)) { ?>
										  	
												<option value="<?php echo $row['place_id']; ?>"><?php echo $row['place_name']; ?></option>
								<?php } ?>

											</select>
					<script>document.getElementById('place_id').value = '<?php echo $place_id; ?>';</script>
												</div>
											</div>
										
										</div>


										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">GST No.</label>
												<div class="col-sm-8">
													<input type="text" name="gst_no" id="gst_no" placeholder="Gst Number" class="form-control" value="<?php echo $gst_no; ?>" maxlength="15">
												</div>
											</div>
										
										</div>
										
										
                                        </div>

									<div class="row">
										<div class="col-sm-4">
									<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">PAN No.</label>
												<div class="col-sm-8">
													<input type="text" name="pan_no" id="pan_no" placeholder="Pan Number" class="form-control" value="<?php echo $pan_no; ?>" maxlength="10">
												</div>
											</div>
										
										</div>


                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Opening Balance</label>
												<div class="col-sm-8">
													<input type="text" name="opn_balnc" id="opn_balnc" placeholder="Opening Balance" class="form-control" value="<?php echo $opn_balnc; ?>">
												</div>
											</div>
										
										</div>


										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Opening Balance Date</label>
												<div class="col-sm-8">
													<input type="date" name="opn_balnc_date" id="opn_balnc_date" placeholder="DD/MM/YYYY" class="form-control" value="<?php echo $opn_balnc_date; ?>">
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
													<input type="text" name="ifsc_code" id="ifsc_code" placeholder="Ifsc Code" class="form-control" value="<?php echo $ifsc_code; ?>" maxlength="15">
												</div>
											</div>
										
										</div>
										
										
                                        </div>
									
									
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Bank Name</label>
												<div class="col-sm-8">
													<input type="text" name="bank_name" id="bank_name" placeholder="Bank Name" class="form-control" value="<?php echo $bank_name; ?>">
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
							<a type="button" href="<?php echo $pagename; ?>" class="btn btn-red">Cancel</a>
												</center>	
											</div>
										</div>
									</div>
								</form>
							</div>
							
							<div class="box box-color box-bordered ">
			<div class="box-title">
			<h3>	<i class="fa fa-table"></i>
					Consignor Master Details</h3>
				
			<a href="pdf/pdf_m_consignor.php" class="btn" style="float: right" target="_blank">Pdf 
											<i class="fa fa-file-pdf-o"></i>
										</a> &nbsp;
					<a href="excel/excel_consignor.php" class="btn btn-warning" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a> 	
				
			</div>
			<div class="box-content nopadding">
				<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
					<thead>
					<tr>
						<th>S.No</th>
						<th>Consignor Name</th>
						<th>Mobile No.</th>
						<th>City</th>
						<th>Opening Balance</th>
						<th>Opening Balance Date</th>
						<th class='hidden-480'>Action</th>
					</tr>
					</thead>
					<tbody>
						 <?php
										$sn=1;
						$sql = mysqli_query($connection,"Select * from  $tblname  order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
				$place_name=$cmn->getvalfield($connection,"m_place","place_name","place_id=$row[place_id]");
										   ?>
					<tr>
						<td><?php echo $sn++; ?></td>
						<td><?php echo $row['consignor_name']; ?></td>
						<td><?php echo $row['mobile_no']; ?></td>
						<td><?php echo $place_name; ?></td>
						<td class='hidden-350'><?php echo $row['opn_balnc']; ?></td>
						<td class='hidden-1024'><?php echo dateformatindia($row['opn_balnc_date']); ?></td>
						<td class='hidden-480'> <?php if ($user_type == 'admin') { ?>
			<a href="?editid=<?php echo $row['consignor_id']; ?>" class="btn btn-primary" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
							  <a href="<?php echo $pagename ?>" class="btn btn-danger" onClick="funDel(<?php echo $row['consignor_id']; ?>)" rel="tooltip" title="Delete"><i class="fa fa-times"></i></a>
							  	<?php } ?>	</td>
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
