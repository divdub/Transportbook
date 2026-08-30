<script>
    function getotherexp(){

  var exp_date = document.getElementById("exp_date").value; 
    var otherid = document.getElementById("otherid").value; 
  var amount = document.getElementById("amount").value; 
  var bill_type = document.getElementById("bill_type").value; 
 var payment_mode = document.getElementById("payment_mode").value; 
 var narration = document.getElementById("narration").value; 
//   alert(narration);
var other_exp_id = document.getElementById("other_exp_id").value; 

      jQuery.ajax({
          type: 'POST',
          url: 'ajaxaccount/save_otherexp_entry.php',
          data: "exp_date="+exp_date+"&otherid="+otherid+"&amount="+amount+"&bill_type="+bill_type+"&payment_mode="+payment_mode+"&narration="+narration +"&other_exp_id="+other_exp_id,
          success: function(data){
// alert(data);
  jQuery('#other_exp').click();
            },
      });
}
function otherdetail(vehicle_id, driver_id, exp_date, otherid,  amount, payment_mode, narration, bill_type, other_exp_id) {

  
    // alert("hii");
    // jQuery('#vehicle_id').val(vehicle_id);
   
  jQuery("#vehicle_id").val(vehicle_id).trigger('change').trigger('select2:select');
    jQuery('#exp_date').val(exp_date);
   // alert(vehicle_id);
    jQuery("#driver_id").val(driver_id).trigger('change').trigger('select2:select');
    // jQuery('#head_id').val(head_id);
    jQuery("#otherid").val(otherid).trigger('change').trigger('select2:select');
    jQuery('#amount').val(amount);

    jQuery('#payment_mode').val(payment_mode);
    jQuery('#narration').val(narration);
    jQuery('#bill_type').val(bill_type);
    jQuery('#other_exp_id').val(other_exp_id);
   
    

  }
     function funDeletem(id) {
     // alert(id);
            var tablename = ' other_expense_entry';
            var tableid = 'other_exp_id';
            if (confirm("Do You want to Delete this record ?")) {
                // alert(tableid);
                jQuery.ajax({
                    type: 'POST',
                    url: 'ajax/delete_master.php',
                    data: 'id=' + id + '&tablename=' + tablename + '&tableid=' + tableid,
                    dataType: 'html',
                    success: function(data) {
                    
  jQuery('#other_exp').click();  

                    }
                }); //ajax close
            }
        }
        
     
function getotherinc(){


  var inc_date = document.getElementById("inc_date").value; 
    var otherid = document.getElementById("otherid").value; 
  var amount = document.getElementById("amount").value; 
  var bill_type = document.getElementById("bill_type").value; 
 var payment_mode = document.getElementById("payment_mode").value; 
 var narration = document.getElementById("narration").value; 
 var txnid = document.getElementById("txnid").value; 
 // alert(narration);
var other_inc_id  = document.getElementById("other_inc_id").value; 

      jQuery.ajax({
          type: 'POST',
          url: 'ajaxaccount/save_otherinc_entry.php',
          data: "inc_date="+inc_date+"&otherid="+otherid+"&txnid="+txnid+"&amount="+amount+"&bill_type="+bill_type+"&payment_mode="+payment_mode+"&narration="+narration +"&other_inc_id="+other_inc_id ,
          success: function(data){
// alert(data);
  jQuery('#other_inc').click();
            },
      });
}

   
 function otheinc_detail(inc_date, otherid,  amount, payment_mode, narration, bill_type, other_inc_id,txnid) {

  
    // alert("hii");
    // jQuery('#vehicle_id').val(vehicle_id);
   
//   jQuery("#vehicle_id").val(vehicle_id).trigger('change').trigger('select2:select');
    jQuery('#inc_date').val(inc_date);
   // alert(vehicle_id);
    // jQuery("#driver_id").val(driver_id).trigger('change').trigger('select2:select');
    // jQuery('#head_id').val(head_id);
    jQuery("#otherid").val(otherid).trigger('change').trigger('select2:select');
    jQuery('#amount').val(amount);

    jQuery('#payment_mode').val(payment_mode);
    jQuery('#narration').val(narration);
    jQuery('#bill_type').val(bill_type);
    jQuery('#other_inc_id').val(other_inc_id); 
   jQuery('#txnid').val(txnid);
    

  }
  
       function funDel1(id) {
     // alert(id);
            var tablename = 'othr_inc_entry';
            // alert(tablename);
            var tableid = 'other_inc_id';
            alert(tableid);
            if (confirm("Do You want to Delete this record ?")) {
                // alert(tableid);
                jQuery.ajax({
                    type: 'POST',
                    url: 'ajax/delete_master.php',
                    data: 'id=' + id + '&tablename=' + tablename + '&tableid=' + tableid,
                    dataType: 'html',
                    success: function(data) {
                         jQuery('#other_inc').click();

                    }
                }); //ajax close
            }
        }

</script>