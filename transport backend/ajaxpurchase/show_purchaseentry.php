<?php 
error_reporting(0);
include("../adminsession.php");
$pagename = "purchaseentry.php";
$tblname ="purchase_entry";
$tblpkey= "purchaseid";
$modulename = "Purchase Entry";
$purchaseid = $_REQUEST['purchaseid'];
$itemcatid = $_REQUEST['iteminv_category_id'];
$bill_type = $_REQUEST['bill_type'];
$sup_id = $_REQUEST['sup_id'];
if ($purchaseid != 0) {
   $purchaseid = $_REQUEST['purchaseid'];
} else {
   $purchaseid = 0;
}
if ($sup_id != 0) {
   $sup_id = $_REQUEST['sup_id'];
} else {
   $sup_id = 0;
}
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title></title>
</head>
<body>



<div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							
<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>S.No.</th>  
                                            <th>ITEM NAME</th>
                                            <th>Serial NO.</th> 
                                            <th>QTY</th>
                                            <th>RATE</th>
                                            <th>GST %</th>
                                            <th>TOTAL AMOUNT</th>
                                            <th>ACTION</th>

                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									
             
                              $sel = "select * from purchasentry_detail  where purchaseid='$purchaseid' && consignor_id='$consignorid' && sessionid='$session_id' && compid='$comp_id'  ORDER BY `purdetail_id` DESC";
                       
                           // echo "select * from purchase_entry where sup_id=$sup_id";

                     
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_assoc($res))
									{
						
								$itemcategoryname = $cmn->getvalfield($connection, "m_iteminv", "item_name", "iteminv_id ='$row[iteminv_id]'");
									
									$iteminv_id= $cmn->getvalfield($connection, "purchasentry_detail", "iteminv_id", "purdetail_id ='$row[purdetail_id]'");
										
									 $iteminv_category_id = $cmn->getvalfield($connection, "m_iteminv", "iteminv_category_id", "iteminv_id ='$iteminv_id'");
			
				$item_category_name = $cmn->getvalfield($connection, "m_iteminv_category", "category_name", "iteminv_category_id='$iteminv_category_id'");
           
     	


            
								
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($itemcategoryname);?>/<?php echo ucfirst($item_category_name);?></td>
                                          <td>     <?php if($iteminv_category_id==5){
                                                      $sln=1;
                                                    
                                                $sel1 = "select * from purchaseorderserial  where purchaseid='$purchaseid' and iteminv_id ='$iteminv_id'";
            $res1 =mysqli_query($connection,$sel1);
            while($row1 = mysqli_fetch_assoc($res1)){
            if($sln==1){
               echo $row1['serial_no'];
            } else {
               echo ltrim(','.$row1['serial_no']);
            }
            $sln++;            
                                              }
                                              } else{echo"---"; 
                                                   } ?></td>
                                            <td><?php echo ucfirst($row['qty']);?></td>
                                            <td><?php echo ucfirst($row['rate']);?></td>
                                            <!-- <td><?php echo number_format($row['total_amt'],2);?></td> -->
                                            
                                              <td><?php echo number_format($row['gst'],2);?></td>
                                          
                                            <td><?php echo number_format($row['nettotal'],2);?></td>

                                           <td class=''>
                                               
                                            
                                        <a class="btn btn-warning" onClick="modelFun('<?php echo $row['purdetail_id']; ?>','<?php echo $row['iteminv_id']; ?>','<?php echo $row['qty']; ?>','<?php echo $row['rate']; ?>','<?php echo $row['total_amt']; ?>','<?php echo $row['gst']; ?>','<?php echo $row['nettotal'];?>','<?php echo $row['purdetail_id']; ?>')">  <i class="fa fa-edit"></i></a>
                                           <a onClick="funDellower('<?php echo $row['purdetail_id']; ?>')"  class="btn btn-danger" rel="tooltip" title="Delete"><i class="fa fa-times"></i></a>
                                           </td>
										</tr>
                                        <?php
										$slno++;
										 $totalamt+=$row['total_amt'];
                              $total+=$row['nettotal'];

									}
									?>
									
									
									 
                          

                               
                                 
                             	<tr><th></th><th></th><th></th><th>Total</th><th></th><th></th><th><?php echo number_format($total,2);?></th><th></th></tr>
                         
                          
                            
									
									</tbody>
									
								</table>
                                </div>
					</div>
				</div>
				
   </body>
</html>
   <script type="text/javascript">


      
 function getTotal() {

               var qty = parseFloat(jQuery('#qty').val());
               var rate = parseFloat(jQuery('#rate').val());
               var disc_rs = parseFloat(jQuery('#disc_rs').val());
               var total_amt = parseFloat(jQuery('#total_amt').val());




               if (!isNaN(qty) && !isNaN(rate)) {
                  total = qty * rate;
                   //alert(total);
jQuery('#total_amt').val(total);
               }
               if (!isNaN(disc_rs)) {
                  total = qty * rate;
                  total = total - disc_rs;
                  jQuery('#total_amt').val(total);
               }
               // alert(total_amt);
               jQuery('#total_amt').val(total);
            }
   </script>