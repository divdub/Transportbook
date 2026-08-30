      <script type="text/javascript">
      function showgst() {

var bill_type = document.getElementById('bill_type').value;

if (bill_type == 'Invoice') {
//alert(bill_type);
   //  jQuery('#grand_total2').show();
    jQuery('#gst2').show();
   //  jQuery('#grand_total1').show();
    jQuery('#gst1').show();



} else {

   //  jQuery('#grand_total2').hide();
    jQuery('#gst2').hide();
   //  jQuery('#grand_total1').hide();
    jQuery('#gst1').hide();

}
}

   function getSave() {
         var iteminv_id = document.getElementById("iteminv_id").value;
         var unitinv_id = document.getElementById("unitinv_id").value;
         var qty = document.getElementById("qty").value;
         var rate = document.getElementById("rate").value;
          var gst = document.getElementById("gst").value;
         var purchaseid = document.getElementById("purchaseid").value;
         var purdetail_id = document.getElementById("purdetail_id").value;
         var total_amt = document.getElementById("total_amt").value;
         var nettotal = document.getElementById("nettotal").value;
            jQuery.ajax({
               type: 'POST',
               url: 'ajaxpurchase/ajax_purchase_entry.php',
               data: 'iteminv_id=' + iteminv_id + '&unitinv_id=' + unitinv_id + '&qty=' + qty + '&gst=' + gst +  '&rate=' + rate + '&total_amt=' + total_amt + '&nettotal=' + nettotal +'&purchaseid=' + purchaseid + '&purdetail_id=' + purdetail_id,
               success: function(data) {
            
               
                  showrecord(<?php echo $keyvalue; ?>);
                  jQuery('#itemid').val('');
                  jQuery("#qty").val('');
                  jQuery("#serial_no").val('');
                  jQuery("#hsncode").val('');
                  jQuery("#rate").val('');

                  jQuery("#total_amt").val('');
                  jQuery("#nettotal").val('');
                   $("#gst").select2().select2('val', '');
                  $("#itemid").select2().select2('val', '');



               }
            });
         }
 function getunitid(){
   var iteminv_id = document.getElementById("iteminv_id").value;

   $.ajax({
        type: 'POST',
        url: 'ajaxpurchase/get_unitdetails.php',
        data: 'iteminv_id='+iteminv_id,
        dataType: 'html',
        success: function(data){
           
           
     $('#unitinv_id').html(data).trigger('change').trigger('select2:select');
    
        }
     });//ajax close	
}

function getHsn(){
   var iteminv_id = document.getElementById("iteminv_id").value;

   $.ajax({
        type: 'POST',
        url: 'ajaxpurchase/ajax_gethsnno.php',
        data: 'iteminv_id='+iteminv_id,
        dataType: 'html',
        success: function(data){
            // alert(data);
            	arr = data.split('|');

				hsncode = arr[0];
				itemcatid = arr[1];
							jQuery('#hsncode').val(hsncode);
                  jQuery('#iteminv_category_id').val(itemcatid);
    //  $('#hsncode').val(data);
     showrecord(<?php echo $keyvalue; ?>);
        }
     });//ajax close 
     
}

function addserial() {
      

      var iteminv_id = jQuery("#iteminv_id").val();	
      var purchaseid = document.getElementById("purchaseid").value;
      var qty = jQuery("#qty").val();	
     
		jQuery.ajax({
		  type: 'POST',
		  url: 'ajaxpurchase/addserialnoitembody.php',
		  data: 'iteminv_id='+iteminv_id+'&qty='+qty+'&purchaseid='+purchaseid,
		  dataType: 'html',
		  success: function(data){			
         
         if(data==2){
		jQuery("#modal-snserial").modal('hide');
            
         }else{
		jQuery("#modal-snserial").modal('show');

			jQuery("#serialbody1").html(data);
		
			}}
			
		  });//ajax close
		
      getdel();
	}	
	
	function getdel() {

         var qty = document.getElementById("qty").value;
      
         var rate = document.getElementById("rate").value;
             
         var gst = document.getElementById("gst").value;
         
         var total_amt = document.getElementById("total_amt").value;

         if (qty != "" && !isNaN(rate)) {

            var total = qty * rate;
            //alert(total);
            var gsttotal = total * gst/100;
            var nettotal = total+gsttotal;
            jQuery('#total_amt').val(total);
            jQuery('#nettotal').val(nettotal);
         }

      }


	function saveserial(i) {
	
		var pos_id = document.getElementById('pos_id'+i).value;
		var iteminv_id = document.getElementById('iteminv_id').value;
        var purchaseid = document.getElementById("purchaseid").value;
 
		var serial_no = document.getElementById('serial_no1'+i).value;
		
		var purdetail_id = document.getElementById('purdetail_id').value;

	
 		
		
		jQuery.ajax({
		  type: 'POST',
		  url: 'ajaxpurchase/saveserialnotyre.php',
		  data: 'i='+i+'&pos_id='+pos_id+'&iteminv_id='+iteminv_id+'&purdetail_id='+purdetail_id+'&serial_no='+serial_no+'&purchaseid='+purchaseid,
		  dataType: 'html',
		  success: function(data){		
		      
      if(data=='duplicate'){
      document.getElementById('dup'+i).innerHTML = 'Duplicate Serial No.';
    
      } else {
         jQuery('#qty').val(data);
      document.getElementById('dup'+i).innerHTML = '';
      }
      
			}
			
		  });//ajax close
		
		
		}
