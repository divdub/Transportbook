        <script type="text/javascript">
        
        
        
     function editselected(paymentid,paymentdate,customer_id,paid_amt,narration,disc,pay_type)
{

	jQuery('#myModal_product').modal('show');
	jQuery('#s_paymentid').val(paymentid);
	jQuery('#s_discamt').val(disc);
	jQuery('#s_paymentdate').val(paymentdate);
	jQuery('#s_paid_amt').val(paid_amt);
	jQuery('#s_narration').val(narration);
    $("#s_customer_id").select2().select2('val', customer_id);	
	jQuery('#s_paymentid').val(paymentid);
    $("#s_pay_type").select2().select2('val', pay_type);	
    alert(paymentid);
   		
}
         
 
function updatesale() {
		
      var customer_id = document.getElementById('s_customer_id').value.trim();
      var paid_amt = document.getElementById('s_paid_amt').value.trim();
      var pay_type = document.getElementById('s_pay_type').value.trim();
    //   alert(pay_type);
      var disc = document.getElementById('s_discamt').value.trim();
      var narration = document.getElementById('s_narration').value.trim();
      var paymentdate = document.getElementById('s_paymentdate').value.trim();
      var paymentid= document.getElementById('s_paymentid').value.trim();
//   alert(paymentdate);
      
      if(paymentdate=='') {
            alert("Please Select Date");
            return false;
      }
      
      
      if(customer_id=='') {
            alert("Please Select Customer");
            return false;
      }
      
      
      if(paid_amt=='' || paid_amt=='0') {
            alert("Paid Amount cant be Balnk/Zero");
            return false;
      }
      
      
      
         jQuery.ajax({
                 type: 'POST',
                 url: 'ajaxsale/savesalepur.php',
                 data: 'paymentdate='+paymentdate+'&paid_amt='+paid_amt+'&disc='+disc+'&narration='+narration+'&pay_type='+pay_type+'&customer_id='+customer_id+'&paymentid='+paymentid,
               //   data: 'paymentdate='+paymentdate+'&paid_amt='+paid_amt+'&narration='+narration+'&sup_id='+sup_id+'&paymentid='+paymentid,
                 dataType: 'html',
                 success: function(data){		
                //   alert(data)	  ;
                 jQuery('#s_customer_id').val('');
                 jQuery('#s_pay_type').val('');
                 jQuery('#s_paid_amt').val('');
                 jQuery('#s_narration').val('');
                 jQuery('#s_paymentdate').val('');
                 jQuery('#s_paymentid').val('');
                 jQuery('#myModal_product').modal('hide');
                 showsalepay();
                        
                        }				
                    });//ajax close
                
      
      
      }        
         
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

function getstock(){
   var iteminv_id = document.getElementById("iteminv_id").value;

	
   $.ajax({
        type: 'POST',
        url: 'ajaxsale/get_stock.php',
        data: 'iteminv_id='+iteminv_id,
        dataType: 'html',
        success: function(data){
        //   alert(data);
           
   document.getElementById('stock').innerHTML='Stock : '+data;
      jQuery("#stockin").val(data);
        }
     });//ajax close	
}


