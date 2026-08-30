<?php 
error_reporting(0);
include("../adminsession.php");

if($_REQUEST['dispatch_id']!=''){
	$dispatch_id = $_REQUEST['dispatch_id'];
}else{
	$dispatch_id=0;
}
// $dispatch_id = $_REQUEST['dispatch_id'];

?>
<div id="showrecord">
<input type="hidden" id="dispatch_id" value="<?php echo $dispatch_id; ?>" >

	 <div class="box box-color box-bordered satblue">
                                          <div class="box-title">
                                             <h3>	<i class="fa fa-table"></i>
											 Freight Bifurcation Details
                                             </h3>
                                          </div>
                                          <div class="box-content nopadding">
                                          	<table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
					<thead>
					<tr>
						<th>S.No</th>
						<!-- <th>DI No.</th> -->
						<!-- <th>Truck No.</th> -->
						<th>Category </th>
						<th>Name</th>
						<th>Rate</th>
						<th class='hidden-1024'>Amount</th>
					<th class='hidden-480'>Action</th>
					</tr>
					</thead>
					<tbody>
	   <?php
                                        $sn = 1;  
										
                                        $sel = "select * from tpa_entry where dispatch_id=$dispatch_id ";
                         $res = mysqli_query($connection, $sel);
                                        while ($row = mysqli_fetch_array($res)) {
		 $tp_name = $cmn->getvalfield($connection, "tpcategory", "tp_name", "tpcat_id='$row[tpcat_id]'");
                                            if($row['tpcat_id']==1) {
	 $catename = $cmn->getvalfield($connection, "m_agent", "agent_name", "agent_id='$row[category_id]'");
											}
											  if($row['tpcat_id']==2) {
			 $catename = $cmn->getvalfield($connection, "m_consignee", "consignee_name", "consignee_id='$row[category_id]'");
											}
											  if($row['tpcat_id']==3) {
											 $catename = $cmn->getvalfield($connection, "m_company", "cname", "compid='$row[category_id]'");
											}
											  if($row['tpcat_id']==4) {
											 $catename = $cmn->getvalfield($connection, "m_vehicle_owner", "owner_name", "owner_id='$row[category_id]'");
											}
					 $di_no = $cmn->getvalfield($connection, "dispatch_entry", "di_no", "dispatch_id='$row[dispatch_id]'");
					  $vehicle_id = $cmn->getvalfield($connection, "dispatch_entry", "vehicle_id", "dispatch_id='$row[dispatch_id]'");
 $vehicle_no = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id='$vehicle_id'");
                        $rate=$row['rate'];
                        $amt=$row['amt'];
                                    $totalamount+=  $row['amt']; 
                                          $totalrate+=  $row['rate'];

                                        ?>
					<tr>
						<td><?php echo $sn++;?></td>
					<!-- 	<td><?php echo $di_no; ?></td>
						<td><?php echo $vehicle_no; ?></td> -->
						<td><?php echo $tp_name; ?></td>
						<td><?php echo $catename; ?></td>
						<td class='hidden-350'><?php echo $rate; ?></td>
						<td class='hidden-1024'><?php echo $amt; ?></td>
				<td class='hidden-480'>
		<!-- <a href="pdf/pdf_dispatch_printA4.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-warning" rel="tooltip" title="Builty A4"target="_blank" >
			<i class="fa fa-print">A4</i>
	<a href="pdf/pdf_dispatch_printA5.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-info" rel="tooltip" title="Builty A5" style="margin-left: 3px;" target="_blank">
			<i class="fa fa-print">A5</i>
		</a> -->
		<a  onClick="edittpa(<?php echo $row['tpa_id']; ?>)" class="btn btn-inverse" rel="tooltip" title="Edit">
			<i class="fa fa-edit"></i>
		</a>
			<?php if($user_type=='admin'){ ?>
		<a onClick="funDel1(<?php echo $row['tpa_id']; ?>)" class="btn btn-danger" rel="tooltip" title="Delete">
			<i class="fa fa-times"></i>
		</a>
			<?php } ?>
		</td>
					</tr>

				<?php } ?>
				<tr><th colspan="6"></th>
			</tr>
					<tr>
						<th colspan="3" style="text-align:right;">TOTAL</th>
						<td><?php echo $totalrate; ?></td>
						<td><?php echo $totalamount; ?></td>
						<td></td>
					</tr>
					
					</tbody>
				
				</table>
                                       </div>
                                    </div>
</div>
