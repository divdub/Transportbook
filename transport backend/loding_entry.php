<!doctype html>
<html>



<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!-- Apple devices fullscreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Apple devices fullscreen -->
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />

	<title>LODING ENTRY</title>

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
							<a href="more-login.html">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="forms-basic.html">Forms</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="forms-basic.html">Basic forms</a>
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
									<i class="fa fa-list"></i>Loding Entry</h3>
							</div>
							<div class="box-content nopadding">
								<form action="#" method="POST" class='form-horizontal form-column form-bordered'>
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Loding Date</label>
												<div class="col-sm-8">
													<input type="date" name="textfield" id="textfield" placeholder="Text input" class="form-control">
												</div>
											</div>
										
										</div>
										
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Loding No.</label>
												<div class="col-sm-8">
													<input type="text" name="textfield" id="textfield" placeholder="Text input" class="form-control">
												</div>
											</div>
										
										</div>
										
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4"> Supplier Name</label>
												<div class="col-sm-8">
                                                <select name="select" id="select" class='form-control'>
												<option value="1"></option>
												<option value="2"></option>
											
									            </select>
												</div>
											</div>
										
										</div>
                                    </div>


									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Form Place</label>
												<div class="col-sm-8">
                                                <select name="select" id="select" class='form-control'>
												<option value="1"></option>
												<option value="2"></option>
											
									            </select>
												</div>
											</div>
										
										</div>


                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Customer</label>
												<div class="col-sm-8">
                                                <select name="select" id="select" class='form-control'>
												<option value="1"></option>
												<option value="2"></option>
											
									            </select>
												</div>
											</div>
										
										</div>


										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">To Place</label>
												<div class="col-sm-8">
                                                <select name="select" id="select" class='form-control'>
												<option value="1"></option>
												<option value="2"></option>
											
									            </select>
												</div>
											</div>
										
										</div>
                                        </div>



										<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Item</label>
												<div class="col-sm-8">
                                                <select name="select" id="select" class='form-control'>
												<option value="1"></option>
												<option value="2"></option>
											
									            </select>
												</div>
											</div>
										</div>
                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Vehicle No.</label>
												<div class="col-sm-8">
                                                <select name="select" id="select" class='form-control'>
												<option value="1"></option>
												<option value="2"></option>
											
									            </select>
												</div>
											</div>
										
										</div>


                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Weight</label>
												<div class="col-sm-8">
													<input type="text" name="textfield" id="textfield" placeholder="Text input" class="form-control">
												</div>
											</div>
										
										</div>
                                        </div>

                                        <div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Rate</label>
												<div class="col-sm-8">
                                            	<input type="text" name="textfield" id="textfield" placeholder="Text input" class="form-control">
												</div>
											</div>
										</div>
                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Amount</label>
												<div class="col-sm-8">
                                                <input type="text" name="textfield" id="textfield" placeholder="Text input" class="form-control">
												</div>
											</div>
										
										</div>


                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Diesel Address</label>
												<div class="col-sm-8">
													<input type="text" name="textfield" id="textfield" placeholder="Text input" class="form-control">
												</div>
											</div>
										
										</div>
                                        </div>
                                        <div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Cash Advance</label>
												<div class="col-sm-8">
                                            	<input type="text" name="textfield" id="textfield" placeholder="Text input" class="form-control">
												</div>
											</div>
										</div>
                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Petrol Pump</label>
												<div class="col-sm-8">
                                                <input type="text" name="textfield" id="textfield" placeholder="Text input" class="form-control">
												</div>
											</div>
										
										</div>


                                        <div class="col-sm-4">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Remarks</label>
												<div class="col-sm-8">
													<input type="text" name="textfield" id="textfield" placeholder="Text input" class="form-control">
												</div>
											</div>
										
										</div>
                                        </div>




									<div class="row">
										<div class="col-sm-12">
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
				
				
				
				
				
			</div>
		</div>
	</div>
	
</body>



</html>
