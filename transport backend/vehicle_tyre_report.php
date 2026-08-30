<?php 
   error_reporting(0);
   include("adminsession.php");
   $tblname = "truck_doc";
   $tblpkey = "tdoc_id";
   $pagename = "document_report.php";
   $modulename = "Dispatch Entry";
   $crit="";

   if (isset($_GET['vehicle_id'])) {
   	$vehicle_id = trim(addslashes($_GET['vehicle_id']));
   } else
   	$vehicle_id = '';
   
   
      if (isset($_GET['typos'])) {
   	$typos = trim(addslashes($_GET['typos']));
   } else
   	$typos = '';
   
  
   if ($vehicle_id != '') {
   	$crit .= " where vehicle_id='$vehicle_id'";
   }
   
   
   if ($typos != '') {
   	$crit .= " and typos='$typos'";
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
      
      <style>
    table.report-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    table.report-table th, table.report-table td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
    }

    table.report-table thead {
        background-color: #343a40;
        color: #fff;
    }

    table.report-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    table.report-table tbody tr:hover {
        background-color: #e0f7fa;
    }

    .active-row {
        background-color: #d4edda !important;
        font-weight: bold;
        border-left: 5px solid #28a745;
    }

    .download-link {
        color: #007bff;
        font-weight: bold;
        text-decoration: none;
    }

    .download-link:hover {
        text-decoration: underline;
    }
</style>
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
                        
                       
                        <div class="box box-color box-bordered red">
                           <div class="box-title">
                              <h3>	<i class="fa fa-table"></i>
                                  Truck-Tyre-Mapping  List
                              </h3>
                            
                           </div>
                           <div class="box-content nopadding">
                          <table class="report-table">
    <thead>
        <tr>
            <th>S.No</th>
            <th>Location</th>
            <th>Issue Category</th>
            <th>Tyre Name</th>
            <th>Serial No.</th>
            <th>Meter Reading</th>
            <th>Upload Date</th>
            <th>Return Category</th>
            <th>Tyre New Image</th>
            <th>Tyre Old Image</th>
            <th>Old Tyre Name</th>
            <th>Old Tyre Serial No.</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $slno = 1;
        $sel = "select * from tyre_map where vehicle_id = '$vehicle_id' && sessionid='$sessionid' && compid='$compid' ORDER BY typos, mapid DESC";
        $res = mysqli_query($connection, $sel);

        while ($row = mysqli_fetch_array($res)) {
            $serial_no = $cmn->getvalfield($connection, "purchaseorderserial", "serial_no", "pos_id='$row[pos_id]'");
            $itemname = $cmn->getvalfield($connection, "m_iteminv", "item_name", "iteminv_id='$row[iteminv_id]'");
            $item_id = $cmn->getvalfield($connection, "purchaseorderserial", "iteminv_id", "pos_id='$row[rpos_id]'");
            $old_serial_no = $cmn->getvalfield($connection, "purchaseorderserial", "serial_no", "pos_id='$row[rpos_id]'");
            $old_itemname = $cmn->getvalfield($connection, "m_iteminv", "item_name", "iteminv_id='$item_id'");

            // Active tyre highlight (is_remove = 0 means still in use)
            $row_class = ($row['is_remove'] == 0) ? 'active-row' : '';
        ?>
        <tr class="<?php echo $row_class; ?>">
            <td><?php echo $slno++; ?></td>
            <td><?php $position = '';
switch ($row['typos']) {
    case 1: $position = "Front Left"; break;
    case 2: $position = "Front Right"; break;
    case 3: $position = "Front Single Left"; break;
    case 4: $position = "Front Single Right"; break;
    case 5: $position = "Lefter Left"; break;
    case 6: $position = "Lefter Right"; break;
    case 7: $position = "Crown Left 1"; break;
    case 8: $position = "Crown Left 2"; break;
    case 9: $position = "Crown Right 1"; break;
    case 10: $position = "Crown Right 2"; break;
    case 11: $position = "Dumy Left 1"; break;
    case 12: $position = "Dumy Left 2"; break;
    case 13: $position = "Dumy Right 1"; break;
    case 14: $position = "Dumy Right 2"; break;
}
echo $position; ?></td>
            <td><?php echo $row['issue_cate']; ?></td>
            <td><?php echo $itemname; ?></td>
            <td><?php echo $serial_no; ?></td>
            <td><?php echo $row['meterreading']; ?></td>
            <td><?php echo dateformatindia($row['uploaddate']); ?></td>
            <td><?php echo $row['return_cate']; ?></td>

            <td>
                <?php if ($row['tyre_new_image']) { ?>
                    <a href="uploaded/newtyre/<?php echo $row['tyre_new_image']; ?>" class="download-link" target="_blank" download>Download</a>
                <?php } ?>
            </td>

            <td>
                <?php if ($row['tyre_old_image']) { ?>
                    <a href="uploaded/oldtyre/<?php echo $row['tyre_old_image']; ?>" class="download-link" target="_blank" download>Download</a>
                <?php } ?>
            </td>

            <td><?php echo $old_itemname; ?></td>
            <td><?php echo $old_serial_no; ?></td>
        </tr>
        <?php } ?>
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
     <script>
         
         function getTyrePositionLabel($typos) {
    $positions = [
        1 => "Front Left",
        2 => "Front Right",
        3 => "Rear Left Outer",
        4 => "Rear Left Inner",
        5 => "Rear Right Outer",
        6 => "Rear Right Inner",
        7 => "Spare Tyre"
        // Add as per your vehicle configuration
    ];

    return isset($positions[$typos]) ? $positions[$typos] : "Unknown";
}

         
         
     </script>
   </body>
   
</html>