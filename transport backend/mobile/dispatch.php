<?php 
error_reporting(0);
include("../adminsession.php");
include ('inc/head.php');


// $pagename='';
if ($_GET['type'] !='') {
	$type =$_GET['type'];
	$pagename =$type;
} else
$type = '';
include ('inc/header.php');
?>


<!-- Welcome Start -->
<div class="content-body">
	<div class="container mb-5">
		<?php
         if($type=='Dispatch'){
          ?>
           <div class="row">
			<div class="col-6">
				<a href="dispatch_report.php">
					<div class="card p-2">
						<div class="icon d-flex justify-content-center">
							<img src="assets/images/icons/dispatch.png" class="w-50">
						</div>
						<div class="title-1 mt-2">
							<p>Dispatch Report</p>
						</a>
					</div>
				</div>
			</div>
			<div class="col-6">
		
				<div class="card p-2">
				<a href="advance_report.php">
					<div class="icon d-flex justify-content-center">
						<img src="assets/images/icons/payment.png" class="w-50">
					</div>
					<div class="title-1 mt-2">
						<p>Advance Report</p>
					</div>
		 </a>
				</div>
			</div>
			<div class="col-6">
				<div class="card p-2" style="display: none;">
				<a href="receive_report.php?is_receive=1">
					<div class="icon d-flex justify-content-center">
						<img src="assets/images/icons/receive-report.png" class="w-50">
					</div>
					<div class="title-1 mt-2">
						<p>Receiving Report</p>
					</div>
		 </a>
				</div>
			</div>
			<div class="col-6">
		
				<div class="card p-2" style="display: none;">
				<a href="cash_adv_report.php">
					<div class="icon d-flex justify-content-center">
						<img src="assets/images/icons/payment.png" class="w-50">
					</div>
					<div class="title-1 mt-2">
						<p>Cash Advance Report</p>
					</div>
		 </a>
				</div>
			</div>
			<div class="col-6" style="display: none;">
		
				<div class="card p-2">
				<a href="receive_report.php?is_receive=0">
					<div class="icon d-flex justify-content-center">
						<img src="assets/images/icons/payment.png" class="w-50">
					</div>
					<div class="title-1 mt-2">
	<p>Receiving Pending Report</p>
					</div>
		 </a>
				</div>
			</div>
		</div>

<?php } 
       if($type=='Payment'){
          ?>
           <div class="row">
			<div class="col-6" style="display: none;">
			<a href="tpa_report.php">
					<div class="card p-2">
						<div class="icon d-flex justify-content-center">
							<img src="assets/images/icons/dispatch.png" class="w-50">
						</div>
						<div class="title-1 mt-2">
							<p>TPA Report</p>
						</a>
					</div>
				</div>
			</div>
			<div class="col-6">
			<a href="voucher_report.php">
				<div class="card p-2">
					<div class="icon d-flex justify-content-center">
						<img src="assets/images/icons/voucher.png" class="w-50">
					</div>
					<div class="title-1 mt-2">
						<p>Voucher Report</p>
					</div>
	   </a>
				</div>
			</div>
			<div class="col-6">
			<a href="payment_report.php">
				<div class="card p-2">
					<div class="icon d-flex justify-content-center">
						<img src="assets/images/icons/payment-report.png" class="w-50">
					</div>
					<div class="title-1 mt-2">
						<p>Payment Report</p>
					</div>
	   </a>
				</div>
			</div>
			<div class="col-6">
			<a href="truck_owner_report.php">
				<div class="card p-2">
					<div class="icon d-flex justify-content-center">
						<img src="assets/images/icons/delivery.png" class="w-50">
					</div>
					<div class="title-1 mt-2">
						<p>Truck Owner Paid/Unpaid Report</p>
					</div>
	   </a>
				</div>
			</div>
			<div class="col-6"style="display: none;">
			<a href="consignee_report.php">
				<div class="card p-2">
					<div class="icon d-flex justify-content-center">
						<img src="assets/images/icons/statistics.png" class="w-50">
					</div>
					<div class="title-1 mt-2">
						<p>Consignee Paid/Unpaid Report</p>
					</div>
	   </a>
				</div>
			</div>
			<div class="col-6" style="display: none;">
			<a href="agent_report.php">
				<div class="card p-2">
					<div class="icon d-flex justify-content-center">
						<img src="assets/images/icons/call-center.png" class="w-50">
					</div>
					<div class="title-1 mt-2">
						<p>Agent Paid/Unpaid Report</p>
					</div>
	   </a>
				</div>
			</div>
			<div class="col-6" style="display: none;">
			<a href="tds_report.php">
				<div class="card p-2">
					<div class="icon d-flex justify-content-center">
						<img src="assets/images/icons/tds.png" class="w-50">
					</div>
					<div class="title-1 mt-2">
						<p>TDS Report</p>
					</div>
	   </a>
				</div>
			</div>
			<div class="col-6" style="display: none;">
			<a href="bilty_report.php">
				<div class="card p-2">
					<div class="icon d-flex justify-content-center">
						<img src="assets/images/icons/discount.png" class="w-50">
					</div>
					<div class="title-1 mt-2">
						<p>Bilty Commission Report</p>
					</div>
	   </a>
				</div>
			</div>
			<div class="col-6" style="display: none;">
			<a href="transport_report.php">
				<div class="card p-2">
					<div class="icon d-flex justify-content-center">
						<img src="assets/images/icons/delivery-truck.png" class="w-50">
					</div>
					<div class="title-1 mt-2">
						<p>Transport Commission Report</p>
					</div>
	   </a>
				</div>
			</div>
		</div>
  <?php } 
       if($type=='Account'){
          ?>
           <div class="row">
			<div class="col-6">
				<a href="othr_exp_report.php">
					<div class="card p-2">
						<div class="icon"style="display: flex; justify-content: center;">
							<img src="assets/images/icons/expense-report.png" class="w-50">
						</div>
						<div class="title-1 mt-2">
							<p>Other Expense Report</p>
						</a>
					</div>
				</div>
			</div>
			<div class="col-6">
			<a href="othr_inc_report.php">
				<div class="card p-2">
					<div class="icon" style="display: flex; justify-content: center;">
						<img src="assets/images/icons/income-report.png" class="w-50">
					</div>
					<div class="title-1 mt-2">
						<p>Other Income Report</p>
					</div>
				</div>
	   </a>
			</div>
		</div>
    <?php } 
       if($type=='Maintenance'){
          ?>
           <div class="row">
			<div class="col-6">
				<a href="service_report.php">
					<div class="card p-2">
						<div class="icon"style="display: flex; justify-content: center;">
							<img src="assets/images/icons/service-report.png" class="w-50">
						</div>
						<div class="title-1 mt-2">
							<p>Service Report</p>
						</a>
					</div>
				</div>
			</div>
			<div class="col-6">
			<a href="maintenance_report.php">
				<div class="card p-2">
					<div class="icon" style="display: flex; justify-content: center;">
						<img src="assets/images/icons/maintenance.png" class="w-50">
					</div>
					<div class="title-1 mt-2">
						<p>Maintenance Report</p>
					</div>
				</div>
			</div>
		</div>
		<?php } 
       if($type=='Billing'){
          ?>
           <div class="row">
			<div class="col-6">
				<a href="inv_report.php">
					<div class="card p-2">
						<div class="icon" style="display: flex; justify-content: center;">
							<img src="assets/images/icons/invoice-report.png" class="w-50">
						</div>
						<div class="title-1 mt-2">
							<p>Invoice Report</p>
						</a>
					</div>
				</div>
			</div>
			<div class="col-6">
			<a href="manual_bill_report.php">
				<div class="card p-2">
					<div class="icon" style="display: flex; justify-content: center;">
						<img src="assets/images/icons/bill-report.png" class="w-50">
					</div>
					<div class="title-1 mt-2">
						<p>Bill Payment Report</p>
					</div>
				</div>
	   </a>
			</div>
			<div class="col-6">
			<a href="diesel_bill_report.php">
				<div class="card p-2">
					<div class="icon" style="display: flex; justify-content: center;">
						<img src="assets/images/icons/diesel-report.png" class="w-50">
					</div>
					<div class="title-1 mt-2">
						<p>Diesel Bill Report</p>
					</div>
				</div>
	   </a>
			</div>
			<div class="col-6">
			<a href="bill_status_report.php">
				<div class="card p-2">
					<div class="icon" style="display: flex; justify-content: center;">
						<img src="assets/images/icons/bill.png" class="w-50">
					</div>
					<div class="title-1 mt-2">
						<p>Bill Status Report</p>
					</div>
				</div>
	   </a>
			</div>
		</div>
			<?php } 
       if($type=='Return'){
          ?>
           <div class="row">
			<div class="col-6">
				<a href="return_report.php">
					<div class="card p-2">
						<div class="icon" style="display: flex; justify-content: center;">
							<img src="assets/images/icons/dispatch.png" class="w-50">
						</div>
						<div class="title-1 mt-2">
							<p>Trip Report</p>
						</a>
					</div>
				</div>
			</div>
			<div class="col-6">
				<div class="card p-2">
					<div class="icon" style="display: flex; justify-content: center;">
						<img src="assets/images/icons/payment.png" class="w-50">
					</div>
					<div class="title-1 mt-2">
						<p>Payment Report</p>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	</div>
</div>
</div>
<!-- Welcome End -->

<?php include('inc/top-footer.php');?>  
<?php include('inc/footer.php');?>