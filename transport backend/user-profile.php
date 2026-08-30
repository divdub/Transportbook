<?php

include("adminsession.php");
error_reporting(0);
$tblname = "m_userlogin";
$tblpkey = "user_id ";
$pagename = "user-profile.php";
$modulename = "User Master";
$duplicate=''; 
if($user_id != "")
{

	$sql = mysqli_query($connection,"select * from $tblname where $tblpkey='$user_id'");
	$row = mysqli_fetch_array($sql);
	 $user_name = $row['user_name']; 
	$password    = $row['password'];
}
else
{
	$user_name = '';
	$password = '';
}
if(isset($_POST['submit']))
{
	  $user_name = $_POST['user_name'];
	 $password = $_POST['password']; 
	// echo "'user_name'=>$user_name,'password'=>$password,'updated_date'=>$currentdate"; die;
	
$form_data = array('user_name'=>$user_name,'password'=>$password,'updated_date'=>$currentdate);

		
		dbRowUpdate($connection,$tblname, $form_data, "$tblpkey='$user_id'");
	
		echo "<script>location='$pagename?action=2'</script>";
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

	<title>CUSTOMER MASTER</title>

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
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-user"></i>
									Change Password
								</h3>
							</div>
							<div class="box-content nopadding">
								<!-- <ul class="tabs tabs-inline tabs-top">
									<li class='active'>
										<a href="#profile" data-toggle='tab'>
											<i class="fa fa-user"></i>Profile</a>
									</li>
									<li>
										<a href="#notifications" data-toggle='tab'>
											<i class="fa fa-bullhorn"></i>Notifications</a>
									</li>
									<li>
										<a href="#security" data-toggle='tab'>
											<i class="fa fa-lock"></i>Security</a>
									</li>
								</ul> -->
								<div class="tab-content padding tab-content-inline tab-content-bottom">
									<div class="tab-pane active" id="profile">
										<form action="#" method="POST" class="form-horizontal">
											<div class="row">
												<!-- <div class="col-sm-2">
													<div class="fileinput fileinput-new" data-provides="fileinput">
														<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 84px; height: 84px;">
															<img src="img/demo/user-1.jpg" alt="">
														</div>
														<div>
															<span class="btn btn-default btn-file">
														<span class="fileinput-new">Select image</span>
															<span class="fileinput-exists">Change</span>
															<input type="file" name="...">
															</span>
															<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
														</div>
													</div>
												</div> -->
												<div class="col-sm-6">
													<div class="form-group">
														<label for="name" class="control-label col-sm-2 right">User Name:</label>
														<div class="col-sm-10">
															<input type="text" name="user_name" id="user_name" class='form-control' value="<?php echo $user_name ?>">
														</div>
													</div>
													
													
													
													<div class="form-group">
														<label for="pw" class="control-label col-sm-2 right">Password:</label>
														<div class="col-sm-10">
															<input type="password" name="password" id="password" class='form-control' value="<?php echo $password ?>">
															<!-- <div class="form-button">
																<a href="#" class="btn btn-grey-4 change-input">Change</a>
															</div> -->
														</div>
													</div>
													<div class="form-actions">
														<input type="submit" name="submit" id="submit" value="Save" class="btn btn-primary">
											
												<a type="button" href="<?php echo $pagename; ?>"class="btn btn-red">Cancel</a>
													</div>
												</div>
											</div>
										</form>
									</div>
							<!-- 		<div class="tab-pane" id="notifications">
										<form action="#" class="form-horizontal">
											<div class="form-group">
												<label for="asdf" class="control-label col-sm-2">Email notifications</label>
												<div class="col-sm-10">
													<label class="checkbox">
														<input type="checkbox" name="asdf">Send me security emails</label>
													<label class="checkbox">
														<input type="checkbox" name="asdf">Send system emails</label>
													<label class="checkbox">
														<input type="checkbox" name="asdf">Lorem ipsum dolor</label>
													<label class="checkbox">
														<input type="checkbox" name="asdf">Minim veli</label>
												</div>
											</div>
											<div class="form-group">
												<label for="asdf" class="control-label col-sm-2">Email for notifications</label>
												<div class="col-sm-10">
													<select name="email" id="email">
														<option value="1">asdf@blasdas.com</option>
														<option value="2">johnDoe@asdasf.de</option>
														<option value="3">janeDoe@janejanejane.net</option>
													</select>
												</div>
											</div>
											<div class="form-actions">
												<input type="submit" class='btn btn-primary' value="Save">
												<input type="reset" class='btn' value="Discard changes">
											</div>
										</form>
									</div> -->
									<!-- <div class="tab-pane" id="security">
										<form action="#" class="form-horizontal">
											<div class="form-group">
												<label for="asdf" class="control-label col-sm-2">Disable account for</label>
												<div class="col-sm-10">
													<select name="email" id="email">
														<option value="1">1 week</option>
														<option value="2">2 weeks</option>
														<option value="3">3 weeks</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label for="asdf" class="control-label col-sm-2">Lock account?</label>
												<div class="col-sm-10">
													<a href="more-locked.html" class="btn btn-danger">Lock account now</a>
												</div>
											</div>
											<div class="form-actions">
												<input type="submit" class='btn btn-primary' value="Save">
												<input type="reset" class='btn' value="Discard changes">
											</div>
										</form>
									</div> -->
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
