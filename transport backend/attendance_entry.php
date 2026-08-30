<?php 
error_reporting(0);
include("adminsession.php");
// include("function/dispatch_function.php");
$tblname = "attendance";
$tblpkey = "attendid";
$pagename = "attendance_entry.php";
$modulename = "Employee Attendance Entry";
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
    $atten_date = $row['atten_date']; 
   $employee_id    = $row['employee_id'];
   $year= $row['year'];
   $month=$row['month'];
   $tno_days=$row['tno_days'];
   $cl_days=$row['cl_days'];
   $a_days=$row['a_days'];
   $total_days=$row['total_days'];
   $remark=$row['remark'];

     }
else
{
   $atten_date = '';
   $employee_id  = '';
   $year = '';
   $month='';
   $tno_days='';
   $cl_days='';
   $a_days='';
   $total_days='';
   $remark='';
 
}
if(isset($_POST['submit']))
{
     $atten_date = $_POST['atten_date'];
    $employee_id =$_POST['employee_id'];
   $year = $_POST['year'];
   $month = $_POST['month'];
   $tno_days = $_POST['tno_days'];
   $cl_days=$_POST['cl_days'];
   $a_days=$_POST['a_days'];
   $total_days=$_POST['total_days'];
   $remark = $_POST['remark'];


   $form_data = array('atten_date'=>$atten_date,'cl_days'=>$cl_days,'a_days'=>$a_days,'total_days'=>$total_days,'employee_id'=>$employee_id,'year'=>$year,'consignorid'=>$consignorid,'month'=>$month,'tno_days'=>$tno_days,'remark'=>$remark,'comp_id'=>$comp_id,'session_id'=>$session_id,'created_date'=>$currentdate,'user_id' => $user_id);
    
   if($keyvalue  == 0)
   {
  
         dbRowInsert($connection,$tblname, $form_data);
         echo "<script>location='$pagename?action=1'</script>";
     
   }
   
   else
   {
      $form_data = array('atten_date'=>$atten_date,'cl_days'=>$cl_days,'a_days'=>$a_days,'total_days'=>$total_days,'employee_id'=>$employee_id,'year'=>$year,'month'=>$month,'consignorid'=>$consignorid,'tno_days'=>$tno_days,'remark'=>$remark,'comp_id'=>$comp_id,'session_id'=>$session_id,'updated_date'=>$currentdate);
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

   <title>PAYROLL :: CHAARUVI INFOTECH PVT. LTD.</title>

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
                           <i class="fa fa-bars"></i>Employee Attendance
</h3>
                     </div>
                     <div class="box-content nopadding">
                        <ul class="tabs tabs-inline tabs-top">
                        <li class='active'>
                              <a id="attendance" data-toggle='tab'>
                                 <i class="fa fa-inbox"></i>Attendance Entry</a>
                           </li>
                           <li >
                              <a id="att_report" data-toggle='tab' style="background: #2563eb; color: #ffffff">
                                 <i class="fa fa-share"></i>Attendance Report</a>
                           </li>
                           <li>
                              <a id="payroll" data-toggle='tab'>
                                 <i class="fa fa-inbox"></i>Payment Entry</a>
                           </li>
                           <li>
                              <a id="report" data-toggle='tab' style="background: #2563eb; color: #ffffff">
                                 <i class="fa fa-share"></i>Payment Report</a>
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
                        
               
                        
                     <h3><i class="fa fa-list"></i>Attendance Entry</h3>  
                        
                        
                     </div>
                     
                     <div class="box-content nopadding" >
                        
                        <form action="#" method="POST" class='form-horizontal form-column form-bordered' enctype="multipart/form-data">
                           <div class="row">
                              
                           <div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Date<span style="color: red">*</span></label>
												<div class="col-sm-8">
												<input type="date" name="atten_date" id="atten_date" placeholder="Total Number Of days in Month"  class="form-control" value="<?php echo $atten_date;?>">
											</select>
												</div>
											</div>
										
										</div>
                              <div class="col-sm-3">
                                 <div class="form-group">
                           <label for="textfield" class="control-label col-sm-4">Employee Name
                          Salary :<span id="sal" style="color:red;"></span></label>
                                    <div class="col-sm-8">
     <select name="employee_id" id="employee_id" class='select2-me' style="width:100%;" required onchange="getsalary(this.value);">
               <option value="">      Select  </option>
      <?php $sql = mysqli_query($connection,"Select * from  m_employee where consignor_id=$consignorid order by employee_id");
                                while($row= mysqli_fetch_array($sql)) { ?>
                                 
                     <option value="<?php echo $row['employee_id']; ?>"><?php echo $row['employee_name']; ?></option>

                     
                        <?php } ?>

                                 </select>
         <script>document.getElementById('employee_id').value = '<?php echo $employee_id ; ?>';</script>
                                    </div>
                                 </div>
                              
                              </div>
                              <div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4"> Year <span style="color: red">*</span></label>
												<div class="col-sm-8">
  <select name="year" id="year" class="form-control" >  
                       <option value="">Select</option>
                        <?php
                        for($i=2024;$i<2030;$i++) {
                        ?>                                 
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                           <?php } ?>                                                                                      
                        </select>
                        <script>document.getElementById('year').value = "<?php echo $year; ?>";</script>

												</div>
											</div>
										
										</div>
											<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4"> Month <span style="color: red">*</span></label>
												<div class="col-sm-8">
                                <select name="month" id="month" class="form-control" onchange="getdays();" >        
                                	<option value="">Select</option>                             
                                    <option value="1">January</option> 
                                    <option value="2">February</option> 
                                    <option value="3">March</option> 
                                    <option value="4">April</option> 
                                    <option value="5">May</option> 
                                    <option value="6">June</option> 
                                    <option value="7">July</option> 
                                    <option value="8">August</option> 
                                    <option value="9">September</option> 
                                    <option value="10">October</option> 
                                    <option value="11">November</option> 
                                    <option value="12">December</option>                                                
                        </select>
                        <script>document.getElementById('month').value = "<?php echo $month; ?>";</script>

												</div>
											</div>
										
										</div>
                                        </div>
                                        <div class="row">
                              <div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Total No. Of Days<span style="color: red">*</span></label>
												<div class="col-sm-8">
												<input type="number" name="tno_days" id="tno_days" placeholder="Total Number Of days in Month" tabindex="5" class="form-control" value="<?php echo $tno_days;?>">
											</select>
												</div>
											</div>
										
										</div>
                                        
                                        <div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Half days </label>
												<div class="col-sm-8">
													<input type="number"   name="cl_days" id="cl_days" placeholder="Number of present days" tabindex="5" class="form-control" value="<?php echo $cl_days;?>" onchange="getTotal();">
												</div>
											</div>
										
										</div>
										         
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4"><span style="color: red">Absent Days*</span></label>
												<div class="col-sm-8">
													<input type="number" name="a_days" id="a_days" placeholder="Number of Leave days" tabindex="6" class="form-control" value="<?php echo $a_days;?>" onchange="getTotal();" >
												</div>
											</div>
										
										</div>
										
										<div class="col-sm-3">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Total Days</label>
												<div class="col-sm-8">
													<input type="text" name="total_days" id="total_days" placeholder="Total days " tabindex="7" class="form-control" value="<?php echo $total_days;?>" readonly> 
												</div>
											</div>
										
										</div>
                                        </div>
                                        <div class="row">
                                                      <div class="col-sm-3">
                                                         <div class="form-group">
                     <label for="textfield" class="control-label col-sm-4">Narration </label>
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
               Recent Attendance Details</h3>
            
      
               <!-- <a href="emp_pay_report.php" class="btn btn-warning" style="float: right">Click Here For All Entry
                                 <i class="fa fa-object-group"></i>
                              </a> &nbsp; -->
            
            
               <!-- <a href="all-dispatch-entry.php" style="text-align: right" target="_blank">All Record</a> -->
            
<!--             
         <a href="pdf/pdf_payroll.php" class="btn" style="float: right" target="_blank">Pdf 
                                 <i class="fa fa-file-pdf-o"></i>
                              </a> &nbsp;
               <a href="excel/excel_payroll.php" class="btn btn-warning" style="float: right">Excel
                                 <i class="fa fa-file-excel-o"></i>
                              </a>  -->
            
         </div>
         <div class="box-content nopadding">
            <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
               <thead>
               <tr>
                  <th>S.No</th>
                  <th class='hidden-350'>Attendance Date</th>
                  <th>Employee Name</th>
                  <th>Year /Month  (Days)</th>
                  <th>Absent Days</th>
					<th>Half Days</th>
					<th>Total Days</th>
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
   $employee_name=$cmn->getvalfield($connection,"m_employee","employee_name","employee_id=$row[employee_id]");
   $user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
   $month=$row['month'];
   if($month=='1') {
        $monthname="January";
   } elseif($month=='2'){
        $monthname="February";
   } elseif($month=='3'){
        $monthname="March";
   }elseif($month=='4'){
        $monthname="April";
   }elseif($month=='5'){
        $monthname="May";
   }elseif($month=='6'){
        $monthname="June";
   }elseif($month=='7'){
        $monthname="July";
   }elseif($month=='8'){
        $monthname="August";
   }elseif($month=='9'){
        $monthname="September";
   }elseif($month=='10'){
        $monthname="October";
   }elseif($month=='11'){
        $monthname="November";
   }elseif($month=='12'){
        $monthname="December";
   }
                           
                           
                           
                           
                           ?>      <tr>
       <td><?php echo $sn++;?></td>
                  <td><?php echo dateformatindia($row['atten_date']); ?></td>
                  <td><?php echo $employee_name; ?></td>
              
                  <td><?php echo $row['year']." / ".$monthname." (".$row['tno_days'].")";?></td> 
                  <td><?php echo $row['a_days'];?></td> 
				 <td><?php echo $row['cl_days'];?></td> 
                 <td><?php echo $row['total_days'];?></td> 
                  <td><?php echo $row['remark']; ?></td>
                 <td><?php echo $user_name; ?></td>
                  <td class='hidden-480'>
   
      <a href="?editid=<?php echo $row['attendid']; ?>" class="btn btn-inverse" rel="tooltip" title="Edit">
         <i class="fa fa-edit"></i>
      </a>
      <a href="<?php echo $pagename ?>" onClick="funDel(<?php echo $row['attendid']; ?>)" class="btn btn-danger" rel="tooltip" title="Delete">
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
   $('#payroll').click(function(){
    location = 'payroll.php'; 
   });
}); //// End of Wait till page is loaded
</script>

