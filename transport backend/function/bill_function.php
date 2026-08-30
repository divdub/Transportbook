<script>
function getsearch(){
      var fromdate = document.getElementById("fromdate").value;
     var todate = document.getElementById("todate").value;
  
     var dbillid = document.getElementById("dbillid").value;
     var vehicle_id = document.getElementById("vehicle_id").value;
     var pump_id = document.getElementById("pump_id").value;
    //  alert(owner_id);
    jQuery.ajax({
          type: 'POST',
          url: 'ajaxbill/dieseldata.php',
          data: "fromdate="+fromdate+"&todate="+todate+"&pump_id="+pump_id+"&vehicle_id="+vehicle_id+"&dbillid="+dbillid,
          dataType: 'html',
          success: function(data){  
        //   alert(data);     
           jQuery("#dieseltable").html(data);
       }
          });//ajax close   
}

function getadvid() {
    var pump_id = document.getElementById("pump_id").value;

    jQuery.ajax({
      type: 'POST',
      url: 'ajaxbill/getadv.php',
      data: "pump_id=" + pump_id,
      dataType: 'html',
      success: function(data) {
        // alert(data);     
        jQuery('#advid').html(data);

      }
    }); //ajax close   
  }

  function getadvno(id) {

    jQuery.ajax({
      type: 'POST',
      url: 'ajaxbill/getadvno.php',
      data: "id=" + id,
      dataType: 'html',
      success: function(data) {
        alert(data);
        jQuery('#adv_nooo').val(data);

      }
    });
  }

  function getadvamt() {
    var advid = document.getElementById("advid").value;

    jQuery.ajax({
      type: 'POST',
      url: 'ajaxbill/getadvamt.php',
      data: "advid=" + advid,
      dataType: 'html',
      success: function(data) {

        jQuery('#adv_amt1').val(data);

      }
    }); //ajax close   
  }

  function getbal() {

    var adv_amt1 = document.getElementById("adv_amt1").value;
    var rcv_amt = document.getElementById("rcv_amt").value;
    var adv_bal_amt = adv_amt1 - rcv_amt;
    jQuery('#adv_bal_amt').val(adv_bal_amt);
  }

 function editgetbal(){
  
    var Eadv_amt = document.getElementById("Eadv_amt").value;
    var Ercv_amt = document.getElementById("Ercv_amt").value;
    var Eadv_bal_amt = Eadv_amt - Ercv_amt;
    jQuery('#Eadv_bal_amt').val(Eadv_bal_amt);
 }

