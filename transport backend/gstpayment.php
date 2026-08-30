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
                  <h3 class="tbhead">GST Payment </h3>
               </div>
               <div class="box-content nopadding" >
                  <form action="#" method="POST" class='form-horizontal form-column form-bordered'>
                   
                      
              
                     <div class="row">
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Invoice No.</label>
                           <div class="col-sm-8">
                              <!--<input type="text" name="invoiceid" id="invoiceid" placeholder="Enter Invoice Number" class="form-control">-->
                              <select name="minvid" id="minvid" class='select2-me' style="width:100%;" required onchange="getgst(this.value)";>
											<option value="">Select</option>
							<?php $sql = mysqli_query($connection, "Select * from  manualinv where consignorid=$consignorid  && gst_pay=0 && session_id=$session_id order by minvid");
										while ($row = mysqli_fetch_array($sql)) { ?>
				<option value="<?php echo $row['minvid']; ?>"><?php
                                    if($row['type'] == 'incentive'){
                                      echo   $invno = $row['ref_no'];
                                    }else{
                                      echo $cmn->getvalfield($connection, "invoicebilty", "invno", "invoiceid='$row[invoiceid]'");
                                    }
                                     ?></option>
																	<?php } ?>
																		</select>
											<script>
				document.getElementById('minvid').value = '<?php echo $minvid; ?>';
																</script>
                           </div>
                        </div>
                     </div>
                    

           
                    
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4"> GSt </label>
                           <div class="col-sm-8">
                               <input type="text" name="gst" id="gst" placeholder="Enter Amount" class="form-control" readonly>
                           <!-- <select name="gst" id="gst" class='form-control' disabled>
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
               <input type="text" name="gst_amt" id="gst_amt" placeholder="Enter Amount" class="form-control" readonly>
               </div>
               </div>
               </div>
               <div class="col-sm-3">
                        <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4"> Receive Date </label>
                           <div class="col-sm-8">
                           <input type="date" name="receive_gstdate" id="receive_gstdate" placeholder="Enter Receive Date" class="form-control">
                           </div>
                        </div>
                     </div>
                              </div>
               
                      
                     <div class="row">
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
                           <label for="textfield" class="control-label col-sm-4">Received Amt<span style="color: red">*</span></label>
                           <div class="col-sm-8">
                              <input type="text" name="received_gstamt" id="received_gstamt" placeholder="Enter Received Amt" class="form-control">
                           </div>
                        </div>
                     </div>
                    
                              
               <div class="col-sm-3">
               <div class="form-group">
               <label for="textfield" class="control-label col-sm-4"> Remark <span style="color: red">*</span> </label>
               <div class="col-sm-8">
               <input type="text" name="gstremark" id="gstremark" placeholder="Enter Remark" class="form-control">
               </div>
               </div>
               </div>
               </div>
               <div class="row">
               <div class="col-sm-12">
               <div class="form-actions">
               <center>
               	  <a type="submit" onclick="savegstpayment();" class="btn btn-primary">Save</a>
             <a type="button" onclick="jQuery('#gst_pay').click();" class="btn btn-red">Cancel</a>
               
               </center>
               </div>
               </div>
               </div>
               </form>
            </div>
            <div class="box box-color box-bordered red">
               <div class="box-title">
                  <h3>	<i class="fa fa-table"></i>
                     GST Payment  Details
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
                           <th>Invoice No.</th>
                           <th>Receive Date</th>
                         
                           <th>Received Amount</th>
                            <!--<th>Incentive Amount</th> -->
                           <th>Remark</th>
                        </tr>
                     </thead>
                     <tbody>
                     		 <?php
									$sn=1;
									// echo "Select * from  $tblname  order by $tblpkey desc limit 10" ;
				$sql = mysqli_query($connection,"Select * from  $tblname where gst_pay='1' && consignorid=$consignorid && session_id=$session_id order by $tblpkey desc limit 10");
										  while($row= mysqli_fetch_array($sql)) {
                                 if($row['type'] == ''){
                             $invno = $cmn->getvalfield($connection, "invoicebilty", "invno", "invoiceid='$row[invoiceid]'");
                           }else{
                               $invno = $row['ref_no'];
                           }
							   ?>

                        <tr>
                          	<td><?php echo $sn++;?></td>
						
						<td><?php echo $invno; ?></td>
						<td><?php echo dateformatindia($row['receive_gstdate']); ?></td>
               
                  <td class='hidden-350'><?php echo $row['received_gstamt']; ?></td>
                  
                  <td class='hidden-350'><?php echo $row['gstremark']; ?></td>    
                        </tr>
                    <?php } ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <br/>
      </div>
