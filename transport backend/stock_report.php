<?php 
error_reporting(0);
include("adminsession.php");
// include("function/dispatch_function.php");
$tblname = "stockin";
$tblpkey = "sid";
$pagename = "stock_report.php";
$modulename = "Income Details";
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



if (isset($_GET['adblue_id'])) {
	$adblue_id = trim(addslashes($_GET['adblue_id']));
} else
	$adblue_id = '';


if ($fromdate != '' && $todate != '') {
	$crit .= "where stockindate BETWEEN  '$fromdate' and  '$todate' ";
		$crit1 .= "where bilty_date BETWEEN  '$fromdate' and  '$todate' ";
		$crit2 .= "where saledate BETWEEN  '$fromdate' and  '$todate' ";
	//echo $crit;
}

if ($adblue_id != '') {
	$crit .= " and adblue_id='$adblue_id'";
		$crit1 .= " and adblue_id='$adblue_id'";
			$crit2 .= " and adblue_id='$adblue_id'";
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

	<title> stockin:: CHAARUVI INFOTECH PVT. LTD.</title>

<?php include("inc/top-files.php"); ?>	
</head>

<body>
<div class="modal fade" id="myModaldshow" role="dialog">
   <div class="modal-dialog" style="width:850px;padding-top: 225px;">
      <div class="modal-content" style="border-radius: 20px;">
         <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
            <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
            <center>
               <h4 class="modal-title"><b>AdBlue Details<b></h4>
            </center>
         </div>
         <div class="modal-body" style="padding-top:30px;">
          
            <div id="showadblue"></div>
         </div>
         <div class="modal-footer">
            <center>
             
               <input type="button" data-dismiss="modal" class="btn btn-danger" value="Close">
               <!-- <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a> -->
            </center>
         </div>
      </div>
   </div>
</div>
	<?php include("inc/model.php"); ?>
	
	<?php include("inc/top-header.php"); ?>
	
	
	<div class="container-fluid nav-hidden" id="content" >
		<?php include("inc/left-menu.php"); ?>
		
		
		
		<div id="main">
			<div class="container-fluid">
				
				<?php include("inc/breadcrumbs.php"); ?>
				
				
				<div class="row">
					<div class="col-sm-12">
						<div class="box box-bordered box-color satblue">
							<div class="box-title">
								<h3>
									<i class="fa fa-list"></i> Stock-In Report
								  </h3>
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
									
								
										  
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4"> AdBlue Name</label>
												<div class="col-sm-8">
												<select name="adblue_id" id="adblue_id" class='select2-me' style="width:100%;">
				<option value="">      Select  </option>
				<?php	$sql = mysqli_query($connection,"Select * from  m_adblue  order by adblue_id");
										  while($row= mysqli_fetch_array($sql)) { ?>
										  	
												<option value="<?php echo $row['adblue_id']; ?>"><?php echo $row['adblue_name']; ?></option>
								<?php } ?>

											</select>
			<script>document.getElementById('adblue_id').value = '<?php echo $adblue_id ; ?>';</script>

												</div>
											</div>
										
										</div>
										
										
  
										<div class="col-sm-3">
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
					 Stock-In Detail </h3>
				
			<!--<a href="pdf_employeebook.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&adblue_id=<?php echo $adblue_id; ?>" class="btn" style="float: right" target="_blank">EmployeeBook -->
			<!--								<i class="fa fa-file-pdf-o"></i>-->
			<!--							</a> &nbsp;-->
					<!--<a href="inventory.php" class="btn btn-warning" style="float: right">Click Hear For New Entry-->
					<!--						<i class="fa fa-object-group"></i>-->
					<!--					</a> &nbsp;-->
				
				
				
				
				
			<a href="pdf_stock.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&adblue_id=<?php echo $adblue_id; ?>" class="btn btn-warning" style="float: right" target="_blank">Pdf 
											<i class="fa fa-file-pdf-o"></i>
										</a> &nbsp;
			<!--		<a href="excel/excel_payroll.php" class="btn btn-warning" style="float: right">Excel-->
			<!--								<i class="fa fa-file-excel-o"></i>-->
			<!--							</a> 	-->
				
			</div>
			<div class="box-content nopadding">
				<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
				  <thead>
               <tr>
                  <th>S.No</th>
                  <th class='hidden-350'>Date</th>
                  <th>Particular</th>
                  <th>Vehicle No</th>
                  <th>AdBlue Name</th>
               
                  <th class='hidden-1024'>qty</th>
                 
                  <th>Remark</th>
              <th>User Name</th>  
               </tr>
               </thead>
               <tbody>
    <?php
                           $sn=1;
                        
        $sql = mysqli_query($connection,"SELECT adblueqty, adblue_id,bilty_date,stkledger,remark,dispatch_id,vehicle_id
FROM dispatch_entry $crit1 && adblueqty != '0'
UNION
SELECT qty, adblue_id,stockindate,for_ledger,remark,sid,vehicle_id
FROM stockin $crit 

UNION

SELECT qty, adblue_id, saledate, for_ledger, remark,saleid,vehicle_id 
FROM saleentry 
$crit2
order by bilty_date ");
                                while($row= mysqli_fetch_array($sql)) {
  

$user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
   $adblue_name=$cmn->getvalfield($connection,"m_adblue","adblue_name","adblue_id=$row[adblue_id]");
   if($row['stkledger']==''){
       $particular='Trip';
       $vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
      
   }else if($row['stkledger']=='Stock-In') {
       $particular=$row['stkledger'];
 $vehicle_no='';
   } else {
        $particular=$row['stkledger'];
       $vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
   }                
                                 ?>
               <tr>
                  <td><?php echo $sn++;?></td>
                  <td><?php echo dateformatindia($row['bilty_date']); ?></td>
               <td><?php echo $particular; ?></td> 
                 <td><a onClick="jQuery('#myModaldshow').modal('show');getddata('<?php echo $row['dispatch_id']; ?>','<?php echo $row['stkledger']; ?>');"><?php echo $vehicle_no; ?></a></td> 
               <td><?php echo $adblue_name; ?></td>
                  <td><?php echo $row['adblueqty']; ?></td>
             
                  <td><?php echo $row['remark']; ?></td>
                 <td><?php echo $user_name; ?></td>
                
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
	<script>
	    	function getddata(id,stkledger) {
						
			// alert(id);

			jQuery.ajax({
				type: 'POST',
				url: 'ajax/show_adblue.php',
				data: 'id=' + id + '&stkledger='+stkledger,
				success: function(data) {

					jQuery("#showadblue").html(data);
				}
			}); //ajax close
		}
	</script>
</body>



</html>
