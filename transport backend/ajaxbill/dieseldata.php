<?php 
   include("../adminsession.php");
include("../function/bill_function.php");
     $fromdate = $_REQUEST['fromdate']; 
   $todate = $_REQUEST['todate']; 
  
     $pump_id = $_REQUEST['pump_id']; 
       $vehicle_id = $_REQUEST['vehicle_id']; 
       $dbillid = $_REQUEST['dbillid']; 

$crit='';
if ($fromdate != '' && $todate != '') {
    $crit .= "where bilty_date BETWEEN  '$fromdate' and  '$todate' ";
    //echo $crit;
}

    if ($vehicle_id != '') {
    $crit .= " and vehicle_id='$vehicle_id'";}
    
    if ($pump_id != '') {
    $crit .= " and pump_id='$pump_id'";
} 
    if ($dbillid == '') {
    $dbillid='0';
    
} else {
    $dbillno = $cmn->getvalfield($connection,"dieselbill","dbillno","dbillid='$dbillid'");
    $dbilldate = $cmn->getvalfield($connection,"dieselbill","dbilldate","dbillid='$dbillid'");
    $discountamt = $cmn->getvalfield($connection,"dieselbill","discountamt","dbillid='$dbillid'");  
      // $itemtype = $cmn->getvalfield($connection,"invoicebilty","dbillno","dbillid='$dbillid'");  
}
?>
  
<div id="dieseltable">
       &nbsp; &nbsp;<strong>Search Here</strong> <input id="myInput" type="text" placeholder="Search.." onkeyup="myFunctionsearch()" style="margin-bottom: 20px;">

 <input type="hidden" id="hideid" value="" >
 <input type="hidden" name="pump_id" id="pump_id" value="<?php echo $pump_id; ?>" />

