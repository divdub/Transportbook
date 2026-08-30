<?php  error_reporting(0);
include("../adminsession.php");

$qty = trim(addslashes($_REQUEST['qty']));
// $purchaseid = trim(addslashes($_REQUEST['purchaseid']));
$iteminv_id = trim(addslashes($_REQUEST['iteminv_id']));

$saledetail_id=$_REQUEST['saledetail_id'];
$itemcatid = $cmn->getvalfield($connection, "m_iteminv", "iteminv_category_id", "iteminv_id ='$iteminv_id'");
$ex=explode(',',$hiddenid);

?>

	
<?php 


if($itemcatid=='5'){ 
    if($saledetail_id==''){ 
    $slno=1;
echo  "select * from  purchaseorderserial where iteminv_id=$iteminv_id && sale='0' && compid='$compid' && session_id='$sessionid' && purchaseid!='0' order by pos_id ";
  $sql = mysqli_query($connection, "select * from  purchaseorderserial where iteminv_id=$iteminv_id && sale='0' && compid='$compid' && is_issue=0 && session_id='$sessionid' && purchaseid!='0' order by pos_id ");
  while ($row = mysqli_fetch_array($sql)) {
 
                                                    ?>
                                                    
    <option value="<?php echo $row['pos_id']; ?><?php $slno; ?>"><?php echo $row['serial_no']; ?></option>
 
                                                <?php 
                                               $slno++;
                                                } ?>



<?php } 
    
    
 else {


 $slno=1;
//  echo "select * from  purchaseorderserial where  saledetail_id='$saledetail_id'  order by pos_id ";
  $sql = mysqli_query($connection, "select * from  purchaseorderserial where  saledetail_id='$saledetail_id'  order by pos_id ");
  while ($row = mysqli_fetch_array($sql)) {
 
                                                    ?>
                                                    
    <option value="<?php echo $row['pos_id']; ?>"><?php echo $row['serial_no']; ?></option>
 
                                                <?php 
                                               $slno++;
                                                } 


}
}
else { echo "2";
}
	
	?>
   
   