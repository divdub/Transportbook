<?php 
error_reporting(0);
include("adminsession.php");
$tblname = "m_vehicle";
$tblpkey = "vehicle_id";
$pagename = "vehicle_master.php";
$modulename = "Vehicle Master";
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
	 $vehicle_no = $row['vehicle_no']; 
	$owner_id1  = $row['owner_id']; 
	$vehicle_type_id    = $row['vehicle_type_id'];
	$agent_id=$row['agent_id'];
	$chassis_no=$row['chassis_no'];
	$uploaded_rc=$row['uploaded_rc'];
	$engine_no=$row['engine_no'];
	$meter_read=$row['meter_read'];
	$meter_read_date=$row['meter_read_date'];
	}
else
{
	$vehicle_no = '';
	$owner_id1  = '';
	$agent_id = '';
	$vehicle_type_id='';
	$chassis_no='';
	$engine_no='';
	$uploaded_rc='';
	$meter_read='';
	$meter_read_date='';
}
if(isset($_POST['submit']))
{
	  $vehicle_no = $_POST['vehicle_no'];
	 $owner_id1 =$_POST['owner_id1'];
	$agent_id = $_POST['agent_id'];
	$vehicle_type_id = $_POST['vehicle_type_id'];
	$chassis_no = $_POST['chassis_no'];
	$engine_no = $_POST['engine_no'];
	$meter_read = $_POST['meter_read'];
	$meter_read_date = $_POST['meter_read_date'];
	$uploaded_rc = $_FILES['uploaded_rc'];
	$form_data = array('vehicle_no'=>$vehicle_no,'owner_id'=>$owner_id1,'agent_id'=>$agent_id,'vehicle_type_id'=>$vehicle_type_id,'chassis_no'=>$chassis_no,'engine_no'=>$engine_no,'meter_read'=>$meter_read,'meter_read_date'=>$meter_read_date,'created_date'=>$currentdate);
	 
	if($keyvalue  == 0)
	{
	$count = check_duplicate($connection,$tblname,"vehicle_no='$vehicle_no'");
		if($count == 0)
		{
			dbRowInsert($connection,$tblname, $form_data);
	       $lastownerid = $connection->insert_id;
			  $imgpath2="upload/rcbook/";
			  
            	$uploaded_filename1 = uploadImage($imgpath2,$uploaded_rc); 
            	
            mysqli_query($connection,"update $tblname set uploaded_rc='$uploaded_filename1' where $tblpkey='$lastownerid'");
			echo "<script>location='$pagename?action=1'</script>";
		}
		else
		{
			$duplicate = "ERROR: Duplicate Record...";
		}
	}
	
	else
	{

    if($_FILES['uploaded_rc']['tmp_name']!="")
				{
		
					//delete old file
					$sql = mysqli_query($connection,"select * from $tblname where $tblpkey='$keyvalue'");
	             $rowimg = mysqli_fetch_array($sql);
			
					$oldimg = $rowimg["uploaded_rc"]; 
					if($oldimg != ""){
					unlink("upload/rcbook/$oldimg");
				}
				 $imgpath="upload/rcbook/";
					//insert new file
				$uploaded_filename = uploadImage($imgpath,$uploaded_rc);
				
					mysqli_query($connection,"update $tblname set uploaded_rc='$uploaded_filename' where $tblpkey='$keyvalue'");
				}
		$form_data = array('vehicle_no'=>$vehicle_no,'owner_id'=>$owner_id1,'agent_id'=>$agent_id,'vehicle_type_id'=>$vehicle_type_id,'chassis_no'=>$chassis_no,'engine_no'=>$engine_no,'meter_read'=>$meter_read,'meter_read_date'=>$meter_read_date,'updated_date'=>$currentdate);
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

	<title>Vehicle Mater :: Chaaruvi Infotech Pvt. Ltd.</title>

<?php include("inc/top-files.php"); ?>	
</head>
<body>
	 <!-- OWNER TRANSFER Modal Start-->
	<div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog" style="width:480px;padding-top: 225px;" >


      <div class="modal-content" style="border-radius: 20px;">
        <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
          <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
          <center>
          <h4 class="modal-title"><b>OWNER TRANSFER <b></h4></center>
        </div>
        <form method="post" action="savenewower.php" class='form-horizontal' enctype="multipart/form-data">
        <div class="modal-body" style="padding-top:30px;">
         
         <br>
         
          <div class="row mb-3">
            <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Owner Name</label>
            <div class="col-sm-6">
 	<select name="owner_id" id="owner_id" class='select2-me' style="width:100%;" required>
													<option value="">      Select  </option>
		<?php	$sql = mysqli_query($connection,"Select * from  m_vehicle_owner  order by owner_id ");
										  while($row= mysqli_fetch_array($sql)) { ?>
											<option value="<?php echo $row['owner_id']; ?>"><?php echo $row['owner_name']; ?></option>
								<?php } ?>

											</select>
            </div>
          </div>
        <br>
         <div class="row mb-3">
            <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Date</label>
            <div class="col-sm-6">
              <input type="date" name="transfer_date" id="transfer_date"  class="form-control" placeholder="" required>
            </div>
          </div>
          <br>
             <div class="row mb-3">
            <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Remark</label>
            <div class="col-sm-6">
              <input type="text" name="transfer_remark" id="transfer_remark"  class="form-control" placeholder="Enter Remark" required>
              <input type="hidden" name="vehicle_id" id="vehicle_id"  class="form-control" placeholder="Enter Remark" required>
            </div>
          </div>
          <br><br>
          <div class="modal-footer" >
          	<center>
            <button class="btn btn-primary" name="savetruck" tabindex="12"> Save</button>
            <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a></center>
          </div>
        </div>
</form>
      </div>
    </div>

  </div>
  <!-- OWNER TRANSFER Modal End -->
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
									<i class="fa fa-list"></i>Vehicle Master</h3>
							</div>
							<div class="box-content nopadding">
								<form action="#" method="POST" class='form-horizontal form-column form-bordered' enctype="multipart/form-data">
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Vehicle No. <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="text" name="vehicle_no" id="vehicle_no" placeholder="Vehicle Number" class="form-control"  value="<?php echo $vehicle_no; ?>" required>
												</div>
											</div>
										
										</div>
                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Owner Name <span style="color: red">*</span></label>
												<div class="col-sm-8">
												<select name="owner_id1" id="owner_id1" class='select2-me' required style="width:343px;">
													<option value="">      Select  </option>
												<?php		$sql = mysqli_query($connection,"Select * from  m_vehicle_owner  order by owner_id ");
										  while($row= mysqli_fetch_array($sql)) { ?>
										  	
												<option value="<?php echo $row['owner_id']; ?>"><?php echo $row['owner_name']; ?></option>
								<?php } ?>

											</select>
					<script>document.getElementById('owner_id1').value = '<?php echo $owner_id1; ?>';</script>
												</div>
											</div>
										
										</div>
                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Agent Name</label>
												<div class="col-sm-8">
												<select name="agent_id" id="agent_id" class='select2-me' style="width:342px;">
													<option value="">      Select  </option>
												<?php		$sql = mysqli_query($connection,"Select * from  m_agent  order by agent_id ");
										  while($row= mysqli_fetch_array($sql)) { ?>
										  	
												<option value="<?php echo $row['agent_id']; ?>"><?php echo $row['agent_name']; ?></option>
								<?php } ?>

											</select>
					<script>document.getElementById('agent_id').value = '<?php echo $agent_id; ?>';</script>
												</div>
											</div>
										
										</div>
			                       </div>
									
									
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Vehicle Type <span style="color: red">*</span></label>
												<div class="col-sm-8">
												<select name="vehicle_type_id" id="vehicle_type_id" class='select2-me' style="width:340px;" required>
												<option value="">      Select  </option>	
												<?php		$sql = mysqli_query($connection,"Select * from  m_vehicle_type  order by vehicle_type_id ");
										  while($row= mysqli_fetch_array($sql)) { ?>
										  	
												<option value="<?php echo $row['vehicle_type_id']; ?>"><?php echo $row['no_of_wheels']; ?> - <?php echo $row['vehicle_type']; ?></option>
								<?php } ?>

											</select>
					<script>document.getElementById('vehicle_type_id').value = '<?php echo $vehicle_type_id; ?>';</script>
												</div>
											</div>
										
										</div>
                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Chassis No </label>
												<div class="col-sm-8">
													<input type="text" name="chassis_no" id="chassis_no" placeholder="Chassis Number" class="form-control" value="<?php echo $chassis_no; ?>">
												</div>
											</div>
										
										</div>
                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Engine No. </label>
												<div class="col-sm-8">
													<input type="text" name="engine_no" id="engine_no" placeholder="Engine Number" class="form-control" value="<?php echo $engine_no; ?>">
												</div>
											</div>
										
										</div>
			                       </div>

                                   <div class="row">
									   
									   
									   <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Upload RC Book</label>
												<div class="col-sm-8">
													<input type="file" name="uploaded_rc" id="uploaded_rc" placeholder="Text input" class="form-control" value="<?php echo $uploaded_rc; ?>">
													<?php if($uploaded_rc!=''){ ?>		<span><img style="width: 80px; height: 80px;border-radius: 10px;border: 2px solid black;" src="upload/rcbook/<?php echo $uploaded_rc ?>" alt="<?php echo $uploaded_rc; ?>" /></span><?php } ?>
												</div>
											</div>
										
										</div>
									   
									   
									   
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Meter Reading</label>
												<div class="col-sm-8">
													<input type="text" name="meter_read" id="meter_read" placeholder="Meter Reading" class="form-control" value="<?php echo $meter_read; ?>">
												</div>
											</div>
										
										</div>


                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Meter Reading Date</label>
												<div class="col-sm-8">
													<input type="date" name="meter_read_date" id="meter_read_date" placeholder="Text input" class="form-control" value="<?php echo $meter_read_date; ?>">
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
									Vehicle  Master Details
								</h3>
								<a href="pdf/pdf_m_vehicle.php" class="btn" style="float: right" target="_blank">Pdf 
											<i class="fa fa-file-pdf-o"></i>
										</a> &nbsp;
					<a href="excel/excel_vehicle.php" class="btn btn-warning" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a> 		
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-colvis">
									<thead>
									        <th>Sno.</th>
											<th>Vehicle No.</th>
											<th>Owner Name</th>
											<th>Agent Name</th>
											<th>Vehicle Type </th>
											<th>Chassis No.</th>
											<th>Engine No.</th>
											<th>Meter Reading</th>
											<th>Meter Reading Date</th>
											<th>RC Book</th>
											<th>Owner Transfer</th>
                                            <th>Action</th>
									</thead>
									<tbody>
											   <?php
										$sn=1;
						$sql = mysqli_query($connection,"Select * from  $tblname  order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
		$owner_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$row[owner_id]");
		$agent_name=$cmn->getvalfield($connection,"m_agent","agent_name","agent_id=$row[agent_id]");
		$vehicle_type=$cmn->getvalfield($connection,"m_vehicle_type","vehicle_type","vehicle_type_id=$row[vehicle_type_id]");
		$no_of_wheels=$cmn->getvalfield($connection,"m_vehicle_type","no_of_wheels","vehicle_type_id=$row[vehicle_type_id]");
										   ?>
										<tr>
											<td><?php echo $sn++; ?></td>
                                            <td><?php echo $row['vehicle_no']; ?></td>
                                            <td><?php echo $owner_name; ?></td>
                                            <td><?php echo $agent_name; ?></td>
                                            <td><?php echo $no_of_wheels."-".$vehicle_type; ?></td>
                                            <td><?php echo $row['chassis_no']; ?></td>
                                            <td><?php echo $row['engine_no']; ?></td>
                                            <td><?php echo $row['meter_read']; ?></td>
                                            <td><?php echo dateformatindia($row['meter_read_date']); ?></td>
                                           <td><b><a href="upload/rcbook/<?php echo $row['uploaded_rc'] ?>" class="text-danger"  target="_blank" download>Download</a></b></td>
                                           <td>
                                           	<button name="submit"  class="btn btn-primary center" onClick="getno(<?php echo $row['vehicle_id']; ?>)" type="submit">Owner Transfer</button></td>
											<td class='hidden-350'>
										<?php if ($user_type == 'admin') { ?>		<a href="?editid=<?php echo $row['vehicle_id']; ?>" class="btn btn-primary" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
							  <a href="<?php echo $pagename ?>" class="btn btn-danger" onClick="funDel(<?php echo $row['vehicle_id']; ?>)" rel="tooltip" title="Delete"><i class="fa fa-times"></i></a>	<?php } ?>
							  </td>
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


        function getno(vehicle_id){		
// alert(vehicle_id);
jQuery("#myModal1").modal('show');
jQuery("#vehicle_id").val(vehicle_id);
jQuery("#status").val(status);

		}
    </script>
</body>



</html>
									