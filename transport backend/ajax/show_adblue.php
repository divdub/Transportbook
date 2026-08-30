<?php 
 include("../adminsession.php");
 $id = $_REQUEST['id'];
 $stkledger = $_REQUEST['stkledger'];
   ?>
<div class="box-content nopadding">
								<table class="table table-hover table-nomargin">
									<thead>
										<tr>
										<th>Sno</th>
											<th>AdBlue Name</th>
											<th>Qty</th>
                                            <th>Rate</th>
										
                                            <th>Amount</th>	
                                          
										
										</tr>
									</thead>
									<tbody>
									<tr>
										<?php $sn=1;
					
                  // echo     "select * from  trip_expenses where trip_no='$tripno' && userid='$userid'"; die;
                  if($stkledger==''){
                    //   echo "select * from  dispatch_entry where dispatch_id='$id' && session_id='$session_id' && consignor_id= '$consignorid'";
          $sql=mysqli_query($connection,"select * from  dispatch_entry where dispatch_id='$id' && session_id='$session_id' && consignor_id= '$consignorid'");
                      
} else {
    // echo "select * from  saleentry where saleid='$id' && session_id='$session_id' && consignor_id= '$consignorid'";
       $sql=mysqli_query($connection,"select * from  saleentry where saleid='$id' && session_id='$session_id' && consignorid= '$consignorid'");
}

                           while($row=mysqli_fetch_array($sql)){
                           	// code...
                           
								
							$adblue_name=$cmn->getvalfield($connection,"m_adblue","adblue_name","adblue_id=$row[adblue_id]");
// $totamt+=$row['consignor_cash_adv'];
  if($stkledger==''){
      $amount=$row['consignor_cash_adv'];
     $qty= $row['adblueqty'];
  }else {
       $amount=$row['amount'];
        $qty= $row['qty'];
  }
                        
                           ?>
                                <tr>
                                     <td><?php echo $sn++;?></td>
									 			<td><?php echo $adblue_name;?></td>
                                                 <td><?php echo $qty;?></td>
                                                 <td><?php echo $row['rate'];?></td>
                                               
												<td><?php echo $amount;?></td>
											

									 			
									 		
                                            <?php }?>
										</tr>
									
										
										
										
									</tbody>
									
								</table>
							