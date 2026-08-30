<?php
error_reporting(0);
include("adminsession.php");
include("function/dispatch_function.php");
$tblname = "dispatch_entry";
$tblpkey = "dispatch_id";
$pagename = "all-dispatch-entry.php";
$modulename = "Dispatch Entry";
$crit = "";

if (isset($_GET['search'])) {
    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
} else {

    $fromdate = date("Y-m-01");
    $todate = date('Y-m-d');
}




if (isset($_GET['owner_id'])) {
    $owner_id  = trim(addslashes($_GET['owner_id']));
} else
    $owner_id  = '';

if (isset($_GET['vehicle_id'])) {
    $vehicle_id = trim(addslashes($_GET['vehicle_id']));
} else
    $vehicle_id = '';



if ($fromdate != '' && $todate != '') {
    $crit .= "where bilty_date BETWEEN  '$fromdate' and  '$todate' ";
    
}

if ($vehicle_id != '') {
    $crit .= " and vehicle_id='$vehicle_id'";
}

if ($owner_id  != '') {
    $crit .= " and brand_id='$owner_id '";
}

?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- Apple devices fullscreen -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Apple devices fullscreen -->
    <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <title> ALL DISPATCH :: CHAARUVI INFOTECH PVT. LTD.</title>
    <?php include("inc/top-files.php"); ?>
</head>

