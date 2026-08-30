<?php 
include("../adminsession.php");
include ('inc/head.php');

$pagename ="Cash Book";


 if ($_GET['fromdate'] != "" && $_GET['todate'] != "") {
	$fromdate = $_GET['fromdate'];
   
	 $todate = $_GET['todate'];
	
   } else {
	 $fromdate = date('Y-m-d');
	 $todate = date('Y-m-d');
   }
   $cond="";
   $cond2="";
 
 
 
 if($fromdate !='' && $todate !='' ) {
   $cond = "and inc_date between '$fromdate' and '$todate' "; 
     $cond1 = "and exp_date between '$fromdate' and '$todate' "; 
   $cond2 = " and cash_adv_date between '$fromdate' and '$todate' "; 
 }
 
 $prevbalance = $cmn->getcashopeningplant($connection,$fromdate,$comp_id,$consignorid);
 $other_inc=$cmn->getvalfield($connection,"othr_inc_entry","sum(amount)","1=1 and bill_type='Cash' and session_id='$session_id'  && consignorid=$consignorid $cond"); 
 $other_exp=$cmn->getvalfield($connection,"other_expense_entry","sum(amount)","1=1 and bill_type='Cash' and session_id='$session_id'  && consignorid=$consignorid $cond1"); 
 $cash_adv=$cmn->getvalfield($connection,"dispatch_entry","sum(cash_adv)","1=1 and (cash_adv !=0)  and session_id='$session_id'  && consignor_id=$consignorid $cond2");  
 $balamt = $prevbalance + $other_inc - $cash_adv-$other_exp;
  
  ?>
 

<!-- Welcome Start -->
<body class="bg-gradient-2">
<?php include ('inc/header.php'); ?>
<div class="content-body" >
	<div class="container mb-3">
		<div class="row">
			<div class="join-area">
				<form action="#" method="GET"  class="filter-form">
					<div class="row">
						<div class="col-md-6 col-6">
							<div class="mb-3">
								<label for="form-check-label">From Date</label>
								<input type="date" name="fromdate" id="fromdate" class="form-control" value="<?php echo $fromdate; ?>"  placeholder="Name" onChange="getSearch();">
							</div>
						</div>
						<div class="col-md-6 col-6">
							<div class="mb-3">
								<label for="form-check-label">To Date</label>
								<input type="date"  name="todate" id="todate" class="form-control" placeholder="Name" value="<?php echo $todate; ?>" onChange="getSearch();">
							</div>
						</div>
					</div>
				
				</form>
				<div class="input-group my-0">
					<!-- <input type="text" class="form-control" placeholder="Search..">
					<span class="input-group-text"> 
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M23.7871 22.7761L17.9548 16.9437C19.5193 15.145 20.4665 12.7982 20.4665 10.2333C20.4665 4.58714 15.8741 0 10.2333 0C4.58714 0 0 4.59246 0 10.2333C0 15.8741 4.59246 20.4665 10.2333 20.4665C12.7982 20.4665 15.145 19.5193 16.9437 17.9548L22.7761 23.7871C22.9144 23.9255 23.1007 24 23.2816 24C23.4625 24 23.6488 23.9308 23.7871 23.7871C24.0639 23.5104 24.0639 23.0528 23.7871 22.7761ZM1.43149 10.2333C1.43149 5.38004 5.38004 1.43681 10.2279 1.43681C15.0812 1.43681 19.0244 5.38537 19.0244 10.2333C19.0244 15.0812 15.0812 19.035 10.2279 19.035C5.38004 19.035 1.43149 15.0865 1.43149 10.2333Z" fill="#FE9063"></path>
						</svg>
					</span> -->
				</div>
			
			</div>
		</div>
		  
                
        <div class="row total">
				<div class="col-12 my-2">
					<div class="filter-form p-2">
						<div class="row dash-icon">
							<!-- <div class="col-5"> -->
								<!-- <div class="icon">
									<img src="assets/images/icons/dispatch.png" class="w-100">
								</div> -->
							<!-- </div> -->
							<div class="col-12">
								<div class="title-1 mt-2 d-flex align-items-center">
									
									
                                    <h4>Opening Balance : <span style="color:#704FFE;"><?php echo $prevbalance ?></span></h4>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-6 my-2">
					<div class="filter-form p-2">
						<div class="row dash-icon">
							<!-- <div class="col-5">
								<div class="icon">
									<img src="assets/images/icons/dispatch.png" class="w-100">
								</div>
							</div> -->
							<div class="col-12">
								<div class="title-1 mt-2">
									<h4><p> Other Income :</p>	<span style="color:#c73b01";><?php echo $other_inc ?></span>	</h4>
									
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-6 my-2">
					<div class="filter-form p-2">
						<div class="row dash-icon">
							<!-- <div class="col-5">
								<div class="icon">
									<img src="assets/images/icons/dispatch.png" class="w-100">
								</div>
							</div> -->
							<div class="col-12">
								<div class="title-1 mt-2">
									<h4>	<p> Dispatch Advance :</p><span style="color:#c73b01";><?php echo $cash_adv ?></span></h4>
									
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-6 my-2">
					<div class="filter-form p-2">
						<div class="row dash-icon">
							<!-- <div class="col-5">
								<div class="icon">
									<img src="assets/images/icons/dispatch.png" class="w-100">
								</div>
							</div> -->
							<div class="col-12">
								<div class="title-1 mt-2">
									<h4><p>Other Expense :</p><span style="color:#c73b01";><?php echo $other_exp ?></span></h4>
									
								</div>
							</div>
						</div>
					</div>
				</div>
                <div class="col-12 my-2">
					<div class="filter-form p-2">
						<div class="row dash-icon">
							<!-- <div class="col-5">
								<div class="icon">
									<img src="assets/images/icons/dispatch.png" class="w-100">
								</div>
							</div> -->
							<div class="col-12">
								<div class="title-1 mt-2">
									<h4>Balance Amt :  <span style="color:#0d6c22;"><?php echo $balamt ?><span></h4>
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
			<!-- Welcome End -->

			<script type="text/javascript">
   
		function getSearch(){
      var fromdate = document.getElementById("fromdate").value;
     var todate = document.getElementById("todate").value;
    
     location = 'cashbook.php?fromdate=' + fromdate + '&todate='+todate;
    //  alert(fromdate);

}



    </script>
	
			<?php include('inc/top-footer.php');?>  
			<?php include('inc/footer.php');?>
		