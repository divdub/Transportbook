<script type="text/javascript">

function getmaintenanceentry(){

 var vehicle_id = document.getElementById("vehicle_id").value; 
 var driver_id = document.getElementById("driver_id").value;
  var mdate = document.getElementById("mdate").value; 
    var head_id = document.getElementById("head_id").value; 
  var mechanic_id = document.getElementById("mechanic_id").value; 
  var amount = document.getElementById("amount").value; 
  var payment_type = document.getElementById("payment_type").value; 
 var payment_mode = document.getElementById("payment_mode").value; 
 var remark = document.getElementById("remark").value; 
 var main_id = document.getElementById("main_id").value; 
 var pay_type = document.getElementById("pay_type").value; 
  var bill_id = document.getElementById("bill_id").value; 
 


      jQuery.ajax({
          type: 'POST',
          url: 'ajaxmaintenance/save_maintenance_entry.php',
          data: "vehicle_id="+vehicle_id+"&driver_id="+driver_id+"&mdate="+mdate+"&head_id="+head_id+"&mechanic_id="+mechanic_id+"&amount="+amount+"&payment_type="+payment_type+"&payment_mode="+payment_mode+"&remark="+remark
          +"&pay_type="+pay_type+"&bill_id="+bill_id
          ,
          success: function(data){

  jQuery('#maintenance').click();
            },
      });
}






  function modelFun(servicedetailid, head_id, mechanic_id, service_datenext ,meater_readingnext, amount) {
     jQuery('#servicedetailid').val(servicedetailid);
     jQuery('#head_id').val(head_id).trigger('change').trigger('select2:select');
     jQuery("#mechanic_id").val(mechanic_id).trigger('change').trigger('select2:select');
     jQuery('#service_datenext').val(service_datenext);
     jQuery('#meater_readingnext').val(meater_readingnext);
     jQuery('#amount').val(amount);

  }


  
  

   function funDeletem(id) {
     // alert(id);
            var tablename = 'maintenance_entry';
            var tableid = 'main_id';
            if (confirm("Do You want to Delete this record ?")) {
                // alert(tableid);
                jQuery.ajax({
                    type: 'POST',
                    url: 'ajax/delete_master.php',
                    data: 'id=' + id + '&tablename=' + tablename + '&tableid=' + tableid,
                    dataType: 'html',
                    success: function(data) {
                    
  jQuery('#maintenance').click();  

                    }
                }); //ajax close
            }
        }

function getSave() {
         var head_id = document.getElementById("head_id").value;
         var mechanic_id = document.getElementById("mechanic_id").value;
         var amount = document.getElementById("amount").value;      
         var meater_readingnext = document.getElementById("meater_readingnext").value;
		     var service_id = document.getElementById("service_id").value;
		     var servicedetailid = document.getElementById("servicedetailid").value;
         var service_datenext = document.getElementById("service_datenext").value;
            jQuery.ajax({
               type: 'POST',
               url: 'ajaxmaintenance/ajax_service_entry.php',
               data: 'head_id=' + head_id +'&service_id='+ service_id +'&servicedetailid=' + servicedetailid + '&mechanic_id=' + mechanic_id  + '&amount=' + amount +  '&meater_readingnext=' + meater_readingnext + '&service_datenext=' + service_datenext,
               success: function(data) {
                  showrecord(<?php echo $service_id; ?>);
                  jQuery("#amount").val('');
                  jQuery("#meater_readingnext").val('');
				           jQuery("#servicedetailid").val('');
                  jQuery("#service_datenext").val('');
                  $("#head_id").select2().select2('val', '');
                  $("#mechanic_id").select2().select2('val', '');



               }
            });
         }





function showrecord() {
  var service_id = document.getElementById("service_id").value;
    jQuery.ajax({
      type: 'POST',
      url: 'ajaxmaintenance/show_serviceentry.php',
      data: 'service_id=' + service_id,
      success: function(data) {
        jQuery("#showsalerecord").html(data);

      }
    }); //ajax close


  }

function getdetails(){
  
       var bill_id = document.getElementById("bill_id").value;  
      var pay_type = document.getElementById("pay_type").value;  
    jQuery.ajax({
          type: 'POST',
          url: 'ajaxmaintenance/getdetails.php',
          data: "bill_id="+bill_id+"&pay_type="+pay_type,
          dataType: 'html',
          success: function(data){    
      arr=data.split("|");
                jQuery('#mdate').val(arr[0]);
               jQuery('#head_id').val(arr[1]);
               jQuery('#vehicle_id').val(arr[2]);
               jQuery('#driver_id').val(arr[3]);
                jQuery('#amount1').val(arr[4]);
                  jQuery('#mechanic_id').val(arr[6]);
                
                 jQuery('#bill_type').val(arr[5]).trigger('change').trigger('select2:select');
            
            }
          });//ajax close   
}

function gettype(pay_type){
    jQuery.ajax({
          type: 'POST',
          url: 'ajaxmaintenance/getpaytype.php',
          data: "pay_type="+pay_type ,
          dataType: 'html',
          success: function(data){  
      jQuery('#bill_id').html(data);
              
            }
          });//ajax close   





}

</script>