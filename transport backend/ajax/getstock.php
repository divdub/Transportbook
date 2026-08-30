<?php 
include("../adminsession.php");

    $id = $_REQUEST['id'];
   
   $qty=$cmn->getvalfield($connection,"stockin","sum(qty)","adblue_id=$id && consignorid=$consignorid");
    $adblueqty=$cmn->getvalfield($connection,"dispatch_entry","sum(adblueqty)","adblue_id=$id && consignor_id=$consignorid");
    $sale=$cmn->getvalfield($connection,"saleentry","sum(qty)","adblue_id=$id && consignorid=$consignorid");
    if($adblueqty==''){$adblueqty=0;}
    if($qty==''){$qty=0;}
    if($sale==''){$sale=0;}
 	$stock=$qty - $adblueqty -$sale;
									echo $stock.'|'.$stock;
									?>
																	



