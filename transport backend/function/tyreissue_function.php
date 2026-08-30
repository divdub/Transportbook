 <script type="text/javascript">
function getissue(id){
         var issue_cate = document.getElementById('issue_cate'+id).value;
         var iteminv_id = document.getElementById('iteminv_id'+id).value;
    $.ajax({
         type: 'POST',
         url: 'ajaxtyreissue/show_items.php',
         data: 'issue_cate='+issue_cate+'&iteminv_id='+iteminv_id,
         dataType: 'html',
         success: function(data){
             //alert(data);
                jQuery('#pos_id'+id).html(data);
            
 
 
         
         }
      });//ajax close	
 
    }
    </script>