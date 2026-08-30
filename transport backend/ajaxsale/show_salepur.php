<?php 
error_reporting(0);
include("../adminsession.php");
$pagename = "sale_entry.php";
$tblname ="inv_payment";
$tblpkey= "payment_id";
$modulename = "Payment ";
include("function/purchase_function.php");
   $payment_id = $_REQUEST['payment_id'];
  $customer_id = $_REQUEST['customer_id'];
   // $purchase_date = $_REQUEST['purchase_date'];

if ($payment_id != 0) {
   $saleid = $_REQUEST['saleid'];
} else {
   $payment_id = 0;
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
                                        <td>Sn</td>
                     	<td>Customer</td>
                        <td>Paid Amount</td>
						<td >Disc Amount</td>
                        <td >Payment Mode</td> 
                        <td >Narration</td> 
                         <td>Payement Date</td>
                        <td >Print</td>
                        <td >Action</td>

                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php 	
					$sn=1;					
					$netpaiamt=0;
					
						$sql = mysqli_query($connection,"select * from inv_payment where  type='sale' && iscomp=0 && sessionid='$sessionid' && compid='$compid' order by paymentid desc"); 
						while($row=mysqli_fetch_assoc($sql))
						{
						
					 ?>
                     <tr>
							<td><?php echo $sn++; ?></td>
							<td> <?php echo $cmn->getvalfield($connection,"m_customer","cust_name","customer_id='$row[customer_id]'"); ?></td>

						<td style="text-align:right;"><?php echo number_format($row['paid_amt'],2); ?></td>
						<td style="text-align:right;"><?php echo number_format($row['discamt'],2); ?></td>
						<td><?php echo $row['pay_type']; ?></td>  
						<td><?php echo $row['narration']; ?></td>  
						 	<td><?php echo dateformatindia($row['paymentdate']); ?></td>              
                           <td><a href="pdf_sale_payment.php?paymentid=<?php echo $row['paymentid'];?>" target="_blank" class="btn btn-success">Print </a>

                                   </td>          
                          <td>
						  <input type="button" class="btn btn-primary" name="add_data_list" id="add_data_list" onClick="editselected('<?php echo $row['paymentid']; ?>','<?php echo $row['paymentdate']; ?>','<?php echo $row['customer_id']; ?>','<?php echo $row['paid_amt']; ?>','<?php echo $row['narration']; ?>','<?php echo $row['discamt']; ?>','<?php echo $row['pay_type']; ?>');" value="E"> &nbsp;
                        
						     <input type="button" class="btn btn-danger" name="add_data_list" id="add_data_list" onClick="funDel1('<?php echo $row['paymentid']; ?>');" value="X">
                          </td>
                      </tr>
                                        <?php
										$slno++;
										 $totalamt+=$row['paid_amt'];
                              $total+=$row['discamt'];

									}
									?>
										<tr><th></th><th>Total</th><th style="text-align:right;"><?php echo number_format($totalamt,2);?></th><th style="text-align:right;"><?php echo number_format($total,2);?></th><th></th><th></th><th></th><th></th> <th></th></tr>
									</tbody>
									
								</table>
                                </div>
					</div>
				</div>
				
   </body>
</html>
