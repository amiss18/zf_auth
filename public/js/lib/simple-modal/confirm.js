/*
 * SimpleModal Confirm Modal Dialog
 * http://simplemodal.com
 *
 * Copyright (c) 2013 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 */
$.noConflict();
jQuery(document).ready(function($) {
 //debut
 
 
	$('#confirm-dialog input.confirm, #confirm-dialog a.confirm').click(function (e) {
		e.preventDefault();
                
               //
              // $("#selec").click(function(event) {
      //  allCheck();
        var data = {'user_ids[]': []};
        $(":checked").each(function() {
            if($(this).val()!=='on')
           data['user_ids[]'].push($(this).val());
           
        });//fin recuperation

               
		confirm("Etes-vous sûr de supprimer?", function () {
                // window.location.href = $('#confirm-dialog a').attr('href');
                 //#######"exécution de la requête ajax

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

        //###########end ajax
                 
		
		});
	});


function confirm(message, callback) {
	$('#confirm').modal({
		closeHTML: "<a href='#' title='Close' class='modal-close'>x</a>",
		position: ["20%",],
		overlayId: 'confirm-overlay',
		containerId: 'confirm-container', 
		onShow: function (dialog) {
			var modal = this;

			$('.message', dialog.data[0]).append(message);

			// if the user clicks "yes"
			$('.yes', dialog.data[0]).click(function () {
				// call the callback
				if ($.isFunction(callback)) {
					callback.apply();
				}
				// close the dialog
				modal.close(); // or $.modal.close();
			});
		}
	});
}

 
   //######## cocher toutes les cases
 
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
        });//fin click
 
 //fin
});//end jquery

/*
jQuery(function ($) {
	$('#confirm-dialog input.confirm, #confirm-dialog a.confirm').click(function (e) {
		e.preventDefault();

		confirm("Etes-vous sûr de supprimer?", function () {
                 window.location.href = $('#confirm-dialog a').attr('href');
		// window.location.href = $('a .confirm').attr('href');
	           // $(location).$('a .confirm').attr('href');
		// return true;
		});
	});
});

function confirm(message, callback) {
	$('#confirm').modal({
		closeHTML: "<a href='#' title='Close' class='modal-close'>x</a>",
		position: ["20%",],
		overlayId: 'confirm-overlay',
		containerId: 'confirm-container', 
		onShow: function (dialog) {
			var modal = this;

			$('.message', dialog.data[0]).append(message);

			// if the user clicks "yes"
			$('.yes', dialog.data[0]).click(function () {
				// call the callback
				if ($.isFunction(callback)) {
					callback.apply();
				}
				// close the dialog
				modal.close(); // or $.modal.close();
			});
		}
	});
}
*/