<?php

if ( isset( $_GET['simple-click-to-call-accion'] ) && $_GET['simple-click-to-call-accion'] == 'restaurar' )
{
	?>
	<div class="wrap">
		<h2><?php echo __('Ajustes Simple Click To Call', 'revisionalpha_simpleclicktocall'); ?></h2>
		<form action="<?php echo admin_url('admin.php?page=simple-click-to-call/app/simple-click-to-call-settings.php'); ?>" method="POST">
			<input type="hidden" name="simple-click-to-call-accion" value="restaurar">
			<p>&iquest;Est&aacute; seguro que desea restaurar los valores por defecto?</p>
			<input type="submit" id="simple-click-to-call-restaurar" class="button" value="<?php echo __('Restaurar valores por defecto', 'revisionalpha_simpleclicktocall'); ?>">
		</form>
	</div>
	<?php
}

elseif ( isset( $_POST['simple-click-to-call-accion'] ) && $_POST['simple-click-to-call-accion'] == 'restaurar' )
{
	update_option( 'revisionalpha_simpleclicktocall_options', '' );
	
	$location = admin_url('admin.php?page=simple-click-to-call/app/simple-click-to-call-settings.php');
	wp_redirect( $location . '&updated=ok' );
	exit;
}

elseif ( isset( $_POST['simple-click-to-call-accion'] ) && $_POST['simple-click-to-call-accion'] == 'registrar' )
{	
	/* SANITIZE */
	$key = ( isset( $_POST['simple-click-to-call-key'] ) ) ? trim( $_POST['simple-click-to-call-key'] ) : '';
	$agente = sanitize_text_field( intval( $_POST['simple-click-to-call-agente'] ) );
	$estado = sanitize_text_field( intval( $_POST['simple-click-to-call-estado'] ) );
	$mostrar = sanitize_text_field( $_POST['simple-click-to-call-mostrar'] );
	switch ( $mostrar )
	{
		case 'todos-los-dias':
		{
			$dias = array( 1, 2, 3, 4, 5, 6, 0 );
			break;
		}
		case 'lunes-a-viernes':
		{
			$dias = array( 1, 2, 3, 4, 5 );
			break;
		}
		case 'personalizado':
		{
			$dias = ( isset( $_POST['simple-click-to-call-dias'] ) ) ? $_POST['simple-click-to-call-dias'] : array();
			break;
		}
		default: 
		{
			$mostrar = 'lunes-a-viernes';
			$dias = array( 1, 2, 3, 4, 5 );
			break;
		}
	}
	$hora_inicio = date( 'H:i', strtotime( $_POST['simple-click-to-call-hora-inicio'] ) );
	$hora_final = date( 'H:i', strtotime( $_POST['simple-click-to-call-hora-final'] ) );
	$mensaje_fuera_de_rango = wp_kses_data( $_POST['simple-click-to-call-mensaje-fuera-de-rango'] );
	
	
	/* VALIDACION */
	if ( empty( $agente ) && !isset( $data['error'] ) )
	{
		$data['error'] = __('El n&uacute;mero del agente introducido no es v&aacute;lido o est&aacute; vac&iacute;o. Por favor introduzca un n&uacute;mero de tel&eacute;fono v&aacute;lido.', 'revisionalpha_simpleclicktocall');
	}
	
	if ( !isset( $data['error'] ) )
	{
		foreach ( $dias as $value )
		{
			if ( !is_numeric($value) || $value < 0 || $value > 6 )
			{
				$data['error'] = __('Uno o m&aacute;s de los d&iacute;as seleccionados no son v&aacute;lidos. Por favor seleccione un valor v&aacute;lido.', 'revisionalpha_simpleclicktocall');
				break;
			}
		}
	}
	
	if ( $hora_final <= $hora_inicio && !isset( $data['error'] ) )
	{
		$data['error'] = __('La hora final debe ser mayor a la hora de inicio.', 'revisionalpha_simpleclicktocall');
	}
	
	if ( isset( $data['error'] ) )
	{	 
		echo '<div class="wrap">';
			echo '<div id="simple-click-to-call-messages" class="error">';
				echo '<p><strong>ERROR</strong>. '. $data['error'] .' <a href="javascript:history.go(-1)">'. __('Volver', 'revisionalpha_simpleclicktocall') .'</a></p>';
			echo '</div>';
		echo '</div>';
	}
	
	
	/* REGISTRO */
	else
	{
		( !empty( $key ) ) ? update_option( 'revisionalpha_simpleclicktocall_key', $key ) : null;
		
		update_option( 'revisionalpha_simpleclicktocall_agente', $agente );
		update_option( 'revisionalpha_simpleclicktocall_estado', $estado );
		
		$options = array();
		
		$options['simple-click-to-call-mostrar'] = $mostrar;
		$options['simple-click-to-call-dias'] = $dias;
		$options['simple-click-to-call-hora-inicio'] = $hora_inicio;
		$options['simple-click-to-call-hora-final'] = $hora_final;
		$options['simple-click-to-call-mensaje-fuera-de-rango'] = $mensaje_fuera_de_rango;
		
		update_option( 'revisionalpha_simpleclicktocall_options', $options );
		
		$location = admin_url('admin.php?page=simple-click-to-call/app/simple-click-to-call-settings.php');
		wp_redirect( $location . '&updated=ok' );
		exit;
	}
}

