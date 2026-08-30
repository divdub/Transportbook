<?php 
   include("../../adminsession.php");

     $fromdate = $_REQUEST['fromdate']; 
   $todate = $_REQUEST['todate']; 
       $tpcat_id = $_REQUEST['tpcat_id'];
       $dispatch_id= $_REQUEST['dispatch_id'];
	   $page = $_REQUEST['page']; 
	//    printf("$page");
$crit='';
if ($fromdate != '' && $todate != '') {
    $crit .= "where bilty_date BETWEEN  '$fromdate' and  '$todate' ";
    //echo $crit;
}

    if ($tpcat_id != '') {
    $crit .= " and tpcat_id='$tpcat_id'";
  }
  if ($dispatch_id != '') {
    $crit .= " and dispatch_id='$dispatch_id'";
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
// printf("SELECT * FROM tpa_entry $crit && is_create=0 && consignorid=$consignorid LIMIT $initial_page, $limit");
$getQuery = "SELECT * FROM tpa_entry $crit && is_create=0 && consignorid=$consignorid LIMIT $initial_page, $limit";     

$result = mysqli_query ($connection, $getQuery);  
?>
<div id="report-1">
			<?php 
		

				   while ($row = mysqli_fetch_array($result)) {
			
            $category=$row['tpcat_id'];
            if($category==1){
              $cname="Agent";
              $catname = $cmn->getvalfield($connection,"m_agent","agent_name","agent_id = '$row[category_id]'");
            
            } 
            if($category==2){
              $cname="Consignee";
              $catname = $cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id = '$row[category_id]'");
            
            } 
            if($category==4) {
              $cname="Truck Owner";
                $catname = $cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id = '$row[category_id]'");
            }
					 ?>
			<div class="col-12 custom-col2">
				<div class="card p-3">
					<div class="row report-1 d-flex justify-content-between align-items-center">
				

						<div class="col-4 px-3"><p>DI/LR No.</p>
							<span><?php echo $row['di_no']; ?></span></div>
							<div class="col-4 px-3"><p>Bilty Date</p><span><?php echo dateformatindia($row['bilty_date']); ?></span></div>
							<div class="col-4 px-3"><p>Category</p><span><?php echo $cname; ?></span></div>
							
						</div>
						<hr class="my-2">
						<div class="row report-1 d-flex justify-content-between align-items-center">
							<div class="col-4 px-3"><p>Category Name</p><span><?php echo $catname; ?></span></div>
							<div class="col-4 px-3"><p>Rate</p><span><?php echo $row['rate']; ?></span></div>
							<div class="col-4 px-3"><p>Amount</p><span><?php echo $row['amt']; ?></span></div>
						</div>
					</div>
				</div>	
				<?php } ?>
				<div class="col-12 my-3">
					<nav aria-label="Page navigation example">
					<ul class="pagination">
				<?php  

$getQuery = "SELECT COUNT(*) FROM tpa_entry $crit && is_create=0 && consignorid=$consignorid";     

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
     var tpcat_id = document.getElementById("tpcat_id").value;
     var dispatch_id = document.getElementById("dispatch_id").value;
    
// alert(page);
   
    jQuery.ajax({
          type: 'POST',
          url: 'ajax/gettpa.php',
          data: "page="+page+"&fromdate="+fromdate+"&todate="+todate+"&tpcat_id="+tpcat_id+"&dispatch_id="+dispatch_id,
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
     var tpcat_id = document.getElementById("tpcat_id").value;
     var dispatch_id = document.getElementById("dispatch_id").value;

  if(pagenos<total_pages){   

	page=pagenos+1;   

}
   
    jQuery.ajax({
          type: 'POST',
          url: 'ajax/gettpa.php',
          data: "page="+page+"&fromdate="+fromdate+"&todate="+todate+"&tpcat_id="+tpcat_id+"&dispatch_id="+dispatch_id,
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
     var tpcat_id = document.getElementById("tpcat_id").value;
     var dispatch_id = document.getElementById("dispatch_id").value;
	 if(pagenos>=2){
		page= pagenos-1;
		
	  }
   
    jQuery.ajax({
          type: 'POST',
          url: 'ajax/gettpa.php',
          data: "page="+page+"&fromdate="+fromdate+"&todate="+todate+"&tpcat_id="+tpcat_id+"&dispatch_id="+dispatch_id,
          dataType: 'html',
          success: function(data){  
        //   alert(data);     
           jQuery("#report-1").html(data);
       }
          });//ajax close   
			}

		   </script>