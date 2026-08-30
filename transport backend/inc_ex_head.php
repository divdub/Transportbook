<?php 
include("adminsession.php");
$tblname = "inc_exp_head";
$tblpkey = "inc_exp_id";
$pagename = "inc_ex_head.php";
$modulename = "Head Master";
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
	 $head_name = $row['head_name']; 
	$head_type  = $row['head_type'];
	$remark=$row['remark'];
}
else
{
	$head_name = '';
	$head_type  = '';
	$remark='';
}
if(isset($_POST['submit']))
{
	  $head_name = $_POST['head_name'];
	 $head_type =$_POST['head_type'];
	 $remark=$_POST['remark'];
	$form_data = array('head_name'=>$head_name,'head_type'=>$head_type,'remark'=>$remark,'created_date'=>$currentdate);
	 
	if($keyvalue  == 0)
	{
		$count = check_duplicate($connection,$tblname,"head_name='$head_name'");
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
	$form_data = array('head_name'=>$head_name,'head_type'=>$head_type,'remark'=>$remark,'updated_date'=>$currentdate);
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

	<title>INCOME/EXPENSES HEAD MASTER :: CHAARUVI INFOTECH PVT. LTD.</title>

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
									<i class="fa fa-list"></i>Head Master</h3>
							</div>
							<div class="box-content nopadding">
								<form action="#" method="POST" class='form-horizontal form-column form-bordered'>
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Head Name</label>
												<div class="col-sm-8">
													<input type="text" name="head_name" id="head_name" placeholder="Enter Head Name" class="form-control" value="<?php echo $head_name; ?>" required>
												</div>
											</div>
										
										</div>
                                        
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Remark</label>
												<div class="col-sm-8">
													<input type="text" name="remark" id="remark" placeholder="Enter Remark" class="form-control" value="<?php echo $remark; ?>">
												</div>
											</div>
										
										</div>
										
										
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Head Type</label>
												<div class="col-sm-8">
                                               <select name="head_type" id="head_type" class='form-control'>
													<option value="">Select</option>	
												<option value="Income">Income</option>
												<option value="Expenses">Expenses</option>
												</select>
					<script>document.getElementById('head_type').value = '<?php echo $head_type; ?>';</script>
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
									Income/Expenses Details
								</h3>
		<a href="pdf/pdf_m_inc_ex_head.php" class="btn" style="float: right" target="_blank">Pdf 
										<i class="fa fa-file-pdf-o"></i></a> &nbsp;
			<a href="excel/excel_inc_ex_head.php" class="btn btn-warning" style="float: right">Excel
							<i class="fa fa-file-excel-o"></i></a>						
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-colvis">
									<thead>
										<tr>
											<th>S.no.</th>
											<th>Head Name</th>
											<th>Head Type</th>
											<th>Remark</th>
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
											<td><?php echo $row['head_name'];?></td>
											<td><?php echo $row['head_type'];?></td>
											<td><?php echo $row['remark'];?></td>
											<td class='hidden-350'> <?php if ($user_type == 'admin') { ?>
			<a href="?editid=<?php echo $row['inc_exp_id']; ?>" class="btn btn-primary" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
						  <a href="<?php echo $pagename ?>" class="btn btn-danger" onClick="funDel(<?php echo $row['inc_exp_id']; ?>)" rel="tooltip" title="Delete"><i class="fa fa-times"></i></a> 	<?php } ?>	
											
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
									