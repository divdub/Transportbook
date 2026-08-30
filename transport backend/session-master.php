<?php 
include("adminsession.php");
$tblname = "m_session";
$tblpkey = "session_id";
$pagename = "session-master.php";
$modulename = "Session Master";
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
	 $session_start = $row['session_start']; 
	$session_end 	 = $row['session_end'];
	$session_name    = $row['session_name'];
}
else
{
	$session_start = '';
	$session_end  = '';
	$session_name = '';
}
if(isset($_POST['submit']))
{
	  $session_start = $_POST['session_start'];
	 $session_end =$_POST['session_end'];
	$session_name = $_POST['session_name'];
	
	
	
	$form_data = array('session_start'=>$session_start,'session_end'=>$session_end,'session_name'=>$session_name,'created_date'=>$currentdate);
	 
	if($keyvalue  == 0)
	{
		$count = check_duplicate($connection,$tblname,"session_name='$session_name'");
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
		$form_data = array('session_start'=>$session_start,'session_end'=>$session_end,'session_name'=>$session_name,'updated_date'=>$currentdate);
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

	<title>SESSION MASTER</title>

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
									<i class="fa fa-list"></i>Session Master</h3>
							</div>
							<div class="box-content nopadding">
								<form action="#" method="POST" class='form-horizontal form-column form-bordered'>
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Session Start <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="date" name="session_start" id="session_start" placeholder="Text input" value="<?php echo $session_start; ?>" class="form-control"required>
												</div>
											</div>
										
										</div>
										
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Session End <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="date" name="session_end" id="session_end" placeholder="Text input" value="<?php echo $session_end; ?>" class="form-control" required>
												</div>
											</div>
										
										</div>
										
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Session Name <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="text" name="session_name" id="session_name" placeholder="Session Name" value="<?php echo $session_name; ?>" class="form-control" required>
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
									Session Details
								</h3>
					<a href="pdf/pdf_m_session.php" class="btn" style="float: right" target="_blank">Pdf 
											<i class="fa fa-file-pdf-o"></i>
										</a> &nbsp;
					<a href="excel/excel_session.php" class="btn btn-warning" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a> 		
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-colvis">
									<thead>
										<tr>
											<th>Sno</th>
											<th>Session Start</th>
											<th>Session End</th>
											<th>Session Name</th>
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
											<td><?php echo $sn++;?></td>
											<td>
												<?php echo date('d-m-Y', strtotime($row['session_start'])); ?>
											</td>
											<td><?php echo date('d-m-Y', strtotime($row['session_end'])); ?></td>
											<td><?php echo $row['session_name']; ?></td>
											<td class='hidden-350'>
											    	<?php if ($user_type == 'admin') { ?>
												<a href="?editid=<?php echo $row['session_id']; ?>" class="btn btn-primary" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
												  <a href="<?php echo $pagename ?>" class="btn btn-danger" onClick="funDel(<?php echo $row['session_id']; ?>)" rel="tooltip" title="Delete"><i class="fa fa-times"></i></a>
												  	<?php } ?>
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
    </script>
</body>



</html>
