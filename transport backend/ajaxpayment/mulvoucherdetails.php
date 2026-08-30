<?php
error_reporting(0);
include("../adminsession.php");
// include("function/payment_function.php");
$fromdate = $_REQUEST['fromdate'];
$todate = $_REQUEST['todate'];
$cat_id = $_REQUEST['cat_id'];
$catname = $_REQUEST['catname'];

$item_id = $_REQUEST['item_id'];
$vehicle_id = $_REQUEST['vehicle_id'];
$crit3 = '';
$crit = '';
if ($fromdate != '' && $todate != '') {
    $crit .= "where bilty_date BETWEEN  '$fromdate' and  '$todate' ";
}
if ($catname != '' && $cat_id == 1) {
    $crit4 .= " and tpa_entry.category_id='$catname'";
}

if ($catname != '' && $cat_id == 2) {
    $crit4 .= " and tpa_entry.category_id='$catname' ";
}
if ($catname != '' && $cat_id == 4) {

    $owner_id = $catname;
    $category_id = $catname;
    if ($owner_id != '') {
        $crit1 .= " and owner_id='$owner_id' ";
    }
    if ($category_id != '') {
        $crit4 .= " and tpa_entry.category_id='$catname'";
    }
}

if ($item_id != '') {
    $crit3 .= " AND item_id='$item_id'";
    $crit4 .= " AND dispatch_entry.item_id = '$item_id'";
}


if ($vehicle_id != '') {
    $crit3 .= " AND vehicle_id='$vehicle_id'";
    $crit4 .= " AND dispatch_entry.vehicle_id = '$vehicle_id'";
}




if ($cat_id == 1) {

    $sql = mysqli_query($connection, "select * from m_agent where agent_id='$catname'");
    $row = mysqli_fetch_array($sql);
    $acc_no = $row['acc_no'];
    $ifsc_code = $row['ifsc_code'];
    $panno = $row['pan_no'];
}
if ($cat_id == 2) {

    $sql = mysqli_query($connection, "select * from m_consignee where consignee_id='$catname'");
    $row = mysqli_fetch_array($sql);
    $acc_no = $row['acc_no'];
    $ifsc_code = $row['ifsc_code'];
    $panno = $row['pan_no'];
}
if ($cat_id == 4) {

    $sql = mysqli_query($connection, "select * from m_vehicle_owner where owner_id='$catname'");
    $row = mysqli_fetch_array($sql);
    $acc_no = $row['acc_no'];
    $ifsc_code = $row['ifsc_code'];
    $panno = $row['pan_no'];
}



?>

<div id="mulrectableid">


    <div>
        <form action="#" method="POST" class='form-horizontal form-column form-bordered'>
            <div class="row">
                <!-- Voucher Date -->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="textfield" class="control-label col-sm-4">Voucher Date<span style="color: red">*</span></label>
                        <div class="col-sm-8">
                            <input type="date" name="voucher_date" id="voucher_date" class="form-control" value="<?php echo $currentdate; ?>" required>
                        </div>
                    </div>
                </div>

                <!-- Paid To (Select2) -->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="textfield" class="control-label col-sm-4">Paid To<span style="color: red; padding: 3px 5px;">*</span></label>
                        <div class="col-sm-8">
                            <select name="payee_name" id="payee_name" class="select2-me" onchange="getPayeeDetails(this.value);" style="width:100%; padding: 5px 10px;">
                                <option value="">Select</option>
                                <?php
                                $sql = mysqli_query($connection, "SELECT * FROM paid_to ORDER BY payee_id");
                                while ($row = mysqli_fetch_array($sql)) { ?>
                                    <option value="<?php echo $row['payee_name']; ?>"><?php echo $row['payee_name']; ?></option>
                                <?php } ?>
                                <script>
                                    document.getElementById('payee_name').value = '<?php echo $payee_name; ?>';
                                </script>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Account No. -->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="textfield" class="control-label col-sm-4">Account No.</label>
                        <div class="col-sm-8">
                            <input type="text" name="acc_no" id="acc_no" placeholder="Enter Account No." class="form-control" value="<?php echo $acc_no; ?>" required>
                        </div>
                    </div>
                </div>


                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="textfield" class="control-label col-sm-4">Ifsc Code</label>
                        <div class="col-sm-8">
                            <input type="text" name="ifsc_code" id="ifsc_code" placeholder="Enter IFSC" class="form-control" value="<?php echo $ifsc_code; ?>" required>
                        </div>
                    </div>
                </div>


                
            </div

            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="textfield" class="control-label col-sm-4">Pan No.</label>
                        <div class="col-sm-8">
                            <input type="text" name="panno" id="panno" placeholder="Enter Pan No." class="form-control" value="<?php echo $panno; ?>" required>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="textfield" class="control-label col-sm-4">Remark</label>
                        <div class="col-sm-8">
                            <input type="text" name="remark" id="remark" placeholder="Enter Remark" class="form-control" value="<?php echo $remark; ?>" required>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="textfield" class="control-label col-sm-4">Bill Type</label>
                        <div class="col-sm-8">
                            <select name="bill_type" id="bill_type" class='form-control' onchange="showGst(this.value);" required>
                                <option value="">Select</option>

                                <option value="Challan">Challan</option>
                                <option value="Invoice">Invoice</option>
                                <script>
                                    document.getElementById('bill_type').value = '<?php echo $bill_type; ?>';
                                </script>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3" id="th1" style="display:none;">
                    <div class="form-group">
                        <label for="textfield" class="control-label col-sm-4">GST Type </label>
                        <div class="col-sm-8">
                            <select name="gst_type" id="gst_type" class="form-control">
                                <option value="">Select</option>

                                <option value="GST">GST</option>
                                <option value="IGST">IGST</option>
                                <script>
                                    document.getElementById('gst_type').value = '<?php echo $gst_type; ?>';
                                </script>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2" id="th2" style="display:none;">
                    <div class="form-group">
                        <label for="textfield" class="control-label col-sm-4">GST %</label>
                        <div class="col-sm-8">
                            <select name="gst" id="gst" class='form-control' onchange="GstPaste(this.value);">
                                <option value="">Select</option>

                                <option value="5">5% </option>
                                <option value="12">12%</option>
                                <option value="18">18%</option>
                                <option value="28">28%</option>
                                <script>
                                    document.getElementById('gstper').value = '<?php echo $gstper; ?>';
                                </script>
                            </select>
                        </div>
                    </div>
                </div>
            </div>


