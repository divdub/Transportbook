<?php 
error_reporting(0);
include("adminsession.php");
$pagename = "tyre_opening_record.php";
$modulename = "Truck-Tyre-Mapping Details";
include("function/tyreissue_function.php");

if(isset($_GET['search']))
{
	 $vehicle_id = addslashes(trim($_GET['vehicle_id']));
	 $typeid = $cmn->getvalfield($connection,"m_vehicle","vehicle_type_id","vehicle_id = '$vehicle_id'"); 
	  $noofwheels = $cmn->getvalfield($connection,"m_vehicle_type","no_of_wheels","vehicle_type_id ='$typeid'"); 
//  	 $typos=$_GET['id'];
 	 $typos= $cmn->getvalfield($connection,"tyre_map","typos","vehicle_id='$vehicle_id'");
	  $rpos_id = $cmn->getvalfield($connection,"tyre_map","pos_id","vehicle_id='$vehicle_id' && typos='1' && is_remove='0'");
	  $serial_no = $cmn->getvalfield($connection,"purchaseorderserial","serial_no","pos_id='$rpos_id'");
	  $item_id = $cmn->getvalfield($connection,"purchaseorderserial","iteminv_id","pos_id='$rpos_id'");
      $itemname = $cmn->getvalfield($connection,"m_iteminv","item_name","iteminv_id='$item_id'");
   $old_tyre_name= $serial_no;
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

	<title> Truck-Tyre-Mapping:: CHAARUVI INFOTECH PVT. LTD.</title>

<?php include("inc/top-files.php"); ?>	
</head>

<body>



	<?php include("inc/model.php"); ?>
	
	<?php include("inc/top-header.php"); ?>
	
	
	<div class="container-fluid nav-hidden" id="content" >
		
		
		
		
		<div id="main">
			<div class="container-fluid" style="display: flex; flex-direction: row; gap: 20px;">
				
			
				
				<img src="image/wheels2.png" style="width: 15%; height: 20%; margin-left:-220px; margin-top:120px"  />
				<div class="row">
					<div class="col-sm-12">
						<div class="box box-bordered box-color satblue">
							<div class="box-title">
								<h3>
									<i class="fa fa-list"></i> Truck-Tyre-Mapping

								  </h3>
								  
								  		
							</div>
							
							<div class="box-content nopadding">
								<form action="#" method="GET" class='form-horizontal form-column form-bordered'>
									<div class="row">
									
										
									
										     <div class="col-sm-3">
                                    <div class="form-group">
                                       <label for="textfield" class="control-label col-sm-4">Truck No.</label>
                                       <div class="col-sm-8">
                                          <select name="vehicle_id" id="vehicle_id" class='select2-me' style="width:100%;">
                                             <option value="">      Select  </option>
                                             <?php		$sql = mysqli_query($connection,"Select * from  m_vehicle  order by vehicle_id");
                                                while($row= mysqli_fetch_array($sql)) { ?>
                                             <option value="<?php echo $row['vehicle_id']; ?>"><?php echo $row['vehicle_no']; ?></option>
                                             <?php } ?>
                                          </select>
                                          <script>document.getElementById('vehicle_id').value = '<?php echo $vehicle_id; ?>';</script>
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
							
							
							<div class="box box-color box-bordered red">
			<div class="box-title">
			<h3>	<i class="fa fa-table"></i>
				Truck-Tyre-Mapping Detail </h3>
				
		<a href="vehicle_tyre_report.php?vehicle_id=<?php echo $vehicle_id; ?>&typos=<?php echo $typos; ?>&compid=<?php echo $compid; ?>&sessionid=<?php echo $sessionid; ?>" target="_blank" class="btn btn-warning" style="float: right">Report
											<i class="fa fa-file-excel-o"></i>
										</a> 
			</div>
			<div class="box-content nopadding">
			
                              
                            <fieldset>
                             
                              <div style="overflow-x: auto; width: 100%;">
                              <table class="table table-hover table-nomargin table-striped table-bordered dataTable">
                              <tr bgcolor="#CCCCCC">
                               <th><strong>Location</strong></th>
                                <th><strong>Issue Cate.</strong></th>
                                <th><strong>Tyre Name</strong></th>
                                <th style ="width:10%"><strong>Serial No:</strong></th>
                                <th><strong>Meter Reading</strong></th>
                                <th><strong>Upload Date:</strong></th>
                               
                                <th><strong>Tyre New Img:</strong></th>
                                <th><strong>Old Tyre (Serial No.)</strong></th>

                                <th><strong>Return Cate.</strong></th>
                                 <th><strong>Tyre Old Img:</strong></th>
                                <th><strong>Action</strong></th>
                              </tr>
                              <?php	
							  $tyre_id ="";
							  for($i = 1;$i<=$noofwheels ; $i++)
							  {
								$mpid="";
								$tid="";
								$desc="";
								$uploaddate=date('Y-m-d');
								$mapping_remark="";
								$mtrd="";
							
								$data_fetch=mysqli_query($connection,"SELECT * FROM tyre_map where vehicle_id='$vehicle_id' and typos='$i'");
								$rowcount = mysqli_num_rows($data_fetch);
								
								$row_fetch=mysqli_fetch_array($data_fetch);
								$mpid=$row_fetch['mapid'];
								$tid=$row_fetch['tid'];
								$desc= ''; //$cmn->getvalfield($connection,"tyre_purchase","tdescription","tid = '$tid'");
								$uploaddate = !empty($row_fetch['uploaddate']) ? $row_fetch['uploaddate'] : date('Y-m-d');
								$mtrd=$row_fetch['meterreading'];
									$mapping_remark=$row_fetch['mapping_remark'];
								$tyre_id = $tid.",".$tyre_id;
								
								  $rpos_id = $cmn->getvalfield($connection,"tyre_map","pos_id","vehicle_id='$vehicle_id' && typos='$i' && is_remove='0'");
	  $serial_no = $cmn->getvalfield($connection,"purchaseorderserial","serial_no","pos_id='$rpos_id'");
	  $item_id = $cmn->getvalfield($connection,"purchaseorderserial","iteminv_id","pos_id='$rpos_id'");
      $itemname = $cmn->getvalfield($connection,"m_iteminv","item_name","iteminv_id='$item_id'");
   $old_tyre_name= $serial_no;
								
							  ?>
                               <form action="save_tyreissue.php" method="POST" enctype="multipart/form-data">
                                   <input type="hidden" name="vehicle_id" id="vehicle_id" value="<?php echo $vehicle_id; ?>">
                                    <?php if ($vehicle_id!= '') { ?>
                              <tr>
                                <td align="center"><strong>
                                    
                                    <?php echo $i; ?></strong>  
                                
                                <input type="hidden" name="typos[]" id="typos<?php echo $i; ?>" value="<?php echo $i; ?>"></td>
                                <td align="center">
                             
                                    <select id="issue_cate<?php echo $i; ?>" name='issue_cate' class="select2-me" >
                                 	<option value="">--</option>
                                 	<option value="New Item">New Item</option>
                                    <option value="Repair">Repair</option>
                                      <option value="Exchange">Exchange</option>
                                     
                                 </select>                             
                                 <script>
                                  $(document).ready(function() {
            $('#issue_cate').select2(); // Initialize Select2
            $('#issue_cate').val('<?php echo $issue_cate; ?>').trigger('change'); // Set selected value
        });
                                	
				  </script>			
									
                                </td>
                                <td align="center"><select  name="iteminv_id" id="iteminv_id<?php echo $i; ?>" class="select2-me"  onchange="getissue(<?php echo $i; ?>);">
            <option value="">Select</option>
            <?php 
            $sql = mysqli_query($connection, "select * from m_iteminv where iteminv_category_id=5");
            while ($row = mysqli_fetch_array($sql)) { ?>
                <option value="<?php echo $row['iteminv_id']; ?>"><?php echo $row['item_name']; ?></option>
            <?php } ?>
        </select>
        <script>
        $(document).ready(function() {
            $('#iteminv_id').select2(); // Initialize Select2
            $('#iteminv_id').val('<?php echo $iteminv_id; ?>').trigger('change'); // Set selected value
        });</script>
       </td>
                                <td align="center"><select  name="pos_id" id="pos_id<?php echo $i; ?>"  class="select2-me"  style ="width:80%">
                  
                    
                   
                  </select> 
                  <script>
        $(document).ready(function() {
            $('#pos_id').select2(); // Initialize Select2
            $('#pos_id').val('<?php echo $pos_id; ?>').trigger('change'); // Set selected value
        });
    </script></td>
                                <td align="center"><input type="text" name="meterreading" id="meterreading<?php echo $i; ?>" class="form-control" value="<?php echo $mtrd; ?>"></td>
                                <td align="center"> <input type="date" id="uploaddate" name="uploaddate" class="form-control" value="<?php echo $uploaddate; ?>"></td>
                                <td align="center"><input type="file" name="tyre_new_image" id="tyre_new_image" value="" style="width:100%;"></td>
                                <td align="center"> <input type="text" name="old_tyre_name" id="old_tyre_name" class="form-control"  value="<?php echo $old_tyre_name; ?>"></td>
                                <td align="center"><input type="hidden" name="rpos_id" id="rpos_id" class="form-control" value="<?php echo $rpos_id ?>" >
                                <select id="return_cate" name='return_cate' class="select2-me" onChange="showItems(this.value)" >
                                 	<option value="">--</option>
                                 	
                                    <option value="Repaired">Repairable</option>
                                      <option value="Exchange">Exchange</option>
                                      <option value="Scrap">Scrap</option>
                                 </select>
                                </td>
                                <td align="center"><input type="file" name="tyre_old_image" id="tyre_old_image" style="width:100%;"></td>
                                <td align="center"><button type="submit" name="SAVE" class="btn btn-lime">Save</button></td>
                              </tr>
                              </form>
                              <?php
							  }}
							  ?>
                            </table>
                            </div>
                            <br>
							
                               
                                  
                            </fieldset>
                            
			</div>
		</div>
						</div>
					</div>
				</div>
				
				
				
				
				
			</div>
		</div>
	</div>
	   
</body>


</html>
