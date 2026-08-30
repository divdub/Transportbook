<?php 
error_reporting(0);
include("../adminsession.php");
$pagename = "purchaseentry.php";
$tblname ="payment";
$tblpkey= "payment_id";
$modulename = "Payment ";

?>
<table class="table table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                        <td>Sn</td>
                     	<td>Customer</td>
                        <td>Paid Amount</td>
						<td >Disc Amount</td>
                        <td >Payment Mode</td> 
                        <td >Narration</td> 
                        <td >Print</td>
                        <td >Action</td>

                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php 	
					$sn=1;					
					$netpaiamt=0;
				
						$sql = mysqli_query($connection,"select * from inv_payment where  type='purchase' && iscomp=0 && compid='$comp_id' && sessionid='$session_id' && consignor_id='$consignorid' order by paymentid desc"); 
						while($row=mysqli_fetch_assoc($sql))
						{
						
					 ?>
                     <tr>
							<td><?php echo $sn++; ?></td>
							<td> <?php echo $cmn->getvalfield($connection,"m_supplier","supp_name","supplier_id='$row[supplier_id]'"); ?></td>
                        
						<td style="text-align:right;"><?php echo number_format($row['paid_amt'],2); ?></td>
						<td style="text-align:right;"><?php echo number_format($row['discamt'],2); ?></td>
						<td><?php echo $row['pay_type']; ?></td>  
						<td><?php echo $row['narration']; ?></td>  
						             
                           <td><a href="pdf_puchase_payment.php?paymentid=<?php echo $row['paymentid'];?>" target="_blank" class="btn btn-success">Print </a>

                                   </td>          
                          <td>
						  <input type="button" class="btn btn-primary" name="add_data_list" id="add_data_list" onClick="editselected('<?php echo $row['paymentid']; ?>','<?php echo $row['paymentdate']; ?>','<?php echo $row['supplier_id']; ?>','<?php echo $row['paid_amt']; ?>','<?php echo $row['narration']; ?>','<?php echo $row['discamt']; ?>','<?php echo $row['pay_type']; ?>');" value="E"> &nbsp;
                        
						     <input type="button" class="btn btn-danger" name="add_data_list" id="add_data_list" onClick="funDel1('<?php echo $row['paymentid']; ?>');" value="X">
                          </td>
                      </tr>
                                        <?php
										$slno++;
										 $totalamt+=$row['paid_amt'];
                              $total+=$row['discamt'];

									}
									?>
										<tr><th></th><th>Total</th><th style="text-align:right;"><?php echo number_format($totalamt,2);?></th><th style="text-align:right;"><?php echo number_format($total,2);?></th><th></th><th></th><th></th><th></th></tr>
									</tbody>
									
								</table>
                                </div>
                                	
					</div>
				</div>


 