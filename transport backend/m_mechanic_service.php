<?php 
error_reporting(0);
include("adminsession.php");
$tblname = "mechanic_service_master";
$tblpkey = "mechanic_id";
$pagename = "m_mechanic_service.php";
$modulename = "Mechanic Master";
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
	 $mechanic_name = $row['mechanic_name']; 
	$mobile_no  = $row['mobile_no'];
	$narration=$row['narration'];
	$address=$row['address'];
	$place_id=$row['place_id'];
    $opn_balnc=$row['opn_balnc'];
    $opn_balnc_date=$row['opn_balnc_date'];
 
}
else
{
	$mechanic_name = '';
	$mobile_no  = '';
	$narration  = '';
	$address  = '';
	$place_id  = '';
	$opn_balnc  = '';
	$opn_balnc_date  = '';
}

if(isset($_POST['submit']))
{
	  $mechanic_name = $_POST['mechanic_name'];
	 $mobile_no =$_POST['mobile_no'];
	 $narration =$_POST['narration'];
	 $address =$_POST['address'];
	 $place_id =$_POST['place_id'];
     $opn_balnc =$_POST['opn_balnc'];
	 $opn_balnc_date =$_POST['opn_balnc_date'];

	$form_data = array('mechanic_name'=>$mechanic_name,'mobile_no'=>$mobile_no,'narration'=>$narration,'address'=>$address,'place_id'=>$place_id,'opn_balnc'=>$opn_balnc,'opn_balnc_date'=>$opn_balnc_date,'created_date'=>$currentdate);
	 
	if($keyvalue  == 0)
	{
		$count = check_duplicate($connection,$tblname,"mechanic_name='$mechanic_name'");
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

	$form_data = array('mechanic_name'=>$mechanic_name,'mobile_no'=>$mobile_no,'narration'=>$narration,'address'=>$address,'place_id'=>$place_id,'opn_balnc'=>$opn_balnc,'opn_balnc_date'=>$opn_balnc_date,'updated_date'=>$currentdate);
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

	<title>Mechanic/Service Center Master :: Chaaruvi Infotech Pvt. Ltd.</title>

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
									<i class="fa fa-bars"></i>Mechanic/Service Center Master</h3>							
								
							</div>
							<div class="box-content nopadding">
								<form action="#" method="POST" class='form-horizontal form-column form-bordered'>
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">
Mechanic/Service Name <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="text" name="mechanic_name" id="mechanic_name" placeholder="Enter  Name" class="form-control" value="<?php echo $mechanic_name; ?>" required>
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
												<label for="textfield" class="control-label col-sm-4">Address</label>
												<div class="col-sm-8">
													<input type="text" name="address" id="address" placeholder="Enter Address" class="form-control" value="<?php echo $address; ?>">
												</div>
											</div>
										
										</div>
					</div>

	<div class="row">

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
                                        <div class="row">
                                        	<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Narration </label>
												<div class="col-sm-8">
													<input type="text" name="narration" id="narration" placeholder="Enter Narration" class="form-control" value="<?php echo $narration; ?>">
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
					Mechanic/Service Center Master Details</h3>
				
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
						<th>Mechanic Name</th>
						<th>Mobile No.</th>
						<th>City</th>
						<th>Opening Balance</th>
						<th>Opening Balance Date</th>
						<th>Narration</th>
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
						<td><?php echo $row['mechanic_name']; ?></td>
						<td><?php echo $row['mobile_no']; ?></td>
						<td><?php echo $place_name; ?></td>
						<td class='hidden-350'><?php echo $row['opn_balnc']; ?></td>
						<td class='hidden-1024'><?php echo dateformatindia($row['opn_balnc_date']); ?></td>
						<td class='hidden-350'><?php echo $row['narration']; ?></td>
						<td class='hidden-480'> <?php if ($user_type == 'admin') { ?>
			<a href="?editid=<?php echo $row['mechanic_id']; ?>" class="btn btn-primary" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
							  <a href="<?php echo $pagename ?>" class="btn btn-danger" onClick="funDel(<?php echo $row['mechanic_id']; ?>)" rel="tooltip" title="Delete"><i class="fa fa-times"></i></a>
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
