<?php 
include("adminsession.php");
$tblname = "m_brand";
$tblpkey = "brand_id ";
$pagename = "brand-master.php";
$modulename = "Brand Master";
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
	 $brand_name = $row['brand_name']; 
	 $brand_logo=$row['brand_logo'];
}
else
{
	$brand_name = '';
	$brand_logo='';
}
if(isset($_POST['submit']))
{
	  $brand_name = $_POST['brand_name'];
	  $brand_logo = $_FILES['brand_logo'];
	
	$form_data = array('brand_name'=>$brand_name,'created_date'=>$currentdate);
	 
	if($keyvalue  == 0)
	{
	$count = check_duplicate($connection,$tblname,"brand_name='$brand_name'");
		if($count == 0)
		{
			dbRowInsert($connection,$tblname, $form_data);
			$lastownerid = $connection->insert_id;
			$imgpath2="upload/logo/";
			  
			$uploaded_filename1 = uploadImage($imgpath2,$brand_logo); 
			"update $tblname set brand_logo='$uploaded_filename1' where $tblpkey='$lastownerid'";
		mysqli_query($connection,"update $tblname set brand_logo='$uploaded_filename1' where $tblpkey='$lastownerid'");
			echo "<script>location='$pagename?action=1'</script>";
		}
		else
		{
			$duplicate = "ERROR: Duplicate Record...";
		}
	}
	
	else
	{
		if($_FILES['brand_logo']['tmp_name']!="")
				{
				//delete old file
					$sql = mysqli_query($connection,"select * from $tblname where $tblpkey='$keyvalue'");
	             $rowimg = mysqli_fetch_array($sql);
			
					$oldimg = $rowimg["brand_logo"]; 
					if($oldimg != ""){
					unlink("upload/logo/$oldimg");
				}
				 $imgpath="upload/logo/";
					//insert new file
				$uploaded_filename = uploadImage($imgpath,$brand_logo);
				
					mysqli_query($connection,"update $tblname set brand_logo='$uploaded_filename' where $tblpkey='$keyvalue'");
				}

   
		$form_data = array('brand_name'=>$brand_name,'updated_date'=>$currentdate);
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

	<title>Brand Master :: Chaaruvi Infotech Pvt. Ltd.</title>

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
									<i class="fa fa-list"></i>Brand Master</h3>
							</div>
							<div class="box-content nopadding">
								<form action="#" method="POST" class='form-horizontal form-column form-bordered' enctype="multipart/form-data">
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Brand Name <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="text" name="brand_name" id="brand_name" placeholder="Brand Name" value="<?php echo $brand_name;?>" class="form-control" required>
												</div>
											</div>
										
										</div>


										
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Brand Logo </label>
												<div class="col-sm-8">
												<input type="file" name="brand_logo" id="brand_logo" class="form-control" value="<?php echo $brand_logo; ?>">
											<?php if($brand_logo!=''){ ?>		<span><img style="width: 80px; height: 80px;border-radius: 10px;border: 2px solid black;" src="upload/logo/<?php echo $brand_logo; ?>" alt="<?php echo $brand_logo; ?>" /></span><?php } ?>
													
												</div>
											</div>
										
										</div>
                                      	<div class="col-sm-4">
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
									Brand Master Details
								</h3>
					<a href="pdf/pdf_m_brand.php" class="btn" style="float: right" target="_blank">Pdf 
											<i class="fa fa-file-pdf-o"></i>
										</a> &nbsp;
					<a href="excel/excel_brand.php" class="btn btn-warning" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a> 		
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-colvis">
									<thead>
									       <th>Sno.</th>
										     <th>Brand Name</th>
											 <th>Brand Logo</th>
                                            <th>Action</th>
									</thead>
									<tbody>
										  <?php
										$sn=1;
					$sql = mysqli_query($connection,"Select * from  $tblname  order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
										   ?>
										<tr>
										
											<td><?php echo $sn++; ?></td>
                                            <td><?php echo $row['brand_name']; ?></td>
											<td><img style="width: 80px; height: 80px;border-radius: 10px;border: 2px solid black;" src="upload/logo/<?php echo $row['brand_logo']; ?>" alt="<?php echo $row['brand_logo']; ?>" /></td>
                                           
                                       
											<td class='hidden-350'>
							<?php if ($user_type == 'admin') { ?>	<a href="?editid=<?php echo $row['brand_id']; ?>" class="btn btn-primary" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
							  <a href="<?php echo $pagename ?>" class="btn btn-danger" onClick="funDel(<?php echo $row['brand_id']; ?>)" rel="tooltip" title="Delete"><i class="fa fa-times"></i></a>
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
									