function showrecord(keyvalue) {
         var purchaseid = document.getElementById("purchaseid").value;
         var bill_type = document.getElementById("bill_type").value;
           var iteminv_category_id = document.getElementById("iteminv_category_id").value;
        //   alert(itemcatid);
         var supplier_id = document.getElementById("supplier_id").value;
         // alert(purchaseid);
         jQuery.ajax({
            type: 'POST',
            url: 'ajaxpurchase/show_purchaseentry.php',
            data: 'purchaseid=' + purchaseid+ '&bill_type=' + bill_type +'&iteminv_category_id=' + iteminv_category_id,
            success: function(data) {

               jQuery("#showsalerecord").html(data);

            }
         }); //ajax close


      }
function addlist() {
var supplier_id = document.getElementById('supplier_id').value;
var paymentdate = document.getElementById('paymentdate').value;
var paid_amt = document.getElementById('paid_amt').value.trim();
var disc = document.getElementById('disc').value.trim();
var pay_type = document.getElementById('pay_type').value.trim();
var narration = document.getElementById('narration').value.trim();
var paymentid=0;

if(paymentdate=='') {
		alert("Please Select Date");
		return false;
}


if(supplier_id=='') {
		alert("Please Select Customer");
		return false;
}


if(paid_amt=='' || paid_amt=='0') {
		alert("Paid Amount cant be Balnk/Zero");
		return false;
}

	jQuery.ajax({
			  type: 'POST',
			  url: 'ajaxpurchase/savepaymentpur.php',
			  data: 'paymentdate='+paymentdate+'&paid_amt='+paid_amt+'&disc='+disc+'&narration='+narration+'&pay_type='+pay_type+'&supplier_id='+supplier_id+'&paymentid='+paymentid,
			//   data: 'paymentdate='+paymentdate+'&paid_amt='+paid_amt+'&disc='+disc+'&narration='+narration+'&sup_id='+sup_id+'&paymentid='+paymentid,
			  dataType: 'html',
			  success: function(data){	
			alert(data);
			  jQuery('#supplier_id').val('');
			  jQuery('#paid_amt').val('');
			  jQuery('#disc').val('');
			  jQuery('#receiptno').val('');
			  jQuery('#prebal').val('');
			  jQuery('#narration').val(''); 
			  
			   
			  
			  jQuery("#supplier_id").val('').trigger("liszt:updated");
			document.getElementById('supplier_id').focus();
			jQuery(".chzn-single").focus();

			 		  
         showpurchaserecord();
						
						}				
			  	});//ajax close
			

}

 function showpurchaserecord() {
  
         var purchaseid = document.getElementById("purchaseid").value;
           
         var supplier_id = document.getElementById("supplier_id").value;
       
         jQuery.ajax({
            type: 'POST',
            url: 'ajaxpurchase/show_paymentpur.php',
            data: 'purchaseid=' + purchaseid+'&supplier_id=' + supplier_id,
            success: function(data) {
               
               jQuery("#showpurchaserecord").html(data);

            }
         }); //ajax close


      }

 
  

 function modelFun(purdetail_id,iteminv_id, qty, rate, total_amt, gst,nettotal,purchaseid) {


jQuery("#purdetail_id").val(purdetail_id);

$('#iteminv_id').val(iteminv_id).trigger('change').trigger('select2:select');

jQuery("#qty").val(qty);
jQuery("#rate").val(rate);
jQuery("#total_amt").val(total_amt);
$('#gst').val(gst).trigger('change').trigger('select2:select');

jQuery("#nettotal").val(nettotal);
if (qty != "" && !isNaN(rate)) {

var total = qty * rate;
//alert(total);
var gsttotal = total * gst/100;
var nettotal = total+gsttotal;
jQuery('#total_amt').val(total);
jQuery('#nettotal').val(nettotal);
}
addserial();
 }
 
 
  function funDellower(id)
{    
	 
       tblname = 'purchasentry_detail';
	   tblpkey = 'purdetail_id';
	    pagename  ='<?php echo $pagename; ?>';
		modulename  ='<?php echo $modulename; ?>';
	  
	if(confirm("Are you sure! You want to delete this record."))
	{
		jQuery.ajax({
		  type: 'POST',
		  url: 'ajaxpurchase/deletepurchase.php',
		  data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename,
		  dataType: 'html',
		  success: function(data){
		     
           showrecord(<?php echo $keyvalue; ?>);
			}
		
		  });//ajax close
	}//confirm close
} //fun close

