<?php 
   include("../adminsession.php");
include("../function/dispatch_function.php");
     $fromdate = $_REQUEST['fromdate']; 
   $todate = $_REQUEST['todate']; 
   $di_no = $_REQUEST['di_no']; 
     $owner_id = $_REQUEST['owner_id']; 
       $vehicle_id = $_REQUEST['vehicle_id']; 
$crit='';
if ($fromdate != '' && $todate != '') {
    $crit .= "where bilty_date BETWEEN  '$fromdate' and  '$todate' ";
    //echo $crit;
}
if ($di_no != '') {
    $crit .= " and di_no='$di_no'";
}
    if ($vehicle_id != '') {
    $crit .= " and vehicle_id='$vehicle_id'";}
    
    if ($owner_id != '') {
    $crit .= " and owner_id='$owner_id'";
} 

?>
  
<div id="mulrectableid">
       &nbsp; &nbsp;<strong>Search Here</strong> <input id="myInput" type="text" placeholder="Search.." onkeyup="myFunctionsearch()" style="margin-bottom: 20px;">

    <table class="table table-hover table-nomargin table-bordered dataTable dataTable-fixedcolumn dataTable-scroll-x dataTable-scroll-y">
                           <thead style="position: sticky;
                              top: 0;">
                              <tr>
                                 <th>#Sno.</th>
                                 <th>DI/LR No.</th>
                                 <th>Bilty No.</th>
                                 <th>Bilty Date.</th>
                                 <th>Consignor </th>
                                 <th>Consignee </th>
                                 <th>Ship to City</th>
                                 <th>Item</th>
                                 <th>Truck No</th>
                                 <th>Owner Name</th>
                                 <th>Owner Mo. No.</th>
                                 <th>Dis. Weight/MT/KG </th>
                                 <th>Dis. Qty (Bags)</th>
                                 <th>Invoice km</th>
                                 <th>GPS Dist. km</th>
                                 <th>Diff km</th>
                                 <th>PTPK</th>
                                 <th>Freight Debit</th>
                                 <th>Rec. Weight/MT/KG <span style="color: red">*</span></th>
                                 <th>Rec. Qty (Bags)</th>
                                 <th>Rec. Date <span style="color: red">*</span></th>
                                 <th>Unloading Place</th>
                                 <th>Shortage(MT/KG)</th>
                                 <th>Shortage(Bag)</th>
                                 <th>Rec. Type</th>
                                 <th>Rec. Upload</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody id="myTable">
 

     <?php
                                    $sn=1;
                                    // echo "Select * from  dispatch_entry  $crit  && is_receive='' && consignor_id=$consignorid order by dispatch_id desc";
                $sql = mysqli_query($connection,"Select * from  dispatch_entry  $crit  && is_receive='' && consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id order by dispatch_id desc");
                                          while($row= mysqli_fetch_array($sql)) {
    $consignor_name=$cmn->getvalfield($connection,"m_consignor","consignor_name","consignor_id=$row[consignor_id]");
    $consignee_name=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id=$row[consignee_id]");
   
    $vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
$destination=$cmn->getvalfield($connection,"m_place","place_name","place_id=$row[destination_id]"); 
$item_name=$cmn->getvalfield($connection,"m_item","item_name","item_id=$row[item_id]");

$owner_name = $cmn->getvalfield($connection, "m_vehicle_owner", "owner_name", "owner_id ='$row[owner_id]'");
$mobile_no = $cmn->getvalfield($connection, "m_vehicle_owner", "mobileno1", "owner_id ='$row[owner_id]'");         $dispatch_id=$row['dispatch_id'];                        
                                           
      ?>
                              <tr>
                                <td> <?php echo $sn++; ?></td>
                                 <td><?php echo $row['di_no']; ?></td>
                                 <td><?php echo $row['bilty_no']; ?></td>
                               <td><?php echo dateformatindia($row['bilty_date']); ?></td>
                                 <td><?php echo $consignor_name; ?></td>
                                 <td><?php echo $consignee_name; ?></td>
                                 <td><?php echo $destination; ?></td>
                                 <td><?php echo $item_name; ?></td>
                               <td><?php echo $vehicle_no; ?></td>
                               <td><?php echo $owner_name; ?></td>
                               <td><?php echo $mobile_no; ?></td>
                               <td><?php echo $row['wt_mt']; ?>
                 <input type="hidden" name="wt_mt" id="wt_mt<?php echo $dispatch_id; ?>" placeholder="Receive Wt" class="form-control" style="width: 70px;" value="<?php echo $row['wt_mt']; ?>" >
                               </td>
                               
         <td><?php echo $row['qty']; ?><input type="hidden" name="qty" id="qty<?php echo $dispatch_id; ?>" placeholder="Receive Wt" class="form-control" style="width: 70px;" value="<?php echo $row['qty']; ?>" ></td>
         <td><?php echo $row['inv_km']; ?><input type="hidden" name="inv_km" id="inv_km<?php echo $dispatch_id; ?>" placeholder="Receive Wt" class="form-control" style="width: 70px;" value="<?php echo $row['inv_km']; ?>" ></td>
         <td><input type="text" name="gps_km" id="gps_km<?php echo $dispatch_id; ?>" placeholder="GPS Km" class="form-control" style="width: 70px;" onchange="diffkm(<?php echo $dispatch_id; ?>);"></td>
         <td><span style="color: red" id="difkm<?php echo $dispatch_id; ?>"></span>
         <input type="hidden" name="diffkm1" id="diffkm1<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" >
      </td>
         <td><input type="text" name="ptpk" id="ptpk<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" ></td>
         <td><input type="text" name="frt_debit" id="frt_debit<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" ></td>
         <td><input type="text" name="rec_wt" id="rec_wt<?php echo $dispatch_id; ?>" placeholder="Receive Wt" class="form-control" style="width: 70px;" onchange="shortvalue(<?php echo $dispatch_id; ?>);"></td>
    <td><input type="text" name="rec_qty" id="rec_qty<?php echo $dispatch_id; ?>" placeholder="Receive QTY " class="form-control" style="width: 70px;" onchange="shortvalue(<?php echo $dispatch_id; ?>);"></td>
<td style="width:100%;"><input type="date" name="rec_date" id="rec_date<?php echo $dispatch_id; ?>" placeholder="Text input" class="form-control" style="width: 100px;" value="<?php echo $currentdate; ?>"></td>
             <td><input type="text" name="unloading_place" id="unloading_place<?php echo $dispatch_id; ?>" placeholder="Enter Unloading Place" class="form-control" style="width: 200px;"></td>
                                 <td><span style="color: red" id="shortwt<?php echo $dispatch_id; ?>"></span></td>
                                 <td><span style="color: red" id="shortqty<?php echo $dispatch_id; ?>"></span></td>
                                <td>
            <select name="receive_type" id="receive_type<?php echo $dispatch_id; ?>" class='form-control' style="width: 110px;">
                                       <option value="0">NO Shortage</option>
                                       <option value="1">Shortage</option>
                                       <option value="1">Damage</option>
                                    </select>
                                 </td>
                                 <td>  <input type="file" name="rec_img" id="rec_img<?php echo $dispatch_id; ?>"  class="form-control"  ></td>
                                 <td><a type="submit" onclick="savemultiple(<?php echo $dispatch_id; ?>);" class="btn btn-primary">Update</a>
                                    <br>
                                 <span style="color:#F00;width: 70px;" id="msg<?php echo $dispatch_id; ?>"></span></td>
                              </tr>
                              <?php }
   ?>
                           </tbody>
                        </table> </div>
 