else
{

?>

<div class="wrap">
	<h2><?php echo __('Ajustes Simple Click To Call', 'revisionalpha_simpleclicktocall'); ?></h2>
	
	<?php
	
	if ( isset($_GET['updated']) )
	{
		if ( $_GET['updated'] == 'ok' )
		{	 
			echo '<div id="simple-click-to-call-messages" class="updated">';
			echo '<p><strong>'. __('Ajustes guardados.', 'revisionalpha_simpleclicktocall') .'</strong></p>';
			echo '</div>';
		}
		
		else
		{
			echo '<div id="simple-click-to-call-messages" class="error">';
			echo '<p><strong>'. __('Ha ocurrido un error inesperado. Intente de nuevo.', 'revisionalpha_simpleclicktocall') .'</strong></p>';
			echo '</div>';
		}
	}
	
	?>
	
	<form action="" method="POST">
		<input type="hidden" name="simple-click-to-call-accion" value="registrar">
		
		<h3 class="title"><?php echo __('Licencia', 'revisionalpha_simpleclicktocall'); ?></h3>
		<?php if ( get_option('revisionalpha_simpleclicktocall_key') ) : ?>
			<p><?php echo __('La <a href="http://www.revisionalpha.com/simple-click-to-call/" target="_blank">versión PREMIUM</a> de este servicio se encuentra activa.', 'revisionalpha_simpleclicktocall'); ?></p>
		<?php else : ?>
			<p><?php echo __('Ingrese el código de activación para la <a href="http://www.revisionalpha.com/simple-click-to-call/" target="_blank">versión PREMIUM</a>.', 'revisionalpha_simpleclicktocall'); ?></p>
		<?php  endif; ?>
	
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="simple-click-to-call-key"><?php echo __('Key', 'revisionalpha_simpleclicktocall'); ?></label></th>
					<td>
						<input type="text" name="simple-click-to-call-key" id="simple-click-to-call-key" <?php if ( get_option('revisionalpha_simpleclicktocall_key') ) echo 'disabled="disabled"' ?> value="<?php echo get_option('revisionalpha_simpleclicktocall_key'); ?>" class="regular-text">
						<?php if ( get_option('revisionalpha_simpleclicktocall_key') ) : ?>
						<span class="description"><a href="javascript:;" onclick="document.getElementById('simple-click-to-call-key').removeAttribute('disabled')"><?php echo __('Modificar', 'revisionalpha_simpleclicktocall'); ?></a></span>
						<?php endif; ?>
					</td>
				</tr>
			</tbody>
		</table>
		
		<h3 class="title"><?php echo __('Agente', 'revisionalpha_simpleclicktocall'); ?></h3>
		<p><?php echo __('Ingrese el n&uacute;mero de tel&eacute;fono donde desea recibir las llamadas.', 'revisionalpha_simpleclicktocall'); ?></p>
		
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="simple-click-to-call-agente"><?php echo __('N&uacute;mero del agente <span class="description">(requerido)</span>', 'revisionalpha_simpleclicktocall'); ?></label></th>
					<td>
						<input type="text" name="simple-click-to-call-agente" id="simple-click-to-call-agente" value="<?php echo get_option('revisionalpha_simpleclicktocall_agente'); ?>">
						<p class="description"><?php echo __('C&oacute;digo de &aacute;rea sin 0 + Prefijo de celular (en caso de serlo) + N&uacute;mero de tel&eacute;fono', 'revisionalpha_simpleclicktocall'); ?></p>
					</td>
				</tr>
			</tbody>
		</table>
		
		<h3 class="title"><?php echo __('Opciones', 'revisionalpha_simpleclicktocall'); ?></h3>
		<?php
		if ( get_option('revisionalpha_simpleclicktocall_options') )
		{
			$options = get_option('revisionalpha_simpleclicktocall_options');
		}
		else
		{
			$options = get_option('revisionalpha_simpleclicktocall_options_default');
		}
		?>
		
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label><?php echo __('Estado', 'revisionalpha_simpleclicktocall'); ?></label></th>
					<td>
						<fieldset>
							<label>
								<input type="radio" name="simple-click-to-call-estado" value="1" <?php if (get_option('revisionalpha_simpleclicktocall_estado') == 1) echo 'checked="true"'; ?>>
								<span><?php echo __('Activo', 'revisionalpha_simpleclicktocall'); ?></span>
							</label><br>
							<label>
								<input type="radio" name="simple-click-to-call-estado" value="0" <?php if (get_option('revisionalpha_simpleclicktocall_estado') == 0) echo 'checked="true"'; ?>>
								<span><?php echo __('Inactivo', 'revisionalpha_simpleclicktocall'); ?></span>
							</label>
						</fieldset>
					</td>
				</tr>
				
				<tr>
					<th scope="row"><label><?php echo __('Mostrar s&oacute;lo los d&iacute;as...', 'revisionalpha_simpleclicktocall'); ?></label></th>					
					<td>
						<fieldset>
							<label>
								<input type="radio" name="simple-click-to-call-mostrar" value="todos-los-dias" onclick="personalizado(this)" <?php if ( $options['simple-click-to-call-mostrar'] == 'todos-los-dias' ) echo 'checked="true"'; ?>>
								<span><?php echo __('Todos los d&iacute;as', 'revisionalpha_simpleclicktocall'); ?></span>
							</label><br>
							<label>
								<input type="radio" name="simple-click-to-call-mostrar" value="lunes-a-viernes" onclick="personalizado(this)" <?php if ( $options['simple-click-to-call-mostrar'] == 'lunes-a-viernes' ) echo 'checked="true"'; ?>>
								<span><?php echo __('De Lunes a Viernes', 'revisionalpha_simpleclicktocall'); ?></span>
							</label><br>
							<label>
								<input type="radio" name="simple-click-to-call-mostrar"  value="personalizado" onclick="personalizado(this)" <?php if ( $options['simple-click-to-call-mostrar'] == 'personalizado' ) echo 'checked="true"'; ?>>
								<span><?php echo __('Personalizado:', 'revisionalpha_simpleclicktocall'); ?></span>
								<div id="simple-click-to-call-dias" style="display:inline-block; margin-left:10px; <?php if ( $options['simple-click-to-call-mostrar'] != 'personalizado' ) echo 'color:#aaa'; ?>">
									<input type="checkbox" name="simple-click-to-call-dias[]" value="1" <?php if ( $options['simple-click-to-call-mostrar'] != 'personalizado' ) echo 'disabled="true"'; elseif ( in_array( 1, $options['simple-click-to-call-dias'] ) ) echo 'checked="true"'; ?>>
									<span class="description"><?php echo __('Lunes', 'revisionalpha_simpleclicktocall'); ?></span>
									&nbsp;&nbsp;
								
									<input type="checkbox" name="simple-click-to-call-dias[]" value="2" <?php if ( $options['simple-click-to-call-mostrar'] != 'personalizado' ) echo 'disabled="true"'; elseif ( in_array( 2, $options['simple-click-to-call-dias'] ) ) echo 'checked="true"'; ?>>
									<span class="description"><?php echo __('Martes', 'revisionalpha_simpleclicktocall'); ?></span>
									&nbsp;&nbsp;
								
									<input type="checkbox" name="simple-click-to-call-dias[]" value="3" <?php if ( $options['simple-click-to-call-mostrar'] != 'personalizado' ) echo 'disabled="true"'; elseif ( in_array( 3, $options['simple-click-to-call-dias'] ) ) echo 'checked="true"'; ?>>
									<span class="description"><?php echo __('Mi&eacute;rcoles', 'revisionalpha_simpleclicktocall'); ?></span>
									&nbsp;&nbsp;
								
									<input type="checkbox" name="simple-click-to-call-dias[]" value="4" <?php if ( $options['simple-click-to-call-mostrar'] != 'personalizado' ) echo 'disabled="true"'; elseif ( in_array( 4, $options['simple-click-to-call-dias'] ) ) echo 'checked="true"'; ?>>
									<span class="description"><?php echo __('Jueves', 'revisionalpha_simpleclicktocall'); ?></span>
									&nbsp;&nbsp;
								
									<input type="checkbox" name="simple-click-to-call-dias[]" value="5" <?php if ( $options['simple-click-to-call-mostrar'] != 'personalizado' ) echo 'disabled="true"'; elseif ( in_array( 5, $options['simple-click-to-call-dias'] ) ) echo 'checked="true"'; ?>>
									<span class="description"><?php echo __('Viernes', 'revisionalpha_simpleclicktocall'); ?></span>
									&nbsp;&nbsp;
								
									<input type="checkbox" name="simple-click-to-call-dias[]" value="6" <?php if ( $options['simple-click-to-call-mostrar'] != 'personalizado' ) echo 'disabled="true"'; elseif ( in_array( 6, $options['simple-click-to-call-dias'] ) ) echo 'checked="true"'; ?>>
									<span class="description"><?php echo __('S&aacute;bado', 'revisionalpha_simpleclicktocall'); ?></span>
									&nbsp;&nbsp;
								
									<input type="checkbox" name="simple-click-to-call-dias[]" value="0" <?php if ( $options['simple-click-to-call-mostrar'] != 'personalizado' ) echo 'disabled="true"'; elseif ( in_array( 0, $options['simple-click-to-call-dias'] ) ) echo 'checked="true"'; ?>>
									<span class="description"><?php echo __('Domingo', 'revisionalpha_simpleclicktocall'); ?></span>
								</div>
							</label>							
						</fieldset>
						
						<script type="text/javascript">
							function personalizado( elem ){
								var dias = document.getElementsByName( 'simple-click-to-call-dias[]' );
								
								for ( i = 0; i < dias.length; ++i ){
									if( elem.value == 'personalizado' ){
										dias[i].disabled = false;
										document.getElementById( 'simple-click-to-call-dias' ).style.color = 'black';
									} else{
										dias[i].disabled = true;
										document.getElementById( 'simple-click-to-call-dias' ).style.color = '#aaa';
									}
								}
							}
						</script>
					</td>
				</tr>
				
				<tr>
					<th scope="row"><label><?php echo __('Rango horario', 'revisionalpha_simpleclicktocall'); ?></label></th>
					<td>
						<fieldset>
							<label>
								<span><?php echo __('Hora de inicio', 'revisionalpha_simpleclicktocall'); ?></span>
								<select name="simple-click-to-call-hora-inicio">
									<?php
									
									for( $i = 0; $i < 24; ++$i )
									{
										if( $i == $options['simple-click-to-call-hora-inicio'] ) $selected = 'selected="true"'; else $selected = null;
										
										echo '<option value="'. str_pad($i, 2, '0', STR_PAD_LEFT) .':00" '. $selected .'>'. str_pad($i, 2, '0', STR_PAD_LEFT) .':00</option>';
									}
									
									?>
								</select>
							</label><br>
							<label>
								<span><?php echo __('Hora final', 'revisionalpha_simpleclicktocall'); ?></span>
								<select name="simple-click-to-call-hora-final">
									<?php
									
									for( $i = 0; $i < 24; ++$i )
									{
										if( $i == $options['simple-click-to-call-hora-final'] ) $selected = 'selected="true"'; else $selected = null;
										
										if ( $i < 23 )
										{
											echo '<option value="'. str_pad($i, 2, '0', STR_PAD_LEFT) .':59" '. $selected .'>'. str_pad($i+1, 2, '0', STR_PAD_LEFT) .':00</option>';
										}
										else
										{
											echo '<option value="'. str_pad($i, 2, '0', STR_PAD_LEFT) .':59" '. $selected .'>'. str_pad(00, 2, '0', STR_PAD_LEFT) .':00</option>';
										}
										
									}
									
									?>
								</select>
							</label>
						</fieldset>
					</td>
				</tr>
				
				<tr>
					<th scope="row"><label for="simple-click-to-call-mensaje-fuera-de-rango"><?php echo __('Mensaje para mostrar fuera de rango horario', 'revisionalpha_simpleclicktocall'); ?></label></th>
					<td>
						<textarea name="simple-click-to-call-mensaje-fuera-de-rango" id="simple-click-to-call-mensaje-fuera-de-rango" rows="5" style="width:25em"><?php echo $options['simple-click-to-call-mensaje-fuera-de-rango']; ?></textarea>
					</td>
				</tr>
			</tbody>
		</table>
			
		
		<p class="submit">
			<input type="submit" id="simple-click-to-call-submit" class="button button-primary" value="<?php echo __('Guardar cambios', 'revisionalpha_simpleclicktocall'); ?>">
			<a href="<?php echo admin_url('admin.php?page=revisionalpha-simple-click-to-call/app/simple-click-to-call-settings.php&simple-click-to-call-accion=restaurar'); ?>" class="button" style="margin-left:5px;"><?php echo __('Restaurar valores por defecto', 'revisionalpha_simpleclicktocall'); ?></a>
		</p>
	</form>

</div>

<?php

}