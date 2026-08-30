<?php 
error_reporting(0);
include("../adminsession.php");
$iteminv_id = $_REQUEST['iteminv_id'];



  $unitinv_id = $cmn->getvalfield($connection,"m_iteminv","unitinv_id","iteminv_id='$iteminv_id'");
 
  $unit_name = $cmn->getvalfield($connection,"m_unitinv","unit_name","unitinv_id='$unitinv_id'");

?>
 echo <option value="<?php echo $unitinv_id; ?>"><?php echo  $unit_name; ?></option>