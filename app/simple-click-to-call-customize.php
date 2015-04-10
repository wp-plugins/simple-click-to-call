<?php

if ( isset( $_GET['simple-click-to-call-accion'] ) && $_GET['simple-click-to-call-accion'] == 'restaurar' )
{
	?>
	<div class="wrap">
		<h2><?php echo __('Personalizar Simple Click To Call', 'revisionalpha_simpleclicktocall'); ?></h2>
		<form action="<?php echo admin_url('admin.php?page=simple-click-to-call/app/simple-click-to-call-customize.php'); ?>" method="POST">
			<input type="hidden" name="simple-click-to-call-accion" value="restaurar">
			<p>&iquest;Est&aacute; seguro que desea restaurar los valores por defecto?</p>
			<input type="submit" id="simple-click-to-call-restaurar" class="button" value="<?php echo __('Restaurar valores por defecto', 'revisionalpha_simpleclicktocall'); ?>">
		</form>
	</div>
	<?php
}

elseif ( isset( $_POST['simple-click-to-call-accion'] ) && $_POST['simple-click-to-call-accion'] == 'restaurar' )
{
	update_option( 'revisionalpha_simpleclicktocall_form_settings', '' );
	
	$location = admin_url('admin.php?page=simple-click-to-call/app/simple-click-to-call-customize.php');
	wp_redirect( $location . '&updated=ok' );
	exit;
}

