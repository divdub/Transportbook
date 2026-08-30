<?php 
   error_reporting(0);
   include("adminsession.php");
   include("function/bill_function.php");
   $tblname = "invoicebilty";
   $tblpkey = "invoiceid";
   $pagename = "gstpayment_report.php";
   $modulename = "Gst Payment Details";
   $crit="";
   
   if(isset($_GET['search']))
   {
   	 $fromdate = $_GET['fromdate'];
    	$todate = $_GET['todate'];
   	
   }
   else
   {
   		$fromdate = date("Y-m-d", strtotime("-3 months"));
   	$todate = $currentdate;
   
   }
   
  
   
   if ($fromdate != '' && $todate != '') {
   	$crit .= "where invdate BETWEEN  '$fromdate' and  '$todate' ";
   	//echo $crit;
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
                              <i class="fa fa-list"></i>Gst Payment
                           </h3>
                        </div> 
                        <div class="box-content nopadding">
                           <form action="#" method="GET" class='form-horizontal form-column form-bordered'>
                              <div class="row">
                                 <div class="col-sm-3">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">From Date <span style="color: red">*</span></label>
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
                                 <!-- 	<div class="col-sm-3">
                                    <div class="form-group">
                                    	<label for="textfield" class="control-label col-sm-4">Item <span style="color: red">*</span></label>
                                    	<div class="col-sm-8">
                                    <select name="item_id" id="item_id" class='select2-me' style="width:230px;" required>
                                    	<option value="">Select</option>
                                    <?php	$sql = mysqli_query($connection,"Select * from  m_item  order by item_id");
                                       while($row= mysqli_fetch_array($sql)) { ?>
                                     	
                                    <option value="<?php echo $row['item_id']; ?>"><?php echo $row['item_name']; ?></option>
                                    <?php } ?>
                                    
                                    </select>
                                    <script>document.getElementById('item_id').value = '<?php echo $item_id; ?>';</script>
                                    
                                    	</div>
                                    </div>
                                    
                                    </div> -->
                                 
                              </div>
                              <div class="row">
                                 <div class="col-sm-12">
                                    <div class="form-actions">
                                       <center>
                                          <input type="submit" name="search" class="btn btn-primary" value="Search">  
                                          <a type="button" href="<?php echo $pagename; ?>" class="btn btn-red">Cancel</a>
                                       </center>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
                        <div class="box box-color box-bordered red">
                           <div class="box-title">
                              <h3>	<i class="fa fa-table"></i>
                                 Gst Payment Details
                              </h3>
                                 <a  href="gstpaypdf.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>" class="btn" target="_blank" style="float: right">Pdf
                              <i class="fa fa-file-pdf-o"></i>
                              </a> &nbsp;
                            	<a onclick="getwhatsapp('<?php echo $fromdate; ?>', '<?php echo $todate ?>')"><img src="img/whatsapp.png" style="width:30px;height:30px;float: right"></a>
									<span style="color:#F00;width: 70px;font-weight:bold;padding-top: 5px;float: right;" id="msg"></span>
										&nbsp;
                           </div>
                           <div class="box-content nopadding">
                              <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
                                 <thead>
                                    <tr>
                                     <th>S.No</th>
                           <th>Invoice No.</th>
                           <th>Invoice Date</th>
                           <th>Gst Amount</th>
                           <th>Receive Date</th>
                         
                           <th>Received Amount</th>
                            
                           <th>Remark</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                  
                                       <?php
									$sn=1;
								// 	echo "Select * from  $tblname $crit && is_pay=1 &&  consignorid=$consignorid && sessionid=$session_id order by $tblpkey desc " ;
				$sql = mysqli_query($connection,"Select * from  $tblname $crit && is_pay=1 &&  consignorid=$consignorid && sessionid=$session_id order by $tblpkey desc ");
										  while($row= mysqli_fetch_array($sql)) {
                                 $gst_amt = $cmn->getvalfield($connection,"manualinv","gst_amt","invoiceid='$row[invoiceid]'");
                                  $receive_gstdate = $cmn->getvalfield($connection,"manualinv","receive_gstdate","invoiceid='$row[invoiceid]'");
                                  $gstremark = $cmn->getvalfield($connection,"manualinv","gstremark","invoiceid='$row[invoiceid]'");
                                  $received_gstamt = $cmn->getvalfield($connection,"manualinv","received_gstamt","invoiceid='$row[invoiceid]'");
                                   $incentiveamt = $cmn->getvalfield($connection,"manualinv","incentiveamt","invoiceid='$row[invoiceid]'");
							   ?>
                                    <tr>
                                       	<td><?php echo $sn++;?></td>
						
						<td><?php echo $row['invno']; ?></td>
							<td><?php echo dateformatindia($row['invdate']); ?></td>
						<td><?php echo $gst_amt; ?></td>
						<td><?php echo dateformatindia($receive_gstdate); ?></td>
               
                  <td class='hidden-350'><?php echo $received_gstamt; ?></td>
                   
                  <td class='hidden-350'><?php echo $gstremark; ?></td>    
                               
                           
                                    </tr>
                                    <?php
                                    $treceived_gstamt +=$received_gstamt;
                                    $tgst_amt+=$gst_amt;
                                    } ?>
                                    
                                 </tbody>
                                 <tfoot style="font-weight:bold;">
                                     <tr>
                                        <td colspan=3 style="text-align:center;">Total :</td>
                                        <td><?php echo $treceived_gstamt; ?></td>
                                        <td></td>
                                        <td><?php echo $tgst_amt; ?></td>
                                        <td></td>
                                    </tr>
                                 </tfoot>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- whatsapp model open -->
	<div class="modal fade" id="myModal_whatsapp" role="dialog">
		<div class="modal-dialog" style="width:480px;padding-top: 225px;">
			<div class="modal-content" style="border-radius: 20px;">
				<div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
					<!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
					<center>
						<h4 class="modal-title"><b>Send Message<b></h4>
					</center>
				</div>
				<div class="modal-body" style="flex-wrap: wrap-reverse;display: flex;">
					<span style="color:#F00;" id="suppler_model_error"></span>
					<table class="table table-condensed table-bordered">
						<tr>
							<th>Bill Name <span style="color:#F00;"> * </span> </th>
							<th>Contact No.</th>
						</tr>
						<tr>
							<td>
								<!-- <input type="hidden" name="w_category" id="w_category" class="form-control" value="" style="font-weight:bold; " autocomplete="off" readonly> -->
								<input type="text" name="w_bill_name" id="w_bill_name" class="form-control" value="" style="font-weight:bold; " autocomplete="off">
								<!-- <input type="hidden" name="w_owner_id" id="w_owner_id" class="form-control" value="" style="font-weight:bold; " autocomplete="off" readonly> -->
							</td>
							<td>
								<input type="number" name="w_mobile" id="w_mobile" placeholder="Mobile No" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" value="<?php echo $w_mobile; ?>" required>
								<!-- <input type="text" name="w_mobile" id="w_mobile" class="form-control" value="" style="font-weight:bold; " autocomplete="off"> -->
								<input type="hidden" name="w_billid" id="w_billid" class="form-control" value="" style="font-weight:bold; " autocomplete="off">
							</td>
						</tr>
						<tr >
							<input type="checkbox" name="numupdate" id="numupdate" value="1" style="width:18px;display: none;" /> <span style="font-size:16px;margin-top:10px;"></span>
							<!-- <input type="checkbox" id="layername1" name="layername" value="Drone Image" onclick="showLayerMap(1);"  /> -->
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" name="s_save" id="s_save" onClick="sendfile();">Send</button>
					<button data-dismiss="modal" class="btn btn-danger">Close</button>
					<!-- <input type="hidden" id="s_saleid" value=""> -->
				</div>
			</div>
		</div>
	</div>
      <script type="text/javascript">
	function getwhatsapp(fromdate,todate){
				// var fromdate = document.getElementById('fromdate').value;
				// var todate = document.getElementById('todate').value;
				// alert(fromdate);
				jQuery.ajax({
					type: 'POST',
					url: 'gstpaypdf_whatsapp.php',
					data: 'fromdate=' + fromdate + '&todate=' + todate,
					dataType: 'html',
					success: function(data) {
						// sendfile(vehicle_id,cat_id,bill_name,mobile);
						// getnum(billid,category,owner_id,bill_name,mobile);
						getnum(fromdate,todate);
					}
				});
			}

	function getnum(fromdate,todate) {
				// alert(fromdate);
				jQuery('#myModal_whatsapp').modal('show');
				jQuery('#w_billid').val(fromdate);
			
			}
			
			function sendfile() {
				var billid = document.getElementById('w_billid').value;
				// var owner_id = document.getElementById('w_billid').value;
				var mobile = document.getElementById('w_mobile').value;
				var bill_name = document.getElementById('w_bill_name').value;
				var numupdate = document.getElementById('numupdate');
				var type = "gst";

				if (numupdate.checked == true) {
					var upval = '1';
				} else {
					var upval = '0';
				}


				if (mobile == '') {
					alert("Please Enter Mobile No.");
					return false;
				}

				jQuery.ajax({
					type: 'POST',
					url: 'whatsapp.php',
					data: 'billid=' + billid + '&mobile=' + mobile + '&bill_name=' + bill_name  + '&type=' + type + '&upval=' + upval,
					dataType: 'html',
					success: function(data) {
						jQuery("#myModal_whatsapp").modal('hide');
						document.getElementById('msg').innerHTML = 'Sent';

					}

				}); //ajax close
			}
    function funDel1(id)
         {    
              //alert(id);   
              tblname = 'invoicebilty';
               tblpkey = 'invoiceid';
               pagename  ='<?php echo $pagename; ?>';
               modulename  ='<?php echo $modulename; ?>';
              //alert(tblpkey); 
            if(confirm("Are you sure! You want to delete this record."))
            {
               $.ajax({
                 type: 'POST',
                 url: 'ajaxbill/deleteinvoice.php',
                 data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename,
                 dataType: 'html',
                 success: function(data){
                   // alert(data);
                   // alert('Data Deleted Successfully');
                    location=pagename+'?action=10';
                  }
               
                 });//ajax close
            }//confirm close
         } //fun close
      </script>
   </body>
</html>