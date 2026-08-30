<?php 
include("adminsession.php");
$tblname = "m_driver";
$tblpkey = "driver_id";
$pagename = "driver-master.php";
$modulename = "Driver Master";
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
	 $driver_name= $row['driver_name']; 
	$mobile_no 	 = $row['mobile_no'];
	$daddress= $row['daddress'];
	$aadhar_no=$row['aadhar_no'];
	$licence_no=$row['licence_no'];
	$lic_exp_date=$row['lic_exp_date'];
	$upload_aadhar=$row['upload_aadhar'];
	$upload_licence=$row['upload_licence'];
	$salary=$row['salary'];
	}
else
{
	$driver_name= '';
	$mobile_no  = '';
	$daddress = '';
	$aadhar_no='';
	$licence_no='';
	$lic_exp_date='';
	$upload_aadhar='';
	$upload_licence='';
	$salary='';
}
if(isset($_POST['submit']))
{
	  $driver_name = $_POST['driver_name'];
	 $mobile_no =$_POST['mobile_no'];
	$daddress = $_POST['daddress'];
	$aadhar_no = $_POST['aadhar_no'];
	$licence_no = $_POST['licence_no'];
	$lic_exp_date = $_POST['lic_exp_date'];
	$salary = $_POST['salary'];
	$upload_licence = $_FILES['upload_licence'];
	$upload_aadhar = $_FILES['upload_aadhar'];
	$form_data = array('driver_name'=>$driver_name,'mobile_no'=>$mobile_no,'daddress'=>$daddress,'aadhar_no'=>$aadhar_no,'licence_no'=>$licence_no,'lic_exp_date'=>$lic_exp_date,'salary'=>$salary,'created_date'=>$currentdate);
	 
	if($keyvalue  == 0)
	{
$count = check_duplicate($connection,$tblname,"driver_name='$driver_name' && mobile_no='$mobile_no'");
		if($count == 0)
		{
			dbRowInsert($connection,$tblname, $form_data);
	       $lastownerid = $connection->insert_id;
			  $imgpath2="upload/driver_aadhar/";
			  $imgpath3="upload/driver_licence/";
            	$uploaded_filename1 = uploadImage($imgpath2,$upload_aadhar); 
            	$uploaded_filename2 = uploadImage($imgpath3,$upload_licence);
            mysqli_query($connection,"update $tblname set upload_aadhar='$uploaded_filename1' , upload_licence='$uploaded_filename2'  where $tblpkey='$lastownerid'");
			echo "<script>location='$pagename?action=1'</script>";
		}
		else
		{
			$duplicate = "ERROR: Duplicate Record...";
		}
	}
	
	else
	{

    if($_FILES['upload_aadhar']['tmp_name']!="")
				{
		
					//delete old file
					$sql = mysqli_query($connection,"select * from $tblname where $tblpkey='$keyvalue'");
	             $rowimg = mysqli_fetch_array($sql);
			
					$oldimg = $rowimg["upload_aadhar"]; 
					if($oldimg != ""){
					unlink("upload/driver_aadhar/$oldimg");
				}
				 $imgpath="upload/driver_aadhar/";
					//insert new file
				$uploaded_filename = uploadImage($imgpath,$upload_aadhar);
				
					mysqli_query($connection,"update $tblname set upload_aadhar='$uploaded_filename' where $tblpkey='$keyvalue'");
				}

    if($_FILES['upload_licence']['tmp_name']!="")
				{
		
					//delete old file
					$sql = mysqli_query($connection,"select * from $tblname where $tblpkey='$keyvalue'");
	             $rowimg = mysqli_fetch_array($sql);
			
					$oldimg1 = $rowimg["upload_licence"]; 
					if($oldimg1 != ""){
					unlink("upload/driver_licence/$oldimg1");
				}
				 $imgpath4="upload/driver_licence/";
					//insert new file
				$uploaded_filename3 = uploadImage($imgpath4,$upload_licence);
				
					mysqli_query($connection,"update $tblname set upload_licence='$uploaded_filename3' where $tblpkey='$keyvalue'");
				}
		$form_data = array('driver_name'=>$driver_name,'mobile_no'=>$mobile_no,'daddress'=>$daddress,'aadhar_no'=>$aadhar_no,'licence_no'=>$licence_no,'lic_exp_date'=>$lic_exp_date,'salary'=>$salary,'updated_date'=>$currentdate);
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

	<title>DRIVER MASTER</title>

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
									<i class="fa fa-list"></i>Driver Master</h3>
							</div>
							<div class="box-content nopadding">
								<form action="#" method="POST" class='form-horizontal form-column form-bordered' enctype="multipart/form-data">
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Driver Name <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="text" name="driver_name" id="driver_name" placeholder="Enter Name" class="form-control" value="<?php echo $driver_name; ?>" required>
												</div>
											</div>
										
										</div>
										
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4"> Mobile No. <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="number" name="mobile_no" id="mobile_no" placeholder="Contact Number" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" value="<?php echo $mobile_no; ?>" required>
												</div>
											</div>
										
										</div>
										
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Address</label>
												<div class="col-sm-8">
													<input type="text" name="daddress" id="daddress" placeholder="Enter Address" class="form-control" value="<?php echo $daddress; ?>">
												</div>
											</div>
										
										</div>
                                    </div>


									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Adhar No.</label>
												<div class="col-sm-8">
													<input type="text" name="aadhar_no" id="aadhar_no" placeholder="Aadhar number" class="form-control" value="<?php echo $aadhar_no; ?>" maxlength="12">
												</div>
											</div>
										
										</div>





                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">licence No.</label>
												<div class="col-sm-8">
													<input type="text" name="licence_no" id="licence_no" placeholder="licence number" class="form-control" value="<?php echo $licence_no; ?>" maxlength="16">
												</div>
											</div>
										
										</div>
                                      

										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">licence Exp. Date</label>
												<div class="col-sm-8">
													<input type="date" name="lic_exp_date" id="lic_exp_date" placeholder="Text input" class="form-control" value="<?php echo $lic_exp_date; ?>">
												</div>
											</div>
										
										</div>
										</div>


									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Upload Aadhar</label>
												<div class="col-sm-8">
													<input type="file" name="upload_aadhar" id="upload_aadhar" placeholder="Text input" class="form-control" value="<?php echo $upload_aadhar; ?>">
												</div>
											</div>
										
										</div>





                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Upload licence</label>
												<div class="col-sm-8">
													<input type="file" name="upload_licence" id="upload_licence" placeholder="Text input" class="form-control" value="<?php echo $upload_licence; ?>">
												</div>
											</div>
										
										</div>
                                      
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Basic Salary</label>
												<div class="col-sm-8">
													<input type="number" name="salary" id="salary" placeholder="Enter Salary" class="form-control" value="<?php echo $salary; ?>">
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
									Driver Master Details
								</h3>
		<a href="pdf/pdf_m_driver.php" class="btn" style="float: right" target="_blank">Pdf 
										<i class="fa fa-file-pdf-o"></i></a> &nbsp;
			<a href="excel/excel_driver.php" class="btn btn-warning" style="float: right">Excel
							<i class="fa fa-file-excel-o"></i></a> 								
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-colvis">
									<thead>
									<tr>
											<th>Sno.</th>
											<th>Driver Name</th>
											<th>Mobile No.</th>
											<th>Address</th>
                                            <th>Licence Exp Date</th>
                                            <th>Basic Salary</th>
                                            <th>Uploaded Aadhar</th>
                                            <th>Uploaded Licence</th>
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
						<td><?php echo $row['driver_name']; ?></td>
						<td><?php echo $row['mobile_no']; ?></td>
						<td><?php echo $row['daddress']; ?></td>
					<td class='hidden-1024'><?php echo dateformatindia($row['lic_exp_date']); ?></td>
					<td><?php echo $row['salary']; ?></td>
						<td><b><a href="upload/driver_aadhar/<?php echo $row['upload_aadhar'] ?>" class="text-danger"  target="_blank" download>Download</a></b></td>
						<td><b><a href="upload/driver_licence/<?php echo $row['upload_licence'] ?>" class="text-danger"  target="_blank" download>Download</a></b></td>
						<td class='hidden-480'><?php if ($user_type == 'admin') { ?>
			<a href="?editid=<?php echo $row['driver_id']; ?>" class="btn btn-primary" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
							  <a href="<?php echo $pagename ?>" class="btn btn-danger" onClick="funDel(<?php echo $row['driver_id']; ?>)" rel="tooltip" title="Delete"><i class="fa fa-times"></i></a>
							  	<?php } ?>	</td>
					</tr>
					<?php } ?>						</tbody>
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
