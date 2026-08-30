<script type="text/javascript">
  function save_consignee() {

    var consignee_name = document.getElementById('consignee_name').value;

    var mobile_no = document.getElementById('mobile_no').value;
    if (consignee_name == '') {
      alert('Consignee Name can not be blank!');
      document.getElementById('consignee_name').focus();
      return false;
    }


    jQuery.ajax({
      type: 'POST',
      url: 'ajax/ajax_savconsignee.php',
      data: 'consignee_name=' + consignee_name + '&mobile_no=' + mobile_no,
      success: function(data) {
        // alert(data);
        jQuery('#consignee_name').val('');
        jQuery('#mobile_no').val('');
        jQuery("#myModal1").modal('hide');
        // jQuery('#consignee_id').html(data).trigger("chosen:updated");
        jQuery('#consignee_id').html(data).trigger('change').trigger('select2:select');
      }

    }); //ajax close


  }

  function edit(dispatch_id, type) {
    // alert(type);
    if (dispatch_id != '') {

      jQuery.ajax({
        type: 'POST',
        url: 'getotp.php',
        data: 'dispatch_id=' + dispatch_id + '&type=' + type,
        dataType: 'html',
        success: function(data) {
            //  alert(data);
          jQuery("#ref_id").val(dispatch_id);
          jQuery("#type").val(type);
          jQuery("#myModal").modal('show');
          //	jQuery("#getotp").html(data);

        }
      }); //ajax close
    }
  }

  function checkdispatchotp() {
    var otp = document.getElementById('otp').value;
    var ref_id = document.getElementById('ref_id').value;
    var type = document.getElementById('type').value;
    // alert(type);
    // alert(ref_id);
    if (otp != '') {
      jQuery.ajax({
        type: 'POST',
        url: 'match_otp.php',
        data: 'ref_id=' + ref_id + '&otp=' + otp,
        dataType: 'html',
        success: function(data) {
          //	alert(data);

          if (data == 1) {

            //alert("ok");
            jQuery("#myModal").modal('hide');
            jQuery("#otp").val('');
            jQuery("#type").val('');
            if (type == 'edit') {
              location = "dispatch-process.php?editid=" + ref_id;
            }
            if (type == 'del') {
              funDel(ref_id);
            }
          } else
            // jQuery("#otp").val('');
            alert("Wrong OTP");
        }
      }); //ajax close

    }

  }

  function checkotp() {
    var otp = document.getElementById('otp').value;
    var ref_id = document.getElementById('ref_id').value;
    var type = document.getElementById('type').value;
    // alert(type);
    // alert(ref_id);
    if (otp != '') {
      jQuery.ajax({
        type: 'POST',
        url: 'match_otp.php',
        data: 'ref_id=' + ref_id + '&otp=' + otp,
        dataType: 'html',
        success: function(data) {
          //	alert(data);

          if (data == 1) {
            //location = "other_expense.php?expenseid="+ref_id;
            //alert("ok");
            jQuery("#myModal").modal('hide');

            jQuery("#otp").val('');
            jQuery("#type").val('');
            if (type == 'edit') {
              jQuery("#myModal9").modal('show');
              getadv1(ref_id);
            }
            if (type == 'del') {
              getadvdelete(ref_id);
            }
          } else
            // jQuery("#otp").val('');
            alert("Wrong OTP");
        }
      }); //ajax close

    }

  }

  function myFunctionsearch() {
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

  function save_consignor() {

    var consignor_name = document.getElementById('consignor_name').value;

    var mobile_no = document.getElementById('mobile_no').value;
    if (consignor_name == '') {
      alert('Consignor Name can not be blank!');
      document.getElementById('consignor_name').focus();
      return false;
    }


    jQuery.ajax({
      type: 'POST',
      url: 'ajax/ajax_savconsignor.php',
      data: 'consignor_name=' + consignor_name + '&mobile_no=' + mobile_no,
      success: function(data) {
        // alert(data);
        jQuery('#consignor_name').val('');
        jQuery('#mobile_no').val('');
        jQuery("#myModal2").modal('hide');
        // jQuery('#consignor_id').html(data).trigger("chosen:updated");
        jQuery('#consignor_id').html(data).trigger('change').trigger('select2:select');
      }

    }); //ajax close


  }

  function save_item() {

    var item_name = document.getElementById('item_name').value;
    var item_category_id = document.getElementById('item_category_id').value;
    var unit_id = document.getElementById('unit_id').value;
    if (item_name == '') {
      alert('Item Name can not be blank!');
      document.getElementById('item_name').focus();
      return false;
    }
    if (item_category_id == '') {
      alert('Category Name can not be blank!');
      document.getElementById('item_category_id').focus();
      return false;
    }
    if (unit_id == '') {
      alert('Unit can not be blank!');
      document.getElementById('unit_id').focus();
      return false;
    }



    jQuery.ajax({
      type: 'POST',
      url: 'ajax/ajax_saveitem.php',
      data: 'item_name=' + item_name + '&unit_id=' + unit_id + '&item_category_id=' + item_category_id,
      success: function(data) {
        // alert(data);
        jQuery('#item_name').val('');
        jQuery('#item_category_id').val('');
        jQuery('#unit_id').val('');
        jQuery("#myModal3").modal('hide');
        // jQuery('#item_id').html(data).trigger("chosen:updated");
        jQuery('#item_id').html(data).trigger('change').trigger('select2:select');
      }

    }); //ajax close


  }

  function save_brand() {

    var brand_name = document.getElementById('brand_name').value;
    if (brand_name == '') {
      alert('Brand Name can not be blank!');
      document.getElementById('brand_name').focus();
      return false;
    }


    jQuery.ajax({
      type: 'POST',
      url: 'ajax/ajax_savebrand.php',
      data: 'brand_name=' + brand_name,
      success: function(data) {
        // alert(data);
        jQuery('#brand_name').val('');
        jQuery("#myModal4").modal('hide');
        // jQuery('#brand_id').html(data).trigger("chosen:updated");
        jQuery('#brand_id').html(data).trigger('change').trigger('select2:select');
      }

    }); //ajax close


  }

  function save_vehicle() {

    var vehicle_no = document.getElementById('vehicle_no').value;
    var owner_id = document.getElementById('owner_id').value;
    var agent_id = document.getElementById('agent_id').value;
    var vehicle_type_id = document.getElementById('vehicle_type_id').value;
    if (vehicle_no == '') {
      alert('Vehicle No. can not be blank!');
      document.getElementById('vehicle_no').focus();
      return false;
    }
    if (owner_id == '') {
      alert('Owner Name can not be blank!');
      document.getElementById('owner_id').focus();
      return false;
    }

    jQuery.ajax({
      type: 'POST',
      url: 'ajax/ajax_savevehicle.php',
      data: 'vehicle_no=' + vehicle_no + '&owner_id=' + owner_id + '&agent_id=' + agent_id + '&vehicle_type_id=' + vehicle_type_id,
      success: function(data) {
        // alert(data);
        jQuery('#vehicle_no').val('');
        jQuery('#owner_id').val('');
        jQuery('#agent_id').val('');
        jQuery('#vehicle_type_id').val('');
        jQuery("#myModal5").modal('hide');
        // jQuery('#vehicle_id').html(data).trigger("chosen:updated");
        jQuery('#vehicle_id').html(data).trigger('change').trigger('select2:select');
      }

    }); //ajax close


  }

  function save_driver() {

    var driver_name = document.getElementById('driver_name').value;

    var mobile_no = document.getElementById('mobile_no').value;
    if (driver_name == '') {
      alert('Driver Name can not be blank!');
      document.getElementById('driver_name').focus();
      return false;
    }
    if (mobile_no == '') {
      alert('Mobile No. can not be blank!');
      document.getElementById('mobile_no').focus();
      return false;
    }

    jQuery.ajax({
      type: 'POST',
      url: 'ajax/ajax_savedriver.php',
      data: 'driver_name=' + driver_name + '&mobile_no=' + mobile_no,
      success: function(data) {
        // alert(data);
        jQuery('#driver_name').val('');
        jQuery('#mobile_no').val('');
        jQuery("#myModal6").modal('hide');
        // jQuery('#driver_id').html(data).trigger("chosen:updated");
        jQuery('#driver_id').html(data).trigger('change').trigger('select2:select');
      }

    }); //ajax close


  }

  function save_place() {

    var place_name = document.getElementById('place_name').value;
    var state_id = document.getElementById('state_id').value;
    if (place_name == '') {
      alert('Place Name can not be blank!');
      document.getElementById('place_name').focus();
      return false;
    }
    if (state_id == '') {
      alert('State Name can not be blank!');
      document.getElementById('state_id').focus();
      return false;
    }

    jQuery.ajax({
      type: 'POST',
      url: 'ajax/ajax_saveplace.php',
      data: 'place_name=' + place_name + '&state_id=' + state_id,
      success: function(data) {
        // alert(data);
        jQuery('#place_name').val('');
        jQuery('#state_id').val('');
        jQuery("#myModal7").modal('hide');
        jQuery('#from_id').html(data).trigger("chosen:updated");
        // jQuery('#destination_id').html(data).trigger("chosen:updated");
        jQuery('#destination_id').html(data).trigger('change').trigger('select2:select');
      }

    }); //ajax close


  }

  function save_owner() {

    var owner_name = document.getElementById('owner_name').value;
    var mobileno1 = document.getElementById('mobileno1').value;
    if (owner_name == '') {
      alert('Owner Name can not be blank!');
      document.getElementById('owner_name').focus();
      return false;
    }


    jQuery.ajax({
      type: 'POST',
      url: 'ajax/ajax_saveowner.php',
      data: 'owner_name=' + owner_name + '&mobileno1=' + mobileno1,
      success: function(data) {
        // alert(data);
        jQuery('#owner_name').val('');
        jQuery('#mobileno1').val('');
        jQuery("#Modal5").modal('hide');
        // jQuery('#from_id').html(data).trigger("chosen:updated");
        // jQuery('#destination_id').html(data).trigger("chosen:updated");
        jQuery('#owner_id').html(data).trigger('change').trigger('select2:select');
      }

    }); //ajax close


  }

  function save_pump() {

    var pump_name = document.getElementById('pump_name').value;

    var head_name = document.getElementById('head_name').value;
    if (pump_name == '') {
      alert('Pump Name can not be blank!');
      document.getElementById('pump_name').focus();
      return false;
    }


    jQuery.ajax({
      type: 'POST',
      url: 'ajax/ajax_savepump.php',
      data: 'pump_name=' + pump_name + '&head_name=' + head_name,
      success: function(data) {
        // alert(data);
        jQuery('#pump_name').val('');
        jQuery('#head_name').val('');
        jQuery("#myModal8").modal('hide');
        // jQuery('#pump_id').html(data).trigger("chosen:updated");
        jQuery('#pump_id').html(data).trigger('change').trigger('select2:select');
      }

    }); //ajax close


  }
</script>
<script type="text/javascript">
  function getOwner(vehicle_id) {

    $.ajax({
      type: 'POST',
      url: 'ajax/show_owner.php',
      data: 'vehicle_id=' + vehicle_id,
      dataType: 'html',
      success: function(data) {
        arr = data.split("|");
        jQuery('#owner_name1').val(arr[0]);
      }
    }); //ajax close    
  }

  function getdriver(driver_id) {

    $.ajax({
      type: 'POST',
      url: 'ajax/show_driver.php',
      data: 'driver_id=' + driver_id,
      dataType: 'html',
      success: function(data) {

        //console.log('get road');
        console.log(data);
        arr = data.split("|");
        jQuery('#mobile_no1').val(arr[0]);
      }
    }); //ajax close    
  }

  function getpumprate(pump_id) {
    // alert("ok");
    $.ajax({
      type: 'POST',
      url: 'ajax/show_pump_rate.php',
      data: 'pump_id=' + pump_id,
      dataType: 'html',
      success: function(data) {

        arr = data.split("|");
        jQuery('#diesel_rate').val(arr[0]);
      }
    }); //ajax close  
  }

  function getdieselamt() {
    var diesel_rate = document.getElementById("diesel_rate").value;
    var diesel_adv_amt = document.getElementById("diesel_adv_amt").value;
    var total = diesel_adv_amt / diesel_rate;
    jQuery('#diesel_ltr').val(total.toFixed(2));

  }

  function shortval() {
    // alert("ok");
    var rec_wt = document.getElementById("rec_wt").value;
    var rec_qty = document.getElementById("rec_qty").value;
    var wt_mt = document.getElementById("wt_mt").value;
    var qty = document.getElementById("qty").value;
    if (!isNaN(rec_wt) && !isNaN(rec_qty)) {
      var shortwt = wt_mt - rec_wt;
      var shortqty = qty - rec_qty;
      if (shortwt == 0 && shortqty == 0) {
        jQuery('#receive_type').val(0);
      } else {
        jQuery('#receive_type').val("1");
        // jQuery('#receive_type').val("2");  
      }
      jQuery('#shortage').val(shortwt + "/" + shortqty);

    }

  }

  function diffkm(dispatch_id) {
    // alert(dispatch_id);
    var inv_km = document.getElementById('inv_km' + dispatch_id).value;
    var gps_km = document.getElementById('gps_km' + dispatch_id).value;
    // alert(inv_km);
    // alert(gps_km);
    // alert(diffkm);
    var diffkm = inv_km - gps_km;

    jQuery('#difkm' + dispatch_id).html(diffkm);
    jQuery('#diffkm1' + dispatch_id).val(diffkm);
  }

  function shortvalue(dispatch_id) {

    var rec_wt = document.getElementById('rec_wt' + dispatch_id).value;
    var rec_qty = document.getElementById("rec_qty" + dispatch_id).value;
    var wt_mt = document.getElementById("wt_mt" + dispatch_id).value;

    var qty = document.getElementById("qty" + dispatch_id).value;

    if (!isNaN(rec_wt) && !isNaN(rec_qty)) {
      var shortwt = wt_mt - rec_wt;
      var shortqty = qty - rec_qty;

      if (shortwt == 0 && shortqty == 0) {
        jQuery('#receive_type' + dispatch_id).val(0);
      } else {
        jQuery('#receive_type' + dispatch_id).val("1");
        // jQuery('#receive_type').val("2");  
      }
      jQuery('#shortwt' + dispatch_id).html(shortwt);
      jQuery('#shortqty' + dispatch_id).html(shortqty);
    }

  }

  function itemname() {

    var item_id = document.getElementById("item_id").value;
    var wt_mt = document.getElementById("wt_mt").value;

    if (item_id == 5) {
      var qty = wt_mt * 20;
      jQuery('#qty').val(qty);
    }

    if (item_id != 5) {

      jQuery('#qty').val('');
    }
  }

  function getsearch() {
    var fromdate = document.getElementById("fromdate").value;
    var todate = document.getElementById("todate").value;
    var di_no = document.getElementById("di_no").value;
    var vehicle_id = document.getElementById("vehicle_id").value;
    var owner_id = document.getElementById("owner_id1").value;
    //  alert(owner_id);
    jQuery.ajax({
      type: 'POST',
      url: 'ajax/getreceive1.php',
      data: "fromdate=" + fromdate + "&todate=" + todate + "&di_no=" + di_no + "&owner_id=" + owner_id + "&vehicle_id=" + vehicle_id,
      dataType: 'html',
      success: function(data) {
        //   alert(data);     
        jQuery("#mulrectableid").html(data);
      }
    }); //ajax close   
  }

  function getreceive(dispatch_id) {

    jQuery.ajax({
      type: 'POST',
      url: 'ajax/getreceive.php',
      data: "dispatch_id=" + dispatch_id,
      dataType: 'html',
      success: function(data) {
        // alert(data);     
        arr = data.split("|");
        jQuery('#bilty_no').val(arr[0]);
        jQuery('#bilty_date').val(arr[1]);
        jQuery('#consignor_name1').val(arr[2]);
        jQuery('#consignee_name1').val(arr[3]);
        jQuery('#place_name1').val(arr[4]);
        jQuery('#wt_mt').val(arr[5]);
        jQuery('#qty').val(arr[6]);
        jQuery('#vehicle_no1').val(arr[7]);
        jQuery('#owner_name').val(arr[8]);
      }
    }); //ajax close   
  }


  function getadventry() {

    var dispatch_id = document.getElementById("dispatch_id").value;
    var pump_id = document.getElementById("pump_id").value;
    var adblue_id = document.getElementById("adblue_id").value;
    var adblueqty = document.getElementById("adblueqty").value;
    var rate = document.getElementById("rate").value;
    var diesel_rate = document.getElementById("diesel_rate").value;
    var diesel_ltr = document.getElementById("diesel_ltr").value;
    var diesel_adv_amt = document.getElementById("diesel_adv_amt").value;
    var cash_adv = document.getElementById("cash_adv").value;
    var cash_adv_date = document.getElementById("cash_adv_date").value;
    var other_cash_adv = document.getElementById("other_cash_adv").value;
    var other_cash_adv_date = document.getElementById("other_cash_adv_date").value;
    var consignor_cash_adv = document.getElementById("consignor_cash_adv").value;
    var consignor_cash_adv_date = document.getElementById("consignor_cash_adv_date").value;
    var consignee_cash_adv = document.getElementById("consignee_cash_adv").value;
    var consignee_cash_adv_date = document.getElementById("consignee_cash_adv_date").value;
    var adv_remark = document.getElementById("adv_remark").value;
    var deduct = document.getElementById("deduct").value;
    var pay_type = document.getElementById("pay_type").value;
    jQuery.ajax({
      type: 'POST',
      url: 'ajax/save_dispatch_adv.php',
      data: "dispatch_id=" + dispatch_id + "&pump_id=" + pump_id + "&deduct=" + deduct + "&adblue_id=" + adblue_id + "&adblueqty=" + adblueqty + "&rate=" + rate + "&diesel_rate=" + diesel_rate + "&diesel_ltr=" + diesel_ltr + "&diesel_adv_amt=" + diesel_adv_amt + "&cash_adv=" + cash_adv + "&cash_adv_date=" + cash_adv_date + "&other_cash_adv=" + other_cash_adv + "&other_cash_adv_date=" + other_cash_adv_date + "&consignor_cash_adv=" + consignor_cash_adv + "&consignor_cash_adv_date=" + consignor_cash_adv_date + "&consignee_cash_adv=" + consignee_cash_adv + "&consignee_cash_adv_date=" + consignee_cash_adv_date + "&adv_remark=" + adv_remark + "&pay_type=" + pay_type,
      success: function(data) {
        // jQuery('#success').show();

        jQuery('#success').load('ajax/jsalert.php #success');
        jQuery('#advance').click();
      },
    });
  }

  function getadventry2() {
    // var freight_amt = document.getElementById("freight_amt").value; 
    var dispatch_id = document.getElementById("dispatch_id").value;
    var pump_id = document.getElementById("pump_id").value;
    var diesel_rate = document.getElementById("diesel_rate").value;
    var diesel_ltr = document.getElementById("diesel_ltr").value;
    var diesel_adv_amt = document.getElementById("diesel_adv_amt").value;
    var cash_adv = document.getElementById("cash_adv").value;
    var cash_adv_date = document.getElementById("cash_adv_date").value;
    var other_cash_adv = document.getElementById("other_cash_adv").value;
    var other_cash_adv_date = document.getElementById("other_cash_adv_date").value;
    var consignor_cash_adv = document.getElementById("consignor_cash_adv").value;
    var consignor_cash_adv_date = document.getElementById("consignor_cash_adv_date").value;
    var consignee_cash_adv = document.getElementById("consignee_cash_adv").value;
    var consignee_cash_adv_date = document.getElementById("consignee_cash_adv_date").value;
    var adblue_id = document.getElementById("adblue_id").value;
    var adblueqty = document.getElementById("adblueqty").value;
    var rate = document.getElementById("rate").value;
    var pay_type = document.getElementById("pay_type").value;
    var adv_remark = document.getElementById("adv_remark").value

    // frt = freight_amt * ( 80 / 100 );
    // //  alert(frt);
    //         adv_total= diesel_adv_amt  +  cash_adv + other_cash_adv; 
    //         //  alert(adv_total);   
    // if(frt<adv_total){
    //     alert("Advance amount is more than Freight amouunt");
    //             return false;

    // }
    jQuery.ajax({
      type: 'POST',
      url: 'ajax/save_dispatch_adv.php',
      data: "dispatch_id=" + dispatch_id + "&adblue_id=" + adblue_id + "&adblueqty=" + adblueqty + "&rate=" + rate + "&pump_id=" + pump_id + "&diesel_rate=" + diesel_rate + "&diesel_ltr=" + diesel_ltr + "&diesel_adv_amt=" + diesel_adv_amt + "&cash_adv=" + cash_adv + "&cash_adv_date=" + cash_adv_date + "&other_cash_adv=" + other_cash_adv + "&other_cash_adv_date=" + other_cash_adv_date + "&consignor_cash_adv=" + consignor_cash_adv + "&consignor_cash_adv_date=" + consignor_cash_adv_date + "&consignee_cash_adv=" + consignee_cash_adv + "&consignee_cash_adv_date=" + consignee_cash_adv_date + "&pay_type=" + pay_type + "&adv_remark=" + adv_remark,
      success: function(data) {

        jQuery('#advtable').load('ajax/show_advtable.php #advtable').html(data);
        jQuery("#advtable").show();
        jQuery("#myModal9").modal('hide');


      },
    });
  }

  function getadventry1() {
    // var freight_amt = document.getElementById("freight_amt").value; 
    var dispatch_id = document.getElementById("dispatch_id").value;
    var pump_id = document.getElementById("pump_id").value;
    var diesel_rate = document.getElementById("diesel_rate").value;
    var diesel_ltr = document.getElementById("diesel_ltr").value;
    var diesel_adv_amt = document.getElementById("diesel_adv_amt").value;
    var cash_adv = document.getElementById("cash_adv").value;
    var cash_adv_date = document.getElementById("cash_adv_date").value;
    var other_cash_adv = document.getElementById("other_cash_adv").value;
    var other_cash_adv_date = document.getElementById("other_cash_adv_date").value;
    var consignor_cash_adv = document.getElementById("consignor_cash_adv").value;
    var consignor_cash_adv_date = document.getElementById("consignor_cash_adv_date").value;
    var consignee_cash_adv = document.getElementById("consignee_cash_adv").value;
    var consignee_cash_adv_date = document.getElementById("consignee_cash_adv_date").value;
    var adblue_id = document.getElementById("adblue_id").value;
    var adblueqty = document.getElementById("adblueqty").value;
    var rate = document.getElementById("rate").value;
    var adv_remark = document.getElementById("adv_remark").value
    // frt = freight_amt * ( 80 / 100 );
    // //  alert(frt);
    //         adv_total= diesel_adv_amt  +  cash_adv + other_cash_adv; 
    //         //  alert(adv_total);   
    // if(frt<adv_total){
    //     alert("Advance amount is more than Freight amouunt");
    //             return false;

    // }
    jQuery.ajax({
      type: 'POST',
      url: 'ajax/save_dispatch_adv.php',
      data: "dispatch_id=" + dispatch_id + "&adblue_id=" + adblue_id + "&adblueqty=" + adblueqty + "&rate=" + rate + "&pump_id=" + pump_id + "&diesel_rate=" + diesel_rate + "&diesel_ltr=" + diesel_ltr + "&diesel_adv_amt=" + diesel_adv_amt + "&cash_adv=" + cash_adv + "&cash_adv_date=" + cash_adv_date + "&other_cash_adv=" + other_cash_adv + "&other_cash_adv_date=" + other_cash_adv_date + "&consignor_cash_adv=" + consignor_cash_adv + "&consignor_cash_adv_date=" + consignor_cash_adv_date + "&consignee_cash_adv=" + consignee_cash_adv + "&consignee_cash_adv_date=" + consignee_cash_adv_date + "&adv_remark=" + adv_remark,
      success: function(data) {
        // jQuery('#advance').click();
        jQuery("#myModal9").modal('hide');
        location.reload();
      },
    });

  }


  function getrecentry() {
    var dispatch_id = document.getElementById("dispatch_id").value;
    var rec_wt = document.getElementById("rec_wt").value;
    var rec_qty = document.getElementById("rec_qty").value;
    var rec_date = document.getElementById("rec_date").value;
    var unloading_place = document.getElementById("unloading_place").value;
    var receive_type = document.getElementById("receive_type").value;



    var formData = new FormData();
    var file = $('#rec_img')[0].files[0];
    if (file) {
      formData.append('image', file);
    }

    formData.append("dispatch_id", dispatch_id);
    formData.append("rec_wt", rec_wt);
    formData.append("rec_qty", rec_qty);
    formData.append("rec_date", rec_date);
    formData.append("unloading_place", unloading_place);
    formData.append("receive_type", receive_type);

    jQuery.ajax({
      type: 'POST',
      url: 'ajax/save_dispatch_rec_single.php',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {

        jQuery('#reciving').click();
      },
    });
  }

  function updaterec() {
    var dispatch_id = document.getElementById("dispatch_id").value;
    var rec_wt = document.getElementById("rec_wt").value;
    var rec_qty = document.getElementById("rec_qty").value;
    var rec_date = document.getElementById("rec_date").value;
    var unloading_place = document.getElementById("unloading_place").value;
    var receive_type = document.getElementById("receive_type").value;


    // alert(receive_type);
    jQuery.ajax({
      type: 'POST',
      url: 'ajax/save_dispatch_rec_single.php',
      data: "dispatch_id=" + dispatch_id + "&rec_wt=" + rec_wt + "&rec_qty=" + rec_qty + "&rec_date=" + rec_date + "&unloading_place=" + unloading_place + "&receive_type=" + receive_type,
      success: function(data) {
        location.reload();
      },
    });
  }

  function savemultiple(dispatch_id) {
    var rec_wt = document.getElementById("rec_wt" + dispatch_id).value;
    var rec_qty = document.getElementById("rec_qty" + dispatch_id).value;
    var rec_date = document.getElementById("rec_date" + dispatch_id).value;
    var gps_km = document.getElementById("gps_km" + dispatch_id).value;
    var diffkm = document.getElementById("diffkm1" + dispatch_id).value;
    var ptpk = document.getElementById("ptpk" + dispatch_id).value;
    var frt_debit = document.getElementById("frt_debit" + dispatch_id).value;

    var unloading_place = document.getElementById("unloading_place" + dispatch_id).value;
    var receive_type = document.getElementById("receive_type" + dispatch_id).value;

    var formData = new FormData();
    var file = document.getElementById('rec_img' + dispatch_id).files[0];
    if (file) {
      formData.append('image', file);
    }

    formData.append("dispatch_id", dispatch_id);
    formData.append("rec_wt", rec_wt);
    formData.append("rec_qty", rec_qty);
    formData.append("rec_date", rec_date);
    formData.append("unloading_place", unloading_place);
    formData.append("receive_type", receive_type);
    formData.append("gps_km", gps_km);
    formData.append("diffkm", diffkm);
    formData.append("ptpk", ptpk);
    formData.append("frt_debit", frt_debit);

    // Validate required fields
    // if (rec_wt === '' || rec_date === '') {
    //     alert("Please fill the Required Details");
    //     return false;
    // }

    // Show loading message or spinner
    document.getElementById('msg' + dispatch_id).innerHTML = 'Saving...';

    jQuery.ajax({
      type: 'POST',
      url: 'ajax/save_dispatch_rec_multiple.php',
      data: formData,
      processData: false, // Important for sending FormData
      contentType: false, // Important for sending FormData
      success: function(data) {
        document.getElementById('msg' + dispatch_id).innerHTML = 'Save';
        // Optionally, handle the success response here
        console.log("Data saved successfully:", data);
      },
      error: function(xhr, status, error) {
        // Handle error response here
        document.getElementById('msg' + dispatch_id).innerHTML = 'Save failed';
        console.error("Error saving data:", status, error);
      }
    });
  }


  function getadvdelete(dispatch_id) {
    if (confirm("Do You want to Delete this record ?")) {
      jQuery.ajax({
        type: 'POST',
        url: 'ajax/delete_adv.php',
        data: "dispatch_id=" + dispatch_id,
        dataType: 'html',
        success: function(data) {
          jQuery('#advance').click();
        }
      }); //ajax close
    }
  }

  function getadvdelete1(dispatch_id) {
    if (confirm("Do You want to Delete this record ?")) {
      jQuery.ajax({
        type: 'POST',
        url: 'ajax/delete_adv.php',
        data: "dispatch_id=" + dispatch_id,
        dataType: 'html',
        success: function(data) {
          location.reload();
        }
      }); //ajax close
    }
  }
</script>


<script type="text/javascript">
  function getdispatch() {
    var dispatch_id = document.getElementById("dispatch_id").value;
    // alert(dispatch_id);
    jQuery.ajax({
      type: 'POST',
      url: 'ajax/dispatch_entrydetails.php',
      data: "dispatch_id=" + dispatch_id,
      dataType: 'html',
      success: function(data) {
        // alert(data);     
        arr = data.split("|");
        jQuery('#bilty_no').val(arr[0]);
        jQuery('#bilty_date').val(arr[1]);
        jQuery('#order_no').val(arr[2]);
        jQuery('#consignor_name1').val(arr[3]);
        jQuery('#consignee_name1').val(arr[4]);
        jQuery('#wt_mt').val(arr[5]);
        jQuery('#own_rate').val(arr[6]);
        jQuery('#freight_amt').val(arr[7]);
        jQuery('#vehicle_no1').val(arr[8]);
        jQuery('#owner_name').val(arr[9]);
        jQuery('#mobileno1').val(arr[10]);
        showdrecordd(dispatch_id);
        loadDeductionTotal(dispatch_id);
      }

    }); //ajax close
  }
</script>
<script type="text/javascript">
  function showrateintpa(consignee_id, vehicle_id, own_rate, wt_mt, balrate, balamt, editid) {

    if (isNaN(editid)) {
      editid = '';
    }
    // jQuery('#vehicle_id').val(vehicle_id);
    if (editid == '') {
      var balamt1 = own_rate * wt_mt;
      var own_rate1 = own_rate;
      // alert(balamt1);

    } else {
      var frt = own_rate * wt_mt;
      // alert(balamt);

      var balamt1 = frt - balamt;
      var own_rate1 = own_rate - balrate;
    }

    // alert(balamt);
    $('#myModal8').modal('show');
    jQuery("#tpaconsignee_id").val(consignee_id).trigger('change').trigger('select2:select');
    jQuery("#tpavehicle_id").val(vehicle_id).trigger('change').trigger('select2:select');
    jQuery('#tpaown_rate').val(own_rate1);
    jQuery('#tpawt_mt').val(wt_mt);
    jQuery('#balamt1').html(balamt1);
    jQuery('#balrate1').html(own_rate1);

  }

  function gettpacatid() {
    var tpavehicle_id = document.getElementById('tpavehicle_id').value;
    var tpaconsignee_id = document.getElementById('tpaconsignee_id').value;
    var tpcat_id = document.getElementById('tpcat_id').value;

    jQuery.ajax({
      type: 'POST',
      url: 'ajax/gettpacatid.php',
      data: "tpcat_id=" + tpcat_id + "&tpaconsignee_id=" + tpaconsignee_id + "&tpavehicle_id=" + tpavehicle_id,
      dataType: 'html',
      success: function(data) {
        // alert(data);     
        jQuery('#category_id').html(data);

      }
    }); //ajax close   
  }

  function getamt() {

    var rate = document.getElementById("rate").value;
    var wt_mt = document.getElementById("tpawt_mt").value;
    var amt = wt_mt * rate;
    jQuery('#amt').val(amt);
  }

  function getadblueamt() {
    var stock = document.getElementById("stock").value;
    var rate = document.getElementById("rate").value;
    var adblueqty = document.getElementById("adblueqty").value;
    if (stock < adblueqty) {
      alert('Quantity is more than Stock');
    }
    var amt = adblueqty * rate;
    jQuery('#consignor_cash_adv').val(amt);
  }

  function gettpaentry() {
    var tpcat_id = document.getElementById("tpcat_id").value;
    var category_id = document.getElementById("category_id").value;
    var wt_mt = document.getElementById("tpawt_mt").value;
    var dispatch_id = document.getElementById('editid').value;
    var rate = document.getElementById("rate").value;
    var amt = document.getElementById("amt").value;
    var tpa_id = document.getElementById('tpa_id').value;
    var tpaown_rate = document.getElementById('tpaown_rate').value;
    //  alert(tpa_id);

    var paid_to = document.getElementById("paid_to").value;

    var tparemark = document.getElementById("tparemark").value;
    if (tpcat_id == '' && amt == '') {
      alert("Please fill the details");
      return false;
    }

    if (category_id == '') {
      alert("Please fill the details");
      return false;
    }
    jQuery.ajax({
      type: 'POST',
      url: 'ajaxpayment/save_tp_adv.php',
      data: "tpcat_id=" + tpcat_id + "&category_id=" + category_id + "&tpaown_rate=" + tpaown_rate + "&wt_mt=" + wt_mt + "&rate=" + rate + "&amt=" + amt + "&paid_to=" + paid_to + "&tparemark=" + tparemark + "&dispatch_id=" + dispatch_id + "&tpa_id=" + tpa_id,
      success: function(data) {
        //  alert(data);
        showrecord();
        if (data == 1) {
          alert("ERROR: Duplicate Record...");
          return false;
        }
        jQuery("#tpcat_id").val('').trigger('change').trigger('select2:select');
        // jQuery("#category_id").val('');
        jQuery("#rate").val('');
        jQuery("#amt").val('');
        jQuery("#paid_to").val('paid_to');
        jQuery("#tparemark").val('tparemark');
        arr = data.split("|");
        jQuery('#balamt1').html(arr[0]);
        jQuery('#balrate1').html(arr[1]);
        jQuery('#paid_to').val(arr[2]).trigger('change').trigger('select2:select');
        jQuery('#tparemark').val(arr[3]);
      },
    });
  }

  function getadv(dispatch_id) {
    // alert(dispatch_id);
    jQuery.ajax({
      type: 'POST',
      url: 'ajax/adv_details.php',
      data: "dispatch_id=" + dispatch_id,
      dataType: 'html',
      success: function(data) {
        // alert(data);     
        jQuery("#updatedata").html(data);
      }
    }); //ajax close
  }

  function getrec(dispatch_id) {
    // alert(dispatch_id);
    jQuery.ajax({
      type: 'POST',
      url: 'ajax/rec_details.php',
      data: "dispatch_id=" + dispatch_id,
      dataType: 'html',
      success: function(data) {
        // alert(data);     
        jQuery("#recdata").html(data);
      }
    }); //ajax close
  }
</script>
<script type="text/javascript">
  function getadv1(dispatch_id) {
    // alert(dispatch_id);
    jQuery.ajax({
      type: 'POST',
      url: 'ajax/adv_details1.php',
      data: "dispatch_id=" + dispatch_id,
      dataType: 'html',
      success: function(data) {
        // alert(data);     
        jQuery("#updatedata").html(data);
      }
    }); //ajax close
  }




  //  function gettSubmit(){
  //  var dispatch_id = document.getElementById("dispatch_id").value;

  //  jQuery.ajax({
  //         type: 'POST',
  //         url: 'ajaxpayment/update_tp_adv.php',
  //         data: "dispatch_id="+dispatch_id,
  //         success: function(data){
  //           showrecord
  //           },
  //     });
  //  }


  function showrecord() {
    var dispatch_id = document.getElementById('editid').value;

    var tpa_id = document.getElementById('tpa_id').value;

    jQuery.ajax({
      type: 'POST',
      url: 'ajaxpayment/showrecord.php',
      data: 'dispatch_id=' + dispatch_id + '&tpa_id=' + tpa_id,
      dataType: 'html',
      success: function(data) {
        // alert(data);
        jQuery('#showrecord').html(data);
      }

    });
  }


  function getcategory() {
    // var dispatch_id = document.getElementById("dispatch_id").value; 
    var tpcat_id = document.getElementById("tpcat_id").value;
    jQuery.ajax({
      type: 'POST',
      url: 'ajaxpayment/getcategory.php',
      data: "tpcat_id=" + tpcat_id,
      dataType: 'html',
      success: function(data) {
        // alert(data);     
        jQuery('#category_id').html(data);

      }
    }); //ajax close   
  }


  function edittpa(tpa_id) {

    jQuery.ajax({
      type: 'POST',
      url: 'ajaxpayment/edittpa.php',
      data: 'tpa_id=' + tpa_id,
      dataType: 'html',
      success: function(data) {
        // alert(data);

        arr = data.split("|");
        jQuery('#rate').val(arr[0]);
        jQuery('#amt').val(arr[1]);
        jQuery('#tpcat_id').val(arr[2]).trigger('change').trigger('select2:select');
        jQuery('#tpa_id').val(arr[3]);
      }

    });
  }

  function funDel1(id) {

    var tablename = 'tpa_entry';
    var tableid = 'tpa_id';
    var dispatch_id = document.getElementById("editid").value;
    var wt_mt = document.getElementById("tpawt_mt").value;
    var tpaown_rate = document.getElementById('tpaown_rate').value;


    if (confirm("Do You want to Delete this record ?")) {
      // alert(dispatch_id);
      jQuery.ajax({
        type: 'POST',
        url: 'ajaxpayment/tpa_delete.php',
        data: 'id=' + id + '&tablename=' + tablename + '&tableid=' + tableid + '&dispatch_id=' + dispatch_id + '&tpaown_rate=' + tpaown_rate + '&wt_mt=' + wt_mt,
        dataType: 'html',
        success: function(data) {
          // alert(data);
          showrecord();
          arr = data.split("|");
          jQuery('#balamt1').html(arr[0]);
          jQuery('#balrate1').html(arr[1]);
        }
      }); //ajax close
    }
  }

  function getstock(id) {
    jQuery.ajax({
      type: 'POST',
      url: 'ajax/getstock.php',
      data: 'id=' + id,
      dataType: 'html',
      success: function(data) {
        // alert(data);
        arr = data.split("|");
        jQuery('#stock').val(arr[0]);
        jQuery('#stock1').html(arr[1]);


      }
    }); //ajax close
  }


  function save_deduction() {


    var dispatch_id = $('#dispatch_id1').val();
    var deduction_id = $('#deduction_id').val();
    var amount = $('#amount').val();
    var date = $('#date').val();
    var remark = $('#remark').val();
    var type = $('#deduct_type').val();

    if (dispatch_id == "") {
      alert("Please Select DI No First");
      return;
    }

    $.ajax({
      type: 'POST',
      url: 'ajax/save_deduct.php',
      data: {
        dispatch_id: dispatch_id,
        deduction_id: deduction_id,
        amount: amount,
        date: date,
        remark: remark,
        type: type
      },

      success: function(data) {

        if (data.trim() == "success") {



          $('#deduction_id').val('');
          $('#amount').val('');
          $('#date').val('');
          $('#remark').val('');
          $('#deduct_type').val('');


          showdrecordd(dispatch_id); // ⭐ ADD THIS LINE
          loadDeductionTotal(dispatch_id);


        } else {
          alert("Save Failed : " + data);
        }
      }

    });
  }

  function showdrecordd(dispatch_id) {

    $.ajax({
      type: 'POST',
      url: 'ajax/show_deductrec.php',
      data: {
        dispatch_id: dispatch_id
      },

      success: function(response) {

        var data = JSON.parse(response);

        $("#showdrecord").html(data.html);
      }
    });
  }

  function loadDeductionTotal(dispatch_id) {

    $.ajax({
      type: 'POST',
      url: 'ajax/show_damp1.php',
      data: {
        dispatch_id: dispatch_id
      },

      success: function(data) {
        // alert(data);
        $('#deduct').val(data)

      }
    });
  }

  function deleteDeduct(id, dispatch_id) {

    if (!confirm("Delete deduction?")) return;

    $.post("ajax/delete_deduct.php", {
      id: id,
      dispatch_id: dispatch_id
    }, function(data) {

      if ($.trim(data) == "success") {
        showdrecordd(dispatch_id);
      }

    });

  }

  function getsavedamt() {
    var dispatch_id = $('#dispatch_id1').val();
    $.post("ajax/savefdeduct.php", {
      dispatch_id: dispatch_id
    }, function(data) {

      if ($.trim(data) == "success") {
        jQuery("#myModald").modal('hide');
      }

    });

  }

  function getdamt() {
    // alert("ok");
    var dispatch_id = $('#dispatch_id').val();
    jQuery.ajax({
      type: 'POST',
      url: 'ajax/show_damp1.php',
      data: 'dispatch_id=' + dispatch_id,
      success: function(data) {
        // alert(data);

        jQuery("#deduct").val(data);
        jQuery("#myModald").modal('hide');
        // gettotal();
      }
    });
  }
  
  function getrate() {
    var destination_id = $('#destination_id').val();
    jQuery.ajax({
      type: 'POST',
      url: 'ajax/get_rate.php',
      data: 'destination_id=' + destination_id,
      success: function(data) {

        jQuery("#comp_rate").val(data);
        calcOwnRate();
      }
    });
  }

  function calcOwnRate() {
    var comp_rate = $('#comp_rate').val()|| 0;
    var ownRate = 0;

    if (comp_rate >= 1 && comp_rate <= 900) {
      ownRate = comp_rate - 30;
    }else if (comp_rate > 1500) {
      ownRate = comp_rate - 100;
    }
    else if (comp_rate > 900) {
      ownRate = comp_rate - 50;
    } 
    else {
      ownRate = 0;
    }
    $('#own_rate').val(ownRate);
  }
  
   function validateamt() {
    var comp_rate = $('#comp_rate').val() || 0;
    var own_rate = $('#own_rate').val() || 0;
    if (own_rate > comp_rate) {
      alert("Own Rate Can not be Greater Then Company Rate!");
      return false;
    }
  }
</script>