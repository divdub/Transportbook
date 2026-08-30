<?php
include("../adminsession.php");
$pagename = "maintance-process.php";
$tblname = "service_detail";
$tblpkey = "servicedetailid";
$modulename = "Service / Maintenance Entry";
 $service_id = $_REQUEST['service_id'];

?>

<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title></title>
</head>

<body>



   <div class="row-fluid">
      <div class="span12">
         
            <table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
               <thead>
                  <tr>
                     <th>Sno</th>
                     <th>Service Head</th>
                     <th>Mechanic / Service Name</th>
                     <th>Next Service Date</th>
                     <th> Next Meter Reading</th>
                     <th>Amount</th>
                     <th>User Name</th>  
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $slno = 1;
                
                      $sel = "select * from service_detail   where service_id='$service_id' && comp_id='$comp_id'  && session_id='$session_id'  ORDER BY `servicedetailid` DESC";  
                  
                  
                  $res = mysqli_query($connection, $sel);
                  while ($row = mysqli_fetch_assoc($res)) {
                      $headname = $cmn->getvalfield($connection, "head_master", "head_name", "head_id='$row[head_id]'");
                     $mechanic_name = $cmn->getvalfield($connection, "mechanic_service_master", "mechanic_name", "mechanic_id='$row[mechanic_id]'");
                     $user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");

                  ?>
                     <tr>
                        <td><?php echo $slno; ?></td>
                        <td><?php echo ucfirst($headname); ?></td>
                        <td><?php echo ucfirst($mechanic_name); ?></td>
                        <td><?php echo dateformatindia($row['service_datenext']); ?></td>
                        <td><?php echo $row['meater_readingnext']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php echo $user_name; ?></td>
                        <td>
                     
                        <a onClick="modelFun('<?php echo $row['servicedetailid']; ?>','<?php echo $row['head_id']; ?>','<?php echo $row['mechanic_id']; ?>', '<?php echo $row['service_datenext']; ?>', '<?php echo $row['meater_readingnext']; ?>','<?php echo $row['amount']; ?>','<?php echo $row['service_datenext']; ?>')" class="btn btn-inverse" rel="tooltip" title="Edit"> <i class="fa fa-edit"></i></a>
                        <a onClick="funDel('<?php echo $row['servicedetailid']; ?>')" style="display:" class="btn btn-danger" rel="tooltip" title="Delete"><i class="fa fa-times"></i></a>
                        </td>
                     </tr>
                  <?php
                     $slno++;
                     $totalamt += $row['amount'];
                  }
                  ?>
                  <tr>
                     <th></th>
                     <th></th>
                     <th></th>
                     <th>Total</th>
                     <th></th>
                     <th><?php echo number_format($totalamt, 2); ?></th>
                     <th></th>
                     <th></th>
                    
                  </tr>
               </tbody>

            </table>
        
      </div>
   </div>
</body>

</html>
<script type="text/javascript">
   function getTotal() {

      var qty = parseFloat(jQuery('#qty').val());
      var rate = parseFloat(jQuery('#rate').val());
      var disc_rs = parseFloat(jQuery('#disc_rs').val());
      var total_amt = parseFloat(jQuery('#total_amt').val());




      if (!isNaN(qty) && !isNaN(rate)) {
         total = qty * rate;
         //alert(total);
         jQuery('#total_amt').val(total);
      }
      if (!isNaN(disc_rs)) {
         total = qty * rate;
         total = total - disc_rs;
         jQuery('#total_amt').val(total);
      }
      // alert(total_amt);
      jQuery('#total_amt').val(total);
   }
</script>