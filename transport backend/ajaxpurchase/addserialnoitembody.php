<?php  
error_reporting(0);
include("../adminsession.php");
$qty = trim(addslashes($_REQUEST['qty']));
$purchaseid = trim(addslashes($_REQUEST['purchaseid']));
$iteminv_id= trim(addslashes($_REQUEST['iteminv_id']));
$itemcatid = $cmn->getvalfield($connection, "m_iteminv", "iteminv_category_id", "iteminv_id ='$iteminv_id'");
?>

<?php if($itemcatid=='5'){ ?>
<table class="table table-bordered">
		<tr>
        <th style="width:100%;">#</th>
         <th style="width:100px;">Serial No</th>
        </tr>
        
       <?php 
	   for($i=1; $i <= $qty; $i++) {
		   
		    $serial_no = $cmn->getvalfield($connection,"purchaseorderserial","serial_no","purchaseid='$purchaseid' and iteminv_id='$iteminv_id' and loop_i='$i' && compid='$comp_id' && session_id='$session_id' && consignor_id='$consignorid'");
		   $pos_id = $cmn->getvalfield($connection,"purchaseorderserial","pos_id","serial_no='$serial_no' and loop_i='$i' && compid='$comp_id' && session_id='$session_id' && consignor_id='$consignorid'");
		   ?>
           	<tr>
            		<td style="width:100%;">Serial <?php echo $i +0; ?></td>
            		<td>
						<!-- <?php echo $purdetail_id;?> -->
                    		<input type="text"  style="width:300px;" class="form-control" name="serial_no" id="serial_no1<?php echo $i;?>" value="<?php echo $serial_no; ?>"  onchange="saveserial('<?php echo $i;?>');"> <span id="dup<?php echo $i;?>"></span>
                    		<input type="hidden" class="" name="pos_id" id="pos_id<?php echo $i;?>"  value="<?php echo $pos_id; ?>" >
							<!-- <button type="button" class="btn btn-default"  onclick="saveserial('<?php echo $i;?>');">Add</button> -->
                    </td>
            </tr>
           <?php	

		   }   
		
	   ?>
       
</table>
<?php }else{  echo "2";
}
	
	?>
	
