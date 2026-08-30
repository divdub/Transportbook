<?php
error_reporting(0);
include("adminsession.php");
include("function/payment_function.php");

if (isset($_GET['editid'])) {
	$voucher_id = $_GET['editid'];
} else
	$voucher_id = '';
// echo $voucher_id; die;;

// $owner_name = $cmn->getvalfield($connection, "m_vehicle_owner", "voucher_date", "voucher_id ='$voucher_id'");
// $mobile = $cmn->getvalfield($connection, "m_vehicle_owner", "mobileno1", "owner_id ='$owner_id'");
// $manual_msg = $cmn->getvalfield($connection, "ws_setting", "automatic_msg", "1=1");

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

	<title> ALL VOUCHER :: CHAARUVI INFOTECH PVT. LTD.</title>

	<?php include("inc/top-files.php"); ?>
</head>

<body>



	<?php include("inc/model.php"); ?>

	<?php include("inc/top-header.php"); ?>


	<div class="container-fluid nav-hidden" id="content">
		<?php include("inc/left-menu.php"); ?>



		<div id="main">
			<div class="container-fluid">

				<?php include("inc/breadcrumbs.php"); ?>


				


							<div class="box box-color box-bordered satblue">
								<div class="box-title">
									<h3> <i class="fa fa-table"></i>
									Edit Voucher List</h3>


									<!-- 	<button class="btn btn-warning" style="float: right">Click Hear For All Entry
											<i class="fa fa-object-group"></i>
										</button> &nbsp;
				 -->




									

								</div>
								<div class="box-content nopadding" style="overflow:scroll;">
								

<div id="mulrectableid">


    <div>
    <?php
											$sn = 1;
											// echo "Select * from  payment  where consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id  && voucher_id='$voucher_id' ";
				$sql = mysqli_query($connection, "Select * from  payment  where consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id  && voucher_id='$voucher_id'  ");
										$row = mysqli_fetch_array($sql);?>
        <form action="#" method="POST" class='form-horizontal form-column form-bordered'>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="textfield" class="control-label col-sm-4">Voucher Date<span style="color: red">*</span></label>
                        <div class="col-sm-8">
                        <input type="hidden" name="voucher_id" id="voucher_id" placeholder="Text input" class="form-control" value="<?php echo $voucher_id; ?>" required>

                            <input type="date" name="voucher_date" id="voucher_date" placeholder="Text input" class="form-control" value="<?php echo $row['voucher_date']; ?>" required>
                        </div>
                    </div>

                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="textfield" class="control-label col-sm-4">Paid To<span style="color: red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="payee_name" id="payee_name" placeholder="Enter Name" class="form-control" value="<?php echo $row['payee_name']; ?>" required>
                        </div>
                    </div>

                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="textfield" class="control-label col-sm-4">Account No.</label>
                        <div class="col-sm-8">
                            <input type="text" name="acc_no" id="acc_no" placeholder="Enter Name" class="form-control" value="<?php echo $row['acc_no']; ?>" required>
                        </div>
                    </div>

                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="textfield" class="control-label col-sm-4">Ifsc Code</label>
                        <div class="col-sm-8">
                            <input type="text" name="ifsc_code" id="ifsc_code" placeholder="Enter Name" class="form-control" value="<?php echo $row['ifsc_code']; ?>" required>
                        </div>
                    </div>

                </div>
                 <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="textfield" class="control-label col-sm-4">Pan No.</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="panno" id="panno" placeholder="Enter Name" class="form-control" value="<?php echo $row['panno']; ?>" required>
                                                </div>
                                            </div>
                                        
                                        </div>    
                                       
                

            </div>
            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="textfield" class="control-label col-sm-4">Remark</label>
                        <div class="col-sm-8">
                            <input type="text" name="remark" id="remark" placeholder="Enter Remark" class="form-control" value="<?php echo $row['remark']; ?>" required>
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
                                    document.getElementById('bill_type').value = '<?php echo $row['bill_type']; ?>';
                                </script>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2" id="th1" style="display:none;">
                    <div class="form-group">
                        <label for="textfield" class="control-label col-sm-4">GST Type </label>
                        <div class="col-sm-8">
                            <select name="gst_type" id="gst_type" class="form-control">
                                <option value="">Select</option>

                                <option value="GST">GST</option>
                                <option value="IGST">IGST</option>
                                <script>
                                    document.getElementById('gst_type').value = '<?php echo $row['gst_type']; ?>';
                                </script>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3" id="th2" style="display:none;">
                    <div class="form-group">
                        <label for="textfield" class="control-label col-sm-4">GST %</label>
                        <div class="col-sm-8">
                            <select name="gst" id="gst" class='form-control' onchange="GstPaste1(this.value);">
                                <option value="">Select</option>

                                <option value="5">5% </option>
                                <option value="12">12%</option>
                                <option value="18">18%</option>
                                <option value="28">28%</option>
                                <script>
                                    document.getElementById('gstper').value = '<?php echo $row['gst']; ?>';
                                </script>
                            </select>
                        </div>
                    </div>
                </div>
