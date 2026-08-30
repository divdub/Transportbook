<?php 
error_reporting(0);
   include("../../adminsession.php");

     $fromdate = $_REQUEST['fromdate']; 
   $todate = $_REQUEST['todate']; 
       // $selectype = $_REQUEST['selectype'];
       // $item_id= $_REQUEST['item_id'];
	   $page = $_REQUEST['page']; 
	//    printf("$page");
$crit='';
if ($fromdate != '' && $todate != '') {
    $crit .= "where voucher_date BETWEEN  '$fromdate' and  '$todate' ";
    //echo $crit;
}

  //   if ($selectype != '') {
  //   $crit .= " and is_complete='$selectype'";
  // }
  // if ($item_id != '') {
  //   $crit .= " and item_id='$item_id'";
  // }  

$limit = 5;    

// update the active page number

if ($page!='') {    

	$page_number  = $_REQUEST["page"];    

}    

else {    

  $page_number=1;    

}       
// printf("$page_number");
// get the initial page number

$initial_page = ($page_number-1) * $limit;       
// printf("$initial_page");
// get data of selected rows per page 
// printf("SELECT * FROM tpa_entry $crit && is_create=0 && consignorid=$consignorid LIMIT $initial_page, $limit");
  //echo "SELECT * FROM tpa_entry $crit  && consignor_id=$consignorid && tpcat_id=2 LIMIT $initial_page, $limit";
$getQuery = "SELECT * FROM payment $crit && tds_amt!=0  && consignorid=$consignorid  LIMIT $initial_page, $limit";     

$result = mysqli_query ($connection, $getQuery);  
?>
<div id="report-1">
			<?php
                                         
                                       
                                          	  while($row= mysqli_fetch_array($result)) {
                                            $di_no=$cmn->getvalfield($connection,"dispatch_entry","di_no","dispatch_id=$row[dispatch_id]");
		$bilty_date=$cmn->getvalfield($connection,"dispatch_entry","bilty_date","dispatch_id=$row[dispatch_id]");
			$destination_id=$cmn->getvalfield($connection,"dispatch_entry","destination_id","dispatch_id=$row[dispatch_id]");
				$owner_id=$cmn->getvalfield($connection,"dispatch_entry","owner_id","dispatch_id=$row[dispatch_id]");
		   $owner_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$owner_id");
		   	$vehicle_id=$cmn->getvalfield($connection,"dispatch_entry","vehicle_id","dispatch_id=$row[dispatch_id]");
		   $vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$vehicle_id");
		   $place_name=$cmn->getvalfield($connection,"m_place","place_name","place_id=$destination_id");
			$wt_mt=$cmn->getvalfield($connection,"dispatch_entry","wt_mt","dispatch_id=$row[dispatch_id]");
				$comp_rate=$cmn->getvalfield($connection,"dispatch_entry","comp_rate","dispatch_id=$row[dispatch_id]");
				$amt=$comp_rate*$wt_mt;
			$tds_amt=	$row['tds_amt'];
	       
                                          	   ?>
			<div class="col-12 custom-col2">
				<div class="card p-3">
					<div class="row report-1 d-flex justify-content-between align-items-center">
				

						<div class="col-4 px-3"><p>DI/LR No.</p>
							<span><?php echo $di_no; ?></span></div>
							<div class="col-4 px-3"><p>Paid To</p><span><?php echo $row['payee_name']; ?></span></div>							

							<div class="col-4 px-3"><p>Destination</p><span><?php echo $place_name; ?></span></div>
						</div>
						<hr class="my-2">
						<div class="row report-1 d-flex justify-content-between align-items-center">
						<div class="col-4 px-3"><p>Freight Amount</p><span><?php echo $amt; ?></span></div>							

							<div class="col-4 px-3"><p>Paid Amount</p><span><?php echo number_format(round(($row['amt_paid_to']),2)); ?></span></div>
							<div class="col-4 px-3"><p>TDS Amount</p><span><?php echo $tds_amt; ?></span></div>
						</div>
					</div>
				</div>	
				<?php } ?>
				<div class="col-12 my-3">
					<nav aria-label="Page navigation example">
					<ul class="pagination">
				<?php  

