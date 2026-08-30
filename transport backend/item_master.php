<?php 
error_reporting(0);
include("adminsession.php");
$tblname = "m_item";
$tblpkey = "item_id";
$pagename = "item_master.php";
$modulename = "Item Master";
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
	 $item_name = $row['item_name']; 
	$item_category_id  = $row['item_category_id'];
	$unit_id=$row['unit_id'];
}
else
{
	$item_name = '';
	$item_category_id  = '';
	$unit_id='';
}
if(isset($_POST['submit']))
{
	  $item_name = $_POST['item_name'];
	 $item_category_id =$_POST['item_category_id'];
	 $unit_id=$_POST['unit_id'];
	$form_data = array('item_name'=>$item_name,'item_category_id'=>$item_category_id,'unit_id'=>$unit_id,'created_date'=>$currentdate);
	 
	if($keyvalue  == 0)
	{
		$count = check_duplicate($connection,$tblname,"item_name='$item_name' && item_category_id='$item_category_id'");
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
	$form_data = array('item_name'=>$item_name,'item_category_id'=>$item_category_id,'unit_id'=>$unit_id,'updated_date'=>$currentdate);
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

	<title> ITEM MASTER :: CHAARUVI INFOTECH PVT. LTD.</title>

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
									<i class="fa fa-list"></i>Item Master</h3>
							</div>
							<div class="box-content nopadding">
								<form action="#" method="POST" class='form-horizontal form-column form-bordered'>
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Item Name <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="text" name="item_name" id="item_name" placeholder="Item Name" class="form-control" value="<?php echo $item_name; ?>"required>
												</div>
											</div>
										
										</div>
										
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Select Category 
													<!-- <span style="color: red">*</span> -->
												</label>
												<div class="col-sm-8">
												<select name="item_category_id" id="item_category_id" class='select2-me' style="width:340px;" >
													 <option value="">      Select Category </option>
											<?php		$sql = mysqli_query($connection,"Select * from  m_item_category  order by item_category_id ");
										  while($row= mysqli_fetch_array($sql)) { ?>
										 
												<option value="<?php echo $row['item_category_id']; ?>"><?php echo $row['category_name']; ?></option>
								<?php } ?>

											</select>
					<script>document.getElementById('item_category_id').value = '<?php echo $item_category_id; ?>';</script>
										
												</div>
											</div>
										
										</div>
										
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4"> Unit <span style="color: red">*</span></label>
												<div class="col-sm-8">
									<select name="unit_id" id="unit_id" class='select2-me' style="width:340px;" required>
													<option value="">      Select Unit </option>
											<?php		$sql = mysqli_query($connection,"Select * from  m_unit  order by unit_id ");
										  while($row= mysqli_fetch_array($sql)) { ?>
										  	
												<option value="<?php echo $row['unit_id']; ?>"><?php echo $row['unit_name']; ?></option>
								<?php } ?>

											</select>
					<script>document.getElementById('unit_id').value = '<?php echo $unit_id; ?>';</script>
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
									Item Master Details
								</h3>
									<a href="pdf/pdf_m_item.php" class="btn" style="float: right" target="_blank">Pdf 
											<i class="fa fa-file-pdf-o"></i>
										</a> &nbsp;
					<a href="excel/excel_item.php" class="btn btn-warning" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a> 		
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-colvis">
									<thead>
										<tr>
										     <th>Sno.</th>
											<th>Item Name</th>
											<th>Category Name</th>
											<th>Unit Name</th>
											<th class='hidden-350'>Action</th>
											
										</tr>
									</thead>
									<tbody>
											  <?php
										$sn=1;
						$sql = mysqli_query($connection,"Select * from  $tblname  order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
				$unit_name=$cmn->getvalfield($connection,"m_unit","unit_name","unit_id=$row[unit_id]");
					$category_name=$cmn->getvalfield($connection,"m_item_category","category_name","item_category_id=$row[item_category_id]");
						   ?>
										<tr>
											<td><?php echo $sn++; ?></td>
											<td><?php echo $row['item_name']; ?></td>
											<td><?php echo $category_name; ?></td>
											<td><?php echo $unit_name; ?></td>
										
											<td class='hidden-350'> <?php if ($user_type == 'admin') { ?>
						<a href="?editid=<?php echo $row['item_id']; ?>" class="btn btn-primary"rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
								  <a href="<?php echo $pagename ?>" class="btn btn-danger" onClick="funDel(<?php echo $row['item_id']; ?>)"rel="tooltip" title="Delete"><i class="fa fa-times"></i></a> 	<?php } ?>
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
