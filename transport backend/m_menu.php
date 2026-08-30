<?php
include("adminsession.php");
error_reporting(0);
$pagename = "m_menu.php";

$dup = '';
if ($_GET['eid'] != '') {
	//   echo "select * from m_menu WHERE menu_id='$_GET[eid]'";
	$sql = mysqli_query($connection, "select * from m_menu WHERE menu_id='$_GET[eid]'");
	$row = mysqli_fetch_array($sql);
	$menuname  = $row['menu_name'];
	$type = $row['type'];
	$pagename = $row['pagename'];
	// echo $menuname;

} else {
	$menuname  = '';
	$type = '';
	$pagename = '';
}
if (isset($_POST['submit'])) {
	$menuname  = $_POST['menu_name'];
	// echo $menuname ; die;

	$menuid = $_POST['menu_id'];
	$type = $_POST['type'];
	$pagename = $_POST['pagename'];
	if ($menuid == '') {
		$sqlcheckdup = mysqli_query($connection, "SELECT * FROM m_menu WHERE menu_name ='$menuname'");

		$check = mysqli_num_rows($sqlcheckdup);
		if ($check > 0) {
			$dup = "<div class='alert alert-danger'>
   			<strong>Error!</strong> Error : Duplicate Record.
   			</div>";
		} else {

			// echo "INSERT into m_menu set menu_name ='$menuname',type='$type',pagename='$pagename',createdate=Now()";die;
			mysqli_query($connection, "INSERT into m_menu set menu_name ='$menuname',type='$type',pagename='$pagename',createdate=Now()");
			$action = 1;
			echo "<script>location='m_menu.php?action=$action'</script>";
		}
	} else {
		// echo "UPDATE m_menu set menu_name ='$menuname ',updated_date=Now() WHERE menu_id='$_GET[eid]' "; die;
		mysqli_query($connection, "UPDATE m_menu set menu_name ='$menuname ',type='$type',pagename='$pagename',updated_date=Now() WHERE menu_id='$_GET[eid]'");
		$action = 2;
		echo "<script>location='m_menu.php?action=$action'</script>";
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

	<!-- <title>ITEM CATEGORY MASTER</title> -->

	<?php include("inc/top-files.php"); ?>
</head>

<body>

	<?php include("inc/model.php"); ?>

	<?php include("inc/top-header.php"); ?>


	<div class="container-fluid" id="content">
		<?php include("inc/left-menu.php"); ?>

		<div id="main">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-12">
						<div class="box box-bordered box-color">
							<div class="box-title">
								<h3>
									<i class="fa fa-list"></i>Menu Master
								</h3>
							</div>
							<div class="box-content nopadding">
								<?php include("include/alerts.php"); ?>
								<?php echo  $dup;  ?>
								<form action="" method="post" class='form-horizontal form-column form-bordered'>
									<div class="row">
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Menu Name<span style="color: red;">*</span></label>
												<div class="col-sm-8">
													<input type="text" name="menu_name" id="menu_name" value="<?php echo $menuname; ?>" tabindex="1" placeholder="Menu Name" class="form-control" required>
												</div>
											</div>

										</div>

										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Type<span style="color: red;">*</span></label>
												<div class="col-sm-8">
													<select name="type" id="type" class='select2-me' style="width:100%;">
														<option value="">Select</option>


														<option value="Module">Module</option>
														<option value="Menu">Menu</option>

													</select>
													<script>
														document.getElementById('type').value = '<?php echo $type; ?>';
													</script>

												</div>

											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Page Link</label>
												<div class="col-sm-8">
													<input type="text" name="pagename" id="pagename" value="<?php echo $pagename; ?>" tabindex="1" placeholder="Menu Name" class="form-control">
												</div>
											</div>

										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<div class="form-actions">
												<center>
													<button type="submit" name="submit" class="btn btn-primary" tabindex="2">
														Save</button>
													<a href="m_menu.php" name="reset" id="reset" class="btn btn-success" tabindex="3">Reset</a>
													<input type="hidden" name="menu_id" id="menu_id" value="<?php echo $_GET['eid']; ?>">

												</center>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!--<p align="right" style="margin-top:7px;"> <a href="pdf_m_item_category.php" class="btn btn-primary" target="_blank">-->
				<!--                 <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>				-->
				<div class="row">
					<div class="col-sm-12">
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-table"></i>
									Menu Master Details
								</h3>
							</div>
							<div class="box-content nopadding">
								<table class="table" id="mytable">
									<thead>

										<th>S.no.</th>
										<th>Menu Name</th>

										<th class='hidden-350'>Action</th>


									</thead>
									<tbody style="text-transform:uppercase;">
										<?php $sn = 1;
										$sql = mysqli_query($connection, "select * from m_menu  order by menu_id desc");
										while ($row = mysqli_fetch_array($sql)) {
										?>
											<tr>
												<td><?php echo $sn++; ?></td>
												<td><?php echo $row['menu_name']; ?></td>



												<td>

													<a href="m_menu.php?eid=<?php echo $row['menu_id']; ?>" class="btn btn-magenta">
														Edit
													</a>

												</td>
											<?php } ?>
											</tr>

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
			var tablename = 'm_menu';
			var tableid = 'menu_id';
			if (confirm("Do You want to Delete this record ?")) {
				jQuery.ajax({
					type: 'POST',
					url: 'ajax/delete_master.php',
					data: 'id=' + id + '&tablename=' + tablename + '&tableid=' + tableid,
					dataType: 'html',
					success: function(data) {
						// alert(data);
						location = 'm_menu.php?action=3';
					}
				});
			}
		}
	</script>
</body>



</html>