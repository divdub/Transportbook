<?php
include("adminsession.php");
error_reporting(0);
$pagename = "m_submenu.php";

$dup = '';
if (isset($_POST['submit'])) {
	$sub_menu  = $_POST['submenu'];
	// echo $sub_menu ; die;
	$sub_cat  = $_POST['sub_cat'];
	$menuid = $_POST['menu_id'];
	$pagelink  = $_POST['pagelink'];
	$sub_menu_id  = $_POST['submenu_id'];
	if ($sub_menu_id == '') {
		$sqlcheckdup = mysqli_query($connection, "SELECT * FROM m_submenu WHERE menu_id='$menuid' && submenu ='$sub_menu'");

		$check = mysqli_num_rows($sqlcheckdup);
		if ($check > 0) {
			$dup = "<div class='alert alert-danger'>
   			<strong>Error!</strong> Error : Duplicate Record.
   			</div>";
		} else {

			// echo "INSERT into m_submenu set submenu ='$sub_menu',sub_cat ='$sub_cat',menu_id ='$menuid',pagelink ='$pagelink',createdate=Now()";die;
			mysqli_query($connection, "INSERT into m_submenu set submenu ='$sub_menu',sub_cat ='$sub_cat',menu_id ='$menuid',pagelink ='$pagelink',createdate=Now()");
			$action = 1;
			echo "<script>location='m_submenu.php?action=$action'</script>";
		}
	} else {
		// echo "UPDATE m_submenu set submenu ='$sub_menu ',updated_date=Now() WHERE menu_id='$_GET[eid]' "; die;
		mysqli_query($connection, "UPDATE m_submenu set submenu ='$sub_menu',sub_cat ='$sub_cat',menu_id ='$menuid',pagelink ='$pagelink',updated_date=Now() WHERE submenu_id='$_GET[eid]'");
		$action = 2;
		echo "<script>location='m_submenu.php?action=$action'</script>";
	}
}

if ($_GET['eid'] != '') {
	$sql = mysqli_query($connection, "select * from m_submenu WHERE submenu_id='$_GET[eid]'");
	$row = mysqli_fetch_array($sql);
	$sub_menu  = $row['submenu'];
	$sub_cat  = $row['sub_cat'];
	$menuid = $row['menu_id'];
	$pagelink  = $row['pagelink'];
} else {
	$sub_menu  = '';
	$sub_cat  = '';
	$menuid  = '';
	$pagelink  = '';
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
									<i class="fa fa-list"></i>Sub Menu Master
								</h3>
							</div>
							<div class="box-content nopadding">
								<?php include("include/alerts.php"); ?>
								<?php echo  $dup;  ?>
								<form action="" method="post" class='form-horizontal form-column form-bordered'>
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4"> Menu Name<span style="color: red;">*</span></label>
												<div class="col-sm-8">
													<select data-placeholder="Choose a Country..." name="menu_id" id="menu_id" style="width:100%;" tabindex="3" class="formcent select2-me">
														<option value="">Select Name</option>
														<?php
														$sql = mysqli_query($connection, "select * from m_menu ");
														while ($row = mysqli_fetch_array($sql)) {

														?>
															<option value="<?php echo $row['menu_id']; ?>"><?php echo $row['menu_name']; ?></option>

														<?php } ?>
														<script>
															document.getElementById('menu_id').value = '<?php echo $menuid; ?>';
														</script>

													</select>
												</div>
											</div>

										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Sub Menu Name<span style="color: red;">*</span></label>
												<div class="col-sm-8">
													<input type="text" name="submenu" id="submenu" value="<?php echo $sub_menu; ?>" tabindex="1" placeholder="Menu Name" class="form-control" required>
												</div>
											</div>

										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">First Position<span style="color: red;">*</span></label>
												<div class="col-sm-8">
													<select data-placeholder="Choose a Country..." name="sub_cat" id="sub_cat" style="width:250px" tabindex="3" class="formcent select2-me">
														<option value="">Select</option>
														<option value="1">Yes</option>
														<option value="0">No</option>

														<script>
															document.getElementById('sub_cat').value = '<?php echo $sub_cat; ?>';
														</script>

													</select>
												</div>
											</div>

										</div>
									</div>
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Page Link</label>
												<div class="col-sm-8">
													<input type="text" name="pagelink" id="pagelink" value="<?php echo $pagelink; ?>" tabindex="1" placeholder="Menu Name" class="form-control">
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
													<a href="m_submenu.php" name="reset" id="reset" class="btn btn-success" tabindex="3">Reset</a>
													<input type="hidden" name="submenu_id" id="submenu_id" value="<?php echo $_GET['eid']; ?>">

												</center>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<p align="right" style="margin-top:7px;"> <a href="pdf_m_item_category.php" class="btn btn-primary" target="_blank">
						<span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>
				<div class="row">
					<div class="col-sm-12">
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-table"></i>
									Sub Menu Master Details
								</h3>
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis" id="mytable">
									<thead>

										<th>S.no.</th>
										<th>Menu Name</th>
										<th>Sub Menu Name</th>
										<th>First Position</th>
										<th>PageLink</th>
										<th class='hidden-350'>Action</th>


									</thead>
									<tbody style="text-transform:uppercase;">
										<?php $sn = 1;
										$sql = mysqli_query($connection, "select * from m_submenu  order by submenu_id  desc");
										while ($row = mysqli_fetch_array($sql)) {
											$menu_name = $cmn->getvalfield($connection, "m_menu", "menu_name", "menu_id='$row[menu_id]'");

										?>
											<tr>
												<td><?php echo $sn++; ?></td>
												<td><?php echo $menu_name; ?></td>
												<td><?php echo $row['submenu']; ?></td>
												<td><?php if ($row['sub_cat'] == '1') {
														echo "Yes";
													} else {
														echo "No";
													}
													?></td>
												<td><?php echo $row['pagelink']; ?></td>

												<td>

													<a href="m_submenu.php?eid=<?php echo $row['submenu_id']; ?>" class="btn btn-magenta">
														Edit
													</a>
													<!--<a href="m_submenu.php" title="Delete" onClick="funDel(<?php echo $row['submenu_id']; ?>);" class="btn btn-satblue">-->
													<!--   Delete-->
													<!--</a>-->
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
			var tablename = 'm_submenu';
			var tableid = 'submenu_id';
			if (confirm("Do You want to Delete this record ?")) {
				jQuery.ajax({
					type: 'POST',
					url: 'ajax/delete_master.php',
					data: 'id=' + id + '&tablename=' + tablename + '&tableid=' + tableid,
					dataType: 'html',
					success: function(data) {
						// alert(data);
						location = 'm_submenu.php?action=3';
					}
				}); //ajax close
			}
		}
	</script>
</body>



</html>