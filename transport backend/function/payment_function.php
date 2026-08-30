<script type="text/javascript">
  function getdetails(dispatch_id) {
    jQuery.ajax({
      type: 'POST',
      url: 'ajaxpayment/getdetails.php',
      data: "dispatch_id=" + dispatch_id,
      dataType: 'html',
      success: function(data) {
        // alert(data); 
        showrecord(dispatch_id);
        arr = data.split("|");
        jQuery('#truck_no').val(arr[0]);
        jQuery('#fromplace').val(arr[1]);
        jQuery('#toplace').val(arr[2]);
        jQuery('#ownername').val(arr[3]);
        jQuery('#itemname').val(arr[4]);
        jQuery('#wt_mt').val(arr[5]);
        jQuery('#ownrate').val(arr[6]);
        jQuery('#freightamt').val(arr[7]);
        jQuery('#balamt').html(arr[8]);
        jQuery('#balrate').html(arr[9]);
        jQuery('#paid_to').val(arr[10]).trigger('change').trigger('select2:select');
        jQuery('#tparemark').val(arr[11]);
      }
    }); //ajax close   
  }




  function funDelete2(id) {

    var tablename = 'tpa_entry';
    var tableid = 'tpa_id';


    if (confirm("Do You want to Delete this record ?")) {
      // alert(tableid);
      jQuery.ajax({
        type: 'POST',
        url: 'ajaxpayment/tpa_delete.php',
        data: 'id=' + id + '&tablename=' + tablename + '&tableid=' + tableid,
        dataType: 'html',
        success: function(data) {
          location.reload();
        }
      }); //ajax close
    }
  }

  function getname(tpcat_id) {
    // alert(tpcat_id);
    jQuery.ajax({
      type: 'POST',
      url: 'ajaxpayment/getname.php',
      data: 'tpcat_id=' + tpcat_id,
      dataType: 'html',
      success: function(data) {
        // alert(data);
        jQuery('#name').html(data);

      }

    });
  }

  function getname1(cat_id) {
    // alert(tpcat_id);
    jQuery.ajax({
      type: 'POST',
      url: 'ajaxpayment/getname1.php',
      data: 'cat_id=' + cat_id,
      dataType: 'html',
      success: function(data) {
        // alert(data);
        jQuery('#tpaname').html(data);

      }

    });
  }

  function getdi() {
    // alert("ok");
    var name = document.getElementById("name").value;
    var tpcat_id = document.getElementById("tpcat_id").value;
    // alert(tpcat_id);
    jQuery.ajax({
      type: 'POST',
      url: 'ajaxpayment/getdi.php',
      data: 'name=' + name + '&tpcat_id=' + tpcat_id,
      dataType: 'html',
      success: function(data) {
        // alert(data);
        jQuery('#dispatch_id').html(data);

      }

    });
  }

  function getdino() {
    // alert("ok");
    var tpaname = document.getElementById("tpaname").value;
    var catid = document.getElementById("catid").value;
    // alert(tpcat_id);
    jQuery.ajax({
      type: 'POST',
      url: 'ajaxpayment/getdino.php',
      data: 'tpaname=' + tpaname + '&catid=' + catid,
      dataType: 'html',
      success: function(data) {
        // alert(data);
        jQuery('#dispatch_id').html(data);

      }

    });
  }

  function getvalue() {
    var dispatch_id = document.getElementById("dispatch_id").value;
    var tpcat_id = document.getElementById("tpcat_id").value;
    // alert(tpcat_id);
    jQuery.ajax({
      type: 'POST',
      url: 'ajaxpayment/getvalue.php',
      data: 'dispatch_id=' + dispatch_id + '&tpcat_id=' + tpcat_id,
      dataType: 'html',
      success: function(data) {
        // alert(data);

        arr = data.split("|");
        jQuery('#bilty_date').val(arr[0]);
        jQuery('#vehicle_no').val(arr[1]);
        jQuery('#destination').val(arr[2]);
        jQuery('#wt_mt').val(arr[3]);
        jQuery('#rec_wt').val(arr[4]);
        jQuery('#comp_rate').val(arr[5]);
        jQuery('#own_rate').val(arr[6]);
        jQuery('#diesel_adv_amt').val(arr[7]);
        jQuery('#cash_adv').val(arr[8]);
        jQuery('#other_cash_adv').val(arr[9]);
        jQuery('#consignor_cash_adv').val(arr[10]);
        jQuery('#consignee_cash_adv').val(arr[11]);
        jQuery('#freight_amt').val(arr[12]);
        jQuery('#freight_rate').val(arr[13]);
        jQuery('#sortamt').val(arr[14]);
        jQuery('#paid_to').val(arr[15]);
        jQuery('#commision').val(arr[16]);
      }

    });
  }


  function showGst(billtype) {
    if (billtype == 'Invoice') {
      jQuery('#th1').show();
      jQuery('#th2').show();
      jQuery('#th3').show();
      jQuery('#th4').show();
      jQuery('#td1').show();
      jQuery('#td2').show();
    } else {

      jQuery('#th1').hide();
      jQuery('#th2').hide();
      jQuery('#th3').hide();
      jQuery('#th4').hide();
      jQuery('#td1').hide();
      jQuery('#td2').hide();
    }
  }

  function GstPaste(gst) {
    // alert('ok');
    var myStr = document.getElementById('sndata').value;
    // alert(myStr);
    if (confirm("Do you want to Copy for all GST")) {
      var strArray = myStr.split(",");
      for (var i = 0; i < strArray.length; i++) {
        document.getElementById('gstper' + strArray[i]).value = gst;

        getgstvalue(strArray[i]);
      }

    }
  }

  function gettds() {
    var tds = document.getElementById("tds").value;
    var freight_amt = document.getElementById("freight_amt").value;
    var tdsamt = freight_amt * tds / 100;
    jQuery('#tds_amt').val(tdsamt);
    gettotal();

  }

  function getgstvalue1() {
    var gstper = parseFloat(document.getElementById("gstper").value);
    var freight_amt = parseFloat(document.getElementById("freight_amt").value);
    gstamt = freight_amt * gstper / 100;
    // alert(gstamt);
    var netamt = freight_amt + gstamt;
    // netamt = freight_amt + gstamt;

    jQuery('#netamt1').val(netamt);
    gettotal();
  }

  function gettotal() {
    // alert("ok");
    var freight_amt = parseFloat(document.getElementById("freight_amt").value);

    var tds_amt = parseFloat(document.getElementById("tds_amt").value);
    var diesel_adv_amt = parseFloat(document.getElementById("diesel_adv_amt").value);
    var cash_adv = parseFloat(document.getElementById("cash_adv").value);
    var other_cash_adv = parseFloat(document.getElementById("other_cash_adv").value);
    var consignor_cash_adv = parseFloat(document.getElementById("consignor_cash_adv").value);
    var consignee_cash_adv = parseFloat(document.getElementById("consignee_cash_adv").value);
    var sortamt = parseFloat(document.getElementById("sortamt").value);
    var bilty_commision = document.getElementById("bilty_commision").value;

    var gstper = document.getElementById("gstper").value;
    // alert(gstper);
    var netamt1 = document.getElementById("netamt1").value;
    // alert(netamt1);
    if (bilty_commision == '') {
      jQuery('#bilty_commision').val(0);
    }
    if (netamt1 != '') {
      // alert("ok");
      var total = netamt1 - tds_amt - diesel_adv_amt - cash_adv - other_cash_adv - consignor_cash_adv - consignee_cash_adv - bilty_commision;
    } else {
      // alert("no");
      var total = freight_amt - tds_amt - diesel_adv_amt - cash_adv - other_cash_adv - consignor_cash_adv - consignee_cash_adv - bilty_commision;
    }
    jQuery('#total').val(total);
  }

  function gettotaltds(dispatch_id) {
    var tds = document.getElementById("tds" + dispatch_id).value;
    var freight_amt = document.getElementById("freight_amt" + dispatch_id).value;
    var tdsamt = freight_amt * tds / 100;

    jQuery('#tds_amt' + dispatch_id).val(tdsamt);
  }

  function getgstvalue(dispatch_id) {
    var gstper = parseFloat(document.getElementById("gstper" + dispatch_id).value);
    var freight_amt = parseFloat(document.getElementById("freight_amt" + dispatch_id).value);
    gstamt = freight_amt * gstper / 100;
    // alert(gstamt);
    var netamt = freight_amt + gstamt;
    // netamt = freight_amt + gstamt;
    // alert(netamt);
    jQuery('#netamt' + dispatch_id).val(netamt);
    gettotalamt(dispatch_id);
  }

  function getcmntamt(dispatch_id) {
    var sortqty = parseFloat(document.getElementById("sortqty" + dispatch_id).value);
    var cmtrate = parseFloat(document.getElementById("cmtrate" + dispatch_id).value);
    var sortamt = sortqty * cmtrate;
    jQuery('#sortamt' + dispatch_id).val(sortamt);
    gettotalamt(dispatch_id);
  }

  function gettotalamt(dispatch_id) {

    var freight_amt = document.getElementById("freight_amt" + dispatch_id).value;
    var frt_debit = document.getElementById("frt_debit" + dispatch_id).value;
    var bank_charge = document.getElementById("bank_charge" + dispatch_id).value;
    var tds_amt = document.getElementById("tds_amt" + dispatch_id).value;
    var diesel_adv_amt = document.getElementById("diesel_adv_amt" + dispatch_id).value;
    var deduct = document.getElementById("deduct" + dispatch_id).value;
    var cash_adv = document.getElementById("cash_adv" + dispatch_id).value;
    var other_cash_adv = document.getElementById("other_cash_adv" + dispatch_id).value;
    var rebidcharge = document.getElementById("rebidcharge" + dispatch_id).value;
    var consignor_cash_adv = document.getElementById("consignor_cash_adv" + dispatch_id).value;
    var consignee_cash_adv = document.getElementById("consignee_cash_adv" + dispatch_id).value;
    var sortamt = document.getElementById("sortamt" + dispatch_id).value;
    var bilty_commision = document.getElementById("bilty_commision" + dispatch_id).value;
    var netamt = document.getElementById("netamt" + dispatch_id).value;

    if (bank_charge == '') {
      jQuery('#bank_charge' + dispatch_id).val(0);
    }
    if (frt_debit == '') {
      jQuery('#frt_debit' + dispatch_id).val(0);
    }
    if (rebidcharge == '') {
      jQuery('#rebidcharge' + dispatch_id).val(0);
    }
    if (bilty_commision == '') {
      jQuery('#bilty_commision' + dispatch_id).val(0);
    }
    if (netamt != '') {
      // alert("ok");
      var total = netamt - tds_amt - diesel_adv_amt - deduct - cash_adv - frt_debit - other_cash_adv - consignor_cash_adv - consignee_cash_adv - bilty_commision - bank_charge - rebidcharge - sortamt;
    } else {
      // alert("no");
      var total = freight_amt - tds_amt - diesel_adv_amt - deduct - cash_adv - frt_debit - other_cash_adv - consignor_cash_adv - consignee_cash_adv - bilty_commision - bank_charge - rebidcharge - sortamt;
    }
    // alert(total);
    jQuery('#total_amt' + dispatch_id).val(total);


  }

  function getcat(cat_id) {

    jQuery.ajax({
      type: 'POST',
      url: 'ajaxpayment/getcat.php',
      data: 'cat_id=' + cat_id,
      dataType: 'html',
      success: function(data) {

        jQuery('#catname').html(data).trigger('change').trigger('select2:select');

      }

    });
  }

  function getallvalue(payment_id) {
    // alert("ok");
    var gstper = parseFloat(document.getElementById("gstper" + payment_id).value);
    var freight_amt = parseFloat(document.getElementById("freight_amt" + payment_id).value);
    var bank_charge = document.getElementById("bank_charge" + payment_id).value;
    var rebidcharge = document.getElementById("rebidcharge" + payment_id).value;
    var diesel_adv_amt = document.getElementById("diesel_adv_amt" + payment_id).value;
    var cash_adv = document.getElementById("cash_adv" + payment_id).value;
    var other_cash_adv = document.getElementById("other_cash_adv" + payment_id).value;
    var total = parseFloat(document.getElementById("total_amt" + payment_id).value);
    var tds = document.getElementById("tds" + payment_id).value;
    var sortamt = parseFloat(document.getElementById("sortamt" + payment_id).value);
    var bilty_commision = document.getElementById("bilty_commision" + payment_id).value;
    // var gstper = document.getElementById("gstper"+payment_id).value;


    if (bilty_commision == '') {
      jQuery('#bilty_commision' + payment_id).val(0);
    }
    if (gstper != '0') {
      gstamt = freight_amt * gstper / 100;
    }
    if (gstamt === undefined || gstamt === '') {
      var gstamt = 0;
    }
    //  alert(gstamt);
    var tdsamt = (freight_amt) * tds / 100;
    //  alert(tdsamt);
    jQuery('#tds_amt' + payment_id).val(tdsamt);
    var total1 = freight_amt - tdsamt - bilty_commision - bank_charge - rebidcharge - diesel_adv_amt - cash_adv - other_cash_adv + gstamt - sortamt;
    // alert(total1);
    jQuery('#total_amt' + payment_id).val(total1);

  }

  function editmultiple(payment_id) {

    var tds_amt = document.getElementById("tds_amt" + payment_id).value;

    var sortamt = document.getElementById("sortamt" + payment_id).value;

    var bilty_commision = document.getElementById("bilty_commision" + payment_id).value;
    var rebidcharge = document.getElementById("rebidcharge" + payment_id).value;

    var bank_charge = document.getElementById("bank_charge" + payment_id).value;
    var tds = document.getElementById("tds" + payment_id).value;

    var total_amt = document.getElementById("total_amt" + payment_id).value;

    var panno = document.getElementById("panno").value;
    var bill_type = document.getElementById("bill_type").value;
    var acc_no = document.getElementById("acc_no").value;
    var ifsc_code = document.getElementById("ifsc_code").value;
    // alert(bill_type);
    var gstper = document.getElementById("gstper" + payment_id).value;
    // alert(gstper);
    var gst_type = document.getElementById("gst_type").value;
    // alert(gst_type); 
    if (bill_type == 'Challan') {
      if (gstper != '0') {
        alert("Please Choose Invoice Bill Type for Gst ");
        return false;
      }

    }
    if (bill_type == '') {
      alert("Please Choose  Bill Type  ");
      return false;
    }
    if (total_amt == '') {
      alert("Please fill the Required Details ");
      return false;
    }
    if (bill_type == 'Invoice') {
      if (gstper == '') {
        alert("Please Add Gst ");
        return false;
      }

    }


    jQuery.ajax({
      type: 'POST',
      url: 'ajaxpayment/edit_multiple.php',
      data: "payment_id=" + payment_id + "&bank_charge=" + bank_charge + "&rebidcharge=" + rebidcharge + "&tds_amt=" + tds_amt + "&sortamt=" + sortamt + "&bilty_commision=" + bilty_commision + "&panno=" + panno + "&tds=" + tds + "&total_amt=" + total_amt + "&gstper=" + gstper + "&bill_type=" + bill_type + "&gst_type=" + gst_type + "&acc_no=" + acc_no + "&ifsc_code=" + ifsc_code,
      success: function(data) {
        // alert(data);
        document.getElementById('msg' + payment_id).innerHTML = 'Save';
      },
    });
  }

  function editbulkvid() {

    var voucher_id = document.getElementById("voucher_id").value;
    var voucher_date = document.getElementById("voucher_date").value;
    var remark = document.getElementById("remark").value;
    var payee_name = document.getElementById("payee_name").value;
    if (voucher_date == '' || payee_name == '') {
      alert("Please fill the Required Details ");
      return false;
    }

    jQuery.ajax({
      type: 'POST',
      url: 'ajaxpayment/editbulkvid.php',
      data: "voucher_date=" + voucher_date + "&remark=" + remark + "&payee_name=" + payee_name + "&voucher_id=" + voucher_id,
      success: function(data) {


        location.href = 'voucher_report.php';




      },

    });



  }

  function savemultiple(dispatch_id) {

    var tds_amt = document.getElementById("tds_amt" + dispatch_id).value;

    var sortamt = document.getElementById("sortamt" + dispatch_id).value;

    var bilty_commision = document.getElementById("bilty_commision" + dispatch_id).value;
    var bank_charge = document.getElementById("bank_charge" + dispatch_id).value;
    var paid_to = document.getElementById("paid_to" + dispatch_id).value;

    var tds = document.getElementById("tds" + dispatch_id).value;
    var diesel_adv_amt = document.getElementById("diesel_adv_amt" + dispatch_id).value;
    var rebidcharge = document.getElementById("rebidcharge" + dispatch_id).value;
    var cash_adv = document.getElementById("cash_adv" + dispatch_id).value;
    var other_cash_adv = document.getElementById("other_cash_adv" + dispatch_id).value;
    var consignor_cash_adv = document.getElementById("consignor_cash_adv" + dispatch_id).value;
    var consignee_cash_adv = document.getElementById("consignee_cash_adv" + dispatch_id).value;
    var total_amt = document.getElementById("total_amt" + dispatch_id).value;
    var freight_rate = document.getElementById("freight_rate" + dispatch_id).value;
    var commision = document.getElementById("commision" + dispatch_id).value;
    var catname = document.getElementById("catname").value;
    var freight_amt = document.getElementById("freight_amt" + dispatch_id).value;
    var deduct = document.getElementById("deduct" + dispatch_id).value;
    var frt_debit = document.getElementById("frt_debit" + dispatch_id).value;
    // alert("ok");
    var cmtrate = document.getElementById("cmtrate" + dispatch_id).value;
    // alert("ok1");
    var cat_id = document.getElementById("cat_id").value;
    var bill_type = document.getElementById("bill_type").value;
    var acc_no = document.getElementById("acc_no").value;
    var ifsc_code = document.getElementById("ifsc_code").value;
    var panno = document.getElementById("panno").value;
    // alert(frt_debit);
    var gstper = document.getElementById("gstper" + dispatch_id).value;
    // alert(gstper);
    var gst_type = document.getElementById("gst_type").value;
    // alert(bank_charge); 
    if (bill_type == 'Challan') {
      if (gstper != '') {
        alert("Please Choose Invoice Bill Type for Gst ");
        return false;
      }

    }
    if (bill_type == '') {
      alert("Please Choose  Bill Type  ");
      return false;
    }
    if (total_amt == '') {
      alert("Please fill the Required Details ");
      return false;
    }
    if (bill_type == 'Invoice') {
      if (gstper == '') {
        alert("Please Add Gst ");
        return false;
      }

    }
    //     if(catname == '')
    // {
    //     alert("Please select the Name");
    //     return false;
    // }
    jQuery.ajax({
      type: 'POST',
      url: 'ajaxpayment/save_multiple.php',
      data: "dispatch_id=" + dispatch_id + "&deduct=" + deduct + "&tds_amt=" + tds_amt + "&frt_debit=" + frt_debit + "&cmtrate=" + cmtrate + "&rebidcharge=" + rebidcharge + "&bank_charge=" + bank_charge + "&sortamt=" + sortamt + "&bilty_commision=" + bilty_commision + "&paid_to=" + paid_to + "&tds=" + tds + "&total_amt=" + total_amt + "&commision=" + commision + "&freight_amt=" + freight_amt + "&freight_rate=" + freight_rate + "&cat_id=" + cat_id + "&catname=" + catname + "&diesel_adv_amt=" + diesel_adv_amt + "&cash_adv=" + cash_adv + "&other_cash_adv=" + other_cash_adv + "&consignor_cash_adv=" + consignor_cash_adv + "&consignee_cash_adv=" + consignee_cash_adv + "&gstper=" + gstper + "&bill_type=" + bill_type + "&gst_type=" + gst_type + "&panno=" + panno + "&acc_no=" + acc_no + "&ifsc_code=" + ifsc_code,
      success: function(data) {
        // alert(data);
        document.getElementById('msg' + dispatch_id).innerHTML = 'Save';
      },
    });
  }

  function savesinglevoucher() {

    var tds_amt = document.getElementById("tds_amt").value;
    var dispatch_id = document.getElementById("dispatch_id").value;

    var sortamt = document.getElementById("sortamt").value;

    var bilty_commision = document.getElementById("bilty_commision").value;

    var paid_to = document.getElementById("paid_to").value;

    var tds = document.getElementById("tds").value;

    var total = document.getElementById("total").value;

    var commision = document.getElementById("commision").value;
    var freight_rate = document.getElementById("freight_rate").value;
    var freight_amt = document.getElementById("freight_amt").value;
    var payee_name = document.getElementById("payee_name").value;
    var name = document.getElementById("name").value;
    var payment_date = document.getElementById("payment_date").value;
    var diesel_adv_amt = document.getElementById("diesel_adv_amt").value;
    var cash_adv = document.getElementById("cash_adv").value;
    var other_cash_adv = document.getElementById("other_cash_adv").value;
    var consignor_cash_adv = document.getElementById("consignor_cash_adv").value;
    var consignee_cash_adv = document.getElementById("consignee_cash_adv").value;
    var bill_type = document.getElementById("bill_type").value;
    var gst_type = document.getElementById("gst_type").value;
    var gstper = document.getElementById("gstper").value;
    // alert(payment_date);
    var acc_no = document.getElementById("acc_no").value;
    var ifsc_code = document.getElementById("ifsc_code").value;
    var remark = document.getElementById("remark").value;
    var tpcat_id = document.getElementById("tpcat_id").value;
    // alert(tpcat_id);
    if (bill_type == 'Challan') {
      if (gstper != '') {
        alert("Please Choose Invoice Bill Type for Gst ");
        return false;
      }

    }
    if (bill_type == 'Invoice') {
      if (gstper == '') {
        alert("Please Add Gst ");
        return false;
      }

    }
    if (bill_type == '') {
      alert("Please Choose  Bill Type  ");
      return false;
    }
    if (payment_date == '' || total == '') {
      alert("Please fill the Required Details ");
      return false;
    }

    jQuery.ajax({
      type: 'POST',
      url: 'ajaxpayment/save_single.php',
      data: "dispatch_id=" + dispatch_id + "&tds_amt=" + tds_amt + "&sortamt=" + sortamt + "&bilty_commision=" + bilty_commision + "&paid_to=" + paid_to + "&tds=" + tds + "&total=" + total + "&commision=" + commision + "&freight_amt=" + freight_amt + "&payment_date=" + payment_date + "&remark=" + remark + "&tpcat_id=" + tpcat_id + "&payee_name=" + payee_name + "&name=" + name + "&freight_rate=" + freight_rate + "&diesel_adv_amt=" + diesel_adv_amt + "&cash_adv=" + cash_adv + "&other_cash_adv=" + other_cash_adv + "&consignor_cash_adv=" + consignor_cash_adv + "&consignee_cash_adv=" + consignee_cash_adv + "&bill_type=" + bill_type + "&gst_type=" + gst_type + "&gstper=" + gstper + "&acc_no=" + acc_no + "&ifsc_code=" + ifsc_code,
      success: function(data) {
        // alert(data);
        document.getElementById('msg').innerHTML = 'Save';
        jQuery('#ventry').click();
      },
    });
  }

  function savebulkvid() {


    var voucher_date = document.getElementById("voucher_date").value;
    var remark = document.getElementById("remark").value;
    var cat_id = document.getElementById("cat_id").value;
    var payee_name = document.getElementById("payee_name").value;

    if (voucher_date == '' || payee_name == '') {
      alert("Please fill the Required Details ");
      return false;
    }

    jQuery.ajax({
      type: 'POST',
      url: 'ajaxpayment/savebulkvid.php',
      data: "voucher_date=" + voucher_date + "&remark=" + remark + "&payee_name=" + payee_name + "&cat_id=" + cat_id,
      success: function(data) {
        location.href = "payment-process.php";
        //  jQuery('#ventry').click();
      },
    });
  }


  function getsearch() {
    // alert("ok");
    var cat_id = document.getElementById("cat_id").value;
    var catname = document.getElementById("catname").value;
    var fromdate = document.getElementById("fromdate").value;
    var todate = document.getElementById("todate").value;
    var item_id = document.getElementById("item_id").value;
    var vehicle_id = document.getElementById("vehicle_id").value;

    jQuery.ajax({
      type: 'POST',
      url: 'ajaxpayment/mulvoucherdetails.php',
      data: "cat_id=" + cat_id + "&catname=" + catname + "&fromdate=" + fromdate + "&todate=" + todate + "&item_id=" + item_id + "&vehicle_id=" + vehicle_id,
      dataType: 'html',
      success: function(data) {
        //   alert(data);     
        jQuery("#vouchertable").html(data);
      }
    }); //ajax close   
  }

  function getvoucherno(tpcat_id) {
    jQuery.ajax({
      type: 'POST',
      url: 'ajaxpayment/getvoucherno.php',
      data: "tpcat_id=" + tpcat_id,
      dataType: 'html',
      success: function(data) {

        // alert(data);
        jQuery('#voucher_no').html(data);

      }
    }); //ajax close    
  }

  function vouchdetail() {
    var tpcat_id = document.getElementById("tpcat_id").value;
    var voucher_no = document.getElementById("voucher_no").value;
    // alert(voucher_no);
    jQuery.ajax({
      type: 'POST',
      url: 'ajaxpayment/vouchdetail.php',
      data: "voucher_no=" + voucher_no + "&tpcat_id=" + tpcat_id,
      dataType: 'html',
      success: function(data) {

        //   alert(data);

        arr = data.split("|");
        jQuery('#voucher_name').val(arr[0]);
        jQuery('#amt_paid_to').val(arr[1]);
        jQuery('#balance_amt').val(arr[2]);
        jQuery('#rec_no').val(arr[3]);
        jQuery('#catname').val(arr[4]);
        jQuery('#payee_name').val(arr[5]);
        jQuery('#accountno').html(arr[6]);
        jQuery('#Ifsccode').html(arr[7]);
        jQuery('#Panno').html(arr[8]);

      }
    }); //ajax close    
  }




  function savevoucherpayment() {

    var tpcat_id = document.getElementById("tpcat_id").value;
    var voucher_no = document.getElementById("voucher_no").value;

    var bankid = document.getElementById("bankid").value;
    var utrno = document.getElementById("utrno").value;
    var voucher_name = document.getElementById("voucher_name").value;

    var receive_amt = document.getElementById("receive_amt").value;
    var catname = document.getElementById("catname").value;
    var receive_date = document.getElementById("receive_date").value;
    var pay_mode = document.getElementById("pay_mode").value;
    // alert(pay_mode);
    var remark = document.getElementById("remark").value;
    // alert(voucher_no);
    if (receive_date == '' || receive_amt == '') {
      alert("Please fill the Required Details ");
      return false;
    }

    jQuery.ajax({
      type: 'POST',
      url: 'ajaxpayment/savevoucherpayment.php',
      data: "tpcat_id=" + tpcat_id + "&voucher_no=" + voucher_no + "&bankid=" + bankid + "&utrno=" + utrno + "&catname=" + catname + "&voucher_name=" + voucher_name + "&receive_amt=" + receive_amt + "&receive_date=" + receive_date + "&remark=" + remark + "&pay_mode=" + pay_mode,
      success: function(data) {
        // alert(data);

        jQuery('#vpayment').click();


      },
    });
  }



  function getPayeeDetails(payee_name) {

    jQuery.ajax({
      type: 'POST',
      url: 'ajaxpayment/getPayeeDetails.php',
      data: "payee_name=" + payee_name,
      dataType: 'html',
      success: function(data) {

        //   alert(data);

        arr = data.split("|");
        jQuery('#acc_no').val(arr[0]);
        jQuery('#ifsc_code').val(arr[1]);
        jQuery('#panno').val(arr[2]);

      }
    }); //ajax clo


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
          //   alert(data);
          jQuery("#ref_id").val(dispatch_id);
          jQuery("#type").val(type);
          jQuery("#myModal").modal('show');
          //	jQuery("#getotp").html(data);

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

            //alert("ok");
            jQuery("#myModal").modal('hide');

            jQuery("#otp").val('');
            jQuery("#type").val('');
            if (type == 'edit') {
              location = "voucheredit.php?editid=" + ref_id;
            }
            if (type == 'del') {
              voucherdelete(ref_id);
            }
          } else
            // jQuery("#otp").val('');
            alert("Wrong OTP");
        }
      }); //ajax close

    }

  }
</script>