function getprebal() {
    var supplier_id = document.getElementById('supplier_id').value.trim();
    var paymentdate = document.getElementById('paymentdate').value.trim();

    if (paymentdate === '') {
        alert("Please Select Date");
        return false;
    }

    if (supplier_id === '') {
        alert("Please Select Supplier");
        return false;
    }

    jQuery.ajax({
        type: 'POST',
        url: 'ajaxpurchase/getprevbalsupp.php',
        data: {
            supplier_id: supplier_id,
            paymentdate: paymentdate
        },
        success: function(data) {
            alert(data);
            document.getElementById('prebal').innerHTML = 'Old Balance : ' + data;
            document.getElementById('paid_amt').focus();
        },
        error: function(xhr, status, error) {
            console.error("Error fetching previous balance:", error);
            alert("Failed to retrieve previous balance.");
        }
    });
}

function savepurchasevupper() {
    var supplier_id = document.getElementById('supplier_id').value.trim();
    var paymentdate = document.getElementById('paymentdate').value.trim();
    jQuery.ajax({
        type: 'POST',
        url: 'ajaxpurchase/saveupperpurchase.php',
        data: {
            supplier_id: supplier_id,
            paymentdate: paymentdate
        },
        success: function(data) {
           jQuery("#payment").click();
          
        },
        error: function(xhr, status, error) {
            console.error("Error saving purchase data:", error);
            alert("Failed to save purchase data.");
        }
    });
}


function editselected(paymentid,paymentdate,supplier_id,paid_amt,narration,disc,pay_type)
{

	jQuery('#myModal_product').modal('show');
	jQuery('#s_paymentid').val(paymentid);

	jQuery('#s_discamt').val(disc);
	jQuery('#s_paymentdate').val(paymentdate);
	jQuery('#s_paid_amt').val(paid_amt);
	jQuery('#s_narration').val(narration);
	// jQuery('#s_sup_id').val(sup_id);
   $("#s_sup_id").select2().select2('val', supplier_id);	

	jQuery('#s_paymentid').val(paymentid);
	// jQuery('#s_pay_type').val(pay_type);
   $("#s_pay_type").select2().select2('val', pay_type);	
   // $("#trip_detailid").select2().select2('val', '');
	//		
}

function updatesale() {
		
      var supplier_id = document.getElementById('s_sup_id').value.trim();
      var paid_amt = document.getElementById('s_paid_amt').value.trim();
      var pay_type = document.getElementById('s_pay_type').value.trim();
    //   alert(pay_type);
      var disc = document.getElementById('s_discamt').value.trim();
      var narration = document.getElementById('s_narration').value.trim();
      var paymentdate = document.getElementById('s_paymentdate').value.trim();
      var paymentid= document.getElementById('s_paymentid').value.trim();
      if(paymentdate=='') {
            alert("Please Select Date");
            return false;
      }
      
      
      if(supplier_id=='') {
            alert("Please Select Customer");
            return false;
      }
      
      
      if(paid_amt=='' || paid_amt=='0') {
            alert("Paid Amount cant be Balnk/Zero");
            return false;
      }
      
      
      
         jQuery.ajax({
                 type: 'POST',
                 url: 'ajaxpurchase/savepaymentpur.php',
                 data: 'paymentdate='+paymentdate+'&paid_amt='+paid_amt+'&disc='+disc+'&narration='+narration+'&pay_type='+pay_type+'&supplier_id='+supplier_id+'&paymentid='+paymentid,
               //   data: 'paymentdate='+paymentdate+'&paid_amt='+paid_amt+'&narration='+narration+'&sup_id='+sup_id+'&paymentid='+paymentid,
                 dataType: 'html',
                 success: function(data){		
                  //alert(data)	  ;
                 jQuery('#s_sup_id').val('');
                 jQuery('#s_pay_type').val('');
                 jQuery('#s_paid_amt').val('');
                 jQuery('#s_narration').val('');
                 jQuery('#s_paymentdate').val('');
                 jQuery('#s_paymentid').val('');
                 jQuery('#myModal_product').modal('hide');
              location.reload();
                        
                        }				
                    });//ajax close
                
      
      
      }
</script>