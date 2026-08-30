<?php 
error_reporting(0);
include("adminsession.php");
include("function/return_function.php");
$tblname = "trip_payment";
$tblpkey = "pay_id";
$pagename = "trip_payment_report.php";
$modulename = "Trip Payment Report";
$crit='';
if(isset($_GET['search']))
{
	 $fromdate = $_GET['fromdate'];
 	$todate = $_GET['todate'];
	
}
else
{
	$fromdate = $currentdate;
	$todate = $currentdate;

}

if (isset($_GET['consignor_id'])) {
	$consignor_id = trim(addslashes($_GET['consignor_id']));
} else
	$consignor_id = '';
	

if (isset($_GET['vehicle_id'])) {
	$vehicle_id = trim(addslashes($_GET['vehicle_id']));
} else
	$vehicle_id = '';


if ($fromdate != '' && $todate != '') {
	$crit .= "where rec_date BETWEEN  '$fromdate' and  '$todate' ";
	//echo $crit;
}

if ($vehicle_id != '') {
	$crit .= " and vehicle_id='$vehicle_id'";
}
if ($consignor_id != '') {
	$crit .= " and consignor_id='$consignor_id'";
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

	<title> RETURN :: CHAARUVI INFOTECH PVT. LTD.</title>

<?php include("inc/top-files.php"); ?>	
</head>

<body>
	    <!-- Edit Modal Start-->
	<div class="modal fade" id="myModal9" role="dialog">
    <div class="modal-dialog" style="width:900px;padding-top: 150px;" >


      <div class="modal-content" style="border-radius: 20px;">
        <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
          <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
          <center>
          <h4 class="modal-title"><b>EDIT ADVANCE ENTRY<b></h4></center>
        </div>
        <div class="modal-body" style="padding-top:30px;" id="updatedata">
    
        </div>

      </div>
    </div>

  </div>
  <!-- Edit Modal End-->


	<?php include("inc/model.php"); ?>
	
	<?php include("inc/top-header.php"); ?>
	
	
	<div class="container-fluid nav-hidden" id="content">
		<?php include("inc/left-menu.php"); ?>
		
		
		
		<div id="main">
			<div class="container-fluid">
				
				<?php include("inc/breadcrumbs.php"); ?>
				
				
				<div class="row">
					<div class="col-sm-12">
						<div class="box box-bordered box-color satblue">
							<div class="box-title">
								<h3>
									<i class="fa fa-list"></i>Trip Payment</h3>
							</div>
							<div class="box-content nopadding">
								<form action="#" method="GET" class='form-horizontal form-column form-bordered'>
									<div class="row">
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">From Date <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="date" name="fromdate" id="fromdate" placeholder="Text input" class="form-control" value="<?php echo $fromdate; ?>" required>
												</div>
											</div>
										
										</div>
										
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">To Date <span style="color: red">*</span></label>
												<div class="col-sm-8">
													<input type="date" name="todate" id="todate" placeholder="Text input" class="form-control" value="<?php echo $todate; ?>" required>
												</div>
											</div>
										
										</div>
										
	<!-- 									<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Item <span style="color: red">*</span></label>
												<div class="col-sm-8">
											<select name="item_id" id="item_id" class='select2-me' style="width:230px;" required>
												<option value="">Select</option>
									<?php	$sql = mysqli_query($connection,"Select * from  m_item  order by item_id");
										  while($row= mysqli_fetch_array($sql)) { ?>
										  	
								<option value="<?php echo $row['item_id']; ?>"><?php echo $row['item_name']; ?></option>
								<?php } ?>

											</select>
			<script>document.getElementById('item_id').value = '<?php echo $item_id; ?>';</script>
												</div>
											</div>
										
										</div> -->
										       <div class="col-sm-3">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">Truck No.</label>
                                       <div class="col-sm-8">
                                          <select name="vehicle_id" id="vehicle_id" class='select2-me' style="width:100%;">
                                             <option value="">      Select  </option>
                                             <?php		$sql = mysqli_query($connection,"Select * from  m_vehicle  order by vehicle_id");
                                                while($row= mysqli_fetch_array($sql)) { ?>
                                             <option value="<?php echo $row['vehicle_id']; ?>"><?php echo $row['vehicle_no']; ?></option>
                                             <?php } ?>
                                          </select>
                                          <script>document.getElementById('vehicle_id').value = '<?php echo $vehicle_id; ?>';</script>
                                       </div>
                                    </div>
                                 </div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Consignor</label>
												<div class="col-sm-8">
												<select name="consignor_id" id="consignor_id" class='select2-me' style="width:100%;">
								<option value="">      Select  </option>
		<?php	$sql = mysqli_query($connection,"Select * from   m_party where p_type='consignor' order by party_id");
										  while($row= mysqli_fetch_array($sql)) { ?>
				<option value="<?php echo $row['party_id']; ?>"><?php echo $row['party_name']; ?></option>
								<?php } ?>

											</select>
			<script>document.getElementById('consignor_id').value = '<?php echo $consignor_id; ?>';</script>
												</div>
											</div>
										
										</div>
										
										
  
										</div>



                                        
										
										
									<div class="row">
										<div class="col-sm-12">
											<div class="form-actions">
												<center>
											<input type="submit" name="search" class="btn btn-primary" value="Search">  
											<a type="button" href="<?php echo $pagename; ?>" class="btn btn-red">Cancel</a>
												</center>	
											</div>
										</div>
									</div>
								</form>
							</div>
							
							
							<div class="box box-color box-bordered red">
			<div class="box-title">
			<h3>	<i class="fa fa-table"></i>
					 Payment Details</h3>
				
		
				<!-- 	<button class="btn btn-warning" style="float: right">Click Hear For All Entry
											<i class="fa fa-object-group"></i>
										</button> &nbsp;
				 -->
				
				
				
	<!-- 			
			<a href="pdf/pdf_dispatch_advance.php" class="btn" style="float: right" target="_blank">Pdf 
											<i class="fa fa-file-pdf-o"></i>
										</a> &nbsp;
					<a href="excel/excel_dispatch_advance.php" class="btn btn-warning" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a> 	 -->
				
			</div>
			<div class="box-content nopadding">
				<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
					<thead>
					<tr>
				<th>S.No</th>
						<th>Trip No.</th>
						<th>Truck No.</th>
						<th class='hidden-350'>Receive Date</th>
						<th>Consignor</th>
						<th>Consignee</th>
						<!-- <th class='hidden-1024'>Truck No.</th> -->
						<!-- <th>Destination</th> -->
						<!-- <th>Item</th> -->
						<th>Deduct Amt</th>
						<!-- <th>Qty (Bags)</th> -->
						<th>Receive Amt</th>	
						<!-- <th>Bilty Scan</th>	 -->
						<th class='hidden-480'>Action</th>
					</tr>
					</thead>
					<tbody>
					
					 <?php
									$sn=1;
							// echo		"Select * from  $tblname  $crit && is_advance=1  order by $tblpkey desc";
				$sql = mysqli_query($connection,"Select * from  $tblname $crit && sessionconsignor_id=$consignorid  order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
	
	$consignor_name=$cmn->getvalfield($connection,"m_party","party_name","party_id=$row[consignor_id]");
	$consignee_name=$cmn->getvalfield($connection,"m_party","party_name","party_id=$row[consignee_id]");

$trip_no=$cmn->getvalfield($connection,"trip_entry","trip_no","trip_id=$row[trip_id]");	
$vehicle_id=$cmn->getvalfield($connection,"trip_entry","vehicle_id","trip_id=$row[trip_id]");								  	
	$vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$vehicle_id");
										   ?>
					<tr>					<td><?php echo $sn++;?></td>
						<td><?php echo $trip_no; ?></td>
						<td class='hidden-1024'><?php echo $vehicle_no; ?></td>
						<td><?php echo dateformatindia($row['rec_date']); ?></td>
						<td><?php echo $consignor_name; ?></td>
						<td class='hidden-350'><?php echo $consignee_name; ?></td>
					
						<!-- <td class='hidden-1024'><?php echo $destination; ?></td> -->
						<!-- <td class='hidden-1024'><?php echo $item_name; ?></td> -->
						<!-- <td><?php echo $row['rec_date']; ?></td> -->
						<td><?php echo $row['deduct_amt']; ?></td>
						<td><?php echo $row['rec_amt']; ?></td>
						<!-- <td><b><a href="upload/bilty/<?php echo $row['bilty_scan'] ?>" class="text-danger"  target="_blank" download>Download</a></b></td> -->
						<td class='hidden-480'>
	<!-- 	<a href="pdf/pdf_dispatch_printA4.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-warning" rel="tooltip" title="Builty A4"target="_blank" >
			<i class="fa fa-print">A4</i>
	<a href="pdf/pdf_dispatch_printA5.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-info" rel="tooltip" title="Builty A5" style="margin-left: 3px;" target="_blank">
			<i class="fa fa-print">A5</i>
		</a> -->
		<!-- <a href="return.php?editid=<?php echo $row['trip_id']; ?>" class="btn btn-inverse" rel="tooltip" title="Edit">
			<i class="fa fa-edit"></i>
		</a> -->
		<a href="<?php echo $pagename ?>" onClick="funDel(<?php echo $row['pay_id']; ?>)" class="btn btn-danger" rel="tooltip" title="Delete">
			<i class="fa fa-times"></i>
		</a></td>
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
	</div>
	<script type="text/javascript">
        function funDel(id) {
     // alert(id);
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
