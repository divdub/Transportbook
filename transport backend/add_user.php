<?php 
error_reporting(0);
include("adminsession.php");
$tblname = "m_userlogin";
$tblpkey = "user_id ";
$pagename = "add_user.php";
$modulename = "User Master";
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
	 $user_name = $row['user_name']; 
	$user_type 	 = $row['user_type'];
	$password    = $row['password'];
	$consignor_id=$row['consignor_id'];
	$sessionid=$row['session_id'];
}
else
{
	$user_name = '';
	$user_type  = '';
	$password = '';
	$consignor_id='';
	$sessionid='';

}
if(isset($_POST['submit']))
{
	  $user_name = $_POST['user_name'];
	 $user_type =$_POST['user_type'];
	$password = $_POST['password'];
	$consignor_id = $_POST['consignor_id'];
	$sessionid = $_POST['sessionid'];
	$form_data = array('user_name'=>$user_name,'user_type'=>$user_type,'password'=>$password,'consignor_id'=>$consignor_id,'session_id'=>$sessionid,'comp_id'=>$comp_id,'created_date'=>$currentdate);
	 
	if($keyvalue  == 0)
	{
	$count = check_duplicate($connection,$tblname,"user_name='$user_name' && user_type='$user_type'");
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
$form_data = array('user_name'=>$user_name,'user_type'=>$user_type,'password'=>$password,'consignor_id'=>$consignor_id,'updated_date'=>$currentdate,'session_id'=>$sessionid);

		
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

	<title>User Master :: Chaaruvi Infotech Pvt. Ltd.</title>

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
									<i class="fa fa-list"></i>User Master</h3>
							</div>
							<div class="box-content nopadding">
								<form action="#" method="POST" class='form-horizontal form-column form-bordered' enctype="multipart/form-data">
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">User Name <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="text" name="user_name" id="user_name" placeholder="User Name " value="<?php echo $user_name;?>" class="form-control" required>
												</div>
											</div>
										
										</div>
                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Password<span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="password" name="password" id="password" placeholder="Enter Password" value="<?php echo $password; ?>" class="form-control" required>
												</div>
											</div>
										
										</div>
										
                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Re-enter Password</label>
												<div class="col-sm-8">
													<input type="password" name="rpwd" id="rpwd" placeholder="Re-enter Password" value="<?php echo $rpwd; ?>" class="form-control" onchange="matchPassword();">
												</div>
											</div>
										
										</div>
			                       </div>

                                   <div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Usertype<span style="color: red">*</span></label>
												<div class="col-sm-8">
												      <select name="user_type" id="user_type" class='form-control' required>
												<option value="">Select</option>
												<option value="admin">ADMIN</option>
												<option value="user">USER</option>
												</select>
											<script>document.getElementById('user_type').value = '<?php echo $user_type; ?>';</script>
												</div>
											</div>
										
										</div>
                                        <div class="col-sm-4">
											<div class="form-group">
							<label for="textfield" class="control-label col-sm-4">Consignor</label>
												<div class="col-sm-8">
							<select name="consignor_id" id="consignor_id" class='select2-me' style="width:100%;">
                                                	<option value="">      Select  </option>
				<?php	$sql = mysqli_query($connection,"Select * from  m_consignor  order by consignor_id ");
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
							<label for="textfield" class="control-label col-sm-4">Session</label>
												<div class="col-sm-8">
							<select name="sessionid" id="sessionid" class='select2-me' style="width:100%;">
                                                	<option value="">      Select  </option>
				<?php	$sql = mysqli_query($connection,"Select * from  m_session  order by session_id ");
										  while($row= mysqli_fetch_array($sql)) { ?>
										  	
												<option value="<?php echo $row['session_id']; ?>"><?php echo $row['session_name']; ?></option>
								<?php } ?>

											</select>
					<script>document.getElementById('sessionid').value = '<?php echo $sessionid; ?>';</script>
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
									User  Master Details
								</h3>
				<!-- 	<a href="pdf/pdf_m_agent.php" class="btn" style="float: right" target="_blank">Pdf 
											<i class="fa fa-file-pdf-o"></i>
										</a> &nbsp;
					<a href="excel/excel_agent.php" class="btn btn-warning" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a>  -->		
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-colvis">
									<thead>
									       <th>Sno.</th>
										     <th>User Name</th>
											<th>Usertype.</th>
											<th>Consignor</th>
											<th>Session </th>
                                            <th>Action</th>
									</thead>
									<tbody>
										  <?php
										$sn=1;
						$sql = mysqli_query($connection,"Select * from  $tblname where user_type='user' order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {

										  		$consignor_name=$cmn->getvalfield($connection,"m_consignor","consignor_name","consignor_id=$row[consignor_id]");
					$session_name=$cmn->getvalfield($connection,"m_session","session_name","session_id=$row[session_id]");
	   ?>
										<tr>
										
											<td><?php echo $sn++; ?></td>
                                            <td><?php echo $row['user_name']; ?></td>
                                            <td><?php echo $row['user_type']; ?></td>
                                            <td><?php echo $consignor_name; ?></td>
                                            <td><?php echo $session_name; ?></td>
                                            <!-- <td><?php echo $row['opn_balnc']; ?></td>
                                            <td><?php echo dateformatindia($row['opn_balnc_date']); ?></td>
                                            <td><b><a href="upload/agentaadhar/<?php echo $row['upload_aadhar'] ?>" class="text-danger"  target="_blank" download>Download</a></b></td> -->
											<td class='hidden-350'>
											<a href="?editid=<?php echo $row['user_id']; ?>" class="btn btn-primary" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
							  <a href="<?php echo $pagename ?>" class="btn btn-danger" onClick="funDel(<?php echo $row['user_id']; ?>)" rel="tooltip" title="Delete"><i class="fa fa-times"></i></a></td>
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

        function matchPassword() {
  var password = document.getElementById("password").value;
  // alert(password);
  var rpwd = document.getElementById("rpwd").value;
  // alert(rpwd);
  if(rpwd != password)
  {	
  	alert("Passwords did not match");
  } 
  
}
    </script>
</body>



</html>
									