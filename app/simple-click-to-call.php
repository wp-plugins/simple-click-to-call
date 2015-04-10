<div class="wrap">
	<h2><?php echo __('Simple Click To Call', 'revisionalpha_simpleclicktocall'); ?></h2>
	
	<p><?php echo __('Su versión actual no permite establecer comunicaciones mayores a dos minutos. Conozca los beneficios de la <a href="http://www.revisionalpha.com/simple-click-to-call/" target="_blank">versión PREMIUM</a>.', 'revisionalpha_simpleclicktocall'); ?></p>
	
	
	<?php
	if ( get_option( 'revisionalpha_simpleclicktocall_estado' ) != 1 )
	{
		echo '<p>'. __('El formulario de Simple Click To Call se encuentra <strong>inactivo</strong>.', 'revisionalpha_simpleclicktocall') .'</p>';
	}
	
	else
	{
		/* $options = get_option('revisionalpha_simpleclicktocall_options'); */
		if ( get_option('revisionalpha_simpleclicktocall_options') )
		{
			$options = get_option('revisionalpha_simpleclicktocall_options');
		}
		else
		{
			$options = get_option('revisionalpha_simpleclicktocall_options_default');
		}
	
		switch ( $options['simple-click-to-call-mostrar'] )
		{
			case 'todos-los-dias':
			{
				$mostrar_dias = __('de Lunes a Domingo', 'revisionalpha_simpleclicktocall');
				break;
			}
			case 'lunes-a-viernes':
			{
				$mostrar_dias = __('de Lunes a Viernes', 'revisionalpha_simpleclicktocall');
				break;
			}
			case 'personalizado':
			{
				if ( !empty( $options['simple-click-to-call-dias'] ) )
				{	
					$mostrar_dias = __('los ', 'revisionalpha_simpleclicktocall');
					$i = 0;
					
					foreach( $options['simple-click-to-call-dias'] as $value )
					{
						$i++;
						
						switch( $value )
						{
							case 0: { $mostrar_dias .= __('Domingos', 'revisionalpha_simpleclicktocall'); break; }
							case 1: { $mostrar_dias .= __('Lunes', 'revisionalpha_simpleclicktocall'); break; }
							case 2: { $mostrar_dias .= __('Martes', 'revisionalpha_simpleclicktocall'); break; }
							case 3: { $mostrar_dias .= __('Mi&eacute;rcoles', 'revisionalpha_simpleclicktocall'); break; }
							case 4: { $mostrar_dias .= __('Jueves', 'revisionalpha_simpleclicktocall'); break; }
							case 5: { $mostrar_dias .= __('Viernes', 'revisionalpha_simpleclicktocall'); break; }
							case 6: { $mostrar_dias .= __('S&aacute;bados', 'revisionalpha_simpleclicktocall'); break; }
							default: break;
						}
						
						if ( ( count( $options['simple-click-to-call-dias'] ) - 1 ) == $i )
						{
							$mostrar_dias .= __(' y ', 'revisionalpha_simpleclicktocall');
						}
						elseif ( count( $options['simple-click-to-call-dias'] ) != $i )
						{
							$mostrar_dias .= ', ';
						}
					}
				}
				break;
			}
			default: break;
		}
		
		if ( isset( $mostrar_dias ) )
		{
			echo '<p>' . __('El formulario de Simple Click To Call se encuentra <strong>activo</strong> y se muestra ', 'revisionalpha_simpleclicktocall') . $mostrar_dias . __(' desde las ', 'revisionalpha_simpleclicktocall') . $options['simple-click-to-call-hora-inicio'] . __(' hs hasta las ', 'revisionalpha_simpleclicktocall') . date( 'H:i', strtotime( '+1 minute', strtotime( $options['simple-click-to-call-hora-final'] ) ) ) . __(' hs', 'revisionalpha_simpleclicktocall'). '</p>';
		}
		else
		{
			echo '<p>'. __('El formulario de Simple Click To Call se encuentra <strong>activo</strong> pero no se ha configurado ning&uacute;n d&iacute;a para mostrarlo.', 'revisionalpha_simpleclicktocall') .'</p>';
		}
		
		if ( get_option('revisionalpha_simpleclicktocall_agente') )
		{
			echo '<p>'. __('El n&uacute;mero de tel&eacute;fono del agente asignado es: ', 'revisionalpha_simpleclicktocall') .'<strong>'. get_option('revisionalpha_simpleclicktocall_agente') .'</strong></p>';
		}
		else
		{
			echo '<p>'. __('No se ha asignado ning&uacute;n n&uacute;mero de tel&eacute;fono para el agente.', 'revisionalpha_simpleclicktocall') .'</p>';
		}
	}
	
	?>
</div>