<?php 
   error_reporting(0);
   include("adminsession.php");
   include("function/bill_function.php");
   $tblname = "invoicebilty";
   $tblpkey = "invoiceid";
   $pagename = "invoice_report.php";
   $modulename = "Invoice Details";
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
   
  if (isset($_GET['is_pay'])) {
   $is_pay = trim(addslashes($_GET['is_pay']));
} else
   $is_pay = '';
   
   if ($fromdate != '' && $todate != '') {
   	$crit .= "where invdate BETWEEN  '$fromdate' and  '$todate' ";
   	//echo $crit;
   }
   
   if ($is_pay != '') {
   $crit .= " and is_pay='$is_pay'";
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
    <div class="modal-dialog" style="width:480px;padding-top: 225px;" >


      <div class="modal-content" style="border-radius: 20px;">
        <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
          <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
          <center>
          <h4 class="modal-title"><b>Check Otp<b></h4></center>
        </div>
        <div class="modal-body" style="padding-top:30px;">
          <div class="row mb-3">
            <label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;">Enter 4 Digit Code</label>
            <div class="col-sm-6">
			
              <input type="text" name="otp" id="otp"  class="form-control" placeholder="" required>
			  <input type="hidden" id="ref_id" value="" >
            </div>
          </div>
         <br>
         <input type="hidden" id="type" value="" >
		 
          <div class="modal-footer" >
          	<center>
            <button class="btn btn-primary" onClick="checkotp();" tabindex="12">Check</button>
            <a><input type="button" data-dismiss="modal" class="btn btn-danger" value="Close"></a></center>
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
                              <i class="fa fa-list"></i>Invoice Book
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
                                 Invoice  List
                              </h3>
                                 <a  href="invoicebook.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>" class="btn" target="_blank" style="float: right">Invoice Book
                              <i class="fa fa-file-pdf-o"></i>
                              </a> &nbsp;
                              <a  href="billing.php" class="btn btn-warning" style="float: right">Click Here For New Entry
                              <i class="fa fa-object-group"></i>
                              </a> &nbsp;
                              <a href="pdf/pdf_invoice_entry.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>" class="btn" style="float: right" target="_blank">Pdf 
                              <i class="fa fa-file-pdf-o"></i>
                              </a> &nbsp;
                             
                              <a href="excel/excel_invoice_entry.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>" class="btn btn-warning" style="float: right">Excel
                              <i class="fa fa-file-excel-o"></i>
                              </a> 
                           </div>
                           <div class="box-content nopadding">
                              <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
                                 <thead>
                                    <tr>
                                   <th>Sno</th>  
                                   <th>Bill Type</th>
                                            <th>Invoice No</th>
                                          <th>Invoice Date</th>
                                            <th>Qty</th>
                                            <th> Amount</th>
                                            <th>Invoice Amount</th>
                                            <th>User Name</th>  
                                            <th>Print</th>
                                               	  <?php if($user_type=='admin'){ ?> <th>Action</th>
                                               	  <?php } ?>
                                    </tr>
                                 </thead>
                                 <tbody>
                                  
                                       <?php
                                          $sn=1;
                                          // echo		"Select * from  $tblname  where consignorid=$consignorid order by $tblpkey desc";
                                    
                                          $sql = mysqli_query($connection,"Select * from  $tblname  $crit && consignorid=$consignorid && sessionid=$session_id order by $tblpkey asc");
                                          	  while($row= mysqli_fetch_array($sql)) {
                                        				$amount = $cmn->getinvoiceamount1($connection,$row['invoiceid']);
                                        				// 		$dispatch_id=$cmn->getvalfield($connection,"dispatch_entry","dispatch_id","invoiceid='$row[invoiceid]'");
                                        				//   $gstper = $cmn->getvalfield($connection,"payment","gstper","invoiceid='$row[invoiceid]'");
                                      $wt_mt = $cmn->getvalfield($connection,"dispatch_entry","sum(wt_mt)","invoiceid='$row[invoiceid]'"); 	
                                      $gstv = $row['gst'];
                                      	$gst =  ($amount * $gstv)/100;
                                      	$amount1=$amount+$gst;
                                      	$totalamount +=$amount;
                                    $user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
                                    $invoiceamount +=$amount1;
                                          	   ?>
                                    <tr>
                                       <td><?php echo $sn++; ?></td>
                                       <td><?php echo ucfirst($row['billtype']);?></td>
                                            <td><?php echo ucfirst($row['invno']);?></td>
                                            <td><?php echo $cmn->dateformatindia($row['invdate']);?></td>
                                            <td><?php echo number_format($wt_mt,2);?></td>
                                             <td><?php echo number_format($amount, 2); ?></td>
                                            <td><?php echo number_format($amount1,2);?></td>
                                            <td><?php echo $user_name; ?></td>
                                            <td>
                                            <?php   if($consignorid!=2){ 
                                            if($row['billtype'] == 'Party'){ 
                                            ?>
                                                                        <a href="pdf/pdf_invoice.php?invoiceid=<?php echo $row['invoiceid']; ?>" class="btn btn-warning" target="_blank" style="padding: 3px 2px">
                                                                        Pdf <i class="fa fa-file-pdf-o"></i>
                                                                        </a>
                                                                        <?php } elseif($row['billtype'] == 'Clinker') { ?>
                                                                         <a href="pdf/clinker_summery.php?invoiceid=<?php echo $row['invoiceid']; ?>" class="btn btn-warning" target="_blank" style="padding: 3px 2px">
                                                                         Cover Note <i class="fa fa-file-pdf-o"></i>
                                                                        </a>&nbsp;
                                                                         <a href="pdf/clinker_details.php?invoiceid=<?php echo $row['invoiceid']; ?>" class="btn btn-primary" target="_blank" style="padding: 3px 2px">
                                                                         Invoice <i class="fa fa-file-pdf-o"></i>
                                                                        </a>
                                                                        <?php } elseif($row['billtype'] == 'Pre Loading') { ?>
                                                                          <a href="pdf/pdf_preloading.php?invoiceid=<?php echo $row['invoiceid']; ?>" class="btn btn-warning" target="_blank" style="padding: 3px 2px">
                                                                         Pdf <i class="fa fa-file-pdf-o"></i>
                                                                        </a>
                                                                     <?php 
                                                                     } else {
                                                                     ?>
                                                                        <a href="pdf/pdf_invoicedepo.php?invoiceid=<?php echo $row['invoiceid']; ?>" class="btn btn-warning" target="_blank" style="padding: 3px 2px">
                                                                         Pdf <i class="fa fa-file-pdf-o"></i>
                                                                        </a>
                                                                     <?php } ?>
                                                                     
                                                                   

                                                                     <?php if($row['billtype'] == 'Party'){ ?>
                                                                        <a href="excel/excel_invoice.php?invoiceid=<?php echo $row['invoiceid']; ?>" class="btn btn-primary" target="_blank" style="padding: 3px 2px">
                                                                        Excel <i class="fa fa-file-excel-o"></i> 
                                                                        </a>
                                                                         <?php } elseif($row['billtype'] == 'Clinker') { ?>
                                                                          <?php } elseif($row['billtype'] == 'Pre Loading') { ?>
                                                                     <?php } else { ?>
                                                                        <a href="excel/excel_invoicedepo.php?invoiceid=<?php echo $row['invoiceid']; ?>" class="btn btn-primary" target="_blank" style="padding: 3px 2px" >
                                                                        Excel  <i class="fa fa-file-excel-o"></i> 
                                                                        </a>
                                                                     <?php }  } 
                                                                     if($consignorid!=1){ ?>
                                                                          <a href="pdf/pdf_invoice_report.php?invoiceid=<?php echo $row['invoiceid']; ?>" class="btn btn-warning" target="_blank" style="padding: 3px 2px">
                                                                        Pdf <i class="fa fa-file-pdf-o"></i>
                                                                        </a>
                                                                     <a href="pdf/invoice_summery.php?invoiceid=<?php echo $row['invoiceid']; ?>" class="btn btn-warning" target="_blank" style="padding: 3px 2px">
                                                                        Invoice Summery <i class="fa fa-file-pdf-o"></i>
                 </a> <?php } ?>
                                                                 

                                                 </td>
                                           
                                           	  <?php if($user_type=='admin'){ ?>
                                           	  <td>
                                           	      <?php if($row['is_pay']=='0'){ ?>
                                                      <a onClick="edit('<?php echo $row['invoiceid'];?>','edit');" class="btn btn-inverse" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                       <!-- <a href= "billing.php?edit=<?php echo ucfirst($row['invoiceid']);?>" class="btn btn-inverse" rel="tooltip" title="Edit"> <i class="fa fa-edit"></i></a> -->
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="edit('<?php echo $row['invoiceid'];?>','del');"  class="btn btn-danger" rel="tooltip" title="Delete">
			<i class="fa fa-times"></i>
		</a>               
                   <!-- <a onClick="funDel1('<?php echo $row['invoiceid']; ?>')"   class="btn btn-danger" rel="tooltip" title="Delete"> <i class="fa fa-times"></i></a> -->
                
                <?php } ?>
               
                                           
                                           
                                 </td>
                                 <?php } ?>
                           
                                    </tr>
                                    
                                    
                                    
                                    <?php } ?>
                                     <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                     <td></td>
                                    <td><strong>Total</strong></td>
                                    <td><strong><?php echo number_format($totalamount, 2); ?></strong></td>
                                     <td><strong><?php echo number_format($invoiceamount, 2); ?></strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                 </tr>

                                    
                                    
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