<?php 
include("../adminsession.php");
include ('inc/head.php');

$pagename ="Dashboard";
$otpno = $cmn->getvalfield($connection,"get_otp","otpcode","id='1'");
include ('inc/header.php');
$bilty=$cmn->getvalfield($connection,"dispatch_entry","count(dispatch_id)","created_date='$currentdate' && consignor_id=$consignorid"); 
$cash_adv=$cmn->getvalfield($connection,"dispatch_entry","sum(cash_adv)","created_date='$currentdate' && consignor_id=$consignorid"); 
$diesel_adv_amt=$cmn->getvalfield($connection,"dispatch_entry","sum(diesel_adv_amt)","created_date='$currentdate' && consignor_id=$consignorid"); 
$receive_amt=$cmn->getvalfield($connection,"payment_receive","sum(receive_amt)","created_date='$currentdate' && consignorid=$consignorid"); 
?>

<!-- Welcome Start -->
<div class="content-body">
	<div class="container mb-5">
		<div class="row mb-3">
			<div class="col-12">
				<div class="filter-form p-3">
					<div class="row dash-icon">
						<div class="col-9 d-flex">
							<h5 class="mb-0 pe-3">Login Otp</h5>
							<span class="badge badge-secondary"><?php echo $otpno?></h5>
							</div>
							<div class="col-2">
							<a href="dashboard.php"><img src="assets/images/icons/refresh.png" class="w-50"></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row total">
				<div class="col-6">
					<div class="filter-form p-2">
						<div class="row dash-icon">
							<div class="col-5">
								<div class="icon">
									<img src="assets/images/icons/bilty.png" class="w-100">
								</div>
							</div>
							<div class="col-7">
								<div class="title-1 mt-2">
									<h4 style="font-size: 16px;margin-bottom: 3px;"><?php echo $bilty ?></h4>
									<p>Today Bilty</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="filter-form p-2">
						<div class="row dash-icon">
							<div class="col-5">
								<div class="icon">
									<img src="assets/images/icons/money.png" class="w-100">
								</div>
							</div>
							<div class="col-7">
								<div class="title-1 mt-2">
									<h4 style="font-size: 16px; margin-bottom: 3px;"><?php echo $cash_adv ?>	</h4>
									<p>Cash Adv.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-6 my-2">
					<div class="filter-form p-2">
						<div class="row dash-icon">
							<div class="col-5">
								<div class="icon">
									<img src="assets/images/icons/diesel.png" class="w-100">
								</div>
							</div>
							<div class="col-7">
								<div class="title-1 mt-2">
									<h4 style="font-size: 16px;margin-bottom: 3px;"><?php echo $diesel_adv_amt ?></h4>
									<p>Diesel Adv.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-6 my-2">
					<div class="filter-form p-2">
						<div class="row dash-icon">
							<div class="col-5">
								<div class="icon">
									<img src="assets/images/icons/total-payment.png" class="w-100">
								</div>
							</div>
							<div class="col-7">
								<div class="title-1 mt-2">
									<h4 style="font-size: 16px;margin-bottom: 3px;"><?php echo $receive_amt ?></h4>
									<p>Total Pymt.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Welcome End -->

	<?php include('inc/top-footer.php');?>  
	<?php include('inc/footer.php');?>