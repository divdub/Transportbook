<?php 
   error_reporting(0);
   include("adminsession.php");
   $tblname = "dispatch_entry";
   $tblpkey = "dispatch_id";
   $pagename = "bilty_status_report.php";
   $modulename = "Billing Entry";
   $crit="";
   
   if(isset($_GET['search']))
   {
   	 $fromdate = $_GET['fromdate'];
    	$todate = $_GET['todate'];
   	
   }
   else
   {
	$fromdate = date("Y-m-d", strtotime("-3 months"));
	$todate = date('Y-m-d');
   
   }
   
   if (isset($_GET['item_id'])) {
   	$item_id = trim(addslashes($_GET['item_id']));
   } else
   	$item_id = '';
   	
   
   if (isset($_GET['is_invoice'])) {
   	$is_invoice = trim(addslashes($_GET['is_invoice']));
   } else
   	$is_invoice = '';
   
   
   if ($fromdate != '' && $todate != '') {
   	$crit .= "where bilty_date BETWEEN  '$fromdate' and  '$todate' ";
   	//echo $crit;
   }
   
   if ($is_invoice != '') {
   	$crit .= " and is_invoice='$is_invoice'";
   }
   if ($item_id != '') {
   	$crit .= " and item_id='$item_id'";
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
      <title> BILLING :: CHAARUVI INFOTECH PVT. LTD.</title>
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
                              <i class="fa fa-list"></i>Bilty Invoice
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
                                 <div class="col-sm-3">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">Bill Status</label>
                                       <div class="col-sm-8">
                                         
                                           <select name="is_invoice" id="is_invoice" class="form-control" style="width:100%;">
				 								<option value="">All</option>
                                      		  <option value="0">UnBilled</option>
                                      		  <option value="1">Billed</option>
                                   		    </select>
                                            <script>document.getElementById('is_invoice').value='<?php echo $is_invoice; ?>';</script>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-3">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">Item Name</label>
                                       <div class="col-sm-8">
                                          <select name="item_id" id="item_id" class='select2-me' style="width:100%;">
                                             <option value="">      Select  </option>
                                             <?php	$sql = mysqli_query($connection,"Select * from  m_item  order by item_id");
                                                while($row= mysqli_fetch_array($sql)) { ?>
                                             <option value="<?php echo $row['item_id']; ?>"><?php echo $row['item_name']; ?></option>
                                             <?php } ?>
                                          </select>
                                          <script>document.getElementById('item_id').value = '<?php echo $item_id; ?>';</script>
                                       </div>
                                    </div>
                                 </div>
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
               <div class="box box-color box-bordered red" style="overflow:scroll;">
                           <div class="box-title">
                              <h3>	<i class="fa fa-table"></i>
                               Bilty Invoice List
                              </h3>
                              <!--<a  href="dispatch-process.php" class="btn btn-warning" style="float: right">Click Here For New Entry-->
                              <!--<i class="fa fa-object-group"></i>-->
                              <!--</a> &nbsp;-->
                              <a href="pdf_invoice_book.php?fromdate=<?php echo $fromdate ?>&todate=<?php echo $todate ?>&is_invoice=<?php echo $is_invoice ?>&item_id=<?php echo $item_id ?>" class="btn" style="float: right" target="_blank">Pdf 
                              <i class="fa fa-file-pdf-o"></i>
                              </a> &nbsp;
                              <a href="excel/excel_dispatch_entry.php?fromdate=<?php echo $fromdate ?>&todate=<?php echo $todate ?>&is_invoice=<?php echo $is_invoice ?>&item_id=<?php echo $item_id ?>" class="btn btn-warning" style="float: right">Excel
                              <i class="fa fa-file-excel-o"></i>
                              </a> 
                           </div>
                           <div class="box-content nopadding">
                              <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
                                 <thead>
                                    <tr>
                                       <th>S.No</th>
                                       <th>DI No.</th>
                                       <th>Bilty No.</th>
                                       <th class='hidden-350'>Bilty Date</th>
                                       <th>Consignor</th>
                                       <th>Consignee</th>
                                       <th class='hidden-1024'>Truck No.</th>
                                       <th>Owner Name</th>
                                       <th>Destination</th>
                                       <th>Item</th>
                                       <th>Weight/MT</th>
                                       <th>Qty (Bags)</th>
                                       <th>Company Rate</th>
                                           <th>Freight</th>
                                            <th>Invoice No</th>
											 <th>Invoice Date</th>
                                  <th>User Name</th>  
                                       <!--<th>Bilty Scan</th>-->
                                       <!--<th class='hidden-480'>Action</th>-->
                                    </tr>
                                 </thead>
                                 <tbody>
                                  
                                       <?php
                                          $sn=1;
                                        //   echo		"Select * from  $tblname  $crit  && consignor_id=$consignorid order by $tblpkey desc";
                                          $sql = mysqli_query($connection,"Select * from  $tblname  $crit  && consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id order by $tblpkey desc");
                                          	  while($row= mysqli_fetch_array($sql)) {
                                          $consignor_name=$cmn->getvalfield($connection,"m_consignor","consignor_name","consignor_id=$row[consignor_id]");
                                          $consignee_name=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id=$row[consignee_id]");
                                          $vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
                                          $destination=$cmn->getvalfield($connection,"m_place","place_name","place_id=$row[destination_id]");	
                                          $item_name=$cmn->getvalfield($connection,"m_item","item_name","item_id=$row[item_id]");				
                                              $owner_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$row[owner_id]");
                                               $is_voucher=$row['is_voucher'];
                                               $invoiceid = $row['invoiceid'];
                                               	$invno = $cmn->getvalfield($connection,"invoicebilty","invno","invoiceid='$invoiceid'");
								
								if($invno=='') { $invno="Unbilled"; }	
								$invdate = $cmn->getvalfield($connection,"invoicebilty","invdate","invoiceid='$invoiceid'");
								$amount = $row['wt_mt'] * $row['comp_rate'];
                                      $totalamount += $amount;     
                                      $user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");      
                                          	   ?>
                                    <tr>
                                       <td><?php echo $sn++;?></td>
                                       <td><?php echo $row['di_no']; ?></td>
                                       <td><?php echo $row['bilty_no']; ?></td>
                                       <td><?php echo dateformatindia($row['bilty_date']); ?></td>
                                       <td><?php echo $consignor_name; ?></td>
                                       <td class='hidden-350'><?php echo $consignee_name; ?></td>
                                       <td class='hidden-1024'><?php echo $vehicle_no; ?></td>
                                         <td class='hidden-1024'><?php echo $owner_name; ?></td>
                                       <td class='hidden-1024'><?php echo $destination; ?></td>
                                       <td class='hidden-1024'><?php echo $item_name; ?></td>
                                       <td><?php echo $row['wt_mt']; ?></td>
                                       <td><?php echo $row['qty']; ?></td>
                                       <td><?php echo $row['comp_rate']; ?></td>
                                         <td><?php echo number_format($row['wt_mt'] * $row['comp_rate'],2);?></td>
                                        
                   <td><?php echo $invno;?></td>
				   <td><?php echo $invdate;?></td> 
               <td><?php echo $user_name; ?></td>
                                       <!--<td><b><a href="upload/bilty/<?php echo $row['bilty_scan'] ?>" class="text-danger"  target="_blank" download>Download</a></b></td>-->
                                       <!--<td class='hidden-480'>-->
                                       <!--   <a href="pdf/pdf_dispatch_printA4.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-warning" rel="tooltip" title="Builty A4"target="_blank" >-->
                                       <!--   <i class="fa fa-print">A4</i>-->
                                       <!--   <a href="pdf/pdf_dispatch_printA5.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-info" rel="tooltip" title="Builty A5" style="margin-left: 3px;" target="_blank">-->
                                       <!--   <i class="fa fa-print">A5</i>-->
                                       <!--   </a>-->
                                       <!--    <?php if($is_voucher=='0'){ ?>-->
                                       <!--        <a href="dispatch-process.php?editid=<?php echo $row['dispatch_id']; ?>" class="btn btn-inverse" rel="tooltip" title="Edit">-->
                                       <!--   <i class="fa fa-edit"></i>-->
                                       <!--   </a>-->
                                       <!--<?php } ?>-->
                                       <!--   <?php if($user_type=='admin'){ ?>-->
                                       <!--   <a href="dispatch-process.php?editid=<?php echo $row['dispatch_id']; ?>" class="btn btn-inverse" rel="tooltip" title="Edit">-->
                                       <!--   <i class="fa fa-edit"></i>-->
                                       <!--   </a>-->
                                          
                                       <!--   <a href="<?php echo $pagename ?>" onClick="funDel(<?php echo $row['dispatch_id']; ?>)" class="btn btn-danger" rel="tooltip" title="Delete">-->
                                       <!--   <i class="fa fa-times"></i>-->
                                       <!--   </a>-->
                                       <!--   <?php } ?>-->
                                       <!--</td>-->
                                    </tr>
                                    <?php } ?>
                                    
                                     <td></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>


                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td><strong>Total</strong></td>
                                 <td><strong><?php echo number_format($totalamount, 2); ?></strong></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
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
         
      </script>
   </body>
</html>