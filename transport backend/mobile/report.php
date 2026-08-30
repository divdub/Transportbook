<?php
include("../adminsession.php");
include ('inc/head.php');?> 
<?php 
$pagename ="Report";
?>
<?php include ('inc/header.php');?>

   <!-- Welcome Start -->
	<div class="content-body">
		<div class="container mb-5">
			<div class="row">
			<div class="col-4">
				<a href="dispatch.php?type=Dispatch">
				<div class="card p-2">
				<div class="icon">
				 <img src="assets/images/icons/dispatch.png" class="w-100">
				</div>
				<div class="title-1 mt-2">
					<p>Dispatch</p>
				</div>
			</div>
		</a>
			</div>
			<div class="col-4">
				<a href="dispatch.php?type=Payment">
				<div class="card p-2">
				<div class="icon">
				 <img src="assets/images/icons/payment.png" class="w-100">
				</div>
				<div class="title-1 mt-2">
					<p>Payment</p>
				</a>
				</div>
			</div>
		</a>
			</div>
			<div class="col-4"  style="display: none;">
				<a href="document_report.php">
				<div class="card p-2">
				<div class="icon">
				 <img src="assets/images/icons/document.png" class="w-100">
				</div>
				<div class="title-1 mt-2">
					<p>Document</p>

				</div>
			</div>
		</a>
			</div>
			<div class="col-4"  style="display: none;">
				<a href="dispatch.php?type=Account">
				<div class="card p-2">
				<div class="icon">
				 <img src="assets/images/icons/account.png" class="w-100">
				</div>
				<div class="title-1 mt-2">
					<p>Account</p>
				</div>
			</div>
		</a>
			</div>
			<div class="col-4"  style="display: none;">
				<a href="dispatch.php?type=Maintenance">
				<div class="card p-2">
				<div class="icon">
				 <img src="assets/images/icons/maintenance.png" class="w-100">
				</div>
				<div class="title-1 mt-2">
					<p>Maintenance</p>
				</div>
			</div>
		</a>
			</div>
			<div class="col-4"  style="display: none;">
				<a href="dispatch.php?type=Billing">
				<div class="card p-2">
				<div class="icon">
				 <img src="assets/images/icons/billing.png" class="w-100">
				</div>
				<div class="title-1 mt-2">
					<p>Billing</p>
				</div>
			</div>
		</a>
			</div>
			<div class="col-4" style="display:none;">
				<a href="#">
				<div class="card p-2">
				<div class="icon">
				 <img src="assets/images/icons/purchase.png" class="w-100">
				</div>
				<div class="title-1 mt-2">
					<p>Purchase</p>
				</div>
			</div>
		</a>
			</div>
			<div class="col-4"  style="display: none;">
				<a href="dispatch.php?type=Return">
				<div class="card p-2">
				<div class="icon">
				 <img src="assets/images/icons/return.png" class="w-100">
				</div>
				<div class="title-1 mt-2">
					<p>Return</p>
				</div>
			</div>
		</a>
			</div>
			<div class="col-4" style="display:none;">
				<div class="card p-2">
				<div class="icon">
				 <img src="assets/images/icons/data-center.png" class="w-100">
				</div>
				<div class="title-1 mt-2">
					<p>Data Center</p>
				</div>
			</div>
			</div>
			<div class="col-4"  style="display: none;">
			<a href="cashbook.php">
				<div class="card p-2">
				<div class="icon">
				 <img src="assets/images/icons/cash-book.png" class="w-100">
				</div>
				<div class="title-1 mt-2">
					<p>Cash Book</p>
				</div>
			</div>
</a>
			</div>
			<div class="col-4" style="display:none;">
				<div class="card p-2">
				<div class="icon">
				 <img src="assets/images/icons/report.png" class="w-100">
				</div>
				<div class="title-1 mt-2">
					<p>Report</p>
				</div>
			</div>
			</div>
			<div class="col-4"  style="display: none;">
				<div class="card p-2">
				<div class="icon">
				 <img src="assets/images/icons/payroll.png" class="w-100">
				</div>
				<div class="title-1 mt-2">
					<p>Payroll</p>
				</div>
			</div>
			</div>
			<div class="col-4" style="display:none;">
				<div class="card p-2">
				<div class="icon">
				 <img src="assets/images/icons/setting.png" class="w-100">
				</div>
				<div class="title-1 mt-2">
					<p>Setting</p>
				</div>
			</div>
			</div>
		</div>
		</div>
	</div>
    <!-- Welcome End -->
	
 <?php include('inc/top-footer.php');?>  
<?php include('inc/footer.php');?>