function dieseladvpayment() {
    var Eadvpayid = document.getElementById("Eadvpayid").value;
    var ppump_id = document.getElementById("ppump_id").value;
    var adv_no = document.getElementById("adv_no").value;
    var adv_date = document.getElementById("adv_date").value;
    var adv_amt = document.getElementById("adv_amt").value;
    var apay_mode = document.getElementById("apay_mode").value;
    var aremarks = document.getElementById("aremarks").value;

    if (ppump_id == '' || adv_no == '' || adv_date == '' || adv_amt == '') {
      alert("Please fill the Required Details ");
      return false;
    }

    jQuery.ajax({
      type: 'POST',
      url: 'ajaxbill/dieseladvpayment.php',
      data: "ppump_id=" + ppump_id + "&adv_no=" + adv_no + "&adv_date=" + adv_date + "&adv_amt=" + adv_amt + "&Eadvpayid=" + Eadvpayid + "&apay_mode=" + apay_mode + "&aremarks=" + aremarks,
      success: function(data) {

        jQuery('#diesel_adv').click();


      },
    });

  }

  function editadv(pump_id, adv_amt, adv_date, adv_no, advid, apay_mode, remarks) {

    jQuery('#myModaladv').modal('show');
    jQuery("#Epump_id").val(pump_id).trigger('change').trigger('select2:select');

    jQuery('#Eadvpayid').val(advid);
    jQuery('#Eadv_amt').val(adv_amt);
    jQuery('#Eadv_date').val(adv_date);
    jQuery('#Eadv_no').val(adv_no);
    jQuery('#Eapay_mode').val(apay_mode).trigger('change');
    jQuery('#Eremarks').val(remarks);

  }

  function save_editadv() {
    var ppump_id = document.getElementById("Epump_id").value;
    var adv_no = document.getElementById("Eadv_no").value;
    var adv_date = document.getElementById("Eadv_date").value;
    var adv_amt = document.getElementById("Eadv_amt").value;
    var Eadvpayid = document.getElementById("Eadvpayid").value;
    var apay_mode = document.getElementById("Eapay_mode").value;
    var aremarks = document.getElementById("Eremarks").value;
    if (ppump_id == '' || adv_no == '' || adv_date == '' || adv_amt == '') {
      alert("Please fill the Required Details ");
      return false;
    }

    jQuery.ajax({
      type: 'POST',
      url: 'ajaxbill/dieseladvpayment.php',
      data: "ppump_id=" + ppump_id + "&adv_no=" + adv_no + "&adv_date=" + adv_date + "&adv_amt=" + adv_amt + "&Eadvpayid=" + Eadvpayid + "&apay_mode=" + apay_mode + "&aremarks=" + aremarks,
      success: function(data) {
        // alert(data);
       jQuery('#myModaladv').modal('hide');
        // jQuery('#diesel_adv').click();
         

      },
    });


  }

  function funDel2(id) {

    var tablename = 'diesel_advpayment';
    var tableid = 'dadvpayid';
    if (confirm("Do You want to Delete this record ?")) {

      jQuery.ajax({
        type: 'POST',
        url: 'ajax/delete_master.php',
        data: 'id=' + id + '&tablename=' + tablename + '&tableid=' + tableid,
        dataType: 'html',
        success: function(data) {
              jQuery('#diesel_adv').click();
        }
      });
    }
  }
  
  function savebillpayment(){

   var invoiceid = document.getElementById("invoiceid").value;
    var tds_per = document.getElementById("tds_per").value;
    var gst = document.getElementById("gst").value; 
    var tds_amt = document.getElementById("tds_amt").value; 
    var deduct = document.getElementById("deduct").value;
    var received_amt = document.getElementById("received_amt").value; 
  var gst_amt = document.getElementById("gst_amt").value; 
  var receive_date = document.getElementById("receive_date").value; 
  var remark = document.getElementById("remark").value; 
  var netamt = document.getElementById("netamt").value; 
 var deduct_date = document.getElementById("deduct_date").value; 
  var deduct_remark = document.getElementById("deduct_remark").value;
  var incentiveamt = document.getElementById("incentiveamt").value;
//   alert(remark);
       if(receive_date == '' || received_amt == '')
        {
            alert("Please fill the Required Details ");
            return false;
        }
        
      jQuery.ajax({
          type: 'POST',
          url: 'ajaxbill/savebillpayment.php',
          data: "invoiceid="+invoiceid+"&tds_per="+tds_per+"&gst="+gst+"&tds_amt="+tds_amt+"&deduct_date="+deduct_date+"&deduct_remark="+deduct_remark+"&deduct="+deduct+"&received_amt="+received_amt+"&gst_amt="+gst_amt+"&receive_date="+receive_date+"&remark="+remark+"&netamt="+netamt +"&incentiveamt="+incentiveamt,
          success: function(data){  
            alert(data);
            
              jQuery('#manual_bill').click();
             

            },
      });
}
function addslipno(dispatch_id){
  var slipno = document.getElementById("slipno"+dispatch_id).value;
 

    
     
   jQuery.ajax({
       type: 'POST',
       url: 'ajaxbill/saveslipno.php',
       data: "slipno="+slipno+"&dispatch_id="+dispatch_id,
       success: function(data){  
        //  alert(data);
         
          //  jQuery('#d_bill').click();
          

         },
   });
}