$getQuery = "SELECT COUNT(*) FROM payment $crit && consignorid=$consignorid && tpcat_id=1";     

$result = mysqli_query($connection, $getQuery);     
// printf($result);
$row = mysqli_fetch_row($result);     

$total_rows = $row[0];              

echo "</br>";            

// get the required number of pages

$total_pages = ceil($total_rows / $limit);     

$pageURL = "";             

if($page_number>=2){   

	echo "	<li class='page-item' ><a class='page-link'  onclick='getprev();' >  Prev </a> </li>";   

}                          

for ($i=1; $i<=5; $i++) {   

  if ($i == $page_number) {   

	  $pageURL .= "<li class='page-item active' ><a class = 'page-link'  onclick='getpgn(".$i.");'   >".$i." </a></li>";  

  }               

  else  {   

	  $pageURL .= "<li class='page-item' ><a class = 'page-link' onclick='getpgn(".$i.");' ;  >   

										".$i."
										</a>
										</li>";     
										
  } 
};     

echo $pageURL;    

if($page_number<$total_pages){   

	echo "<li class='page-item active'><a class = 'page-link'  onclick='getnext();' >  Next </a></li>";   

}     ?>	<input type="hidden" id="pagenos" class="form-control" value="<?php echo $page_number; ?>" ><input type="hidden" id="total_pages" class="form-control" value="<?php echo $total_pages; ?>" ></ul>	</nav>
</div>

           </div>
		   <script>
			function getpgn(i) {
				// alert(i);
				var page =i;
				var fromdate = document.getElementById("fromdate").value;
     var todate = document.getElementById("todate").value;
    
	 var total_pages = document.getElementById("total_pages").value;
     // var selectype = document.getElementById("selectype").value;
     // var item_id = document.getElementById("item_id").value;
    
// alert(page);
   
    jQuery.ajax({
          type: 'POST',
          url: 'ajax/gettds.php',
          data: "page="+page+"&fromdate="+fromdate+"&todate="+todate,
          dataType: 'html',
          success: function(data){  
        //   alert(data);     
           jQuery("#report-1").html(data);
       }
          });//ajax close   
			}
			
			function getnext() {
				
				var pagenos = parseInt(document.getElementById("pagenos").value);
				var fromdate = document.getElementById("fromdate").value;
     var todate = document.getElementById("todate").value;
   
	 var total_pages = document.getElementById("total_pages").value;
     // var selectype = document.getElementById("selectype").value;
     // var item_id = document.getElementById("item_id").value;

  if(pagenos<total_pages){   

	page=pagenos+1;   

}
   
    jQuery.ajax({
          type: 'POST',
          url: 'ajax/gettds.php',
          data: "page="+page+"&fromdate="+fromdate+"&todate="+todate,
          dataType: 'html',
          success: function(data){  
        //   alert(data);     
           jQuery("#report-1").html(data);
       }
          });//ajax close   
			}

			function getprev() {
				
				var pagenos = parseInt(document.getElementById("pagenos").value);
				var fromdate = document.getElementById("fromdate").value;
     var todate = document.getElementById("todate").value;
 
	 var total_pages = document.getElementById("total_pages").value;
     // var selectype = document.getElementById("selectype").value;
     // var item_id = document.getElementById("item_id").value;
	 if(pagenos>=2){
		page= pagenos-1;
		
	  }
   
    jQuery.ajax({
          type: 'POST',
          url: 'ajax/gettds.php',
          data: "page="+page+"&fromdate="+fromdate+"&todate="+todate,
          dataType: 'html',
          success: function(data){  
        //   alert(data);     
           jQuery("#report-1").html(data);
       }
          });//ajax close   
			}

		   </script>