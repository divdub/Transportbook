<?php
error_reporting(0);
include("adminsession.php");
include("function/sale_function.php");
$tblname = "inv_saleentry";
$tblpkey = "saleid";
$pagename = "sale_entry.php";
$modulename = "Sale Entry";
$duplicate = '';
$privilege_id = $cmn->getvalfield($connection, "user_privilege", "count(privilege_id)", "menu_id='5' && submenu_id='9' && subcat_id=0  && user_id='$user_id'");
$sale_date = date('Y-m-d');

if (isset($_REQUEST['action']))
   $action = $_REQUEST['action'];
else
   $action = 0;
  $keyvalue = $_GET['saleid'];

if (isset($_GET['saleid'])) {
   $keyvalue = $_GET['saleid'];
} else
   $keyvalue = 0;
if (isset($_POST['submit'])) {
   	// echo 'ok';
   $saleid = trim(addslashes($_POST['saleid']));

   $sale_date = $_POST['sale_date'];
   $bill_type = $_POST['bill_type'];
   $billno = $_POST['billno'];
   $customer_id = $_POST['customer_id'];
   $remark = $_POST['remark'];
   $sale_type = $_POST['sale_type'];
   $pay_type = $_POST['pay_type'];

   if ($saleid=='') {
       //echo "INSERT into inv_saleentry set sale_date='$sale_date',bill_type='$bill_type',remark='$remark',sale_type='$sale_type',customer_id='$customer_id',compid='$compid',sessionid='$sessionid',createdby='$createdby',ipaddress='$ipaddress', consignor_id='$consignorid', lastupdated='$lastupdated',createdate='$createdate'";
   	mysqli_query($connection,"INSERT into inv_saleentry set sale_date='$sale_date',bill_type='$bill_type',remark='$remark',sale_type='$sale_type',customer_id='$customer_id',compid='$compid',sessionid='$sessionid',createdby='$createdby',ipaddress='$ipaddress', consignor_id='$consignorid', lastupdated='$lastupdated',createdate='$createdate'");

      $action = 1;
      $process = "insert";
      $keyvalue = mysqli_insert_id($connection);
      mysqli_query($connection, "update inv_saleentrydetail set saleid='$keyvalue' where saleid='0' && comp_id='$compid' && sessionid='$sessionid'");

//   $totalamt = $cmn->gettotalsale($connection, $keyvalue);
//   echo "INSERT into sale_trans set customer_id='$customer_id',transdate='$sale_date',pamount='$totalamt',transtype='debit',purticular='sale',bill_id='$keyvalue'";die;
if($sale_type=='Cash') { 

//   mysqli_query($connection,"insert into payment set paymentdate='$sale_date', customer_id='$customer_id',	
// 	paid_amt='$totalamt',pay_type='$pay_type',iscomp=1,narration='$remark',createdby='$loginid',compid='$compid',createdate='$createdate',
// 	type='sale',ipaddress='$ipaddress',sessionid='$sessionid',saleid='$keyvalue'");
   // $lastid = mysqli_insert_id($connection);
   mysqli_query($connection,"update inv_saleentry set is_paid='1' where saleid='$keyvalue'");
   }
 
  


   echo "<script>location='$pagename?action=$action'</script>";
   } else {



   mysqli_query($connection,"update inv_saleentry set sale_date='$sale_date',sale_type='$sale_type',bill_type='$bill_type', remark='$remark',customer_id='$customer_id',compid='$compid',sessionid='$sessionid',createdby='$createdby',ipaddress='$ipaddress', consignor_id='$consignorid',lastupdated='$lastupdated' WHERE $tblpkey = '$keyvalue'");

      $action = 2;
      $process = "updated";
      $is_paid=$cmn->getvalfield($connection,"inv_saleentry","is_paid","saleid='$keyvalue'"); 
      if($is_paid=='0'){
      if($sale_type=='Cash') { 

        //  mysqli_query($connection,"insert into payment set paymentdate='$sale_date',customer_id='$customer_id',	
        //  paid_amt='$totalamt',pay_type='$pay_type',narration='$remark',createdby='$loginid',compid='$compid',createdate='$createdate',
        //  type='sale',ipaddress='$ipaddress',iscomp=1,sessionid='$sessionid',saleid='$keyvalue'");
         // $lastid1 = mysqli_insert_id($connection);
         mysqli_query($connection,"update inv_saleentry set is_paid='1' where saleid='$keyvalue'");
         } 
         else {

         }
      } else {
         if($sale_type=='Cash') { 
//   mysqli_query($connection,"UPDATE payment set paymentdate='$purchase_date',customer_id='$customer_id', 
//          paid_amt='$totalamt',pay_type='$pay_type', narration='$remark',createdby='$loginid',lastupdated='$createdate',
//          ipaddress='$ipaddress' where saleid='$keyvalue'");
            }  else {
               mysqli_query($connection,"update inv_saleentry set is_paid='0' where saleid='$keyvalue'");
            //   mysqli_query($connection,"delete from payment where saleid='$keyvalue'");
            }
         
         
         }
   
	

   echo "<script>location='$pagename?action=$action'</script>";
   }



//   echo "<script>location='$pagename?action=$action'</script>";
}

