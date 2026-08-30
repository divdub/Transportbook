<?php 
error_reporting(0);
include("adminsession.php");
// include("function/dispatch_function.php");
$tblname = "m_adblue";
$tblpkey = "adblue_id";
$pagename = "stock.php";
$modulename = "Income Details";
$crit='';



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

	<title> Stock:: CHAARUVI INFOTECH PVT. LTD.</title>

<?php include("inc/top-files.php"); ?>	
</head>

<body>
	  


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
									<i class="fa fa-list"></i> Stock Report
								  </h3>
							</div>
						
							
							
							<div class="box box-color box-bordered red">
			<div class="box-title">
			<h3>	<i class="fa fa-table"></i>
					 Stock Detail </h3>
				
			<!--<a href="pdf_employeebook.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&adblue_id=<?php echo $adblue_id; ?>" class="btn" style="float: right" target="_blank">EmployeeBook -->
			<!--								<i class="fa fa-file-pdf-o"></i>-->
			<!--							</a> &nbsp;-->
					<a href="inventory.php" class="btn btn-warning" style="float: right">Click Hear For New Entry
											<i class="fa fa-object-group"></i>
										</a> &nbsp;
				
				
				
				
				
			<!--<a href="pdf/pdf_payroll.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&adblue_id=<?php echo $adblue_id; ?>" class="btn" style="float: right" target="_blank">Pdf -->
			<!--								<i class="fa fa-file-pdf-o"></i>-->
			<!--							</a> &nbsp;-->
			<!--		<a href="excel/excel_payroll.php" class="btn btn-warning" style="float: right">Excel-->
			<!--								<i class="fa fa-file-excel-o"></i>-->
			<!--							</a> 	-->
				
			</div>
			<div class="box-content nopadding">
				<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
				  <thead>
               <tr>
                  <th>S.No</th>
                
                  <th>AdBlue Name</th>
                  <th class='hidden-1024'>Stock-In </th>
                  <th>Trip</th>
                    <th>Sale </th>
                  <th class='hidden-480'>Balance</th>
               </tr>
               </thead>
               <tbody>
    <?php
                           $sn=1;
            $sql = mysqli_query($connection,"Select * from  $tblname  order by $tblpkey desc ");
                                while($row= mysqli_fetch_array($sql)) {
  
$qty=$cmn->getvalfield($connection,"stockin","sum(qty)","adblue_id=$row[adblue_id]");
$sale=$cmn->getvalfield($connection,"saleentry","sum(qty)","adblue_id=$row[adblue_id]");
          $adblueqty=$cmn->getvalfield($connection,"dispatch_entry","sum(adblueqty)","adblue_id=$row[adblue_id]");             
          if($adblueqty==''){$adblueqty=0;}
    if($qty==''){$qty=0;}
    if($sale==''){$sale=0;}
 	$stock=$qty - $adblueqty - $sale;
                                 ?>
               <tr>
                  <td><?php echo $sn++;?></td>
                  
                  <td><?php echo $row['adblue_name']; ?></td>
                
                  <td><?php echo $qty; ?></td>
             
                  <td><?php echo $adblueqty; ?></td>
                   <td><?php echo $sale; ?></td>
                 
                  <td><?php echo $stock; ?></td>
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
	
</body>



</html>
