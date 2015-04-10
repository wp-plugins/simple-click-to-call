jQuery(document).ready(function($) {

    $('#simple-click-to-call-form').validate({
		rules: {
			'simple-click-to-call-codigo-pais': {
				required: true,
				number: true
			},
			'simple-click-to-call-codigo-area': {
				required: true,
				number: true
			},
			'simple-click-to-call-numero': {
				required: true,
				number: true
			}
		},
		showErrors: function(errorMap, errorList) {
			if (this.numberOfInvalids() > 0) {
				$('#simple-click-to-call-message').stop().html('<p id="simple-click-to-call-message-error">' + options.message_error + '</p>').slideDown(500);
			} else{
				$('#simple-click-to-call-message').stop().slideUp(500, function(){
					$(this).html('');
				});
			}
		},
		submitHandler: function(form) {
			$.ajax({
				url: options.ajaxurl,
				type: $(form).attr('method'),
				data: $(form).serialize() + '&action=revisionalpha_simpleclicktocall_ajax_callback',
				dataType: 'json',
				beforeSend: function(){
					$('#simple-click-to-call-form input').attr('disabled', true);
					$('#simple-click-to-call-form input').attr('readonly', true);
					$('#simple-click-to-call-message').stop().slideUp(500, function(){
						$(this).html('');
					});
					$('#simple-click-to-call-submit').stop().slideUp(500, function(){
						$('#simple-click-to-call-message').stop().html('<p id="simple-click-to-call-message-wait">' + options.message_wait + '</p>').slideDown(500);
					});
				},
				success: function(data){
					setTimeout(function(){
						if(!data.error){
							$('#simple-click-to-call-message').stop().slideUp(500, function(){
								$(this).html('');
								$(this).stop().html('<p id="simple-click-to-call-message-comunicacion-ok">' + options.message_comunicacion_ok + '</p>').slideDown(500);
							});
						} else{
							$('#simple-click-to-call-message').stop().slideUp(500, function(){
								$(this).html('');
								$('#simple-click-to-call-form input').removeAttr('disabled');
								$('#simple-click-to-call-form input').removeAttr('readonly');
								$('#simple-click-to-call-submit').stop().slideDown(500);
								$(this).stop().html('<p id="simple-click-to-call-message-comunicacion-error">' + options.message_comunicacion_error + '</p>').slideDown(500);
							});
						}
					}, 2000);
				}
			});
		}
    });
    
});