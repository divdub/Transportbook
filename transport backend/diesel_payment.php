<?php
error_reporting(0);
include("adminsession.php");
include("function/bill_function.php");
$tblname = "diesel_pay";
$tblpkey = "dpayid";
$pagename = "manual_bill_payment.php";
$modulename = "Manual Bill Payment";

?>

<div class="tab-pane active" id="main" style="margin-left:0">
   <div class="modal fade" id="myModal8" role="dialog">
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
                  <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Bill NO.</label>
                  <div class="col-sm-6">
                     <select name="Edbillid" id="Edbillid" class='select2-me' style="width:100%;" disabled>
                        <option value=" "> Select</option>
                        <?php $sql = mysqli_query($connection, "Select * from  dieselbill  order by dbillid ");
                        while ($row = mysqli_fetch_array($sql)) { ?>
                           <option value="<?php echo $row['dbillid']; ?>"><?php echo $row['dbillno']; ?></option>
                        <?php } ?>
                     </select>
                  </div>
               </div>
               <br>
               <div class="row mb-3">
                  <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Bill Date</label>
                  <div class="col-sm-6">
                     <input type="date" name="Edbill_date" id="Edbill_date" class="form-control" placeholder="" readonly>
                  </div>
               </div>
               <br>
               <div class="row mb-3">
                  <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Bill Amt</label>
                  <div class="col-sm-6">
                     <input type="text" name="Ediesel_adv_amt" id="Ediesel_adv_amt" class="form-control" placeholder="" readonly>
                  </div>
               </div>
               <br>
               <div class="row mb-3">
                  <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Advance No</label>
                  <div class="col-sm-6">
                      <select name="Eadv_id" id="Eadv_id" class='select2-me' style="width:100%;" disabled>
                        <option value=" "> Select</option>
                        <?php $sql = mysqli_query($connection, "Select * from   diesel_advpayment  order by dadvpayid ");
                        while ($row = mysqli_fetch_array($sql)) { ?>
                           <option value="<?php echo $row['dadvpayid']; ?>"><?php echo $row['adv_no']; ?></option>
                        <?php } ?>
                     </select>
                  </div>
               </div>
               <br>
               <div class="row mb-3">
                  <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Advance Amt</label>
                  <div class="col-sm-6">
                     <input type="text" name="Eadv_amt" id="Eadv_amt" class="form-control" placeholder="" readonly onchange="editgetbal()";>
                  </div>
               </div>
               <br>
               
               <div class="row mb-3">
                  <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Paid Amt</label>
                  <div class="col-sm-6">
                     <input type="text" name="Ercv_amt" id="Ercv_amt" class="form-control" placeholder="" onchange="editgetbal()";>
                  </div>
               </div>
               <br>
               <div class="row mb-3">
                  <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Adv Bal Amt</label>
                  <div class="col-sm-6">
                     <input type="text" name="Eadv_bal_amt" id="Eadv_bal_amt" class="form-control" placeholder="" readonly>
                  </div>
               </div>
               <br>
               <div class="row mb-3">
                  <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Paid Date</label>
                  <div class="col-sm-6">
                     <input type="date" name="Ercv_date" id="Ercv_date" class="form-control" placeholder="">
                  </div>
               </div>
               <br>
               <div class="row mb-3">
                  <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Payment Mode</label>
                  <div class="col-sm-6">
                     <select name="Epay_mode" id="Epay_mode" class='select2-me' style="width:100%;">
                        <option value="">Select</option>
                        <option value="CASH">CASH</option>
                        <option value="NEFT">NEFT</option>
                        <option value="CHEQUE">CHEQUE</option>
                     </select>
                  </div>
               </div>
               <br>
               <div class="row mb-3">
                  <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Remark</label>
                  <div class="col-sm-6">
                     <input type="text" name="Ebill_remark" id="Ebill_remark" class="form-control" placeholder="">
                     <input type="hidden" name="Edpayid" id="Edpayid" class="form-control" placeholder="" required>
                  </div>
               </div>
               <br>
               <div class="modal-footer">
                  <center>
                     <button class="btn btn-primary" onClick="save_editpay();" tabindex="12"> Save</button>
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
                  <h3 class="tbhead">Diesel Bill Payment </h3>
            </div>
            <div class="box-content nopadding">
               <form action="#" method="POST" class='form-horizontal form-column form-bordered'>


                  <input type="hidden" name="dpayid" id="dpayid" placeholder=" " class="form-control">
                  <div class="row">
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4"> Pump Name <span style="color: red"></span> </label>
                           <div class="col-sm-8">
                              <select name="pump_id" id="pump_id" class='select2-me' style="width:100%;" required onchange="getpumpid(); getadvid();" >
                                 <option value="">Select</option>
                                 <?php $sql = mysqli_query($connection, "Select * from  m_petrol_pump  order by pump_id");
                                 while ($row = mysqli_fetch_array($sql)) { ?>
                                    <option value="<?php echo $row['pump_id']; ?>"><?php echo $row['pump_name']; ?></option>
                                 <?php } ?>
                              </select>
                              <script>
                                 document.getElementById('pump_id').value = '<?php echo $pump_id; ?>';
                              </script>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Bill No.</label>
                           <div class="col-sm-8">
                              <!--<input type="text" name="invoiceid" id="invoiceid" placeholder="Enter Invoice Number" class="form-control">-->
                              <select name="dbillid" id="dbillid" class='select2-me' style="width:100%;" required onchange="getdbillid(this.value)" ;>
                                 <option value="">Select</option>
                              </select>
                              <script>
                                 document.getElementById('dbillid').value = '<?php echo $dbillid; ?>';
                              </script>
                           </div>
                        </div>
                     </div>

                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Bill Date <span style="color: red">*</span></label>
                           <div class="col-sm-8">
                              <!-- <input type="date" name="dbill_date" id="dbill_date" placeholder="Enter Bill Date" class="form-control" readonly> -->
                              <input type="date" name="dbill_date" id="dbill_date" placeholder="Enter Bill Date" class="form-control" readonly>
                           </div>
                        </div>
                     </div>


                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4"> Amount <span style="color: red"></span> </label>
                           <div class="col-sm-8">
                              <input type="text" name="diesel_adv_amt" id="diesel_adv_amt" placeholder="Enter Amount" class="form-control" readonly>


                           </div>
                        </div>
                     </div>

                  </div>


                  <div class="row">
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Adv No.<span style="color: red">*</span></label>
                           <div class="col-sm-8">
                              <select name="advid" id="advid" class='select2-me' style="width:100%;" onchange="getadvamt(this.value)";>
                                 <option value="">Select</option>
                              </select>
                              <script>
                                 document.getElementById('advid').value = '<?php echo $advid; ?>';
                              </script>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Advance Amt<span style="color: red">*</span></label>
                           <div class="col-sm-8">
                              <input type="text" name="adv_amt1" id="adv_amt1" placeholder="Enter  Amt" class="form-control" readonly onchange="getbal()";>
                           </div>
                        </div>
                     </div>

                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Paid Amt<span style="color: red">*</span></label>
                           <div class="col-sm-8">
                              <input type="text" name="rcv_amt" id="rcv_amt" placeholder="Enter  Amt" class="form-control" onchange="getbal()";>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Adv Bal Amt </label>
                           <div class="col-sm-8">
                              <input type="text" name="adv_bal_amt" id="adv_bal_amt" placeholder="Enter  Amt" class="form-control" readonly> 
                           </div>
                        </div>
                     </div>
                     
                  </div>
                  <div class="row">
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4"> Paid Date </label>
                           <div class="col-sm-8">
                              <input type="date" name="rcv_date" id="rcv_date" placeholder="Enter  Date" class="form-control">
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4"> Payment Mode</label>
                           <div class="col-sm-8">
                              <select name="pay_mode" id="pay_mode" class='select2-me' style="width:100%;">
                                 <option value="">Select</option>
                                 <option value="CASH">CASH</option>
                                 <option value="NEFT">NEFT</option>
                                 <option value="CHEQUE">CHEQUE</option>
                              </select>
                              <script>
                                 document.getElementById('pay_mode').value = '<?php echo $pay_mode; ?>';
                              </script>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4"> Remark </label>
                           <div class="col-sm-8">
                              <input type="text" name="bill_remark" id="bill_remark" placeholder="Enter Remark" class="form-control">
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-sm-12">
                        <div class="form-actions">
                           <center>
                              <a type="submit" onclick="dieselpayment();" class="btn btn-primary">Save</a>
                              <a type="button" onclick="jQuery('#d_pay').click();" class="btn btn-red">Cancel</a>

                           </center>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
            <div class="box box-color box-bordered red">
               <div class="box-title">
                  <h3> <i class="fa fa-table"></i>
                     Diesel Payment Details
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
                           <th>Bill No.</th>
                           <th>Paid Date</th>

                           <th>Paid Amount</th>
                           <th>Payment Mode</th>
                           <th>Remark</th>
                           <th>User Name</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        $sn = 1;
                        // echo "Select * from  $tblname  order by $tblpkey desc limit 10" ;
                        $sql = mysqli_query($connection, "Select * from  $tblname where consignorid=$consignorid && sessionid=$session_id order by $tblpkey desc limit 10");
                        while ($row = mysqli_fetch_array($sql)) {
                           $invno = $cmn->getvalfield($connection, "dieselbill", "dbillno", "dbillid='$row[dbillid]'");
                           $dbill_date = $cmn->getvalfield($connection, "dieselbill", "dbilldate", "dbillid='$row[dbillid]'");
                           $diesel_adv_amt = $cmn->getvalfield($connection, "dispatch_entry", "sum(diesel_adv_amt)", "dbillid='$row[dbillid]'");
                           $adv_amt = $cmn->getvalfield($connection, "diesel_advpayment", "adv_amt", "dadvpayid='$row[advid]'");
                           $user_name = $cmn->getvalfield($connection, "m_userlogin", "user_name", "user_id=$row[user_id]");
                        ?>

                           <tr>
                              <td><?php echo $sn++; ?></td>

                              <td><?php echo $invno; ?></td>
                              <td><?php echo dateformatindia($row['rcv_date']); ?></td>

                              <td class='hidden-350'><?php echo $row['rcv_amt']; ?></td>
                              <td class='hidden-350'><?php echo $row['pay_mode']; ?></td>
                              <td class='hidden-350'><?php echo $row['bill_remark']; ?></td>
                              <td><?php echo $user_name; ?></td>
                              <td>
                                 <?php if ($user_type == 'admin') { ?>
                                    <a onClick="modelFun('<?php echo $row['pump_id']; ?>','<?php echo $row['rcv_amt']; ?>','<?php echo $row['rcv_date']; ?>','<?php echo $row['pay_mode']; ?>','<?php echo $row['bill_remark']; ?>','<?php echo $row['dpayid']; ?>','<?php echo $dbill_date; ?>','<?php echo $diesel_adv_amt; ?>','<?php echo $row['dbillid']; ?>','<?php echo $row['advid']; ?>','<?php echo $adv_amt; ?>')" class="btn btn-inverse" rel="tooltip" title="Edit">
                                       <i class="fa fa-edit"></i>
                                    </a>
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