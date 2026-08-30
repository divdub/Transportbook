<?php

error_reporting(0);
include("adminsession.php");
include("function/bill_function.php");
$tblname = "diesel_advpayment";
$tblpkey = "dadvpayid";
$pagename = "diesel_advpayment.php";
$modulename = "Manual Bill Payment";


?>

<div class="tab-pane active" id="main" style="margin-left:0">
    <div class="modal fade" id="myModaladv" role="dialog">
        <div class="modal-dialog" style="width:480px;padding-top: 225px;">


            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
                    <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
                    <center>
                        <h4 class="modal-title"><b>Edit<b></h4>
                    </center>
                </div>
                <div class="modal-body" style="padding-top:30px;">
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">PUMP NAME</label>
                        <div class="col-sm-6">
                            <select name="Epump_id" id="Epump_id" class='select2-me' style="width:100%;" disabled>
                                <option value=" "> Select</option>
                                <?php $sql = mysqli_query($connection, "Select * from  m_petrol_pump  order by pump_id ");
                                while ($row = mysqli_fetch_array($sql)) { ?>
                                    <option value="<?php echo $row['pump_id']; ?>"><?php echo $row['pump_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <br>

                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Adv NO.</label>
                        <div class="col-sm-6">
                            <input type="text" name="Eadv_no" id="Eadv_no" class="form-control" placeholder="" readonly>
                        </div>
                    </div>
                    <br>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Adv Date</label>
                        <div class="col-sm-6">
                            <input type="date" name="Eadv_date" id="Eadv_date" class="form-control" placeholder="">
                        </div>
                    </div>
                    <br>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Adv Amt</label>
                        <div class="col-sm-6">
                            <input type="text" name="Eadv_amt" id="Eadv_amt" class="form-control" placeholder="">
                            <input type="hidden" name="Eadvpayid" id="Eadvpayid" class="form-control" placeholder="">
                        </div>
                    </div>
                    <br>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Payment Mode</label>
                        <div class="col-sm-6">
                            <select name="Eapay_mode" id="Eapay_mode" class='select2-me' style="width:100%;">
                                <option value="">Select</option>
                                <option value="CASH">CASH</option>
                                <option value="NEFT">NEFT</option>
                                <option value="CHEQUE">CHEQUE</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Remarks</label>
                        <div class="col-sm-6">
                            <input type="text" name="Eremarks" id="Eremarks" class="form-control" placeholder="">
                        </div>
                    </div>
                    <br>


                    <div class="modal-footer">
                        <center>
                            <button class="btn btn-primary" onClick="save_editadv();" tabindex="12"> Save</button>
                            <a href="<?php echo $pagename; ?>"><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a>
                        </center>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-bordered box-color">
                <div class="box-title">
                    <!-- <span style="color: white; font-weight: bold">Success! Data Insert Successfully. <i class="fa fa-check-circle"></i></span>
                     <span style="color: white; font-weight: bold">Warning! The value you entered is already in the list. <i class="fa fa-clone"></i></span>
                     <span style="color: white; font-weight: bold">Warning! Data not inserted kindly fill mandatory field. <i class="fa fa-warning"></i></span>	 -->
                    <h3>
                        <i class="fa fa-list"></i>
                        <h3 class="tbhead">Diesel Advance Payment </h3>
                </div>
                <div class="box-content nopadding">
                    <form action="#" method="POST" class='form-horizontal form-column form-bordered'>

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="textfield" class="control-label col-sm-4"> Pump Name <span style="color: red"></span> </label>
                                    <div class="col-sm-8">
                                        <select name="ppump_id" id="ppump_id" class='select2-me' style="width:100%;" required onchange="getadvno(this.value)" ;>
                                            <option value="">Select</option>
                                            <?php $sql = mysqli_query($connection, "Select * from  m_petrol_pump  order by pump_id");
                                            while ($row = mysqli_fetch_array($sql)) { ?>
                                                <option value="<?php echo $row['pump_id']; ?>"><?php echo $row['pump_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <script>
                                            document.getElementById('ppump_id').value = '<?php echo $ppump_id; ?>';
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="textfield" class="control-label col-sm-4">Adv No.</label>
                                    <div class="col-sm-8">
                                        <!--<input type="text" name="invoiceid" id="invoiceid" placeholder="Enter Invoice Number" class="form-control">-->
                                        <input type="text" name="adv_no" id="adv_nooo" placeholder="Enter Advance Number" class="form-control"  readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="textfield" class="control-label col-sm-4">Advance Date <span style="color: red">*</span></label>
                                    <div class="col-sm-8">
                                        <!-- <input type="date" name="dbill_date" id="dbill_date" placeholder="Enter Bill Date" class="form-control" readonly> -->
                                        <input type="date" name="adv_date" id="adv_date" placeholder="Enter Advance Date" class="form-control">
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="textfield" class="control-label col-sm-4"> Advance Amount <span style="color: red"></span> </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="adv_amt" id="adv_amt" placeholder="Enter Amount" class="form-control">


                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="textfield" class="control-label col-sm-4"> Payment Mode </label>
                                    <div class="col-sm-8">
                                        <select name="apay_mode" id="apay_mode" class='select2-me' style="width:100%;">
                                            <option value="">Select</option>
                                            <option value="CASH">CASH</option>
                                            <option value="NEFT">NEFT</option>
                                            <option value="CHEQUE">CHEQUE</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="textfield" class="control-label col-sm-4"> Remarks </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="aremarks" id="aremarks" placeholder="Enter Remarks" class="form-control">
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-actions">
                                    <center>
                                        <a type="submit" onclick="dieseladvpayment();" class="btn btn-primary">Save</a>
                                        <a type="button" onclick="jQuery('#diesel_adv').click();" class="btn btn-red">Cancel</a>

                                    </center>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box box-color box-bordered red">
                    <div class="box-title">
                        <h3> <i class="fa fa-table"></i>
                            Diesel Advance Payment Details
                        </h3>
                        <!-- <a href="all-dispatch-entry.php" class="btn btn-warning" style="float: right">Click Hear For All Entry -->
                        <!-- <i class="fa fa-object-group"></i> -->
                        <!-- </a> &nbsp; -->
                        <!-- <a href="all-dispatch-entry.php" style="text-align: right" target="_blank">All Record</a> -->
                        <!-- <button class="btn" style="float: right">Export
                        <i class="fa fa-file-pdf-o"></i>
                         </button> &nbsp; -->
                        <!-- <button class="btn btn-warning" style="float: right">Export -->
                        <!-- <i class="fa fa-file-excel-o"></i> -->
                        <!-- </button> 		 -->
                    </div>
                    <div class="box-content nopadding">
                        <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
                            <thead>
                                <tr>
                                    <th>S.No</th>

                                    <th>Pump Name </th>
                                    <th>Adv No.</th>
                                    <th>Advance Date</th>
                                    <th>Advance Amount</th>
                                    <th>Payment Mode</th>
                                    <th>Remarks</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sn = 1;
                                // echo "Select * from  $tblname  order by $tblpkey desc limit 10" ;
                                $sql = mysqli_query($connection, "Select * from  $tblname where consignorid=$consignorid && sessionid=$session_id order by $tblpkey desc limit 10");
                                while ($row = mysqli_fetch_array($sql)) {
                                    $pump_name = $cmn->getvalfield($connection, "m_petrol_pump", "pump_name", "pump_id='$row[pump_id]'");



                                ?>

                                    <tr>
                                        <td><?php echo $sn++; ?></td>

                                        <td><?php echo $pump_name; ?></td>
                                        <td class='hidden-350'><?php echo $row['adv_no']; ?></td>
                                        <td><?php echo dateformatindia($row['adv_date']); ?></td>

                                        <td class='hidden-350'><?php echo $row['adv_amt']; ?></td>
                                        <td class='hidden-350'><?php echo $row['pay_mode']; ?></td>
                                        <td class='hidden-350'><?php echo $row['remark']; ?></td>



                                        <td>
                                            <?php if ($user_type == 'admin') { ?>
                                                 <a href= "pdf/pdf_diesel_advpayment.php?dadvpayid=<?php echo $row['dadvpayid'];?>" class="btn btn-success" target="_blank">Print</a>
                                                <a onClick="editadv('<?php echo $row['pump_id']; ?>','<?php echo $row['adv_amt']; ?>','<?php echo $row['adv_date']; ?>','<?php echo $row['adv_no']; ?>','<?php echo $row['dadvpayid']; ?>','<?php echo $row['pay_mode']; ?>','<?php echo $row['remark']; ?>')" class="btn btn-inverse" rel="tooltip" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a onClick="funDel2('<?php echo $row['dadvpayid']; ?>')" class="btn btn-danger" rel="tooltip" title="Delete"> <i class="fa fa-times"></i></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br />
        </div>
        <!-- <script type="text/javascript">
		function funDel2(id) {
          
			var tablename = 'diesel_advpayment';
			var tableid = 'dadvpayid';
			if (confirm("Do You want to Delete this record ?")) {
				// alert(tableid);
				jQuery.ajax({
					type: 'POST',
					url: 'ajax/delete_master.php',
					data: 'id=' + id + '&tablename=' + tablename + '&tableid=' + tableid,
					dataType: 'html',
					success: function(data) {
						showdrecord();
						gettotal();
					}
				}); //ajax close
			}
		}
	</script> -->