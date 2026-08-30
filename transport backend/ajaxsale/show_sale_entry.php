<?php 
error_reporting(0);
include("../adminsession.php");
$pagename = "show_sale_entry.php";
$tblname ="sale_entry";
$tblpkey= "saleid";
$modulename = "Sale Entry";

  $saleid = $_REQUEST['saleid'];
  $iteminv_category_id = $_REQUEST['iteminv_category_id'];
 
    $bill_type = $_REQUEST['bill_type'];
  $customer_id = $_REQUEST['customer_id'];
   $disc = $_REQUEST['disc'];

if ($saleid != 0) {
   $saleid = $_REQUEST['saleid'];
} else {
   $saleid = 0;
}

if ($customer_id != 0) {
   $customer_id = $_REQUEST['customer_id'];
} else {
   $customer_id = 0;
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
                                            <th> AMOUNT</th>
                                       

                                          
                                <th>GST %</th>
                            
                                            <!--<th>NET AMOUNT</th>-->
                                  
                                            <th>DISCOUNT</th>
                                            <th>GRAND TOTAL</th>
                                            <th>ACTION</th>

                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									
                                  
                              $sel = "select * from inv_saleentrydetail   where saleid='$saleid' && comp_id='$compid' && sessionid='$sessionid'  ORDER BY `saledetail_id` DESC";
                       
                           // echo "select * from sale_entry where customer_id=$customer_id";

                     
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_assoc($res))
									{
								$itemcategoryname = $cmn->getvalfield($connection, "m_iteminv", "item_name", "iteminv_id ='$row[iteminv_id]'");
					
									$itemid= $cmn->getvalfield($connection, "inv_saleentrydetail", "iteminv_id", "saledetail_id ='$row[saledetail_id]'");
											
										$iteminv_category_id = $cmn->getvalfield($connection, "m_iteminv", "iteminv_category_id", "iteminv_id ='$itemcategoryname'");
				$item_category_name = $cmn->getvalfield($connection, "m_iteminv_category", "category_name", "iteminv_category_id='$iteminv_category_id'");
				$pos_id=$row['pos_id'];
          $saledetail_id=$row['saledetail_id'];
   



            
								
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($itemcategoryname);?>/<?php echo ucfirst($item_category_name);?>
                                       </td><td>  <?php     if($pos_id!=''){
        //   $ids = explode(',',$pos_id); 
      $sln=1;
            $sel1 = "select * from purchaseorderserial where saledetail_id ='$saledetail_id'";
            $res1 =mysqli_query($connection,$sel1);
            while($row1 = mysqli_fetch_assoc($res1)){    
             if($sln==1){
               echo $row1['serial_no'];
            } else {
               echo ltrim(','.$row1['serial_no']);
            }
            $sln++;            
                                              }
                                              } else{ echo"--- ";
                                                   } ?>
</td>
                                      
                                            <td><?php echo ucfirst($row['qty']);?></td>
                                            <td><?php echo ucfirst($row['rate']);?></td>
                                            <td><?php echo number_format($row['total_amt'],2);?></td>

                                           
                                              <td><?php echo number_format($row['gst'],2);?></td>
                                            
                                            <!--<td><?php echo number_format($row['nettotal'],2);?></td>-->
                                            <td><?php echo ucfirst($row['disc']);?></td>

                                            <td><?php echo number_format($row['grandtotal'],2);?></td>

                                           <td class=''>
                                            <!--<a href= "?edit=<?php echo ucfirst($row['saledetail_id']);?>"><img src="../img/b_edit.png" title="Edit"></a> -->
                                           <a class="btn btn-warning" onClick="modelFun('<?php echo $row['saledetail_id']; ?>','<?php echo $row['iteminv_id']; ?>','<?php echo $row['qty']; ?>','<?php echo $row['rate']; ?>','<?php echo $row['total_amt']; ?>','<?php echo $row['gst']; ?>','<?php echo $row['disc'];?>','<?php echo $row['nettotal'];?>','<?php echo $row['saleid']; ?>','<?php echo $row['pos_id']; ?>')">  <i class="icon-edit"></i>E</a>
<a onClick="funDellower('<?php echo $row['saledetail_id']; ?>')"  class="btn btn-danger" rel="tooltip" title="Delete"><i class="fa fa-times"></i></a>
                                           
                                          
                                           </td>
										</tr>
                                        <?php
										$slno++;
										 $totalamt+=$row['total_amt'];
                              $total+=$row['grandtotal'];

									}
									?>
									
									
									 
                             	<tr><th></th><th></th><th></th><th></th><th></th><th>Total</th><th></th><th></th><th><?php echo number_format($total,2);?></th><th></th></tr>
                            
									
									</tbody>
									
								</table>
                                </div>
					</div>
				</div>
				
   </body>
</html>
 