<!-- 
<script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#attendance').click(function(){
      $('#main1').load('attendance_entry.php #main1', function() {
         jQuery('.select2-me').select2();
          // jQuery("#advtable").html(data);

           /// can add another function here
      });
   });
}); //// End of Wait till page is loaded
</script> -->
<script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#attendance').click(function(){
    location = 'attendance_entry.php'; 
   });
}); //// End of Wait till page is loaded
</script>
<!-- <script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#att_report').click(function(){
      $('#main1').load('attendance_report.php #main1', function() {
         jQuery('.select2-me').select2();
          // jQuery("#advtable").html(data);

           /// can add another function here
      });
   });
}); //// End of Wait till page is loaded
</script> -->

<script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#report').click(function(){
    location = 'emp_pay_report.php'; 
   });
}); //// End of Wait till page is loaded
</script>

<script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#att_report').click(function(){
    location = 'attendance_report.php'; 
   });
}); //// End of Wait till page is loaded
</script>
<script type="text/javascript">
       
        function getdays(){
var year = document.getElementById("year").value;
var month = document.getElementById("month").value;
// alert(year);

// alert(month);
 tno_days= new Date(year, month, 0).getDate();
 // alert(month);
	jQuery('#tno_days').val(tno_days);
	
}

    </script>
    
    <script type="text/javascript">
        function getsalary(id) {
    //   alert(id);
         
      
                // alert(tableid);
                jQuery.ajax({
                    type: 'POST',
                    url: 'ajaxpayroll/getsalary.php',
                    data: 'id=' + id ,
                    dataType: 'html',
                    success: function(data) {
                        // alert(data);
                        	arr=data.split("|");
                 jQuery('#salary').val(arr[0]);
                 jQuery('#sal').html(arr[1]); 
           
                 
                    }
                }); //ajax close
            
        }

    </script>
     <script type="text/javascript">
       
        
        function getTotal(){
var tno_days = parseFloat(document.getElementById("tno_days").value);
// alert(tno_days);
var a_days = parseFloat(document.getElementById("a_days").value);
// alert(a_days);
var cl_days = parseFloat(document.getElementById("cl_days").value);
// alert(cl_days);
if(isNaN(cl_days)){
    cl_days=0;
}
if(isNaN(a_days)){
    a_days=0;
}

halfday=cl_days/2;
    total_days = tno_days  - a_days - halfday;
   // alert(total_days);
	jQuery('#total_days').val(total_days);

	}
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