function addserial() {
     
   var saledetail_id = jQuery("#saledetail_id").val();	
      var iteminv_id = jQuery("#iteminv_id").val();	
      var qty = jQuery("#qty").val();	
//   alert("okk");
		jQuery.ajax({
		  type: 'POST',
		  url: 'ajaxsale/serial_sale.php',
		  data: 'iteminv_id='+iteminv_id+'&qty='+qty+'&saledetail_id='+saledetail_id,
		  dataType: 'html',
		  success: function(data){			
        //   alert(data);
         if(data==2){
		jQuery("#serialn").hide();
      jQuery("#seriald").hide();
            
         }else{
            jQuery("#serialn").show();
      jQuery("#seriald").show();

			// jQuery("#serial").html(data).trigger('change').trigger('select2:select');
         //$("#serial").empty();		 
         $("#serial").html(data);		 
				// $("#serial").multiselect("rebuild");
            // $("#serial").multiselect('select', tempselecteproperty);
            // jQuery('.select2-me').select2();
            // $('select[multiple]').multiselect();
			}}
			
		  });//ajax close
		
      getdel();
	}	
	
	function getdel() {

         var qty = document.getElementById("qty").value;
      
         var rate = document.getElementById("rate").value;
             
         var gst = document.getElementById("gst").value;
         
         var total_amt = document.getElementById("total_amt").value;
         var disc = document.getElementById("disc").value;

         if (qty != "" && !isNaN(rate)) {

            var total = qty * rate;
            //alert(total);
            var gsttotal = total * gst/100;
            var nettotal = total+gsttotal;
            var nettotal1 = nettotal-disc;
            jQuery('#total_amt').val(total);
            jQuery('#nettotal').val(nettotal);
            jQuery('#grandtotal').val(nettotal1);
         }

      }
      
      
      
      function getSave() {

         var iteminv_id = document.getElementById("iteminv_id").value;
         var unitinv_id = document.getElementById("unitinv_id").value;
         var hiddenid = document.getElementById("hiddenid").value;
           stock = parseFloat(document.getElementById("stockin").value);

          qty = parseFloat(document.getElementById("qty").value);
         var rate = document.getElementById("rate").value;
          var gst = document.getElementById("gst").value;


         var saleid = '<?php echo $keyvalue; ?>';
         // var saledetail_id = 0;

         var saledetail_id = document.getElementById("saledetail_id").value;
        
         var total_amt = document.getElementById("total_amt").value;
         var disc = document.getElementById("disc").value;

         var nettotal = document.getElementById("nettotal").value;
         var grandtotal = document.getElementById("grandtotal").value;
        //   alert(stock);
          if(isNaN(qty)){
              qty='0';
          }
             if(isNaN(stock)){
              stock='0';
          }
        if(qty > stock){
            alert("quantity is more than Stock");
            return false;
            
        }
           if(qty=='' || rate==''){
            alert("Please add Qty && Rate");
            return false;
            
        }    

           
            jQuery.ajax({
               type: 'POST',
               url: 'ajaxsale/ajax_sale_entry.php',
               data: 'iteminv_id=' + iteminv_id + '&hiddenid=' + hiddenid + '&unitinv_id=' + unitinv_id + '&qty=' + qty + '&gst=' + gst +  '&rate=' + rate + '&total_amt=' + total_amt + '&nettotal=' + nettotal +'&saleid=' + saleid + '&saledetail_id=' + saledetail_id+ '&disc=' + disc+ '&grandtotal=' + grandtotal,
               success: function(data) {
        //   alert(data);
               
                 
                  jQuery('#iteminv_id').val('');
                  jQuery("#qty").val('');
                  jQuery("#serial_no").val('');
                  jQuery("#hsncode").val('');
                jQuery("#stock").html('');
                     jQuery("#stockin").val('');
                  jQuery("#rate").val('');
              jQuery("#hiddenid").val('');
                  jQuery("#total_amt").val('');
                  jQuery("#disc").val('');
                  jQuery("#nettotal").val('');
                  jQuery("#grandtotal").val('');
  $("#gst").select2().select2('val', '');
                  $("#iteminv_id").select2().select2('val', '');
$("#serial").select2().select2('val', '');
 showrecord(<?php echo $keyvalue; ?>);

               }
            });
         }
 
  function showrecord(keyvalue) {
         var saleid = document.getElementById("saleid").value;
         var bill_type = document.getElementById("bill_type").value;
           var iteminv_category_id = document.getElementById("iteminv_category_id").value;
       
         var customer_id = document.getElementById("customer_id").value;
         // alert(saleid);
         jQuery.ajax({
            type: 'POST',
            url: 'ajaxsale/show_sale_entry.php',
            data: 'saleid=' + saleid+ '&bill_type=' + bill_type +'&iteminv_category_id=' + iteminv_category_id,
            success: function(data) {
                //  alert(data);
               jQuery("#showsalerecord").html(data);

            }
         }); //ajax close


      }


 function modelFun(saledetail_id,iteminv_id, qty, rate, total_amt, gst,disc,nettotal,saleid,pos_id) {
jQuery("#saledetail_id").val(saledetail_id);
$('#iteminv_id').val(iteminv_id).trigger('change').trigger('select2:select');
jQuery("#qty").val(qty);
jQuery("#rate").val(rate);
jQuery("#disc").val(disc);
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
if(pos_id!=''){
// addserial();
// addids();
// getValues(pos_id);
} else {
    jQuery("#hiddenid").val('');
}
 }
 
 
 function funDellower(id)
{    
	 
       tblname = 'inv_saleentrydetail';
	   tblpkey = 'saledetail_id';
	    pagename  ='<?php echo $pagename; ?>';
		modulename  ='<?php echo $modulename; ?>';
	  
	if(confirm("Are you sure! You want to delete this record."))
	{
		jQuery.ajax({
		  type: 'POST',
		  url: 'ajaxsale/delete_saledetail.php',
		  data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename,
		  dataType: 'html',
		  success: function(data){
		     
           showrecord(<?php echo $keyvalue; ?>);
			}
		
		  });//ajax close
	}//confirm close
} //fun close

function funDel(id) {
			tblname = 'inv_saleentry';
			tblpkey = 'saleid';
			pagename = '<?php echo $pagename; ?>';
			modulename = '<?php echo $modulename; ?>';
			//alert(tblpkey); 
			if (confirm("Are you sure! You want to delete this record.")) {
				$.ajax({
					type: 'POST',
					url: 'ajaxsale/deletesale.php',
					data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' + modulename,
					dataType: 'html',
					success: function(data) {
					    //alert(data)
						location = '<?php echo $pagename ?>?action=3';
					}

				}); //ajax close
			} //confirm close
		} //fun close


