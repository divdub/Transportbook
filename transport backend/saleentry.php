<?php 
error_reporting(0);
include("adminsession.php");
// include("function/dispatch_function.php");
$tblname = "saleentry";
$tblpkey = "saleid";
$pagename = "saleentry.php";
$modulename = "Employee Payment Entry";
$duplicate='';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = "";
}
if (isset($_GET['editid'])) {
   
    $keyvalue = $_GET['editid'];
} else {
 
    $keyvalue = 0;
}
if(isset($_GET['editid']) != "")
{
    $keyvalue = test_input($_GET['editid']);
   $sql = mysqli_query($connection,"select * from $tblname where $tblpkey='$keyvalue'");
   $row = mysqli_fetch_array($sql);
    $saledate = $row['saledate']; 
   $adblue_id = $row['adblue_id'];
   $qty=$row['qty'];
   $remark=$row['remark'];
    $vehicle_id = $row['vehicle_id'];
   $rate = $row['rate'];
   $amount= $row['amount'];
   $payment_mode=$row['payment_mode'];
   $owner_id = $cmn->getvalfield($connection, "m_vehicle", "owner_id", "vehicle_id=$vehicle_id");
   	$owner_name1 = $cmn->getvalfield($connection, "m_vehicle_owner", "owner_name", "owner_id=$owner_id");
     }