if (isset($_GET[$tblpkey])) {
 
   $btn_name = "Update";
 
   $sqledit = "SELECT * from $tblname where $tblpkey = $keyvalue";
     
   $rowedit = mysqli_fetch_array(mysqli_query($connection, $sqledit));
   $saleid =$rowedit['saleid'];
   $billno = $rowedit['billno'];
   $sale_date = $rowedit['sale_date'];
   $disc = $rowedit['disc'];
   $customer_id = $rowedit['customer_id'];
   $sale_type = $rowedit['sale_type'];
//   $pay_type=$cmn->getvalfield($connection,"payment","pay_type","saleid='$keyvalue'"); 

   $remark = $rowedit['remark'];
   $bill_type = $rowedit['bill_type'];
   

} else {
   $sale_date = date('Y-m-d');
   $transport_date = date('Y-m-d');
   $billno  = '';
   $customer_id  = '';

   $bill_type  = 'challan';

   $remark  = '';


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

<body onLoad="showrecord('<?php echo $keyvalue; ?>');">
    
    	<!-- Serial Modal Start-->
	<div class="modal fade" id="modal-snserial" role="dialog">
		<div class="modal-dialog" style="width:480px;padding-top: 225px;">


			<div class="modal-content" style="border-radius: 20px;">
				<div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
					<!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
					<center>
						<h4 class="modal-title"><b>SERIAL  NO<b></h4>
					</center>
				</div>
				<div class="modal-body" style="padding-top:30px;">
					<div class="row mb-3">
						<label for="inputText" class="col-sm-6 control-label" style="font-size:15px;font-weight:bold ;width: 190px;"></label>
						<div class="col-sm-6" id="serialbody1" style="width:100%">
						<h4 class="modal-title" id="myModalLabel"> <span id="m_itemname"></span> </h4>
						</div>
					</div>
					<br>

				
					
					<div class="modal-footer">
					     <input type="hidden" id="m_purdetail_id" value=""  >
						<center>
						    <button type="button" class="btn btn-primary" data-dismiss="modal"><?php if($keyvalue==0){?>Save<?php } else{ ?> Update <?php }?></button>
							<input type="button" data-dismiss="modal" class="btn btn-danger" value="Close">

						
						</center>
					</div>
				</div>

			</div>
		</div>

	</div>
	<!-- Serial Modal End-->
    
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
									<i class="fa fa-bars"></i>Sale Entry
								</h3>
							</div>
							<div class="box-content nopadding">
							    
								<ul class="tabs tabs-inline tabs-top">
							
									<?php $subsn = 1;
							$sql1 = mysqli_query($connection, "select * from user_privilege where menu_id='11' && submenu_id!=0 && subcat_id=0 && user_id='$user_id' order by submenu_id  asc");
							while ($row1 = mysqli_fetch_array($sql1)) { 
								$activity2=$row1['status'];		
								$submenu_id=$row1['submenu_id'];	
								$submenu =$cmn->getvalfield($connection,"m_submenu","submenu","submenu_id='$submenu_id'"); 
							
								$pagelink2 =$cmn->getvalfield($connection,"m_submenu","pagelink","submenu_id='$submenu_id'"); 
								$sub_cat =$cmn->getvalfield($connection,"m_submenu","sub_cat","submenu_id='$submenu_id'");
								
								?>
									<li <?php if($sub_cat==1){ ?> class='active'<?php }?> >
										<a id="<?php echo $pagelink2; ?>" data-toggle='tab'>
											<i class="fa fa-inbox"></i><?php echo ucfirst($submenu); ?></a>
									</li>
									<?php } ?>
									<li>
									
										<li>
										<a id="salereport" data-toggle='tab' style="background: #2563eb; color: #ffffff">
											<i class="fa fa-share"></i>Sale Report</a>
									</li>
									
									
									
					
									
					
								
									<li>
										<a id="paymentreport" data-toggle='tab' style="background: #2563eb; color: #ffffff">
											<i class="fa fa-share"></i>Payment Report</a>
									</li>
									
								

								</ul>
							
								<div class="tab-content padding tab-content-inline tab-content-bottom" id="main1">
									<?php if ($privilege_id == 1) { ?>
										<div class="tab-pane active" id="first11">
											<div class="col-sm-12">
												<div class="row" style="padding-top:20px;">
													<div class="col-sm-12">
														<?php if ($duplicate != '') { ?>
															<div class="alert alert-warning">
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

													<div class="box-content nopadding">

													<form action="#" method="POST" class='form-horizontal form-column form-bordered' enctype="multipart/form-data">
								                      	<div class="row">
															<div class="col-sm-3">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">Date <span style="color: red">*</span></label>
																	<div class="col-sm-8">
	                                                              <input type="date" name="sale_date" id="sale_date" value="<?php echo $sale_date; ?>" placeholder="Text input" class="form-control">

																	</div>
																</div>

															</div>
	<div class="col-sm-3">	
																<div class="form-group" >
																	<label for="textfield" class="control-label col-sm-4" >Customer Name</label>
																	<div class="col-sm-8" >
																	<select name="customer_id" id="customer_id" class="select2-me" style="width:100%;">
                                           		<option value="">-Select-</option>
																		 <?php 
																		 $sql = mysqli_query($connection, "select * from  m_customer  order by cust_name");
                                       while ($row = mysqli_fetch_array($sql)) {

                                       ?>
                                          <option value="<?php echo $row['customer_id']; ?>"><?php echo $row['cust_name']; ?></option>

                                       <?php } ?>
                                           </select>
                                       <script>
                                          document.getElementById('customer_id').value = '<?php echo $customer_id; ?>';
                                       </script>
																	</div>
																</div>

															</div>



															
															
															
															
															
															
															<div class="col-sm-3">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4"> Bill Type<span style="color: red">*</span></label>
																	<div class="col-sm-8">
																	    <select name="bill_type" id="bill_type" class='select2-me'  style="width:100%;" onChange="showgst();">
																	    
																	     <option value="challan">Challan</option>
                                       <option value="Invoice">Invoice</option>
                                     

                                    </select>
                                  <script>
                                       document.getElementById('bill_type').value ='challan';
                                    </script>
																		
																	</div>
																</div>

															</div>

	<div class="col-sm-3">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">Payment Type<span style="color: red">*</span></label>
																	<div class="col-sm-8">
																		 <select name="sale_type" id="sale_type" class="select2-me" style="width:100%;">
                                           		<option value="">-Select-</option>
																			<option value="cash">CASH</option>
																			<option value="credit">CREDIT</option>
                                           </select>
                                           <script>document.getElementById('sale_type').value = '<?php echo $sale_type; ?>'; </script>
																	</div>
																</div>

															</div> 
														
														
													
                                                    	
															</div>
															<div class="row">
															    
															    
															
															<div class="col-sm-3">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">Payment Mode</label>
																	<div class="col-sm-8">
													 <select name="pay_type" id="pay_type" class="select2-me" style="width:100%;">
                                           		<option value="">-Select-</option>
																			<option value="NEFT/Net Banking">NEFT/Net Banking</option>
																			<option value="upi">UPI</option>
																				<option value="cash">CASH</option>
                                           </select>
                                           <script>document.getElementById('pay_type').value = '<?php echo $pay_type ; ?>'; </script>
																	</div>
																</div>

															</div>

															<div class="col-sm-3">
																<div class="form-group">
																	<label for="textfield" class="control-label col-sm-4">Remark</label>
																	<div class="col-sm-8">
																		<input type="text" name="remark" id="remark" value="<?php echo $remark; ?>" placeholder="Text input" class="form-control">
																	</div>
																</div>

															</div>

                                             
														


														

														</div>
															<pre style="font-weight: bold; color: red"></pre>
                                                          <h5 style="color:#FF0000" id="stock"></h5>

															<div>
																<table class="table">
																	<thead style="position: sticky;  top: 0;">

																		<tr>

																			<th>Item</th>
																			
																			<th>Unit</th>
																			<th>HSN Code.</th>
																			<th>Qty</th>
																		    <th id="serialn">Serial No.</th>
																			<th>Rate</th>
																			 <th> Amount</th>
																			<th id="gst1" <?php
                                                                                if ($bill_type == 'Invoice') { ?> style="display:block;" <?php  } else { ?>style="display:none;" <?php } ?>>GST(%)</th>
																			<th>Discount</th>
																			<th>Net Amount</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																		     <input type="hidden" name="stock" id="stockin" value="<?php echo $stock; ?>"  />
																			<td>
																				<select name="iteminv_id" id="iteminv_id" class="select2-me" style="width:100%;" onchange="getunitid();getHsn();getstock();addserial();">
																					<option value="">-Select-</option>
																					<?php
																					$sql = mysqli_query($connection, "select * from m_iteminv");
																					while ($row = mysqli_fetch_assoc($sql)) {

																					?>
																						<option value="<?php echo $row['iteminv_id']; ?>"><?php echo $row['item_name']; ?></option>
																					<?php
																					}
																					?>
																				</select>
																				<script>
																					document.getElementById('iteminv_id').value = '<?php echo $iteminv_id; ?>';
																				</script>


																			</td>
																			<td>	<select name="unitinv_id" id="unitinv_id" class="select2-me" style="width:100%;">
																					<option value="">-Select-</option>
																					<?php
																					$sql = mysqli_query($connection, "select * from m_unitinv");
																					while ($row = mysqli_fetch_assoc($sql)) {

																					?>
																						<option value="<?php echo $row['unitinv_id']; ?>"><?php echo $row['unit_name']; ?></option>
																					<?php
																					}
																					?>
																				</select>
																				<script>
																					document.getElementById('unitinv_id').value = '<?php echo $unitinv_id; ?>';
																				</script>
                                                                               </td> 
                                                                               <input type="hidden" name="iteminv_category_id" id="iteminv_category_id"  style="width:100px;"  value="<?php echo $iteminv_category_id; ?>"  />
																				<td><input type="text" name="hsncode" id="hsncode" class="form-control" value="<?php echo $hsncode ?>"></td>

																			
																			<td><input type="text" name="qty" id="qty" onchange="getdel()" class="form-control" value="<?php echo $qty; ?>"></td>
																			<td id="seriald">
																			     <input type="hidden" id="hiddenid" value="" >  
                                                                                <input type="hidden" id="delserial" value="" >  
																			      <select multiple name="serial" id="serial" placeholder=" Select" style="width:318px;"  onclick="addids();" class="formcent select2-me" >
                         
                              </select>
																			</td>
																			
																			<td><input type="text" name="rate" id="rate" class="form-control" placeholder=" "  onChange="getdel();" value="<?php echo $rate; ?>"></td>
																		 <td> <input type="text" name="total_amt" id="total_amt" class="form-control"   value="<?php echo $total_amt; ?>" onChange="getdel();"  /></td>
																		 
																		 <td id="gst2" <?php
                                                                    if ($bill_type == 'Invoice') { ?> style="display:block;" <?php  } else { ?>style="display:none;" <?php } ?>>
																			    
																			    <select name="gst" id="gst" class="default-select ms-0 form-control" tabindex="14" style="width:100%;" onchange="getdel();">
                                                            <option value="">Select</option>
                                                            <option value="5">5%</option>
                                                            <option value="12">12%</option>
                                                             <option value="14">14%</option>
                                                            <option value="18">18%</option>
                                                            <option value="28">28%</option>
                                                        </select>
                                                        <script>
                                                            document.getElementById('gst').value = '<?php echo $gst; ?>';
                                                        </script></td>
                                                         <td><input type="text" name="disc" id="disc"  class="form-control" onChange="getdel();" value="<?php echo $disc; ?>"/> </td>
                                                           <td style="display:none;"><input type="text" name="nettotal" id="nettotal"   value="<?php echo $nettotal; ?>"  </td>
                                                         <td><input type="text" name="grandtotal" id="grandtotal" class="form-control"  value="<?php echo $grandtotal; ?>"  </td>
																			<td><a class="btn btn-primary" style="width: 50px;" tabindex="27" onclick="getSave();">Add</a></td>
															<input type="hidden" name="saleid" id="saleid" value="<?php echo $saleid; ?>">
                                                                               <input type="hidden" name="iteminv_category_id" id="iteminv_category_id"  class="form-control"  value="<?php echo $iteminv_category_id; ?>"  />
                                                         <input type="hidden" name="saleid1" id="saleid1" value="<?php echo $keyvalue; ?>">
														<input type="hidden" name="saledetail_id" id="saledetail_id"  value="<?php echo $saledetail_id; ?>">
															 
																	</tbody>
																</table>
																<br>
															</div>


													</div>
													
													<div class="box box-color box-bordered red">
												<div class="box-title">
													<h3> <i class="fa fa-table"></i>
														Recent Sale Entry Details

													</h3>


												

												</div>
												<div class="row-fluid">
   	<div class="box-content nopadding" id="showsalerecord">
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

											
											</div><br />
										</div>
									<?php } ?>




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
			$('#salepayment').click(function() {
				$('#main1').load('paysale_entry.php #main', function() {
					jQuery('.select2-me').select2();
					showsalepay()

					/// can add another function here
				});
			});
		}); //// End of Wait till page is loaded
	</script>
	<script type="text/javascript" language="javascript">
		$(document).ready(function() { /// Wait till page is loaded
			$('#sale').click(function() {
				$('#main1').load('sale_entry.php #main1', function() {
					jQuery('.select2-me').select2();
					 showrecord();
				});
			});
		}); //// End of Wait till page is loaded
	</script>
	

	<script type="text/javascript" language="javascript">
		$(document).ready(function() { /// Wait till page is loaded
			$('#paymentreport').click(function() {
				location = 'salepayment_report.php';
			});
		}); //// End of Wait till page is loaded
	</script>

	<script type="text/javascript" language="javascript">
		$(document).ready(function() { /// Wait till page is loaded
			$('#salereport').click(function() {
				location = 'sale_report.php';
			});
		}); //// End of Wait till page is loaded
	</script>
	
	

<script>
$(document).ready(function() {
   $("#<?php echo $variable;?>").trigger('click');
});
</script>
</body>



</html>