function getnumber(billtype){
  var billtype = document.getElementById("billtype").value;
  var planttype = document.getElementById("planttype").value;
   jQuery.ajax({
       type: 'POST',
       url: 'ajaxbill/getinvno.php',
       data: "billtype="+billtype+"&planttype="+planttype,
       success: function(data){  
        // alert(data);
        arr = data.split("|");

jQuery('#invoiceno').val(arr[0]);

    jQuery('#sno').val(arr[1]);
        jQuery('#serial').val(arr[2]);
           jQuery('#cserial').val(arr[3]);
            jQuery('#pserial').val(arr[4]);

         },
   });
}
function dieselpayment(){
// alert("ok");
var dbillid = document.getElementById("dbillid").value;
 var pump_id = document.getElementById("pump_id").value;
 var rcv_amt = document.getElementById("rcv_amt").value; 
var rcv_date = document.getElementById("rcv_date").value; 
var bill_remark = document.getElementById("bill_remark").value; 
var pay_mode = document.getElementById("pay_mode").value; 


// alert(pump_id);
    if(rcv_amt == '' || rcv_date == '')
     {
         alert("Please fill the Required Details ");
         return false;
     }
     
   jQuery.ajax({
       type: 'POST',
       url: 'ajaxbill/savedieselpayment.php',
       data: "dbillid="+dbillid+"&rcv_amt="+rcv_amt+"&rcv_date="+rcv_date+"&bill_remark="+bill_remark+"&pump_id="+pump_id+"&pay_mode="+pay_mode,
       success: function(data){  
        //  alert(data);
        //  
           jQuery('#d_pay').click();
          

         },
   });
}

  function save_insentive() {

    var gst_amt1 = document.getElementById("gst_amt1").value;
    var incgst = document.getElementById("incgst").value;
    var tds_amt = document.getElementById("tds_amt1").value;
    var received_amt = document.getElementById("received_amt1").value;
    var ref_no = document.getElementById("ref_no").value;
    var type = document.getElementById("type").value;

    var receive_date = document.getElementById("receive_date1").value;
    var remark = document.getElementById("remark1").value;
    if (ref_no == '' || received_amt == '' || receive_date == '') {
      alert("Please fill the Required Details ");
      return false;
    }


    jQuery.ajax({
      type: 'POST',
      url: 'ajaxbill/saveincentive.php',
      data: "gst_amt1=" + gst_amt1 + "&tds_amt=" + tds_amt + "&received_amt=" + received_amt + "&receive_date=" + receive_date + "&remark=" + remark + "&ref_no=" + ref_no + "&incgst=" + incgst + "&type=" + type,
      success: function(data) {

        $("#gst_amt1").val('');
        $("#incgst").val('');
        $("#tds_amt").val('');
        $("#received_amt").val('');
        $("#ref_no").val('');
        $("#receive_date").val('');
        $("#remark").val('');
        $("#myModald1").modal('hide');

        alert("Saved successfully");
        jQuery('#manual_bill').click();

      },
    });
  }
function save_editpay(){
// alert("ok");Edbillid
 var rcv_amt = document.getElementById("Ercv_amt").value; 
var rcv_date = document.getElementById("Ercv_date").value; 
var bill_remark = document.getElementById("Ebill_remark").value; 
var pay_mode = document.getElementById("Epay_mode").value; 
 var dpayid = document.getElementById("Edpayid").value; 
 var Edbillid = document.getElementById("Edbillid").value; 


// alert(pump_id);
    if(rcv_amt == '' || rcv_date == '')
     {
         alert("Please fill the Required Details ");
         return false;
     }
     
   jQuery.ajax({
       type: 'POST',
       url: 'ajaxbill/editdieselpayment.php',
       data: "rcv_amt="+rcv_amt+"&rcv_date="+rcv_date+"&bill_remark="+bill_remark+"&pay_mode="+pay_mode+"&dpayid="+dpayid +"&Edbillid=" + Edbillid,
       success: function(data){  
        //  alert(data);
           $('#myModal8').modal('hide');

        //   jQuery('#d_pay').click();
          

         },
   });
}
function getdbillid(dbillid) {
// 			alert(invoiceid);
			jQuery.ajax({
				type: 'POST',
				url:'ajaxbill/billdata.php',
				data:'dbillid='+ dbillid,
				dataType: 'html',
				success: function(data) {
				//   alert(data);
					arr = data.split("|");

			jQuery('#dbill_date').val(arr[0]);

					jQuery('#pumpname').val(arr[1]);
					jQuery('#diesel_adv_amt').val(arr[2]);
			
					
				}
			}); //ajax close
		}
		function getpumpid(){
		    var pump_id = document.getElementById("pump_id").value;
		    var dpayid = document.getElementById("dpayid").value;
    //  alert(pump_id);
    //   alert(dpayid);
    jQuery.ajax({
          type: 'POST',
          url: 'ajaxbill/getpump.php',
          data: "pump_id="+pump_id+"&dpayid="+dpayid,
          dataType: 'html',
          success: function(data){  
        //   alert(data);     
          jQuery('#dbillid').html(data);
        //   jQuery('#category_id').html(data);
       }
          });//ajax close   
		}

