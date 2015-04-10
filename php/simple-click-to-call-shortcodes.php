<?php

add_shortcode( 'simple-click-to-call-form', 'revisionalpha_simpleclicktocall_form' );

function revisionalpha_simpleclicktocall_form()
{
	$estado = get_option('revisionalpha_simpleclicktocall_estado');
	
	if ( get_option('revisionalpha_simpleclicktocall_options') )
	{
		$options = get_option('revisionalpha_simpleclicktocall_options');
	}
	else
	{
		$options = get_option('revisionalpha_simpleclicktocall_options_default');
	}
	
	if ( get_option('revisionalpha_simpleclicktocall_form_settings') )
	{
		$form_settings = get_option('revisionalpha_simpleclicktocall_form_settings');
	}
	else
	{
		$form_settings = get_option('revisionalpha_simpleclicktocall_form_settings_default');
	}
	
	function in_range( $days, $desde, $hasta )
	{
		date_default_timezone_set( 'America/Argentina/Buenos_Aires' );
		
		$now_time = date( 'H:i' );
		$now_day = date( 'w' );
		
		$desde_ts = strtotime( $desde );
		$hasta_ts = strtotime( $hasta );
		$now_time_ts = strtotime( $now_time );
		$now_day_ts = strtotime( $now_day );
		
		return ( in_array( $now_day, $days ) && ( $now_time_ts >= $desde_ts ) && ( $now_time_ts <= $hasta_ts ) );
	}
	
	$revisionalpha_simpleclicktocall_form = null;
	
	if ( $estado == 1 )
	{
		$revisionalpha_simpleclicktocall_form .= '<div id="simple-click-to-call">';	
		
		if ( in_range( $options['simple-click-to-call-dias'], $options['simple-click-to-call-hora-inicio'], $options['simple-click-to-call-hora-final'] ) )
		{
		
		$revisionalpha_simpleclicktocall_form .= '<form action="" method="POST" id="simple-click-to-call-form">';
			if ( $form_settings['simple-click-to-call-codigo-pais-mostrar'] == 0 )
			{
				$revisionalpha_simpleclicktocall_form .= '<input type="hidden" name="simple-click-to-call-codigo-pais" value="'. $form_settings['simple-click-to-call-codigo-pais-default'] .'">';
			}
			
			if ( !empty( $form_settings['simple-click-to-call-description'] ) )
			{
				$revisionalpha_simpleclicktocall_form .= '<p id="simple-click-to-call-description">' . $form_settings['simple-click-to-call-description'] . '</p>';
			}
			
			$revisionalpha_simpleclicktocall_form .= '<fieldset>';
			
			if ( $form_settings['simple-click-to-call-codigo-pais-mostrar'] == 1 )
			{
				if ( !empty( $form_settings['simple-click-to-call-codigo-pais-text'] ) )
				{
					if ( $form_settings['simple-click-to-call-codigo-pais-placeholder'] == 0 )
					{
						$revisionalpha_simpleclicktocall_form .= '<label>' . $form_settings['simple-click-to-call-codigo-pais-text'] . '</label>';
					}
				}
				
				$revisionalpha_simpleclicktocall_form .= '<input type="text" name="simple-click-to-call-codigo-pais" minlength="2" maxlength="4" size="4"';
				
				if ( $form_settings['simple-click-to-call-codigo-pais-placeholder'] == 1 )
				{
					$revisionalpha_simpleclicktocall_form .= ' placeholder="' . $form_settings['simple-click-to-call-codigo-pais-text'] . '"';
				}
				
				$revisionalpha_simpleclicktocall_form .= ' value="'. $form_settings['simple-click-to-call-codigo-pais-default'] .'">';
			}
			
				
			if ( !empty( $form_settings['simple-click-to-call-codigo-area-text'] ) )
			{
				if ( $form_settings['simple-click-to-call-codigo-area-placeholder'] == 0 )
				{
					$revisionalpha_simpleclicktocall_form .= '<label>' . $form_settings['simple-click-to-call-codigo-area-text'] . '</label>';
				}
			}
			
			$revisionalpha_simpleclicktocall_form .= '<input type="text" name="simple-click-to-call-codigo-area" minlength="2" maxlength="4" size="4"';
			
			if ( $form_settings['simple-click-to-call-codigo-area-placeholder'] == 1 )
			{
				$revisionalpha_simpleclicktocall_form .= ' placeholder="' . $form_settings['simple-click-to-call-codigo-area-text'] . '"';
			}
			
			$revisionalpha_simpleclicktocall_form .= ' value="'. $form_settings['simple-click-to-call-codigo-area-default'] .'">';
				
			
			if ( !empty( $form_settings['simple-click-to-call-numero-text'] ) )
			{
				if ( $form_settings['simple-click-to-call-numero-placeholder'] == 0 )
				{
					$revisionalpha_simpleclicktocall_form .= '<label>' . $form_settings['simple-click-to-call-numero-text'] . '</label>';
				}
			}
			
			$revisionalpha_simpleclicktocall_form .= '<input type="text" name="simple-click-to-call-numero" minlength="6" maxlength="10"';
			
			if ( $form_settings['simple-click-to-call-numero-placeholder'] == 1 )
			{
				$revisionalpha_simpleclicktocall_form .= ' placeholder="' . $form_settings['simple-click-to-call-numero-text'] . '"';
			}
			
			$revisionalpha_simpleclicktocall_form .= '>';
			
			
			$revisionalpha_simpleclicktocall_form .= '</fieldset>';
			
			$revisionalpha_simpleclicktocall_form .= '<fieldset id="simple-click-to-call-message" style="display:none"></fieldset>';
		
			$revisionalpha_simpleclicktocall_form .= '<p id="simple-click-to-call-submit"><input type="submit" name="simple-click-to-call-submit" value="'. $form_settings['simple-click-to-call-submit-text'] .'"></p>';
		
		$revisionalpha_simpleclicktocall_form .= '</form>';		
		
		}
		else
		{
			$revisionalpha_simpleclicktocall_form .= '<p>' . $options['simple-click-to-call-mensaje-fuera-de-rango'] . '</p>';
		}
		
		$revisionalpha_simpleclicktocall_form .= '</div>';
	}
	
	return $revisionalpha_simpleclicktocall_form;
}