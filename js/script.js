/**
 * Global variables.
 */
var alertMessage = '<div class="alert alert-ALERTTYPE fade in">' +
	'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
	'<p>MESSAGE</p>' +
	'</div>';


/**
 * Functions.
 */
function displayAlert( type, message )
{
	var messageBox = alertMessage.replace( 'ALERTTYPE', type );
	messageBox = messageBox.replace( 'MESSAGE', message );
    $('#messages-container').html( messageBox );
}

function displayError( message )
{
	displayAlert( 'danger', message );
}

function displaySuccess( message )
{
	displayAlert( 'success', message );
}

function setMasks()
{
	$('#generate-component input[name="creation_date"]').mask('99/99/9999');
}

function setNextButtons()
{
	$('.next').click( function ()
	{
		$('.nav-tabs .active').next('a').trigger('click');
	});
}


/**
 * Main execution.
 */
$(document).ready( function () 
{
	setMasks();

	setNextButtons();

	$('#generate-component').submit( function ()
	{
		var btn = $('#generate-component button[type="submit"]');
		btn.button('loading');

		var data = {};

		$('#generate-component input[type="text"]').each( function()
		{
			data[$(this).attr('name')] = $(this).val();
		});

		$.ajax({
            type: 'POST',
            url: 'lib/generate-component.php',
            dataType: "json",
            data: data
        })
        .done( function( resultado )
        {
            if ( resultado.success == 0 ) displayError( resultado.message );
            else displaySuccess( resultado.message );
        })
        .fail( function () 
        {
        	displayError( 'Execution failed. Contact the developers.' );
        })
        .always( function ()
    	{
    		btn.button('reset')
    	});
		
		return false;
	});
});