elseif ( isset( $_POST['simple-click-to-call-accion'] ) && $_POST['simple-click-to-call-accion'] == 'registrar' )
{
	/* SANITIZE */
	$descripcion = wp_kses_data( $_POST['simple-click-to-call-description'] );
	
	$codigo_pais_mostrar = ( isset( $_POST['simple-click-to-call-codigo-pais-mostrar'] ) ) ? 1 : 0;
	$codigo_pais_text = sanitize_text_field( $_POST['simple-click-to-call-codigo-pais-text'] );
	$codigo_pais_placeholder = ( isset( $_POST['simple-click-to-call-codigo-pais-placeholder'] ) ) ? 1 : 0;
	$codigo_pais_default = sanitize_text_field( $_POST['simple-click-to-call-codigo-pais-default'] );
	
	$codigo_area_text = sanitize_text_field( $_POST['simple-click-to-call-codigo-area-text'] );
	$codigo_area_placeholder = ( isset( $_POST['simple-click-to-call-codigo-area-placeholder'] ) ) ? 1 : 0;
	$codigo_area_default = sanitize_text_field( $_POST['simple-click-to-call-codigo-area-default'] );
	
	$numero_text = sanitize_text_field( $_POST['simple-click-to-call-numero-text'] );
	$numero_placeholder = ( isset( $_POST['simple-click-to-call-numero-placeholder'] ) ) ? 1 : 0;
	
	$submit_text = sanitize_text_field( $_POST['simple-click-to-call-submit-text'] );
	
	$message_error = sanitize_text_field( $_POST['simple-click-to-call-message-error'] );
	$message_wait = sanitize_text_field( $_POST['simple-click-to-call-message-wait'] );
	$message_comunicacion_error = sanitize_text_field( $_POST['simple-click-to-call-message-comunicacion-error'] );
	$message_comunicacion_ok = sanitize_text_field( $_POST['simple-click-to-call-message-comunicacion-ok'] );
	
	
	/* VALIDACION */
	if ( !empty( $codigo_pais_default ) && !isset( $data['error'] ) )
	{
		if ( !is_numeric( $codigo_pais_default ) )
		{
			$data['error'] = __('El c&oacute;digo de pa&iacute;s debe ser un valor num&eacute;rico.', 'revisionalpha_simpleclicktocall');
		}
	}
	
	if ( !empty( $codigo_area_default ) && !isset( $data['error'] ) )
	{
		if ( !is_numeric( $codigo_area_default ) )
		{
			$data['error'] = __('El c&oacute;digo de &aacute;rea debe ser un valor num&eacute;rico.', 'revisionalpha_simpleclicktocall');
		}
	}
	
	if ( empty( $submit_text ) && !isset( $data['error'] ) )
	{
		$data['error'] = __('El texto a mostrar para el bot&oacute;n Click To Call no puede estar vac&iacute;o.', 'revisionalpha_simpleclicktocall');
	}
	
	if ( empty( $message_error ) && !isset( $data['error'] ) )
	{
		$data['error'] = __('El mensaje de error de validaci&oacute;n no puede estar vac&iacute;o.', 'revisionalpha_simpleclicktocall');
	}
	
	if ( empty( $message_wait ) && !isset( $data['error'] ) )
	{
		$data['error'] = __('El mensaje de espera no puede estar vac&iacute;o.', 'revisionalpha_simpleclicktocall');
	}
	
	if ( empty( $message_comunicacion_error ) && !isset( $data['error'] ) )
	{
		$data['error'] = __('El mensaje de comunicaci&oacute;n fallida no puede estar vac&iacute;o.', 'revisionalpha_simpleclicktocall');
	}
	
	if ( empty( $message_comunicacion_ok ) && !isset( $data['error'] ) )
	{
		$data['error'] = __('El mensaje de comunicaci&oacute;n establecida no puede estar vac&iacute;o.', 'revisionalpha_simpleclicktocall');
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
		$options = array();
		
		$options['simple-click-to-call-description'] = $descripcion;
		
		$options['simple-click-to-call-codigo-pais-mostrar'] = $codigo_pais_mostrar;
		$options['simple-click-to-call-codigo-pais-text'] = $codigo_pais_text;
		$options['simple-click-to-call-codigo-pais-placeholder'] = $codigo_pais_placeholder;
		$options['simple-click-to-call-codigo-pais-default'] = $codigo_pais_default;		
		
		$options['simple-click-to-call-codigo-area-text'] = $codigo_area_text;
		$options['simple-click-to-call-codigo-area-placeholder'] = $codigo_area_placeholder;
		$options['simple-click-to-call-codigo-area-default'] = $codigo_area_default;
		
		$options['simple-click-to-call-numero-text'] = $numero_text;
		$options['simple-click-to-call-numero-placeholder'] = $numero_placeholder;
		
		$options['simple-click-to-call-submit-text'] = $submit_text;
		
		$options['simple-click-to-call-message-error'] = $message_error;
		$options['simple-click-to-call-message-wait'] = $message_wait;
		$options['simple-click-to-call-message-comunicacion-error'] = $message_comunicacion_error;
		$options['simple-click-to-call-message-comunicacion-ok'] = $message_comunicacion_ok;
		
		update_option( 'revisionalpha_simpleclicktocall_form_settings', $options );
		
		$location = admin_url( 'admin.php?page=simple-click-to-call/app/simple-click-to-call-customize.php' );
		wp_redirect( $location . '&updated=ok' );
		exit;
	}
}

