<?php
include("../adminsession.php");
 $issue_cate= addslashes($_REQUEST['issue_cate']);
 ?>
  <option value="">-Select-</option>
 <?php
if($issue_cate=='New Item'){ ?>
   <?php
                                // ECHO "select * from m_iteminv where iteminv_category_id!='5' order by iteminv_id";
                                $resprod = mysqli_query($connection,"select * from m_iteminv where iteminv_category_id!='5' order by iteminv_id");
                                while($rowprod = mysqli_fetch_array($resprod))
                                {
   $iteminv_category_id =  $rowprod['iteminv_category_id'];
   $item_category_name = $cmn->getvalfield($connection, "m_iteminv_category", "category_name", "iteminv_category_id='$iteminv_category_id'");
   $qty = $cmn->getvalfield($connection, "purchasentry_detail", "sum(qty)", "iteminv_id='$rowprod[iteminv_id]' && purchaseid!='0'");
  $saleqty = $cmn->getvalfield($connection, "inv_saleentrydetail", "sum(qty)", "iteminv_id='$rowprod[iteminv_id]' && saleid!='0'");
  $materialinqty = $cmn->getvalfield($connection,"issueentrydetail","sum(qty)","iteminv_id='$iteminv_id' && category='New Item'");
 
 

 
 
 $stock = $qty-$materialinqty -$saleqty;
// if($iteminv_category_id!='19'){
if($stock>0){
    
                                
                                ?>
                                <option value="<?php echo $rowprod['iteminv_id']; ?>"><?php echo $rowprod['item_name']; ?>/<?php echo $item_category_name; ?></option>
                                <?php
                                }
                                ?>  
<?php } 

}

?>
 <?php
if($issue_cate=='Repaired'){ ?>
    <?php
                                //where cat_id not in (5,8)
                                // echo "select * from  issueentrydetail where is_rep='Repaired' and is_used='0'  order by iteminv_id";
                                $resprod = mysqli_query($connection,"select * from  issueentrydetail where is_rep='Repaired' && compid='$compid' && sessionid='$sessionid' Group by iteminv_id");
                                while($rowprod = mysqli_fetch_array($resprod))
                                {
							
												$item_name = $cmn->getvalfield($connection, "m_iteminv", "item_name", "iteminv_id='$rowprod[iteminv_id]' and iteminv_category_id!='19'");
												$item_category_name = $cmn->getvalfield($connection, "item_categories", "item_category_name", "iteminv_category_id='$rowprod[iteminv_category_id]'");
                                                $materialinqty1 = $cmn->getvalfield($connection,"issueentrydetail","sum(qty)","iteminv_id='$rowprod[iteminv_id]' && is_rep='Repaired' && compid='$compid' && sessionid='$sessionid'");
                                                $qty1 = $cmn->getvalfield($connection,"issueentrydetail","sum(qty)","iteminv_id='$rowprod[iteminv_id]' && category='Repaired' && compid='$compid' && sessionid='$sessionid'");
                                                $stock = $materialinqty1 -$qty1;
 if($stock>0){
                                ?>
                                <option value="<?php echo $rowprod['iteminv_id']; ?>"><?php echo $item_name; ?>/<?php echo $item_category_name; ?></option>
                                <?php
                                } }
                                ?>  
<?php } ?>

 <?php
if($issue_cate=='Exchange'){ ?>
   <?php
                                //where cat_id not in (5,8)
                                $resprod = mysqli_query($connection,"select * from issueentrydetail where is_rep='Exchange' && compid='$compid' && sessionid='$sessionid' Group by iteminv_id");
                                while($rowprod = mysqli_fetch_array($resprod))
                                {
                                            $item_name = $cmn->getvalfield($connection, "m_iteminv", "item_name", "iteminv_id='$rowprod[iteminv_id]' and iteminv_category_id!='5'");
												
													$item_category_name = $cmn->getvalfield($connection, "item_categories", "item_category_name", "iteminv_category_id='$rowprod[iteminv_category_id]'");
                                                    $materialinqty2 = $cmn->getvalfield($connection,"issueentrydetail","sum(qty)","iteminv_id='$rowprod[iteminv_id]' && is_rep='Exchange' && compid='$compid' && sessionid='$sessionid'");
                                                   $qty2 = $cmn->getvalfield($connection,"issueentrydetail","sum(qty)","iteminv_id='$rowprod[iteminv_id]' && category='Exchange' && compid='$compid' && sessionid='$sessionid'");
  $stock = $materialinqty2 -$qty2 ;

                     if($stock>0){           
                                ?>
                                <option value="<?php echo $rowprod['iteminv_id']; ?>"><?php echo $item_name; ?>/<?php echo $item_category_name; ?></option>
                                <?php
                                } }
                                ?>  
<?php } ?>