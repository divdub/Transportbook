<?php 
session_start();
include("dbinfo.php");
include("lib/getval.php");
 $cmn = new Comman();
if(isset($_POST['login'])){
    $user_name     = $_POST['user_name'] ?? '';
    $password      = $_POST['password'] ?? '';
    $comp_id       = $_POST['comp_id'] ?? '';
    $session_id    = $_POST['session_id'] ?? '';
    $consignor_id  = $_POST['consignor_id'] ?? '';
    $otpno         = mt_rand(1000, 9999);
$user_type=$cmn->getvalfield($connection,"m_userlogin","user_type","user_name='$user_name'");
  if($user_type=='admin'){
  
  $sql=mysqli_query($connection,"select * from m_userlogin where user_name='$user_name' && password='$password' ");
  
  }
   else
    {
// echo "no"; die;
  $sql=mysqli_query($connection,"select * from m_userlogin where user_name='$user_name' && password='$password' && consignor_id='$consignor_id'");
}
  $count=mysqli_num_rows($sql); 
  // echo $count; die;
 $row =mysqli_fetch_array($sql); 
if($count==1){
    mysqli_query($connection,"update get_otp set otpcode='$otpno' where id='1'");
     $_SESSION['user_id']=$row['user_id'];
     $_SESSION['user_name']=$row['user_name']; 
     $_SESSION['password']=$row['password'];

   $_SESSION['session_id']=$session_id;  
 $_SESSION['comp_id']=$comp_id; 
  $_SESSION['consignor_id']=$consignor_id; 
    "<script>location='loginotp.php'</script>";
 }

else{
     $_SESSION['user_id']='';
     $_SESSION['user_name']=''; 
     $_SESSION['password']='';

   $_SESSION['session_id']='';  
 $_SESSION['comp_id']=''; 
  $_SESSION['consignor_id']=''; 
echo "<script>window.location='index.php'</script>";

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

	<title>TRANSPORT BOOK :: CHAARUVI INFOTECH PVT. LTD.</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- icheck -->
	<link rel="stylesheet" href="css/plugins/icheck/all.css">
	<!-- Theme CSS -->
	<link rel="stylesheet" href="css/style.css">
	<!-- Color CSS -->
	<link rel="stylesheet" href="css/themes.css">


	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>

	<!-- Nice Scroll -->
	<script src="js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
	<!-- Validation -->
	<script src="js/plugins/validation/jquery.validate.min.js"></script>
	<script src="js/plugins/validation/additional-methods.min.js"></script>
	<!-- icheck -->
	<script src="js/plugins/icheck/jquery.icheck.min.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<script src="js/eakroko.js"></script>







	

	<!-- Favicon -->
	<link rel="shortcut icon" href="img/favicon.html" />
	<!-- Apple devices Homescreen icon -->
	<link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-precomposed.png" />

</head>

<body class='login'>
	<div class="wrapper">
		<h1>
			<a href="">
				<img src="img/logo-big.png" alt="" class='retina-ready' width="59" height="49">OTP</a>
		</h1>
		<div class="login-body">
		    <?php echo $otpno;?>
        <center><h2 style="font-weight: bold">OTP Verification </h2></center>
			<form action="check_login.php" method='post' name="login"class='form-validate' id="test">
				<div class="form-group">
				
						<input type="hidden" name='user_name' value="<?php echo  $_SESSION['user_name'] ?>" class='form-control'>
						<input type="hidden" name='password' value="<?php echo  $_SESSION['password'] ?>"class='form-control'>
						<input type="hidden" name='comp_id' value="<?php echo $_SESSION['comp_id']?>"class='form-control'>
						
                        <input type="hidden" name='session_id' value="<?php echo  $_SESSION['session_id'] ?>" class='form-control'>
						<input type="hidden" name='consignor_id' value="<?php echo  $_SESSION['consignor_id'] ?>"class='form-control'>
						
				<div class="form-group">
					<div class="pw controls">
						<input type="text" name="otpcode" placeholder="Please enter OTP number" class='form-control' data-rule-required="true">
					</div>
				</div>
				
				
		<!-- 		<div class="form-group">
				 
                 <input name="captcha_code" id="captcha_code" placeholder="Enter Captcha" type="text" class='input-block-level'  maxlength="4"  data-rule-required="true" style="border-radius: 30px !important; height: 36px; padding-left:25px; width:150px;"/>
                        <img src="captcha.php" id='captchaimg' style="padding-bottom:10px"/>			
				</div> -->
				<div >
				<center>
					<input type="submit" value="Submit" name="submit" class='btn btn-primary'>
                    </center>
				</div>
                <br>
			</form>
		
		</div>
	</div>
	<!-- <script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-38620714-4']);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script');
		ga.type = 'text/javascript';
		ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(ga, s);
	})();
	</script> -->
</body>



</html>
