<?php 
include("adminsession.php");
$tblname = "paid_to";
$tblpkey = "payee_id";
$pagename ="paid_to_master.php";
$modulename = "Paid Master";
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
	 $payee_name = $row['payee_name']; 
     $account_no = $row['account_no']; 
	 $ifsc_code = $row['ifsc_code']; 
	 $pan_no = $row['pan_no']; 
}
else
{
	$payee_name = '';
    $account_no = '';
    $ifsc_code = '';
    $pan_no = '';
}
if(isset($_POST['submit']))
{
	  $payee_name = $_POST['payee_name'];
	  $account_no = $_POST['account_no'];
	  $ifsc_code= $_POST['ifsc_code'];
	  $pan_no = $_POST['pan_no'];
   
	  $form_data = array('payee_name'=>$payee_name,'account_no'=>$account_no,'ifsc_code'=>$ifsc_code,'pan_no'=>$pan_no,'created_date'=>$currentdate); 
	if($keyvalue  == 0)
	{
		  $count = check_duplicate($connection,$tblname,"account_no='$account_no'");
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
	$form_data = array('payee_name'=>$payee_name,'account_no'=>$account_no,'ifsc_code'=>$ifsc_code,'pan_no'=>$pan_no,'updated_date'=>$currentdate);
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

	<title>PAID TO MASTER  :: CHAARUVI INFOTEH PVT. LTD.</title>

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
									<i class="fa fa-list"></i>Paid To Master </h3>
							</div>
							<div class="box-content nopadding">
                            <form action="" method="POST" class='form-horizontal form-column form-bordered'>
    <div class="row">
        <!-- Payee Name -->
        <div class="col-sm-3">
            <div class="form-group">
                <label for="textfield" class="control-label col-sm-4">Payee Name <span style="color: red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" name="payee_name" id="payee_name" placeholder="Payee Name" class="form-control" value="<?php echo $payee_name; ?>" required>
                </div>
            </div>
        </div>

        <!-- Account No -->
        <div class="col-sm-3">
            <div class="form-group">
                <label for="account_no" class="control-label col-sm-4">Account No <span style="color: red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" name="account_no" id="account_no" placeholder="Account No" class="form-control" value="<?php echo $account_no; ?>" required maxlength="17">
                </div>
            </div>
        </div>

        <!-- IFSC Code -->
        <div class="col-sm-3">
            <div class="form-group">
                <label for="ifsc_code" class="control-label col-sm-4">IFSC Code </label>
                <div class="col-sm-8">
                    <input type="text" name="ifsc_code" id="ifsc_code" placeholder="IFSC Code" class="form-control" value="<?php echo $ifsc_code; ?>" maxlength="11">
                </div>
            </div>
        </div>

        <!-- PAN No -->
        <div class="col-sm-3">
            <div class="form-group">
                <label for="pan_no" class="control-label col-sm-4">PAN No </label>
                <div class="col-sm-8">
                    <input type="text" name="pan_no" id="pan_no" placeholder="PAN No" class="form-control" value="<?php echo $pan_no; ?>"  maxlength="10">
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
								<h3><i class="fa fa-table"></i>Paid To Details</h3>
	<!--			<a href="pdf/pdf_m_unit.php" class="btn" style="float: right" target="_blank">Pdf -->
	<!--							<i class="fa fa-file-pdf-o"></i></a> &nbsp;-->
	<!--<a href="excel/excel_unit.php" class="btn btn-warning" style="float: right">Excel-->
	<!--			<i class="fa fa-file-excel-o"></i></a>-->
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-colvis">
									<thead>
										<tr>
											<th>Sno.</th>
											<th>Payee Name</th>
                                            <th>Account No</th>
                                            <th>IFCS Code</th>
                                            <th>PAN No</th>
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
											<td><?php echo $row['payee_name'];?></td>
											<td><?php echo $row['account_no'];?></td>
											<td><?php echo $row['ifsc_code'];?></td>
											<td><?php echo $row['pan_no'];?></td>
											<td class='hidden-350'><?php if ($user_type == 'admin') { ?>
											<a href="?editid=<?php echo $row['payee_id']; ?>" class="btn btn-primary" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
											  <a href="<?php echo $pagename ?>" class="btn btn-danger" onClick="funDel(<?php echo $row['payee_id']; ?>)" rel="tooltip" title="Delete"><i class="fa fa-times"></i></a>	<?php } ?>
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
									