function getprebal() {
	var customer_id = document.getElementById('customer_id').value;
	var paymentdate = document.getElementById('paymentdate').value;
    // alert(paymentdate);
	
	if(paymentdate=='') {
	alert("Please Select Date");
	return false;
	}
	
	if(customer_id=='') {
	alert("Please Select Customer");
	return false;
	}
	
	if(customer_id !='') {
	jQuery.ajax({
			  type: 'POST',
			  url: 'ajaxsale/getprevbalcust.php',
			  data: 'customer_id='+customer_id+'&paymentdate='+paymentdate,
			  dataType: 'html',
			  success: function(data){
				// 		alert(data);
						document.getElementById('prebal').innerHTML='Old Balance : '+data;
						jQuery('#paid_amt').focus('');
						}				
			  	});//ajax close
			 } 

}


function addlist() {
var customer_id = document.getElementById('customer_id').value;
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


if(customer_id=='') {
		alert("Please Select Customer");
		return false;
}


if(paid_amt=='' || paid_amt=='0') {
		alert("Paid Amount cant be Balnk/Zero");
		return false;
}


	jQuery.ajax({
			  type: 'POST',
			  url: 'ajaxsale/savesalepur.php',
			  data: 'paymentdate='+paymentdate+'&paid_amt='+paid_amt+'&disc='+disc+'&narration='+narration+'&pay_type='+pay_type+'&customer_id='+customer_id+'&paymentid='+paymentid,
			//   data: 'paymentdate='+paymentdate+'&paid_amt='+paid_amt+'&disc='+disc+'&narration='+narration+'&sup_id='+sup_id+'&paymentid='+paymentid,
			  dataType: 'html',
			  success: function(data){	
               //  alert("hiii");
			//  alert(data);		  
			  jQuery('#customer_id').val('');
			  jQuery('#paid_amt').val('');
			  jQuery('#disc').val('');
			  jQuery('#receiptno').val('');
			  jQuery('#prebal').val('');
			  jQuery('#narration').val(''); 
			  
			  
			  
			  jQuery("#customer_id").val('').trigger("liszt:updated");
			document.getElementById('customer_id').focus();
			jQuery(".chzn-single").focus();

			 		  
         showsalepay();
						
						}				
			  	});//ajax close
			

}

function showsalepay(keyvalue) {
         var purchaseid = document.getElementById("purchaseid").value;
         // alert(purchaseid);
         var customer_id = document.getElementById("customer_id").value;
         // alert(purchaseid);
         jQuery.ajax({
            type: 'POST',
            url: 'ajaxsale/show_salepur.php',
            data: 'purchaseid=' + purchaseid+'&customer_id=' + customer_id,
            success: function(data) {
               // alert(data);
               jQuery("#showsalepayrecord").html(data);

            }
         }); //ajax close


      } 
      
  function savesaleupper() {
    var customer_id = document.getElementById('customer_id').value.trim();
    var paymentdate = document.getElementById('paymentdate').value.trim();

    // Validate input
    if (!paymentdate) {
        alert("Please fill  Payment Date fields.");
        return;
    }

    // Send AJAX request
    jQuery.ajax({
        type: 'POST',
        url: 'ajaxsale/saveuppersale.php',
        data: {
            customer_id: customer_id,
            paymentdate: paymentdate
        },
        success: function(data) {
            // Optional: you can check the response data if needed
            // console.log(data);

            // Trigger click on #salepayment button
            jQuery("#salepayment").click();
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
            alert("An error occurred while saving the sale. Please try again.");
        }
    });
}

      
   


		
			function fundelupper(id) {
			tblname = '<?php echo $tblname; ?>';
			tblpkey = '<?php echo $tblpkey; ?>';
			pagename = '<?php echo $pagename; ?>';
			modulename = '<?php echo $modulename; ?>';
			alert(tblpkey); 
			if (confirm("Are you sure! You want to delete this record.")) {
				$.ajax({
					type: 'POST',
					url: 'ajax/deletepurchaseupper.php',
					data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' + modulename,
					dataType: 'html',
					success: function(data) {
						
						location = pagename + '?action=10';
					}

				}); //ajax close
			} //confirm close
		} //fun close

		
 function addids()
         {
          
            strids="";
            var serial = document.getElementById("serial").value;
            var hiddenid = document.getElementById("hiddenid").value;
            var delserial = document.getElementById("delserial").value;
            const testArray = hiddenid.split(",");
                     var check = testArray.includes(serial);
                     //  alert(check);
                      if(check==false){
                  if (serial!='')
                  {
                    
                            if(hiddenid==""){
                        
                            strids=strids + document.getElementById("serial").value;
                            jQuery("#serial").val('');
                            jQuery("#delserial").val(serial);
                             } else {
                            strids=hiddenid + "," + document.getElementById("serial").value;
                            jQuery("#serial").val('');
                            jQuery("#delserial").val(","+ serial);
                             } 
                             document.getElementById("hiddenid").value = strids;
                   } else {

                     strids=document.getElementById("delserial").value;
                     newString = hiddenid.replace(strids, "");
   //  console.log(newString);
    document.getElementById("hiddenid").value = newString;
    const myArray = newString.split(",");
    var length =  myArray.length;
   if(length!=1){
      lastElement = myArray[myArray.length - 1];
    jQuery("#delserial").val(","+ lastElement);
   } else {
      lastElement = myArray[myArray.length - 1];
    jQuery("#delserial").val(lastElement);
   }
    

  
                   }
              
         
                  }
         }
</script>

