<?php 
 include("../adminsession.php");
 $id = $_REQUEST['id'];
   ?>
<div class="box-content nopadding">
								<table class="table table-hover table-nomargin">
									<thead>
										<tr>
										<th>Sno</th>
											<th>Deduction Name</th>
											<th>Sap Doc No.</th>
                                            <th>Inv/Ref No.</th>
											<th>Date</th>
                                            <th>Amount</th>	
                                            <th>Remark</th>
										
										</tr>
									</thead>
									<tbody>
									<tr>
										<?php $sn=1;
					
                  // echo     "select * from  trip_expenses where trip_no='$tripno' && userid='$userid'"; die;
          $sql=mysqli_query($connection,"select * from  other_deduct where invoiceid='$id' && session_id='$session_id' && consignorid= '$consignorid'");
                      


                           while($row=mysqli_fetch_array($sql)){
                           	// code...
                           
								
								$deduct_name = $cmn->getvalfield($connection, "m_deduction", "deduct_name", "other_id='$row[other_id]'");
$totamt+=$row['damt'];
                        
                           ?>
                                <tr>
                                     <td><?php echo $sn++;?></td>
									 			<td><?php echo $deduct_name;?></td>
                                                 <td><?php echo $row['sap_doc_no'];?></td>
                                                 <td><?php echo $row['inv_ref_no'];?></td>
                                                 <td><?php echo date('d-m-Y',strtotime($row['ddate']));?></td>
												<td><?php echo $row['damt'];?></td>
												<td><?php echo $row['dremark'];?></td>

									 			
									 		
                                            <?php }?>
										</tr>
										<tr > 
											
											<th colspan=5 style="text-align:right;">Total: </th>
											<th><?php echo $totamt?></th>
										
									
										<th></th></tr>
										
										
										
									</tbody>
									
								</table>
							