else
{
    $amount='';
    $rate='';
    $vehicle_id='';
   $saledate = '';
   $adblue_id = '';
   $qty='';
   $remark='';
}
if(isset($_POST['submit']))
{
     $saledate = $_POST['saledate'];
   $adblue_id = $_POST['adblue_id'];
   $qty = $_POST['qty'];
   $vehicle_id = $_POST['vehicle_id'];
   $rate = $_POST['rate'];
   $amount= $_POST['amount'];
   $payment_mode=$_POST['payment_mode'];
   $remark = $_POST['remark'];
 
   $form_data = array('saledate'=>$saledate,'vehicle_id'=>$vehicle_id,'for_ledger'=>'Sale','amount'=>$amount,'adblue_id'=>$adblue_id,'rate'=>$rate,'consignorid'=>$consignorid,'qty'=>$qty,'remark'=>$remark,'comp_id'=>$comp_id,'payment_mode'=>$payment_mode,'session_id'=>$session_id,'created_date'=>$currentdate,'user_id' => $user_id);
    
   if($keyvalue  == 0)
   {
         dbRowInsert($connection,$tblname, $form_data);
         echo "<script>location='$pagename?action=1'</script>";
   }
   else
   {
      $form_data = array('saledate'=>$saledate,'vehicle_id'=>$vehicle_id,'for_ledger'=>'Sale','amount'=>$amount,'adblue_id'=>$adblue_id,'rate'=>$rate,'qty'=>$qty,'consignorid'=>$consignorid,'remark'=>$remark,'comp_id'=>$comp_id,'payment_mode'=>$payment_mode,'session_id'=>$session_id,'updated_date'=>$currentdate);
      dbRowUpdate($connection,$tblname, $form_data, "$tblpkey='$keyvalue'");
     echo "<script>location='$pagename?action=2'</script>";
   }
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

   <title>INVENTORY :: CHAARUVI INFOTECH PVT. LTD.</title>

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
                  <div class="box box-bordered box-color satblue" >
                     <div class="box-title">
                        <h3>
                           <i class="fa fa-bars"></i>Stock
</h3>
                     </div>
                     <div class="box-content nopadding">
                        <ul class="tabs tabs-inline tabs-top">
                        <li>
                              <a id="attendance" data-toggle='tab'>
                                 <i class="fa fa-inbox"></i>Stock-In Entry</a>
                           </li>
                            <li class="active">
                              <a id="sale" data-toggle='tab'>
                                 <i class="fa fa-inbox"></i>Sale Entry</a>
                           </li>
                           <li>
                              <a id="att_report" data-toggle='tab' style="background: #fab750; color: #000000">
                                 <i class="fa fa-share"></i>Stock-In  Report</a>
                           </li>
                        <li>
                              <a id="stock" data-toggle='tab' style="background: #fab750; color: #000000">
                                 <i class="fa fa-share"></i>Stock</a>
                           </li>
                         <li>
                              <a id="stockr" data-toggle='tab' style="background: #fab750; color: #000000">
                                 <i class="fa fa-share"></i>Stock Report</a>
                           </li>
                           
                        </ul>
                     <div class="tab-content padding tab-content-inline tab-content-bottom" id="main1" >
                           <div class="tab-pane active" id="first11">
                              <div class="col-sm-12">
                         <div class="row" style="padding-top:20px;">
               <div class="col-sm-12">
                  <?php if($duplicate!='') { ?>
                     <div class="alert alert-warning" >
               <button data-dismiss="alert" class="close" type="button">×</button>
                 <strong><i class="fa fa-clone"></i> Warning! The value you entered is already in the list. </strong> 
                   </div>
              <?php } ?>
               <?php include("inc/alert.php"); ?>
            </div>
             </div>        
                  <div class="box box-bordered box-color">
                     <div class="box-title">
                        
               
                        
                     <h3><i class="fa fa-list"></i>Sale Entry</h3>  
                        
                        
                     </div>
                     
                     <div class="box-content nopadding" >
                        
                        <form action="#" method="POST" class='form-horizontal form-column form-bordered' enctype="multipart/form-data">
                           <div class="row">
                             
                              
                            <div class="col-sm-3">
                                 <div class="form-group">
                                    <label for="textfield" class="control-label col-sm-4">Sale Date <span style="color: red">*</span></label>
                                    <div class="col-sm-8">
   <input type="date" name="saledate" id="saledate" placeholder="Enter Number" class="form-control" required value="<?php echo $saledate; ?>">
                                    </div>
                                 </div>
                              
                              </div>
                                  	<div class="col-sm-3">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">Truck No <span style="color: red">*</span> </label>
																	<div class="col-sm-8">
																		<select name="vehicle_id" id="vehicle_id" class='select2-me' style="width:100%;" onChange="getOwner(this.value);" required>
																			<option value=""> Select </option>
																			<?php $sql = mysqli_query($connection, "Select * from  m_vehicle where status='0' order by vehicle_id");
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
																<div class="col-sm-3">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">Owner Name</label>
																	<div class="col-sm-8">
																		<input type="text" name="owner_name1" id="owner_name1" placeholder="Text input" class="form-control" value="<?php echo $owner_name1; ?>" readonly>
																	</div>
																</div>

															</div>
                            	<div class="col-sm-3">
																			<div class="form-group">
					<label for="textfield" class="control-label col-sm-4" style="color: #F16567">AdBlue </br>
			Stock :<span id="stock1" style="color:red;"></span>	</label>	 
																				<div class="col-sm-8">
												<select name="adblue_id" id="adblue_id" class='select2-me' onchange="getstock(this.value);" style="width:100%;">
												<option value=" "> Select</option>
		<?php	$sql = mysqli_query($connection,"Select * from  m_adblue  order by adblue_id ");
										  while($row= mysqli_fetch_array($sql)) { ?>
											<option value="<?php echo $row['adblue_id']; ?>"><?php echo $row['adblue_name']; ?></option>
								<?php } ?>
							</select>
							<script>
				document.getElementById('adblue_id').value ='<?php echo $adblue_id; ?>';</script>
												</div>
													</div>

																		</div> 	</div>
																		 <div class="row">
																				<div class="col-sm-3">
																			<div class="form-group">
					<label for="textfield" class="control-label col-sm-4" style="color:sienna">Qty</label>
																				<div class="col-sm-8">
					<input type="text" name="qty" id="qty" placeholder="Enter Qty" class="form-control" value="<?php echo $qty; ?>" onchange="getadblueamt();">
										<input type="hidden" name="stock" id="stock" placeholder="Enter Qty" class="form-control" value="<?php echo $qty; ?>" onchange="getadblueamt();">

																				</div>
																			</div>

																		</div>
																			<div class="col-sm-3">
																			<div class="form-group">
					<label for="textfield" class="control-label col-sm-4" style="color:sienna">Rate </label>
																				<div class="col-sm-8">
					<input type="text" name="rate" id="rate" placeholder="Enter AdBlue Rate" class="form-control" value="<?php echo $rate; ?>" onchange="getadblueamt();">
																				</div>
																			</div>
																		</div>
																			<div class="col-sm-3">
																			<div class="form-group">
																				<label for="textfield" class="control-label col-sm-4" style="color:darkcyan"> AdBlue Amount</label>
																				<div class="col-sm-8">
			<input type="text" name="amount" id="amount" placeholder="Text input" class="form-control" value="<?php echo $amount; ?>">
																				</div>
																			</div>

																		</div>
                                   
                          	<div class="col-sm-3">
																			<div class="form-group">
			<label for="textfield" class="control-label col-sm-4"> Payment Mode</label>
												<div class="col-sm-8">
					<select name="payment_mode" id="payment_mode" class='form-control'>
												<option value=" ">Select</option>
												<option value="Cash">Cash </option>
												<option value="Cheque">Cheque  </option>
												<option value="UPI">UPI  </option>
												
												</select>
	<script>document.getElementById('payment_mode').value = '<?php echo $payment_mode; ?>';</script>
																				</div>
											</div>

																		</div>
	</div>
	<div class="row">
                                                      <div class="col-sm-3">
                                                         <div class="form-group">
                     <label for="textfield" class="control-label col-sm-4">Remark </label>
                                                            <div class="col-sm-8">
      <input type="text" name="remark" id="remark" placeholder="Enter Remark" class="form-control" value="<?php echo $remark; ?>">
                                                            </div>
                                                         </div>

                                                      </div>

               </div>

                  

                
                           <div class="row">
                              <div class="col-sm-12">
                                 <div class="form-actions">
                                    <center>
                                 
            <input type="submit" name="submit" id="submit" value="Save" class="btn btn-primary">
                  <a type="button" href="<?php echo $pagename; ?>"class="btn btn-red">Cancel</a>
                                    </center>   
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                     
                     <div class="box box-color box-bordered red">
         <div class="box-title">
         <h3>  <i class="fa fa-table"></i>
               Recent Sale Details</h3>
            
      
               <!--<a href="emp_pay_report.php" class="btn btn-warning" style="float: right">Click Here For All Entry-->
               <!--                  <i class="fa fa-object-group"></i>-->
               <!--               </a> &nbsp;-->
            
            
               <!-- <a href="all-dispatch-entry.php" style="text-align: right" target="_blank">All Record</a> -->
            
            
         <!--<a href="pdf/pdf_payroll.php" class="btn" style="float: right" target="_blank">Pdf -->
         <!--                        <i class="fa fa-file-pdf-o"></i>-->
         <!--                     </a> &nbsp;-->
         <!--      <a href="excel/excel_payroll.php" class="btn btn-warning" style="float: right">Excel-->
         <!--                        <i class="fa fa-file-excel-o"></i>-->
         <!--                     </a> -->
            
         </div>
         <div class="box-content nopadding">
            <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
               <thead>
               <tr>
                  <th>S.No</th>
                
                  <th class='hidden-350'>Sale Date</th>
                  	<th class='hidden-1024'>Truck No.</th>
                  <th>AdBlue Name</th>
               
                  <th class='hidden-1024'>Qty</th>
                 <th>Rate</th>
                 <th>Amount</th>
                 <th>Payment Mode</th>
                  <th>Remark</th>
                  <th>User Name</th>  
                  <th class='hidden-480'>Action</th>
               </tr>
               </thead>
               <tbody>
    <?php
                           $sn=1;
            $sql = mysqli_query($connection,"Select * from  $tblname where consignorid=$consignorid order by $tblpkey desc limit 10");
                                while($row= mysqli_fetch_array($sql)) {
  

   $adblue_name=$cmn->getvalfield($connection,"m_adblue","adblue_name","adblue_id=$row[adblue_id]");
	$vehicle_no = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id=$row[vehicle_id]");
                           $user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
                                 ?>
               <tr>
                  <td><?php echo $sn++;?></td>
                  <td><?php echo dateformatindia($row['saledate']); ?></td>
                  	<td class='hidden-1024'><?php echo $vehicle_no; ?></td>
                  <td><?php echo $adblue_name; ?></td>
                
                  <td><?php echo $row['qty']; ?></td>
              <td><?php echo $row['rate']; ?></td>
               <td><?php echo $row['amount']; ?></td>
                 <td><?php echo $row['payment_mode']; ?></td>
                  <td><?php echo $row['remark']; ?></td>
                 <td><?php echo $user_name; ?></td>
                  <td class='hidden-480'>
   
      <a href="?editid=<?php echo $row['saleid']; ?>" class="btn btn-inverse" rel="tooltip" title="Edit">
         <i class="fa fa-edit"></i>
      </a>
      <a href="<?php echo $pagename ?>" onClick="funDel(<?php echo $row['saleid']; ?>)" class="btn btn-danger" rel="tooltip" title="Delete">
         <i class="fa fa-times"></i>
      </a></td>
               </tr>
               
               <?php } ?>
               </tbody>
            </table>
         </div>
      </div>
                  </div><br/>
               </div>
                              
                              
                              
                              
                              
                           </div>
                     
                           
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            
            
            
            
            
         </div>
      </div>
   </div>

<script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#attendance').click(function(){
    location = 'inventory.php'; 
   });
}); //// End of Wait till page is loaded
</script>
<script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#sale').click(function(){
    location = 'saleentry.php'; 
   });
}); //// End of Wait till page is loaded
</script>
<script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#att_report').click(function(){
    location = 'inventory_report.php'; 
   });
}); //// End of Wait till page is loaded
</script>
<script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#stock').click(function(){
    location = 'stock.php'; 
   });
}); //// End of Wait till page is loaded
</script>
<script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#stockr').click(function(){
    location = 'stock_report.php'; 
   });
}); //// End of Wait till page is loaded
</script>
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

function getstock(id){
     jQuery.ajax({
                    type: 'POST',
                    url: 'ajax/getstock.php',
                    data: 'id=' + id ,
                    dataType: 'html',
                    success: function(data) {
                        // alert(data);
                        	arr=data.split("|");
                 jQuery('#stock').val(arr[0]);
                 jQuery('#stock1').html(arr[1]); 
           
                 
                    }
                }); //ajax close
}
function getadblueamt() {
var stock = document.getElementById("stock").value;
var rate = document.getElementById("rate").value;
    var qty = document.getElementById("qty").value;
    if(stock < qty){
        alert('Quantity is more than Stock');
    }
  var amt=qty *rate ;
     jQuery('#amount').val(amt);
}

  function getOwner(vehicle_id) {
 
            $.ajax({
                type: 'POST',
                url: 'ajax/show_owner.php',
                data: 'vehicle_id=' + vehicle_id,
                dataType: 'html',
                success: function(data) {
                    arr = data.split("|");
                    jQuery('#owner_name1').val(arr[0]);
                }
            }); //ajax close    
        }

    </script>
   
     
    
</body>



</html>
