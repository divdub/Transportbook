<script type="text/javascript">
function getTotal() {

var qty_mt_day_trip = parseFloat(jQuery('#qty_mt_day_trip').val());
var rate = parseFloat(jQuery('#rate').val());
var frieght_amt = parseFloat(jQuery('#frieght_amt').val());
var cash_advance = parseFloat(jQuery('#cash_advance').val());
var diesel_advance = parseFloat(jQuery('#diesel_advance').val());
// alert(diesel_advance);
var consignor_adv = parseFloat(jQuery('#consignor_adv').val());
// var trip_expenses = parseFloat(jQuery('#trip_expenses').val());
// var tp_amount = parseFloat(jQuery('#tp_amount').val());
//alert(tp_amount);
 var net_amount = parseFloat(jQuery('#net_amount').val());
if (!isNaN(qty_mt_day_trip) && !isNaN(rate)) {
	var total = qty_mt_day_trip * rate;
	

}
if(isNaN(cash_advance)){
  cash_advance='0';
} 
if(isNaN(diesel_advance)){
  diesel_advance='0';
}
if(isNaN(consignor_adv)){
  consignor_adv='0';
}

	var nettotal= total- cash_advance -diesel_advance -consignor_adv;




jQuery('#frieght_amt').val(total);

	

jQuery('#net_amount').val(nettotal);
}


function gettype(billtype) {
			if(billtype=='Consignor'){
 jQuery('#consignor_show').show();
 jQuery('#shhide').hide();
  jQuery('#consignee_show').hide();

}else if(billtype=='Consignee'){
    
jQuery('#consignor_show').hide();
 jQuery('#consignee_show').show();
 jQuery('#shhide').hide();

} else {
	jQuery('#consignor_show').hide();
 jQuery('#consignee_show').hide();
 jQuery('#shhide').show();
}

		}

		function getDetails(condid,condtype) {
			
			jQuery.ajax({
				type: 'POST',
				url: 'ajaxreturn/tripno_details.php',
				data: "condid=" + condid + '&condtype=' + condtype ,
				dataType: 'html',
				success: function(data) {
                    // alert(data);
					jQuery('#trip_id').html(data);

				}
			}); //ajax close
		}

	function getTrip(trip_id) {
			// alert(trip_id);
			jQuery.ajax({
				type: 'POST',
				url: 'ajaxreturn/tripwise_details.php',
				data: "trip_id=" + trip_id,
				dataType: 'html',
				success: function(data) {
				 // alert(data);
					arr = data.split("|");
					jQuery('#loding_date').val(arr[0]);
					jQuery('#truck_no').val(arr[1]);
					jQuery('#frieght_amt').val(arr[2]);
					jQuery('#tadv').val(arr[3]);
					 jQuery('#net_amount').val(arr[4]);
					
				}
			}); //ajax close
		}

function getnetamt(){
	
    var deduct_amt = parseFloat(jQuery('#deduct_amt').val());
     var net_amount = parseFloat(jQuery('#net_amount').val());

total_amt= net_amount - deduct_amt;


jQuery('#total_amt').val(total_amt);

}

    function getpaysave(){

          var billing_type = document.getElementById("billing_type").value;
   var consignor_id = document.getElementById("consignor_id").value;
   var consignee_id = document.getElementById("consignee_id").value;
   var trip_id = document.getElementById("trip_id").value;
   var deduct_amt = document.getElementById("deduct_amt").value;
// alert(trip_id);
   var rec_amt = document.getElementById("rec_amt").value; 
var rec_date = document.getElementById("rec_date").value; 
var payment_mode = document.getElementById("payment_mode").value; 
var pay_remark = document.getElementById("pay_remark").value; 
var pay_id = document.getElementById("pay_id").value; 
// alert(pay_id);
  
        if(billing_type == '')
        {
               alert("Please Choose  Bill Type  ");
            return false;  
        }
       if(rec_date == '' || rec_amt == '')
        {
            alert("Please fill the Required Details ");
            return false;
        }
        
      jQuery.ajax({
          type: 'POST',
          url: 'ajaxreturn/save_trip_payment.php',
          data: "billing_type="+billing_type+"&consignor_id="+consignor_id+"&consignee_id="+consignee_id+"&trip_id="+trip_id+"&deduct_amt="+deduct_amt+"&rec_amt="+rec_amt+"&rec_date="+rec_date+"&payment_mode="+payment_mode+"&pay_remark="+pay_remark+"&pay_id="+pay_id,
          success: function(data){  
            // alert(data);
              // document.getElementById('msg').innerHTML = 'Save';
jQuery('#pay').click();
            },
      });
}

  function funDel1(id) {
     // alert(id);
            var tablename = 'trip_payment';
            var tableid = 'pay_id';
            if (confirm("Do You want to Delete this record ?")) {
                // alert(tableid);
                jQuery.ajax({
                    type: 'POST',
                    url: 'ajax/delete_master.php',
                    data: 'id=' + id + '&tablename=' + tablename + '&tableid=' + tableid,
                    dataType: 'html',
                    success: function(data) {
                      jQuery('#pay').click();
                    }
                }); //ajax close
            }
        }

  function paydetail(pay_id, billing_type, consignor_id, consignee_id,  deduct_amt, rec_amt, rec_date, payment_mode, pay_remark ,trip_id) {

  
    // alert("hii");
    // jQuery('#vehicle_id').val(vehicle_id);
    jQuery('#pay_id').val(pay_id);
   
  jQuery("#billing_type").val(billing_type).trigger('change').trigger('select2:select');
// alert(billing_type);   
    jQuery("#consignor_id").val(consignor_id).trigger('change').trigger('select2:select');
    // jQuery('#head_id').val(head_id);
    jQuery("#consignee_id").val(consignee_id).trigger('change').trigger('select2:select');
    jQuery('#deduct_amt').val(deduct_amt);
   jQuery("#trip_id").val(trip_id).trigger('change').trigger('select2:select');
   // alert(trip_id);
    jQuery('#rec_amt').val(rec_amt);
    jQuery('#rec_date').val(rec_date);
    jQuery('#payment_mode').val(payment_mode);
    jQuery('#pay_remark').val(pay_remark);
   
    

  }

</script>