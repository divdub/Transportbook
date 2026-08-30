<?php 
   error_reporting(0);
   include("adminsession.php");
   $tblname = "dispatch_entry";
   $tblpkey = "dispatch_id";
   $pagename = "summary_report.php";
   $modulename = "Dispatch Entry";
   $crit="";
   
   if(isset($_GET['search']))
   {
   	 $fromdate = $_GET['fromdate'];
    	$todate = $_GET['todate'];
   	
   }
   else
   {
   	// $fromdate = $currentdate;
   	// $todate = $currentdate;
   		$fromdate = date("Y-m-01");
	$todate = date('Y-m-d');
   
   }
   
   
   
   if (isset($_GET['vehicle_id'])) {
   	$vehicle_id = trim(addslashes($_GET['vehicle_id']));
   } else
   	$vehicle_id = '';
   if (isset($_GET['owner_id'])) {
   	$owner_id = trim(addslashes($_GET['owner_id']));
   } else
   	$owner_id = '';
   	
   	if (isset($_GET['is_approve'])) {
   	$is_approve = trim(addslashes($_GET['is_approve']));
   } else
   	$is_approve = '';
   	
   	if (isset($_GET['user_id'])) {
   	$user_id = trim(addslashes($_GET['user_id']));
   } else
   	$user_id = '';
   
   if ($fromdate != '' && $todate != '') {
   	$crit .= "where bilty_date BETWEEN  '$fromdate' and  '$todate' ";
   	//echo $crit;
   }
   
   if ($vehicle_id != '') {
   	$crit .= " and vehicle_id='$vehicle_id'";
   }
  if ($owner_id != '') {
   	$crit .= " and owner_id='$owner_id'";
   }
   
   if ($is_approve != '') {
   	$crit .= " and is_approve='$is_approve'";
   }
   if ($user_id != '') {
   	$crit .= " and approved_by='$user_id'";
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
                              <i class="fa fa-list"></i>Summary
                           </h3>
                        </div>
                        <div class="box-content nopadding">
                           <form action="#" method="GET" class='form-horizontal form-column form-bordered'>
                              <div class="row">
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">From Date <span style="color: red">*</span></label>
                                       <div class="col-sm-8">
                                          <input type="date" name="fromdate" id="fromdate" placeholder="Text input" class="form-control" value="<?php echo $fromdate; ?>" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">To Date <span style="color: red">*</span></label>
                                       <div class="col-sm-8">
                                          <input type="date" name="todate" id="todate" placeholder="Text input" class="form-control" value="<?php echo $todate; ?>" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">Owner Name</label>
                                       <div class="col-sm-8">
                                          <select name="owner_id" id="owner_id" class='select2-me' style="width:100%;">
                                             <option value="">      Select  </option>
                                             <?php $sql = mysqli_query($connection,"Select * from  m_vehicle_owner  order by owner_id");
                                                while($row= mysqli_fetch_array($sql)) { ?>
                                             <option value="<?php echo $row['owner_id']; ?>"><?php echo $row['owner_name']; ?></option>
                                             <?php } ?>
                                          </select>
                                          <script>document.getElementById('owner_id').value = '<?php echo $owner_id; ?>';</script>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">Truck No.</label>
                                       <div class="col-sm-8">
                                          <select name="vehicle_id" id="vehicle_id" class='select2-me' style="width:100%;">
                                             <option value="">      Select  </option>
                                             <?php $sql = mysqli_query($connection,"Select * from  m_vehicle  order by vehicle_id");
                                                while($row= mysqli_fetch_array($sql)) { ?>
                                             <option value="<?php echo $row['vehicle_id']; ?>"><?php echo $row['vehicle_no']; ?></option>
                                             <?php } ?>
                                          </select>
                                          <script>document.getElementById('vehicle_id').value = '<?php echo $vehicle_id; ?>';</script>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">Approved</label>
                                       <div class="col-sm-8">
                                          <select name="is_approve" id="is_approve" class='select2-me' style="width:100%;">
                                             <option value="">      Select  </option>
                                             <option value="1">  Approved  </option>
                                             <option value="0">   UnApproved  </option>
                                          </select>
                                          <script>document.getElementById('is_approve').value = '<?php echo $is_approve; ?>';</script>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">Approved By</label>
                                       <div class="col-sm-8">
                                          <select name="user_id" id="user_id" class='select2-me' style="width:100%;">
                                             <option value="">      Select  </option>
                                             <?php $sql = mysqli_query($connection,"Select * from  m_userlogin  order by user_id");
                                                while($row= mysqli_fetch_array($sql)) { ?>
                                             <option value="<?php echo $row['user_id']; ?>"><?php echo $row['user_name']; ?></option>
                                             <?php } ?>
                                          </select>
                                          <script>document.getElementById('user_id').value = '<?php echo $user_id; ?>';</script>
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
               <div class="box box-color box-bordered red" >
                           <div class="box-title">
                              <h3>	<i class="fa fa-table"></i>
                                 Summary Report
                              </h3>
                              <!--<a  href="dispatch-process.php" class="btn btn-warning" style="float: right">Click Here For New Entry-->
                              <!--<i class="fa fa-object-group"></i>-->
                              <!--</a> &nbsp;-->
                              <!--<a href="pdf/pdf_dispatch_entry.php?fromdate=<?php echo $fromdate ?>&todate=<?php echo $todate ?>&vehicle_id=<?php echo $vehicle_id ?>&item_id=<?php echo $item_id ?>&brand_id=<?php echo $brand_id ?>" class="btn" style="float: right" target="_blank">Pdf -->
                              <!--<i class="fa fa-file-pdf-o"></i>-->
                              <!--</a> &nbsp;-->
                              <a href="excel/excel_summary.php?fromdate=<?php echo $fromdate ?>&todate=<?php echo $todate ?>&vehicle_id=<?php echo $vehicle_id ?>&owner_id=<?php echo $owner_id ?>" class="btn btn-warning" style="float: right">Excel
                              <i class="fa fa-file-excel-o"></i>
                              </a> 
                           </div>
                           <div class="box-content nopadding" style="overflow:scroll;">
                              <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
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
                                       <th>approved</th>

                                 
                                    </tr>
                                 </thead>
                                 <tbody>
                                  
                                       <?php
                                          $sn=1;
                                        //   echo		"Select * from  $tblname  $crit  && consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id order by $tblpkey desc";
                                          $sql = mysqli_query($connection,"Select * from  $tblname  $crit  && consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id order by $tblpkey desc");
                                          	  while($row= mysqli_fetch_array($sql)) {
                                          $consignor_name=$cmn->getvalfield($connection,"m_consignor","consignor_name","consignor_id=$row[consignor_id]");
                                          $consignee_name=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id=$row[consignee_id]");
                                          $vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
                                          $destination=$cmn->getvalfield($connection,"m_place","place_name","place_id=$row[destination_id]");	
                                          $item_name=$cmn->getvalfield($connection,"m_item","item_name","item_id=$row[item_id]");				
                                              $owner_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$row[owner_id]");
                                              $brand_name=$cmn->getvalfield($connection,"m_brand","brand_name","brand_id=$row[brand_id]");	
                                              $approve_by  = $cmn->getvalfield($connection, "m_userlogin", "user_name", "user_id=$row[approved_by]");
                                               $is_voucher=$row['is_voucher'];
                                               $tqty+=$row['wt_mt'];
                                             $famt=  $row['wt_mt'] * $row['own_rate'];
                                                $tfamt+=$famt;
                                          	   ?>
                                    <tr>
                                       <td><?php echo $sn++;?></td>
                                       <td><?php echo $row['di_no']; ?></td>
                                       <!--<td><?php echo $row['bilty_no']; ?></td>-->
                                       <td><?php echo dateformatindia($row['bilty_date']); ?></td>
                                      	<td><?php echo $row['gr_no']; ?></td>
                                       <td class='hidden-350'><?php echo $consignee_name; ?></td>
                                       <td class='hidden-1024'><?php echo $vehicle_no; ?></td>
                                         <td class='hidden-1024'><?php echo $owner_name; ?></td>
                                       <td class='hidden-1024'><?php echo $destination; ?></td>
                                       <td class='hidden-1024'><?php echo $item_name; ?></td>
                                        <td class='hidden-1024'><?php echo $brand_name; ?></td>
                                       <td><?php echo $row['wt_mt']; ?></td>
                                       <!--<td><?php echo $row['qty']; ?></td>-->
                                       <td><?php echo $row['comp_rate']; ?></td>
                                       <td><?php echo $row['own_rate']; ?></td>
                                       <td><?php echo $famt; ?></td>
                                       <td>
                                          <?php if ($row['is_approve'] == 0) { ?>

                                             <a onclick="isapprove('<?php echo $row['dispatch_id']; ?>');" class="btn btn-warning">
                                                OK
                                             </a>

                                          <?php } else { ?>

                                             <a class="btn btn-success">
                                                Approved BY <?php echo $approve_by; ?>
                                             </a>

                                          <?php } ?>
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
      <script type="text/javascript">
         function funDel(id) {
         // alert(id);
             var tablename = '<?php echo $tblname ?>';
             var tableid = '<?php echo $tblpkey ?>';
             if (confirm("Do You want to Delete this record ?")) {
                 // alert(tableid);
                 jQuery.ajax({
                     type: 'POST',
                     url: 'ajax/delete_master.php',
                     data: 'id=' + id + '&tablename=' + tablename + '&tableid=' + tableid,
                     dataType: 'html',
                     success: function(data) {
                         location = '<?php echo $pagename ?>?action=3';
         
                     }
                 }); //ajax close
             }
         }
         function isapprove(id) {

         if (confirm("Are you sure want to approve this report?")) {
            $.ajax({
               type: 'POST',
               url: 'ajax/approve.php',
               data: 'dispatch_id=' + id,
               success: function(data) {

                  alert("Approved Successfully");
                  location.reload();
               }

            });
         }
      }
         
      </script>
   </body>
</html>