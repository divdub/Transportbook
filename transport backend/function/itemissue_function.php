  <script type="text/javascript">
  function showItems(issue_cate){
      //alert("okk");
 	jQuery.ajax({
		  type: 'POST',
		  url: 'ajaxissue/ajaxshow_items.php',
		  data: 'issue_cate='+issue_cate,
		  dataType: 'html',
		  success: function(data){				  
 	alert(data);				
			jQuery('#iteminv_id').html(data);
		
			}
			
		  });//ajax close   
}


function getDetails(){
   
    var iteminv_id = document.getElementById('iteminv_id').value;
	var issue_cate = document.getElementById('issue_cate').value;

    $.ajax({
			type: 'POST',
			url: 'ajaxissue/show_purchase_details1.php',
			data: 'iteminv_id='+iteminv_id+'&issue_cate='+issue_cate,
			dataType: 'html',
			success: function(data){
			//alert(data);
				arr = data.split("|");
		$('#unitname').val(arr[0]);
		$('#stock').val(arr[1]);
			$('#iteminv_category_id').val(arr[2]);

		
document.getElementById('stockin').innerHTML='Stock : '+(arr[1]);

			
			}
		});//ajax close	
}


function addlist()
{
     	var iteminv_id= document.getElementById('iteminv_id').value; 
		var  vehicle_id= document.getElementById('vehicle_id').value; 
		
    	var  unitname= document.getElementById('unitname').value; 
    		  
	 	stock= parseFloat(document.getElementById('stock').value); 
	 
	   qty= parseFloat(document.getElementById('qty').value);	 
	var  iteminv_category_id= document.getElementById('iteminv_category_id').value;	 
	var  returnitem_id= document.getElementById('returnitem_id').value;	 

// 		alert(stock);
	var  remark1= document.getElementById('remark1').value;	
	var  is_rep= document.getElementById('is_rep').value;	

		var  issue_cate= document.getElementById('issue_cate').value; 
	var issueid=document.getElementById('issueid').value;	
	var issuedetailid=0;
	
		if(qty > stock)
	{
		alert('Quantity Is More than Stock');	
		return false;
	}
		
	if(qty =='')
	{
		alert('Quantity cant be blank');	
		return false;
	}	 
	else
	{
		alert("okkk");
		jQuery.ajax({
		  type: 'POST',
		  url: 'ajaxissue/save_issueproduct1.php',
		  data: 'iteminv_id='+iteminv_id+'&unitname='+unitname+'&issue_cate='+issue_cate+'&vehicle_id='+vehicle_id+'&iteminv_category_id='+iteminv_category_id+'&qty='+qty+'&issueid='+issueid+'&issuedetailid='+issuedetailid+'&is_rep='+is_rep+'&returnitem_id='+returnitem_id+'&remark1='+remark1,
		  dataType: 'html',
		  success: function(data){				  
  		alert(data);
		if(data==3){
		    alert("Error : Duplicate Record");
		}
			jQuery('#purdetail_id').val('');
			$("#purdetail_id").select2().select2('val','');
			jQuery('#is_rep').val('');
			jQuery('#returnitem_id').val('');
			jQuery('#remark1').val('');
			jQuery('#unit_name').val('');		  
			jQuery('#qty').val('');
			jQuery('#stock').val('');
				jQuery('#stockin').html('');
				$("#iteminv_id").select2().select2('val','');
					$("#issue_cate").select2().select2('val','');
			getrecord(<?php echo $keyvalue; ?>)
			
			}
			
		  });//ajax close
	}
}

function getrecord(){
   
	  var issueid=jQuery("#issueid").val();	
	   
			  jQuery.ajax({
			  type: 'POST',
			  url: 'ajaxissue/show_issuerecord.php',
			   data: "issueid="+issueid,
			  dataType: 'html',
			  success: function(data){				  
				 //alert(data);
					jQuery('#showissuerecord').html(data);
				//	setTotalrate();		
					jQuery('#purdetail_id').focus();	
				}				
			  });//ajax close								
	}
	
	
function deleterecord(id)
{    
	  
	  tblname = 'issueentrydetail';
	   tblpkey = 'issuedetailid';
	   pagename  ='<?php echo $pagename; ?>';
		modulename  ='<?php echo $modulename; ?>';
	  
	if(confirm("Are you sure! You want to delete this record."))
	{
		$.ajax({
		  type: 'POST',
		  url: 'ajaxissue/delete_issue.php',
		  data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename,
		  dataType: 'html',
		  success: function(data){
			 	getrecord(<?php echo $keyvalue; ?>);
			}
		
		  });//ajax close
	}//confirm close
} //fun close
	
 function funDelnew(id)
    {
      tblname = 'issueentry';
      tblpkey = 'issueid';
      pagename = '';
    
      if (confirm("Are you sure! You want to delete this record."))
      {
        $.ajax({
          type: 'POST',
          url: 'ajaxissue/delete_issue.php',
          data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename,
          dataType: 'html',
          success: function(data) {
            location = pagename + '?action=10';

          }



        }); //ajax close

      } //confirm close

    } //fun close

	
	
  </script>