<?php 
// error_reporting(0);
include("adminsession.php");
// include("function/dispatch_function.php");

$pagename = "diesel_cash_book.php";
$modulename = "Bilty Advance Details";

if(isset($_GET['fromdate'])) {
    $fromdate = $_GET['fromdate'];
  }
  else
  $fromdate=date('Y-m-d');

if(isset($_GET['todate'])) {
    $todate =$_GET['todate'];
  }
  else
  $todate=date('Y-m-d');
if(isset($_GET['pump_id'])) {
    $pump_id =$_GET['pump_id'];
  }
  else
  $pump_id='';



	

  $cond="";
  $cond2="";



if($fromdate !='' && $todate !='' ) {
  $cond .= "and bilty_date between '$fromdate' and '$todate' "; 
    $cond1 .= "and rcv_date between '$fromdate' and '$todate' "; 
  
}
if($pump_id !='' ) {
  $cond .= "and pump_id='$pump_id'"; 
    $cond1 .= "and pump_id='$pump_id'"; 
  
// echo $pump_id;
  $openbal = $cmn->getvalfield($connection,"m_petrol_pump","opn_balnc","pump_id='$pump_id'"); 
	 $diesel_open_bal_str = strtotime($cmn->getvalfield($connection,"m_petrol_pump","opn_balnc_date","pump_id='$pump_id'"));
	 	 $opn_balnc_date = $cmn->getvalfield($connection,"m_petrol_pump","opn_balnc_date","pump_id='$pump_id'");
	 $currdate_str = strtotime($fromdate);
	if($currdate_str >= $diesel_open_bal_str)
	{	
// 			$opn_balnc_date =  date('Y-m-d', strtotime($opn_balnc_date . ' +1 day'));
		$currdate = date('Y-m-d', strtotime('-1 day', strtotime($fromdate)));

	$opn_balnc_date =  date('Y-m-d', strtotime($opn_balnc_date . ' +1 day'));
		$tot=0;	
// 	echo	"select * from dieselbill where dbilldate between '$opn_balnc_date' and '$fromdate' && pump_id='$pump_id' && consignorid=$consignorid && sessionid=$session_id"; 
		$sql = mysqli_query($connection,"select * from dieselbill where dbilldate between '$opn_balnc_date' and '$currdate' && pump_id='$pump_id' && consignorid=$consignorid && sessionid=$session_id");
		while($row=mysqli_fetch_assoc($sql))
		{
		     
		      $adv_diesel = $cmn->getvalfield($connection,"dispatch_entry","sum(diesel_adv_amt)","dbillid='$row[dbillid]'"); 
			$tot += $adv_diesel;
// 			echo $adv_diesel.'     ';
			
		}
// 			$tot += $adv_diesel;
// 		echo "ot".$tot."  ";
	
		$tot_pay =0;
// 	echo	"select * from diesel_pay  where rcv_date between '$opn_balnc_date' and '$fromdate' && pump_id='$pump_id' && consignorid=$consignorid && sessionid=$session_id";
		$sql2 = mysqli_query($connection,"select * from diesel_pay  where rcv_date between '$opn_balnc_date' and '$currdate' && pump_id='$pump_id' && consignorid=$consignorid && sessionid=$session_id");
		while($row2=mysqli_fetch_assoc($sql2))
		{
			$tot_pay += $row2['rcv_amt'];
		}
		
			
		$curr_openingbal = $openbal + $tot - $tot_pay ;
		
	}
	else
	{
		$curr_openingbal = $openbal;	
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

	<title> DIESEL CASH BOOK :: CHAARUVI INFOTECH PVT. LTD.</title>

<?php include("inc/top-files.php"); ?>	
</head>

<body>
	    <!-- Edit Modal Start-->
	<div class="modal fade" id="myModal9" role="dialog">
    <div class="modal-dialog" style="width:900px;padding-top: 150px;" >


      <div class="modal-content" style="border-radius: 20px;">
        <div class="modal-header" style="background-color:#29465B;color: white;border-top-left-radius: 18px;border-top-right-radius: 18px;">
          <!-- <a href=""  class="close" data-dismiss="modal" style="color:red;"><b>X<b></a> -->
          <center>
          <h4 class="modal-title"><b>EDIT ADVANCE ENTRY<b></h4></center>
        </div>
        <div class="modal-body" style="padding-top:30px;" id="updatedata">
    
        </div>

      </div>
    </div>

  </div>
  <!-- Edit Modal End-->


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
									<i class="fa fa-list"></i>Diesel Cash Book</h3>
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

										    
									 <div class="col-sm-3">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">Petrol Pump</label>
                                       <div class="col-sm-8">
                                          <select name="pump_id" id="pump_id" class='select2-me' style="width:100%;">
                                             <option value="">      Select  </option>
                                             <?php		$sql = mysqli_query($connection,"Select * from  m_petrol_pump  order by pump_id");
                                                while($row= mysqli_fetch_array($sql)) { ?>
                                             <option value="<?php echo $row['pump_id']; ?>"><?php echo $row['pump_name']; ?></option>
                                             <?php } ?>
                                          </select>
                                          <script>document.getElementById('pump_id').value = '<?php echo $pump_id; ?>';</script>
                                       </div>
                                    </div>
                                 </div>
										
  



                                        
										
										
								
										<div class="col-sm-3">
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
			<h3>			 <strong>Opening Balance: <?php
							 echo number_format($curr_openingbal,2);?></strong>	</h3>
							 <a onclick="getwhatsapp('<?php echo $fromdate; ?>','<?php echo $todate; ?>','<?php echo $pump_id; ?>');"  style="float: right"><img src="img/whatsapp.png" style="width:30px;height:30px;">
                                          </a>
				
			 <?php if($pump_id !=''){ ?>          <a href="pdf_diesel_cash_book.php?fromdate=<?php echo $fromdate ?>&todate=<?php echo $todate ?>&pump_id=<?php echo $pump_id ?>" class="btn btn-warning" style="float: right" target="_blank">Pdf
                              <i class="fa fa-file-pdf-o"></i>
                              </a> 
                              
                             <a href="excel_dieselcashbook.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&pump_id=<?php echo $pump_id ?>" class="btn btn-success" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a>
                              
                                <a href="pdf_diesel_cashbook.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&pump_id=<?php echo $pump_id ?>" class="btn btn-primary" style="float: right" target="_blank">Pdf
											<i class="fa fa-file-excel-o"></i>
										</a>    
                              
                              
                              <?php } ?>
                              
                           <!--     <a  style="float:right;  " href="pdf_comoany_cash_book.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>" target="_blank"> 

                               	<button class="btn btn-primary right" >PDF</button></a> -->
                          
				<!-- 	<button class="btn btn-warning" style="float: right">Click Hear For All Entry
											<i class="fa fa-object-group"></i>
										</button> &nbsp;
				 -->
				
				
				
			<!-- 	
			<a href="pdf/pdf_dispatch_advance.php" class="btn" style="float: right" target="_blank">Pdf 
											<i class="fa fa-file-pdf-o"></i>
										</a> &nbsp;
					<a href="excel/excel_dispatch_advance.php" class="btn btn-warning" style="float: right">Excel
											<i class="fa fa-file-excel-o"></i>
										</a> 	 -->
				
			</div>
			<div class="box-content nopadding">
					<div class="col-sm-6">
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-bar-chart-o"></i>
									Diesel Bill
								</h3>
							
							</div>
			    
                           
                           
                               
                                    <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
                                        <thead>
                                       
                                            <tr>
                                                   <th>Sno</th>  
                                            <th>Invoice No</th>
                                          <th>Bilty Date</th>
                                             <th>TRUCK NO</th> 
                                            <th>Diesel  Advance</th>
                                          
                                            </tr>
                                        </thead>
                                        <tbody>
                                             <?php
                                          $sn=1;
                                        //   echo	"Select * from  dispatch_entry where consignor_id=$consignorid && session_id=$session_id $cond order by bilty_date desc";
                                         $sql = mysqli_query($connection,"Select * from  dispatch_entry where consignor_id=$consignorid && session_id=$session_id $cond order by bilty_date desc");
                                          	  while($row= mysqli_fetch_array($sql)) {
                                        				// $amount = $cmn->getinvoiceamount($connection,$row['dbillid']);
                                    //   $adv_diesel = $cmn->getvalfield($connection,"dispatch_entry","sum(diesel_adv_amt)","dbillid='$row[dbillid]'"); 
                                    	$truckno = $cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id='$row[vehicle_id]'");
                                          	   ?>
                                            	<tr>
                                                    <td><?php echo $sn; ?></td>
                                            <td><?php echo ucfirst($row['invoice_no']);?></td>
                                            <td><?php echo $cmn->dateformatindia($row['bilty_date']);?></td>
                                             <td><?php echo $truckno;?></td> 
                                            <td><?php echo number_format($row['diesel_adv_amt'],2);?></td>
                                                </tr>
                                            
                                            <?php
											$netbilty += $row['diesel_adv_amt'];
											$sn++;
											}
											?>
                                            
                                       
                                        </tbody>
                                        <tfoot class="bg-light-blue">
                                           <tr>
                                                                                                
                                                <th colspan="4" style="text-align:right">Total</th>                                                
                                                                                              
                                                <th  style="text-align:right"><i class="fa fa-inr"></i> <?php echo number_format(round($netbilty),2); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
</br></br>

                       

                        </div></div>
                        		<div class="col-sm-6">
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-bar-chart-o"></i>
									Diesel Bill Payment
								</h3>
							</div>
			    
                           
                           
                               
                                    <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
                                        <thead>
                                       
                                            <tr>
                                                 <th>S.No</th>
                           <th>Bill No.</th>
                           <th>Paid Date</th>
                        
                           <th>Paid Amount</th>
                            <th>Payment Mode</th> 
                           <th>Remark</th>
                                                
                                               	
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php
									$sn=1;
								// 	echo "Select * from  diesel_pay where consignorid=$consignorid && sessionid=$session_id $cond1 order by dpayid desc" ;
				$sql = mysqli_query($connection,"Select * from  diesel_pay where consignorid=$consignorid && sessionid=$session_id $cond1 order by dpayid desc");
										  while($row= mysqli_fetch_array($sql)) {
                                 $invno = $cmn->getvalfield($connection,"dieselbill","dbillno","dbillid='$row[dbillid]'");
							   ?>
                                            	<tr>
                                                      <td><?php echo $sn++;?></td>
						
						<td><?php echo $invno; ?></td>
						<td><?php echo dateformatindia($row['rcv_date']); ?></td>
                
                  <td class='hidden-350'><?php echo $row['rcv_amt']; ?></td>    <td class='hidden-350'><?php echo $row['pay_mode']; ?></td>  
                  <td class='hidden-350'><?php echo $row['bill_remark']; ?></td>   
                        
                                                    
                                                </tr>
                                            
                                            <?php
											$gtotal += $row['rcv_amt'];
											}
											?>
                                            
                                       
                                        </tbody>
                                        <tfoot class="bg-light-blue">
                                           <tr>
                                                                                                
                                                <th colspan="5" style="text-align:right">Total</th>                                                
                                                                                              
                                                <th  style="text-align:right"><i class="fa fa-inr"></i> <?php echo number_format(round($gtotal),2); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
</br></br>

                       

                        </div></div>
                                  <?php $balamt = $curr_openingbal + $netbilty - $gtotal; 
					 ?>    
                    <table class="table" width="99%" border="1"   style="font-size:14px; margin-right: 10px; margin-left: 10px;" >
                        	<tr bgcolor="#CCCCCC">
                            	<td>&nbsp;   </td><td>&nbsp;   </td>
                            	<td align="right"><strong>Balance Amt : <i class="fa fa-inr"></i> <?php echo number_format(round($balamt),2); ?></strong></td>
                            </tr>
                           
                        </table>
                                             
			</div>
		</div>
						</div>
					</div>
				</div>
				
				
				
				
				
			</div>
		</div>
	</div>
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
						<input type="hidden" name="w_category" id="w_category" class="form-control" value="" style="font-weight:bold; " autocomplete="off" readonly>

                            <input type="text" name="w_bill_name" id="w_bill_name" class="form-control" value="" style="font-weight:bold; " autocomplete="off" >
                            <!--<input type="hidden" name="w_owner_id" id="w_owner_id" class="form-control" value="" style="font-weight:bold; " autocomplete="off" readonly>-->

                           </td>

						<td>
                        <input type="number" name="w_mobile" id="w_mobile" placeholder="Mobile No" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" value="<?php echo $w_mobile; ?>" required>              
                 <!-- <input type="text" name="w_mobile" id="w_mobile" class="form-control" value="" style="font-weight:bold; " autocomplete="off"> -->
						<!--<input type="hidden" name="w_billid" id="w_billid" class="form-control" value="" style="font-weight:bold; " autocomplete="off">-->
                    </td>


					</tr>
				
                 

					<!--<tr>-->
     <!--               <input type="checkbox" name="numupdate" id="numupdate" value="1"  style="width:18px;"/>  <span style="font-size:16px;margin-top:10px;"> &nbsp; Update Mobile Number</span>  -->
                    <!-- <input type="checkbox" id="layername1" name="layername" value="Drone Image" onclick="showLayerMap(1);"  /> -->
     <!--               </tr>-->
				
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" name="s_save" id="s_save" onClick="sendfile();">Send</button>
				<button data-dismiss="modal" class="btn btn-danger">Close</button>
				<input type="hidden" id="s_saleid" value="">

			</div>
		</div>

    </div>
    <script>
    function getwhatsapp(fromdate,todate,pump_id){
    $.ajax({
        type: 'POST',
        url: 'pdf_diesel_whatsapp.php',
        data: {
            fromdate: fromdate,
            todate: todate,
            pump_id: pump_id
        },
        dataType: 'html',
        success: function(data){
            alert(data);
            $('#myModal_whatsapp').modal('show');
        },
        error: function(xhr, status, error){
            console.log(xhr.responseText);
            console.log(error);
        }
    });
}

function sendfile(){
	var fromdate = document.getElementById('fromdate').value;
            var mobile = document.getElementById('w_mobile').value;
           
            var bill_name = document.getElementById('w_bill_name').value;

            

if(mobile==''){
    alert("Please Enter Mobile No.");
    return false;
}

jQuery.ajax({
type: 'POST',
url: 'whatsappreport.php',
data: 'mobile='+mobile+'&bill_name='+bill_name+'&fromdate='+fromdate,
dataType: 'html',
success: function(data){
	jQuery("#myModal_whatsapp").modal('hide');
document.getElementById('msg').innerHTML = 'Sent';

}

});//ajax close
}
</script>
	
</body>



</html>
