<?php 
include("../adminsession.php");
include ('inc/head.php');

$pagename ="Service Report";


 if ($_GET['fromdate'] != "" && $_GET['todate'] != "") {
	$fromdate = $_GET['fromdate'];
   
	 $todate = $_GET['todate'];

   } else {
	 $fromdate = date('Y-m-d');
	 $todate = date('Y-m-d');
   }


   ?>
 

<!-- Welcome Start -->
<body class="bg-gradient-2" onload="getSearch();">
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
                    <div class="row">
						<div class="col-md-6 col-6">
					<div class="mb-3">
						<label for="form-check-label">Truck No.</label>
						
						 <select name="vehicle_id" id="vehicle_id" class='form-select mySelect' style="width:100%;" aria-label="Default select example" onChange="getSearch();">
                                             <option value="">      Select  </option>
                                             <?php		$sql = mysqli_query($connection,"Select * from  m_vehicle  order by vehicle_id");
                                                while($row= mysqli_fetch_array($sql)) { ?>
                                             <option value="<?php echo $row['vehicle_id']; ?>"><?php echo $row['vehicle_no']; ?></option>
                                             <?php } ?>
                                          </select>
                                          <script>document.getElementById('vehicle_id').value = '<?php echo $vehicle_id; ?>';</script>
						
					</div>
                                                </div>
                                                <div class="col-md-6 col-6">
                    <div class="mb-3">
						<label for="form-check-label">Service Head</label>
						
						 <select name="head_id" id="head_id" class='form-select mySelect' style="width:100%;" aria-label="Default select example" onChange="getSearch();">
                                             <option value="">      Select  </option>
                                             <?php		$sql = mysqli_query($connection,"Select * from  head_master  order by head_id");
                                                while($row= mysqli_fetch_array($sql)) { ?>
                                             <option value="<?php echo $row['head_id']; ?>"><?php echo $row['head_name']; ?></option>
                                             <?php } ?>
                                          </select>
                                          <script>document.getElementById('head_id').value = '<?php echo $head_id; ?>';</script>
						
					</div>
                                                </div>
                                                </div>
				</form>
				<div class="input-group my-3">
					<input type="text" class="form-control" placeholder="Search..">
					<span class="input-group-text"> 
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M23.7871 22.7761L17.9548 16.9437C19.5193 15.145 20.4665 12.7982 20.4665 10.2333C20.4665 4.58714 15.8741 0 10.2333 0C4.58714 0 0 4.59246 0 10.2333C0 15.8741 4.59246 20.4665 10.2333 20.4665C12.7982 20.4665 15.145 19.5193 16.9437 17.9548L22.7761 23.7871C22.9144 23.9255 23.1007 24 23.2816 24C23.4625 24 23.6488 23.9308 23.7871 23.7871C24.0639 23.5104 24.0639 23.0528 23.7871 22.7761ZM1.43149 10.2333C1.43149 5.38004 5.38004 1.43681 10.2279 1.43681C15.0812 1.43681 19.0244 5.38537 19.0244 10.2333C19.0244 15.0812 15.0812 19.035 10.2279 19.035C5.38004 19.035 1.43149 15.0865 1.43149 10.2333Z" fill="#FE9063"></path>
						</svg>
					</span>
				</div>
			
			</div>
		</div>
		  
                
		<div class="row mb-3 report" id="report-1">
		
								</div>
			</div>
			<!-- Welcome End -->

			<script type="text/javascript">
   
		function getSearch(){
      var fromdate = document.getElementById("fromdate").value;
     var todate = document.getElementById("todate").value;
     var vehicle_id = document.getElementById("vehicle_id").value;
     var head_id = document.getElementById("head_id").value;
    
    //  alert(head_id);
    jQuery.ajax({
          type: 'POST',
          url: 'ajax/getservice.php',
          data: "fromdate="+fromdate+"&todate="+todate+"&vehicle_id="+vehicle_id+"&head_id="+head_id,
          dataType: 'html',
          success: function(data){  
        //   alert(data);     
           jQuery("#report-1").html(data);
       }
          });//ajax close   
}



    </script>
	
			<?php include('inc/top-footer.php');?>  
			<?php include('inc/footer.php');?>
		