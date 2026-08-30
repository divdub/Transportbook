<?php 
error_reporting(0);
   include("adminsession.php");
   include("function/bill_function.php");
   $tblname = "manualinv";
   $tblpkey = "minvid";
   $pagename = "manual_bill_payment.php";
   $modulename = "Manual Bill Payment";

   ?>
      <div class="tab-pane active" id="main" style="margin-left:0">
      <div class="row">
         <div class="col-sm-12">
            <div class="box box-bordered box-color">
               <div class="box-title">
                  <!-- <span style="color: white; font-weight: bold">Success! Data Insert Successfully. <i class="fa fa-check-circle"></i></span>
                     <span style="color: white; font-weight: bold">Warning! The value you entered is already in the list. <i class="fa fa-clone"></i></span>
                     <span style="color: white; font-weight: bold">Warning! Data not inserted kindly fill mandatory field. <i class="fa fa-warning"></i></span>	 -->							
                  <h3>
                  <i class="fa fa-list"></i>	
                  <h3 class="tbhead">Invoice Payment </h3>
               </div>
               <div class="box-content nopadding" >
                  <form action="#" method="POST" class='form-horizontal form-column form-bordered'>
                   
                      
              
                     <div class="row">
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Invoice No.</label>
                           <div class="col-sm-8">
                              <!--<input type="text" name="invoiceid" id="invoiceid" placeholder="Enter Invoice Number" class="form-control">-->
                              <select name="invoiceid" id="invoiceid" class='select2-me' style="width:100%;" required onchange="getinv(this.value)";>
											<option value="">Select</option>
							<?php $sql = mysqli_query($connection, "Select * from  invoicebilty where consignorid=$consignorid && is_pay='0' && sessionid=$session_id order by invoiceid");
										while ($row = mysqli_fetch_array($sql)) { ?>
				<option value="<?php echo $row['invoiceid']; ?>"><?php echo $row['invno']; ?></option>
																	<?php } ?>
																		</select>
											<script>
				document.getElementById('invoiceid').value = '<?php echo $invoiceid; ?>';
																</script>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Invoice Date <span style="color: red">*</span></label>
                           <div class="col-sm-8">
                              <input type="date" name="invdate" id="invdate" placeholder="Enter Invoice Date" class="form-control" readonly>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4"> Qty </label>
                           <div class="col-sm-8">
                              <input type="text" name="qty" id="qty" placeholder="Enter Qty" class="form-control"readonly>
                           </div>
                        </div>
                     </div>
               
               <div class="col-sm-3">
               <div class="form-group">
               <label for="textfield" class="control-label col-sm-4"> Amount  <span style="color: red"></span> </label>
               <div class="col-sm-8">
               <input type="text" name="amount" id="amount" placeholder="Enter Amount" class="form-control" readonly>
                <input type="hidden" name="amount1" id="amount1" placeholder="Enter Amount" class="form-control" readonly>
               </div>
               </div>
               </div>

               </div>
               
                     <div class="row">
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Tds %</label>
                           <div class="col-sm-8">
                              <!--<input type="text" name="invoiceid" id="invoiceid" placeholder="Enter Invoice Number" class="form-control">-->
                              <select name="tds_per" id="tds_per" class='form-control' onchange="gettotal();">
                                    <option value="">Select</option>
       
               <option value="0.75">0.75% </option>
              <option value="1">1%</option> 
              <option value="1.5">1.5%</option>    
              <option value="2">2%</option>     
         <script>
            document.getElementById('tds_per').value ='<?php echo $tds_per ; ?>';</script>
                     </select>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Tds Amt<span style="color: red">*</span></label>
                           <div class="col-sm-8">
                              <input type="text" name="tds_amt" id="tds_amt" placeholder="Enter Amt" class="form-control">
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4"> GSt </label>
                           <div class="col-sm-8">
                                <input type="text" name="gst" id="gst" placeholder="Enter Amount" class="form-control">
                           <!-- <select name="gst" id="gst" class='form-control' onchange="gettotal();">
                                    <option value="">Select</option>
       
               <option value="5">5% </option>
              <option value="12">12%</option> 
              <option value="18">18%</option>    
              <option value="28">28%</option>     
         <script>
            document.getElementById('gst').value ='<?php echo $gst; ?>';</script>
                     </select> -->
                           </div>
                        </div>
                     </div>
               
               <div class="col-sm-3">
               <div class="form-group">
               <label for="textfield" class="control-label col-sm-4"> Gst Amount  <span style="color: red">*</span> </label>
               <div class="col-sm-8">
               <input type="text" name="gst_amt" id="gst_amt" placeholder="Enter Amount" class="form-control">
               </div>
               </div>
               </div>
                              </div>
               <div class="row">
                        <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4"> Deduction Date</label>
                           <div class="col-sm-8">
                           <input type="date" name="deduct_date" id="deduct_date" placeholder="Enter " class="form-control" >
                           </div>
                        </div>
                     </div>
                     
               <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4"> Deduction Amt <span class="badge shtcutbtn"><a class="shtcut" onClick="jQuery('#myModald').modal('show');">+</a></span></label>
                           <div class="col-sm-8">
                           <input type="text" name="deduct" id="deduct" placeholder="Enter Amt" class="form-control" onchange="gettotal();">
                           </div>
                        </div>
                     </div>
                          <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4"> Deduction Remark</label>
                           <div class="col-sm-8">
                           <input type="text" name="deduct_remark" id="deduct_remark" placeholder="Enter Remark" class="form-control">
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Amt Paid to </label>
                           <div class="col-sm-8">
                              <!--<input type="text" name="invoiceid" id="invoiceid" placeholder="Enter Invoice Number" class="form-control">-->
                              <input type="text" name="netamt" id="netamt" placeholder="" class="form-control" readonly>
                           </div>
                        </div>
                     </div>
                     </div>
                     <div class="row">
                        
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Received Amt<span style="color: red">*</span></label>
                           <div class="col-sm-8">
                              <input type="text" name="received_amt" id="received_amt" placeholder="Enter Received Amt" class="form-control">
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4"> Receive Date </label>
                           <div class="col-sm-8">
                           <input type="date" name="receive_date" id="receive_date" placeholder="Enter Receive Date" class="form-control">
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3" style="display: none;">
                            <div class="form-group">
                               <label for="textfield" class="control-label col-sm-4">Incentive Amt</label>
                               <div class="col-sm-8">
                                  <input type="text" name="incentiveamt" id="incentiveamt" placeholder="Enter Incentive Amt" class="form-control">
                               </div>
                            </div>
                        </div>
                              
               <div class="col-sm-3">
               <div class="form-group">
               <label for="textfield" class="control-label col-sm-4"> Remark <span style="color: red">*</span> </label>
               <div class="col-sm-8">
               <input type="text" name="remark" id="remark" placeholder="Enter Remark" class="form-control">
               </div>
               </div>
               </div>
               </div>
               <div class="row">
               <div class="col-sm-12">
               <div class="form-actions">
               <center>
               	  <a type="submit" onclick="savebillpayment();" class="btn btn-primary">Save</a>
             <a type="button" onclick="jQuery('#manual_bill').click();" class="btn btn-red">Cancel</a>
               
               </center>
               </div>
               </div>
               </div>
               </form>
            </div>
            <div class="box box-color box-bordered red">
               <div class="box-title">
                  <h3>	<i class="fa fa-table"></i>
                     Invoice Payment  Details
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
                  <input type="button" class="btn btn-success" value="Incentive / Deduct" style="text-align:right; float:right;" onClick="jQuery('#myModald1').modal('show');">
               </div>
               <div class="box-content nopadding">
                  <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
                     <thead>
                        <tr>
                           <th>S.No</th>
                           <th>Invoice No.</th>
                           <th>Receive Date</th>
                           <th>Tds Amt</th>
                            <th>Gst Amt </th>
                           <th>Deduct Amount</th>
                           <th>Received Amount</th>
                           <!-- <th>Deduct Amount</th> -->
                           <th>Remark</th>
                           <th>User Name</th>  
                        </tr>
                     </thead>
                     <tbody>
                     		 <?php
									$sn=1;
									// echo "Select * from  $tblname  order by $tblpkey desc limit 10" ;
				$sql = mysqli_query($connection,"Select * from  $tblname where consignorid=$consignorid && session_id=$session_id order by $tblpkey desc limit 10");
										  while($row= mysqli_fetch_array($sql)) {
                                         if ($row['type'] == 'incentive' || $row['type'] == 'Deduct') {
                                              $invno = $row['ref_no'];
                                           }else{
                                              $invno = $cmn->getvalfield($connection, "invoicebilty", "invno", "invoiceid='" . $row['invoiceid'] . "'");
                                           }
                                 $user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
							   ?>

                        <tr>
                          	<td><?php echo $sn++;?></td>
						
						<td><?php echo $invno; ?></td>
						<td><?php echo dateformatindia($row['receive_date']); ?></td>
                  <td class='hidden-350'><?php echo $row['tds_amt']; ?></td>
                  <td class='hidden-350'><?php echo $row['gst_amt']; ?></td>
				  <td class='hidden-350'>
				      <?php if($row['some_condition'] == 1) { ?>
                     <?php echo $row['deduct']; ?>
                    <?php } else { ?>
                     <a onClick="jQuery('#myModaldshow').modal('show');getddata(<?php echo $row['invoiceid']; ?>);">
                        <?php echo $row['deduct']; ?>
                    </a>
                     <?php } ?>
                     </td>
                     
                  <td class='hidden-350'><?php echo $row['received_amt']; ?></td>
                  <td class='hidden-350'><?php echo $row['remark']; ?></td>   
                  <td><?php echo $user_name; ?></td> 
                        </tr>
                    <?php } ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <br/>
      </div>
