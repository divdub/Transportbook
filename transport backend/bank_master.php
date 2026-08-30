<?php 
include("adminsession.php");
$tblname = "m_bank";
$tblpkey = "bankid";
$pagename = "bank_master.php";
$modulename = "Company Master";
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

	$ifsc_code = $row['ifsc_code'];

	$bank_name = $row['bank_name'];

	$acc_holder_name  = $row['acc_holder_name'];	
	$acc_no   = $row['acc_no'];	
	$branch_name  = $row['branch_name'];	
	$acc_type  = $row['acc_type'];	
}
else
{
	
	$ifsc_code = '';
	
	$bank_name ='';

	$acc_holder_name = '';	
	$acc_no    = '';	
	$branch_name    ='';	
	$acc_type    ='';	
}
if(isset($_POST['submit']))
{
	  
	$bank_name = $_POST['bank_name'];

	$ifsc_code = $_POST['ifsc_code'];
	
	$acc_holder_name = $_POST['acc_holder_name'];
	$acc_no    = $_POST['acc_no'];	
	$branch_name    = $_POST['branch_name'];	
	$acc_type = $_POST['acc_type'];		
	$form_data = array('bank_name'=>$bank_name,'ifsc_code'=>$ifsc_code,'acc_holder_name'=>$acc_holder_name,'acc_no'=>$acc_no,'branch_name'=>$branch_name,
	 'acc_type'=>$acc_type,'created_date'=>$currentdate);
	 if($keyvalue == 0)
	{
		$count = check_duplicate($connection,$tblname,"bank_name='$bank_name' && acc_no = '$acc_no'");
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
	
		$form_data = array('bank_name'=>$bank_name,'ifsc_code'=>$ifsc_code,'acc_holder_name'=>$acc_holder_name,'acc_no'=>$acc_no,'branch_name'=>$branch_name,
	 'acc_type'=>$acc_type,'updated_date'=>$currentdate);
	 
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
	<title>BANK PROFILE MASTER :: CHAARUVI INFOTECHPVT. LTD.</title>
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
									<i class="fa fa-list"></i>Bank Master</h3>
							</div>
							
							<div class="box-content nopadding">
								<form action="#" method="POST" class='form-horizontal form-column form-bordered' enctype="multipart/form-data">
								

								

									
								
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Account Holder Name</label>
												<div class="col-sm-8">
													<input type="text" name="acc_holder_name" id="acc_holder_name" placeholder="Name" class="form-control"value="<?php echo $acc_holder_name; ?>">
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
						</div>
					</div>
				</div>
				
			
				<div class="row">
					<div class="col-sm-12">
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-table"></i>
									Bank Details
								</h3>
					<!-- <a href="pdf/pdf_m_bank.php" class="btn" style="float: right" target="_blank">Pdf 
											<i class="fa fa-file-pdf-o"></i>
										</a> &nbsp;
					<a href="excel/excel_company.php" class="btn btn-warning" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a> 		 -->
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-colvis">
									<thead>
										<tr>
											<th>S.no</th>
											<th>Bank Name</th>
											<th>Account No</th>
											<th>Ifsc Code</th>
											<th>Branch Name</th>
											<th class='hidden-350'>Action</th>
											
										</tr>
									</thead>
									<tbody>
										  <?php
										$sn=1;
						$sql = mysqli_query($connection,"Select * from  $tblname  order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
										   ?>
										<tr>
											<td><?php echo $sn++; ?></td>
											<td>
												<?php echo $row['bank_name']; ?>
											</td>
											<td><?php echo $row['acc_no']; ?></td>
											<td><?php echo $row['ifsc_code']; ?></td>
											<td><?php echo $row['branch_name'];?></td>
																					<td class='hidden-350'>
																					    	<?php if ($user_type == 'admin') { ?>
												<a href="?editid=<?php echo $row['bankid']; ?>" class="btn btn-primary" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
									             <a  class="btn btn-danger" onClick="funDel(<?php echo $row['bankid']; ?>)" rel="tooltip" title="Delete"><i class="fa fa-times"></i></a></td>
											<?php } ?>	
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
