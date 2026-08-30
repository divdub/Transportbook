<?php
error_reporting(0);
   include("adminsession.php");
   // include("function/document_function.php");
   
   if ($_GET['vehicle_id'] != '') {
   	$vehicle_id = $_GET['vehicle_id'];
   }
   $owner_id = $cmn->getvalfield($connection,"m_vehicle","owner_id","vehicle_id='$vehicle_id' && status=0");
   $vehicle_type_id = $cmn->getvalfield($connection,"m_vehicle","vehicle_type_id","vehicle_id='$vehicle_id' && status=0");
    $owner_name = $cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id='$owner_id'");
    $vehicle_type = $cmn->getvalfield($connection,"m_vehicle_type","vehicle_type","vehicle_type_id='$vehicle_type_id'");
   $no_of_wheels = $cmn->getvalfield($connection,"m_vehicle_type","no_of_wheels","vehicle_type_id='$vehicle_type_id'");
   $vtype=$vehicle_type."-".$no_of_wheels;
   
   
   
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
      <title> DOCUMENT ENTRY</title>
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
               <i class="fa fa-bars"></i>Documents
            </h3>
         </div>
         <div class="box-content nopadding">
            <ul class="tabs tabs-inline tabs-top">
               <li class='active'>
                  <a id="document" data-toggle='tab'>
                  <i class="fa fa-inbox"></i>Vehicle Documents</a>
               </li>
              
               <li>
                	<a id="report" data-toggle='tab' style="background: #2563eb; color: #ffffff>
					<i class="fa fa-share"></i>Document Report</a>
               </li>
               
            </ul>
            <div class="tab-content padding tab-content-inline tab-content-bottom">
               <div class="tab-pane active" id="first11">
                  <div class="col-sm-12">
                     <div class="box box-bordered box-color">
                        <div class="box-title">
                           <h3>
                              <i class="fa fa-list"></i>Vehicle Document Master
                           </h3>
                        </div>
                        <div class="box-content nopadding">
                           <!-- <form  class='form-horizontal form-column form-bordered'> -->
                           <div class="row" >
                              <div class="col-sm-4"style="margin-top:15px;">
                                 <div class="form-group">
                                    <label for="textfield" class="control-label col-sm-4" style="font-weight: bold;">Vehicle No.<span style="color: red">*</span></label>
                                    <div class="col-sm-8">
                                       <select id="vehicle_id" name="vehicle_id" onChange="getDetails(this.value);" tabindex="1" class="formcent select2-me" style="width:200px"  required>
                                          <option value="">Select</option>
                                          <?php	$sql = mysqli_query($connection,"Select * from  m_vehicle  order by vehicle_id ");
                                             while($row= mysqli_fetch_array($sql)) { ?>
                                          <option value="<?php echo $row['vehicle_id']; ?>"><?php echo $row['vehicle_no']; ?></option>
                                          <?php } ?>
                                       </select>
                                       <script>
                                          document.getElementById('vehicle_id').value = '<?php echo $vehicle_id; ?>';
                                       </script>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-4" style="margin-top:15px;">
                                 <div class="form-group">
                                    <label for="textfield" class="control-label col-sm-4" style="font-weight:bold;">Owner Name </label>
                                    <div class="col-sm-8">
                                       <input type="text" name="" id="owner_id" placeholder="Text input" onChange="getDetails(this.value);" tabindex="2" class="form-control" value="<?php echo $owner_name; ?>" readonly>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-4" style="margin-top:15px;">
                                 <div class="form-group">
                                    <label for="textfield" class="control-label col-sm-4" style="font-weight:bold;">Vehicle Type</label>
                                    <div class="col-sm-8">
                                       <input type="text" name="" id="vehicletype_id" placeholder="Text input" onChange="getDetails(this.value);" tabindex="3" class="form-control" value="<?php echo  $vtype; ?>"readonly>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-12">
                                 <div class="form-actions">
                                    <table class="table table-hover table-nomargin">
                                       <thead>
                                          <tr>
                                             <th>Documents </th>
                                             <th>Issue Date</th>
                                             <th>Expiry Date</th>
                                             <th>Upload Document</th>
                                             <th>Action</th>
                                             <th>Download</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php
                                             $sql = mysqli_query($connection, "select * from m_doc_cat order by doccat_id asc");
                                             
                                             while ($row = mysqli_fetch_array($sql)) {
                                             
                                             $docid =$row['doccat_id'];
                                             
                                             $issue_date = $cmn->getvalfield($connection, "truck_doc", "issue_date", "doccat_id='$docid' && vehicle_id='$vehicle_id'");
                                             
                                             $expiry_date = $cmn->getvalfield($connection, "truck_doc", "expiry_date", "doccat_id='$docid' && vehicle_id='$vehicle_id'");
                                                $doc_img = $cmn->getvalfield($connection, "truck_doc", "doc_img", "doccat_id='$docid' && vehicle_id='$vehicle_id'");
                                             
                                             ?>
                                          <form action="save_document.php" method="POST" enctype="multipart/form-data">
                                             <?php if ($vehicle_id != '') {
                                                ?>
                                             <tr>
                                                <td><strong><?php echo $row['catname'];
                                                   ?></strong>
                                                   <input type="hidden" name="doccat_id" value="<?php echo $row['doccat_id']; ?>" class="form-control" style="width:180px">
                                                   <input type="hidden" name="vehicle_id" value="<?php echo $vehicle_id; ?>" class="form-control" style="width:180px">
                                                </td>
                                                <td>
                                                   <input type="date" name="issue_date" id="issue_date<?php echo $row['doccat_id']; ?>" value="<?php echo $issue_date; ?>" tabindex="4" class="form-control" style="width:180px" required>
                                                </td>
                                                <td>
                                                   <input type="date" name="expiry_date" id="expiry_date<?php echo $row['doccat_id']; ?>" value="<?php echo $expiry_date; ?>" tabindex="5" class="form-control" style="width:180px" required>
                                                </td>
                                                <td>
                                                   <input type="file" name="doc_img" id="doc_img<?php echo $row['doccat_id']; ?>" value="upload/doc_upload/<?php echo $doc_img; ?>" class="form-control" tabindex="6" autocomplete="off" >
                                                   <?php if($doc_img!=''){ ?>
                                                   <span><img style="width: 80px; height: 80px;border-radius: 10px;" src="upload/doc_upload/<?php echo $doc_img ?>" alt="<?php echo $doc_img; ?>" /></span>
                                               <?php } ?>
                                                </td>
                                                <td>
                                                   <?php
                                                      //  $count1 = $cmn->getvalfield($connection, "document_renawal", "count(doc_id)", "dre_id= $row[doc_id]");
                                                      if ($issue_date == '') {
                                                      ?>
                                                   <button type="submit" name="submit" class="btn btn-lime" tabindex="7">
                                                   Save</button>
                                                   <?php } else { ?>
                                                   <button type="submit" name="submit" class="btn btn-lime" tabindex="8">
                                                   Update</button>
                                                   <?php } ?>
                                                </td>
                                                <td>
                                                  <!--  <?php
                                                      //  $count2 = $cmn->getvalfield($connection, "document_renawal", "count(document_name)", "dre_id= $row[doc_id]");
                                                      if ($document_name != '') {
                                                      ?>
                                                   <a href="uploaded/document/<?php echo $document_name; ?>" tabindex="9" class="btn btn-success" download> Download <i class="fa fa-download"></i></a>
                                                   <?php } else { ?>
                                                   <button class="btn btn-success" disabled>
                                                   Download <i class="fa fa-download"></i></button>
                                                   <?php } ?> -->
                                                   <a href="upload/doc_upload/<?php echo $doc_img; ?>" target="_blank" download><img src="img/download.png"/></a>
                                                </td>
                                             </tr>
                                          </form>
                                          <?php }
                                             } ?>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                           <!-- </form> -->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script>
         function getDetails(vehicle_id) {
         	
         	location = 'documents.php?vehicle_id=' + vehicle_id;
         }
         
         // datatables
         $(document).ready(function() {
         	$('#Vehicle').DataTable();
         });
      </script>
  <script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#report').click(function(){
    location = 'document_report.php'; 
   });
}); //// End of Wait till page is loaded
</script>
<script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#document').click(function(){
    location = 'documents.php'; 
   });
}); //// End of Wait till page is loaded
</script>
   </body>
</html>