function myFunctionsearch(){
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
   function addids2()
         {
             strids="";
             var cbs = document.getElementsByTagName('input');
             var len = cbs.length;
             for (var i = 1; i < len; i++)
             {
                  if (document.getElementById("check" + i)!=null)
                  {
                       if (document.getElementById("check" + i).checked==true)
                       {
                            if(strids=="")
                            strids=strids + document.getElementById("check" + i).value;
                            else
                            strids=strids + "," + document.getElementById("check" + i).value;
                        }
                   }
              }
          // alert(strids);
              document.getElementById("hideid").value = strids;
         }

function createbill() {
         var hideid = document.getElementById('hideid').value;
         //alert(hiddenid);
         if(hideid=='') {
          alert("Please Select Bilty");
          return false;
         }
         else
         {
         
         
          $('#myModal1').modal('show');
          
         }
         
         }
         
//       function savebill() {
//     var hideid = document.getElementById('hideid').value.trim();
//     var dbillno = document.getElementById('dbillno').value.trim();
//     var dbilldate = document.getElementById('dbilldate').value.trim();
//     var dbillid = document.getElementById('dbillid').value.trim();
//     var pump_id = document.getElementById('pump_id').value.trim();
//     var discountamt = document.getElementById('discountamt').value.trim();
//     var itemtype = document.getElementById('itemtype') 
//         ? document.getElementById('itemtype').value.trim() 
//         : '';
// alert(discountamt);
//     if (dbillid === '') {
//         dbillid = '0';
//     }

//     if (hideid === '') {
//         alert("Please Select Bilty");
//         return false;
//     } else if (dbillno === '') {
//         alert("Please Add Bill No");
//         return false;
//     } else if (dbilldate === '') {
//         alert("Please Add Bill Date");
//         return false;
//     }

//     $.ajax({
//         type: 'POST',
//         url: 'ajaxbill/ajax_create_bill.php',
//         data: {
//             hideid: hideid,
//             dbillno: dbillno,
//             dbilldate: dbilldate,
//             dbillid: dbillid,
//             pump_id: pump_id,
//             discountamt: discountamt,
//             itemtype: itemtype
//         },
//         dataType: 'html',
//         success: function (data) {
//             // Optional: check response
//             alert(data);

//             window.location.href = "billing.php?tabtype=d_bill";
//         },
//         error: function (xhr, status, error) {
//             console.error(error);
//             alert("Something went wrong. Please try again.");
//         }
//     });
// }

function savebill() {
         
         var hideid = document.getElementById('hideid').value.trim();
         var dbillno = document.getElementById('dbillno').value.trim();
         var dbilldate = document.getElementById('dbilldate').value.trim();
         var dbillid = document.getElementById('dbillid').value.trim();
         var pump_id = document.getElementById('pump_id').value.trim();
             var discountamt = document.getElementById('discountamt').value.trim();
         // var dbillid = '<?php echo $dbillid; ?>';
        //  alert(pump_id);
          if(dbillid==''){
            dbillid='0';
          }
         // alert(dbillid);
         if(hideid=='') {
          alert("Please Select Bilty");
          return false;
         }
         else if(dbillno=='')
         {
          alert("Please Add Bill No");
          return false;
         } else if(dbilldate=='')
         {
          alert("Please Add Bill Date");
          return false;
         } 
         else
         {
         $.ajax({
              type: 'POST',
              url: 'ajaxbill/ajax_create_bill.php',
              data: 'hideid=' + hideid+'&dbillno='+dbillno+'&dbilldate='+dbilldate+'&dbillid='+dbillid+'&pump_id='+pump_id+'&discountamt='+discountamt
              +'&itemtype='+itemtype,
              dataType: 'html',
              success: function(data){
                alert(data);
              // window.open('pdf_invoice.php?invoiceid='+data, '_blank');
                // jQuery('#mobile_no').val('');
                 // jQuery('#dbillid').val('');
           
              // window.location='billing.php';
                // window.location="billing.php";
        // jQuery("#d_bill").click();
               location.href = "billing.php?tabtype=d_bill";
                 // jQuery('#d_bill').click();
              }   
              });//ajax close
          }   
         }
         
    
</script>
<script>
    function getgst(minvid) {
// 			alert(invoiceid);
			jQuery.ajax({
				type: 'POST',
				url:'ajaxbill/gstdata.php',
				data:'minvid='+ minvid,
				dataType: 'html',
				success: function(data) {
				  // alert(data);
					arr = data.split("|");

			jQuery('#gst').val(arr[0]);

					jQuery('#gst_amt').val(arr[1]);
				
				}
			}); //ajax close
		}
function savegstpayment(){

   var minvid = document.getElementById("minvid").value;
   
    var received_gstamt = document.getElementById("received_gstamt").value; 
  var incentiveamt = document.getElementById("incentiveamt").value; 
  var receive_gstdate = document.getElementById("receive_gstdate").value; 
  var gstremark = document.getElementById("gstremark").value; 

       if(receive_gstdate == '' || received_gstamt == '')
        {
            alert("Please fill the Required Details ");
            return false;
        }
        
      jQuery.ajax({
          type: 'POST',
          url: 'ajaxbill/savegstpayment.php',
          data: "minvid="+minvid+"&received_gstamt="+received_gstamt+"&incentiveamt="+incentiveamt+"&receive_gstdate="+receive_gstdate+"&gstremark="+gstremark,
          success: function(data){  
            // alert(data);
            
              jQuery('#gst_pay').click();
             

            },
      });
}
</script>
<script>
         
         	function getinv(invoiceid) {
// 			alert(invoiceid);
			jQuery.ajax({
				type: 'POST',
				url:'ajaxbill/invoicedata.php',
				data:'invoiceid='+ invoiceid,
				dataType: 'html',
				success: function(data) {
				  // alert(data);
					arr = data.split("|");

			jQuery('#invdate').val(arr[0]);

					jQuery('#qty').val(arr[1]);
					jQuery('#amount').val(arr[2]);
			
						jQuery('#amount1').val(arr[3]);
            	jQuery('#gst').val(arr[4]);
              	jQuery('#gst_amt').val(arr[5]);
                gettotal();
				}
			}); //ajax close
		}



function gettotal(){
  var tds_per =document.getElementById("tds_per").value;
//  var gst_amt = document.getElementById("gst_amt").value;
// var received_amt = parseFloat(document.getElementById("received_amt").value); 
 var gst = parseFloat(document.getElementById("gst").value);
 var amount = parseFloat(document.getElementById("amount").value);
  var amount1 = parseFloat(document.getElementById("amount1").value);

 var deduct = parseFloat(document.getElementById("deduct").value);
 
 if(isNaN(gst)){
    gst='0';
 }
//  alert(tdsamt);
 if(isNaN(tds_amt)){
   tds_amt='0';
 }
 if(isNaN(gst_amt)){
    gst_amt='0';
 }
 if(isNaN(deduct)){
    deduct='0';
 }
 var gst_amt= amount1 * (gst / 100) ;
 
 jQuery('#gst_amt').val(gst_amt);
  // alert(gst_amt);
 var tdsamt= amount1 * tds_per /  100 ;
 jQuery('#tds_amt').val(tdsamt);
 

//  alert(amount);

//  alert(deduct);  
   var netamt = amount - gst_amt -tdsamt -deduct;    
    //  alert(netamt);
  jQuery('#netamt').val(netamt.toFixed(2));
  
}


  function modelFun(pump_id,rcv_amt,rcv_date, pay_mode, bill_remark,dpayid,dbill_date,diesel_adv_amt,dbillid, advid, adv_amt) {

  
    // alert(dpayid);
    // jQuery('#vehicle_id').val(vehicle_id);
    //   $('#myModal2').modal('show');
    $('#myModal8').modal('show');
    jQuery("#Epump_id").val(pump_id).trigger('change').trigger('select2:select');
     jQuery("#Edbillid").val(dbillid).trigger('change').trigger('select2:select');
   jQuery('#Edpayid').val(dpayid);
   jQuery('#Ercv_amt').val(rcv_amt);
    jQuery('#Ercv_date').val(rcv_date);
        jQuery('#Ediesel_adv_amt').val(diesel_adv_amt);
jQuery('#Eadv_id').val(advid).trigger('change').trigger('select2:select');
    jQuery('#Eadv_amt').val(adv_amt);
//   // alert(vehicle_id);
    // jQuery("#dbillid").val(dbillid).trigger('change').trigger('select2:select');
//     jQuery('#head_id').val(head_id).trigger('change').trigger('select2:select');
//     jQuery("#mechanic_id").val(mechanic_id).trigger('change').trigger('select2:select');
   

    jQuery('#Epay_mode').val(pay_mode).trigger('change').trigger('select2:select');
    jQuery('#Ebill_remark').val(bill_remark);
    jQuery('#Edbill_date').val(dbill_date);
   
   editgetbal();
   
    

  }

  function edit(dispatch_id,type) {
    // alert(type);
    if(dispatch_id !='') {
          
          jQuery.ajax({
        type: 'POST',
        url: 'getotp.php',
        data: 'dispatch_id='+dispatch_id+'&type='+type,
        dataType: 'html',
        success: function(data){ 
        //   alert(data);
            jQuery("#ref_id").val(dispatch_id);
            jQuery("#type").val(type);
          jQuery("#myModal").modal('show');
          //	jQuery("#getotp").html(data);
          
        }	
        });//ajax close
      }	
  }

  function checkotp() {
	var otp = document.getElementById('otp').value;
	var ref_id = document.getElementById('ref_id').value;
  var type = document.getElementById('type').value;
  // alert(type);
  // alert(ref_id);
	if(otp !='') {
					jQuery.ajax({
			  type: 'POST',
			  url: 'match_otp.php',
			  data: 'ref_id='+ref_id+'&otp='+otp,
			  dataType: 'html',
			  success: function(data){ 
			//	alert(data);
				
					if(data==1) {
						
						 //alert("ok");
						 jQuery("#myModal").modal('hide');
             
             jQuery("#otp").val('');
             jQuery("#type").val('');
             if(type=='edit'){
             location = "billing.php?edit="+ref_id;
             }
             if(type=='del'){
              funDel1(ref_id);
             }
						} 
						else
            // jQuery("#otp").val('');
						alert("Wrong OTP");
				}	
			  });//ajax close
		 
	}
	
}


function checkdotp() {
	var otp = document.getElementById('otp').value;
	var ref_id = document.getElementById('ref_id').value;
  var type = document.getElementById('type').value;
  // alert(type);
  // alert(ref_id);
	if(otp !='') {
					jQuery.ajax({
			  type: 'POST',
			  url: 'match_otp.php',
			  data: 'ref_id='+ref_id+'&otp='+otp,
			  dataType: 'html',
			  success: function(data){ 
			//	alert(data);
				
					if(data==1) {
						
						 //alert("ok");
						 jQuery("#myModal").modal('hide');
             
             jQuery("#otp").val('');
             jQuery("#type").val('');
             if(type=='edit'){
             location = "billing.php?tabtype=d_bill&dbillid="+ref_id;
             }
             if(type=='del'){
              funDel1(ref_id);
             }
						} 
						else
            // jQuery("#otp").val('');
						alert("Wrong OTP");
				}	
			  });//ajax close
		 
	}
	
}
</script>