<?php  ?>





            </div>


            <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
                <thead style="position: sticky;
                              top: 0;">
                    <tr>
                        <th>Sno</th>
                        <th>GR No.</th>
                        <!-- <th>Bilty No.</th> -->
                        <th>Bilty Date</th>
                        <th>Voucher Name</th>
                        <th>Truck No.</th>
                        <th>Destination </th>
                        <th>Wt</th>
                        <th>Rec Wt</th>
                        <th>Comp Rate</th>
                        <th>Own Rate</th>
                        <th>Adv. Paid to</th>
                        <th>Comm.</th>
                        <th>Frt Rate</th>
                        <th>Frt Amt</th>
                        <th>Bilty Comm.</th>
                        <th>Bank Charges</th>
                        <th>Rebidding Charges</th>
                        <th>Shrt Amt</th>

                        <th>Tds %</th>
                        <th>Tds Amt</th>
                        <th>Die Adv. </th>
                        <th>Cash Adv</th>
                        <th>GPS Amt</th>
                        
                        <th>GST %</th>
                        <th>Amt Paid to</th>
                        <!-- <th>Remark</th> -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody> 
                <?php
											$sn = 1;
											// echo "Select * from  payment  where consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id  && voucher_id='$voucher_id' ";
				$sql = mysqli_query($connection, "Select * from  payment  where consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id  && voucher_id='$voucher_id'  ");
											while ($row = mysqli_fetch_array($sql)) { ?>
                <?php   
                 
                $payment_id = $row['payment_id'];
                $dispatch_id = $row['dispatch_id'];
              $sql1 = mysqli_query($connection,"Select * from  dispatch_entry  where dispatch_id=$dispatch_id order by dispatch_id desc");
                        $row1 = mysqli_fetch_array($sql1);
                            $vehicle_no = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id=$row1[vehicle_id]");
                            $owner_name = $cmn->getvalfield($connection, "m_vehicle_owner", "owner_name", "owner_id=$row1[owner_id]");
                            $wt_mt = $row1['wt_mt'];
                            $rec_wt = $row1['rec_wt'];
                            $sortwt = $wt_mt - $rec_wt;
                            $own_rate = $row1['own_rate'];
                            $comp_rate = $row1['comp_rate'];
                          
                            $diesel_adv_amt = $row1['diesel_adv_amt'];
                            $cash_adv = $row1['cash_adv'];
                            $other_cash_adv = $row1['other_cash_adv'];
                            $consignor_cash_adv = $row1['consignor_cash_adv'];
                            $consignee_cash_adv = $row1['consignee_cash_adv'];
                            $commision = $comp_rate - $own_rate;
                            $sort_wt = $wt_mt - $rec_wt;
                            $sortamt = $sort_wt * $own_rate;
                           
                            $destination = $cmn->getvalfield($connection, "m_place", "place_name", "place_id ='$row1[destination_id]'"); ?>

                    <!-- <input type="hidden" name="payment_id" id="payment_id" placeholder="Receive Wt" class="form-control" style="width: 70px;" value="<?php echo $payment_id; ?>"> -->
                    <!-- <input type="hidden" name="catname" id="catname" placeholder="Receive Wt" class="form-control" style="width: 70px;" value="<?php echo $catname; ?>"> -->
                       <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $row1['gr_no']; ?></td>
                                    <td><?php echo dateformatindia($row1['bilty_date']); ?></td>
                                    <td><?php echo $owner_name; ?></td>
                                    <td><?php echo $vehicle_no; ?></td>
                                    <td><?php echo $destination; ?></td>
                                    <td><?php echo $wt_mt; ?></td>
                                    <td><?php echo $rec_wt; ?></td>
                                    <td><?php echo $comp_rate; ?></td>
                                    <td><?php echo $own_rate; ?></td>
                                    <td><?php echo $row['paid_to']; ?>
                                    </td>
                                    <td><?php echo $commision; ?>
                                    </td>
                                    <td><?php echo $row['freight_rate']; ?>
                                    </td>
                                    <td><?php echo $row['freight_amt']; ?>
                              <input type="hidden" name="freight_amt" id="freight_amt<?php echo $payment_id; ?>" placeholder="Receive Wt" class="form-control" style="width: 70px;" value="<?php echo $row['freight_amt']; ?>">

                                    </td>
                                    <td>
                                    <input type="text" name="bilty_commision" value="<?php echo $row['bilty_commision']; ?>" id="bilty_commision<?php echo $payment_id; ?>" placeholder="Commision" class="form-control" style="width: 70px;" onchange="getallvalue(<?php echo $payment_id; ?>);">
                                    </td>
                                    <td>
                                    <input type="text" name="bank_charge" value="<?php echo $row['bank_charge']; ?>" id="bank_charge<?php echo $payment_id; ?>" placeholder="" class="form-control" style="width: 70px;" onchange="getallvalue(<?php echo $payment_id; ?>);">
                                    </td>
                                    <td>
                                    <input type="text" name="rebidcharge" value="<?php echo $row['rebidcharge']; ?>" id="rebidcharge<?php echo $payment_id; ?>" placeholder="" class="form-control" style="width: 70px;" onchange="getallvalue(<?php echo $payment_id; ?>);">
                                    </td>
                                    <td>
                                        <input type="text" name="sortamt" id="sortamt<?php echo $payment_id; ?>" placeholder="Short Amt" class="form-control" style="width: 70px;" value="<?php echo $sortamt; ?>" onchange="getallvalue(<?php echo $payment_id; ?>);">
                                    </td>
                                    <td>
                                        <input type="text" name="tds" id="tds<?php echo $payment_id; ?>"  value="<?php echo $row['tds']; ?>"  placeholder="" class="form-control" style="width: 70px;" onchange="getallvalue(<?php echo $payment_id; ?>);">
                                    </td>
                                    <td>
                                        <input type="text" name="tds_amt" id="tds_amt<?php echo $payment_id; ?>" placeholder="Amount" class="form-control" style="width: 70px;" onchange="getallvalue(<?php echo $payment_id; ?>);"  value="<?php echo $row['tds_amt']; ?>">
                                    </td>
                                    <td><?php echo $diesel_adv_amt; ?>
                   <input type="hidden" name="diesel_adv_amt" id="diesel_adv_amt<?php echo $payment_id; ?>" placeholder="Receive Wt" class="form-control" style="width: 70px;" value="<?php echo $diesel_adv_amt; ?>">

                                    </td>
                                    <td><?php echo $cash_adv; ?>
                                    <input type="hidden" name="cash_adv" id="cash_adv<?php echo $payment_id; ?>" placeholder="Receive Wt" class="form-control" style="width: 70px;" value="<?php echo $cash_adv; ?>">

                                    </td>
                                    <td><?php echo $other_cash_adv; ?>
          <input type="hidden" name="other_cash_adv" id="other_cash_adv<?php echo $payment_id; ?>" placeholder="Receive Wt" class="form-control" style="width: 70px;" value="<?php echo $other_cash_adv; ?>">

                                    </td>
                                
                                    <td> <input type="text" name="gstper" id="gstper<?php echo $payment_id; ?>" placeholder=" " class="form-control" style="width: 70px;" value="<?php echo $row['gstper']; ?>" onchange="getallvalue(<?php echo $payment_id; ?>);"></td>
                                    <td>
                                        <input type="text" name="total_amt" id="total_amt<?php echo $payment_id; ?>" placeholder="Amount" class="form-control" style="width: 70px;" value="<?php echo $row['amt_paid_to']; ?>">
                                    </td>
                                    
                                    <td><a type="submit" onclick="editmultiple(<?php echo $payment_id; ?>);" class="btn btn-primary">Update</a><br>
                                        <span style="color:#F00;width: 70px;" id="msg<?php echo $payment_id; ?>"></span>
                                    </td>
                                    </td>
                                </tr>
                   


                    <?php
                      $arraycomission .= $payment_id . ",";
                                            }
    ?> 
                        <input type="hidden" class="formcent" id="sndata" value="<?php echo rtrim($arraycomission, ","); ?>" autocomplete="off" style="width: 70px;">


</tbody>
            </table>

    </div>
  
    <br> <br>
   

    <div class="row">
        <div class="col-sm-12">
            <div class="form-actions">
                <center>

                    <a type="submit" onclick="editbulkvid();" class="btn-lg btn-success">SAVE</a>

                </center>
            </div>
        </div>
    </div>
    </form>
</div>

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