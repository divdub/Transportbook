<?php
error_reporting(0);
include("../adminsession.php");
$issueid = $_REQUEST['issueid'];

if ($issueid != 0) {
  $issueid = $_REQUEST['issueid'];
} else {
  $issueid = 0;
}

//echo "select * from issueentrydetail where issueid='$issueid' && compid='$compid' && sessionid='$sessionid' ORDER BY `issuedetailid` DESC";
$sqlget = mysqli_query($connection, "select * from issueentrydetail where issueid='$issueid'  ORDER BY `issuedetailid` DESC");
$sn = 1;
$amount = 0;
?>


<table width="100%" class="table table-bordered table-condensed">
  <thead>
    <tr>
      <th width="3%">SN</th>
       <th width="15%">Category</th>
      <th width="25%">Item Name</th>
      <th width="8%">Unit Name</th>
     
      <th width="8%">Qty.</th>
      
      <th width="15%">Issue Category</th>
          
      <!--<th width="15%">Return Item</th>-->
     
      <th width="15%">Remark</th>
      <th width="9%" class="center">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $rowcount = mysqli_num_rows($sqlget);
    while ($rowget = mysqli_fetch_assoc($sqlget)) {

      $issuedetailid = $rowget['issuedetailid'];
        $returnitem_id = $rowget['returnitem_id'];
      $iteminv_id = $rowget['iteminv_id'];
      $issueid = $rowget['issueid'];
      $unitname = $rowget['unitname'];
      $is_rep = $rowget['is_rep'];
      $excrec = $rowget['excrec'];
      $qty = $rowget['qty'];
      $remark1 = $rowget['remark1'];
      $stock = $rowget['stock'];
       $purdetail_id = $rowget['purdetail_id'];
$category = $rowget['category'];

 

       $itemcategoryname = $cmn->getvalfield($connection, "m_iteminv", "item_name", "iteminv_id='$iteminv_id'"); 

    $itemid = $cmn->getvalfield($connection, "purchasentry_detail", "iteminv_id", "purdetail_id='$rowget[returnitem_id]'");
    $returnitem = $cmn->getvalfield($connection, "m_iteminv", "item_name", "iteminv_id='$iteminv_id' and iteminv_category_id!='5'");
    $item_name = $cmn->getvalfield($connection, "m_iteminv", "item_name", "iteminv_id='$rowget[iteminv_id]' and iteminv_category_id!='5'");
                     
    $item_category_name = $cmn->getvalfield($connection, "m_iteminv_category", "category_name", "iteminv_category_id='$rowget[iteminv_category_id]'");
    ?>

      <tr>

        <td><?php echo $sn; ?></td>
        <td><?php echo $category; ?></td>
        <td><?php echo $itemcategoryname; ?>/<?php echo $item_category_name; ?></td>
        <td><?php echo $unitname; ?></td>
        
        <td><?php echo $qty;  ?></td>
       
        <td><?php echo $is_rep;  ?></td>
     
         
     
               
        
         
        <td><?php echo $remark1;  ?></td>
        <td class="center"><a class="btn btn-danger btn-small" onClick="deleterecord('<?php echo $rowget['issuedetailid']; ?>');"> X </a>
        </td>

      </tr>



    <?php


      $sn++;
    }





    ?>


  </tbody>

</table>