<body>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog" style="width:480px;padding-top: 225px;">


            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
                    <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
                    <center>
                        <h4 class="modal-title"><b>Check Otp<b></h4>
                    </center>
                </div>
                <div class="modal-body" style="padding-top:30px;">
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Enter 4 Digit Code</label>
                        <div class="col-sm-6">

                            <input type="text" name="otp" id="otp" class="form-control" placeholder="" required>
                            <input type="hidden" id="ref_id" value="">
                        </div>
                    </div>
                    <br>
                    <input type="hidden" id="type" value="">

                    <div class="modal-footer">
                        <center>
                            <button class="btn btn-primary" onClick="checkdispatchotp();" tabindex="12">Check</button>
                            <a><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a>
                        </center>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <?php include("inc/model.php"); ?>
    <?php include("inc/top-header.php"); ?>
    <div class="container-fluid nav-hidden" id="content">
        <?php include("inc/left-menu.php"); ?>
        <div id="main">
            <div class="container-fluid">
                <?php include("inc/breadcrumbs.php"); ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box box-bordered box-color satblue">
                            <div class="box-title">
                                <h3>
                                    <i class="fa fa-list"></i>Dispatch Filter
                                </h3>
                            </div>
                            <div class="box-content nopadding">
                                <form action="#" method="GET" class='form-horizontal form-column form-bordered'>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="textfield" class="control-label col-sm-4">From Date <span style="color:red">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="date" name="fromdate" id="fromdate" placeholder="Text input" class="form-control" value="<?php echo $fromdate; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="textfield" class="control-label col-sm-4">To Date <span style="color: red">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="date" name="todate" id="todate" placeholder="Text input" class="form-control" value="<?php echo $todate; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="textfield" class="control-label col-sm-4">Owner Name <span style="color: red">*</span></label>
                                                <div class="col-sm-8">
                                                    <select name="owner_id" id="owner_id" class='select2-me' style="width:100%;" required>
                                                        <option value="">Select</option>
                                                        <?php $sql = mysqli_query($connection, "Select * from  m_vehicle_owner  order by owner_id");
                                                        while ($row = mysqli_fetch_array($sql)) { ?>
                                                            <option value="<?php echo $row['owner_id']; ?>"><?php echo $row['owner_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <script>
                                                        document.getElementById('owner_id').value = '<?php echo $owner_id ; ?>';
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="textfield" class="control-label col-sm-4">Truck No.</label>
                                                <div class="col-sm-8">
                                                    <select name="vehicle_id" id="vehicle_id" class='select2-me' style="width:100%;">
                                                        <option value=""> Select </option>
                                                        <?php $sql = mysqli_query($connection, "Select * from  m_vehicle  order by vehicle_id");
                                                        while ($row = mysqli_fetch_array($sql)) { ?>
                                                            <option value="<?php echo $row['vehicle_id']; ?>"><?php echo $row['vehicle_no']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <script>
                                                        document.getElementById('vehicle_id').value = '<?php echo $vehicle_id; ?>';
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-actions" style="border-top:none; text-align:center;">
                                                <input type="submit" name="search" class="btn btn-primary" value="Search">
                                                <a type="button" href="<?php echo $pagename; ?>" class="btn btn-red">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="box box-color box-bordered red">
                                <div class="box-title">
                                    <h3> <i class="fa fa-table"></i>
                                        Dispatch Filter List
                                    </h3>
                                    <a href="dispatch-process.php" class="btn btn-info" style="float: right">Click Here For New Entry
                                        <i class="fa fa-object-group"></i>
                                    </a> &nbsp;
                                    <a href="pdf/pdf_dispatch_entry.php?fromdate=<?php echo $fromdate ?>&todate=<?php echo $todate ?>&vehicle_id=<?php echo $vehicle_id ?>&item_id=<?php echo $item_id ?>&brand_id=<?php echo $owner_id  ?>&consignee_id=<?php echo $consignee_id ?>" class="btn" style="float: right" target="_blank">Pdf
                                        <i class="fa fa-file-pdf-o"></i>
                                    </a> &nbsp;
                                    <a href="excel/excel_dispatch_entry.php?fromdate=<?php echo $fromdate ?>&todate=<?php echo $todate ?>&vehicle_id=<?php echo $vehicle_id ?>&item_id=<?php echo $item_id ?>&brand_id=<?php echo $owner_id  ?>&consignee_id=<?php echo $consignee_id ?>" class="btn btn-info" style="float: right">Excel
                                        <i class="fa fa-file-excel-o"></i>
                                    </a>
                                    <!--<a onclick="getwhatsapp1('<?php echo $fromdate; ?>','<?php echo $todate; ?>','<?php echo $vehicle_id; ?>','<?php echo $item_id; ?>','<?php echo $owner_id ; ?>','<?php echo $consignee_id; ?>');" ><img src="img/whatsapp.png" style="width:30px;height:30px;">-->
                                    <!--          </a>-->
                                    <!--          <span style="color:#F00;width: 70px;font-weight:bold;padding-top: 5px;" id="msg1"></span>-->
                                </div>
                                <div class="box-content nopadding" style="overflow:scroll;">
                                    <table class="table table-nomargin  table-bordered dataTable dataTable-colvis">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>DI No.</th>
                                                <!--<th>Bilty No.</th>-->
                                                <th class='hidden-350'>Bilty Date</th>
                                                <th>GR No.</th>
                                                <th>Consignee</th>
                                                <th class='hidden-1024'>Truck No.</th>
                                                <th>Owner Name</th>
                                                <th>Destination</th>
                                                <th>Item</th>
                                                <th>Brand</th>
                                                <th>Weight/MT</th>
                                                <!--<th>Qty (Bags)</th>-->
                                                <th>Company Rate</th>
                                                <th>Own Rate</th>
                                                <th>Freight Amt</th>
                                                <th>User Name</th>
                                                <th>Bilty Scan</th>

                                                <th class='hidden-480'>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $sn = 1;
                                           
                                            $sql = mysqli_query($connection, "Select vehicle_id,sum(freight_amt),diesel_adv_amt,cash_adv,other_cash_adv,consignor_cash_adv from dispatch_entry  join   consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id order by $tblpkey desc");
                                            while ($row = mysqli_fetch_array($sql)) {
                                                
                                            ?>
                                                <tr style="<?php echo $backgroundColor; ?>">
                                                    <!--<tr <?php if ($row['checkbox'] == '1') { ?> style="background-color:#ADD8E6;" <?php } ?>>-->
                                                    <td><?php echo $sn++; ?></td>
                                                    <td><?php echo $row['di_no']; ?></td>
                                                    <!--<td><?php echo $row['bilty_no']; ?></td>-->
                                                    <td><?php echo dateformatindia($row['bilty_date']); ?></td>
                                                    <td><?php echo $row['gr_no']; ?></td>
                                                   
                                                    <td><?php echo $row['wt_mt']; ?></td>
                                                    <!--<td><?php echo $row['qty']; ?></td>-->
                                                    <td><?php echo $row['comp_rate']; ?></td>
                                                    <td><?php echo $row['own_rate']; ?></td>
                                                    <td><?php echo $famt; ?></td>
                                                    <td><?php echo $user_name; ?></td>
                                                    <td><b><a href="upload/bilty/<?php echo $row['bilty_scan'] ?>" class="text-danger" target="_blank" download>Download</a></b></td>
                                                    <td style="display:flex;justify-content:space-between;align-items:center;">
                                                        <a href="pdf/pdf_dispatch_printA4.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-warning" rel="tooltip" title="Builty A4" target="_blank">
                                                            <i class="fa fa-print">A4</i>
                                                            <a href="pdf/pdf_dispatch_printA5.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-info" rel="tooltip" title="Builty A5" style="margin-left: 3px;" target="_blank">
                                                                <i class="fa fa-print">A5</i>
                                                            </a>
                                                            <!--    <?php if ($is_voucher == '0') { ?>-->
                                                            <!--        <a href="dispatch-process.php?editid=<?php echo $row['dispatch_id']; ?>" class="btn btn-inverse" rel="tooltip" title="Edit">-->
                                                            <!--   <i class="fa fa-edit"></i>-->
                                                            <!--   </a>-->
                                                            <!--<?php } ?>-->
                                                            <?php if ($user_type == 'admin') { ?>
                                                                <a onClick="edit('<?php echo $row['dispatch_id']; ?>','edit');" class="btn btn-inverse" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                                                <!-- <a href="dispatch-process.php?editid=<?php echo $row['dispatch_id']; ?>" class="btn btn-inverse" rel="tooltip" title="Edit">
                                          <i class="fa fa-edit"></i>
                                          </a> -->
                                                                <a onClick="edit('<?php echo $row['dispatch_id']; ?>','del');" class="btn btn-danger" rel="tooltip" title="Delete">
                                                                    <i class="fa fa-times"></i>
                                                                </a>

                                                                <!-- <a href="<?php echo $pagename ?>" onClick="funDel(<?php echo $row['dispatch_id']; ?>)" class="btn btn-danger" rel="tooltip" title="Delete">
                                          <i class="fa fa-times"></i>
                                          </a> -->
                                                            <?php } ?>
                                                            <a onclick="getwhatsapp('<?php echo $row['dispatch_id']; ?>','<?php echo $row['owner_id']; ?>','<?php echo $owner_name; ?>','<?php echo $mobile; ?>');"><img src="img/whatsapp.png" style="width:30px;height:30px;">
                                                            </a>
                                                            <span style="color:#F00;width: 70px;font-weight:bold;padding-top: 5px;" id="msg<?php echo $row['dispatch_id']; ?>"></span>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        <tfoot>
                                            <tr>

                                                <td colspan="10" style="text-align:center;">TOTAL QTY</td>
                                                <td><?php echo $tqty; ?></td>
                                                <td colspan="2" style="text-align:center;">TOTAL Amount</td>
                                                <td><?php echo $tfamt; ?></td>
                                            </tr>
                                        </tfoot>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</body>

</html>