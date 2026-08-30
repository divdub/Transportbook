<?php 
   include("../../adminsession.php");

     $fromdate = $_REQUEST['fromdate']; 
   $todate = $_REQUEST['todate']; 
       $otherid = $_REQUEST['otherid']; 
	   
	   $page = $_REQUEST['page']; 
	//    printf("$page");
$crit='';
if ($fromdate != '' && $todate != '') {
    $crit .= "where inc_date BETWEEN  '$fromdate' and  '$todate' ";
    //echo $crit;
}

    if ($otherid != '') {
    $crit .= " and otherid='$otherid'";
  }
    

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
// printf("SELECT * FROM othr_inc_entry $crit LIMIT $initial_page, $limit");
$getQuery = "SELECT * FROM othr_inc_entry $crit && consignorid=$consignorid LIMIT $initial_page, $limit";     

$result = mysqli_query ($connection, $getQuery);  
?>
<div id="report-1">
			<?php 
				// $sn = 1;
                   
				//    $sql = mysqli_query($connection, "select * from othr_inc_entry $crit order by dispatch_id  desc limit 10 ");

				   while ($row = mysqli_fetch_array($result)) {
					// $vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","otherid=$row[otherid]");
                    $head_name=$cmn->getvalfield($connection,"otherexp_master","head_name","otherid=$row[otherid]");


					 ?>
			<div class="col-12 custom-col2">
				<div class="card p-3">
					<div class="row report-1 d-flex justify-content-between align-items-center">
				

						<div class="col-4 px-3"><p>Income Date</p>
							<span><?php echo dateformatindia($row['inc_date']); ?></span></div>
							<div class="col-4 px-3"><p>Other Income</p><span><?php echo $head_name; ?></span></div>
							<div class="col-4 px-3"><p>Amount </p><span><?php echo $row['amount']; ?></span></div>
							
						</div>
						<hr class="my-2">
						<div class="row report-1 d-flex justify-content-between align-items-center">
							<div class="col-4 px-3"><p>Payment Type</p><span><?php echo $row['bill_type']; ?></span></div>
							<div class="col-4 px-3"><p>Payment Mode </p><span><?php echo $row['payment_mode']; ?></span></div>
							<div class="col-4 px-3"><p>Narration </p><span><?php echo $row['narration']; ?></span></div>
						</div>
					</div>
				</div>	
				<?php } ?>
				<div class="col-12 my-3">
					<nav aria-label="Page navigation example">
					<ul class="pagination">
				<?php  

$getQuery = "SELECT COUNT(*) FROM othr_inc_entry $crit && consignorid=$consignorid ";     

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
     var otherid = document.getElementById("otherid").value;
	 var total_pages = document.getElementById("total_pages").value;

// alert(page);
   
    jQuery.ajax({
          type: 'POST',
          url: 'ajax/getincome.php',
          data: "page="+page+"&fromdate="+fromdate+"&todate="+todate+"&otherid="+otherid,
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
     var otherid = document.getElementById("otherid").value;
	 var total_pages = document.getElementById("total_pages").value;
	  

  if(pagenos<total_pages){   

	page=pagenos+1;   

}
   
    jQuery.ajax({
          type: 'POST',
          url: 'ajax/getincome.php',
          data: "page="+page+"&fromdate="+fromdate+"&todate="+todate+"&otherid="+otherid,
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
     var otherid = document.getElementById("otherid").value;
	 var total_pages = document.getElementById("total_pages").value;
	  

	 if(pagenos>=2){
		page= pagenos-1;
		
	  }
   
    jQuery.ajax({
          type: 'POST',
          url: 'ajax/getincome.php',
          data: "page="+page+"&fromdate="+fromdate+"&todate="+todate+"&otherid="+otherid,
          dataType: 'html',
          success: function(data){  
        //   alert(data);     
           jQuery("#report-1").html(data);
       }
          });//ajax close   
			}

		   </script>