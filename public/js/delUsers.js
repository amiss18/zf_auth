/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



//$.noConflict();
jQuery(document).ready(function($) {
    $("#selec").click(function(event) {
      //  allCheck();
        var data = {'user_ids[]': []};
        $(":checked").each(function() {
            if($(this).val()!=='on')
           data['user_ids[]'].push($(this).val());
        
            
           
        });


        $.ajax({
            type: "POST",
            url: "/user/delete",
            data: data,
            success: function(data) {
                $('#resultat').html(data);
                console.log(data);
            },
            error: function(xhr) {
                alert("ERROR AJAX REQUEST!!!!!" + xhr.status);
            }

        });

        //end ajax
        return false;

    });
//}
});









/*  
 var rows=[];
 $("input[type='checkbox']:checked").each(
 function() {
 // console.log($(this).attr('name'));
 //alert('val='+$(this).attr('name')+"\n");
 rows=$(this).attr('name');
 
 }
 
 );*/



$.noConflict();
jQuery(document).ready(function($) {
    
    	$('#all').click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;                        
        });
    }else{
        
         $(':checkbox').each(function() {
            this.checked = false;                        
        });
    }
});
    
    


});