else
{

?>

<div class="wrap">
	<h2><?php echo __('Personalizar Simple Click To Call', 'revisionalpha_simpleclicktocall'); ?></h2>
	
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
		
		<h3 class="title"><?php echo __('Formulario', 'revisionalpha_simpleclicktocall'); ?></h3>
		<?php
		if ( get_option('revisionalpha_simpleclicktocall_form_settings') )
		{
			$form_settings = get_option('revisionalpha_simpleclicktocall_form_settings');
		}
		else
		{
			$form_settings = get_option('revisionalpha_simpleclicktocall_form_settings_default');
		}
		?>
		
		<p><?php echo __('Para colocar el formulario Click To Call en cualquier lugar de su sitio simplemente a&ntilde;ada el siguiente shortcode:', 'revisionalpha_simpleclicktocall'); ?> <code>[simple-click-to-call-form]</code></p>
		
		
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="simple-click-to-call-description"><?php echo __('Descripci&oacute;n', 'revisionalpha_simpleclicktocall'); ?></label></th>
					<td>
						<textarea name="simple-click-to-call-description" id="simple-click-to-call-description" rows="5" style="width:25em"><?php echo $form_settings['simple-click-to-call-description']; ?></textarea>
					</td>
				</tr>
				
				<tr>
					<th scope="row"><label><?php echo __('C&oacute;digo de pa&iacute;s', 'revisionalpha_simpleclicktocall'); ?></label></th>
					<td>
						<fieldset>
							<label><input type="checkbox" name="simple-click-to-call-codigo-pais-mostrar" value="1" <?php if ( $form_settings['simple-click-to-call-codigo-pais-mostrar'] == 1 ) echo 'checked="checked"'; ?>> <span><?php echo __('Mostrar este campo', 'revisionalpha_simpleclicktocall'); ?></span></label><br>
							<label>
								<input type="text" name="simple-click-to-call-codigo-pais-text" value="<?php echo $form_settings['simple-click-to-call-codigo-pais-text']; ?>" class="regular-text">
								<span class="description"><?php echo __('Texto a mostrar para el c&oacute;digo de pa&iacute;s.', 'revisionalpha_simpleclicktocall'); ?></span>								
							</label><br>
							<label><input type="checkbox" name="simple-click-to-call-codigo-pais-placeholder" value="1" <?php if ( $form_settings['simple-click-to-call-codigo-pais-placeholder'] == 1 ) echo 'checked="checked"'; ?>> <span class="description"><?php echo __('Placeholder', 'revisionalpha_simpleclicktocall'); ?></span></label><br>
							<label><input type="text" name="simple-click-to-call-codigo-pais-default" minlength="2" maxlength="4" value="<?php echo $form_settings['simple-click-to-call-codigo-pais-default']; ?>" size="4"> <span class="description"><?php echo __('C&oacute;digo de pa&iacute;s por defecto', 'revisionalpha_simpleclicktocall'); ?></span></label>
						</fieldset>
					</td>
				</tr>
				
				<tr>
					<th scope="row"><label><?php echo __('C&oacute;digo de &aacute;rea', 'revisionalpha_simpleclicktocall'); ?></label></th>
					<td>
						<fieldset>
							<label>
								<input type="text" name="simple-click-to-call-codigo-area-text" value="<?php echo $form_settings['simple-click-to-call-codigo-area-text']; ?>" class="regular-text">
								<span class="description"><?php echo __('Texto a mostrar para el c&oacute;digo de &aacute;rea.', 'revisionalpha_simpleclicktocall'); ?></span>								
							</label><br>
							<label><input type="checkbox" name="simple-click-to-call-codigo-area-placeholder" value="1" <?php if ( $form_settings['simple-click-to-call-codigo-area-placeholder'] == 1 ) echo 'checked="checked"'; ?>> <span class="description"><?php echo __('Placeholder', 'revisionalpha_simpleclicktocall'); ?></span></label><br>
							<label><input type="text" name="simple-click-to-call-codigo-area-default" minlength="2" maxlength="4" value="<?php echo $form_settings['simple-click-to-call-codigo-area-default']; ?>" size="4"> <span class="description"><?php echo __('C&oacute;digo de &aacute;rea por defecto', 'revisionalpha_simpleclicktocall'); ?></span></label>
						</fieldset>
					</td>
				</tr>
		
				<tr>
					<th scope="row"><label for="simple-click-to-call-numero-text"><?php echo __('N&uacute;mero de tel&eacute;fono', 'revisionalpha_simpleclicktocall'); ?></label></th>
					<td>
						<fieldset>
							<label>
								<input type="text" name="simple-click-to-call-numero-text" id="simple-click-to-call-numero-text" value="<?php echo $form_settings['simple-click-to-call-numero-text']; ?>" class="regular-text">
								<span class="description"><?php echo __('Texto a mostrar para el n&uacute;mero de tel&eacute;fono.', 'revisionalpha_simpleclicktocall'); ?></span>
							</label><br>
							<label><input type="checkbox" name="simple-click-to-call-numero-placeholder" value="1" <?php if ( $form_settings['simple-click-to-call-numero-placeholder'] == 1 ) echo 'checked="checked"'; ?>> <span class="description"><?php echo __('Placeholder', 'revisionalpha_simpleclicktocall'); ?></span></label>
						</fieldset>
					</td>
				</tr>
				
				<tr>
					<th scope="row"><label for="simple-click-to-call-submit-text"><?php echo __('Bot&oacute;n Click To Call <span class="description">(requerido)</span>', 'revisionalpha_simpleclicktocall'); ?></label></th>
					<td>
						<label>
							<input type="text" name="simple-click-to-call-submit-text" id="simple-click-to-call-submit-text" value="<?php echo $form_settings['simple-click-to-call-submit-text']; ?>" class="regular-text">
							<span class="description"><?php echo __('Texto a mostrar para el bot&oacute;n Click To Call.', 'revisionalpha_simpleclicktocall'); ?></span>
						</label>
					</td>
				</tr>
			</tbody>
		</table>
		
		<h3 class="title"><?php echo __('Mensajes', 'revisionalpha_simpleclicktocall'); ?></h3>
		
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="simple-click-to-call-message-error"><?php echo __('Mensaje de error de validaci&oacute;n <span class="description">(requerido)</span>', 'revisionalpha_simpleclicktocall'); ?></label></th>
					<td>
						<textarea name="simple-click-to-call-message-error" id="simple-click-to-call-message-error" rows="5" style="width:25em"><?php echo $form_settings['simple-click-to-call-message-error']; ?></textarea>
					</td>
				</tr>
				
				<tr>
					<th scope="row"><label for="simple-click-to-call-message-wait"><?php echo __('Mensaje de espera <span class="description">(requerido)</span>', 'revisionalpha_simpleclicktocall'); ?></label></th>
					<td>
						<textarea name="simple-click-to-call-message-wait" id="simple-click-to-call-message-wait" rows="5" style="width:25em"><?php echo $form_settings['simple-click-to-call-message-wait']; ?></textarea>
					</td>
				</tr>
				
				<tr>
					<th scope="row"><label for="simple-click-to-call-message-comunicacion-error"><?php echo __('Mensaje de comunicaci&oacute;n fallida <span class="description">(requerido)</span>', 'revisionalpha_simpleclicktocall'); ?></label></th>
					<td>
						<textarea name="simple-click-to-call-message-comunicacion-error" id="simple-click-to-call-message-comunicacion-error" rows="5" style="width:25em"><?php echo $form_settings['simple-click-to-call-message-comunicacion-error']; ?></textarea>
					</td>
				</tr>
				
				<tr>
					<th scope="row"><label for="simple-click-to-call-message-comunicacion-ok"><?php echo __('Mensaje de comunicaci&oacute;n establecida <span class="description">(requerido)</span>', 'revisionalpha_simpleclicktocall'); ?></label></th>
					<td>
						<textarea name="simple-click-to-call-message-comunicacion-ok" id="simple-click-to-call-message-comunicacion-ok" rows="5" style="width:25em"><?php echo $form_settings['simple-click-to-call-message-comunicacion-ok']; ?></textarea>
					</td>
				</tr>
			</tbody>
		</table>
		
		
		<p class="submit">
			<input type="submit" name="simple-click-to-call-submit" id="simple-click-to-call-submit" class="button button-primary" value="<?php echo __('Guardar cambios', 'revisionalpha_simpleclicktocall'); ?>">
			<a href="<?php echo admin_url('admin.php?page=revisionalpha-simple-click-to-call/app/simple-click-to-call-customize.php&simple-click-to-call-accion=restaurar'); ?>" class="button" style="margin-left:5px;"><?php echo __('Restaurar valores por defecto', 'revisionalpha_simpleclicktocall'); ?></a>
		</p>
	</form>

</div>

<?php

}