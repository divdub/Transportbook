<?php 
include("adminsession.php");
$tblname = "m_party";
$tblpkey = "party_id";
$pagename = "party_master.php";
$modulename = "Party Master";
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
	 $party_name= $row['party_name']; 
	$mobile_no 	 = $row['mobile_no'];
	$paddress= $row['paddress'];
	$place_id=$row['place_id'];
	$p_type=$row['p_type'];
	}
else
{
	$party_name= '';
	$mobile_no  = '';
	$paddress = '';
	$place_id='';
	$p_type='';
}
if(isset($_POST['submit']))
{
	  $party_name = $_POST['party_name'];
	  $mobile_no =$_POST['mobile_no']; 
	$paddress = $_POST['paddress'];
	$place_id = $_POST['place_id'];
	$p_type = $_POST['p_type'];
// 	echo "'party_name'=>$party_name,'mobile_no'=>$mobile_no,'paddress'=>$paddress,'place_id'=>$place_id,'p_type'=>$p_type,'created_date'=>$currentdate";
	$form_data = array('party_name'=>$party_name,'mobile_no'=>$mobile_no,'paddress'=>$paddress,'place_id'=>$place_id,'p_type'=>$p_type,'created_date'=>$currentdate);
	 
	if($keyvalue  == 0)
	{
$count = check_duplicate($connection,$tblname,"party_name='$party_name' && p_type='$p_type'");
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



		$form_data = array('party_name'=>$party_name,'mobile_no'=>$mobile_no,'paddress'=>$paddress,'place_id'=>$place_id,'p_type'=>$p_type,'updated_date'=>$currentdate);
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

	<title>PARTY MASTER</title>

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
									<i class="fa fa-list"></i>Party Master</h3>
							</div>
							<div class="box-content nopadding">
								<form action="#" method="POST" class='form-horizontal form-column form-bordered' enctype="multipart/form-data">
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Party Name <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="text" name="party_name" id="party_name" placeholder="Enter Name" class="form-control" value="<?php echo $party_name; ?>" required>
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
													<input type="text" name="paddress" id="paddress" placeholder="Enter Address" class="form-control" value="<?php echo $paddress; ?>">
												</div>
											</div>
										
										</div>
                                    </div>




									<div class="row">
									
       <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4"> City</label>
												<div class="col-sm-8">
                                            <select name="place_id" id="place_id" class='select2-me' style="width:100%;">
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
												<label for="textfield" class="control-label col-sm-4">Party Type</label>
												<div class="col-sm-8">
                                                <select name="p_type" id="p_type" class='form-control' required>
                                                	<option value="">Select</option>
												<option value="consignor">Consignor</option>
												<option value="consignee">Consignee</option>
												</select>
						    <script>document.getElementById('p_type').value = '<?php echo $p_type; ?>';</script>
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
									 Party Master Details
								</h3>
		<!--<a href="pdf/pdf_m_driver.php" class="btn" style="float: right" target="_blank">Pdf -->
		<!--								<i class="fa fa-file-pdf-o"></i></a> &nbsp;-->
		<!--	<a href="excel/excel_driver.php" class="btn btn-warning" style="float: right">Excel-->
		<!--					<i class="fa fa-file-excel-o"></i></a> 								-->
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-colvis">
									<thead>
									<tr>
											<th>Sno.</th>
											<th>Party Name</th>
											<th>Mobile No.</th>
											<th>Address</th>
                                            <!-- <th>City</th> -->
                                            <th>Party Type</th>
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
						<td><?php echo $row['party_name']; ?></td>
						<td><?php echo $row['mobile_no']; ?></td>
						<td><?php echo $row['paddress']; ?></td>
					
					<td><?php echo $row['p_type']; ?></td>
						
						<td class='hidden-480'>
			<a href="?editid=<?php echo $row['party_id']; ?>" class="btn btn-primary" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
							  <a href="<?php echo $pagename ?>" class="btn btn-danger" onClick="funDel(<?php echo $row['party_id']; ?>)" rel="tooltip" title="Delete"><i class="fa fa-times"></i></a></td>
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
