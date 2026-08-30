<?php 
include("../adminsession.php");
include ('inc/head.php');

$pagename ="Forget Password";
$tblname = "m_userlogin";
$tblpkey = "user_id ";
$pagename = "PROFILE";
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
	
		echo "<script>location='forgot-password.php'</script>";
	}





?>

 
   

   ?>
 

<!-- Welcome Start -->
<body class="bg-gradient-2">
<?php include ('inc/header.php'); ?>
<div class="content-body" >
	<div class="container mb-3">
	<div class="join-area h-50">
					<div class="started">
						<h1 class="title">Change Password</h1>
					
					</div>
					<form action="#" method="POST" class="form-horizontal">
					<label >User Name</label>
						<div class="input-group form-item input-select">
					
						<input type="text" name="user_name" id="user_name" class='form-control' value="<?php echo $user_name ?>">		
							
						</div>
						<label>Password:</label>
						<div class="input-group form-item input-select">
						
						<input type="password" name="password" id="password" class='form-control' value="<?php echo $password ?>">		
							
						</div>
						<div>
							<center>
						<input type="submit" name="submit" id="submit" value="Save" class="btn btn-success" style="background-color:green;">
											
												<a type="button" href="forgot-password.php"class="btn btn-red" style="background-color:red;color:white;">Cancel</a>	
</center>
						</div>
					</form>	
				
				</div>
		  
</div>
			</div>
			<!-- Welcome End -->

		
	
			<?php include('inc/top-footer.php');?>  
			<?php include('inc/footer.php');?>
		