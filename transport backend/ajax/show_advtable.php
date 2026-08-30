<?php 
error_reporting(0);
include("../adminsession.php");
?>
<div id="advtable" style="overflow:scroll;">

	<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
					<thead>
					<tr>
						<th>S.No</th>
						<th>DI No.</th>
						<th>Bilty No.</th>
						<th>Truck No.</th>
						<th>Freight Amt</th>
						<th>Bilty Date</th>
						<th>Diesel Adv. Amt.</th>
						<th>Cash Advance</th>
						<th>GPS Amount</th>
									<th>User Name</th>	
						<!--<th>Consignor Cash Adv.</th>-->
      <!--                   <th>Consignee Cash Adv.</th>-->
                         <th>Print</th>
                           <?php if($user_type=='admin'){ ?>
						<th>Action</th>
						<?php } ?>
					</tr>
					</thead>
					<tbody>
						 <?php
									$sn=1;
						
				$sql = mysqli_query($connection,"Select * from  dispatch_entry  where is_advance=1 && consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id order by dispatch_id desc limit 10");
										  while($row= mysqli_fetch_array($sql)) {
	$vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
	 $wt_mt =$row['wt_mt'];
     $own_rate=$row['own_rate'];
     $freight_amt=$wt_mt * $own_rate;
     $is_voucher=$row['is_voucher'];
						  	$user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
										   ?>
					<tr>
					<td><?php echo $sn++;?></td>
						<td><?php echo $row['di_no']; ?></td>
						<td><?php echo $row['bilty_no']; ?></td>
						<td><?php echo $vehicle_no; ?></td>
						<td><?php echo $freight_amt; ?></td>
						<td><?php echo dateformatindia($row['bilty_date']); ?></td>
						<td><?php echo $row['diesel_adv_amt']; ?></td>
						<td><?php echo $row['cash_adv']; ?></td>
						<td><?php echo $row['other_cash_adv']; ?></td>
						<!--<td><?php echo $row['consignor_cash_adv']; ?></td>-->
						<!--<td><?php echo $row['consignee_cash_adv']; ?></td>-->
						<td><?php echo $user_name; ?></td>
						<td>
		  <a href="pdf/pdf_dispatch_advanceA4.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-warning" rel="tooltip" title="Builty A4" target="_blank">
			<i class="fa fa-print">A4</i>
			<a href="pdf/pdf_dispatch_advanceA5.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-info" rel="tooltip" title="Builty A5" style="margin-left: 3px;" target="_blank">
			<i class="fa fa-print">A5</i>
		</a>
		
			<a href="pdf/pdf_dieselslip.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-info" rel="tooltip" title="Diesel Slip" style="margin-left: 3px;" target="_blank">
			<i class="fa fa-print" >Diesel Slip</i>
		</a></td><td>
		    <?php if($user_type=='admin'){ ?>
				<a onClick="jQuery('#myModal9').modal('show');getadv1(<?php echo $row['dispatch_id']; ?>);"  class="btn btn-inverse" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
		    	<!-- <a  onClick="jQuery('#myModal9').modal('show');getadv1(<?php echo $row['dispatch_id']; ?>);" class="btn btn-inverse" rel="tooltip" title="Edit">
			<i class="fa fa-edit"></i>
		</a> -->
			<a onclick="getadvdelete(<?php echo $row['dispatch_id']; ?>);"  class="btn btn-danger" rel="tooltip" title="Delete">
			<i class="fa fa-times"></i>
		</a>
		    <?php } ?>
		    	<!-- <?php if($user_type=='admin'){ ?>
	<a  onClick="jQuery('#myModal9').modal('show');getadv1(<?php echo $row['dispatch_id']; ?>);" class="btn btn-inverse" rel="tooltip" title="Edit">
			<i class="fa fa-edit"></i>
		</a> -->
		
	
			<!-- <?php } ?> -->
		</td>
					</tr>
					
					<?php } ?>
					</tbody>
				</table>
</div>
