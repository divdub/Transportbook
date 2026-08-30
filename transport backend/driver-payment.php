<!doctype html>
<html>



<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!-- Apple devices fullscreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Apple devices fullscreen -->
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />

	<title>DRIVER PAYMENT</title>

<?php include("inc/top-files.php"); ?>	
</head>

<body>
	
	<?php include("inc/model.php"); ?>
	
	<?php include("inc/top-header.php"); ?>
	
	
	<div class="container-fluid nav-hidden" id="content">
		<?php include("inc/left-menu.php"); ?>
		
		
		
		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					
					<div class="pull-right">
						<ul class="minitiles">
							<li class='grey'>
								<a href="#">
									<i class="fa fa-cogs"></i>
								</a>
							</li>
							<li class='lightgrey'>
								<a href="#">
									<i class="fa fa-globe"></i>
								</a>
							</li>
						</ul>
						<ul class="stats">
							<li class='satgreen'>
								<i class="fa fa-money"></i>
								<div class="details">
									<span class="big">$324,12</span>
									<span>Balance</span>
								</div>
							</li>
							<li class='lightred'>
								<i class="fa fa-calendar"></i>
								<div class="details">
									<span class="big">February 22, 2013</span>
									<span>Wednesday, 13:56</span>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="breadcrumbs">
					<ul>
						<li>
							<a href="#">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="forms-basic.html">Forms</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Basic forms</a>
						</li>
					</ul>
					<div class="close-bread">
						<a href="#">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
				
				
				<div class="row">
					<div class="col-sm-12">
						<div class="box box-bordered box-color">
							<div class="box-title">
								<h3>
									<i class="fa fa-list"></i>Driver Payment Entry</h3>
							</div>
							<div class="box-content nopadding">
								<form action="#" method="POST" class='form-horizontal form-column form-bordered'>
									

									<div class="row">
										
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Driver Name <span style="color: red">10000</span></label>
												<div class="col-sm-8">
												<select name="select" id="select" class='form-control'>
												<option value="1">Select</option>
												<option value="2">Mohan</option>
												<option value="2">Sohan</option>
												<option value="2">Ajay</option>	
											
												
											</select>
												</div>
											</div>
										
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Vehicle No.</label>
												<div class="col-sm-8">
												<select name="select" id="select" class='form-control'>
												<option value="1">Select</option>
												<option value="2">CG04MJ6490</option>
												<option value="2">CG06MK9632</option>
												<option value="2">CG04MJ6490</option>	
											
												
											</select>
												</div>
											</div>
										
										</div>
										
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Payment Type</label>
												<div class="col-sm-8">
												<select name="select" id="select" class='form-control'>
												<option value="1">Select</option>
												<option value="2">Salary</option>
												<option value="2">Advance</option>
												<option value="2">Other</option>	
											
												
											</select>
												</div>
											</div>
										
										</div>
                                        
                                        <div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Payment Mode</label>
												<div class="col-sm-8">
												<select name="select" id="select" class='form-control'>
												<option value="1">Select</option>
												<option value="2">Cash</option>
												<option value="2">Check</option>
												<option value="2">NEFT/RTGS</option>	
												<option value="2">UPI</option>	
											
												
											</select>
												</div>
											</div>
										
										</div>
			                       </div>
									
									<div class="row">
										
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Pay Amt</label>
												<div class="col-sm-8">
													<input type="text" name="textfield" id="textfield" placeholder="amt" class="form-control">
												</div>
											</div>
										
										</div>
										
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Payment Date</label>
												<div class="col-sm-8">
													<input type="text" name="textfield" id="textfield" placeholder="DD/MM/YYYY" class="form-control">
												</div>
											</div>
										
										</div>
										
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Remark</label>
												<div class="col-sm-8">
													<input type="text" name="textfield" id="textfield" placeholder="Text input" class="form-control">
												</div>
											</div>
										
										</div>
                                        
                                        <div class="col-sm-3">
											<div class="form-actions">
												<center>
												<button type="submit" class="btn btn-primary">Save</button>
												<button type="button" class="btn btn-red">Cancel</button>
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
									Pertrol Pump Details
								</h3>
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin">
									<thead>
										<tr>
											<th>Customer Name</th>
											<th>Head Name</th>
											<th>Mobile No.</th>
											<th>Address</th>
										
											<th>Opaning Balance</th>
                                            <th>Opaning Balance Date</th>
											<th class='hidden-350'>Action</th>
											
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Trident</td>
											<td>
												Internet Explorer 4.0
											</td>
											
											<td>Trident</td>
											<td>Trident</td>
											<td>Trident</td>
											<td>Trident</td>
											<td class='hidden-350'>
												<a href="#" class="btn btn-magenta">Edit</a>
									             <a href="#" class="btn btn-satblue">Delete</a></td>
											
										</tr>
										
										
										
										
										
									</tbody>
								</table>
								<div class="table-pagination">
									<a href="#" class='disabled'>First</a>
									<a href="#" class='disabled'>Previous</a>
									<span>
										<a href="#" class='active'>1</a>
										<a href="#">2</a>
										<a href="#">3</a>
									</span>
									<a href="#">Next</a>
									<a href="#">Last</a>
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
