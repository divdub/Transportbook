<?php 
error_reporting(0);
include("adminsession.php");
// include("function/dispatch_function.php");
$tblname = "payroll";
$tblpkey = "payment_id";
$pagename = "emp_pay_report.php";
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



if (isset($_GET['employee_id'])) {
	$employee_id = trim(addslashes($_GET['employee_id']));
} else
	$employee_id = '';


if ($fromdate != '' && $todate != '') {
	$crit .= "where payment_date BETWEEN  '$fromdate' and  '$todate' ";
	//echo $crit;
}

if ($employee_id != '') {
	$crit .= " and employee_id='$employee_id'";
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

	<title> PAYROLL:: CHAARUVI INFOTECH PVT. LTD.</title>

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
									<i class="fa fa-list"></i> Payment Report
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
												<label for="textfield" class="control-label col-sm-4"> Employee Name</label>
												<div class="col-sm-8">
												<select name="employee_id" id="employee_id" class='select2-me' style="width:100%;">
				<option value="">      Select  </option>
				<?php	$sql = mysqli_query($connection,"Select * from  m_employee  order by employee_id");
										  while($row= mysqli_fetch_array($sql)) { ?>
										  	
												<option value="<?php echo $row['employee_id']; ?>"><?php echo $row['employee_name']; ?></option>
								<?php } ?>

											</select>
			<script>document.getElementById('employee_id').value = '<?php echo $employee_id ; ?>';</script>

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
					 Payment  Detail </h3>
			<?php	if($employee_id!=''){ ?>
				
			
			<a href="pdf_employeebook.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&employee_id=<?php echo $employee_id; ?>" class="btn" style="float: right" target="_blank">EmployeeBook 
											<i class="fa fa-file-pdf-o"></i>
										</a> &nbsp; <?php } ?>
					<a href="payroll.php" class="btn btn-warning" style="float: right">Click Hear For New Entry
											<i class="fa fa-object-group"></i>
										</a> &nbsp;
				
				
				
				
				
			<a href="pdf/pdf_payroll.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&employee_id=<?php echo $employee_id; ?>" class="btn" style="float: right" target="_blank">Pdf 
											<i class="fa fa-file-pdf-o"></i>
										</a> &nbsp;
					<a href="excel/excel_payroll.php" class="btn btn-warning" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a> 	
				
			</div>
			<div class="box-content nopadding">
				<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
					<thead>
					<tr>
				  <th>S.No</th>
                
                  <th class='hidden-350'>Payment Date</th>
                  <th>Employee Name</th>
                  <th>Expense Head</th>
                  <th class='hidden-1024'>Amount</th>
                  <th>Pay Mode</th>
                  <th>Remark</th>
				  <th>User Name</th>  
                  <th class='hidden-480'>Action</th>
					</tr>
					</thead>
					<tbody>
					
				 <?php
                           $sn=1;
            $sql = mysqli_query($connection,"Select * from  $tblname $crit  && consignorid=$consignorid order by $tblpkey desc ");
                                while($row= mysqli_fetch_array($sql)) {
   $employee_name=$cmn->getvalfield($connection,"m_employee","employee_name","employee_id=$row[employee_id]");

   $head_name=$cmn->getvalfield($connection,"inc_exp_head","head_name","inc_exp_id=$row[inc_exp_id]");
$user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
                           
                                 ?>
               <tr>
                  <td><?php echo $sn++;?></td>
                  <td><?php echo dateformatindia($row['payment_date']); ?></td>
                  <td><?php echo $employee_name; ?></td>
                  <td class='hidden-350'><?php echo $head_name; ?></td>
                  <td><?php echo $row['amount']; ?></td>
                  <td><?php echo $row['pay_mode']; ?></td>
                  <td><?php echo $row['remark']; ?></td>
                 <td><?php echo $user_name; ?></td>
                  <td class='hidden-480'>
   
      <a href="payroll.php?editid=<?php echo $row['payment_id']; ?>" class="btn btn-inverse" rel="tooltip" title="Edit">
         <i class="fa fa-edit"></i>
      </a>
      <a href="<?php echo $pagename ?>" onClick="funDel(<?php echo $row['payment_id']; ?>)" class="btn btn-danger" rel="tooltip" title="Delete">
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
	
</body>



</html>