</div>


<table class="table table-hover table-nomargin table-bordered dataTable dataTable-fixedcolumn dataTable-scroll-x dataTable-scroll-y">
    <thead style="position: sticky;
                              top: 0;">
        <tr>
            <th>#Sno.</th>
            <th>DI/LR No.</th>
            <!-- <th>Bilty No.</th> -->
            <th>Bilty Date.</th>
            <th>Voucher Name</th>
            <th>Truck No.</th>
            <th>Destination </th>
            <th>Weight</th>
            <th>Receive Weight</th>
            <th>Company Rate</th>
            <th>Own Rate</th>
            <th>Adv. Paid to</th>
            <th>Commision</th>
            <th>Freight Rate</th>
            <th>Freight Amt</th>
            <?php if ($cat_id == 4) { ?>
                <th>Freight Debit</th>
            <?php  } ?>
            <th>Bilty Commision<span style="color: red">*</span></th>
            <?php if ($cat_id == 4) { ?>
                <th>Short Bag</th>
                <th>Cement Rate</th>
            <?php  } ?>
            <th>Shortage Amt</th>

            <th>Tds %</th>
            <th>Tds Amt</th>
            <th>Bank Charge</th>
            <th>Rebidding Charge</th>
            <th>Diesel Adv. Amt.</th>
            <th>Cash Advance</th>
            <th>GPS Amt</th>
            <th>AdBlue Amt</th>
            <th>Extra Amt</th>
            <th style="display:none;">Consignee Cash Adv.</th>
            <th>GST %</th>
            <th>Net Amt</th>
            <th>Amt Paid to</th>
            <!-- <th>Remark</th> -->
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <input type="hidden" name="cat_id" id="cat_id" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $cat_id; ?>">
        <input type="hidden" name="catname" id="catname" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $catname; ?>">
        <?php
        if ($cat_id == 4) {
            $sn = 1;
            // echo "Select * from  dispatch_entry  $crit && is_receive=1 && checkbox=0 && consignor_id=$consignorid && is_create=0 $crit1 && comp_id=$comp_id $crit3 && session_id=$session_id order by dispatch_id desc";die;
            // echo    "Select * from  dispatch_entry  $crit && is_receive=1 && checkbox=0 && consignor_id=$consignorid && is_create=0 $crit1 && comp_id=$comp_id $crit3 && session_id=$session_id order by dispatch_id desc";
            $sql = mysqli_query($connection, "Select * from  dispatch_entry  $crit && is_receive=1 && checkbox=0 && consignor_id=$consignorid && is_create=0 $crit1 && comp_id=$comp_id $crit3 && session_id=$session_id order by dispatch_id desc");
            while ($row = mysqli_fetch_array($sql)) {
                $vehicle_no = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id=$row[vehicle_id]");
                $owner_name = $cmn->getvalfield($connection, "m_vehicle_owner", "owner_name", "owner_id=$row[owner_id]");
                $wt_mt = $row['wt_mt'];
                $rec_wt = $row['rec_wt'];
                $sortwt = $wt_mt - $rec_wt;
                $own_rate = $row['own_rate'];
                $comp_rate = $row['comp_rate'];
                $qty = $row['qty'];
                $recqty = $row['rec_qty'];
                $deduct = $row['deduct'];
                $sortqty = $qty - $recqty;
                $commision = $comp_rate - $own_rate;
                $freight_amt = $wt_mt * $own_rate;
                $sortamt = $sortwt * $own_rate;
                $dispatch_id = $row['dispatch_id'];
                $frt_debit = $row['frt_debit'];
                $destination = $cmn->getvalfield($connection, "m_place", "place_name", "place_id ='$row[destination_id]'");
        ?>
                <tr>
                    <td><?php echo $sn++; ?></td>
                    <td><?php echo $row['di_no']; ?></td>
                    <td><?php echo dateformatindia($row['bilty_date']); ?></td>
                    <td><?php echo $owner_name; ?>

                    </td>
                    <td><?php echo $vehicle_no; ?></td>
                    <td><?php echo $destination; ?></td>
                    <td><?php echo $wt_mt; ?></td>
                    <td><?php echo $rec_wt; ?></td>
                    <td><?php echo $comp_rate; ?></td>
                    <td><?php echo $own_rate; ?></td>
                    <td><?php echo "Truck Owner" ?><input type="hidden" name="paid_to" id="paid_to<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo "Truck Owner"; ?>"></td>
                    <td><?php echo $commision; ?>
                        <input type="hidden" name="commision" id="commision<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $commision; ?>">
                    </td>
                    <td><?php echo $own_rate; ?><input type="hidden" name="freight_rate" id="freight_rate<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $own_rate; ?>"></td>
                    <td><?php echo $freight_amt; ?>
                        <input type="hidden" name="freight_amt" id="freight_amt<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $freight_amt; ?>">
                    </td>
                    <td>
                        <!--<?php echo $frt_debit; ?>-->
                        <input type="text" name="frt_debit" id="frt_debit<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $frt_debit; ?>">
                    </td>
                    <td>
                        <input type="text" name="bilty_commision" id="bilty_commision<?php echo $dispatch_id; ?>" placeholder="Commision" class="form-control" style="width: 70px;" onchange="gettotalamt(<?php echo $dispatch_id; ?>);">
                    </td>

                    <td>
                        <input type="text" name="sortqty" id="sortqty<?php echo $dispatch_id; ?>" placeholder="Short Qty" class="form-control" style="width: 70px;" value="<?php echo $sortqty; ?>" readonly>
                    </td>
                    <td>
                        <input type="text" name="cmtrate" id="cmtrate<?php echo $dispatch_id; ?>" placeholder="Cement Rate" class="form-control" style="width: 70px;" onchange="getcmntamt(<?php echo $dispatch_id; ?>);" value="">
                    </td>
                    <td>
                        <input type="text" name="sortamt" id="sortamt<?php echo $dispatch_id; ?>" placeholder="Short Amt" class="form-control" style="width: 70px;" onchange="gettotalamt(<?php echo $dispatch_id; ?>);" value="<?php echo $sortamt; ?>">
                    </td>
                    <td>
                        <input type="text" name="tds" id="tds<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" onchange="gettotaltds(<?php echo $dispatch_id; ?>);gettotalamt(<?php echo $dispatch_id; ?>);">
                    </td>
                    <td>
                        <input type="text" name="tds_amt" id="tds_amt<?php echo $dispatch_id; ?>" placeholder="Amount" class="form-control" style="width: 70px;" onchange="shortvalue(<?php echo $dispatch_id; ?>);">
                    </td>
                    <td>
                        <input type="text" name="bank_charge" id="bank_charge<?php echo $dispatch_id; ?>" placeholder="Amount" class="form-control" style="width: 70px;" onchange="gettotalamt(<?php echo $dispatch_id; ?>);">
                    </td>
                    <td>
                        <input type="text" name="rebidcharge" id="rebidcharge<?php echo $dispatch_id; ?>" placeholder="Amount" class="form-control" style="width: 70px;" onchange="gettotalamt(<?php echo $dispatch_id; ?>);">
                    </td>

                    <td>
                        <?php echo $row['diesel_adv_amt']; ?>
                        <input type="hidden" name="diesel_adv_amt" id="diesel_adv_amt<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $row['diesel_adv_amt']; ?>">
                    </td>
                    <td><?php echo $row['cash_adv']; ?>
                        <input type="hidden" name="cash_adv" id="cash_adv<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $row['cash_adv']; ?>">
                    </td>
                    <td><?php echo $row['other_cash_adv']; ?>
                        <input type="hidden" name="other_cash_adv" id="other_cash_adv<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $row['other_cash_adv']; ?>">
                    </td>
                    <td><?php echo $row['consignor_cash_adv']; ?>
                        <input type="hidden" name="consignor_cash_adv" id="consignor_cash_adv<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $row['consignor_cash_adv']; ?>">
                    </td>
                    <td><?php echo $row['deduct']; ?>
                        <input type="hidden" name="deduct" id="deduct<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $row['deduct']; ?>">
                    </td>
                    <td style="display:none;"><?php echo $row['consignee_cash_adv']; ?>
                        <input type="hidden" name="consignee_cash_adv" id="consignee_cash_adv<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $row['consignee_cash_adv']; ?>">
                    </td>
                    <td> <input type="text" name="gstper" id="gstper<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" onchange="getgstvalue();"></td>
                    <td> <input type="text" name="netamt" id="netamt<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;"></td>

                    <td>
                        <input type="text" name="total_amt" id="total_amt<?php echo $dispatch_id; ?>" placeholder="Amount" class="form-control" style="width: 70px;">
                    </td>

                    <td><a type="submit" onclick="savemultiple(<?php echo $dispatch_id; ?>);" class="btn btn-primary">Update</a><br>
                        <span style="color:#F00;width: 70px;" id="msg<?php echo $dispatch_id; ?>"></span>
                    </td>
                </tr>

        <?php
                $arraycomission .= $dispatch_id . ",";
            }
        } ?>
        <?php
        if ($cat_id == '1') {
            $sn = 1;


            // $sql1 = mysqli_query($connection, "Select * from  tpa_entry  $crit && tpcat_id=1 && is_create=0 && consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id");
            $sql = mysqli_query($connection, "
    SELECT tpa_entry.* 
    FROM tpa_entry 
    INNER JOIN dispatch_entry 
        ON dispatch_entry.dispatch_id = tpa_entry.dispatch_id 
    WHERE tpa_entry.bilty_date BETWEEN '$fromdate' AND '$todate' 
    AND tpa_entry.tpcat_id = 1 
    AND tpa_entry.is_create = 0 
    AND tpa_entry.consignorid = '$consignorid' 
    AND tpa_entry.comp_id = '$comp_id' 
    $crit4  $crit2
    AND tpa_entry.session_id = '$session_id'
");

            while ($row1 = mysqli_fetch_array($sql1)) {
                $dispatch_id = $row1['dispatch_id'];
                $freight_amt = $row1['amt'];
                $freight_rate = $row1['rate'];
                $agent_name = $cmn->getvalfield($connection, "m_agent", "agent_name", "agent_id='$row1[category_id]'");
                $sql = mysqli_query($connection, "Select * from  dispatch_entry where dispatch_id=$dispatch_id && is_receive=1");
                while ($row = mysqli_fetch_array($sql)) {
                    $vehicle_no = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id='$row[vehicle_id]'");

                    $destination = $cmn->getvalfield($connection, "m_place", "place_name", "place_id ='$row[destination_id]'");
                    $paid_to = $row['paid_to'];
                    $comp_rate = $row['comp_rate'];
                    $own_rate = $row['own_rate'];
                    $rec_wt = $row['rec_wt'];
                    $wt_mt = $row['wt_mt'];
                    if ($paid_to == 'Agent') {


                        $diesel_adv_amt = $row['diesel_adv_amt'];
                        $cash_adv = $row['cash_adv'];
                        $other_cash_adv = $row['other_cash_adv'];
                        $consignor_cash_adv = $row['consignor_cash_adv'];
                        $consignee_cash_adv = $row['consignee_cash_adv'];
                        $deduct = $row['deduct'];
                        $commision = $comp_rate - $own_rate;
                        $sort_wt = $wt_mt - $rec_wt;
                        $sortamt = $sort_wt * $own_rate;
                    }
                    if ($paid_to != 'Agent' && $paid_to == 'Consignee' || $paid_to == 'Truck Owner') {

                        $diesel_adv_amt = 0;
                        $cash_adv = 0;
                        $other_cash_adv = 0;
                        $consignor_cash_adv = 0;
                        $consignee_cash_adv = 0;
                        $sortamt = 0;
                        $deduct = 0;
                        $commision = 0;
                    }


        ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $row['di_no']; ?></td>
                        <td><?php echo dateformatindia($row['bilty_date']); ?></td>
                        <td><?php echo $agent_name; ?></td>
                        <td><?php echo $vehicle_no; ?></td>
                        <td><?php echo $destination; ?></td>
                        <td><?php echo $wt_mt; ?></td>
                        <td><?php echo $rec_wt; ?></td>
                        <td><?php echo $comp_rate; ?></td>
                        <td><?php echo $own_rate; ?></td>
                        <td><?php echo $paid_to; ?>
                            <input type="hidden" name="paid_to" id="paid_to<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $paid_to; ?>">
                        </td>
                        <td><?php echo $commision; ?>
                            <input type="hidden" name="commision" id="commision<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $commision; ?>">
                        </td>
                        <td><?php echo $freight_rate; ?>
                            <input type="hidden" name="freight_rate" id="freight_rate<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $freight_rate; ?>">
                        </td>
                        <td><?php echo $freight_amt; ?>
                            <input type="hidden" name="freight_amt" id="freight_amt<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $freight_amt; ?>">
                        </td>

                        <input type="hidden" name="frt_debit" id="frt_debit<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="">

                        <td>
                            <input type="text" name="bilty_commision" id="bilty_commision<?php echo $dispatch_id; ?>" placeholder="Commision" class="form-control" style="width: 70px;" onchange="gettotalamt(<?php echo $dispatch_id; ?>);" <?php if ($paid_to != 'Agent') { ?>
                                readonly
                                <?php } ?>>
                        </td>
                        <td>
                            <input type="text" name="sortamt" id="sortamt<?php echo $dispatch_id; ?>" placeholder="Short Amt" class="form-control" style="width: 70px;" onchange="gettotalamt(<?php echo $dispatch_id; ?>);" value="<?php echo $sortamt; ?>" <?php if ($paid_to != 'Agent') { ?>
                                readonly
                                <?php } ?>>
                        </td>
                        <td>
                            <input type="text" name="tds" id="tds<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" onchange="gettotaltds(<?php echo $dispatch_id; ?>);gettotalamt(<?php echo $dispatch_id; ?>);">
                        </td>
                        <td>
                            <input type="text" name="tds_amt" id="tds_amt<?php echo $dispatch_id; ?>" placeholder="Amount" class="form-control" style="width: 70px;" onchange="gettotalamt(<?php echo $dispatch_id; ?>);">
                        </td>
                        <td>
                            <input type="text" name="bank_charge" id="bank_charge<?php echo $dispatch_id; ?>" placeholder="Amount" class="form-control" style="width: 70px;" onchange="gettotalamt(<?php echo $dispatch_id; ?>);">
                        </td>

                        <td>
                            <input type="text" name="rebidcharge" id="rebidcharge<?php echo $dispatch_id; ?>" placeholder="Amount" class="form-control" style="width: 70px;" onchange="gettotalamt(<?php echo $dispatch_id; ?>);">
                        </td>
                        <td><?php echo $diesel_adv_amt; ?>
                            <input type="hidden" name="diesel_adv_amt" id="diesel_adv_amt<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $diesel_adv_amt; ?>">
                        </td>
                        <td><?php echo $cash_adv; ?>
                            <input type="hidden" name="cash_adv" id="cash_adv<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $cash_adv; ?>">
                        </td>
                        <td><?php echo $other_cash_adv; ?>
                            <input type="hidden" name="other_cash_adv" id="other_cash_adv<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $other_cash_adv; ?>">
                        </td>
                        <td><?php echo $consignor_cash_adv; ?>
                            <input type="hidden" name="consignor_cash_adv" id="consignor_cash_adv<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $consignor_cash_adv; ?>">
                        </td>
                        <td><?php echo $deduct; ?>
                            <input type="hidden" name="deduct" id="deduct<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $deduct; ?>">
                        </td>
                        <td style="display:none;"><?php echo $consignee_cash_adv; ?>
                            <input type="hidden" name="consignee_cash_adv" id="consignee_cash_adv<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $consignee_cash_adv; ?>">
                        </td>
                        <td>
                            <input type="text" name="gstper" id="gstper<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" onchange="getgstvalue();">
                        </td>
                        <td>
                            <input type="text" name="netamt" id="netamt<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;">
                        </td>
                        <td>
                            <input type="text" name="total_amt" id="total_amt<?php echo $dispatch_id; ?>" placeholder="Amount" class="form-control" style="width: 70px;">
                        </td>

                        <td><a type="submit" onclick="savemultiple(<?php echo $dispatch_id; ?>);" class="btn btn-primary">Update</a><br>
                            <span style="color:#F00;width: 70px;" id="msg<?php echo $dispatch_id; ?>"></span>
                        </td>
                        </td>
                    </tr>
        <?php
                    $arraycomission .= $dispatch_id . ",";
                }
            }
        } ?>
        <?php
        if ($cat_id == '2') {
            $sn = 1;
            //                         echo  "
            //     SELECT tpa_entry.* 
            //     FROM tpa_entry 
            //     INNER JOIN dispatch_entry 
            //         ON dispatch_entry.dispatch_id = tpa_entry.dispatch_id 
            //     WHERE tpa_entry.bilty_date BETWEEN '$fromdate' AND '$todate' 
            //     AND tpa_entry.tpcat_id = 2
            //     AND tpa_entry.is_create = 0 
            //     AND tpa_entry.consignorid = '$consignorid' 
            //     AND tpa_entry.comp_id = '$comp_id' 
            //     $crit4 
            //     AND tpa_entry.session_id = '$session_id'
            // ";
            $sql1 = mysqli_query($connection, "
    SELECT tpa_entry.* 
    FROM tpa_entry 
    INNER JOIN dispatch_entry 
        ON dispatch_entry.dispatch_id = tpa_entry.dispatch_id 
    WHERE tpa_entry.bilty_date BETWEEN '$fromdate' AND '$todate' 
    AND tpa_entry.tpcat_id = 2 
    AND tpa_entry.is_create = 0 
    AND tpa_entry.consignorid = '$consignorid' 
    AND tpa_entry.comp_id = '$comp_id' 
    $crit4
    AND tpa_entry.session_id = '$session_id'
");
            // $sql1 = mysqli_query($connection, "Select * from  tpa_entry  $crit && tpcat_id=2 && is_create=0 && consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id");
            while ($row1 = mysqli_fetch_array($sql1)) {
                $dispatch_id = $row1['dispatch_id'];
                $freight_amt = $row1['amt'];
                $freight_rate = $row1['rate'];
                $consignee_name = $cmn->getvalfield($connection, "m_consignee", "consignee_name", "consignee_id ='$row1[category_id]'");
                $sql = mysqli_query($connection, "Select * from  dispatch_entry where dispatch_id=$dispatch_id && is_receive=1");
                while ($row = mysqli_fetch_array($sql)) {
                    $vehicle_no = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id='$row[vehicle_id]'");
                    $destination = $cmn->getvalfield($connection, "m_place", "place_name", "place_id ='$row[destination_id]'");

                    $paid_to = $row['paid_to'];
                    $comp_rate = $row['comp_rate'];
                    $own_rate = $row['own_rate'];
                    $rec_wt = $row['rec_wt'];
                    $wt_mt = $row['wt_mt'];
                    if ($paid_to == 'Consignee') {


                        $diesel_adv_amt = $row['diesel_adv_amt'];
                        $cash_adv = $row['cash_adv'];
                        $other_cash_adv = $row['other_cash_adv'];
                        $consignor_cash_adv = $row['consignor_cash_adv'];
                        $consignee_cash_adv = $row['consignee_cash_adv'];
                        $commision = $comp_rate - $own_rate;
                        $sort_wt = $wt_mt - $rec_wt;
                        $deduct = $row['deduct'];
                        $sortamt = $sort_wt * $own_rate;
                    }
                    if ($paid_to != 'Consignee' && $paid_to == 'Agent' || $paid_to == 'Truck Owner') {

                        $diesel_adv_amt = 0;
                        $cash_adv = 0;
                        $deduct = 0;
                        $other_cash_adv = 0;
                        $consignor_cash_adv = 0;
                        $consignee_cash_adv = 0;
                        $sortamt = 0;
                        $commision = 0;
                    }


        ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $row['di_no']; ?></td>
                        <td><?php echo dateformatindia($row['bilty_date']); ?></td>
                        <td><?php echo $consignee_name; ?></td>
                        <td><?php echo $vehicle_no; ?></td>
                        <td><?php echo $destination; ?></td>
                        <td><?php echo $wt_mt; ?></td>
                        <td><?php echo $rec_wt; ?></td>
                        <td><?php echo $comp_rate; ?></td>
                        <td><?php echo $own_rate; ?></td>
                        <td><?php echo $paid_to; ?> <input type="hidden" name="paid_to" id="paid_to<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $paid_to; ?>"></td>
                        <td><?php echo $commision; ?>
                            <input type="hidden" name="commision" id="commision<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $commision; ?>">
                        </td>
                        <td><?php echo $freight_rate; ?>
                            <input type="hidden" name="freight_rate" id="freight_rate<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $freight_rate; ?>">
                        </td>
                        <td><?php echo $freight_amt; ?>
                            <input type="hidden" name="freight_amt" id="freight_amt<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $freight_amt; ?>">
                        </td>

                        <input type="hidden" name="frt_debit" id="frt_debit<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="">

                        <input type="hidden" name="cmtrate" id="cmtrate<?php echo $dispatch_id; ?>" placeholder="Cement Rate" class="form-control" style="width: 70px;" onchange="getcmntamt(<?php echo $dispatch_id; ?>);" value="">

                        <td>
                            <input type="text" name="bilty_commision" id="bilty_commision<?php echo $dispatch_id; ?>" placeholder="Commision" class="form-control" style="width: 70px;" onchange="gettotalamt(<?php echo $dispatch_id; ?>);" <?php if ($paid_to != 'Consignee') { ?>
                                readonly
                                <?php } ?>>
                        </td>
                        <td>
                            <input type="text" name="sortamt" id="sortamt<?php echo $dispatch_id; ?>" placeholder="Short Amt" class="form-control" style="width: 70px;" onchange="gettotalamt(<?php echo $dispatch_id; ?>);" value="<?php echo $sortamt; ?>">
                        </td>
                        <td>
                            <input type="text" name="tds" id="tds<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" onchange="gettotaltds(<?php echo $dispatch_id; ?>);gettotalamt(<?php echo $dispatch_id; ?>);">
                        </td>
                        <td>
                            <input type="text" name="tds_amt" id="tds_amt<?php echo $dispatch_id; ?>" placeholder="Amount" class="form-control" style="width: 70px;" onchange="gettotalamt(<?php echo $dispatch_id; ?>);">
                        </td>
                        <td>
                            <input type="text" name="bank_charge" id="bank_charge<?php echo $dispatch_id; ?>" placeholder="Amount" class="form-control" style="width: 70px;" onchange="gettotalamt(<?php echo $dispatch_id; ?>);">
                        </td>
                        <td>
                            <input type="text" name="rebidcharge" id="rebidcharge<?php echo $dispatch_id; ?>" placeholder="Amount" class="form-control" style="width: 70px;" onchange="gettotalamt(<?php echo $dispatch_id; ?>);">
                        </td>

                        <td><?php echo $diesel_adv_amt; ?>
                            <input type="hidden" name="diesel_adv_amt" id="diesel_adv_amt<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $diesel_adv_amt; ?>">
                        </td>
                        <td><?php echo $cash_adv; ?>
                            <input type="hidden" name="cash_adv" id="cash_adv<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $cash_adv; ?>">
                        </td>
                        <td><?php echo $other_cash_adv; ?>
                            <input type="hidden" name="other_cash_adv" id="other_cash_adv<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $other_cash_adv; ?>">
                        </td>
                        <td><?php echo $consignor_cash_adv; ?>
                            <input type="hidden" name="consignor_cash_adv" id="consignor_cash_adv<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $consignor_cash_adv; ?>">
                        </td>
                        <td><?php echo $deduct; ?>
                            <input type="hidden" name="deduct" id="deduct<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $deduct; ?>">
                        </td>
                        <td style="display:none;"><?php echo $consignee_cash_adv; ?>
                            <input type="hidden" name="consignee_cash_adv" id="consignee_cash_adv<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $consignee_cash_adv; ?>">
                        </td>
                        <td> <input type="text" name="gstper" id="gstper<?php echo $dispatch_id; ?>" placeholder=" " class="form-control" style="width: 70px;" onchange="getgstvalue();"></td>
                        <td> <input type="text" name="netamt" id="netamt<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;"></td>
                        <td>
                            <input type="text" name="total_amt" id="total_amt<?php echo $dispatch_id; ?>" placeholder="Amount" class="form-control" style="width: 70px;">
                        </td>

                        <td><a type="submit" onclick="savemultiple(<?php echo $dispatch_id; ?>);" class="btn btn-primary">Update</a><br>
                            <span style="color:#F00;width: 70px;" id="msg<?php echo $dispatch_id; ?>"></span>
                        </td>
                        </td>
                    </tr>
        <?php
                    $arraycomission .= $dispatch_id . ",";
                }
            }
        } ?>
        <?php
        if ($cat_id == '4') {
            //   echo "
            //     SELECT tpa_entry.* 
            //     FROM tpa_entry 
            //     INNER JOIN dispatch_entry 
            //         ON dispatch_entry.dispatch_id = tpa_entry.dispatch_id 
            //     WHERE tpa_entry.bilty_date BETWEEN '$fromdate' AND '$todate' 
            //     AND tpa_entry.tpcat_id = 4 
            //     AND tpa_entry.is_create = 0 
            //     AND tpa_entry.consignorid = '$consignorid' 
            //     AND tpa_entry.comp_id = '$comp_id' 
            //     $crit4
            //     AND tpa_entry.session_id = '$session_id'";
            $sql1 = mysqli_query(
                $connection,
                "
    SELECT tpa_entry.* 
    FROM tpa_entry 
    INNER JOIN dispatch_entry 
        ON dispatch_entry.dispatch_id = tpa_entry.dispatch_id 
    WHERE tpa_entry.bilty_date BETWEEN '$fromdate' AND '$todate' 
    AND tpa_entry.tpcat_id = 4 
    AND tpa_entry.is_create = 0 
    AND tpa_entry.consignorid = '$consignorid' 
    AND tpa_entry.comp_id = '$comp_id' 
    $crit4
    AND tpa_entry.session_id = '$session_id'"
            );

            // "Select * from  tpa_entry  $crit && tpcat_id=4 && is_create=0 $crit2 && consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id");
            while ($row1 = mysqli_fetch_array($sql1)) {
                $dispatch_id = $row1['dispatch_id'];
                $freight_amt = $row1['amt'];
                $freight_rate = $row1['rate'];
                $sql = mysqli_query($connection, "Select * from  dispatch_entry where dispatch_id=$dispatch_id && is_receive=1");
                while ($row = mysqli_fetch_array($sql)) {
                    $vehicle_no = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id='$row[vehicle_id]'");
                    $destination = $cmn->getvalfield($connection, "m_place", "place_name", "place_id ='$row[destination_id]'");
                    $owner_name = $cmn->getvalfield($connection, "m_vehicle_owner", "owner_name", "owner_id ='$row[owner_id]'");
                    $paid_to = $row['paid_to'];
                    $comp_rate = $row['comp_rate'];
                    $own_rate = $row['own_rate'];
                    $rec_wt = $row['rec_wt'];
                    $wt_mt = $row['wt_mt'];
                    $frt_debit = $row['frt_debit'];
                    $qty = $row['qty'];
                    $recqty = $row['rec_qty'];
                    $sortqty = $qty - $recqty;
                    if ($paid_to == 'Truck Owner') {


                        $diesel_adv_amt = $row['diesel_adv_amt'];
                        $cash_adv = $row['cash_adv'];
                        $other_cash_adv = $row['other_cash_adv'];
                        $consignor_cash_adv = $row['consignor_cash_adv'];
                        $consignee_cash_adv = $row['consignee_cash_adv'];
                        $deduct = $row['deduct'];
                        $commision = $comp_rate - $own_rate;
                        $sort_wt = $wt_mt - $rec_wt;
                        $sortamt = $sort_wt * $own_rate;
                    }
                    if ($paid_to != 'Truck Owner' && $paid_to == 'Agent' || $paid_to == 'Consignee') {

                        $diesel_adv_amt = 0;
                        $cash_adv = 0;
                        $deduct = 0;
                        $other_cash_adv = 0;
                        $consignor_cash_adv = 0;
                        $consignee_cash_adv = 0;
                        $sortamt = 0;
                        $commision = 0;
                    }


        ?>
                    <tr style="background-color:#87CEEB;">
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $row['di_no']; ?></td>
                        <td><?php echo dateformatindia($row['bilty_date']); ?></td>
                        <td><?php echo $owner_name; ?></td>
                        <td><?php echo $vehicle_no; ?></td>
                        <td><?php echo $destination; ?></td>
                        <td><?php echo $wt_mt; ?></td>
                        <td><?php echo $rec_wt; ?></td>
                        <td><?php echo $comp_rate; ?></td>
                        <td><?php echo $own_rate; ?></td>
                        <td><?php echo $paid_to; ?>
                            <input type="hidden" name="paid_to" id="paid_to<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $paid_to; ?>">
                        </td>
                        <td><?php echo $commision; ?>
                            <input type="hidden" name="commision" id="commision<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $commision; ?>">
                        </td>
                        <td><?php echo $freight_rate; ?>
                            <input type="hidden" name="freight_rate" id="freight_rate<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $freight_rate; ?>">
                        </td>
                        <td><?php echo $freight_amt; ?>
                            <input type="hidden" name="freight_amt" id="freight_amt<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $freight_amt; ?>">
                        </td>
                        <td><?php echo $frt_debit; ?>
                            <input type="hidden" name="frt_debit" id="frt_debit<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $frt_debit; ?>">
                        </td>
                        <td>
                            <input type="text" name="bilty_commision" id="bilty_commision<?php echo $dispatch_id; ?>" placeholder="Commision" class="form-control" style="width: 70px;" onchange="gettotalamt(<?php echo $dispatch_id; ?>);">
                        </td>
                        <td>
                            <input type="text" name="sortqty" id="sortqty<?php echo $dispatch_id; ?>" placeholder="Short Qty" class="form-control" style="width: 70px;" value="<?php echo $sortqty; ?>" readonly>
                        </td>
                        <td>
                            <input type="text" name="cmtrate" id="cmtrate<?php echo $dispatch_id; ?>" placeholder="Cement Rate" class="form-control" style="width: 70px;" onchange="getcmntamt(<?php echo $dispatch_id; ?>);" value="">
                        </td>
                        <td>
                            <input type="text" name="sortamt" id="sortamt<?php echo $dispatch_id; ?>" placeholder="Short Amt" class="form-control" style="width: 70px;" onchange="gettotalamt(<?php echo $dispatch_id; ?>);" value="<?php echo $sortamt; ?>">
                        </td>
                        <td>
                            <input type="text" name="tds" id="tds<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" onchange="gettotaltds(<?php echo $dispatch_id; ?>);gettotalamt(<?php echo $dispatch_id; ?>);">
                        </td>
                        <td>
                            <input type="text" name="tds_amt" id="tds_amt<?php echo $dispatch_id; ?>" placeholder="Amount" class="form-control" style="width: 70px;" onchange="gettotalamt(<?php echo $dispatch_id; ?>);">
                        </td>
                        <td>
                            <input type="text" name="bank_charge" id="bank_charge<?php echo $dispatch_id; ?>" placeholder="Amount" class="form-control" style="width: 70px;" onchange="gettotalamt(<?php echo $dispatch_id; ?>);">
                        </td>
                        <td>
                            <input type="text" name="rebidcharge" id="rebidcharge<?php echo $dispatch_id; ?>" placeholder="Amount" class="form-control" style="width: 70px;" onchange="gettotalamt(<?php echo $dispatch_id; ?>);">
                        </td>
                        <td><?php echo $diesel_adv_amt; ?>
                            <input type="hidden" name="diesel_adv_amt" id="diesel_adv_amt<?php echo $dispatch_id; ?>" placeholder=" " class="form-control" style="width: 70px;" value="<?php echo $diesel_adv_amt; ?>">
                        </td>

                        <td><?php echo $cash_adv; ?>
                            <input type="hidden" name="cash_adv" id="cash_adv<?php echo $dispatch_id; ?>" placeholder=" " class="form-control" style="width: 70px;" value="<?php echo $cash_adv; ?>">
                        </td>
                        <td><?php echo $other_cash_adv; ?>
                            <input type="hidden" name="other_cash_adv" id="other_cash_adv<?php echo $dispatch_id; ?>" placeholder=" " class="form-control" style="width: 70px;" value="<?php echo $other_cash_adv; ?>">
                        </td>
                        <td><?php echo $consignor_cash_adv; ?>
                            <input type="hidden" name="consignor_cash_adv" id="consignor_cash_adv<?php echo $dispatch_id; ?>" placeholder=" " class="form-control" style="width: 70px;" value="<?php echo $consignor_cash_adv; ?>">
                        </td>
                        <td><?php echo $deduct; ?>
                            <input type="hidden" name="deduct" id="deduct<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $deduct; ?>">
                        </td>
                        <td style="display:none;"><?php echo $consignee_cash_adv; ?>
                            <input type="hidden" name="consignee_cash_adv" id="consignee_cash_adv<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value="<?php echo $consignee_cash_adv; ?>">
                        </td>
                        <td> <input type="text" name="gstper" id="gstper<?php echo $dispatch_id; ?>" placeholder=" " class="form-control" style="width: 70px;" value="" onchange="getgstvalue();"></td>
                        <td> <input type="text" name="netamt" id="netamt<?php echo $dispatch_id; ?>" placeholder="" class="form-control" style="width: 70px;" value=""></td>
                        <td>
                            <input type="text" name="total_amt" id="total_amt<?php echo $dispatch_id; ?>" placeholder="Amount" class="form-control" style="width: 70px;">
                        </td>

                        <td><a type="submit" onclick="savemultiple(<?php echo $dispatch_id; ?>);" class="btn btn-primary">Update</a><br>
                            <span style="color:#F00;width: 70px;" id="msg<?php echo $dispatch_id; ?>"></span>
                        </td>
                        </td>
                    </tr>
        <?php
                    $arraycomission .= $dispatch_id . ",";
                }
            }
        } ?>


        <input type="hidden" class="formcent" id="sndata" value="<?php echo rtrim($arraycomission, ","); ?>" autocomplete="off" style="width: 70px;">
    </tbody>
</table>
</div>
<br> <br>
<div class="row">
    <div class="col-sm-12">
        <div class="form-actions">
            <center>
                <a type="submit" onclick="savebulkvid();" class="btn-lg btn-success">SAVE</a>

            </center>
        </div>
    </div>
</div>
</form>
</div>

<script>
    $(document).ready(function() {
        // Initialize Select2 on your select element
        $('#payee_name').select2({
            placeholder: "Select Payee",
            allowClear: true // Optional: allows the user to clear the selection
        });

        // Set the selected value if needed
        $('#payee_name').val('<?php echo $payee_name; ?>').trigger('change');
    });
</script>