<?php if($dbillid==0) { ?>
                            <input type="button" class="btn btn-success" value="Create Bill" style="text-align:right; float:right;" onClick="createbill();" > <?php } else { ?>
                            <input type="button" class="btn btn-success" value="Update Bill" style="text-align:right; float:right;" onClick="createbill();" >
                            <?php } ?>
    <!-- <input type="button" class="btn btn-success" value="Create Bill" style="text-align:right; float:right;" onClick="createbill();" >  -->
        <?php if($dbillid==0) { 
// echo "ok";
                                                            ?>
                                            <table class="table table-hover table-nomargin table-striped table-bordered" style="margin-top:20px;">
                                                            <thead>
                                                                <tr>
                                                                    <th><input type="checkbox" name="check0" id="check0" onClick="toggle(this.checked)" />All </th>
                              <th>Slip No.</th><th>Bilty Date</th>
                                                <th>GR No</th>
                                                <th>Invoice No</th>
                                                <th>DI No</th>
                                                <th>Item Name</th>
                                                <th>Truck No</th>
                                                <th>Consignee</th>
                                                <th>Destination</th>
                                                <th>Weight/(M.T.)</th>
                                                <th>Rate/MT</th>
                                                <!--<th>Print</th>-->
                                                <th>Freight</th>
                                                <th>Advance</th>
                                                <th>Diesel Rs</th>
                                                <th>Petrol Pump</th>
                                                <!-- <th>Brand</th> -->
                                                            
                                                                </tr>
                                                            </thead>
                                                            <tbody id="myTable">
                                                                   <?php
                                                $slno=1;                                    
                                               
                                        
                  $sql = mysqli_query($connection,"Select * from  dispatch_entry  $crit  && consignor_id=$consignorid && diesel_adv_amt!=0 && is_bill=0 && session_id=$session_id  order by dispatch_id desc");
                            
                                                
                                                while($row = mysqli_fetch_array($sql))
                                                {                                   
                                                // $gr_date = $row['gr_date'];
                                                $truckid = $row['vehicle_id'];
                                                $item_id = $row['item_id'];
                                                $consigneeid = $row['consignee_id'];
                                                $destinationid = $row['destination_id'];
                                                $supplier_id = $row['pump_id'];
                                                $brand_id = $row['brand_id'];
                                                $s = $row['bilty_date'];
                                                $dt = new DateTime($s);                             
                                                $date = $dt->format('d-m-Y');
                                                $time = $dt->format('H:i:s');   
                                                
                                                $advance = $row['other_cash_adv']+$row['cash_adv'];
                                                ?>
                                             <tr>
                                                <td><input type="checkbox" name="check<?php echo $slno; ?>" id="check<?php echo $slno; ?>" onClick="addids2()" value="<?php echo $row['dispatch_id']; ?>" <?php //if($exist){ echo "Checked" ;}?>/></td>
                                                <td><input type="text" style="width:80px"; name="slipno<?php echo $row['dispatch_id']; ?>" id="slipno<?php echo $row['dispatch_id']; ?>" onchange="addslipno(<?php echo $row['dispatch_id']; ?>)" value="<?php echo $row['slip_no']; ?>" <?php //if($exist){ echo "Checked" ;}?>/></td>
                                                <td><?php echo $cmn->dateformatindia($row['bilty_date']);?></td>
                                                <td><?php echo $row['gr_no'];?></td>
                                                <td><?php echo $row['invoice_no'];?></td>
                                                <td><?php echo $row['di_no'];?></td>
                                                <td><?php echo $cmn->getvalfield($connection,"m_item","item_name","item_id='$item_id'");?></td>
                                                <td><?php echo $cmn->getvalfield($connection," m_vehicle","vehicle_no","vehicle_id='$truckid'");?></td>
                                                <td><?php echo $cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id='$consigneeid'");?></td>
                                                <td><?php echo $cmn->getvalfield($connection,"m_place","place_name","place_id='$destinationid'");?></td>
                                                <td><?php echo ucfirst($row['wt_mt']);?></td>
                                                <td><?php echo ucfirst($row['own_rate']);?></td>
                                                <!--<td><a href= "pdf_bill_invoice.php?bilty_id=<?php //echo $row['bid_id'];?>" class="btn btn-success" target="_blank" >Print </a></td>-->
                                                <td><?php echo number_format($row['wt_mt'] * $row['own_rate'],2);?></td>
                                                <td><?php echo number_format($advance,2);?></td>
                                                <td><?php echo ucfirst($row['diesel_adv_amt']);?></td>
                                                <td><?php echo $cmn->getvalfield($connection,"m_petrol_pump","pump_name","pump_id='$supplier_id'");?></td>
                                                <!-- <td><?php echo $cmn->getvalfield($connection,"m_brand","brand_name","brand_id='$brand_id'");?></td> -->
                                             </tr>
                                             <?php
                                                $slno++;
                                                }
                                                ?>                                                          </tbody>
                                                        </table>
                                                        <?php } else {
                            // echo "hi";
                             ?><table class="table table-hover table-nomargin table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th><input type="checkbox" name="check0" id="check0" onClick="toggle(this.checked)" />All </th>
                                                                    <th>Slip No.</th> <th>Bilty Date</th>
                                                <th>GR No</th>
                                                <th>Invoice No</th>
                                                <th>DI No</th>
                                                <th>Item Name</th>
                                                <th>Truck No</th>
                                                <th>Consignee</th>
                                                <th>Destination</th>
                                                <th>Weight/(M.T.)</th>
                                                <th>Rate/MT</th>
                                                <!--<th>Print</th>-->
                                                <th>Freight</th>
                                                <th>Advance</th>
                                                <th>Diesel Rs</th>
                                                <th>Petrol Pump</th>
                                                            
                                                                </tr>
                                                            </thead>
                                                            <tbody id="myTable">
                                                                   <?php
                                                $slno=1;                                    
                                                if($user_type=='admin')
                                                {
                                                    $cond="where 1=1 "; 
                                                }
                                                else
                                                {
                                                    $cond="where 1=1 "; 
                                                }
                                               // echo  "select * from dispatch_entry $cond && session_id='$session_id' && consignor_id=$consignorid and (is_bill=0 || dbillid='$dbillid') order by dbillid desc"; 
                                              $sel = "select * from dispatch_entry $cond && session_id='$session_id' && diesel_adv_amt!=0 && consignor_id=$consignorid and (is_bill=0 || dbillid='$dbillid') order by dbillid desc";
                                                $res = mysqli_query($connection,$sel);
                                                while($row = mysqli_fetch_array($res))
                                                {                                   
                                                // $gr_date = $row['gr_date'];
                                                $truckid = $row['vehicle_id'];
                                                $item_id = $row['item_id'];
                                                $consigneeid = $row['consignee_id'];
                                             $destinationid = $row['destination_id'];
                                                $supplier_id = $row['pump_id'];
                                                $brand_id = $row['brand_id'];
                                                $s = $row['bilty_date'];
                                                $dt = new DateTime($s);                             
                                                $date = $dt->format('d-m-Y');
                                                $time = $dt->format('H:i:s');   
                                                
                                                $advance = $row['other_cash_adv']+$row['cash_adv'];
                                                $exist = $cmn->getvalfield($connection,"dispatch_entry","count(*)","dbillid='$dbillid' && dispatch_id='$row[dispatch_id]'");    
                                                ?>
                                             <tr>
                                                <td><input type="checkbox" name="check<?php echo $slno; ?>" id="check<?php echo $slno; ?>" onClick="addids2()" value="<?php echo $row['dispatch_id']; ?>" <?php if($exist !=0){ echo "Checked" ;}?>/></td>
                                                <td><input type="text" style="width:80px"; name="slipno<?php echo $row['dispatch_id']; ?>" id="slipno<?php echo $row['dispatch_id']; ?>" onchange="addslipno(<?php echo $row['dispatch_id']; ?>)" value="<?php echo $row['slip_no']; ?>" <?php //if($exist){ echo "Checked" ;}?>/></td>

                                                <td><?php echo $cmn->dateformatindia($row['bilty_date']);?></td>
                                                <td><?php echo $row['order_no'];?></td>
                                                <td><?php echo $row['invoice_no'];?></td>
                                                <td><?php echo $row['di_no'];?></td>
                                                <td><?php echo $cmn->getvalfield($connection,"m_item","item_name","item_id='$item_id'");?></td>
                                                <td><?php echo $cmn->getvalfield($connection," m_vehicle","vehicle_no","vehicle_id='$truckid'");?></td>
                                                <td><?php echo $cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id='$consigneeid'");?></td>
                                                <td><?php echo $cmn->getvalfield($connection,"m_place","place_name","place_id='$destinationid'");?></td>
                                                <td><?php echo ucfirst($row['wt_mt']);?></td>
                                                <td><?php echo ucfirst($row['own_rate']);?></td>
                                                <!--<td><a href= "pdf_bill_invoice.php?bilty_id=<?php //echo $row['bid_id'];?>" class="btn btn-success" target="_blank" >Print </a></td>-->
                                                <td><?php echo number_format($row['wt_mt'] * $row['own_rate'],2);?></td>
                                                <td><?php echo number_format($advance,2);?></td>
                                                <td><?php echo ucfirst($row['diesel_adv_amt']);?></td>
                                                <td><?php echo $cmn->getvalfield($connection,"m_petrol_pump","pump_name","pump_id='$supplier_id'");?>
                                             <!--   <select name="pump_id" id="pump_id"  style="width:100%;">-->
                                             <!--<option value="">      Select  </option>-->
                                             <?php		$sql = mysqli_query($connection,"Select * from  m_petrol_pump  order by pump_id");
                                                while($row= mysqli_fetch_array($sql)) { ?>
                                             <!--<option value="<?php echo $row['pump_id']; ?>"><?php echo $row['pump_name']; ?></option>-->
                                             <?php } ?>
                                          <!--</select>-->
                                          <!--<script>document.getElementById('pump_id').value = '<?php echo $row['pump_id']; ?>';</script>-->
                                             
                                             </td>
                                             </tr>
                                             <?php
                                                $slno++;
                                                }
                                                ?>                                                          </tbody>
                                                        </table>
                                                            <?php } ?>
                                                       </div>
 
 <div id="myModal1" class="modal fade" role="dialog">
         <div class="modal-dialog" style="width:480px;padding-top: 225px;">
            <!-- Modal content-->
            <div class="modal-content" style="border-radius: 20px;">
               <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
                  <center>
                     <h4 class="modal-title">Create Diesel Bill</h4>
                  </center>
               </div>
               <div class="modal-body" style="padding-top:30px;">
                  <div class="form-group">
                     <div class="row mb-3">
                        <label for="email" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;"><strong>Bill No :</strong></label>
                        <div class="col-sm-6">
                           <input type="text" class="form-control" id="dbillno" value="<?php echo $dbillno; ?>">
                        </div>
                     </div>
                     <br>
                     <div class="row mb-3">
                        <label for="invdate" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;"><strong>Bill Date :</strong></label>
                        <div class="col-sm-6">
                           <input type="text" class="form-control" id="dbilldate" value="<?php  if($dbilldate==''){
                            echo dateformatindia($currentdate);
                           } else { 
                            echo dateformatindia($dbilldate); 
                        } ?>">
                        </div>
                     </div>
                     <br>
                     <div class="row mb-3">
                        <label for="email" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;"><strong>Discount:</strong></label>
                        <div class="col-sm-6">
                           <input type="text" class="form-control" id="discountamt" value="<?php echo $discountamt; ?>">
                        </div>
                     </div>
                     <br>
                <!--      <div class="row mb-3">
                        <label for="itemtype"  class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;"><strong>Type :</strong></label>
                        <div class="col-sm-6">
                           <select id="itemtype" class="select2-me" style="width:120px;">
                              <option value="CEMENT">Cement</option>
                              <option value="LOOSE CLINKER">Clinker</option>
                           </select>
                           <script> document.getElementById('itemtype').value='<?php echo $itemtype; ?>'; </script>
                        </div>
                     </div> -->
                      <input type="hidden" class="form-control" id="dbillid" value="<?php echo $dbillid; ?>">
                     <br>
                     <br>
                     <!-- <button type="submit" class="btn btn-default btn-success" onClick="saveinvoice()" style="margin-top:-8px;">Submit</button> -->
                  </div>
               </div>
               <div class="modal-footer">
                  <center>
                     <button class="btn btn-primary" onClick="savebill();" tabindex="12"> Save</button>
                     <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a>
                  </center>
               </div>
            </div>
         </div>
      </div>